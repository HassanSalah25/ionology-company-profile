<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SEO extends Model
{
    use HasTranslations;

    protected $table = 'seos';

    protected $fillable = ['seoable_id', 'seoable_type', 'meta_title', 'meta_description', 'meta_keywords', 'alt_image', 'canonical'];

    public $translatable = ['meta_title', 'meta_description', 'meta_keywords', 'alt_image', 'canonical'];

    public function seoable()
    {
        return $this->morphTo();
    }
}

