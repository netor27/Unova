var imagenes = [];
var editarImagenBandera = false;
var idEditarImagen = -1;

$(function(){
    
    $("#dialog-form-imagen").dialog({
        autoOpen: false,
        height:650,
        width: 550,
        modal: true,
        buttons:{
            "Aceptar": function(){
                if(editarImagenBandera){
                    editarImagen();
                }else{
                    agregarImagen();    
                }
                
                $(this).dialog("close");
                $("#urlImagen").val("");
            },
            "Cancelar": function(){
                $(this).dialog("close");
            }
        }
    });	 
    $('#imagenAccordion').accordion({
        autoHeight: false
    });
    
    $("#colorHiddenImagen").val("#FFFFFF");
    $('#colorSelectorImagen').ColorPicker({
        color: "#FFFFFF",
        flat: true,
        onChange: function (hsb, hex, rgb) {
            $('#colorSeleccionadoImagen').css('backgroundColor', '#' + hex);
            $("#colorHiddenImagen").val('#'+hex);
        }
    });
    
    //validamos el tiempo que escriben en el campo de Imagen
    $("#tiempoInicioImagen").blur(validarTiemposImagen);
    $("#tiempoFinImagen").blur(validarTiemposImagen);
});

function mostrarDialogoInsertarImagen(){
    
    editarImagenBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();
    var totalTime = getTotalTime();
    $('#tiempoInicioImagen').val(transformaSegundos(currentTime));
    $('#tiempoFinImagen').val(transformaSegundos(currentTime + 10));
    //console.log("mostrar Dialogo Insertar Imagen");
    $('#tiempoRangeSliderImagen').slider({
        range: true,
        min: 0,
        max: totalTime,
        values: [ currentTime, currentTime + 10 ],
        slide: function( event, ui ) {
            //console.log( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]);
            if(ui.values[0] == ui.values[1])
                ui.values[1] = ui.values[1]+1;
            $('#tiempoInicioImagen').val(transformaSegundos(ui.values[ 0 ]));
            $('#tiempoFinImagen').val(transformaSegundos(ui.values[ 1 ]));
        }
    });
    $("#dialog-form-imagen").dialog("open");
}

function cargarImagenEnArreglo(urlImagen, inicio, fin, color, top, left, width, height){
    imagenes.push({
        urlImagen : urlImagen,
        inicio : inicio,
        fin : fin,
        color : color,
        top : top,
        left : left,
        height : height,
        width: width
    }); 
}

function agregarImagen(){    
    var urlImagen = $("#urlImagen").val();
    var inicio = $("#tiempoInicioImagen").val();
    var fin = $("#tiempoFinImagen").val();
    var color = $("#colorHiddenImagen").val();
    
    agregarImagenDiv(imagenes.length, urlImagen, inicio, fin, color, 50, 50, 300, 200);
    cargarImagenEnArreglo(urlImagen, inicio, fin, color, 50, 50, 300, 200);
}

function mostrarDialogoEditarImagen(idImagen){
    editarImagenBandera = true;
    idEditarImagen = idImagen;
    pauseVideo();
    $("#urlImagen").val(imagenes[idImagen].urlImagen);
    
    var inicio = stringToSeconds(imagenes[idImagen].inicio);
    var fin = stringToSeconds(imagenes[idImagen].fin);
    var totalTime = getTotalTime();
    
    var color = imagenes[idImagen].color;
    
    cambiarColorPicker(color,"Imagen");
    
    $('#tiempoInicioImagen').val(imagenes[idImagen].inicio);
    $('#tiempoFinImagen').val(imagenes[idImagen].fin);
    $('#tiempoRangeSliderImagen').slider({
        range: true,
        min: 0,
        max: totalTime,
        values: [ inicio, fin ],
        slide: function( event, ui ) {
            //console.log( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]);
            if(ui.values[0] == ui.values[1])
                ui.values[1] = ui.values[1]+1;
            $('#tiempoInicioImagen').val(transformaSegundos(ui.values[ 0 ]));
            $('#tiempoFinImagen').val(transformaSegundos(ui.values[ 1 ]));
        }
    });
    $("#dialog-form-imagen").dialog("open");
}

function editarImagen(){
    var urlImagen = $("#urlImagen").val();
    var inicio = $("#tiempoInicioImagen").val();
    var fin = $("#tiempoFinImagen").val();
    var color = $("#colorHiddenImagen").val();
    var position = $("#imagen_"+idEditarImagen).position();    
    //console.log("position = "+position.top+" - "+position.left);
    var width = $("#imagen_"+idEditarImagen).width();
    var height = $("#imagen_"+idEditarImagen).height();
    
    agregarImagenDiv(imagenes.length, urlImagen, inicio, fin, color, position.top, position.left, width, height);
    cargarImagenEnArreglo(urlImagen, inicio, fin, color, position.top, position.left, width, height);
    
    borrarImagen(idEditarImagen);
}

function agregarImagenDiv(indice, urlImagen, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="imagen_'+indice+'" class="ui-corner-all imagenAgregada  stack" style="background-color: '+color+'; position: fixed; top: '+top+'px; left: '+left+'px; width: '+width+'px; height: '+height+'px;">' +
    '<div class="elementButtons">' +
    '<a href="#" onclick=mostrarDialogoEditarImagen('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-wrench" >' +
    'Editar' +
    '</span>' +
    '</div>' +
    '</a>'+
    '<a href="#" onclick=dialogoBorrarImagen('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-closethick" >' +
    'Borrar' +
    '</span>' +
    '</div>' +
    '</a>'+    
    '</div>' +
    '<div>'+
    '<img src="'+urlImagen+'" style="width:98%; height: 98%;position: absolute;top:1%;left:1%;"/>'+
    '</div>' +
    '</div>';
 
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    
    $("#imagen_"+indice).draggable({
        containment: "#editorContainment",
        stack: ".stack",
        stop: function(event, ui){
            //ui.position - {top, left} current position
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            imagenes[indice].top = ui.offset.top;
            imagenes[indice].left = ui.offset.left;
        }
    });
    $("#imagen_"+indice).resizable({
        minHeight: 50,
        minWidth: 100,
        stop: function(event, ui){
            //ui.size - {width, height} current size
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            imagenes[indice].width = ui.size.width;
            imagenes[indice].height = ui.size.height;
        }
    });
}

function dialogoBorrarImagen(indice){
    $("#modalDialog").html("<p>&iquest;Seguro que deseas eliminar este elemento?</p>");
    $( "#modalDialog" ).dialog({
        height: 160,
        width: 400,
        modal: true,
        buttons: {
            Si: function() {
                borrarImagen(indice);
                $( this ).dialog( "close" );
            },
            Cancelar: function() {
                $( this ).dialog( "close" );
            }
        }
    });  
    $( "#modalDialog" ).dialog("open");
}

function borrarImagen(indice){    
    destroyPopcorn();   
    imagenes.splice(indice,1);
    inicializarPopcorn();        
}

function eliminarImagenes(){
    $(".imagenAgregada").remove();
    $(".imagenAgregada").draggable("destroy");
    $(".imagenAgregada").resizable("destroy");
}

function cargarImagenes(){    
    var i;    
    //console.log("Se cargaran "+ imagenes.length +" imagenes");
    //logImagenesAgregadas();
    for(i=0;i<imagenes.length;i++){
        agregarImagenDiv(i, imagenes[i].urlImagen, imagenes[i].inicio, imagenes[i].fin, imagenes[i].color, imagenes[i].top, imagenes[i].left, imagenes[i].width, imagenes[i].height);
    }
}

function logImagenesAgregadas(){
    var i;
    if(imagenes.length > 0){
        console.log("Imagenes agregados:")
        for(i=0;i<imagenes.length;i++){
            console.log(i+")");
            console.log(imagenes[i].urlImagen);
            console.log(" --Tiempo{"+imagenes[i].inicio+" - "+imagenes[i].fin+"} ");
            console.log(" --Color"+imagenes[i].color);
            console.log(" --Posicion{t="+imagenes[i].top+", l="+imagenes[i].left+"} ");
            console.log(" --Tamano{w="+imagenes[i].width+", h="+imagenes[i].height+"} ");
        }
    }else{
        console.log("No hay imagenes");
    }
}

//Valida el input de los tiempos en el slider
function validarTiemposImagen(){    
    var $videoDuration = getTotalTime();
    $("#tiempoInicioImagen").val($("#tiempoInicioImagen").val().substr(0, 5));
    $("#tiempoFinImagen").val($("#tiempoFinImagen").val().substr(0, 5));
    
    var $ini = stringToSeconds($("#tiempoInicioImagen").val().substr(0, 5));
    var $fin = stringToSeconds($("#tiempoFinImagen").val().substr(0, 5));
    
    if($ini < 0)
        $ini = 0;
    if($fin < 0)
        $fin = 1;
    if($ini >= $videoDuration)
        $ini = $videoDuration-1;
    
    if($ini >= $fin)
        $fin = $ini +1;
    
    if($fin > $videoDuration)
        $fin = $videoDuration;
    
    $("#tiempoRangeSliderImagen").slider( "option", "values", [$ini,$fin] );
    
    $("#tiempoInicioImagen").val(transformaSegundos($ini));
    $("#tiempoFinImagen").val(transformaSegundos($fin));
}

