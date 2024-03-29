<?php
require_once ('layout/headers/headInicio.php');
require_once ('layout/headers/headListaCursos.php');
require_once ('layout/headers/headCierre.php');
?>


<div class="contenido">
    
    <div class="cursosContainer">
        <h1 class="left">Cursos de los que soy instructor</h1>
        <br><br>
        <a href="/cursos/curso/crearCurso" class="blueButton right">Crear un curso</a>
        <a href="/usuarios/cursos/responderPreguntas" class="blueButton right" style="margin-right: 5px;">Responder las preguntas pendientes</a>
        <br><br>
        <ul>
            <?php
            if (isset($cursos) && !is_null($cursos)) {
                foreach ($cursos as $curso) {
                    ?>
                    <li>
                        <a href="/curso/<?php echo $curso->uniqueUrl; ?>"><div class="thumb" style="background: url(<?php echo $curso->imagen; ?>);"></div></a>
                        <div class="detalles">
                            <?php
                            echo '<a href="/curso/' . $curso->uniqueUrl . '">' . $curso->titulo . '</a>';
                            echo '<br><br><span class="publicado">';
                            if ($curso->publicado == 1)
                                echo 'Publicado';
                            else
                                echo 'No publicado';
                            echo '</span><span> - </span><span class="precio">';

                            if ($curso->precio > 0)
                                echo "$" . $curso->precio;
                            else
                                echo "Gratis";
                            echo "</span>";
                            ?>                    
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
            }else {
                echo '<li><h2>No has creado ningún curso</h2></li>';
            }
            ?>
        </ul>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>
