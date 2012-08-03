<?php

function loginUsuario($email, $password) {
    require_once ('bd/conex.php');
    $numeroTuplas = 0;
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM usuario WHERE email = :email and password = :pass");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $password);
    $stmt->execute();

    require_once 'modulos/usuarios/clases/Usuario.php';
    $usuario = new Usuario();
    if ($stmt->rowCount() == 1) {
        $numeroTuplas = 1;
        $row = $stmt->fetch();
        $usuario->idUsuario = $row['idUsuario'];
        $usuario->activado = $row['activado'];
        $usuario->avatar = $row['avatar'];
        //$usuario->bio = $row['bio'];
        $usuario->email = $row['email'];
        $usuario->nombreUsuario = $row['nombreUsuario'];
        $usuario->tipoUsuario = $row['tipoUsuario'];
        $usuario->uuid = $row['uuid'];
        $usuario->uniqueUrl = $row['uniqueUrl'];
        $usuario->saldo = $row['saldo'];

        $_SESSION['usuario'] = $usuario;

        //actualizamos en la base de datos el sessionId actual
        actualizarIdSession($usuario->idUsuario);

        require_once 'funcionesPHP/CargarInformacionSession.php';
        cargarCursosSession();
    } else {
        //echo "rowCount = " . $stmt->rowCount();
    }
    return $numeroTuplas;
}

function actualizarIdSession($idUsuario) {
    $sessionId = session_id();
    require_once ('bd/conex.php');
    global $conex;
    $stmt = $conex->prepare("UPDATE usuario SET sessionId = :sessionId WHERE idUsuario = :idUsuario");
    $stmt->bindParam(':sessionId', $sessionId);
    $stmt->bindParam(':idUsuario', $idUsuario);
    return($stmt->execute());
}

function validateSessionIdUsuario($idUsuario, $sessionId) {
    require_once ('bd/conex.php');
    global $conex;
    $stmt = $conex->prepare("SELECT idUsuario FROM usuario WHERE idUsuario = :id and sessionId = :sessionId");
    $stmt->bindParam(':id', $idUsuario);
    $stmt->bindParam(':sessionId', $sessionId);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        //el usuario y el sessionId son válidos regresar true
        return true;
    }else{
        //el sessionId ya no es válido para este usuario, destruimos la session
        setSessionMessage("<h4 class='error'>Alguien utilizó tus datos para iniciar sesión. Si esto es un error <a href='/usuarios/usuario/recuperarPassword'>recupera tu contraseña aquí</a></h4>");
        $_SESSION['usuario'] = null;
        return false;
    }
}

function salir() {
    $log = false;
    if (isset($_SESSION['usuario'])) {
        $_SESSION['usuario'] = null;
        session_destroy();
        $log = true;
    }
    return $log;
}

?>
