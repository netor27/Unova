var $popPrincipal;
var $indice = 0;

$(function(){
    if(layout == "desktop"){
        $(".videoClass").bind("contextmenu", function(e) {
            e.preventDefault();
        });
        $("#menuClasesLink").click(function(e){   
            $("#flechitaClases").toggle("swing");       
            $("#clases_menu").toggle("swing");  
        });
        //Evento para evitar que se cierre al dar click dentro del menu
        $("#clases_menu").mouseup(function(){
            return false;
        });
        //Evento en todo el body que cierra el menu si no 
        $(document).mouseup(function(e){     
            if($(e.target).attr("id") != "menuClasesLink"){
                $("#flechitaClases").hide("swing");
                $("#clases_menu").hide("swing");            
            }
            return true;
        });
    }else {
        //bind para dispositivos con pantalla tactil
        $("#menuClasesLink").bind('touchstart', function(e) {
            $("#flechitaClases").toggle("swing");       
            $("#clases_menu").toggle("swing");  
            $(".videoClass").toggle("swing");
        });
        //Evento para evitar que se cierre al dar click dentro del menu
        $("#clases_menu").bind("touchend",function(){
            return false;
        });
        
        //Evento en todo el body que cierra el menu si no 
        $(document).bind("touchend",function(e){     
            if($(e.target).attr("id") != "menuPerfilLink" &&
                $(e.target).attr("id") != "menuClasesLink" &&
                $(e.target).attr("id") != "menuCursosLink" ){                
                $(".videoClass").show("swing");
            }
            if($(e.target).attr("id") != "menuPerfilLink"){
                $("#flechitaClases").hide("swing");
                $("#clases_menu").hide("swing");    
            }
            return true;
        });
        
        //cerramos el video cuando se da click al menu cursos y menu perfil
        $("#menuPerfilLink").bind("touchstart",function(e){       
            $(".videoClass").toggle("swing");
        });   
        $("#menuCursosLink").bind("touchstart",function(e){       
            $(".videoClass").toggle("swing");
        });
    }
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
        return unidad + "%";
        
    }
}

function agregarTextoDiv(texto, inicio, fin, color, top, left, width, height){
    var textoDiv = '<div id="drag_'+$indice+'" class="ui-corner-all textoAgregado stack draggable" style="overflow:auto;background-color: '+color+'; position: fixed; top: '+getUnidadPx(top)+'; left: '+getUnidadPx(left)+'; width: '+getUnidadPx(width)+'; height: '+getUnidadPx(height)+';">' +
    '<div id="content_'+$indice+'" style="width:90%; height:90%; padding:5px; ">'+
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
    $("#drag_"+$indice).draggable({
        handle: "#content_"+$indice,
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
    '<p class="ui-widget-header dragHandle">Arr&aacute;strame de aqu&iacute;<br></p>'+
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
        handle: "p",
        containment: "#editorContainment",
        stack: ".stack"
    });
}
