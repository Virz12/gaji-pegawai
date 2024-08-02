<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class arsip_pesan extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'arsip_pesan';

    protected $fillable = [
        'nip',
        'nama',
        'nomorWa',
        'pesan',
        'attachment',
    ];

    public static function booted() {
        static::creating (function ($model) {
        $model->id = Str::uuid();
        });
    }
}
