<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headRegistro.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">

    <div class="left centerText" style="width: 100%">
        <h1 >Registro</h1>

        <?php
        if (isset($error) && $error != "") {
            echo '<h5 class="error centerText">' . $error . '</h5>';
        }
        if (isset($info) && $info != "") {
            echo '<h5 class="info centerText">' . $info . '</h5>';
        } else {
            ?>
            <div id="formDiv" style="width:550px;">                

                <form method="post" id="customForm" action="/usuarios/registro/alta">  
                    <div class="divInput">  
                        <label for="nombre">Nombre</label>  
                        <input id="nombre" name="nombre" type="text" value="<?php echo $nombre; ?>"/>  
                        <span class="infoLabel" id="nombreInfo">¿Cúal es tu nombre?</span>  
                    </div>  
                    <div class="divInput">  
                        <label for="email">Correo electrónico</label>  
                        <input id="email" name="email" type="text" value="<?php echo $email; ?>"/>  
                        <span id="emailInfo" class="infoLabel">Introduce un correo electrónico válido</span>  
                    </div>  
                    <div class="divInput">  
                        <label for="pass1">Contraseña</label>  
                        <input id="pass1" name="pass1" type="password" />  
                        <span id="pass1Info" class="infoLabel">Por lo menos 5 caracteres</span>  
                    </div>  
                    <div class="divInput">  
                        <label for="pass2">Confirma tu contraseña</label>  
                        <input id="pass2" name="pass2" type="password" />  
                        <span id="pass2Info" class="infoLabel">Confirma tu contraseña</span>  
                    </div>                
                    <?php
                    require_once('lib/php/recaptcha/recaptchalib.php');
                    $publickey = "6LdXP9MSAAAAAJPsmT5t8j3GNmwa1WoVbR_z7tvG";
                    if(isset($captchaError))
                        echo recaptcha_get_html($publickey,$captchaError);
                    else
                        echo recaptcha_get_html($publickey);
                    ?>
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