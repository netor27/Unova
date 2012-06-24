<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headRedirigir.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <div class="centerText">
        <h2>Iniciando Sesión...</h2>
        Serás dirigido automáticamente en unos momentos.
        <br>
        En caso contrario, puedes acceder haciendo click <a href="<?php echo $pagina; ?>">Aquí</a></p>
    </div>
</div>

<?php
require_once('layout/foot.php');
?>
