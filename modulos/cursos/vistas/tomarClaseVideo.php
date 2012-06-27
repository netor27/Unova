<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headTomarClase.php');
?>
<script languague="javascript">
    function cargarElementosGuardados(){
<?php
$json = $clase->codigo;

$var = json_decode($json, true);
if (isset($var['textos'])) {
    $textos = $var['textos'];
    foreach ($textos as $texto) {
    ?>
                agregarTextoDiv( '<?php echo $texto['texto']; ?>','<?php echo $texto['inicio']; ?>','<?php echo $texto['fin']; ?>','<?php echo $texto['color']; ?>','<?php echo $texto['top']; ?>','<?php echo $texto['left']; ?>','<?php echo $texto['width']; ?>','<?php echo $texto['height']; ?>');
                        
    <?php
}
}
if (isset($var['imagenes'])) {
    $imagenes = $var['imagenes'];
    foreach ($imagenes as $imagen) {
    ?>
                agregarImagenDiv('<?php echo $imagen['urlImagen']; ?>','<?php echo $imagen['inicio']; ?>','<?php echo $imagen['fin']; ?>','<?php echo $imagen['color']; ?>','<?php echo $imagen['top']; ?>','<?php echo $imagen['left']; ?>','<?php echo $imagen['width']; ?>','<?php echo $imagen['height']; ?>');
    <?php
}
}
if (isset($var['videos'])) {
    $videos = $var['videos'];
    foreach ($videos as $video) {
    ?>
                agregarVideoDiv('<?php echo $video['urlVideo']; ?>','<?php echo $video['inicio']; ?>','<?php echo $video['fin']; ?>','<?php echo $video['color']; ?>','<?php echo $video['top']; ?>','<?php echo $video['left']; ?>','<?php echo $video['width']; ?>','<?php echo $video['height']; ?>');
    <?php
}
}
if (isset($var['links'])) {
    $links = $var['links'];
    foreach ($links as $link) {
    ?>
                agregarLinkDiv('<?php echo $link['texto']; ?>','<?php echo $link['url']; ?>','<?php echo $link['inicio']; ?>','<?php echo $link['fin']; ?>','<?php echo $link['color']; ?>','<?php echo $link['top']; ?>','<?php echo $link['left']; ?>','<?php echo $link['width']; ?>','<?php echo $link['height']; ?>');
    <?php
}
}
if (isset($var['videoData'])) {
    $videoData = $var['videoData'];
}





?>
    }
</script>
<?php
require_once('layout/headers/headCierre.php');
?>

</div>
<div style="z-index: 6;" >
    <video id="videoPrincipal" class="videoClass" style="position: relative; top: <?php echo $videoData['top'] . 'px'; ?>; left: <?php echo $videoData['left'] . 'px'; ?>; width: <?php echo $videoData['width'] . 'px'; ?>; height: <?php echo $videoData['height'] . 'px'; ?>;">
        <source src="<?php echo $clase->archivo; ?>" type="video/mp4"></source>      
        <source src="<?php echo $clase->archivo2; ?>" type="video/ogg"></source>      
    </video>  
    <div id="footnotediv">

    </div>
</div>

<?php
require_once('layout/foot.php');
?>