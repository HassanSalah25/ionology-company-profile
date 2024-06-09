<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'content','slug'];

    protected $fillable = ['title', 'slug', 'content', 'position'];

    public function seo()
    {
        return $this->morphOne(SEO::class, 'seoable');
    }
}

