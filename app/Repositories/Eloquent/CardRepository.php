<?php

namespace App\Repositories\Eloquent;

use App\Models\Card;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CardRepository extends BaseRepository
{
    public function __construct(Card $model)
    {
        parent::__construct($model);
    }


}
