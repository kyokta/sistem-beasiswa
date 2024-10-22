<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    use HasFactory;

    protected $table = 'beasiswas';

    protected $fillable = ['nama', 'sumber_dana', 'kuota'];

    public function syarat()
    {
        return $this->hasMany(SyaratBeasiswa::class);
    }
}
