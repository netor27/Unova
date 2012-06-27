$(function(){
    $('.wow').rating();
    
    //Inicializar los dialogs
    $( "#modalDialog" ).dialog({
        height: 160,
        width: 400,
        modal: true,
        autoOpen: false,
        buttons: {
            Aceptar: function() {
                $( this ).dialog( "close" );
            }
        }
    });
    
    $('.calificar').rating({
        callback: function(value, link){
            
            var ic = $(this).attr('ic');
            var iu = $(this).attr('iu');
            ;
            var url = '/cursos.php?a=calificarCurso&ic=' + ic + '&iu=' + iu + '&rating=' + value;            
            $.ajax({
                type: 'get',
                url: url,             
                success: function(data) {
                    $( "#modalDialog" ).attr("title", "Calificación enviada");
                    $( "#modalDialog" ).html("<p>"+data+"</p>");
                    
                    $( "#modalDialog" ).dialog("open");
                }
            }); 
        }
    });
    
    $("#cursoTabs").tabs();
    
    $('#pageMeComments').quickPager({
        pageSize: 5
    });
    $('#pageMePreguntas').quickPager({
        pageSize: 5
    });
    
    var options = {
        beforeSubmit: validate,
        success: function(data) {            
            if(data.indexOf("error") == -1){
                $( "#modalDialog" ).html("Gracias por tu comentario");
                $( "#modalDialog" ).dialog("open");
                $("#pageMeComments").prepend(data);
            }else{
                alert("Ocurrió un error al guardar tu comentario. Intenta de nuevo más tarde");
            }
            $("#comentario").val("");
        }
    }; 
    $('#comentarioForm').ajaxForm(options);
    
    function validate(formData, jqForm, options) { 
        for (var i=0; i < formData.length; i++) { 
            if (!formData[i].value) { 
                return false; 
            } 
        } 
        return true;
    }
    
    var preguntaOptions = { 
        beforeSubmit: validate,
        success: function(data) { 
            if(data.indexOf("error") == -1){
                $( "#modalDialog" ).html("Tu pregunta ha sido enviada al profesor");
                $( "#modalDialog" ).dialog("open");
                $("#pageMePreguntas").prepend(data);
                $("#pregunta").val("");
            }else{
                alert("Ocurrió un error al guardar tu pregunta. Intenta de nuevo más tarde");
            }
            
        }
    }; 
    $('#preguntarForm').ajaxForm(preguntaOptions);
});