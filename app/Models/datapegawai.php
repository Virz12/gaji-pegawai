<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class datapegawai extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'data_pegawai';

    protected $fillable = [
        'nip',
        'nama',
        'nomorWa',
    ];

    public static function booted() {
        static::creating (function ($model) {
        $model->id = Str::uuid();
        });
    }
}
