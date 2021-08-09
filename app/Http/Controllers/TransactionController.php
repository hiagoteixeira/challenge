<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transaction_service;

    public function __construct(TransactionService $transaction_service)
    {
        $this->transaction_service = $transaction_service;
    }

    public function create(Request $request)
    {
        $dataValid = $request->validate([
            'tipo' => 'required',
            'valor' => 'required',
            'origem_account_id' => 'required',
            'destino_account_id' => 'required'

        ]);

        $result = $this->transaction_service->create($dataValid);
        return response()->json($result);
    }
}