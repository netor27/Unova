$(function(){
    //Para evitar que al presionar enter se cierre el dialogo
    $('form').submit(function(e){
        return false;
    });

    $("#ShowHideToolbox").click(
        function(){
            $("#toolbox").toggle("slow");
            $(".showHideToolboxButton").toggle();
        });
    
    cargarElementosGuardados();
});

function getUnidadPx(unidad){
    if(unidad.indexOf("auto") != -1){
        return unidad + "px";
    }else{
        return unidad;
    }
}

function cambiarColorPicker(hex, id){
    console.log("Cambiando Color picker "+id+" con hex = "+hex);
    $("#colorSelector"+id).ColorPickerSetColor(hex);
    $('#colorSeleccionado'+id).css('backgroundColor', hex);
    $('#colorHidden'+id).val(hex);
}

//Funcion utilizada para transformar un entero que representa segundos a minutos en un string de la forma mm:ss
function transformaSegundos(segundos){
    var min = parseInt(segundos / 60);	
    var seg = segundos % 60;
    
    if(min < 10)
        min = "0"+min;    
    if(seg < 10)
        seg = "0"+seg;
    
    var res = (min + ":" + seg);
    res = res.substr(0, 5);
    
    return res;
}

//Transforma un string de la forrma mm:ss a un entero que representa los segundos
function stringToSeconds(str){
    var splitted = str.split(":");
    var minutos = parseInt(splitted[0]);
    var seg = parseInt(splitted[1]);
    
    if(!isNaN(minutos) && !isNaN(seg)){
        return (minutos * 60) + seg;
    }else{
        return 0;
    }
}

//Guardar los datos
function guardar(u, uuid, cu, cl){    
    pauseVideo();
    
    $("#modalDialog").html("<div style='float:left;'><p>Guardando...</p><p>Espera un momento</p><br></div><img style=' float:right; width:50px;' src='/layout/imagenes/loading.gif'>");
    $( "#modalDialog" ).dialog({
        height: 230,
        draggable: false,
        resizable: false,
        modal: true,
        buttons:{
            "Aceptar": function(){
                $(this).dialog("close");
            }
        }
    });  
    
    
    var videoData = {
        top: $("#videoContainer").position().top,
        left: $("#videoContainer").position().left,
        width: $("#videoContainer").width(),
        height: $("#videoContainer").height()
    }
    
    
    var data = {
        u: u,
        uuid: uuid,
        cu: cu,
        cl: cl,
        videoData: videoData,
        textos:  textos,
        imagenes: imagenes,
        videos: videos,
        links: links
    };
    
    $.ajax({
        type: 'post',
        cache: false,
        url: '/cursos/clase/guardarEdicionVideo',
        data: data
    }).done(function( html ) {
        var res = jQuery.parseJSON(html);
        
        if(res.resultado == "error"){
            $("#modalDialog").html("<h3 class='error'>&iexcl;Error!</h3><br>"+res.mensaje);
        }else{
            $("#modalDialog").html("<h3 class='success'>&iexcl;Bien!</h3><br>"+res.mensaje);
        }
        $("#modalDialog").dialog("open");
    });
}