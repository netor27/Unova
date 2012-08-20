<?php

function principal() {
    if (validarUsuarioAdministrador()) {
        require_once 'modulos/cdn/modelos/cdnModelo.php';
        $containers = listContainers();
        require_once 'modulos/administracion/vistas/adminArchivos.php';
    } else {
        goToIndex();
    }
}

function detallesContenedor(){
    if (validarUsuarioAdministrador()) {
        require_once 'modulos/cdn/modelos/cdnModelo.php';
        $containerName = $_GET['i'];
        if(isset($containerName)){
            $container = getContainer($containerName);
            $objects = $container->get_objects();
            require_once 'modulos/administracion/vistas/detallesContenedorArchivos.php';
        }else{
            setSessionMessage("No se especificó el nombre del contenedor");
            redirect("administracion/archivos");
        }
    } else {
        goToIndex();
    }
}
?>