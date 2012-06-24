<?php

function transformar() {
    $idClase = $_POST['idClase'];
    $file = $_POST['file'];

    require_once 'funcionesPHP/LogFile.php';
    //putLog("================== Inicio de transformación de video =============");

    require_once 'modulos/videos/modelos/transformador.php';

    // lo transformamos primero a mp4
   //  putLog("Transformando...");
    // putLog($file);
    $res = transformarArchivo($file);
    if ($res['return_var'] == 0) {
       //  putLog("Transformado a mp4 y ogv correctamente");
        $archivoMp4 = $res['outputFileMp4'];
        $archivoOgv = $res['outputFileOgv'];
        $duration = $res['duration'];
        

        //Hay que subir los dos archivos al CDN
        require_once 'modulos/cdn/modelos/cdnModelo.php';
        $tipoVideo = 0;

        //Subimos al cdn el archivo mp4
        $path = pathinfo($archivoMp4);
        $fileNameMp4 = $path['basename'];
        // putLog("Subiendo al CDN el archivo mp4 -> " . $archivoMp4);
        $uriMp4 = crearArchivoCDN($archivoMp4, $fileNameMp4, $tipoVideo);
        
//        if ($uriMp4 != NULL)
//            putLog("archivo mp4 subido correctamente");
//        else
//            putLog("ERROR al subir el archivo mp4");

        //Subimos al cdn el archivo ogv
        $path = pathinfo($archivoOgv);
        $fileNameOgv = $path['basename'];
        // putLog("Subiendo al CDN el archivo ogv -> " . $archivoOgv);
        
        $uriOGV = crearArchivoCDN($archivoOgv, $fileNameOgv, $tipoVideo);
//        if ($uriOGV != NULL)
//            putLog("archivo ogv subido correctamente");
//        else
//            putLog("ERROR al subir el archivo ogv");

        require_once 'modulos/cursos/modelos/ClaseModelo.php';
        // putLog("Actualizando BD..");
        actualizaArchivosDespuesTransformacion($idClase, $uriMp4, $uriOGV);
        actualizaDuracionClase($idClase, $duration);
        // putLog("BD actualizada");
        //enviar emai de aviso
        
        $curso = getCursoPerteneciente($idClase);
        require_once 'modulos/cursos/modelos/CursoModelo.php';
        $usuario = getUsuarioDeCurso($curso->idCurso);
        require_once 'modulos/email/modelos/envioEmailModelo.php';
        $clase = getClase($idClase);
        
        
        enviarMailTransformacionVideoCompleta($usuario->email,$curso->titulo,$clase->titulo,'www.unova.mx/curso/'.$curso->uniqueUrl);
        // putLog("Se envió el correo a " . $usuario->email);
        // putLog("================== Fin de transformación de video ================");
        
    } else {
        // putLog("ERROR transformando a mp4 y ogv. ERROR = " . $res['return_var']);
    }
}
?>

