<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headTomarClase.php');
?>
<script languague="javascript">
    function cargarElementosGuardados(){
<?php
$json = $clase->codigo;

$var = json_decode($json, true);

$textos = $var['textos'];
$imagenes = $var['imagenes'];
$videos = $var['videos'];
$links = $var['links'];
$videoData = $var['videoData'];

foreach ($textos as $texto) {
    ?>
            agregarTextoDiv( '<?php echo $texto['texto']; ?>','<?php echo $texto['inicio']; ?>','<?php echo $texto['fin']; ?>','<?php echo $texto['color']; ?>','<?php echo $texto['top']; ?>','<?php echo $texto['left']; ?>','<?php echo $texto['width']; ?>','<?php echo $texto['height']; ?>');
                
    <?php
}
foreach ($imagenes as $imagen) {
    ?>
                agregarImagenDiv('<?php echo $imagen['urlImagen']; ?>','<?php echo $imagen['inicio']; ?>','<?php echo $imagen['fin']; ?>','<?php echo $imagen['color']; ?>','<?php echo $imagen['top']; ?>','<?php echo $imagen['left']; ?>','<?php echo $imagen['width']; ?>','<?php echo $imagen['height']; ?>');
    <?php
}
foreach ($videos as $video) {
    ?>
                agregarVideoDiv('<?php echo $video['urlVideo']; ?>','<?php echo $video['inicio']; ?>','<?php echo $video['fin']; ?>','<?php echo $video['color']; ?>','<?php echo $video['top']; ?>','<?php echo $video['left']; ?>','<?php echo $video['width']; ?>','<?php echo $video['height']; ?>');
    <?php
}
foreach ($links as $link) {
    ?>
                agregarLinkDiv('<?php echo $link['texto']; ?>','<?php echo $link['url']; ?>','<?php echo $link['inicio']; ?>','<?php echo $link['fin']; ?>','<?php echo $link['color']; ?>','<?php echo $link['top']; ?>','<?php echo $link['left']; ?>','<?php echo $link['width']; ?>','<?php echo $link['height']; ?>');
    <?php
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