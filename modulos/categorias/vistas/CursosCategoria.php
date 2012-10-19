<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headBusqueda.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">
    <div class="cursosContainer">
        <h1><?php echo $categoria->nombre; ?></h1>
        <?php if (isset($cursos)) { ?>
            <h3>Total de cursos en esta categoría: <?php echo $numCursos; ?> </h3>
            <div class="busquedaPager">
                <?php
                for ($i = 1; $i <= $numPaginas; $i++) {
                    if ($i == $pagina) {
                        echo '<span >' . $i . '</span>';
                    } else {
                        echo '<a href="/categoria/' . $categoriaUrl . '/' . $i . '" >' . $i . '</a>';
                    }
                }
                ?>
            </div>
            <ul>
                <?php
                foreach ($cursos as $curso) {
                    ?>
                    <li>
                        <a href="/curso/<?php echo $curso->uniqueUrl; ?>"><div class="thumb" style="background: url(<?php echo $curso->imagen; ?>);"></div></a>
                        <div class="detalles">                        
                            <a href="/curso/<?php echo $curso->uniqueUrl; ?> "> <?php echo $curso->titulo; ?> </a>
                            <span class="precio">
                                <?php
                                if ($curso->precio > 0)
                                    echo '$' . $curso->precio;
                                else
                                    echo 'Gratis';
                                ?>
                            </span>
                            <br><span class="autor"> Hecho por <a href="/usuario/<?php echo $curso->uniqueUrlUsuario; ?>"><?php echo $curso->nombreUsuario; ?></a></span>
                            <br><span class="descripcionCorta"><?php echo $curso->descripcionCorta; ?></span>                                            

                            <br><span class="keywords">Palabras clave:
                                <?php
                                $keywords = explode(",", $curso->keywords);
                                foreach ($keywords as $keyword) {
                                    echo '<a href="/busqueda.php?q=' . trim($keyword) . '">' . trim($keyword) . '</a>';
                                }
                                ?>
                            </span>
                        </div>                        
                        <div class="numDetalles numAlumnos">                    
                            <?php echo $curso->numeroDeAlumnos; ?>
                            <span>Alumnos</span>
                        </div>
                        <div class="numDetalles numClases">
                            <?php echo $curso->numeroDeClases; ?>
                            <span>Clases</span>
                        </div>
                    </li>
                    <?php
                }
            } else {
                if (isset($pagina) && $pagina != 1) {
                    echo '<li><h2 class="error">Ya no hay más resultados</h2></li>';
                } else {
                    echo '<li><h2 class="notice">No hay cursos en esta categoría</h2></li>';
                    echo '<div style="text-align: center;" class="whiteBox">';
                    echo '<a href="/cursos/curso/crearCurso"><h2>Agrega un curso a esta categoria</h2></a>';
                    echo '</div>';
                    echo '<h3>Ayúdanos llenando una Encuesta</h3>
                            <div style="margin-left: 100px;">
                                <iframe src="https://docs.google.com/a/unova.mx/spreadsheet/embeddedform?formkey=dGQwRG5wWDVsNlBmZjNDOEVKb3VxMFE6MQ" width="400" height="500" frameborder="1" marginheight="20" marginwidth="50">Cargando...</iframe>
                            </div>';
                }
            }
            ?>
        </ul>
        <div class="busquedaPager">
            <?php
            for ($i = 1; $i <= $numPaginas; $i++) {
                if ($i == $pagina) {
                    echo '<span >' . $i . '</span>';
                } else {
                    echo '<a href="/categoria/' . $categoriaUrl . '/' . $i . '" >' . $i . '</a>';
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
require_once('layout/foot.php');
?>
            