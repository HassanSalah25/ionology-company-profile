<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CompanyInfo extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'description', 'address'];

    protected $fillable = ['name', 'description', 'address', 'phone', 'email'];
}
