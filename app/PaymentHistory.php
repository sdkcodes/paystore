<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
	protected $table = 'payment_history';
    protected $guarded = [];

    public function supplier(){
    	return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
