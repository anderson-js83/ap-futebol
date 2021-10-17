<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\SoftDeletes;

class Atleta extends Model
{
	
	use SoftDeletes;
    protected $fillable = [
        'nome', 'email', 'sn_goleiro',
    ];
}
