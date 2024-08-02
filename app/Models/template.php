<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class template extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'template';

    protected $fillable = [
        'nama_template',
        'pesan',
    ];

    public static function booted() {
        static::creating (function ($model) {
        $model->id = Str::uuid();
        });
    }
}
