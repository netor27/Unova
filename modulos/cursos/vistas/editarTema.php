<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headAgregarTema.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">

    <div class="left centerText" style="width: 890px">
        <h1 class="centerText">Agregar un tema</h1>    
        <h5></h5>
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
            <form method="post" id="customForm" action="/temas/tema/editarTemaSubmit">  
                <input type="hidden" name="idTema" value="<?php echo $idTema; ?>"/>
                <input type="hidden" name="idCurso" value="<?php echo $idCurso;?>"/>
                <p>
                <div>  
                    <label for="titulo">Título</label>  
                    <input id="titulo" name="titulo" type="text" style="width:350px;" value="<?php echo $tema->nombre; ?>"/>                          
                    <span id="tituloInfo">Título del tema</span>  
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