<?php

require_once 'modulos/usuarios/clases/Usuario.php';
require_once 'funcionesPHP/funcionesGenerales.php';
require_once 'modulos/cursos/clases/Curso.php';
require_once 'funcionesPHP/LogFile.php';

session_start();

    global $msg;
    $msg ='';
if(!empty($_GET['c']))
      $controlador = $_GET['c'];
else
      $controlador = $controladorPredefinido;
 
if(!empty($_GET['a']))
      $accion = $_GET['a'];
else
      $accion = $accionPredefinida;

if(!empty($_GET['m']))
    $modulo = $_GET['m'];
else
    $modulo = $moduloPredefinido;
	

 
//Ya tenemos el modulo, el controlador y la accion
 
//Formamos el nombre del fichero que contiene nuestro controlador
$controlador = "modulos/" . $modulo . "/controladores/" . $controlador . 'Controlador.php';
 
//Incluimos el controlador o detenemos todo si no existe
if(is_file($controlador))
      require_once $controlador;
else
      die('El controlador no existe - 404 not found');
 
//Llamamos la accion o detenemos todo si no existe
if(is_callable($accion))
      $accion();
else
      die('La accion ' . $accion .' no existe en el controlador ' . $controlador .' - 404 not found');

?>