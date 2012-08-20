<?php

class Curso{
    public $idCurso;            //Integer autoincrement
    public $idUsuario;          //Integer
    public $idSubcategoria;     //integer
    public $titulo;             //varchar(100)
    public $uniqueUrl;          //varchar(100)
    public $publicado;          //tinyint
    public $precio;             //integer
    public $descripcionCorta;   //varchar(140)
    public $descripcion;        //text    
    public $fechaPublicacion;   //DATE
    public $fechaCreacion;      //DATE
    public $imagen;             //varchar(200)
    public $rating;             //Integer
    public $keywords;           //varchar(50)
    public $totalViews;         //Integer
    public $totalReportes;         //Integer
    
    
    //Las siguientes no son parte de la bd
    public $nombreUsuario;    
    public $numeroDeClases;
    public $numeroDeAlumnos;
    public $fechaInscripcion;
    public $puntuacion;
    public $uniqueUrlUsuario;
    
    function toString(){
        return " idCurso=" . $this->idCurso . 
               " idUsuario=" . $this->idUsuario .
               " idSubcategoria=" . $this->idSubcategoria .
               " titulo=". $this->titulo .
               " descripcionCorta=". $this->descripcionCorta .
               " keywords=".$this->keywords .
               " usuario =".$this->nombreUsuario;
    }
}

?>