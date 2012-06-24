<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headAgregarClase.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">

    <div class="left centerText" style="width: 100%;">
        <h1 class="centerText">Editar clase</h1>    
        <a style="float:right;" class="blueButton"  href="/cursos/clase/editorVideo/<?php echo $curso->idCurso . "/" . $clase->idClase; ?>">
            Agregar interactividad al video
        </a>
        <br><br>
        <?php
        if (isset($error) && $error != "") {
            echo '<h5 class="error centerText">' . $error . '</h5>';
        }
        if (isset($info) && $info != "") {
            echo '<h5 class="info centerText">' . $info . '</h5>';
        }
        ?>
        <div id="formDiv" style="width:600px;" >  
            <form method="post" id="customForm" action="/clases/clase/editarClaseSubmit">  

                <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>"/>
                <input type="hidden" name="idClase" value="<?php echo $clase->idClase; ?>"/>

                <p>
                <div>  
                    <label for="titulo">Título</label>  
                    <input id="titulo" name="titulo" type="text" style="width:90%;" value="<?php echo $clase->titulo; ?>"/><br>
                    <span id="tituloInfo">Título de la clase</span>  
                </div>  
                </p>
                <p>
                <div>  
                    <label for="descripcion">Descripción</label>  
                    <textarea id="descripcion" name="descripcion" style="width:90%;"> <?php echo $clase->descripcion; ?></textarea><br>                       
                    <span id="descripcionInfo">Descripción de la clase</span>  
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