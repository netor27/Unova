var textos = [];
var editarTextoBandera = false;
var idEditar = -1;

$(function(){
    
    $("#dialog-form-texto").dialog({
        autoOpen: false,
        height:650,
        width: 550,
        modal: true,
        buttons:{
            "Aceptar": function(){
                if(editarTextoBandera){
                    editarTexto();
                }else{
                    agregarTexto();    
                }
                
                $(this).dialog("close");
                $('#textoTinyMce').html("");
            },
            "Cancelar": function(){
                $(this).dialog("close");
            }
        }
    });	
    
    $("#colorHiddenTexto").val("#FFFFFF");
    $('#colorSelectorTexto').ColorPicker({
        color: "#FFFFFF",
        flat: true,
        onChange: function (hsb, hex, rgb) {
            $('#colorSeleccionadoTexto').css('backgroundColor', '#' + hex);
            $("#colorHiddenTexto").val('#'+hex);
        }
    });
    
    //validamos el tiempo que escriben en el campo de texto
    $("#tiempoInicioTexto").blur(validarTiemposTexto);
    $("#tiempoFinTexto").blur(validarTiemposTexto);
    
    $('#textoTinyMce').tinymce({
        script_url : '/lib/js/tiny_mce/tiny_mce.js',
        theme : "advanced",
        skin:"o2k7",    
        skin_variant:"silver",
        width : "320",        
        height : "320",
                
        // Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "undo,redo,|,cut,copy,paste,|,bold,italic,underline,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,|,bullist,numlist,|,link,preview",
        theme_advanced_buttons2 : "fontselect,fontsizeselect",
        theme_advanced_buttons3 : "",      
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom"
    });  
    
    $('#textAccordion').accordion({
        autoHeight: false
    });
});

function mostrarDialogoInsertarTexto(){
    editarTextoBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();
    var totalTime = getTotalTime();
    $('#tiempoInicioTexto').val(transformaSegundos(currentTime));
    $('#tiempoFinTexto').val(transformaSegundos(currentTime + 10));
    $('#tiempoRangeSliderTexto').slider({
        range: true,
        min: 0,
        max: totalTime,
        values: [ currentTime, currentTime + 10 ],
        slide: function( event, ui ) {
            //console.log( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]);
            if(ui.values[0] == ui.values[1])
                ui.values[1] = ui.values[1]+1;
            $('#tiempoInicioTexto').val(transformaSegundos(ui.values[ 0 ]));
            $('#tiempoFinTexto').val(transformaSegundos(ui.values[ 1 ]));
        }
    });
    $("#dialog-form-texto").dialog("open");
}

function cargarTextoEnArreglo(texto, inicio, fin, color, top, left, width, height){
    textos.push({
        texto : texto, 
        inicio : inicio,
        fin : fin,
        color : color,
        top : top,
        left : left,
        height : height,
        width: width
    });   
}

function agregarTexto(){    
    var texto = $("#textoTinyMce").tinymce().getContent();
    texto = texto.replace(/(\r\n|\n|\r)/gm,"<br>");
    var inicio = $("#tiempoInicioTexto").val();
    var fin = $("#tiempoFinTexto").val();
    var color = $("#colorHiddenTexto").val();
    
    
    agregarTextoDiv(textos.length, texto, inicio, fin, color, 50, 50, 'auto', 'auto');
    cargarTextoEnArreglo(texto, inicio, fin, color, 50, 50, 'auto', 'auto');
    
}

function mostrarDialogoEditarTexto(idTexto){
    editarTextoBandera = true;
    idEditar = idTexto;
    pauseVideo();
    $('#textoTinyMce').html(textos[idTexto].texto);
    
    var inicio = stringToSeconds(textos[idTexto].inicio);
    var fin = stringToSeconds(textos[idTexto].fin);
    var totalTime = getTotalTime();
    
    var color = textos[idTexto].color;
    
    cambiarColorPicker(color,"Texto");
    
    $('#tiempoInicioTexto').val(textos[idTexto].inicio);
    $('#tiempoFinTexto').val(textos[idTexto].fin);
    $('#tiempoRangeSliderTexto').slider({
        range: true,
        min: 0,
        max: totalTime,
        values: [ inicio, fin ],
        slide: function( event, ui ) {
            //console.log( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]);
            if(ui.values[0] == ui.values[1])
                ui.values[1] = ui.values[1]+1;
            $('#tiempoInicioTexto').val(transformaSegundos(ui.values[ 0 ]));
            $('#tiempoFinTexto').val(transformaSegundos(ui.values[ 1 ]));
        }
    });
    $("#dialog-form-texto").dialog("open");
}

function editarTexto(){
    var texto = $("#textoTinyMce").tinymce().getContent();
    texto = texto.replace(/(\r\n|\n|\r)/gm,"<br>");
    var inicio = $("#tiempoInicioTexto").val();
    var fin = $("#tiempoFinTexto").val();
    var color = $("#colorHiddenTexto").val();
    
    $containmentWidth = $("#editorContainment").width();
    $containmentHeight  = $("#editorContainment").height();
    
    var position = $("#texto_"+idEditar).position();        
    position.top = position.top * 100 / $containmentHeight;
    position.left = position.left * 100 / $containmentWidth;     
    
    var width = $("#texto_"+idEditar).width();
    var height = $("#texto_"+idEditar).height();
    width = width * 100 / $containmentWidth;
    height = height * 100/ $containmentHeight;
    
    agregarTextoDiv(textos.length, texto, inicio, fin, color, position.top, position.left, width, height);   
    cargarTextoEnArreglo(texto, inicio, fin, color, position.top, position.left, width, height);
    
    borrarTexto(idEditar);
}

function agregarTextoDiv(indice, texto, inicio, fin, color, top, left, width, height){
    
    var textoDiv = '<div id="texto_'+indice+'" class="ui-corner-all textoAgregado stack draggable" style="overflow:auto; background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<div id="content_'+indice+'" style="width:90%; height:90%; padding:5px;">'+
    '<div class="elementButtons">' +
    '<a href="#" onclick=mostrarDialogoEditarTexto('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-wrench" >' +
    'Editar' +
    '</span>' +
    '</div>' +
    '</a>'+
    '<a href="#" onclick=dialogoBorrarTexto('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-closethick" >' +
    'Borrar' +
    '</span>' +
    '</div>' +
    '</a>'+    
    '</div>' +
    '<div>' +
    texto +
    '</div>' +
    '</div>' +
    '</div>';
 
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    
    $("#texto_"+indice).draggable({
        handle: "#content_"+indice,
        containment: "#editorContainment",
        stack: ".stack",
        stop: function(event, ui){
            //ui.position - {top, left} current position
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            $containmentWidth = $("#editorContainment").width();
            $containmentHeight  = $("#editorContainment").height();
            textos[indice].top = ui.offset.top * 100 / $containmentHeight;
            textos[indice].left = ui.offset.left * 100 / $containmentWidth;            
            logTextosAgregados();   
        }
    });
    $("#texto_"+indice).resizable({
        minHeight: 50,
        minWidth: 50,
        stop: function(event, ui){
            //ui.size - {width, height} current size
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];            
            $containmentWidth = $("#editorContainment").width();
            $containmentHeight  = $("#editorContainment").height();
            textos[indice].height = ui.size.height * 100/ $containmentHeight;
            textos[indice].width = ui.size.width * 100 / $containmentWidth;
        //logTextosAgregados();
        }
    });
}

function dialogoBorrarTexto(indice){
    $("#modalDialog").html("<p>&iquest;Seguro que deseas eliminar este elemento?</p>");
    $( "#modalDialog" ).dialog({
        height: 160,
        width: 400,
        modal: true,
        buttons: {
            Si: function() {
                borrarTexto(indice);
                $( this ).dialog( "close" );
            },
            Cancelar: function() {
                $( this ).dialog( "close" );
            }
        }
    });  
    $( "#modalDialog" ).dialog("open");
}

function borrarTexto(indice){    
    destroyPopcorn();    
    textos.splice(indice,1);
    inicializarPopcorn();        
}

function eliminarTextos(){
    $(".textoAgregado").remove();
    $(".textoAgregado").draggable("destroy");
    $(".textoAgregado").resizable("destroy");
}

function cargarTextos(){    
    var i;    
    //console.log("Se cargaran "+ textos.length +" textos");
    //logTextosAgregados();
    for(i=0;i<textos.length;i++){
        agregarTextoDiv(i, textos[i].texto, textos[i].inicio, textos[i].fin, textos[i].color, textos[i].top, textos[i].left, textos[i].width, textos[i].height);
    }
}

function logTextosAgregados(){
    var i;
    if(textos.length > 0){
        console.log("Textos agregados:")
        for(i=0;i<textos.length;i++){
            console.log(i+")");
            console.log(textos[i].texto);
            console.log(" --Tiempo{"+textos[i].inicio+" - "+textos[i].fin+"} ");
            console.log(" --Color"+textos[i].color);
            console.log(" --Posicion{t="+textos[i].top+", l="+textos[i].left+"} ");
            console.log(" --Tamano{w="+textos[i].width+", h="+textos[i].height+"} ");
        }
    }else{
        console.log("No hay textos");
    }
}

//Valida el input de los tiempos en el slider
function validarTiemposTexto(){    
    var $videoDuration = getTotalTime();
    $("#tiempoInicioTexto").val($("#tiempoInicioTexto").val().substr(0, 5));
    $("#tiempoFinTexto").val($("#tiempoFinTexto").val().substr(0, 5));
    
    var $ini = stringToSeconds($("#tiempoInicioTexto").val().substr(0, 5));
    var $fin = stringToSeconds($("#tiempoFinTexto").val().substr(0, 5));
    
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
    
    $("#tiempoRangeSliderTexto").slider( "option", "values", [$ini,$fin] );
    
    $("#tiempoInicioTexto").val(transformaSegundos($ini));
    $("#tiempoFinTexto").val(transformaSegundos($fin));
}

