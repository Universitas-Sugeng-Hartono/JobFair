<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo_path',
        'description',
        'login_code',
        'password',
        'email',
        'pic_name',
    ];

    protected $hidden = ['password'];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function applications()
    {
        return $this->hasManyThrough(Application::class, Position::class);
    }
}
