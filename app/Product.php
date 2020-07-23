<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'description', 'photo', 'unit_price'
    ];

    public function delivery() {
        return $this->hasMany('App\Delivery');
    }
}
