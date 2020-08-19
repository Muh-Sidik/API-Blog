<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterEmail extends Model
{

    protected $table = "register_email";

    protected $guarded = ['id'];

    // public $timestamps = false;
}
