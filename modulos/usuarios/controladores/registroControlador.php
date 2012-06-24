<?php

function principal() {
    $nombre = "";
    $email = "";
    require_once 'modulos/usuarios/vistas/registro.php';
}

function alta() {

    if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['pass1']) && isset($_POST['pass2'])) {

        $pass1 = removeBadHtmlTags(trim($_POST['pass1']));
        $pass2 = removeBadHtmlTags(trim($_POST['pass2']));
        $nombre = removeBadHtmlTags(trim($_POST['nombre']));
        $email = removeBadHtmlTags(trim($_POST['email']));

        require_once('lib/php/recaptcha/recaptchalib.php');
        $privatekey = "6LdUV9ESAAAAAKE4T1aGYgW4nPqDn3EOs18xUDwU";
        $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

        if (strlen($pass1) >= 5 && strlen($nombre) >= 4 && comprobar_email($email) && $pass1 == $pass2 && $resp->is_valid) {
            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            require_once 'modulos/usuarios/clases/Usuario.php';
            require_once 'funcionesPHP/uniqueUrlGenerator.php';
            $usuario = new Usuario();
            $usuario->nombreUsuario = $nombre;
            $usuario->email = $email;
            $usuario->password = md5($pass1);
            $usuario->uniqueUrl = getUsuarioUniqueUrl($nombre);

            $array = altaUsuario($usuario);
            $id = $array['id'];
            $uuid = $array['uuid'];

            if ($id >= 0) {
                require_once 'modulos/email/modelos/envioEmailModelo.php';
                enviarMailBienvenida($email, $nombre, 'www.unova.mx/usuarios.php?a=confirmarCuenta&i=' . $uuid);
                setSessionMessage("<h4 class='success'>Registro satisfactorio. Recibirás un correo para confirmar tu cuenta.</h4>");
                require_once 'modulos/principal/modelos/loginModelo.php';
                loginUsuario($email, $pass1);
                redirect("/");
            } else {
                $error = "<h4 class='error'>Ocurrió un error en tu registro. El valor para correo electrónico ya fue registrado</h4>";
                require_once 'modulos/usuarios/vistas/registro.php';
            }
        } else {
            $error = "Los datos envíados no son correctos.";
            $captchaError = $resp->error;
            require_once 'modulos/usuarios/vistas/registro.php';
        }
    } else {
        goToIndex();
    }
}

?>
