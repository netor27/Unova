<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headLogin.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <div class="left centerText" style="width: 590px">
        <h1>Inicio de sesión</h1>

        <?php
        if (isset($msgLogin)) {
            echo '<div class="error">' . $msgLogin . '</div>';
        }
        ?>         
        <div id="formDiv" class="centerText">
            <form type="actionForm" action="/login/login/loginSubmit" method="post">
                <fieldset style="margin: 0 auto; width:310px;">
                    <legend>Introduce tus datos</legend>
                    <p>
                        <label for="email">Correo electrónico</label>
                        <br>
                        <input type="text" class="title" name="email">                            
                    </p>
                    <p>
                        <label for="password">Contraseña</label>
                        <br>
                        <input type="password" class="title" name="password">
                    </p>
                    <p >
                    <div style="margin: 0 auto; width: 61px">
                        <button type="submit" style="margin: 0 auto;">
                            Aceptar
                        </button>
                    </div>
                    </p>
                </fieldset>
                <?php if (!$user) { ?>
                    <div class="login-box olvidePass">

                        <div class="special-btn-wrap">
                            <a class="special-btn facebook badge-facebook-connect" href="<?= $loginUrl ?>">
                                Iniciar sesión con Facebook
                            </a>
                        </div>
                    </div>

                <?php } ?>


                <div class="info centerText olvidePass">
                    <a href="/usuarios/usuario/recuperarPassword">¿Olvidaste tu contraseña? Da click aquí</a>
                </div>

                <?php
                if (isset($pagina))
                    echo '<input type="hidden" name="pagina" value="' . $pagina . '">';
                ?>
            </form>

        </div>

    </div>
    <div class="right" style="width: 320px">
        <div class="notice centerText noCuenta" style="">
            <a href="/usuarios/registro"><h1>Si no tienes cuenta registrate aquí</h1></a>            
        </div>
    </div>
</div>


<?php
require_once('layout/foot.php');
?>