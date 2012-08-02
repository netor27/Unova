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
    <h2>Últimas operaciones</h2>
    <div class="OperacionesContainer">
        <table class="OperacionesTable" cellpadding="5" cellspacing="5" >
            <thead>
                <tr class="OperacionesTableHeader">
                    <th style="width: 20%">Fecha</th>
                    <th style="width: 20%">Tipo de operaci&oacute;n</th>                                                
                    <th style="width: 40%">Detalles de la operaci&oacute;n</th>
                    <th style="width: 20%" colspan="2">Cantidad</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $operacionPositiva;
                $i = 0;
                foreach ($operaciones as $operacion) {
                    if ($i % 2 == 0)
                        echo '<tr class="par">';
                    else
                        echo '<tr class="non">';
                    if (operacionEsPositiva($operacion->idTipoOperacion)) {

                        echo '<td class="operacionFecha">' . $operacion->fecha . '</td>';
                        echo '<td class="operacionTipo cantidadPositiva">' . getTipoOperacion($operacion->idTipoOperacion) . '</td>';
                        echo '<td class="operacionDetalle">' . $operacion->detalle . '</td>';
                        echo '<td class="cantidadPositiva">$' . $operacion->cantidad . '</td>';
                        echo '<td ></td>';
                    } else {
                        echo '<td class="operacionFecha">' . $operacion->fecha . '</td>';
                        echo '<td class="operacionTipo cantidadNegativa">' . getTipoOperacion($operacion->idTipoOperacion) . '</td>';
                        echo '<td class="operacionDetalle">' . $operacion->detalle . '</td>';
                        echo '<td></td>';
                        echo '<td class="cantidadNegativa">- $' . $operacion->cantidad . '</td>';
                    }
                    echo '</tr>';
                    $i++;
                }
                ?>

            </tbody>
        </table>
    </div>


</div>

<?php
require_once('layout/foot.php');
?>