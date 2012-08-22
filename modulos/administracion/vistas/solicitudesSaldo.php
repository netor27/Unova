<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headTableSorter.php');
require_once('layout/headers/headCierre.php');
?>
<script type="text/javascript">
    var doConfirm = function()
    {
        if(confirm("Estas seguro de establecer la solicitud como pagada?"))
            return true;
        else
            return false;
    }
</script>
<div class="contenido">
    <div style="padding:0px 0px 30px 30px;">                
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
                    <th><a href='#' title="Click Header to Sort">Usuario</a></th>
                    <th><a href='#' title="Click Header to Sort">Fecha de solicitud</a></th>
                    <th><a href='#' title="Click Header to Sort">Email</a></th>
                    <th><a href='#' title="Click Header to Sort">Cantidad por entregar</a></th>
                    <th><a href='#' title="Click Header to Sort"></a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($solicitudesDeSaldo as $solicitud) {
                    echo '<tr>';
                    echo '<td><a href="/usuario/' . $solicitud->uniqueUrl . '" >' . $solicitud->nombreUsuario . '</a></td>';
                    echo '<td>' . $solicitud->fechaSolicitud . '</td>';
                    echo '<td>' . $solicitud->email . '</td>';
                    echo '<td>$' . $solicitud->cantidad . '</td>';
                    echo '<td><a onclick="return doConfirm();" href="/administracion/saldos/solicitudPagada/' . $solicitud->idSolicitudSaldo . '">Solicitud pagada con éxito</a></td>';
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
                            <option selected="selected"  value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                        </select>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>   
</div>
<?php
require_once('layout/foot.php');
?>
