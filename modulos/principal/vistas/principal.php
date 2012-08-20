<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headIndex.php');
require_once('layout/headers/headSocialMedia.php');
require_once('layout/headers/validarRespuestaPreguntas.php');
require_once('layout/headers/headCierre.php');
?>
<div class="contenido">    
    <div class="left" style="width: 700px">      
        <div  style="text-align: center;">
            <h1>Unova Beta</h1>   
        </div>
        <div>
            <p>En esta versión se pueden crear los cursos, agregar las clases de videos y documentos</p>
            <p>Estamos trabajando en el módulo de cobros en línea, mientras está listo, no podrás establecerle precio a tus cursos</p>
            </div>
        <div>
            <?php if (isset($cursos)) { ?>
                <h3>Cursos mejor puntuados </h3>
                <ul id="pageMe">
                    <?php
                    foreach ($cursos as $curso) {
                        ?>
                        <li class="whiteBox">
                            <a href="/curso/<?php echo $curso->uniqueUrl; ?>"><div class="thumb" style="background: url(<?php echo $curso->imagen; ?>);"></div></a>
                            <div class="detalles" style="width: 350px;">                        
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
                                <br><span class="keywords">Palabras clave:
                                    <?php
                                    $keywords = explode(",", $curso->keywords);
                                    foreach ($keywords as $keyword) {
                                        echo '<a href="/busqueda.php?q=' . trim($keyword) . '">' . trim($keyword) .'  </a>';
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
                }
                ?>
            </ul>
        </div>
        <br>
        <br>
        <h2>Ayúdanos llenando una Encuesta</h2>
        <div style="margin-left: 100px;">
            <iframe src="https://docs.google.com/a/unova.mx/spreadsheet/embeddedform?formkey=dGQwRG5wWDVsNlBmZjNDOEVKb3VxMFE6MQ" width="400" height="500" frameborder="1" marginheight="20" marginwidth="50">Cargando...</iframe>
        </div>
    </div>
    <div class="right" style="width: 220px">        
        <div id="category-list">
            <h2>Categorías</h2>
            <ul>
                <?php
                foreach ($categorias as $categoria) {
                    echo '<li><a href="/categoria/' . $categoria->urlNombre . '">' . $categoria->nombre . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <fb:like-box href="http://www.facebook.com/pages/Unova/266525193421804" width="220" show_faces="true" border_color="#CCCCCC" stream="false" header="true"></fb:like-box>
    </div>

</div>

<?php
require_once('layout/foot.php');
?>