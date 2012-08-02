<?php
require_once 'modulos/pagos/modelos/operacionModelo.php';
require_once 'funcionesPHP/funcionesGenerales.php';

$operaciones = getUltimasOperacionesPorUsuario(20,3);
$operaciones = array_reverse($operaciones);
?>

<table>
    <tr>
        <td>IdOperacion</td>
        <td>tipo</td>
        <td>usuario</td>
        <td>fecha</td>
        <td>detalle</td>
        <td>cantidad</td>
    </tr>

    <?php
    foreach ($operaciones as $operacion) {
        echo '<tr>';
        echo '<td>'.$operacion->idOperacion.'</td>';
       
        echo '<td>'.getTipoOperacion($operacion->idTipoOperacion).'</td>';
        echo '<td>'.$operacion->idUsuario.'</td>';
        echo '<td>'.$operacion->fecha.'</td>';
        echo '<td>'.$operacion->detalle.'</td>';
        echo '<td>'.$operacion->cantidad.'</td>';
        echo '</tr>';
    }
    ?>

</table>
