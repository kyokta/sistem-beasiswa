<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'syarat_beasiswas';

    protected $fillable = ['beasiswa_id', 'syarat'];
}
