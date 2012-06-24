var videos = [];
var editarVideoBandera = false;
var idEditarVideo = -1;

$(function(){
    
    $("#dialog-form-video").dialog({
        autoOpen: false,
        height:650,
        width: 550,
        modal: true,
        buttons:{
            "Aceptar": function(){
                if(editarVideoBandera){
                    editarVideo();
                }else{
                    agregarVideo();    
                }
                
                $(this).dialog("close");
                $("#urlVideo").val("");
            },
            "Cancelar": function(){
                $(this).dialog("close");
            }
        }
    });	 
    $('#videoAccordion').accordion({
        autoHeight: false
    });
    
    $("#colorHiddenVideo").val("#FFFFFF");
    $('#colorSelectorVideo').ColorPicker({
        color: "#FFFFFF",
        flat: true,
        onChange: function (hsb, hex, rgb) {
            $('#colorSeleccionadoVideo').css('backgroundColor', '#' + hex);
            $("#colorHiddenVideo").val('#'+hex);
        }
    });
    
    //validamos el tiempo que escriben en el campo de Video
    $("#tiempoInicioVideo").blur(validarTiemposVideo);
    $("#tiempoFinVideo").blur(validarTiemposVideo);
});

function mostrarDialogoInsertarVideo(){
    editarVideoBandera = false;    
    pauseVideo();
    var currentTime = getCurrentTime();
    var totalTime = getTotalTime();
    $('#tiempoInicioVideo').val(transformaSegundos(currentTime));
    $('#tiempoFinVideo').val(transformaSegundos(currentTime + 10));
    //console.log("mostrar Dialogo Insertar Video");
    $('#tiempoRangeSliderVideo').slider({
        range: true,
        min: 0,
        max: totalTime,
        values: [ currentTime, currentTime + 10 ],
        slide: function( event, ui ) {
            //console.log( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]);
            if(ui.values[0] == ui.values[1])
                ui.values[1] = ui.values[1]+1;
            $('#tiempoInicioVideo').val(transformaSegundos(ui.values[ 0 ]));
            $('#tiempoFinVideo').val(transformaSegundos(ui.values[ 1 ]));
        }
    });
    $("#dialog-form-video").dialog("open");
}

function cargarVideoEnArreglo(urlVideo, inicio, fin, color, top, left, width, height){
    videos.push({
        urlVideo : urlVideo,
        inicio : inicio,
        fin : fin,
        color : color,
        top : top,
        left : left,
        height : height,
        width: width
    }); 
}

function agregarVideo(){    
    var urlVideo = $("#urlVideo").val();
    var inicio = $("#tiempoInicioVideo").val();
    var fin = $("#tiempoFinVideo").val();
    var color = $("#colorHiddenVideo").val();
    
    agregarVideoDiv(videos.length, urlVideo, inicio, fin, color, 0, 0, 350, 300);
    cargarVideoEnArreglo(urlVideo, inicio, fin, color, 0, 0, 350, 300);
    
}

function mostrarDialogoEditarVideo(idVideo){
    editarVideoBandera = true;
    idEditarVideo = idVideo;
    pauseVideo();
    $("#urlVideo").val(videos[idVideo].urlVideo);
    
    var inicio = stringToSeconds(videos[idVideo].inicio);
    var fin = stringToSeconds(videos[idVideo].fin);
    var totalTime = getTotalTime();
    
    var color = videos[idVideo].color;
    
    cambiarColorPicker(color,"Video");
    
    $('#tiempoInicioVideo').val(videos[idVideo].inicio);
    $('#tiempoFinVideo').val(videos[idVideo].fin);
    $('#tiempoRangeSliderVideo').slider({
        range: true,
        min: 0,
        max: totalTime,
        values: [ inicio, fin ],
        slide: function( event, ui ) {
            //console.log( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]);
            if(ui.values[0] == ui.values[1])
                ui.values[1] = ui.values[1]+1;
            $('#tiempoInicioVideo').val(transformaSegundos(ui.values[ 0 ]));
            $('#tiempoFinVideo').val(transformaSegundos(ui.values[ 1 ]));
        }
    });
    $("#dialog-form-video").dialog("open");
}

function editarVideo(){
    var urlVideo = $("#urlVideo").val();
    var inicio = $("#tiempoInicioVideo").val();
    var fin = $("#tiempoFinVideo").val();
    var color = $("#colorHiddenVideo").val();
    var position = $("#video_"+idEditarVideo).offset();    
    //console.log("position = "+position.top+" - "+position.left);
    var width = $("#video_"+idEditarVideo).width();
    var height = $("#video_"+idEditarVideo).height();
    
    agregarVideoDiv(videos.length, urlVideo, inicio, fin, color, position.top, position.left, width, height);
    cargarVideoEnArreglo(urlVideo, inicio, fin, color, position.top, position.left, width, height);
    
    borrarVideo(idEditarVideo);
}

function agregarVideoDiv(indice, urlVideo, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="videoContainer_'+indice+'" class="ui-corner-all videoAgregado" style="background-color: '+color+'; position: absolute; top: '+top+'px; left: '+left+'px; width: '+width+'px; height: '+height+'px;">' +
    '<p class="ui-widget-header dragHandle">Arr&aacute;strame de aqu&iacute;<br></p>'+
    '<div class="elementButtons">' +
    '<a href="#" onclick=mostrarDialogoEditarVideo('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-wrench" >' +
    'Editar' +
    '</span>' +
    '</div>' +
    '</a>'+
    '<a href="#" onclick=dialogoBorrarVideo('+indice+')>'+
    '<div class="ui-state-default ui-corner-all littleBox">' +
    '<span class="ui-icon ui-icon-closethick" >' +
    'Borrar' +
    '</span>' +
    '</div>' +
    '</a>'+    
    '</div>' +
    '<div id="video_'+indice+'" class="videoPopcorn" style="width:98%; height: 98%;position: absolute;top:1%;left:1%;">'+
    '</div>' +
    '</div>';
 
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    
    $("#videoContainer_"+indice).draggable({
        handle: "p", 
        containment: "body",
        stop: function(event, ui){
            //ui.position - {top, left} current position
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            videos[indice].top = ui.position.top;
            videos[indice].left = ui.position.left;
        }
    });
    $("#videoContainer_"+indice).resizable({
        minHeight: 180,
        minWidth: 260,
        stop: function(event, ui){
            //ui.size - {width, height} current size
            var id = ui.helper.attr("id");
            var indice = id.split("_")[1];
            videos[indice].width = ui.size.width;
            videos[indice].height = ui.size.height;
        }
//      resize: function(event, ui) {
//            $("#video_"+indice).children().each(function() {
//                var orig = $(this);		
//                orig.attr("width", ui.size.width)
//                orig.attr("height", ui.size.height);	
//            });
//        }
    });
    var auxVarVideo = Popcorn.smart('#video_'+indice, urlVideo);
    auxVarVideo.autoplay(false);
    auxVarVideo.pause();
    auxVarVideo.on("playing", function() {    	
        pauseVideo();
    });
}

function dialogoBorrarVideo(indice){
    $("#modalDialog").html("<p>&iquest;Seguro que deseas eliminar este elemento?</p>");
    $( "#modalDialog" ).dialog({
        height: 160,
        modal: true,
        buttons: {
            Si: function() {
                borrarVideo(indice);
                $( this ).dialog( "close" );
            },
            Cancelar: function() {
                $( this ).dialog( "close" );
            }
        }
    });  
    $( "#modalDialog" ).dialog("open");
}

function borrarVideo(indice){    
    destroyPopcorn();   
    videos.splice(indice,1);
    inicializarPopcorn();        
}

function eliminarVideos(){
    $(".videoAgregado").remove();
    $(".videoAgregado").draggable("destroy");
    $(".videoAgregado").resizable("destroy");
}

function cargarVideos(){    
    var i;    
    //console.log("Se cargaran "+ videos.length +" videos");
    //logVideosAgregadas();
    for(i=0;i<videos.length;i++){
        agregarVideoDiv(i, videos[i].urlVideo, videos[i].inicio, videos[i].fin, videos[i].color, videos[i].top, videos[i].left, videos[i].width, videos[i].height);
    }
}

function logVideosAgregadas(){
    var i;
    if(videos.length > 0){
        console.log("Videos agregados:")
        for(i=0;i<videos.length;i++){
            console.log(i+")");
            console.log(videos[i].urlVideo);
            console.log(" --Tiempo{"+videos[i].inicio+" - "+videos[i].fin+"} ");
            console.log(" --Color"+videos[i].color);
            console.log(" --Posicion{t="+videos[i].top+", l="+videos[i].left+"} ");
            console.log(" --Tamano{w="+videos[i].width+", h="+videos[i].height+"} ");
        }
    }else{
        console.log("No hay videos");
    }
}

//Valida el input de los tiempos en el slider
function validarTiemposVideo(){    
    var $videoDuration = getTotalTime();
    $("#tiempoInicioVideo").val($("#tiempoInicioVideo").val().substr(0, 5));
    $("#tiempoFinVideo").val($("#tiempoFinVideo").val().substr(0, 5));
    
    var $ini = stringToSeconds($("#tiempoInicioVideo").val().substr(0, 5));
    var $fin = stringToSeconds($("#tiempoFinVideo").val().substr(0, 5));
    
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
    
    $("#tiempoRangeSliderVideo").slider( "option", "values", [$ini,$fin] );
    
    $("#tiempoInicioVideo").val(transformaSegundos($ini));
    $("#tiempoFinVideo").val(transformaSegundos($fin));
}

