<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function create(Request $request)
    {
        $dataValid = $request->validate([
            'nome' => 'required',
            'cpf' => ['required', 'max:14'],
            'telefone' => 'required',
            'email' => ['required', 'unique:user'],
            'senha' => ['required', 'string', 'min:6']
        ]);
        $result = $this->user_service->create($dataValid);
        return response()->json($result);
    }

    public function list(Request $request)
    {

        $result = $this->user_service->list($request->query('q'));
        return response()->json($result);
    }
}