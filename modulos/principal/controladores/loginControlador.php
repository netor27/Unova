<?php

function principal() {
    require_once 'lib/php/facebook/loginFacebook.php';
    
    if ($user) {
        goToIndex();
    }else{
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
            require_once 'lib/php/facebook/loginFacebook.php';
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
    salir();
    goToIndex();
}

?>
