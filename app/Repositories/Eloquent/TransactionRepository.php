<?php

namespace App\Repositories\Eloquent;

use App\Models\Transaction;
use App\Repositories\UserRepositoryInterface;

class TransactionRepository extends BaseRepository
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }


}
