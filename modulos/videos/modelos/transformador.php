<?php

/**
 * Description of transformador
 *
 * @author neto
 * 
 */
function transformarArchivo($file) {
    $return_var = -1;

    //Obtener la duración
    ob_start();
    passthru('ffmpeg -i "' . $file . '" 2>&1');
    $duration = ob_get_contents();
    ob_end_clean();
    
    //putLog($duration);
    $search = '/Duration: (.*?),/';
    $duration = preg_match($search, $duration, $matches, PREG_OFFSET_CAPTURE);
    $duration = $matches[1][0];
    list($hours, $mins, $secs) = split('[:]', $duration);
    $mins = $mins + ($hours * 60);    
    $secs = substr($secs, 0, 2);
    $duration = $mins . ":" . $secs;
    //putLog($duration);
    $pathInfo = pathinfo($file);
    $uniqueCode = getUniqueCode(15);
    $outputFile = $pathInfo['dirname'] . "/" . $uniqueCode . "_" . $pathInfo['filename'] . ".mp4";
    $outputFileOgv = $pathInfo['dirname'] . "/" . $uniqueCode . "_" . $pathInfo['filename'] . "OGV.ogv";
    $cmd = 'ffmpeg -i "' . $file . '" "' . $outputFile . '";';
    $cmd = $cmd . 'ffmpeg2theora -o "' . $outputFileOgv . '" "' . $outputFile . '"';
    //putLog($cmd);
    system($cmd, $return_var);
    if ($return_var == 0) {
        unlink($file);
    }
    return array("return_var" => $return_var, "duration" => $duration, "outputFileMp4" => $outputFile, "outputFileOgv" => $outputFileOgv);
}

?>
