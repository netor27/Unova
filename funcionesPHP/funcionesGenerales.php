<?php

function goToIndex() {
    redirect('/');
}

function getUrl() {
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}

function redirect($url, $permanent = false) {
    if ($permanent) {
        header('HTTP/1.1 301 Moved Permanently');
    }
    header('Location: ' . $url);
    exit();
}

function strleft($s1, $s2) {
    return substr($s1, 0, strpos($s1, $s2));
}

function tipoUsuario() {
    require_once 'modulos/usuarios/clases/Usuario.php';

    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
        if ($usuario->tipoUsuario == 1) {
            return 'administrador';
        } else if ($usuario->tipoUsuario == 0) {
            return 'usuario';
        }
    } else {
        return 'visitante';
    }
}

function getUsuarioActual() {
    if (isset($_SESSION['usuario'])) {
        return $_SESSION['usuario'];
    } else {
        return NULL;
    }
}

function validarUsuarioLoggeado() {
    if (!isset($_SESSION['usuario'])) {
        $pagina = getUrl();
        $msgLogin = "Debes iniciar sesión para ver este contenido.";
        require_once 'modulos/principal/vistas/login.php';
        return false;
    } else {
        return true;
    }
}

function validarUsuarioLoggeadoParaAjax() {
    return isset($_SESSION['usuario']);
}

function validarUsuarioLoggeadoParaSubmits() {
    return isset($_SESSION['usuario']);
}

function validarUsuarioLoggeadoMandarIndex() {
    if (!isset($_SESSION['usuario'])) {
        goToIndex();
    }
}

function comprobar_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function transformaDateDDMMAAAA($date) {
    return date("d-m-Y",$date);
}



function getUniqueCode($length) {
    $code = md5(uniqid(rand(), true));
    if ($length != "")
        return substr($code, 0, $length);
    else
        return $code;
}

function setSessionMessage($message) {
    $_SESSION['sessionMessage'] = $message;
}

function getSessionMessage() {
    if (isset($_SESSION['sessionMessage'])) {
        $sessionMessage = $_SESSION['sessionMessage'];
        $_SESSION['sessionMessage'] = NULL;
        unset($_SESSION['sessionMessage']);
        return $sessionMessage;
    }
    else
        return NULL;
}

function removeBadHtmlTags($badHtml) {
    //echo "<br><br><br><br>Bad:<br>";
    //echo "<pre>" . htmlspecialchars($badHtml) . "</pre>";

    require_once 'lib/php/htmlPurifier/library/HTMLPurifier.auto.php';
    $config = HTMLPurifier_Config::createDefault();


    $config->set('HTML.Doctype', 'XHTML 1.0 Transitional'); // replace with your doctype

    $purifier = new HTMLPurifier($config);

    $pureHtml = $purifier->purify($badHtml);

    //echo "<br>Good:<br>";
    //echo "<pre>" .htmlspecialchars($pureHtml) . "</pre>";

    return $pureHtml;
}

?>