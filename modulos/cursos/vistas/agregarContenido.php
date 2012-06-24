<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headAgregarContenido.php');
require_once('layout/headers/headCierre.php');
?>

<div class="contenido">
    <div id="videoSubidoDialog" title="Transferencia completa">
        <p>Tu video se ha sido subido correctamente y se está transformando.Te enviaremos un correo electrónico cuando este listo</p>
    </div>
    <div id="dialog">
        
    </div>

    <div class="left centerText" style="width: 100%;">
        <h1 class="centerText">Agrega contenido a tu curso</h1>    
        <br>
        <?php
        if (isset($error) && $error != "") {
            echo '<h5 class="error centerText">' . $error . '</h5>';
        }
        if (isset($info) && $info != "") {
            echo '<h5 class="info centerText">' . $info . '</h5>';
        }
        ?>
        <h2>
            Sube tus archivos y se creará automáticamente una clase por cada uno de ellos
        </h2>
        <br>
        <br>
        <div class="left">
            <div id="uploadZone">
                <h3>Arrastra tus archivos aquí</h3>
            </div>       <br>
            <div id="botonTerminar" class="btn btn-primary left">
                <a href="/curso/<?php echo $curso->uniqueUrl; ?>" style="color:white;">Terminar</a>
            </div>
        </div>


        <div id="uploadForm" class="right">
            <form id="fileupload" action="/uploader.php" method="POST" enctype="multipart/form-data">
                <div class="row fileupload-buttonbar">
                    <div class="span7">
                        <span class="btn btn-success fileinput-button">
                            <i class="icon-plus icon-white"></i>
                            <span>Agregar archivos...</span>
                            <input type="file" name="files[]" multiple>
                        </span>
                        <button type="submit" class="btn btn-primary start">
                            <i class="icon-upload icon-white"></i>
                            <span>Iniciar la carga</span>
                        </button>
                        <button type="reset" class="btn btn-warning cancel">
                            <i class="icon-ban-circle icon-white"></i>
                            <span>Cancelar la carga</span>
                        </button>
                        <button type="button" class="btn btn-danger delete">
                            <i class="icon-trash icon-white"></i>
                            <span>Borrar</span>
                        </button>
                        <input type="checkbox" class="toggle">
                    </div>
                    <div class="span5">                    
                        <div class="progress progress-success progress-striped active fade">
                            <div class="bar" style="width:0%;"></div>
                        </div>
                    </div>
                </div>            
                <div class="fileupload-loading"></div>
                <br>
                <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
                <input type="hidden" name="idUsuario" value="<?php echo $usuarioActual->idUsuario; ?>">
                <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>">
                <input type="hidden" name="idTema" value="<?php echo $idTema; ?>">
                <input type="hidden" name="uuid" value="<?php echo $usuarioActual->uuid; ?>">
            </form>
        </div>
    </div>
    <div id="modal-gallery" class="modal modal-gallery hide fade">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
            <h3 class="modal-title"></h3>
        </div>
        <div class="modal-body"><div class="modal-image"></div></div>
        <div class="modal-footer">
            <a class="btn modal-download" target="_blank">
                <i class="icon-download"></i>
                <span>Download</span>
            </a>
            <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
                <i class="icon-play icon-white"></i>
                <span>Slideshow</span>
            </a>
            <a class="btn btn-info modal-prev">
                <i class="icon-arrow-left icon-white"></i>
                <span>Previous</span>
            </a>
            <a class="btn btn-primary modal-next">
                <span>Next</span>
                <i class="icon-arrow-right icon-white"></i>
            </a>
        </div>
    </div>
    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td class="preview"><span class="fade"></span></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
            {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
                {% } %}</td>
            {% } else { %}
            <td colspan="2"></td>
            {% } %}
            <td class="cancel">{% if (!i) { %}
                <button class="btn btn-warning">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>{%=locale.fileupload.cancel%}</span>
                </button>
                {% } %}</td>
        </tr>
        {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade">
            {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
            {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
                {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
            {% } %}
            <td class="delete">
                <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                    <i class="icon-trash icon-white"></i>
                    <span>{%=locale.fileupload.destroy%}</span>
                </button>
                <input type="checkbox" name="delete" value="1">
            </td>
        </tr>
        {% } %}
    </script>


</div>
<?php
require_once('layout/foot.php');
?>