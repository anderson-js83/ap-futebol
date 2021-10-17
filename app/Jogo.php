<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\SoftDeletes;

class Jogo extends Model
{

	use SoftDeletes;
    protected $fillable = [
        'descricao', 'dt_jogo', 'status', 'jogadores', 'resultado',
    ];
}
