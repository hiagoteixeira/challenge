<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $account_service;

    public function __construct(AccountService $account_service)
    {
        $this->account_service = $account_service;
    }

    public function create(Request $request)
    {
        if ($request['empresarial']) {
            $dataValid = $request->validate([
                'agencia' => 'required',
                'numero' => 'required',
                'digito' => 'required',
                'razaoSocial' => 'required',
                'nomeFantasia' => 'required',
                'cpf_cnpj' => ['required', 'unique:account'],
                'empresarial' => 'required',
                'user_id' => 'required'
            ]);
        } else {
            $dataValid = $request->validate([
                'agencia' => 'required',
                'numero' => 'required',
                'digito' => 'required',
                'nome' => 'required',
                'cpf_cnpj' => ['required', 'unique:account'],
                'empresarial' => 'required',
                'user_id' => 'required'
            ]);
        }

        $result = $this->account_service->create($dataValid);
        return response()->json($result);
    }

    public function list($id)
    {
        $result = $this->account_service->list($id);
        return response()->json($result);
    }
}