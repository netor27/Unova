var $popPrincipal;

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
    var textoDiv = '<div class="ui-corner-all textoAgregado" style="background-color: '+color+'; position: absolute; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
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
}

function agregarImagenDiv(urlImagen, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div  class="ui-corner-all imagenAgregada" style="background-color: '+color+'; position: absolute; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
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
}

function agregarLinkDiv(texto, url, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div  class="ui-corner-all linkAgregado" style="background-color: '+color+'; position: absolute; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<a href="'+url+'" target="_blank" onclick="pauseVideo()" class="textoLink">'+
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
}

var $idVideo = 0;
function agregarVideoDiv(urlVideo, inicio, fin, color, top, left, width, height){
    var indice = $idVideo;
    $idVideo++;
    var textoDiv = '<div id="videoContainer_'+indice+'" class="ui-corner-all videoAgregado" style="background-color: '+color+'; position: absolute; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<div id="video_'+indice+'" class="videoPopcorn" style="width:98%; height: 98%;position: absolute;top:1%;left:1%;">'+
    '</div>' +
    '</div>';
 
    $popPrincipal.footnote({
        start: inicio,
        end: fin,
        text: textoDiv,
        target: "footnotediv"
    });
    var auxVarVideo = Popcorn.smart('#video_'+indice, urlVideo);
    auxVarVideo.autoplay(false);
    auxVarVideo.pause();
    auxVarVideo.on("playing", function() {    	
        pauseVideo();
    });
}
