<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'status',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
