<?php

namespace App\Services;

use App\Models\Account;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AccountService
{

    public function create($params)
    {
        DB::beginTransaction();
        try {
            $user = User::find($params['user_id']);

            if (!$user)
                throw new Exception("Usuário não encontrado!");

            $valid_cpf_cnpj = Account::where('cpf_cnpj', $params['cpf_cnpj'])->first();
            if ($valid_cpf_cnpj) {
                if ($params['empresarial'])
                    throw new Exception("Já Existe uma conta vinculada a este CNPJ!");
                else
                    throw new Exception("Já Existe uma conta vinculada a este CPF!");
            }

            $user_account = $user->account->where('empresarial', $params['empresarial'])->first();
            if ($user_account)
                throw new Exception("Esse usuário já possui uma conta desse tipo!");

            $account = Account::create($params);

            DB::commit();

            $result = [
                'status' => true,
                'data' => $account
            ];
        } catch (Exception $e) {
            DB::rollback();
            $result = [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        return $result;
    }

    public function list($id)
    {
        $account = Account::find($id);
        if (!$account)
            return "Conta não encontrada!";
        $user = $account->user;
        $origem = $account->origem_transaction;
        $destino = $account->destino_transaction;
        $result = [
            'usuario' => $user,
            'transactions' => [
                'origem' => $origem,
                'destino' => $destino
            ]
        ];
        return ['data' => $result];
    }
}