<?php

function putLog($msg) {
    if ($fh = fopen($_SERVER['DOCUMENT_ROOT'] . '/log/log.txt', 'a+')) {
        $msg = '[' . date('d-m-Y H:i:s') . ']' . $msg . "\r"; //backslash r backslach n
        fputs($fh, $msg, strlen($msg));
        fclose($fh);
        return true;
    } else {
        return false;
    }
}

?>