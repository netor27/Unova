<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headTableSorter.php');
require_once('layout/headers/headSolicitudesSaldo.php');
require_once('layout/headers/headCierre.php');
?>
<div class="contenido">
    <div style="padding:0px 0px 30px 30px;">  
        <form action="/administracion/saldos/generarArchivoCsv" method="post">
            <table id="tableOne" class="yui" style="width:100%">    
                <thead>
                    <tr>
                        <td class="tableHeader">
                            Solicitudes de retiro de saldo
                        </td>
                        <td colspan="6" class="filter">
                            Filtrar: <input id="filterBoxOne" value="" maxlength="30" size="30" type="text" />
                            <img id="filterClearOne" src="/lib/js/jqueryTableSorter/img/cross.png" title="Click to clear filter." alt="Clear Filter Image" />
                        </td>
                    </tr> 	
                    <tr>
                        <th><a  title="Click Header to Sort">Usuario</a></th>
                        <th><a  title="Click Header to Sort">Fecha de solicitud</a></th>
                        <th><a  title="Click Header to Sort">Email Paypal</a></th>
                        <th><a  title="Click Header to Sort">Cantidad por entregar</a></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($solicitudesDeSaldo as $solicitud) {
                        echo '<tr>';
                        echo '<td><a href="/usuario/' . $solicitud->uniqueUrl . '" >' . $solicitud->nombreUsuario . '</a></td>';
                        echo '<td>' . $solicitud->fechaSolicitud . '</td>';
                        echo '<td>' . $solicitud->emailPaypal . '</td>';
                        echo '<td id="cantidad_' . $solicitud->idSolicitudSaldo . '">$' . $solicitud->cantidad . '</td>';
                        echo '<td><input id="' . $solicitud->idSolicitudSaldo . '" class="solicitud_checkbox" type="checkbox" name="idSolicitud[]" value="' . $solicitud->idSolicitudSaldo . '"></td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>
                <tfoot>
                    <tr id="pagerOne">
                        <td colspan="6">
                            <img src="/lib/js/jqueryTableSorter/img/first.png" class="first"/>
                            <img src="/lib/js/jqueryTableSorter/img/prev.png" class="prev"/>
                            <input type="text" class="pagedisplay"/>
                            <img src="/lib/js/jqueryTableSorter/img/next.png" class="next"/>
                            <img src="/lib/js/jqueryTableSorter/img/last.png" class="last"/>
                            <select class="pagesize">
                                <option value="10">10</option>
                                <option selected="selected" value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <br><br>
            <a id="toggle_checkbox" class="blueButton right selected">Seleccionar todos</a>
            <br><br><br>
            <input class="right" type="submit" name="submit" onclick="return validarTotal()" value ="Generar archivo .csv">
        </form>
    </div>   
</div>
<?php
require_once('layout/foot.php');
?>
