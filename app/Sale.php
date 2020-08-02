<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id', 'user_id', 'quantity', 'amount'
    ];

    public function cart() {
        return $this->belongsTo('App\Cart');
    }

    public function product() {
        return $this->hasMany('App\Product');
    }

    public function user() {
        return $this->hasMany('App\User');
    }
}
