<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cliente_nome',
    ];

    protected static function booted()
    {
        static::addGlobalScope('empresa', function (Builder $builder) {
            if (request()->is('api/*') && Auth::check()) {
                $builder->whereHas('usuario', function ($query) {
                    $query->where('empresa_id', Auth::user()->empresa_id);
                });
            }
        });
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
