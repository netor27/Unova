<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headPerfil.php');
require_once('layout/headers/headCierre.php');
require_once('layout/headers/headSocialMedia.php');
?>

<div class="contenido">    
    <div id="perfil_header">
        <div id="perfil_header_image" class="left">
            <img src="<?php echo $usuarioPerfil->avatar; ?>" ><br>
            <?php
            
            if ($miPerfil) {
                echo '<a href="/usuarios/usuario/cambiarImagen">Cambiar imagen</a>';
            }
            ?>

        </div>

        <div class="left" id="perfil_datos">
            <div id="perfil_nombre">
                <h1>
                    <?php echo $usuarioPerfil->nombreUsuario; ?>
                </h1>
            </div>
            <div id="perfil_titulo_personal">
                <h3>
                    <?php echo $usuarioPerfil->tituloPersonal; ?>
                </h3>

            </div>   
            <div id="perfil_cursos">
                <h5>
                    <?php
                    if ($numCursos == 1)
                        echo "Enseñando en " . $numCursos . " curso";
                    else
                        echo "Enseñando en " . $numCursos . " cursos";
                    ?>
                </h5>
                <h5>
                    <?php
                    if ($numTomados == 1)
                        echo "Tomando " . $numTomados . " curso";
                    else
                        echo "Tomando " . $numTomados . " cursos";
                    ?>
                </h5>
            </div>
        </div>
        <?php
        if ($miPerfil) {
            ?>
            <div class="right" style="text-align: right">
                <div id="perfil_header_links" style="width:270px;">
                    <br><br>
                    <a  href="/usuarios/usuario/editarInformacion/<?php echo $usuarioPerfil->idUsuario; ?>">
                        <div class="blueButton" style="width:250px;">Editar mi información de usuario</div>
                    </a>
                    <a href="/usuarios/usuario/cambiarCorreo" >
                        <div class="blueButton" style="width:250px;">Cambiar mi correo electrónico</div>
                    </a>
                    <a href="/usuarios/usuario/cambiarCorreoPaypal" >
                        <div class="blueButton" style="width:250px;">Cambiar mi correo asociado con Paypal</div>
                    </a>
                    <a href="/usuarios/usuario/cambiarPassword">
                        <div class="blueButton" style="width:250px;">Cambiar mi contraseña</div>
                    </a>
                    <?php if ($usuarioPerfil->activado == 0) { ?>
                        <a href="/usuarios/usuario/enviarCorreoConfirmacion">
                            <div class="blueButton" style="width:250px;">Confirmar cuenta</div>
                        </a>
                    <?php } ?>

                </div>
            
        <?php } ?>
            <?php
            require_once('layout/SocialMediaContainer.php');
            ?>
        </div>
    </div>
    <div id="perfil_panel">
        <h3>Biografía</h3>
    </div>
    <div id="perfil_footer">
        <div id="bio" class="left">
            <div id="bioContent">
                <?php echo $usuarioPerfil->bio; ?>
            </div>
        </div>
    </div>
    <div id="perfil_panel">
        <h3>
            <?php
            if ($numCursos == 1)
                echo "Enseñando en " . $numCursos . " curso";
            else
                echo "Enseñando en " . $numCursos . " cursos";
            ?>
        </h3>
    </div>
    <div class="cursosContainer">
        <ul>
            <?php
            if (isset($cursos) && !is_null($cursos)) {
                foreach ($cursos as $curso) {
                    ?>
                    <li>
                        <a href="/curso/<?php echo $curso->uniqueUrl; ?>"><div class="thumb" style="background: url(<?php echo $curso->imagen; ?>);"></div></a>
                        <div class="detalles">
                            <?php
                            echo '<a href="/curso/' . $curso->uniqueUrl . '">' . $curso->titulo . '</a>';
                            ?>    <br>        
                            <span>
                                <?php echo $curso->descripcionCorta; ?>
                            </span>
                        </div>

                        <div class="numDetalles numAlumnos">                    
                            <?php echo $curso->numeroDeAlumnos; ?>
                            <span>Alumnos</span>
                        </div>
                        <div class="numDetalles numClases">
                            <?php echo $curso->numeroDeClases; ?>
                            <span>Clases</span>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>

</div>

<?php
require_once('layout/foot.php');
?>
