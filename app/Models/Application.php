<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'position_id',
        'status',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function answers()
    {
        return $this->hasMany(ApplicationAnswer::class);
    }
}
