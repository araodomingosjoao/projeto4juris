<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Validator;

trait CrudTrait
{
    abstract protected function validationRules();

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);

        $data = $this->model->paginate($perPage);
        return response()->json([
            'data' => $this->resource::collection($data->items()),
            'meta' => [
                'current_page' => $data->currentPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'next_page_url' => $data->nextPageUrl(),
                'prev_page_url' => $data->previousPageUrl(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors(), 422);
        }

        try {
            $data = $this->model->create($request->all());
            return ApiResponse::success(new $this->resource($data), 'Registro criado com sucesso!', 201);
        } catch (\Exception $e) {
            return ApiResponse::error('Erro ao criar: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        $data = $this->model->findOrFail($id);
        return ApiResponse::success(new $this->resource($data));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors(), 422);
        }

        try {
            $data = $this->model->findOrFail($id);
            $data->update($request->all());
            return ApiResponse::success(new $this->resource($data), 'Registro atualizado com sucesso!');
        } catch (\Exception $e) {
            return ApiResponse::error('Erro ao atualizar: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->model->findOrFail($id);
            $data->delete();
            return ApiResponse::success(null, 'Registro deletado com sucesso!', 204);
        } catch (\Exception $e) {
            return ApiResponse::error('Erro ao deletar: ' . $e->getMessage(), 500);
        }
    }
}
