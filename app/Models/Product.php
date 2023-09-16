<?php

namespace App\Models;

use App\Models\traits\General\Searchable;
use App\Models\traits\Product\Functions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @method static searchService(string|null $serviceName = null)
 */
class Product extends Model implements HasMedia
{
    use HasFactory, Searchable, InteractsWithMedia, Functions;

    protected $fillable = [
        'title',
        'price',
        'user_id'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('m')
            ->quality(70)
            ->width(300)
            ->height(300)
            ->performOnCollections('product_images');
    }

}
