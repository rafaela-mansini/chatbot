<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [ 'method', 'current_balance', 'transaction_balance', 'new_balance', 'user_id' ];

    /**
     * Return user from transaction
     */
    public function transactions()
    {
        return $this->belongsTo('App\User');
    }

}
