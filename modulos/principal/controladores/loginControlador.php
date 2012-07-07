<?php

function principal() {
    require_once 'lib/php/facebook/loginFacebook.php';
    require_once 'modulos/principal/modelos/loginModelo.php';
    require_once 'modulos/usuarios/modelos/usuarioModelo.php';

    if ($user) {
        //tenemos un usuario logeado en facebook
        //Datos de facebook
        $email = $user_info['email'];
        $nombre = $user_info['name'];
        $avatar = 'http://graph.facebook.com/' . $user . '/picture?type=normal';

        //validamos si este usuario ya tiene su email registrado, sino creamos un usuario nuevo
        $usuario = getUsuarioFromEmail($email);
        if (isset($usuario)) {
            //el usuario ya existe en la bd, loggearlo!
            if(loginUsuario($usuario->email, $usuario->password) == 1)
                setSessionMessage("<h4 class='success'>¡Bienvenido " . getUsuarioActual()->nombreUsuario . "!</h4>");
            goToIndex();
        } else {
            //el usuario no existe en la bd, crearlo!
            require_once 'modulos/usuarios/clases/Usuario.php';
            require_once 'funcionesPHP/uniqueUrlGenerator.php';
            $usuario = new Usuario();
            $usuario->nombreUsuario = $nombre;
            $usuario->email = $email;
            $password = getUniqueCode(10);
            $usuario->password = md5($password);
            $usuario->uniqueUrl = getUsuarioUniqueUrl($nombre);

            $array = altaUsuario($usuario);
            $id = $array['id'];
            $usuario->idUsuario = $id;

            if ($id >= 0) {
                //Ya creamos el usuario, ahora actualizamos su avatar y su estado de activado
                echo 'se creo un usuario con id= ' . $id;
                $usuario->avatar = $avatar;
                actualizaAvatar($usuario);
                setActivado($id, 1);
                if(loginUsuario($email, md5($password)) == 1)
                    setSessionMessage("<h4 class='success'>¡Bienvenido " . getUsuarioActual()->nombreUsuario . "!</h4>");
                goToIndex();
            }
        }
    } else {
        $pagina = "/";
        require_once 'modulos/principal/vistas/login.php';
    }
}

function loginSubmit() {
    require_once 'modulos/principal/modelos/loginModelo.php';

    if (isset($_POST['pagina']))
        $pagina = $_POST['pagina'];

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $usuario = removeBadHtmlTags(trim($_POST['email']));
        $password = removeBadHtmlTags(trim($_POST['password']));
        $num = loginUsuario($usuario, md5($password));
        //$num= 0;
        if ($num == 0) { //no hay usuario correcto
            $msgLogin = "Nombre de usuario y/o contraseña incorrectos.<br>";
            require_once 'modulos/principal/vistas/login.php';
        } else {
            setSessionMessage("<h4 class='success'>¡Bienvenido " . getUsuarioActual()->nombreUsuario . "!</h4>");
            redirect($pagina);
        }
    } else {
        $msgLogin = "Los datos no son válidos.<br>";
        require_once 'modulos/principal/vistas/login.php';
    }
}

function logout() {
    require_once 'modulos/principal/modelos/loginModelo.php';
    if (salir()) {
        require_once ('funcionesPHP/funcionesGenerales.php');
        goToIndex();
    }
}

?>
