<?php

error_reporting(E_ALL | E_STRICT);

require_once 'funcionesPHP/funcionesGenerales.php';

require('lib/php/jqueryFileUpload/upload.class.php');

$upload_handler = new UploadHandler();

header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Content-Disposition: inline; filename="files.json"');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        break;
    case 'HEAD':
    case 'GET':
        $upload_handler->get();
        break;
    case 'POST':
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            $upload_handler->delete();
        } else {
            if (isset($_POST['uuid']) && isset($_POST['idUsuario']) && isset($_POST['idCurso']) && isset($_POST['idTema'])) {
                $info = $upload_handler->post();
                $file = $info[0];
                $uuid = $_POST['uuid'];
                $idUsuario = $_POST['idUsuario'];
                $idCurso = $_POST['idCurso'];
                $idTema = $_POST['idTema'];

                $clase = crearClase($idUsuario, $idCurso, $uuid, $idTema, $file->name, $file->type);
                if (!is_null($clase)) {
                    $file->url = urlencode($clase->archivo);
                    $file->delete_url = "#";
                    $info[0] = $file;
                    writeJSON($info);                    
                } else {
                    echo 'error';
                }
            }
        }
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
}

function crearClase($idUsuario, $idCurso, $uuid, $idTema, $fileName, $fileType) {
    require_once 'modulos/cursos/clases/Clase.php';
    require_once 'modulos/cursos/modelos/ClaseModelo.php';
    require_once 'modulos/usuarios/modelos/usuarioModelo.php';
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    require_once 'modulos/cursos/modelos/TemaModelo.php';
    $filePath = "archivos/temporal/uploaderFiles/";

    if (getIdUsuarioDeCurso($idCurso) == $idUsuario && getIdUsuarioFromUuid($uuid) == $idUsuario && $idCurso == getIdCursoPerteneciente($idTema)) {
        //Validamos que el curso sea del usuario, que el uuid pertenezca a este usuario y que el tema sea del curso        
        $clase = new Clase();
        $clase->idTema = $idTema;
        //Revisamos que el nombre del archivo no pase de 50 caractéres
        if (strlen($fileName) > 45) {
            $auxFileName = substr($fileName, 0, 50);
            if (!rename($filePath . $fileName, $filePath . $auxFileName)) {
                //Ocurrió un error al renombrar el archivo
                die('Ocurrió un error al subir el archivo');
            }
            $fileName = $auxFileName;
        }


        $clase->titulo = $fileName;
        $clase->idTipoClase = getTipoClase($fileType);

        if ($clase->idTipoClase == 0) {
            $clase->transformado = 0;
            $idClase = altaClase($clase);
            //Si es video creamos la clase con la bandera que todavía no se transforma
            //hacemos un llamado asincrono para transformarlo
            require_once 'funcionesPHP/AsyncPost.php';
            $url = "http://localhost/videos.php";
            $file = $filePath . $fileName;
            $params = array(
                "idClase"  => $idClase,
                "file"     => $file,
                "fileType" => $fileType
            );
            curl_post_async($url, $params);
            return $clase;
        } else {
            $clase->transformado = 1;
            //Si es de otro tipo, lo subimos al CDN de rackspace y creamos la clase
            require_once 'modulos/cdn/modelos/cdnModelo.php';
            $file = $filePath . $fileName;

            //Le agregamos al nombre del archivo un codigo aleatorio de 5 caracteres
            $fileName = getUniqueCode(15) . "_" . $fileName;
            
            $uri = crearArchivoCDN($file, $fileName, $clase->idTipoClase);

            if ($uri != NULL) {
                //Si se creo correctamene el archivo CDN, creamos la clase y borramos el archivo local
                $clase->archivo = $uri;
                altaClase($clase);                
                return $clase;
            } else {
                //Si ocurrió un error, se borra y regresamos false
                unlink($file);
                return NULL;
            }
        }
    } else {
        //Hay errores en la integridad usuario <-> curso
        //borramos el archivo
        unlink("archivos/temporal/uploaderFiles/" . $fileName);
        return NULL;
    }
}

function getTipoClase($fileType) {
    //Si es video
    if (stristr($fileType, "video")) {
        return 0;
    }

    if (stristr($fileType, "presentation") || stristr($fileType, "powerpoint")) {
        return 1;
    }

    if (stristr($fileType, "word") || stristr($fileType, "pdf")) {
        return 2;
    }
}

function writeJSON($info) {
    header('Vary: Accept');
    $json = json_encode($info);
    $redirect = isset($_REQUEST['redirect']) ?
            stripslashes($_REQUEST['redirect']) : null;
    if ($redirect) {
        header('Location: ' . sprintf($redirect, rawurlencode($json)));
        return;
    }
    if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
        header('Content-type: application/json');
    } else {
        header('Content-type: text/plain');
    }
    echo $json;
}