<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headTableSorter.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <div style="padding:0px 0px 30px 30px;">                
        <table id="tableOne" class="yui" style="width:100%">    
            <thead>
                <tr>
                    <td class="tableHeader">
                        Cursos
                    </td>
                    <td colspan="7" class="filter">
                        Filtrar: <input id="filterBoxOne" value="" maxlength="30" size="30" type="text" />
                        <img id="filterClearOne" src="/lib/js/jqueryTableSorter/img/cross.png" title="Click to clear filter." alt="Clear Filter Image" />
                    </td>
                </tr> 	
                <tr>
                    <th><a  title="Click Header to Sort">Título</a></th>
                    <th><a  title="Click Header to Sort">Fecha Creación</a></th>
                    <th><a  title="Click Header to Sort">Fecha Publicación</a></th>
                    <th><a  title="Click Header to Sort">Precio</a></th>
                    <th><a  title="Click Header to Sort">Rating</a></th>
                    <th><a  title="Click Header to Sort">Total Views</a></th>
                    <th><a  title="Click Header to Sort">Total Reportes</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($cursos as $curso) {
                    echo '<tr>';
                    echo '<td><a href="/curso/' . $curso->uniqueUrl . '" >'.$curso->titulo.'</a></td>';
                    echo '<td>'. $curso->fechaCreacion . '</td>';
                    if($curso->publicado == 1)
                        echo '<td>'. $curso->fechaPublicacion . '</td>';
                    else
                        echo '<td>No publicado</td>';
                    echo '<td>'. $curso->precio . '</td>';
                    echo '<td>'. $curso->rating . '</td>';
                    echo '<td>'. $curso->totalViews . '</td>';
                    echo '<td>'. $curso->totalReportes . '</td>';
                    echo '</tr>';
                }
                ?>

            </tbody>
            <tfoot>
                <tr id="pagerOne">
                    <td colspan="7">
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
