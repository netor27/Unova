<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headEditarImagenCurso.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">
    <div class="left centerText" style="width: 890px">
        <h1 class="centerText">Cambiar imagen del curso</h1>  
        <br><br>
        <?php
        if (isset($error) && $error != "") {
            echo '<h5 class="error centerText">' . $error . '</h5>';
        }
        if (isset($info) && $info != "") {
            echo '<h5 class="info centerText">' . $info . '</h5>';
        }
        ?>
        <div id="formDiv" style="width:700px;" >  
            <form method="post" id="customForm" enctype="multipart/form-data" action="/cursos/curso/cambiarImagenSubmit/<?php echo $cursoParaModificar->idCurso; ?>">  
                <p>
                <div>
                    <label for="imagen actual">Imagen actual:</label><br><br>
                    <img src="<?php echo $cursoParaModificar->imagen; ?>">
                </div>
                </p>
                <p>
                <div>  
                    <label for="imagen">Sube una imagen:</label>  <br><br>
                    <input id="imagen" name="imagen" type="file" style="width:350px;" />                          
                    <span id="tituloInfo">Imagen del curso</span>  
                </div>  
                </p>

                <p>
                <div>  
                    <input id="send" name="send" type="submit" value="  Aceptar  " />  
                </div> 
                </p>

            </form>  

        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>