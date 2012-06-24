<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headEditarPerfil.php');
require_once('layout/headers/headTinyMCE.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">

    <div class="left centerText" style="width: 100%;">
        <h1 >Editar mi información</h1>
        
        <?php
        if (isset($error) && $error != "") {
            echo '<h5 class="error centerText">' . $error . '</h5>';
        }
        if (isset($info) && $info != "") {
            echo '<h5 class="info centerText">' . $info . '</h5>';
        } else {
            ?>
            <div id="formDiv" style="width: 690px; margin: 0 auto;">                

                <form method="post" id="customForm" action="/usuarios/usuario/editarInformacionSubmit">  
                    <div class="divInput">  
                        <label for="nombre">Nombre</label>  
                        <input id="nombre" name="nombre" type="text" value='<?php echo $usuario->nombreUsuario; ?>'/>  
                        <span id="nombreInfo" class="infoLabel">¿Cúal es tu nombre?</span>  
                    </div> 
                    <div class="divInput">  
                        <label for="tituloPersonal">Titulo profesional</label>  
                        <input style="width: 625px" id="tituloPersonal" name="tituloPersonal" type="text" value="<?php echo $usuario->tituloPersonal; ?>"/>  <br>
                        <span id="tituloPersonalInfo" class="infoLabel">Ejemplos: Experto en tocar la guitarra, Profesor de tiempo completo, diseñador web en Unova, etc.</span>  
                    </div> 
                     
                    <div class="divInput">  
                        <label for="bio">Biografía</label> 
                        <textarea id="bio" name="bio"><?php echo $usuario->bio; ?></textarea>                                               
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