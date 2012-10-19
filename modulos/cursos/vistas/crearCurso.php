<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headCrearCurso.php');
require_once('layout/headers/headCierre.php');
?>


<div class="contenido">
    <div class="left centerText" style="width: 890px">
        <h1 class="centerText">Crea un curso</h1>    
        <h5>Tu curso será creado pero no publicado hasta que lo decidas.</h5>
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
            <form method="post" id="customForm" action="/cursos/curso/crearCursoSubmit">  
                <p>
                <div>  
                    <label for="titulo">Título</label>  
                    <input id="titulo" name="titulo" type="text" style="width:350px;"/>                          
                    <span id="tituloInfo">Título de tu curso</span>  
                </div>  
                </p>
                <p>
                <div>  
                    <label for="categoria" class="inline">Categoría</label>  
                    <div class="styled-select">
                        <select name="categoria" id="categoria" class="inline">
                            <?php
                            $i = 0;
                            foreach ($categorias as $categoria) {
                                if ($i == 0)
                                    echo '<option value="' . $categoria->idCategoria . '" selected >' . $categoria->nombre . '</option>';
                                else
                                    echo '<option value="' . $categoria->idCategoria . '" >' . $categoria->nombre . '</option>';
                                $i++;
                            }
                            ?>                            
                        </select>   
                    </div>
                    <br>
                    <div>
                        <label for="subcategoria" class="inline">Subcategoría</label>
                        <div class="styled-select">
                            <select name="subcategoria" id="subcategoria"  class="inline">
                                <?php
                                $i = 0;
                                foreach ($subcategorias as $subcategoria) {
                                    if ($i == 0)
                                        echo '<option value="' . $subcategoria->idSubcategoria . '" selected >' . $subcategoria->nombre . '</option>';
                                    else
                                        echo '<option value="' . $subcategoria->idSubcategoria . '" >' . $subcategoria->nombre . '</option>';
                                    $i++;
                                }
                                ?>   
                            </select>   
                        </div>
                    </div>  
                    </p>
                    <p>
                    <div>  
                        <label for="descripcionCorta">Descripción Corta</label>  
                        <textarea id="descripcionCorta" name="descripcionCorta"></textarea>                        
                        <br>
                        <span id="descripcionCortaInfo">Escribe una descripción corta de tu curso.</span>  
                    </div>  
                    </p>
                    <p>
                    <div>  
                        <label for="palabrasClave">Palabras Clave</label>  
                        <textarea id="palabrasClave" name="palabrasClave"></textarea>                        
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
</div>

<?php
require_once('layout/foot.php');
?>
            