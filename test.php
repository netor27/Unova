<?php

$file = "/home/neto/VideoIpod3Sec.MOV";
ob_start();
passthru('ffmpeg -i "' . $file . '" 2>&1');
$duration = ob_get_contents();
ob_end_clean();

echo $duration;
$search = '/Duration: (.*?),/';
$duration = preg_match($search, $duration, $matches, PREG_OFFSET_CAPTURE);
$duration = $matches[1][0];

echo '<br><br><br>==============================';
print_r($duration);
echo '<br><br><br>==============================';
list($hours, $mins, $secs) = explode(':', $duration);
$mins = $mins + ($hours * 60);
$secs = substr($secs, 0, 2);
$duration = $mins . ":" . $secs;
echo '<br><br><br>==============================';
echo '<br><br><br>==============================';
echo '<br><br><br>==============================';
echo $duration;
?>