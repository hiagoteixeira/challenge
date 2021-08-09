<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'account';
    protected $primaryKey = 'id';
    protected $fillable = [
        'agencia',
        'numero',
        'digito',
        'razaoSocial',
        'nomeFantasia',
        'nome',
        'cpf_cnpj',
        'empresarial',
        'user_id'
    ];

    public function origem_transaction()
    {
        return $this->hasMany('App\Models\Transaction', 'origem_account_id', 'id');
    }


    public function destino_transaction()
    {
        return $this->hasMany('App\Models\Transaction', 'destino_account_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public $timestamps = false;
}