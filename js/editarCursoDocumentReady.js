$(function(){
    
    $("#modalDialogCambiarPrecio").dialog({
        height: 200,
        width: 580,
        modal: true,
        autoOpen: false
    });
    
    $("#cambiarPrecio").click( function (){
        $("#modalDialogCambiarPrecio").dialog("open");
    });
    
    $('.wow').rating();
    
    $("#cursoTabs").tabs();
    
    $('#pageMeComments').quickPager({
        pageSize: 6
    });
    $('#pageMePreguntas').quickPager({
        pageSize: 6
    });
    
    //Inicializar los dialogs
    $( "#modalDialog" ).dialog({
        height: 160,
        width: 400,
        modal: true,
        autoOpen: false
    });
    
    var i;
    
    var n = 0;
    try{
        n = document.getElementById("numTemas").value;
    }catch(err){
        n = 0;
    }
    
    for(i=0; i < n; i++){            
        makeSortable(i);
    }
    
    $('.deleteTema').click(function() {
        var me = $(this);
        var parent = $(this).closest('.temaContainer');
        var url = '/temas/tema/borrarTema/' + $(this).attr('curso') + "/" + $(this).attr('id');
        
        $( "#modalDialog" ).html("<p>¿Seguro que deseas eliminar el tema?</p>");
        $( "#modalDialog" ).dialog({
            height: 200,
            width: 400,
            modal: true,
            buttons: {
                Si: function() {
                    me.hide().delay(2500).fadeIn();
                    parent.hide(300);
                    $.ajax({
                        type: 'get',
                        url: url, 
                        success: function(data) {
                            var str = data.toString();
                
                            if(str.indexOf("ok") != -1){                    
                                parent.remove();
                            }else{      
                                console.log("error");                                
                                $( "#modalDialog" ).html(data);
                                $( "#modalDialog" ).dialog({
                                    height: 230,
                                    width: 400,
                                    modal: true,
                                    buttons: {
                                        Aceptar: function(){                                            
                                            parent.show();
                                            $( this ).dialog( "close" );
                                        }
                                    }
                                });
                                $( "#modalDialog" ).dialog("open");
                            }                
                        }
                    }); 
                    $( this ).dialog( "close" );
                },
                Cancelar: function() {
                    $( this ).dialog( "close" );
                }
            }
        });  
        $( "#modalDialog" ).dialog("open");
    });
    
    $('.deleteClase').click(function() {
        var parent = $(this).closest('.claseContainer');
        
        var url = '/clases/clase/borrarClase/' + $(this).attr('curso') + "/" + $(this).attr('id');
        var me = $(this);
        
        $( "#modalDialog" ).html("<p>¿Seguro que deseas eliminar la clase?</p>");
        $( "#modalDialog" ).dialog({
            height: 160,
            width: 400,
            modal: true,
            buttons: {
                Si: function() {        
                    parent.fadeOut(300);
                    me.hide().delay(3500).fadeIn();
                    $.ajax({
                        type: 'get',
                        url: url, 
                        success: function(data) {
                            var str = data.toString();                
                            if(str.indexOf("success") != -1){                    
                                parent.remove();
                            }else{
                                parent.show();
                                $("#modalDialog").html("<p class='error'>Ocurrió un error al borrar la clase. Intenta de nuevo más tarde</p>");
                                $("#modalDialog").dialog({
                                    height: 180,
                                    width: 400,
                                    modal: true,
                                    buttons: {
                                        Aceptar: function(){
                                            $( "#modalDialog" ).dialog("close");
                                        }
                                    }
                                });
                                $( "#modalDialog" ).dialog("open");
                            }
                        }
                    });        
                    $( this ).dialog( "close" );
                },
                Cancelar: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
        $( "#modalDialog" ).dialog("open");
    });
    
    
    
    $(".claseSortableContainer").children(".showOnHover").hide();
       
    $(".claseSortableContainer").hover(
        function () {
            $(this).css('cursor','move');
            $(this).children(".showOnHover").show();
        }, 
        function () {
            $(this).css('cursor','auto');
            $(this).children(".showOnHover").hide();
        }
        );
            
    function validate(formData, jqForm, options) { 
        for (var i=0; i < formData.length; i++) { 
            if (!formData[i].value) { 
                return false; 
            } 
        } 
        jqForm.hide();
        return true;
    }
    function showResponse(responseText, statusText, xhr, $form)  {  
        $res = $form.parent(".respuesta");
        $res.html(responseText);
        $form.remove();
    }
            
    var preguntaOptions = { 
        beforeSubmit: validate,        
        success: showResponse
    }; 
    $('.preguntarForm').ajaxForm(preguntaOptions);
    
    
});

function makeSortable(num){
    var idTema = document.getElementById("idTema"+num).value;
    $( "#sortable" + num ).sortable({
        
        cursor: "move",
        placeholder: "ui-widget-header",
        forcePlaceholderSize: true,
        connectWith: ".connectedSortable",           
        update : function () {    
            //alert("actualize " + num + " i ="+i);            
            
            serial = $('#sortable'+num).sortable('serialize');                 
            $.ajax({
                url: "/cursos.php?c=ordenarClases&a=ordenar&idTema="+idTema,
                type: "post",
                data: serial,
                error: function(){
                    alert("Ocurrió un error al actualizar el orden de las clases");
                },
                success: function(data){
                //$("#cursoTabs").append(data);
                }
            });
        }
    });
}

function publicarCurso(ic){
    var url = "/cursos.php?a=publicar&ic="+ic;
        
    $( "#modalDialog" ).html("<p>¿Seguro que deseas publicar tu curso?</p>");
    $( "#modalDialog" ).dialog({
        height: 160,
        width: 400,
        modal: true,
        buttons: {
            Si: function() {        
                $.ajax({
                    type: 'get',
                    url: url,             
                    success: function(data) {
                        $("#modalDialog").dialog( "close" );
                        var str = data.toString();
                        var mensaje;
                        if(str.indexOf("ok") != -1){                    
                            $( '#publicadoContainer' ).html('<h4 class="success" style="text-align: center;">Curso publicado</h4>');
                        }else if(str.indexOf("activado")){
                            mensaje = '<p>Confirma tu cuenta antes de poder publicar tu curso.</p>';
                        }else{    
                            mensaje = '<p>Ocurrió un error al publicar tu curso. Intenta de nuevo más tarde.</p>';                            
                        }
                        mostrarMensaje(mensaje);
                    }
                });                 
            },
            Cancelar: function() {
                $( this ).dialog( "close" );
            }
        }
    });
    $( "#modalDialog" ).dialog("open");
}

function mostrarMensaje(mensaje){
    $("#modalDialog").html(mensaje);
    $( "#modalDialog" ).dialog({
        height: 160,
        width: 400,
        modal: true,
        buttons: {
            Aceptar: function() {        
                $( this ).dialog( "close" );                
            }
        }
    });
    $( "#modalDialog" ).dialog("open");
}