<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCambiarCorreo.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">

    <div class="left centerText" style="width: 100%;">
        <h1 >Correo electrónico asociado a tu cuenta Paypal</h1>
        
        <?php
        if (isset($error) && $error != "") {
            echo '<h5 class="error centerText">' . $error . '</h5>';
        }
        if (isset($info) && $info != "") {
            echo '<h5 class="info centerText">' . $info . '</h5>';
        } else {
            ?>
            <div id="formDiv" style="width: 550px; margin: 0 auto;">                

                <form method="post" id="customForm" action="/usuarios/usuario/cambiarCorreoPaypalSubmit">  
                   <div class="divInput">  
                        <label for="email">Correo electrónico asociado con Paypal</label>  
                        <input id="email" name="email" type="text" value="<?php echo $correoPaypal; ?>"/>  
                        <span id="emailInfo" class="infoLabel">Introduce tu correo</span>  
                    </div>  
                    
                    <div class="divInput">  
                        <input id="send" name="send" type="submit" value="  Aceptar  " />  
                    </div>  
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