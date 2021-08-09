<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionService
{

    public function create($params)
    {
        DB::beginTransaction();
        try {

            $tipos = ["Pagamento de Conta", "Depósito", "Transferência", "Recarga de Celular", "Compra (Crédito)"];

            if (!in_Array($params['tipo'], $tipos))
                throw new Exception("Tipo de transação não identificado!");

            if ($params['origem_account_id'] == $params['destino_account_id'])
                throw new Exception("A conta de destino deve ser diferente da de origem!");

            $account = Account::find($params['origem_account_id']);
            if (!$account)
                throw new Exception("Conta de origem não encontrada.");

            $destino_account = Account::find($params['destino_account_id']);
            if (!$destino_account)
                throw new Exception("Conta de destino não encontrada.");

            $transaction = Transaction::create($params);

            Db::commit();
            $result = [
                'status' => true,
                'data' => $transaction
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
}