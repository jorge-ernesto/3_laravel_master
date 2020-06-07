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

    /* RELACION DE MUCHOS A UNO */
    //Un like solo pertenece a un usuario
    public function user(){
        return $this->belongsTo("App\User", "user_id");
    }
    
    //Un like solo pertenece a una imagen
    public function image(){
        return $this->belongsTo("App\Image", "image_id");
    }
}
