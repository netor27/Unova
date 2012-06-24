<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headTomarClase.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">         
    <div id="cursoHeader">
        <h1><?php echo $clase->titulo; ?></h1>
        <h4><?php echo $clase->descripcion; ?></h4>
    </div>

    <div id="cursoTabs">
        <h2>Descarga el archivo con el siguiente link</h2>
        <h3><?php echo '<a style="text-decoration: underline;" href="' . $clase->archivo . '">' . $clase->titulo . '</a>'; ?></h3>
    </div>

</div>
<?php
require_once('layout/foot.php');
?>