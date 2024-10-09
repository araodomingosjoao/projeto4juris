<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmpresaResource;
use App\Models\Empresa;
use App\Traits\CrudTrait;

class EmpresaController extends Controller
{
    use CrudTrait;

    protected $model;
    protected $resource = EmpresaResource::class;

    public function __construct(Empresa $empresa)
    {
        $this->model = $empresa;
    }

    protected function validationRules()
    {
        return [
            'empresa_nome' => 'required|string|max:255',
        ];
    }
}
