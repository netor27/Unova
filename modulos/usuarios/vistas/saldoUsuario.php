<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headSaldoUsuario.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <div>
        <h1>Mi cuenta en Unova</h1>
        <div class="whiteBox saldoBox" style="width: 90%; padding: 30px 0px 30px 10px;text-align: center;">
            <div class="left" style="width:50%;">
                <h3>Tu saldo actual es de <br>
                    <?php
                    if ($usuarioHead->saldo > 0) {
                        echo '<span class="cantidadPositiva"> $' . $usuarioHead->saldo . '</span>';
                    } else {
                        echo '<span class="cantidadNegativa"> $' . $usuarioHead->saldo . '</span>';
                    }
                    ?>
                </h3>
            </div>
            <div class="left blueBox" style="width:45%; margin: 0px; ">                
                <h3>Recargar Saldo</h3>
                <div style="margin-bottom:10px;">
                    <label>Cantidad a Recargar:</label>
                    $<input type="text" id="cantidadRecargar" value="50" style="width:50px; margin-left:20px; padding-left: 10px;">
                    <br>
                    <button id="botonRecargar">Aceptar</button>
                </div>
            </div>
        </div>

    </div>

    <h2>Últimas operaciones</h2>
    <div class="OperacionesContainer">

        <?php
        if (isset($operaciones)) {
            ?>


            <table class="OperacionesTable" cellpadding="5" cellspacing="5" >
                <thead>
                    <tr class="OperacionesTableHeader">
                        <th style="width: 20%">Fecha</th>
                        <th style="width: 20%">Tipo de operaci&oacute;n</th>                                                
                        <th style="width: 40%">Detalles de la operaci&oacute;n</th>
                        <th style="width: 20%;padding-left: 5%;" colspan="2">Cantidad</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $i = 0;
                    foreach ($operaciones as $operacion) {
                        if ($i % 2 == 0)
                            echo '<tr class="par">';
                        else
                            echo '<tr class="non">';
                        if (operacionEsPositiva($operacion->idTipoOperacion)) {

                            echo '<td class="operacionFecha">' . transformaMysqlDateDDMMAAAAConHora($operacion->fecha) . '</td>';
                            echo '<td class="operacionTipo cantidadPositiva">' . getTipoOperacion($operacion->idTipoOperacion) . '</td>';
                            echo '<td class="operacionDetalle">' . $operacion->detalle . '</td>';
                            echo '<td class="cantidadPositiva">$' . $operacion->cantidad . '</td>';
                            echo '<td ></td>';
                        } else {
                            echo '<td class="operacionFecha">' . transformaMysqlDateDDMMAAAAConHora($operacion->fecha) . '</td>';
                            echo '<td class="operacionTipo cantidadNegativa">' . getTipoOperacion($operacion->idTipoOperacion) . '</td>';
                            echo '<td class="operacionDetalle">' . $operacion->detalle . '</td>';
                            echo '<td></td>';
                            echo '<td class="cantidadNegativa" >- $' . $operacion->cantidad . '</td>';
                        }
                        echo '</tr>';
                        $i++;
                    }
                    ?>

                </tbody>
            </table>

            <?php
        } else {
            ?>
            <h3 style="padding-left: 30px; color:black;">No hay registros</h3>
            <?php
        }
        ?>
    </div>

</div>

<?php
require_once('layout/foot.php');
?>