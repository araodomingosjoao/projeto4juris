<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_nome',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}
