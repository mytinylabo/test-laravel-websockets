<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guaded = ['id'];
    protected $fillable = ['body'];
}
