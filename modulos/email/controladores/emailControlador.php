<?php

//Script
//  wget -O - -q http://localhost/email.php?llaveSecreta=199201302
//  exit 0
// 
//  
//    ejecutado desde cron-tab semanalmente para enviar un resumen semanal a 
//cada usuario
//el resumen puede contener nuevos alumnos y nuevas preguntas si es que existen 
//y el usuario es un profesor.
//Si el usuario no es un profesor, se envía información de nuevos cursos 
//dependiendo de sus intereses
//
function enviarResumenSemanal() {
    $dias = 7;
    $secret = -1;
    if (isset($_GET['llaveSecreta'])) {
        $secret = $_GET['llaveSecreta'];
    }
    //Si esta llave no es igual, no hacer nada
    if ($secret == 199201302) {
        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';

        $totalUsuarios = getTotalUsuarios();
        echo "Total de usuarios = " . $totalUsuarios . '<br>';
        //obtenemos de 500 en 500 usuarios
        $i = 0;
        for ($i = 0; $i <= $totalUsuarios; $i+=100) {
            $usuarios = getUsuariosParaResumenSemanal($i, 100);
            foreach ($usuarios as $usuario) {
                echo '<br><br>==================================<br><br>';
                echo 'Analizando usuario ' . $usuario->idUsuario . ' -- ' . $usuario->nombreUsuario . '<br>';
                //Obtener el número de nuevos alumnos en sus cursos
                $numAlumnos = getNumeroDeNuevosAlumnos($usuario->idUsuario, $dias);
                echo '---Alumnos nuevos ' . $numAlumnos . '<br>';
                //Obtener el número de preguntas sin responder
                $numPreguntas = getNumeroDePreguntasSinResponder($usuario->idUsuario);
                echo '---Preguntas sin responder ' . $numPreguntas . '<br>';
                require_once 'modulos/email/modelos/envioEmailModelo.php';
                if ($numAlumnos > 0 || $numPreguntas > 0) {
                    enviarMailResumenSemanal($usuario->email, $usuario->nombreUsuario, $numAlumnos, $numPreguntas);
                    echo 'mail enviado a ' . $usuario->email;
                }else{
                    echo 'no se envio el mail porque tiene 0 alumnos y 0 preguntas';
                }
            }
        }
    }
//    else {
//        goToIndex();
//    }
}

?>