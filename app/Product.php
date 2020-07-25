<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'description', 'photo', 'unit_price'
    ];

    protected $dates = ['deleted_at'];

    public function delivery() {
        return $this->hasMany('App\Delivery');
    }
}
