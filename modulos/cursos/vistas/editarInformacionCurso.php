<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headTinyMCE.php');
require_once('layout/headers/headCrearCurso.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">
    <div class="left centerText" style="width: 890px">
        <h1 class="centerText">Editar información del curso</h1>  
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
            <form method="post" id="customForm" action="/cursos/curso/editarInformacionCursoSubmit/<?php echo $cursoParaModificar->idCurso; ?>">  
                <p>
                <div>  
                    <label for="titulo">Título</label>  
                    <input id="titulo" name="titulo" type="text" style="width:350px;" value="<?php echo $cursoParaModificar->titulo; ?>"/>                          
                    <span id="tituloInfo">Título de tu curso</span>  
                </div>  
                </p>
                <p>
                <div>  
                    <label for="categoria" class="inline">Categoría</label>  
                    <select name="categoria" id="categoria" class="inline">
                        <?php
                        foreach ($categorias as $categoria) {
                            if ($cat->idCategoria == $categoria->idCategoria)
                                echo '<option value="' . $categoria->idCategoria . '" selected >' . $categoria->nombre . '</option>';
                            else
                                echo '<option value="' . $categoria->idCategoria . '" >' . $categoria->nombre . '</option>';
                        }
                        ?>                            
                    </select>   
                </div>
                <div>
                    <label for="subcategoria" class="inline">Subcategoría</label>
                    <select name="subcategoria" id="subcategoria"  class="inline">
                        <?php
                        foreach ($subcategorias as $subcategoria) {
                            if ($cursoParaModificar->idSubcategoria == $subcategoria->idSubcategoria)
                                echo '<option value="' . $subcategoria->idSubcategoria . '" selected >' . $subcategoria->nombre . '</option>';
                            else
                                echo '<option value="' . $subcategoria->idSubcategoria . '" >' . $subcategoria->nombre . '</option>';
                        }
                        ?>   
                    </select>   
                </div>  
                </p>
                <p>
                <div>  
                    <label for="descripcionCorta">Descripción Corta</label>  
                    <textarea id="descripcionCorta" name="descripcionCorta"><?php echo $cursoParaModificar->descripcionCorta; ?></textarea>                        
                    <br>
                    <span id="descripcionCortaInfo">Escribe una descripción corta de tu curso.</span>  
                </div>  
                </p>
                <p>
                <div>  
                    <label for="descripcion">Descripción</label>  
                    <textarea id="descripcion" name="descripcion"><?php echo $cursoParaModificar->descripcion; ?></textarea>                        
                    <br>
                    <span id="descripcionInfo">Escribe una descripción corta de tu curso.</span>  
                </div>  
                </p>
                <p>
                <div>  
                    <label for="palabrasClave">Palabras Clave</label>  
                    <textarea id="palabrasClave" name="palabrasClave"><?php echo $cursoParaModificar->keywords; ?></textarea>                        
                    <br>
                    <span id="palabrasClaveInfo">Palabras clave para identificar tu curso. Separadas con comas.</span>  
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