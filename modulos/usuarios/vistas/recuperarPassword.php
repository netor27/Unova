<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headRegistro.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">

    <div class="left centerText" style="width: 100%">
        <h1 >Recuperar contraseña</h1>
        <br><br>
        <h4>Te enviaremos un correo electrónico para que puedas reestablecer tu contraseña</h4>
        <?php
        if (isset($error) && $error != "") {
            echo '<h5 class="error centerText">' . $error . '</h5>';
        }
        if (isset($info) && $info != "") {
            echo '<h5 class="info centerText">' . $info . '</h5>';
        } else {
            ?>
        <br><br><br><br>
            <div id="formDiv" style="width:550px;">                

                <form method="post" id="customForm" action="/usuarios/usuario/recuperarPasswordSubmit">  
                    <div class="divInput">  
                        <label for="email">Correo electrónico</label>  
                        <input id="email" name="email" type="text" />  
                        <span id="emailInfo" class="infoLabel">Introduce un correo electrónico válido</span>  
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