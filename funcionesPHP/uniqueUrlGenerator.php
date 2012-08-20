<?php

function transformToUrlFriendly($titulo) {
    $uniqueUrl = $titulo;
    $uniqueUrl = str_replace("á", "a", $uniqueUrl);
    $uniqueUrl = str_replace("Á", "A", $uniqueUrl);
    $uniqueUrl = str_replace("é", "e", $uniqueUrl);
    $uniqueUrl = str_replace("É", "E", $uniqueUrl);
    $uniqueUrl = str_replace("í", "i", $uniqueUrl);
    $uniqueUrl = str_replace("Í", "I", $uniqueUrl);
    $uniqueUrl = str_replace("ó", "o", $uniqueUrl);
    $uniqueUrl = str_replace("Ó", "O", $uniqueUrl);
    $uniqueUrl = str_replace("ú", "u", $uniqueUrl);
    $uniqueUrl = str_replace("Ú", "U", $uniqueUrl);
    $uniqueUrl = preg_replace('/[^a-zA-Z0-9_.]/', "_", $uniqueUrl);
    return $uniqueUrl;
}

function getCursoUniqueUrl($titulo) {
    $uniqueUrl = transformToUrlFriendly($titulo);
    require_once 'modulos/cursos/modelos/CursoModelo.php';
    $aux = $uniqueUrl;    
    while (!elTituloEsUnico($aux)) {
        if (strlen($aux) > 95)
            $aux = substr($aux, 0, 95);
        $aux = $uniqueUrl . '_' . getUniqueCode(2);
    }

    return $uniqueUrl;
}

function getUsuarioUniqueUrl($userName) {
    $uniqueUrl = transformToUrlFriendly($userName);
    require_once 'modulos/usuarios/modelos/usuarioModelo.php';
    if (!elNombreUsuarioEsUnico($uniqueUrl)) {
        if (strlen($uniqueUrl) > 44)
            $uniqueUrl = substr($uniqueUrl, 0, 44);
        $uniqueUrl = $uniqueUrl . '_' . getUniqueCode(4);
    }
    return $uniqueUrl;
}

?>