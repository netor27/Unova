$(function(){
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
        height: 140,
        modal: true,
        autoOpen: false
    });
    
    var i;
    var n = document.getElementById("numTemas").value;
    for(i=0; i < n; i++){            
        makeSortable(i);
    }
    
    $('.deleteTema').click(function() {
        var me = $(this);
        var parent = $(this).closest('.temaContainer');
        var url = '/temas/tema/borrarTema/' + $(this).attr('curso') + "/" + $(this).attr('id');
        
        $( "#modalDialog" ).html("<p>¿Seguro que deseas eliminar el tema?</p>");
        $( "#modalDialog" ).dialog({
            height: 140,
            modal: true,
            buttons: {
                Si: function() {
                    me.hide().delay(2500).fadeIn();
                    $.ajax({
                        type: 'get',
                        url: url, 
                        success: function(data) {
                            var str = data.toString();
                
                            if(str.indexOf("ok") != -1){                    
                                parent.fadeOut(300,function() {
                                    parent.remove();
                                });
                            }else{                     
                                parent.append("<div class='temaContainerMessage'>"+data+"</div>");                                        
                                parent.children(".temaContainerMessage").delay(3000).fadeOut(300, function(){
                                    $(this).remove();
                                });    
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
            height: 140,
            modal: true,
            buttons: {
                Si: function() {        
                    me.hide().delay(3500).fadeIn();
                    $.ajax({
                        type: 'get',
                        url: url, 
                        success: function(data) {
                            var str = data.toString();
                
                            if(str.indexOf("success") != -1){                    
                                parent.fadeOut(300,function() {
                                    parent.remove();
                                });
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
        height: 140,
        modal: true,
        buttons: {
            Si: function() {        
                $.ajax({
                    type: 'get',
                    url: url,             
                    success: function(data) {
                        var str = data.toString();
                        if(str.indexOf("ok") != -1){                    
                            $('#publicadoContainer').html('<h4 class="success" style="text-align: center;">Curso publicado</h4>');
                        }else{    
                            $("#modalDialog").html('<p>Ocurrió un error al publicar tu curso. Intenta de nuevo más tarde.</p>');
                            $("#modalDialog").dialog("open");
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
}
