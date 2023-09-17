<?php

namespace App\Models;

use App\Models\traits\User\Relations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Relations;

    protected $fillable = [
        'name',
        'mobile',
        'password',
    ];

    protected $hidden = [
        'password'
    ];


}
