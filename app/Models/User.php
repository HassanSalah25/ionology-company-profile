<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'user_type'];

    protected $hidden = ['password', 'remember_token'];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }
}
