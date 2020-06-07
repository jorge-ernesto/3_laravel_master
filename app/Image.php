<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table      = "images";
    protected $primaryKey = "id";
    public $timestamps    = true;

    protected $fillable = [
        "user_id",
        "image_path",
        "description"
    ];

    /* RELACION DE MUCHOS A UNO */
    //Un imagen solo pertenece a un usuario
    public function user(){
        return $this->belongsTo("App\User", "user_id");
    }

    /* RELACION DE UNO A MUCHOS */
    //Una imagen puede tener muchos comentarios
    public function comments(){
        return $this->hasMany("App\Comment");
    }

    //Una imagen puede tener muchos likes
    public function likes(){
        return $this->hasMany("App\Like");
    }    
}
