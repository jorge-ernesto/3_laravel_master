<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table      = "comments";
    protected $primaryKey = "id";
    public $timestamps    = true;

    protected $fillable = [
        "user_id",
        "image_id",
        "content"
    ];

    /* RELACION DE MUCHOS A UNO */
    //Un comentario solo pertenece a un usuario
    public function user(){
        return $this->belongsTo("App\User", "user_id");
    }
    
    //Un comentario solo pertenece a una imagen
    public function image(){
        return $this->belongsTo("App\Image", "image_id");
    }
}
