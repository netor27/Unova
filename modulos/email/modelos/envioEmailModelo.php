<?php

require_once 'modulos/email/modelos/EmailModelo.php';
define("EMAIL_FROM", "contacto@unova.mx");
define("HEADER",'<html>
        <head>
        <title>Bienvenido a Unova</title>
        </head><body>
        <img src="http://c342380.r80.cf1.rackcdn.com/Unova_Logo_400x102.png"><img>');

function enviarMailBienvenida($email, $nombreUsuario, $urlConfirmacion) {
    $text = 'Bienvenido a Unova,\n' . $nombreUsuario . '\n
        Haz quedado registrado satisfactoriamente en Unova,\n 
        por favor confirma tu cuenta siguiendo este enlace:\n\n
        ' . $urlConfirmacion . '\n\n
        Gracias, equipo Unova.';
    $html = $header.'
        <h1>Bienvenido a Unova</h1>
        <p>' . $nombreUsuario . ',</p>
        <p>Haz quedado registrado satisfactoriamente en Unova, por favor confirma tu cuenta siguiendo este enlace:</p>
        <p><a href="' . $urlConfirmacion . '">' . $urlConfirmacion . '</a></p>
        <p>Gracias. </p><p>Equipo Unova.</p>
        </body></html>
        ';
    return sendMail($text, $html, "Te damos la bienvenida a Unova", EMAIL_FROM, $email);
}

function enviarMailConfirmacion($email, $urlConfirmacion) {
    $text = 'Confirmaci&oacute;n de cuenta,\n\n
        Para confirmar tu cuenta sigue este enlace:\n\n
        ' . $urlConfirmacion . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER.'
        <h1>Confirmaci&oacute;n de cuenta</h1>
        <p>Para confirmar tu cuenta sigue este enlace:</p>
        <p><a href="' . $urlConfirmacion . '">' . $urlConfirmacion . '</a></p>
        <p>Gracias. </p><p>Equipo Unova.</p>
        </body></html>
        ';
    return sendMail($text, $html, "Confirmacion de cuenta", EMAIL_FROM, $email);
}

function enviarMailOlvidePassword($email, $urlReestablecer) {
    $text = 'Reestablecer contrase&ntilde;a,\n\n
        Para reestablecer tu contrase&ntilde;a sigue este enlace:\n\n
        ' . $urlReestablecer . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER.'
        <h1>Reestablecer contrase&ntilde;a</h1>
        <p>Para reestablecer tu contrase&ntilde;a sigue este enlace:</p>
        <p><a href="' . $urlReestablecer . '">' . $urlReestablecer . '</a></p>
        <p>Gracias. </p><p>Equipo Unova.</p>
        </body></html>
        ';
    return sendMail($text, $html, "Reestablecer contrasena", EMAIL_FROM, $email);
}

function enviarMailTransformacionVideoCompleta($email, $tituloCurso, $tituloClase, $urlCurso) {
    $text = 'Transformaci&oacute;n de video completa,\n\n
        El video de tu clase "' . $tituloClase . '" perteneciente a tu curso "' . $tituloCurso . '"\n
        ha sido transformado satisfactoriamente.\n
        Ya esta disponible en l&iacute;nea en la p&aacute;gina de tu curso:\n
        ' . $urlCurso . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER.'
        <h1>Transformaci&oacute;n de video completa</h1>
        <p>El video de tu clase "' . $tituloClase . '" perteneciente a tu curso "' . $tituloCurso . '" ha sido transformado satisfactoriamente.</p>
        <p>Ya esta disponible en l&iacute;nea en la p&aacute;gina de tu curso:</p>
        <p><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
        <p>Gracias. </p><p>Equipo Unova.</p>
        </body></html>
        ';
    return sendMail($text, $html, "Transformacion de video completa", EMAIL_FROM, $email);
}

function enviarMailAlumnoSuscrito($email, $tituloCurso, $urlCurso) {
    $text = 'Felicidades, tienes un nuevo alumno en tu curso "' . $tituloCurso . '".\n\n
        Recuerda ver los comentarios y calificaciones de tus alumnos, adem&aacute;s, si te es posible, responder
        a las preguntas que te hagan.\n\n
        Esto lo puedes hacer en el siguiente enlace:\n\n' . $urlCurso . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER.'
        <h1>Nuevo alumno inscrito</h1>
        <p>Felicidades, tienes un nuevo alumno en tu curso "' . $tituloCurso . '".</p>
        <p>Recuerda ver los comentarios y calificaciones de tus alumnos, adem&aacute;s, si te es posible, responder
        a las preguntas que te hagan.</p>
        <p>Esto lo puedes hacer en el siguiente enlace:</p>
        <p><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
        <p>Gracias. </p><p>Equipo Unova.</p>
        </body></html>
        ';
    return sendMail($text, $html, "Nuevo alumno suscrito", EMAIL_FROM, $email);
}

function enviarMailSuscripcionCurso($email, $tituloCurso, $urlCurso) {
    $text = 'Haz quedado suscrito al curso "' . $tituloCurso . '",\n\n
        Recuerda que es importante comentar y calificar los cursos para mejorar su calidad.\n\n
        Tambi&eacute;n puedes hacer preguntas directamente al profesor.\n\n
        Esto lo puedes hacer en el siguiente enlace:\n\n' . $urlCurso . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER.'
        <h1>Haz quedado suscrito al curso "' . $tituloCurso . '"</h1>
        <p>Recuerda que es importante comentar y calificar los cursos para mejorar su calidad.</p>
        <p>Tambi&eacute;n puedes hacer preguntas directamente al profesor.</p>
        <p>Esto lo puedes hacer en el siguiente enlace:</p>
        <p><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
        <p>Gracias. </p><p>Equipo Unova.</p>
        </body></html>
        ';
    return sendMail($text, $html, "Suscripcion a curso", EMAIL_FROM, $email);
}

function enviarMailPreguntaEnCurso($email, $tituloCurso, $urlCurso, $pregunta) {
    $text = 'Te han hecho una nueva pregunta en tu curso "' . $tituloCurso . '":\n\n
        ' . $pregunta . '\n\n
        Para contestarla sigue este enlace:\n\n
        ' . $urlCurso . '\n\n
        Gracias, equipo Unova.';
   $html = HEADER.'
        <h1>Te han hecho una nueva pregunta en tu curso "' . $tituloCurso . '":</h1>
        <h2>' . $pregunta . '</h2>
        <p>Para contestarla sigue este enlace:</p>
        <p><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
        <p>Gracias. </p><p>Equipo Unova.</p>
        </body></html>
        ';
    return sendMail($text, $html, "Te han hecho una nueva pregunta", EMAIL_FROM, $email);
}

?>
