<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Service extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    public $translatable = ['name', 'description'];

    protected $fillable = ['name', 'description', 'category_id', 'image', 'images'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

