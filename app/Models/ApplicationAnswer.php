<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'field_label',
        'field_type',
        'field_value',
        'file_path',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
