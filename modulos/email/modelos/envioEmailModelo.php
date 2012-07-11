<?php

require_once 'modulos/email/modelos/EmailModelo.php';
define("EMAIL_FROM", "Unova@unova.mx");
define("HEADER", '<html>
        <head>
        <title>Bienvenido a Unova</title>
        </head>
        <body style="color:midnightblue">
        <table cellpadding="0" cellspacing="0" width="98%">
        <tbody><tr>
            <td width="100%" align="center">
                <table width="700" cellpadding="0" cellspacing="0" bgcolor="#f1f1ee" style="font-family:arial;font-size:14px;line-height:150%">
                    <colgroup>
                        <col width="30">
                        <col width="640">
                        <col width="30">
                    </colgroup>
                    <tbody>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="padding:10px 0">
                                <a href="http://unova.co">
                                    <img src="http://c342380.r80.cf1.rackcdn.com/Unova_Logo_400x102.png" width="219" height="50" border="0" title="Unova" alt="Unova">
                                </a>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="padding:20px 15px" bgcolor="#ffffff">
                                <p></p>
                                <p></p>');

define("FOOTER", '<p></p>
                                <p></p></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="padding:10px 35px;color:#999999;font-size:11px;line-height:16px">
                                Encu&eacute;ntranos en:&nbsp;
                                <a href="http://www.facebook.com/pages/Unova/266525193421804" style="text-decoration:none;border:0" title="Facebook" target="_blank">
                                    <img src="http://c342380.r80.cf1.rackcdn.com/Facebook.png" style="border:0" width="16" height="16" alt="Encuentra a Unova en Facebook">
                                </a>&nbsp;
                                <a href="http://twitter.com/UnovaEdu" style="text-decoration:none;border:0" title="Twitter" target="_blank">
                                    <img src="http://c342380.r80.cf1.rackcdn.com/Twitter.png" style="border:0" width="16" height="16" alt="Encuentra a Unova en Twitter">
                                </a>&nbsp;
                                <a href="#" style="text-decoration:none;border:0" title="Google+" target="_blank">
                                    <img src="http://c342380.r80.cf1.rackcdn.com/Google+.png" style="border:0" width="16" height="16" alt="Encuentra a Unova en Google+">
                                </a>&nbsp;
                                <br>
                                <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody></table>
            </td>
        </tr>
    </tbody>
    </table>
    </body></html>
    ');

function enviarMailBienvenida($email, $nombreUsuario, $urlConfirmacion) {
    $text = 'Bienvenido a Unova,\n' . utf8_encode($nombreUsuario) . '\n
        Haz quedado registrado satisfactoriamente en Unova,\n 
        por favor confirma tu cuenta siguiendo este enlace:\n\n
        ' . $urlConfirmacion;
    $html = HEADER . '
        <h1 style="font-size:18px">Bienvenido a Unova, ' . utf8_encode($nombreUsuario) . '</h1>
            <table bgcolor="#f1f1ee" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Haz quedado registrado satisfactoriamente en Unova, por favor confirma tu cuenta siguiendo este enlace:</p>
                            <p style="padding:10px;margin:0">
                               <a href="' . $urlConfirmacion . '">' . $urlConfirmacion . '</a>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>' . FOOTER;

    return sendMail($text, $html, "Te damos la bienvenida a Unova", EMAIL_FROM, $email);
}

function enviarMailConfirmacion($email, $urlConfirmacion) {
    $text = 'Confirmaci&oacute;n de cuenta,\n\n
        Para confirmar tu cuenta sigue este enlace:\n\n
        ' . $urlConfirmacion . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER . '
        <h1 style="font-size:18px">Confirmaci&oacute;n de cuenta</h1>
        <table bgcolor="#f1f1ee" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Para confirmar tu cuenta sigue este enlace:</p>
                            <p style="padding:10px;margin:0"><a href="' . $urlConfirmacion . '">' . $urlConfirmacion . '</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ' . FOOTER;

    return sendMail($text, $html, "Confirmacion de cuenta", EMAIL_FROM, $email);
}

function enviarMailOlvidePassword($email, $urlReestablecer) {
    $text = 'Reestablecer contrase&ntilde;a,\n\n
        Para reestablecer tu contrase&ntilde;a sigue este enlace:\n\n
        ' . $urlReestablecer . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER . '
        <h1 style="font-size:18px">Reestablecer contrase&ntilde;a</h1>
        <table bgcolor="#f1f1ee" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Para reestablecer tu contrase&ntilde;a sigue este enlace:</p>
                            <p style="padding:10px;margin:0"><a href="' . $urlReestablecer . '">' . $urlReestablecer . '</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ' . FOOTER;
    return sendMail($text, $html, utf8_encode("Reestablecer contraseña"), EMAIL_FROM, $email);
}

function enviarMailTransformacionVideoCompleta($email, $tituloCurso, $tituloClase, $urlCurso) {
    $text = 'Transformaci&oacute;n de video completa,\n\n
        El video de tu clase "' . utf8_encode($tituloClase) . '" perteneciente a tu curso "' . utf8_encode($tituloCurso) . '"\n
        ha sido transformado satisfactoriamente.\n
        Ya esta disponible en l&iacute;nea en la p&aacute;gina de tu curso:\n
        ' . $urlCurso . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER . '
        <h1 style="font-size:18px">Transformaci&oacute;n de video completa</h1>
        <table bgcolor="#f1f1ee" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">El video de tu clase "' . utf8_encode($tituloClase) . '" perteneciente a tu curso "' . utf8_encode($tituloCurso) . '" ha sido transformado satisfactoriamente.</p>
                            <p style="padding:10px;margin:0">Ya esta disponible en l&iacute;nea en la p&aacute;gina de tu curso:</p>
                            <p style="padding:10px;margin:0"><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ' . FOOTER;
    return sendMail($text, $html, utf8_encode("Transformacóon de video completa"), EMAIL_FROM, $email);
}

function enviarMailSuscripcionCurso($email, $tituloCurso, $imagenCurso, $urlCurso) {
    $text = 'Haz quedado inscrito al curso "' . utf8_encode($tituloCurso) . '",\n\n
        Recuerda que es importante comentar y calificar los cursos para mejorar su calidad.\n\n
        Tambi&eacute;n puedes hacer preguntas directamente al profesor.\n\n
        Esto lo puedes hacer en el siguiente enlace:\n\n' . $urlCurso . '\n\n
        Gracias, equipo Unova.';
    $html = HEADER . '
        <h1 style="font-size:18px">Haz quedado inscrito al curso "' . utf8_encode($tituloCurso) . '"</h1>
        <table bgcolor="#f1f1ee" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td valign="top" style="width:110px;text-align:center">
                            <a href="' . $urlCurso . '" alt="' . $urlCurso . '">
                                <img width="80" height="80" border="0" title="Unova" alt="Unova" src="' . $imagenCurso . '"/>
                            </a>
                        </td>
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Recuerda que es importante comentar y calificar los cursos para mejorar su calidad.</p>
                            <p style="padding:10px;margin:0">Tambi&eacute;n puedes hacer preguntas directamente al profesor.</p>
                            <p style="padding:10px;margin:0">Esto lo puedes hacer en el siguiente enlace:</p>
                            <p style="padding:10px;margin:0"><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ' . FOOTER;
    return sendMail($text, $html, utf8_encode("Inscripción a curso"), EMAIL_FROM, $email);
}

function enviarMailRespuestaPregunta($email, $tituloCurso, $urlCurso, $pregunta, $respuesta) {
    $text = 'Tu pregunta ha sido respondida: \n\n
        ' . utf8_encode($pregunta) . '\n\n
        Respuesta:\n\n
        ' . utf8_encode($respuesta) . '\n\n\n\n
        Equipo Unova.';
    $html = HEADER . '
        <h1  style="font-size:18px">Tu pregunta en el curso "' . utf8_encode($tituloCurso) . '" ha sido respondida </h1>
        <table bgcolor="#f1f1ee" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
                <tbody>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="font-size:17px; color:darkred;padding:10px;margin:0">' . utf8_encode($pregunta) . '</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Respuesta:</p>
                            <p style="font-size:17px; color:darkgreen; padding:10px;margin:0">' . utf8_encode($respuesta) . '</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td style="font-size:13px;margin: 10px; padding: 10px;">
                            <p style="padding:10px;margin:0">Para ver el curso sigue este enlace:</p>
                            <p style="padding:10px;margin:0"><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ' . FOOTER;
    return sendMail($text, $html, "Tu pregunta ha sido respondida", EMAIL_FROM, $email);
}

function enviarMailResumenSemanal($email, $nombreUsuario, $numAlumnos, $numPreguntas) {
    $text = $nombreUsuario .', este es tu resument semanal en Unova: \n\n
        Tienes '.$numAlumnos.' nuevos.\n\n
        Te quedan '.$numPreguntas.' sin responder.\n\n\n
        Equipo Unova.
        ';
    $html = HEADER . '
        <h1 style="font-size:18px">'.utf8_encode($nombreUsuario).', este es tu resumen semanal en Unova</h1>
        <table bgcolor="#f1f1ee" width="100%" cellpadding="0" cellspacing="0" style="padding:15px 0 15px 0">
            <tbody>                                            
                <tr valign="top" style="text-align: center;">
                    <td style="font-size:18px;margin: 10px; padding: 10px; width: 50%;">
                        <p style=""> 
                            Alumnos nuevos 
                        </p>
                        <span style="padding:5px;margin:0;font-size:24px;color:darkgreen;">'.$numAlumnos.'</span>
                        <p><a href="http://www.unova.co/usuarios/cursos/instructor">Ir a mis cursos</a></p>
                    </td>
                    <td style="font-size:18px;margin: 10px; padding: 10px; width: 50%; border-left: 1px;border-style: dotted;">
                        <p style=""> 
                            Preguntas sin responder
                        </p>
                        <span style="padding:5px;margin:0;font-size:24px;color:darkred;">'. $numPreguntas.'</span>
                        <p><a href="http://www.unova.co/usuarios/cursos/responderPreguntas">Responder las preguntas</a></p>
                    </td>
                </tr>
            </tbody>
        </table>
        ' . FOOTER;
    return sendMail($text, $html, "Tu resumen semanal en Unova", EMAIL_FROM, $email);
}

//function enviarMailAlumnoSuscrito($email, $tituloCurso, $urlCurso) {
//    $text = 'Felicidades, tienes un nuevo alumno en tu curso "' . $tituloCurso . '".\n\n
//        Recuerda ver los comentarios y calificaciones de tus alumnos, adem&aacute;s, si te es posible, responder
//        a las preguntas que te hagan.\n\n
//        Esto lo puedes hacer en el siguiente enlace:\n\n' . $urlCurso . '\n\n
//        Gracias, equipo Unova.';
//    $html = HEADER . '
//        <h1>Nuevo alumno inscrito</h1>
//        <p>Felicidades, tienes un nuevo alumno en tu curso "' . $tituloCurso . '".</p>
//        <p>Recuerda ver los comentarios y calificaciones de tus alumnos, adem&aacute;s, si te es posible, responder
//        a las preguntas que te hagan.</p>
//        <p>Esto lo puedes hacer en el siguiente enlace:</p>
//        <p><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
//        ' . FOOTER;
//    return sendMail($text, $html, "Nuevo alumno suscrito", EMAIL_FROM, $email);
//}
//function enviarMailPreguntaEnCurso($email, $tituloCurso, $urlCurso, $pregunta) {
//    $text = 'Te han hecho una nueva pregunta en tu curso "' . $tituloCurso . '":\n\n
//        ' . $pregunta . '\n\n
//        Para contestarla sigue este enlace:\n\n
//        ' . $urlCurso . '\n\n
//        Gracias, equipo Unova.';
//    $html = HEADER . '
//        <h1>Te han hecho una nueva pregunta en tu curso "' . $tituloCurso . '":</h1>
//        <h2>' . $pregunta . '</h2>
//        <p>Para contestarla sigue este enlace:</p>
//        <p><a href="' . $urlCurso . '">' . $urlCurso . '</a></p>
//        ' . FOOTER;
//    return sendMail($text, $html, "Te han hecho una nueva pregunta", EMAIL_FROM, $email);
//}
?>
