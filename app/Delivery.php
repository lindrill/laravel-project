<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
	protected $primaryKey = 'id';
	
    protected $fillable = [
        'receipt_no', 'quantity', 'product_id'
    ];

    public function product() {
        return $this->belongsTo('App\Product');
    }
}
