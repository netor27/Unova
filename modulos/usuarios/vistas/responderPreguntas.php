<?php
require_once ('layout/headers/headInicio.php');
require_once ('layout/headers/headListaCursos.php');
require_once ('layout/headers/headResponderPreguntas.php');
require_once ('layout/headers/headCierre.php');
?>


<div class="contenido">
    <h1>Preguntas sin responder</h1>
    <?php
    if (isset($preguntas)) {
        $auxIdCurso = -1;

        foreach ($preguntas as $pregunta) {

            if ($pregunta->idCurso != $auxIdCurso) {
                echo '<div>';
                echo '<div style="overflow:hidden;display:block;padding-right:20px; padding-botton:10px;">
                    <a href="/curso/'.$pregunta->uniqueUrl.'">
                    <img style="float:left;"src="' . $pregunta->imagen . '"/>
                    <h2 style="float:left;padding-top:20px;"> Preguntas del curso ' . $pregunta->titulo . '</h2>
                    </a>';
                echo '</div></div>';
                $auxIdCurso = $pregunta->idCurso;
            }
            echo '<div class="preguntaContainer whiteBox" style="width:97%;">';
            echo '<div class="comentarioAvatar"><img src="' . $pregunta->avatar . '"></div>';
            echo '<div class="comentarioUsuario"><a href="/usuario/' . $pregunta->uniqueUrlUsuario . '">' . $pregunta->nombreUsuario . '</a></div>';
            echo '<br><div class="comentario">' . $pregunta->pregunta . '</div>';
            if (isset($pregunta->respuesta)) {
                echo '<br><div class="respuesta blueBox" style="width: 80%;">';
                echo '<div class="comentarioAvatar"><img src="' . $pregunta->avatar . '"></div>';
                echo '<div class="comentarioUsuario"><a href="/usuario/' . $pregunta->uniqueUrlUsuario . '">' . $pregunta->nombreUsuario . '</a></div>';
                echo '<br><div class="comentario">' . $pregunta->respuesta . '</div>';
                echo '</div>';
            } else {
                echo '<div class="respuesta">';
                echo '<div class="loading" style="display:none;">';
                echo '<img src="/layout/imagenes/loading.gif" style="width:30px;">';
                echo '</div>';
                echo '<form id="preguntaForm" method="POST" action="/cursos/curso/responderPreguntaCurso/' . $pregunta->idCurso . '/' . $pregunta->idPregunta . '"  class="preguntarForm">';
                echo '<textarea id="pregunta" name="respuesta"  ></textArea>';
                echo '<br><input type="submit" value="  Responder  ">';
                echo '</form>';
                echo '</div>';
            }
            echo '</div>';
        }
    } else {
        ?>
        <div class="whiteBox"><h3>No hay preguntas</h3></div>
        <?php
    }
    ?>
</div>
<?php
require_once('layout/foot.php');
?>