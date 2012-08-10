<?php

function transformar($datosJson) {
    $datos = json_decode($datosJson);

    $idClase = $datos->idClase;
    $file = $datos->file;
    $fileType = $datos->fileType;

    require_once 'modulos/videos/modelos/transformador.php';
    
    $res = transformarArchivo($file);
    if ($res['return_var'] == 0) {
        $archivoMp4 = $res['outputFileMp4'];
        $archivoOgv = $res['outputFileOgv'];
        $duration = $res['duration'];
        
        //Hay que subir los dos archivos al CDN
        require_once 'modulos/cdn/modelos/cdnModelo.php';
        $tipoVideo = 0;

        //Subimos al cdn el archivo mp4
        $path = pathinfo($archivoMp4);
        $fileNameMp4 = $path['basename'];
        //putLog("Subiendo al CDN el archivo mp4 -> " . $archivoMp4);
        $uriMp4 = crearArchivoCDN($archivoMp4, $fileNameMp4, $tipoVideo);

        //Subimos al cdn el archivo ogv
        $path = pathinfo($archivoOgv);
        $fileNameOgv = $path['basename'];
  
        $uriOGV = crearArchivoCDN($archivoOgv, $fileNameOgv, $tipoVideo);

        require_once 'modulos/cursos/modelos/ClaseModelo.php';

        actualizaArchivosDespuesTransformacion($idClase, $uriMp4, $uriOGV);
        actualizaDuracionClase($idClase, $duration);
        
        //enviar emai de aviso
        $curso = getCursoPerteneciente($idClase);
        require_once 'modulos/cursos/modelos/CursoModelo.php';
        $usuario = getUsuarioDeCurso($curso->idCurso);
        require_once 'modulos/email/modelos/envioEmailModelo.php';
        $clase = getClase($idClase);
        enviarMailTransformacionVideoCompleta($usuario->email, $curso->titulo, $clase->titulo, 'www.unova.mx/curso/' . $curso->uniqueUrl);
        return true;
    } else {
        //putLog("ERROR transformando a mp4 y ogv. ERROR = " . $res['return_var']);
        return false;
    }
}
?>