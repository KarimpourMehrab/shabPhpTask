<?php

namespace App\Repositories\Eloquent;

use App\Models\Fee;
use App\Repositories\UserRepositoryInterface;

class FeeRepository extends BaseRepository
{
    public function __construct(Fee $model)
    {
        parent::__construct($model);
    }


}
