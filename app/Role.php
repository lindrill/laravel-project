<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Role extends Model
{
	use SoftDeletes;

    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $softCascade = ['user'];

    protected $fillable = [
        'name', 'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
