<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByMobile(string $mobile): Model|null
    {
        return $this->model->query()->where('mobile', $mobile)->first();
    }

    public function checkPassword(string|null $userPassword, string $password): bool
    {
        return Hash::check($password, $userPassword ?? '');
    }

}
