<?php
$json = $clase->codigo;

$var = json_decode($json, true);

$textos = $var['textos'];
$imagenes = $var['imagenes'];
$videos = $var['videos'];
$links = $var['links'];
$videoData = $var['videoData'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Editor de video</title>

        <script src="/js/jquery-1.7.1.min.js"></script>		
        <script src="/js/jquery-ui-1.8.17.custom.min.js"></script>
        <script src="/js/popcorn-complete.min.js"></script>

        <link rel="stylesheet" media="screen" type="text/css" href="/layout/css/colorpicker.css" />
        <script type="text/javascript" src="/js/colorpicker.js"></script>

        <script src="/lib/js/tiny_mce/jquery.tinymce.js"></script>

        <script src="/js/editorPopcorn/funciones.js"></script>

        <script src="/js/editorPopcorn/agregarImagen.js"></script>
        <script src="/js/editorPopcorn/agregarTexto.js"></script>
        <script src="/js/editorPopcorn/agregarVideo.js"></script>
        <script src="/js/editorPopcorn/agregarLink.js"></script>

        <script src="/js/editorPopcorn/cargarPopcorn.js"></script>

        <link type="text/css" href="/layout/css/redmond/jquery-ui-1.8.17.custom.css" rel="stylesheet" />	
        <link type="text/css" href="/layout/css/editorPopcorn.css" rel="stylesheet" />	

        <script language="javascript">

            function showHideControles(){
                $("#controlesContainer").toggle("slow");
                $(".toggleControles").toggle();
            }
        </script>

        <script languague="javascript">
            function cargarElementosGuardados(){
<?php foreach ($textos as $texto) { ?>
            try{
                cargarTextoEnArreglo( '<?php echo $texto['texto']; ?>','<?php echo $texto['inicio']; ?>','<?php echo $texto['fin']; ?>','<?php echo $texto['color']; ?>','<?php echo $texto['top']; ?>','<?php echo $texto['left']; ?>','<?php echo $texto['width']; ?>','<?php echo $texto['height']; ?>');
            }catch(err){
                console.log("ERROR -- "+err);
            }
    <?php
}
foreach ($imagenes as $imagen) {
    ?>
                try{
                    cargarImagenEnArreglo('<?php echo $imagen['urlImagen']; ?>','<?php echo $imagen['inicio']; ?>','<?php echo $imagen['fin']; ?>','<?php echo $imagen['color']; ?>','<?php echo $imagen['top']; ?>','<?php echo $imagen['left']; ?>','<?php echo $imagen['width']; ?>','<?php echo $imagen['height']; ?>');
                }catch(err){
                    console.log("ERROR -- "+err);
                }
    <?php
}
foreach ($videos as $video) {
    ?>
                try{
                    cargarVideoEnArreglo('<?php echo $video['urlVideo']; ?>','<?php echo $video['inicio']; ?>','<?php echo $video['fin']; ?>','<?php echo $video['color']; ?>','<?php echo $video['top']; ?>','<?php echo $video['left']; ?>','<?php echo $video['width']; ?>','<?php echo $video['height']; ?>');
                }catch(err){
                    console.log("ERROR -- "+err);
                }
    <?php
}
foreach ($links as $link) {
    ?>
                try{
                    cargarLinkEnArreglo('<?php echo $link['texto']; ?>','<?php echo $link['url']; ?>','<?php echo $link['inicio']; ?>','<?php echo $link['fin']; ?>','<?php echo $link['color']; ?>','<?php echo $link['top']; ?>','<?php echo $link['left']; ?>','<?php echo $link['width']; ?>','<?php echo $link['height']; ?>');
                }catch(err){
                    console.log("ERROR -- "+err);
                }
    <?php
}
?>
    }
        </script>

    </head>
    <body>
        <div id="modalDialog">

        </div>
        <div id="e-bar" class="ui-corner-left">
            <div id="top-bar">
                <a href="#" class="logo left" id="logo"> <img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
                <a href="/curso/<?php echo $curso->uniqueUrl; ?>" class="element right ease3">Salir</a>
                <a href="#" onclick="guardar(<?php echo $usuario->idUsuario . ",'" . $usuario->uuid . "'," . $idCurso . "," . $idClase; ?>)" class="element right ease3">Guardar</a>

            </div>
        </div>


        <div id="videoContainer" class="draggable resizable ui-widget-content" style="position: absolute; top: <?php echo $videoData['top'] . 'px'; ?>; left: <?php echo $videoData['left'] . 'px'; ?>; width: <?php echo $videoData['width'] . 'px'; ?>; height: <?php echo $videoData['height'] . 'px'; ?>;">				
            <video id="videoPrincipal" class="videoClass">
                <source src="<?php echo $clase->archivo; ?>" type="video/mp4">
                <source src="<?php echo $clase->archivo2; ?>" type="video/ogg">
            </video>
        </div>
        <div id="footnotediv">
        </div>

        <?php
        require_once 'modulos/editorPopcorn/vistas/formaAgregarTexto.php';
        require_once 'modulos/editorPopcorn/vistas/formaAgregarImagen.php';
        require_once 'modulos/editorPopcorn/vistas/formaAgregarVideo.php';
        require_once 'modulos/editorPopcorn/vistas/formaAgregarLink.php';
        ?>
        <div id="toolboxContainer">
            <div id="ShowHideToolbox" class="ui-state-hover ui-corner-all">
                <img class="showHideToolboxButton" src="/layout/imagenes/Agregar.png" >
                <img class="showHideToolboxButton" src="/layout/imagenes/AgregarMenos.png" style="display:none;">
            </div>
            <div id="toolbox" class="ui-state-highlight ui-corner-all" style="display:none;">                
                <a href="#" onClick="mostrarDialogoInsertarTexto()" title="Agregar texto" class="ui-corner-all">
                    <img src="/layout/imagenes/agregarTexto.png">
                </a><br>
                <a href="#"  onClick="mostrarDialogoInsertarImagen()" title="Agregar imagen" class="ui-corner-all">
                    <img src="/layout/imagenes/agregarImagen.png">
                </a><br>
                <a href="#" onClick="mostrarDialogoInsertarVideo()" title="Agregar video" class="ui-corner-all">
                    <img src="/layout/imagenes/agregarVideo.png">
                </a><br>
                <a href="#" onClick="mostrarDialogoInsertarLink()" title="Agregar página web" class="ui-corner-all">
                    <img src="/layout/imagenes/agregarPagina.png">
                </a>
            </div>
        </div>

        <div id="footer">
            <div id="ShowHideControles">
                <a  href="#" onclick="showHideControles()">
                    <div title="Mostrar controles" class="ui-state-default ui-corner-all littleBox toggleControles" style="display:none;">
                        >>
                    </div>
                    <div title="Ocultar controles"  class="ui-state-default ui-corner-all littleBox toggleControles" style="" >
                        <<
                    </div>
                </a>

            </div>
            <div id="controlesContainer" class="ui-widget-header ui-corner-all">	

                <div id="controles">
                    <a href="#" onclick="playVideo()" title="Play"  >
                        <div class="ui-state-default ui-corner-all littleBox" >
                            <span class="ui-icon ui-icon-play" style="float:left;margin: 0 4px;">
                                Play
                            </span>
                        </div>
                    </a>
                    <a href="#" onclick="pauseVideo()" title="Pause">
                        <div class="ui-state-default ui-corner-all littleBox">
                            <span class="ui-icon ui-icon-pause" style="float:left;margin: 0 4px;">
                                Pause
                            </span>
                        </div>
                    </a>
                </div>
                <div id="sliderContainer">

                    <div id="controlTiempo"></div>
                    <div id="slider"></div>
                </div>
            </div>
        </div>
    </body>
</html>

