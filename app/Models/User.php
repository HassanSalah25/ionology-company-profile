<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use InteractsWithMedia, HasRoles;

    protected $fillable = ['name', 'email', 'password', 'user_type','role_id'];

    protected $hidden = ['password', 'remember_token'];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }
}
