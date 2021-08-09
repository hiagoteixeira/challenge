<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tipo',
        'valor',
        'origem_account_id',
        'destino_account_id'

    ];

    public $timestamps = false;
}