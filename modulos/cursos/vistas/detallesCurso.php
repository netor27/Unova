<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headDetallesCurso.php');
require_once('layout/headers/headStarRating.php');
require_once('layout/headers/headSocialMedia.php');
require_once('layout/headers/headCierre.php');
require_once('layout/SocialMediaContainer.php');
?>


<div class="Contenido">    
    <div class="cursoHeader blueBox" style="width: 97.5%;">          
        <div id="cursoImageWrapper">

        </div>
        <div id="cursoTituloWrapper">            
            <div id="cursoImage">
                <img itemprop="image" src="<?php echo $curso->imagen; ?>" class="left">
            </div>
            <div id="cursoTitulo" itemprop="name"><?php echo $curso->titulo; ?></div>                
            <div id="cursoDescripcionCorta">       
                <p itemprop="description">
                    <?php echo $curso->descripcionCorta; ?>
                </p>
            </div>
            <br><br>
            <h5>Categoria: <a href="/categoria/<?php echo $categoria->urlNombre; ?>"><?php echo $categoria->nombre; ?></a> >> <?php echo $subcategoria->nombre; ?></h5>
            <br>
            <h5>Palabras clave: 
                <?php
                $splitted = explode(",", $curso->keywords);
                $i = 0;
                foreach ($splitted as $split) {

                    if ($i != 0)
                        echo ", ";
                    echo "<a href='/busqueda.php?q=" . trim($split) . "'>" . trim($split) . "</a>";

                    $i++;
                }
                ?>

            </h5>
        </div>

        <div id="slp-botonComprar">
            <div id="botonComprar-wrapper">
                <a class="botonComprar-link" href="/cursos/curso/suscribirUsuario/<?php echo $curso->idCurso; ?>">
                    Suscribirme a este curso
                    <span>
                        <?php
                        if ($curso->precio > 0)
                            echo "$" . $curso->precio;
                        else
                            echo 'Gratuitamente ';
                        ?>
                    </span>
                </a>
            </div>
        </div>
    </div>       

    <div class="cursoContainer">
        <div id="leftContainer" class="left">
            <div class="infoCursoContainer whiteBox" style="width: 97.5%;">
                <div id="cursoAutor" class="left">
                    <?php
                    echo 'Autor:<br> <a href="/usuario/' . $usuarioDelCurso->uniqueUrl . '">' . $usuarioDelCurso->nombreUsuario . '</a>';
                    ?>  
                    </a>
                </div>
                <div id="cursoDescripcion" class="left">
                    <?php
                    echo $curso->descripcion;
                    ?>
                </div>
            </div>
            <div id="temasContainer" class="whiteBox" style="width: 99%;">

                <?php
                $i = 1;
                $j = 1;
                if (isset($temas) && isset($clases)) {
                    foreach ($temas as $tema) {
                        echo '<h3> Tema ' . $i . ': <b>' . $tema->nombre . '</b></h3>';
                        echo '<ul>';
                        $j = 1;
                        foreach ($clases as $clase) {
                            if ($tema->idTema == $clase->idTema) {
                                switch ($clase->idTipoClase) {
                                    case 0:
                                        echo '<li class="single-class type-video">';
                                        echo '<a href="#" class="thumb">';
                                        echo '<img src="/layout/imagenes/video.png">';
                                        echo '<div class="thumbText">' . $clase->duracion . '</div>';
                                        break;
                                    case 1:
                                        echo '<li class="single-class type-document">';
                                        echo '<a href="#" class="thumb">';
                                        echo '<img src="/layout/imagenes/document.png">';
                                        break;
                                    case 2:
                                        echo '<li class="single-class type-presentation">';
                                        echo '<a href="#" class="thumb">';
                                        echo '<img src="/layout/imagenes/presentation.png">';
                                        break;
                                    default:
                                        break;
                                }

                                echo '</a>';

                                echo '<div class="details">';
                                echo '<h4>Clase ' . $j . ':</h4>';
                                if (strlen($clase->titulo) > 27)
                                    echo '<a href="#">' . substr($clase->titulo, 0, 27) . '...</a>';
                                else
                                    echo '<a href="#">' . $clase->titulo . '</a>';

                                echo '</div>';
                                echo '</li>';
                                $j++;
                            }
                        }
                        $i++;
                        echo '</ul>';
                    }
                }else {
                    ?>
                    <h2 style="text-align: center;">Este curso no tiene clases</h2>
                    <?php
                }
                ?>
            </div>
        </div>
        <div id="rightContainer" class="right">
            <div id="numInscritos" class="whiteBox" style="width: 95%; text-align: center">
                <p>
                    <?php
                    if ($curso->numeroDeAlumnos == 1) {
                        echo "Este curso tiene <span> 1 </span> alumno inscrito";
                    } else {
                        echo "Este curso tiene <span>" . $numAlumnos . "</span> alumnos inscritos";
                    }
                    if (isset($duracion) && $duracion > 0)
                        echo ' <br>y más de <span>' . $duracion . '</span> minutos de video';
                    ?>
                </p>
                <p>

                </p>
            </div>

            <div id="calificacion" class="whiteBox" style="width: 95%">
                Calificación del curso<br>
                <div id="cursoStars">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($curso->rating == $i)
                            echo '<input title="' . $i . '" name="adv2" type="radio" disabled="disabled" class="wow" checked="checked"/>';
                        else
                            echo '<input title="' . $i . '" name="adv2" type="radio" disabled="disabled" class="wow"/>';
                    }
                    ?>
                </div>
            </div>

            <div id="instructor" class="whiteBox" style="width: 95%;">
                <div id="instructorHeader">
                    Instructor
                </div>
                <div id="instructorImage">
                    <img src="<?php echo $usuarioDelCurso->avatar; ?>"/>
                </div><br>
                <div id="instructorInfo">
                    <span id="nombre"><a href="/usuario/<?php echo $usuarioDelCurso->uniqueUrl; ?>"><?php echo $usuarioDelCurso->nombreUsuario; ?>  </a></span><br>
                    <span id="titulo"><?php echo $usuarioDelCurso->tituloPersonal; ?></span>
                </div>
                <div id="instructorBio">
                    <?php
                    echo $usuarioDelCurso->bio;
                    ?>
                </div>
            </div>
            <div id="comentariosContainer" class="whiteBox" style="width: 95%;">
                <div id="instructorHeader">
                    Comentarios
                </div>
                <?php
                if (isset($comentarios)) {
                    echo '<ul id="pageMe" class="pageMe">';
                    foreach ($comentarios as $comentario) {
                        echo '<li>';
                        if ($comentario->idUsuario == $curso->idUsuario)
                            echo '<div class="comentarioContainer blueBox"  style="width:320px">';
                        else
                            echo '<div class="comentarioContainer whiteBox"  style="width:320px">';
                        echo '<div class="comentarioAvatar"><img src="' . $comentario->avatar . '"></div>';
                        echo '<div class="comentarioUsuario"><a href="/usuario/' . $comentario->uniqueUrlUsuario . '">' . $comentario->nombreUsuario . '</a></div>';
                        echo '<div class="comentarioFecha">' . transformaDateDDMMAAAA(strtotime($comentario->fecha)) . '</div>';
                        echo '<br><div class="comentario">' . $comentario->texto . '</div>';
                        echo '</div>';
                        echo '</li>';
                    }
                    echo '</ul>';
                }else {
                    ?>
                    <h3>No hay comentarios</h3>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>