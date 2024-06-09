<?php

namespace App\Models;

use App\Enum\CategoryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    public $translatable = ['name', 'description'];

    protected $fillable = ['name', 'description', 'type','image'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function getType($value)
    {
        return CategoryType::from($value);
    }

    public function setType($value)
    {
        if (!CategoryType::tryFrom($value)) {
            throw new \InvalidArgumentException("Invalid state value: $value");
        }
        $this->attributes['type'] = $value;
    }

    public function seo()
    {
        return $this->morphOne(SEO::class, 'seoable');
    }
}
