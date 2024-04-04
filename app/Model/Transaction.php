<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'total_money', 'total_rice'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function TransactionDetail()
    {
        return $this->hasMany('App\Model\TransactionDetail');
    }
}
