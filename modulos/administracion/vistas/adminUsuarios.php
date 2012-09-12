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
                        Usuarios
                    </td>
                    <td colspan="5" class="filter">
                        Filtrar: <input id="filterBoxOne" value="" maxlength="30" size="30" type="text" />
                        <img id="filterClearOne" src="/lib/js/jqueryTableSorter/img/cross.png" title="Click to clear filter." alt="Clear Filter Image" />
                    </td>
                </tr> 	
                <tr>
                    <th><a  title="Click Header to Sort">Nombre Usuario</a></th>
                    <th><a  title="Click Header to Sort">Email</a></th>
                    <th><a  title="Click Header to Sort">Fecha Registro</a></th>
                    <th><a  title="Click Header to Sort">Cursos de este usuario</a></th>
                    <th><a  title="Click Header to Sort">Cursos que toma</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($usuarios as $usuario) {
                    echo '<tr>';
                    echo '<td><a href="/usuario/' . $usuario->uniqueUrl . '" >'.$usuario->nombreUsuario.'</a></td>';
                    echo '<td>'.$usuario->email.'</td>';
                    echo '<td>'. $usuario->fechaRegistro.'</td>';
                    echo '<td style="text-align:center;"><a href="/administracion/usuarios/cursosInstructor/' . $usuario->idUsuario .'">Ver</a></td>';
                    echo '<td style="text-align:center;"><a href="/administracion/usuarios/cursosAlumno/' . $usuario->idUsuario .'">Ver</a></td>';
                    echo '</tr>';
                }
                ?>

            </tbody>
            <tfoot>
                <tr id="pagerOne">
                    <td colspan="5">
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
