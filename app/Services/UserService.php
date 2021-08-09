<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function create($params)
    {
        DB::beginTransaction();
        try {

            $email_existent = User::where('email', $params['email'])->first();
            $cpf_existent = User::where('cpf', $params['cpf'])->first();
            if ($cpf_existent)
                throw new Exception("Já existe um registro com CPF informado.");
            if ($email_existent)
                throw new Exception('Já existe um registro com Email informado.');

            $user = User::create($params);

            DB::commit();
            $result = [
                'status' => true,
                'data' => $user
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $result = [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        return $result;
    }

    public function list($params)
    {
        if ($params)
            $user = User::where('nome', 'like', "$params%")->orWhere('cpf', 'like', "$params%")->get();
        else
            $user = User::get();
        return $user;
    }
}