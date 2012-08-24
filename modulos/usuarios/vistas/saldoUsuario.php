<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headSaldoUsuario.php');
require_once('layout/headers/headCierre.php');
?>
<script>
    $maxSaldo = <?php echo $usuario->saldo; ?>;
    $offset = <?php echo $numOperaciones; ?>;
</script>
<div class="contenido">
    <div>
        <h1 class="left">Mi cuenta en Unova</h1>
        <br>
        <?php
        if ($usuarioHead->saldo > 0) {
            ?>
            <div class="right">
                <a id="btnRetirarSaldo" class="blueButton">Retirar saldo</a>
            </div>
            <?php
        }
        ?>
        <div class="whiteBox saldoBox" style="width: 98%; padding: 30px 0px 30px 10px;text-align: center;">
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
    <div id="modalDialogRetirarSaldo" title="Retirar saldo">
        <div>
            <form method="post" action="/usuarios/saldo/retirarSaldoSubmit">
                <p>
                    <label for="amount">Cantidad a retirar:</label>
                    <input type="text" name="cantidad" id="cantidad" style="border:0; color:#f6931f; font-weight:bold;" value="10"/>
                </p>
                <div id="slider-range-min"></div>
                <br>
                <input class="right" type="submit" value="  Aceptar ">
            </form>
        </div><br><br><br><br>
        <h3>-Tu saldo será abonado a tu cuenta de paypal asociada con tu correo electrónico</h3>
        <h3>-La solicitud será resuelta en un lapso no mayor a 3 días hábiles</h3>
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
                <tbody id="tableBodyOperaciones">

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
        <a style="padding-left: 5px;" id="mostrarMasOperaciones">Ver operaciones anteriores</a>
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