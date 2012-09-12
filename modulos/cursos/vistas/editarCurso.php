<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headEditarCurso.php');
require_once('layout/headers/headStarRating.php');
require_once('layout/headers/headSocialMedia.php');
require_once('layout/headers/headCierre.php');
?>
<div id="modalDialogCambiarPrecio" title="Cambiar precio">
    <h2>Aquí puedes establecer el precio de tu curso</h2>
    <div>
        <form method="post" action="/cursos/curso/cambiarPrecio">
            <p>
                <label for="amount">Precio del curso:</label>
                <input type="text" name="cantidad" id="cantidad" style="border:1; color:#f6931f; font-weight:bold; font-size: 20px;" value="10"/>
            </p>
            <br>
            <input type="hidden" name="ic" value="<?php echo $cursoParaModificar->idCurso; ?>">
            <input class="right" type="submit" value="  Aceptar ">
        </form>
    </div>
</div>

<div class="contenido">    
    <div id="cursoHeader">
        <div id="cursoHeader_left">            
            <div id="cursoHeader_img" class="left">
                <img itemprop="image" src="<?php echo $cursoParaModificar->imagen; ?>"/>
                <br>
                <a href="/cursos/curso/cambiarImagen/<?php echo $cursoParaModificar->idCurso; ?>">Cambiar imagen</a>
            </div>            
            <div id="cursoHeader_info" class="left" style="width:630px">
                <div id="cursoHeader_info_titulo">
                    <h1 itemprop="name"><?php echo $cursoParaModificar->titulo; ?></h1>
                </div>
                <div style="float:left; padding-right: 20px;">
                    <?php
                    if ($cursoParaModificar->publicado == 1) {
                        if ($numAlumnos == 0) {
                            echo '<h3>No hay ningún usuario inscrito</h3>';
                        } else if ($numAlumnos == 1) {
                            echo '<h3><span style="font-weight:bold;">1</span> alumno inscrito</h3>';
                        } else {
                            echo '<h3>' . $numAlumnos . ' alumnos inscrito</h3>';
                        }
                    }
                    ?>
                </div>
                <div style="float:left;">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($cursoParaModificar->rating == $i)
                            echo '<input title="' . $i . '" name="adv2" type="radio" disabled="disabled" class="wow" checked="checked"/>';
                        else
                            echo '<input title="' . $i . '" name="adv2" type="radio" disabled="disabled" class="wow"/>';
                    }
                    ?>
                </div>

                <br><br><br>
                <h5>Categoria: <a href="/categoria/<?php echo $categoria->urlNombre; ?>"><?php echo $categoria->nombre; ?></a> >> <?php echo $subcategoria->nombre; ?></h5>
                <br>
                <h5>Palabras clave: 
                    <?php
                    $splitted = explode(",", $cursoParaModificar->keywords);
                    $i = 0;
                    foreach ($splitted as $split) {

                        if ($i != 0)
                            echo ", ";
                        echo "<a href='/busqueda.php?q=" . trim($split) . "'>" . trim($split) . "</a>";

                        $i++;
                    }
                    ?>

                </h5>
                <h5> 
                    <?php
                    if ($cursoParaModificar->precio > 0)
                        echo "Precio:  <strong>$" . $cursoParaModificar->precio . "</strong>";
                    else
                        echo "<strong>Curso gratuito</strong>";
                    ?>
                </h5>
            </div>            
        </div>
        <div id="cursoHeader_right" class="right">
            <a href="/cursos/curso/editarInformacionCurso/<?php echo $cursoParaModificar->idCurso; ?>" >
                <div class="blueButton">Editar información del curso</div>
            </a>
            <a id="cambiarPrecio">
                <div class="blueButton">Cambiar precio del curso</div>
            </a>
            <div id="publicadoContainer">
                <?php
                if ($cursoParaModificar->publicado == 1) {
                    echo '<h4 class="success" style="text-align: center;">Curso publicado</h4>';
                } else {
                    ?>
                    <a style="text-align:center;"  onclick="publicarCurso('<?php echo $cursoParaModificar->idCurso ?>')"id="publicarCurso">
                        <div class="blueButton" >Publicar curso</div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="right">
            <?php
            require_once('layout/SocialMediaContainer.php');
            ?>
        </div>
    </div>
    <div id="cursoTabs">
        <ul>
            <li><a href="#tabs-1">Clases</a></li>
            <li><a href="#tabs-2">Descripción</a></li>
            <li><a href="#tabs-3">Comentarios</a></li>
            <li><a href="#tabs-4">Preguntas</a></li>
        </ul>

        <div id="tabs-1">
            <div class="mensajes">
                <?php
                if (isset($error) && $error != "") {
                    echo '<h5 class="error centerText">' . $error . '</h5>';
                }
                if (isset($info) && $info != "") {
                    echo '<h5 class="info centerText">' . $info . '</h5>';
                }
                ?>
            </div>
            <?php
            if (isset($temas)) {
                ?>
                <div class="right">
                    <a href="/temas/tema/agregarTema/<?php echo $cursoParaModificar->idCurso; ?>" class="blueButton">Agregar un tema</a>
                </div> 
                <div class="centerText" style="padding: 10px;">
                    <a href="/cursos/curso/agregarContenido/<?php echo $cursoParaModificar->idCurso; ?>" class="blueButton" id="agregarContenido">Agregar contenido</a>
                </div>
                <p>
                    Arrastra y suelta las clases para ordenarlas
                </p>
                <input type="hidden" name="numTemas" id="numTemas" value="<?php echo sizeof($temas); ?>" />
                <?php
                for ($i = 0; $i < sizeof($temas); $i++) {
                    ?>
                    <div class="temaContainer" >
                        <input type="hidden" name="idTema<?php echo $i; ?>" id="idTema<?php echo $i; ?>" value="<?php echo $temas[$i]->idTema; ?>" />
                        <div class="temaHeader  ui-state-highlight">
                            <div class="temaNombre left">
                                <?php
                                if (strlen($temas[$i]->nombre) > 47)
                                    echo substr($temas[$i]->nombre, 0, 47) . "...";
                                else
                                    echo $temas[$i]->nombre;
                                ?>
                            </div>                                                
                            <div class="temaNombreLinks right">    
                                <?php
                                echo '<a href="/cursos/curso/agregarContenido/' . $cursoParaModificar->idCurso . '/' . $temas[$i]->idTema . '">Agregar Contenido</a>';
                                echo '<a href="/temas/tema/editarTema/' . $cursoParaModificar->idCurso . '/' . $temas[$i]->idTema . '">Editar</a>';
                                echo '<a class="deleteTema" id="' . $temas[$i]->idTema . '" curso="' . $cursoParaModificar->idCurso . '" >Borrar</a>';
                                ?>

                            </div>
                        </div>
                        <div class="temaContainerMessage"></div>
                        <br>  
                        <ul id="sortable<?php echo $i; ?>" class="connectedSortable">
                            <?php
                            for ($j = 0; $j < sizeof($clases); $j++) {
                                if ($clases[$j]->idTema == $temas[$i]->idTema) {
                                    ?>
                                    <li id="clase_<?php echo $clases[$j]->idClase; ?>"  class="ui-state-default claseContainer">
                                        <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                        <div class="claseSortableContainer">
                                            <div class="left">                                            
                                                <img class="left" src="/layout/imagenes/<?php echo $tiposClase[$clases[$j]->idTipoClase]->imagen ?>">
                                                <div class="left claseNombre">
                                                    <?php
                                                    if (strlen($clases[$j]->titulo) > 45)
                                                        echo substr($clases[$j]->titulo, 0, 45) . "...";
                                                    else
                                                        echo $clases[$j]->titulo;
                                                    ?>  
                                                </div>
                                            </div>
                                            <div class="claseLinks right showOnHover">   
                                                <?php
                                                if ($clases[$j]->idTipoClase == 0) {
                                                    ?>
                                                    <a href="/cursos/clase/editorVideo/<?php echo $cursoParaModificar->idCurso . "/" . $clases[$j]->idClase; ?>">Agregar interactividad al video</a>
                                                    <?php
                                                }
                                                ?>
                                                <a href="/curso/<?php echo $cursoParaModificar->uniqueUrl . "/" . $clases[$j]->idClase; ?>">Ver</a>
                                                <a href="/cursos/clase/editarClase/<?php echo $cursoParaModificar->idCurso . "/" . $clases[$j]->idClase; ?>">Editar</a>
                                                <?php
                                                echo '<a class="deleteClase" id="' . $clases[$j]->idClase . '" curso="' . $cursoParaModificar->idCurso . '" >Borrar</a>';
                                                ?>

                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>

                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="centerText" style="height: 100px; padding: 50px;">
                    <a href="/cursos/curso/agregarContenido/<?php echo $cursoParaModificar->idCurso; ?>" class="blueButton" id="agregarContenido">Agregar contenido</a>
                </div>
                <?php
            }
            ?>

        </div>
        <div id="tabs-2">
            <div class="right">
                <a href="/cursos/curso/editarInformacionCurso/<?php echo $cursoParaModificar->idCurso; ?>" class="blueButton">Editar esta información</a>
            </div>
            <div id="descripcion" style="margin-top:30px;">
                <h2 style="padding-left: 20px;">Descripción corta</h2>   
                <div id="descripcionContent">
                    <p itemprop="description">
                        <?php
                        echo $cursoParaModificar->descripcionCorta;
                        ?>
                    </p>
                </div>
            </div>
            <div id="descripcion">                
                <h2 style="padding-left: 20px;">Descripción</h2>
                <div id="descripcionContent">
                    <?php
                    echo $cursoParaModificar->descripcion;
                    ?>
                </div>
            </div>

        </div>
        <div id="tabs-3">

            <?php
            if (isset($comentarios)) {
                echo '<ul id="pageMeComments" class="pageMe">';
                foreach ($comentarios as $comentario) {
                    echo '<li>';
                    if ($comentario->idUsuario == $cursoParaModificar->idUsuario)
                        echo '<div class="comentarioContainer blueBox">';
                    else
                        echo '<div class="comentarioContainer whiteBox">';
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
                <div class="whiteBox"><h3>No hay comentarios</h3></div>
                <?php
            }
            ?>
        </div>
        <div id="tabs-4">
            <?php
            if (isset($preguntas)) {
                echo '<ul id="pageMePreguntas" class="pageMe">';
                foreach ($preguntas as $pregunta) {
                    echo '<li>';
                    echo '<div class="preguntaContainer whiteBox">';
                    echo '<div class="comentarioAvatar"><img src="' . $pregunta->avatar . '"></div>';
                    echo '<div class="comentarioUsuario"><a href="/usuario/' . $pregunta->uniqueUrlUsuario . '">' . $pregunta->nombreUsuario . '</a></div>';
                    echo '<br><div class="comentario">' . $pregunta->pregunta . '</div>';
                    if (isset($pregunta->respuesta)) {
                        echo '<br><div class="respuesta blueBox" style="width: 80%;">';
                        echo '<div class="comentarioAvatar"><img src="' . $usuarioDelCurso->avatar . '"></div>';
                        echo '<div class="comentarioUsuario"><a href="/usuario/' . $usuarioDelCurso->uniqueUrl . '">' . $usuarioDelCurso->nombreUsuario . '</a></div>';
                        echo '<br><div class="comentario">' . $pregunta->respuesta . '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="respuesta">';
                        echo '<form id="preguntaForm" method="POST" action="/cursos/curso/responderPreguntaCurso/' . $cursoParaModificar->idCurso . '/' . $pregunta->idPregunta . '"  class="preguntarForm">';
                        echo '<textarea id="pregunta" name="respuesta"  ></textArea>';
                        echo '<br><input type="submit" value="  Responder  ">';
                        echo '</form>';
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                ?>
                <div class="whiteBox"><h3>No hay preguntas</h3></div>
                <?php
            }
            ?>
        </div>
    </div>

</div>
<?php
require_once('layout/foot.php');
?>