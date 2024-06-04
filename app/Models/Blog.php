<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'content'];

    protected $fillable = ['title', 'content', 'author_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}

