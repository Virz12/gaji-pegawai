<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class config_api extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'config_api';

    protected $fillable = [
        'id_nomor',
        'id_bisnis',
        'token_api',
    ];

    public static function booted() {
        static::creating (function ($model) {
        $model->id = Str::uuid();
        });
    }
}
