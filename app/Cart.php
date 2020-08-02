<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id', 'user_id', 'quantity', 'amount'
    ];

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function user() {
        return $this->hasMany('App\Users');
    }

    public function sale() {
        return $this->hasMany('App\Sale');
    }


}
