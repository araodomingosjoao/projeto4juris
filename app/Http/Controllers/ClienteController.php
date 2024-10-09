<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use App\Models\User;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    use CrudTrait;

    protected $model;
    protected $resource = ClienteResource::class;

    public function __construct(Cliente $cliente)
    {
        $this->model = $cliente;
    }

    protected function validationRules() {}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|alpha_dash|unique:users,name',
            'empresa_id' => 'required|exists:empresas,id',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'cliente_nome' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors(), 422);
        }

        try {
            DB::beginTransaction();

            $usuario = User::create([
                'name' => $request->name,
                'empresa_id' => $request->empresa_id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $cliente = Cliente::create([
                'user_id' => $usuario->id,
                'cliente_nome' => $request->cliente_nome
            ]);

            DB::commit();

            return ApiResponse::success(new $this->resource($cliente), 'Cliente criado com sucesso!', 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return ApiResponse::error('Erro ao criar: ' . $e->getMessage(), 500);
        }
    }


    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $usuarioId = $cliente->user_id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|alpha_dash|unique:users,name,' . $usuarioId,
            'empresa_id' => 'sometimes|exists:empresas,id',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuarioId,
            'password' => 'nullable|string|confirmed|min:8',
            'cliente_nome' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors(), 422);
        }

        try {
            DB::beginTransaction();

            $usuario = User::findOrFail($usuarioId);
            $usuario->update([
                'name' => $request->name,
                'empresa_id' => $request->empresa_id,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $usuario->password,
            ]);

            $cliente->update([
                'cliente_nome' => $request->cliente_nome,
            ]);

            DB::commit();

            return ApiResponse::success(new $this->resource($cliente), 'Cliente atualizado com sucesso!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return ApiResponse::error('Erro ao atualizar: ' . $e->getMessage(), 500);
        }
    }
}
