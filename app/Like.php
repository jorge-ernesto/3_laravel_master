<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table      = "likes";
    protected $primaryKey = "id";
    public $timestamps    = true;

    protected $fillable = [
        "user_id",
        "image_id"        
    ];
}
