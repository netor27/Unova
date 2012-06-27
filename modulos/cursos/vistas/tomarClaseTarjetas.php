<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">         
    <div id="cursoHeader">
        <h1><?php echo $clase->titulo; ?></h1>
        <h4><?php echo $clase->descripcion; ?></h4>
    </div>

    <div id="cursoTabs">
        <h3>Aquí se toma la clase de tarjetas</h3>
    </div>

</div>
<?php
require_once('layout/foot.php');
?>