<?php

namespace App\Repositories\Eloquent;

use App\Enums\TransactionStatesEnum;
use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\UserRepositoryInterface;
use App\Services\Notification\NotificationService;
use App\Services\Notification\Pattern;
use App\Services\Notification\Sms\Sms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountRepository extends BaseRepository
{
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $params
     * @param TransactionRepository $transactionRepository
     * @param FeeRepository $feeRepository
     * @return array
     */
    public function decreaseBalance(array $params, TransactionRepository $transactionRepository, FeeRepository $feeRepository): array
    {
        /**
         * @var Transaction $transaction
         */
        $transaction = $this->createTransaction($transactionRepository, $params);
        try {
            /**
             * @var Account $fromAccount
             * @var Account $toAccount
             */
            $fromAccount = $params['fromAccount'];
            $toAccount = $params['toAccount'];
            $amount = $params['amount'];

            $transaction = DB::transaction(function () use ($fromAccount, $toAccount, $amount, $transactionRepository, $feeRepository, $transaction) {

                $this->decreaseAccountBalance($fromAccount, $amount);
                $this->increaseAccountBalance($toAccount, $amount);
                $this->calculateAndCreateFee($feeRepository, $transaction->id);
                $transaction->succeed();
                return $transaction;
            });

            $this->notify($toAccount, Pattern::UserAccountIncreaseBalance, $amount);
            $this->notify($fromAccount, Pattern::UserAccountDecreaseBalance, $amount);
            return [true, $transaction];

        } catch (\Exception $e) {
            Log::error($e);
            $transaction->failed();
            return [false, $transaction];
        }
    }

    /**
     * @param Account $account
     * @param string $pattern
     * @param int $amount
     * @return void
     * send async sms and push to queue system in notification service
     */
    private function notify(Account $account, string $pattern, int $amount): void
    {
        $notificationService = NotificationService::make(Sms::name());
        $notificationService->setMobile($account->user->mobile);
        $notificationService->setPattern($pattern);
        $notificationService->setParams([
            'user' => $account->user->first_name,
            'amount' => $amount,
            'account' => $account->number,
        ]);
        $notificationService->notify();
    }

    /**
     * @param Account $account
     * @param int $amount
     * @return void
     * decrease the destination account balance
     */
    private function decreaseAccountBalance(Account $account, int $amount): void
    {
        $account->hasBalanceDecrease($amount + config('transaction.fee'));
    }

    /**
     * @param Account $account
     * @param int $amount
     * @return void
     */
    private function increaseAccountBalance(Account $account, int $amount): void
    {
        $account->hasBalanceDecrease($amount);
    }

    /**
     * @param TransactionRepository $transactionRepository
     * @param array $params
     * @return Model
     */
    private function createTransaction(TransactionRepository $transactionRepository, array $params): Model
    {
        $newTransaction = $transactionRepository->create([
            'amount' => $params['amount'],
            'from_card_id' => $params['from_card_id'],
            'to_card_id' => $params['to_card_id'],
            'state' => TransactionStatesEnum::INITIALIZE->value
        ]);
        $newTransaction->load(['fromCard', 'toCard']);
        return $newTransaction;
    }

    /**
     * @param FeeRepository $feeRepository
     * @param int $transId
     * @return void
     */
    private function calculateAndCreateFee(FeeRepository $feeRepository, int $transId): void
    {
        $feeByAnyTransaction = config('transaction.fee');
        $feeRepository->create([
            'amount' => $feeByAnyTransaction,
            'transaction_id' => $transId
        ]);
    }


}
