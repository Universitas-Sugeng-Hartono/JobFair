<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'selection',
        'time_to_answer',
        'job_responsibilities',
        'requirements',
        'location',
        'form_config',
        'additional_info'
    ];

    protected $casts = [
        'form_config' => 'array',
        'additional_info' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
