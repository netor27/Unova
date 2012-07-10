var links = [];
var editarLinkBandera = false;
var idEditarLink = -1;

$(function(){
    
    $("#dialog-form-link").dialog({
        autoOpen: false,
        height:650,
        width: 550,
        modal: true,
        buttons:{
            "Aceptar": function(){
                if(editarLinkBandera){
                    editarLink();
                }else{
                    agregarLink();    
                }
                
                $(this).dialog("close");
                $('#urlLink').val("");
                $('#textoLink').val("");
            },
            "Cancelar": function(){
                $(this).dialog("close");
            }
        }
    });	
    
    $("#colorHiddenLink").val("#FFFFFF");
    $('#colorSelectorLink').ColorPicker({
        color: "#FFFFFF",
        flat: true,
        onChange: function (hsb, hex, rgb) {
            $('#colorSeleccionadoLink').css('backgroundColor', '#' + hex);
            $("#colorHiddenLink").val('#'+hex);
        }
    });
    
    //validamos el tiempo que escriben en el campo del link
    $("#tiempoInicioLink").blur(validarTiemposLink);
    $("#tiempoFinLink").blur(validarTiemposLink);
    
    $('#linkAccordion').accordion({
        autoHeight: false
    });
});

function mostrarDialogoInsertarLink(){
    editarLinkBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();
    var totalTime = getTotalTime();
    $('#tiempoInicioLink').val(transformaSegundos(currentTime));
    $('#tiempoFinLink').val(transformaSegundos(currentTime + 10));
    $('#tiempoRangeSliderLink').slider({
        range: true,
        min: 0,
        max: totalTime,
        values: [ currentTime, currentTime + 10 ],
        slide: function( event, ui ) {
            if(ui.values[0] == ui.values[1])
                ui.values[1] = ui.values[1]+1;
            $('#tiempoInicioLink').val(transformaSegundos(ui.values[ 0 ]));
            $('#tiempoFinLink').val(transformaSegundos(ui.values[ 1 ]));
        }
    });
    $("#dialog-form-link").dialog("open");
}

function cargarLinkEnArreglo(texto, url, inicio, fin, color, top, left, width, height){    
    links.push({
        texto : texto, 
        url : url,
        inicio : inicio,
        fin : fin,
        color : color,
        top : top,
        left : left,
        height : height,
        width: width
    }); 
}

function agregarLink(){    
    var texto = $("#textoLink").val();
    var url = $("#urlLink").val();
    var inicio = $("#tiempoInicioLink").val();
    var fin = $("#tiempoFinLink").val();
    var color = $("#colorHiddenLink").val();
    
    agregarLinkDiv(links.length, texto, url, inicio, fin, color, 50, 50, 'auto', 'auto');
    cargarLinkEnArreglo(texto, url, inicio, fin, color, 50, 50, 'auto', 'auto'); 
}

function mostrarDialogoEditarLink(idLink){
    editarLinkBandera = true;
    idEditarLink = idLink;
    pauseVideo();
    $('#textoLink').val(links[idLink].texto);
    $('#urlLink').val(links[idLink].url);
    
    var inicio = stringToSeconds(links[idLink].inicio);
    var fin = stringToSeconds(links[idLink].fin);
    var totalTime = getTotalTime();
    
    var color = links[idLink].color;
    
    cambiarColorPicker(color,"Link");
    
    $('#tiempoInicioLink').val(links[idLink].inicio);
    $('#tiempoFinLink').val(links[idLink].fin);
    $('#tiempoRangeSliderLink').slider({
        range: true,
        min: 0,
        max: totalTime,
        values: [ inicio, fin ],
        slide: function( event, ui ) {
            //console.log( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]);
            if(ui.values[0] == ui.values[1])
                ui.values[1] = ui.values[1]+1;
            $('#tiempoInicioLink').val(transformaSegundos(ui.values[ 0 ]));
            $('#tiempoFinLink').val(transformaSegundos(ui.values[ 1 ]));
        }
    });
    $("#dialog-form-link").dialog("open");
}

function editarLink(){
    var texto = $("#textoLink").val();
    var url = $("#urlLink").val();
    var inicio = $("#tiempoInicioLink").val();
    var fin = $("#tiempoFinLink").val();
    var color = $("#colorHiddenLink").val();
    var position = $("#link_"+idEditarLink).position();    
    //console.log("position = "+position.top+" - "+position.left);
    var width = $("#link_"+idEditarLink).width();
    var height = $("#link_"+idEditarLink).height();
    
    agregarLinkDiv(links.length, texto, url, inicio, fin, color, position.top, position.left, width, height);
    cargarLinkEnArreglo(texto, url, inicio, fin, color, position.top, position.left, width, height);
    
    borrarLink(idEditarLink);
}

function agregarLinkDiv(indice, texto, url, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="link_'+indice+'" class="ui-corner-all linkAgregado  stack" style="background-color: '+color+'; position: fixed; top: '+top+'px; left: '+left+'px; width: '+width+'px; height: '+height+'px;">' +
    '<div class="elementButtons">' +
    '<a href="#" onclick=mostrarDialogoEditarLink('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-wrench" >' +
    'Editar' +
    '</span>' +
    '</div>' +
    '</a>'+
    '<a href="#" onclick=dialogoBorrarLink('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-closethick" >' +
    'Borrar' +
    '</span>' +
    '</div>' +
    '</a>'+    
    '</div>' +
    '<a href="'+url+'" target="_blank" class="textoLink">'+
    '<div>' +
    texto +
    '</div>' +
    '</a>'+
    '</div>';
    
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    
    $("#link_"+indice).draggable({
        containment: "#editorContainment",
        stack: ".stack",
        stop: function(event, ui){
            //ui.position - {top, left} current position
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            links[indice].top = ui.offset.top;
            links[indice].left = ui.offset.left;
        //logLinksAgregados();
        }
    });
    $("#link_"+indice).resizable({
        minHeight: 50,
        minWidth: 50,
        stop: function(event, ui){
            //ui.size - {width, height} current size
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            links[indice].width = ui.size.width;
            links[indice].height = ui.size.height;
        //logLinksAgregados();
        }
    });
}

function dialogoBorrarLink(indice){
    $("#modalDialog").html("<p>&iquest;Seguro que deseas eliminar este elemento?</p>");
    $( "#modalDialog" ).dialog({
        height: 160,
        width: 400,
        modal: true,
        buttons: {
            Si: function() {
                borrarLink(indice);
                $( this ).dialog( "close" );
            },
            Cancelar: function() {
                $( this ).dialog( "close" );
            }
        }
    });  
    $( "#modalDialog" ).dialog("open");
}

function borrarLink(indice){    
    destroyPopcorn();    
    links.splice(indice,1);
    inicializarPopcorn();        
}

function eliminarLinks(){
    $(".linkAgregado").remove();
    $(".linkAgregado").draggable("destroy");
    $(".linkAgregado").resizable("destroy");
}

function cargarLinks(){    
    var i;    
    //console.log("Se cargaran "+ textos.length +" textos");
    //logTextosAgregados();
    for(i=0;i<links.length;i++){
        agregarLinkDiv(i, decode_utf8(links[i].texto), links[i].url, links[i].inicio, links[i].fin, links[i].color, links[i].top, links[i].left, links[i].width, links[i].height);
    }
}

function logLinksAgregados(){
    var i;
    if(links.length > 0){
        console.log("Links agregados:")
        for(i=0;i<links.length;i++){
            console.log(i+")");
            console.log(links[i].texto);
            console.log(" --Url "+links[i].url);
            console.log(" --Tiempo{"+links[i].inicio+" - "+links[i].fin+"} ");
            console.log(" --Color"+links[i].color);
            console.log(" --Posicion{t="+links[i].top+", l="+links[i].left+"} ");
            console.log(" --Tamano{w="+links[i].width+", h="+links[i].height+"} ");
        }
    }else{
        console.log("No hay links");
    }
}

//Valida el input de los tiempos en el slider
function validarTiemposLink(){    
    var $videoDuration = getTotalTime();
    $("#tiempoInicioLink").val($("#tiempoInicioLink").val().substr(0, 5));
    $("#tiempoFinLink").val($("#tiempoFinLink").val().substr(0, 5));
    
    var $ini = stringToSeconds($("#tiempoInicioLink").val().substr(0, 5));
    var $fin = stringToSeconds($("#tiempoFinLink").val().substr(0, 5));
    
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
    
    $("#tiempoRangeSliderLink").slider( "option", "values", [$ini,$fin] );
    
    $("#tiempoInicioLink").val(transformaSegundos($ini));
    $("#tiempoFinLink").val(transformaSegundos($fin));
}

