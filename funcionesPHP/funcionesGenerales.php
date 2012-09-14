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

function validarUniqueSession() {
    if (isset($_SESSION['usuario'])) {
        require_once 'modulos/principal/modelos/loginModelo.php';
        $sessionId = session_id();
        $idUsuario = $_SESSION['usuario']->idUsuario;
        if (validateSessionIdUsuario($idUsuario, $sessionId)) {
            return true;
        } else {
            //No es una sesión válida, destruimos la sesión actual y las cookies
            //el sessionId ya no es válido para este usuario, destruimos la session            
            $_SESSION['usuario'] = null;
            session_destroy();
            unset($_COOKIE['usrcookie']);
            unset($_COOKIE['clvcookie']);            
            setcookie("usrcookie", "logout", 1, '/');
            setcookie("clvcookie", "logout", 1, '/');
            global $msg;
            $msg = "<h4 class='error'>Alguien utilizó tus datos para iniciar sesión. Te recomendamos iniciar sesión y cambiar tu contraseña </h4>";
            return false;
        }
    }else{
        //no hay ningún usuario loggeado, entonces es una sesión válida
        return true;
    }
}

function getUsuarioActual() {
    if (isset($_SESSION['usuario'])) {
        //hay un usuario en la sesioń, regresamos eso.
        return $_SESSION['usuario'];
    } else {
        //no hay usuario en session, verificamos si hay cookies guardadas
        if (isset($_COOKIE['usrcookie']) && isset($_COOKIE['clvcookie'])) {
            //hay cookies, tratamos de hacer login
            require_once 'modulos/principal/modelos/loginModelo.php';
            if (loginUsuario($_COOKIE['usrcookie'], $_COOKIE['clvcookie']) == 1) {
                //hay buen login
                return $_SESSION['usuario'];
            } else {
                //los datos guardados en las cookies no son correctos. Se borran
                return NULL;
            }
        } else {
            return NULL;
        }
    }
}

function validarUsuarioLoggeado() {
    if (!isset($_SESSION['usuario'])) {
        $pagina = getUrl();
        $msgLogin = "Debes iniciar sesión para ver este contenido.";
        require_once 'lib/php/facebook/loginFacebook.php';
        if ($user) {
            //si user existe entonces ya hay un inicio de sesión por facebook
            return true;
        } else {
            //si no hay user, no hay usuario en facebook
            require_once 'modulos/principal/vistas/login.php';
            return false;
        }
    } else {
        return true;
    }
}

function validarUsuarioLoggeadoParaSubmits() {
    return isset($_SESSION['usuario']);
}

function validarUsuarioAdministrador() {
    $usuario = getUsuarioActual();
    if (isset($usuario)) {
        if ($usuario->tipoUsuario == 1) {
            return true;
        } else {
            //no tiene los permisos
            return false;
        }
    } else {
        return false;
    }
}

function comprobar_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function transformaDateDDMMAAAA($date) {
    return date("d-m-Y", $date);
}

function transformaMysqlDateDDMMAAAA($date) {
    $fecha = DateTime::createFromFormat('Y-m-d', $date);
    return $fecha->format('d/m/Y');
}

function transformaMysqlDateDDMMAAAAConHora($date) {
    $time = strtotime($date);
    return date('d/m/Y -- h:i a', $time);
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

function bytesToString($bytes) {
    if ($bytes < 1000) {
        //mostramos en bytes
        return $bytes . " bytes";
    } else if ($bytes < 1000000) {
        //mostramos en KB
        return round($bytes / 1000, 4) . " KB";
    } else if ($bytes < 1000000000) {
        //mostramos en MB
        return round($bytes / 1000000, 4) . " MB";
    } else {
        //mostramos en GB
        return round($bytes / 1000000000, 4) . " GB";
    }
}

function bytesToDollars($bytes) {
    //Convertir primero a GB y luego multiplicar por 0.15 que es lo que cuesta el gb al mes
    $dollars = round($bytes / 1000000000 * 0.15, 4);
    return $dollars;
}

function getTipoOperacion($idTipoOperacion) {
    switch ($idTipoOperacion) {
        case 1:
            return "Recarga de saldo";
            break;
        case 2:
            return "Inscripci&oacute;n";
            break;
        case 3:
            return "Ganancia por ventas";
            break;
        case 4:
            return "Retiro de saldo";
            break;
        default:
            return "Tipo de operaci&oacute;n no definida";
            break;
    }
}

function operacionEsPositiva($idTipoOperacion) {
    switch ($idTipoOperacion) {
        case 1:
        case 3:
            return true;
            break;
        case 2:
        case 4:
            return false;
            break;
    }
}

function transformaMMSStoMinutes($tiempo) {
    list($minutes, $seconds) = explode(":", $tiempo);
    $minutes = $minutes + floor($seconds / 60);
    return $minutes;
}

function guardarTipoLayout() {
    //checamos si es tablet, movil o desktop
    if (!isset($_SESSION['layout'])) {
        require_once 'lib/php/Mobile_Detect/Mobile_Detect.php';
        $detect = new Mobile_Detect();
        $layout = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'desktop');
        $_SESSION['layout'] = $layout;
    }
}

function getTipoLayout() {
    return $_SESSION['layout'];
}

?>