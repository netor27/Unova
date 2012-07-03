<?php

/**
 * Description of cdnModelo
 *
 * @author neto
 * 
 */
function crearArchivoCDN($file, $fileName, $tipoArchivo) {
    $conn = getConnection();
    $containerName = getContainerName($tipoArchivo);
    //Obtenemos el container 
    $container = $conn->get_container($containerName);
    //Creamos el objeto
    $object = $container->create_object($fileName);
    $uri = NULL;
    if ($object->load_from_filename($file)) {
        $uri = $object->public_uri();
        //obtenemos el link del cdn y borramos el archivo local
        unlink($file);
    }
    return $uri;
}

function deleteArchivoCdn($fileName, $tipoArchivo) {
    $conn = getConnection();
    $containerName = getContainerName($tipoArchivo);
    $container = $conn->get_container($containerName);
    $object = $container->delete_object($fileName);
}

function getConnection() {
    require_once 'modulos/cdn/clases/cloudfiles.php';
    $username = "netor27";
    $api_key = "a4958be56757129de44332626cb0594b";
    $auth = new CF_Authentication($username, $api_key);
    $auth->authenticate();
    //Creamos una conexión
    //Si esta en el servidor con true
    //$conn = new CF_Connection($auth, TRUE);
    $conn = new CF_Connection($auth);
    return $conn;
}

function listContainers(){
    $conn = getConnection();
    $containers = $conn->list_containers_info();
    return $containers;
}

function getContainerName($tipoArchivo) {
    switch ($tipoArchivo) {
        case -1:
            return "imagenes";
            break;
        case 0:
            return "videos";
            break;
        case 1:
            return "presentaciones";
            break;
        case 2:
            return "documentos";
            break;
//        case 4:
//            return  "archivos";
//            break;
        default:
            return NULL;
            break;
    }
}

function getContainer($nombre){
    $conn = getConnection();
    $container = $conn->get_container($nombre);
    return $container;
}

?>
