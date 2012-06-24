<?php

function loginUsuario($email,$password){
    require_once ('bd/conexRead.php');
    $numeroTuplas = 0;
    $password = md5($password);
    global $conex;
    $stmt = $conex->prepare("SELECT * FROM usuario WHERE email = :email and password = :pass");
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':pass',$password);
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
        
        $_SESSION['usuario'] = $usuario;
        
        require_once 'funcionesPHP/CargarInformacionSession.php';
        cargarCursosSession();
    }else{
        //echo "rowCount = " . $stmt->rowCount();
    }
    return $numeroTuplas;
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
