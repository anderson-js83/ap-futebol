<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\SoftDeletes;

class Time extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'time', 'id_jogo', 'jogadores',
    ];
}
