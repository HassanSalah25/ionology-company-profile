<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Blog extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    public $translatable = ['title', 'content'];

    protected $fillable = ['title', 'content', 'image'];

}

