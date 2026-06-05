<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    
    // Nonaktifkan timestamps jika kita tidak membutuhkannya, atau aktifkan (bebas).
    // Karena kita tidak membuat id dan timestamps di migrasi, kita perlu mematikan timestamps dan mengatur primary key.
    public $timestamps = false;
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    public $incrementing = false;
}
