<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Portfolio extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    public $translatable = ['title', 'description'];

    protected $fillable = ['title', 'description', 'image_path'];

    public function seo()
    {
        return $this->morphOne(SEO::class, 'seoable');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}

