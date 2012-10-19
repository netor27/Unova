<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCambiarPassword.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">

    <div class="left centerText" style="width: 100%;">
        <h1 >Cambiar contraseña</h1>
        
        <?php
        if (isset($error) && $error != "") {
            echo '<h5 class="error centerText">' . $error . '</h5>';
        }
        if (isset($info) && $info != "") {
            echo '<h5 class="info centerText">' . $info . '</h5>';
        } else {
            ?>
            <div id="formDiv" style="width: 550px; margin: 0 auto;">                

                <form method="post" id="customForm" action="/usuarios/usuario/reestablecerPasswordSubmit">                      
                    <div class="divInput">  
                        <label for="pass1">Contraseña</label>  
                        <input id="pass1" name="pass1" type="password"/>  
                        <span id="pass1Info" class="infoLabel">Introduce una contraseña. Mínimo 5 caracteres</span>  
                    </div> 
                    <div class="divInput">  
                        <label for="pass2">Repetir contraseña</label>  
                        <input id="pass2" name="pass2" type="password"/> 
                        <span id="pass2Info" class="infoLabel">Repetir contraseña</span>  
                    </div> 
                    
                    <div class="divInput">  
                        <input id="send" name="send" type="submit" value="  Aceptar  " />  
                    </div>  
                    <input type="hidden" name="uuid" value="<?php echo $uuid; ?>">
                </form>  
                <?php
            }
            ?>
        </div>
    </div>
    

</div>

<?php
require_once('layout/foot.php');
?>