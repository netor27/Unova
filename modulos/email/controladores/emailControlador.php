<?php

//Script ejecutado desde cron-tab semanalmente para enviar un resumen semanal a 
//cada usuario
//el resumen puede contener nuevos alumnos y nuevas preguntas si es que existen 
//y el usuario es un profesor.
//Si el usuario no es un profesor, se envía información de nuevos cursos 
//dependiendo de sus intereses
//
function enviarResumenSemanal() {
    $secret = -1;
    if(isset($_GET['llaveSecreta'])){
        $secret = $_GET['llaveSecreta'];
    }
    //Si esta llave no es igual, no hacer nada
    if ($secret == 199201302) {
        
    }else{
        goToIndex();
    }
}
?>