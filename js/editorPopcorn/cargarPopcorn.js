//variable global para el video principal del curso
var $popPrincipal;
var $videoDuration;

$(function(){
    //Configuración inicial    
    $("#videoContainer").draggable({
        containment: "#editorContainment"
    });
    $("#videoContainer").resizable({
        resize: function(event, ui) {
            var w = $("#videoContainer").width();
            var h = $("#videoContainer").height();
            //console.log("h="+h+" w=" +w);
            $("#videoPrincipal").width(w);
            $("#videoPrincipal").height(h);
        }
    });	
     $(".videoClass").bind("contextmenu", function(e) {
        e.preventDefault();
    });
});

Popcorn( function() {
    inicializarPopcorn();
});

function inicializarPopcorn(){
    $popPrincipal = Popcorn('#videoPrincipal');
    $popPrincipal.controls(false);
    $popPrincipal.volume(0.5);
    $popPrincipal.autoplay(true);

    $popPrincipal.on("timeupdate", function() {
        var current = parseInt($popPrincipal.currentTime());
        $("#slider").slider("value", current);        	
        $('#controlTiempo').text(transformaSegundos(current)+" / "+transformaSegundos($videoDuration));
    });

    $popPrincipal.on("playing", function() {    	
        $videoDuration = $popPrincipal.duration();
        //console.log("inicializare el slider con min = 0 y max = "+$videoDuration);
        //Configuración del slider
        $( "#slider" ).slider({
            range: "min",
            value: 0,
            min: 0,
            max: $videoDuration,
            slide: function( event, ui ) {				
                //console.log("El valor del slider es = " + ui.value);
                $popPrincipal.currentTime(ui.value);	
            }
        });
    });
    cargarTextos();
    cargarImagenes();    
    cargarLinks();
    cargarVideos();
}

//Funciones para pausar y reproducir el video principal
function playVideo(){
    $popPrincipal.play();
}
function pauseVideo(){
    $popPrincipal.pause();
}

//funciones para obtener el tiempo total y el actual
function getCurrentTime(){
    return parseInt($popPrincipal.currentTime());
}
function getTotalTime(){
    return parseInt($popPrincipal.duration());
}

//funcion para eliminar los datos en el popPrincipal
function destroyPopcorn(){
    $popPrincipal.destroy();
    eliminarTextos();
    eliminarImagenes();
    eliminarVideos();
    eliminarLinks();
}