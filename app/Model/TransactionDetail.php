<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'transaction_id', 'muzakki_id', 'zakat_id', 'nominal'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function Transaction()
    {
        return $this->belongsTo('App\Model\Transaction');
    }

    public function Muzakki()
    {
        return $this->belongsTo('App\Model\Muzakki');
    }

    public function Zakat()
    {
        return $this->belongsTo('App\Model\Zakat');
    }
}
