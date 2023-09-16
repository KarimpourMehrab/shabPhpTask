<?php

namespace App\Models;

use App\Models\traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static searchService(string|null $serviceName=null)
 */
class Product extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'price'
    ];
}
