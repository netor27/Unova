<?php

// register Pheanstalk class loader
require_once('lib/php/beanstalkd/ColaMensajes.php');
$colaMensajes = new ColaMensajes("transformarvideos");


$accion;
if (!isset($_GET['a'])) {
    $accion = "status";
} else {
    $accion = $_GET['a'];
}

if ($accion == "publicar") {
    $colaMensajes->push("Estos son los datos del job");
}

if ($accion == "leer") {
    $job = $colaMensajes->pop();
    if ($job == "") {
        echo 'no hay datos en job, suponemos time_out';        
    }else{
        echo $job->getData() . '<br><br>';
        $colaMensajes->deleteJob($job);
    }
}

$colaMensajes->printStats();
?>