<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
	use SoftDeletes;
	use SearchableTrait;

	protected $primaryKey = 'id';

	protected $searchable = [
        'columns' => [
            'products.name' => 10,
            'products.description' => 5,
            'products.unit_price' => 5,
        ]
    ];

    protected $fillable = [
        'name', 'description', 'photo', 'unit_price'
    ];

    protected $dates = ['deleted_at'];

    public function delivery() {
        return $this->hasMany('App\Delivery');
    }

    public function cart() {
        return $this->hasMany('App\Cart');
    }

    public function sale() {
        return $this->hasMany('App\Sale');
    }
}
