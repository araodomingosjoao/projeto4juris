<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cliente_id' => $this->id,
            'usuario_id' =>  $this->usuario->id ?? null,
            'empresa_id' => $this->usuario->empresa_id ?? null,
            'usuario_nome' => $this->usuario->name ?? null,
            'cliente_nome' => $this->cliente_nome ?? null,
            'email' => $this->usuario->email ?? null,
            'empresa_nome' => $this->usuario->empresa->empresa_nome ?? null,
            'profile_photo_url' => $this->usuario->profile_photo_url ?? null,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
