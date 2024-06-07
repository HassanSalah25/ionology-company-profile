<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SEO extends Model
{
    protected $fillable = ['seoable_id', 'seoable_type', 'meta_title', 'meta_description', 'meta_keywords', 'alt_image'];

    public function seoable()
    {
        return $this->morphTo();
    }
}

