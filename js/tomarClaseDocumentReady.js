var $popPrincipal;
var $indice = 0;

$(function(){
    $(".videoClass").bind("contextmenu", function(e) {
        e.preventDefault();
    });
    
});

Popcorn( function() {
    $popPrincipal = Popcorn('#videoPrincipal');
    $popPrincipal.controls(true);
    $popPrincipal.volume(0.5);
    $popPrincipal.autoplay(true);
    cargarElementosGuardados();
});

function pauseVideo(){
    $popPrincipal.pause();
}

function getUnidadPx(unidad){
    if(unidad.indexOf("auto") != -1){
        return unidad;
    }else{
        return unidad + "px";
        
    }
}


function agregarTextoDiv(texto, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="drag_'+$indice+'" class="ui-corner-all textoAgregado stack draggable" style="background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<div>' +
    texto +
    '</div>' +
    '</div>';
 
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    $("#drag_"+$indice).draggable({
        containment: "#editorContainment",
        stack: ".stack"
    });
    $indice++;
}

function agregarImagenDiv(urlImagen, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="drag_'+$indice+'"  class="ui-corner-all imagenAgregada stack draggable" style="background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
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
     $("#drag_"+$indice).draggable({
        containment: "#editorContainment",
        stack: ".stack"
    });
    $indice++;
}

function agregarLinkDiv(texto, url, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="drag_'+$indice+'"  class="ui-corner-all linkAgregado stack draggable" style="background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<a href="'+url+'" target="_blank" onclick="pauseVideo()" class="textoLink">'+
    '<div>' +
    decode_utf8(texto) +
    '</div>' +
    '</a>'+
    '</div>';
    
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
     $("#drag_"+$indice).draggable({
        containment: "#editorContainment",
        stack: ".stack"
    });
    $indice++;
}

var $idVideo = 0;
function agregarVideoDiv(urlVideo, inicio, fin, color, top, left, width, height){
    var indiceVideo = $idVideo;
    $idVideo++;
    var textoDiv = '<div id="videoContainer_'+indiceVideo+'" class="ui-corner-all videoAgregado draggable" style="background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<div id="video_'+indiceVideo+'" class="videoPopcorn" style="width:98%; height: 98%;position: absolute;top:1%;left:1%;">'+
    '</div>' +
    '</div>';
 
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    var auxVarVideo = Popcorn.smart('#video_'+indiceVideo, urlVideo);
    auxVarVideo.autoplay(false);
    auxVarVideo.pause();
    auxVarVideo.on("playing", function() {    	
        pauseVideo();
    });
     $("#videoContainer_"+indiceVideo).draggable({
        containment: "#editorContainment",
        stack: ".stack"
    });
}
