<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headSaldoUsuario.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <div>
        <h1>Mi cuenta en Unova</h1>
        <div class="whiteBox saldoBox" style="width: 90%; padding: 30px 0px 30px 10px;">
            <div class="left">
                <h3>Tu saldo actual es de 
                    <?php
                    if ($usuarioHead->saldo > 0) {
                        echo '<span class="cantidadPositiva"> $' . $usuarioHead->saldo . '</span>';
                    } else {
                        echo '<span class="cantidadNegativa"> $' . $usuarioHead->saldo . '</span>';
                    }
                    ?>
                </h3>
            </div>

            <div class="right">
                <a class="blueButton" style="font-size: 30px; margin: 20px;" href="/usuarios/saldo/recargar">Recargar Saldo</a>
            </div>
        </div>

    </div>
</div>

<?php
require_once('layout/foot.php');
?>