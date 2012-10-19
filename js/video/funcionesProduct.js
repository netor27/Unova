var pop;

document.addEventListener("DOMContentLoaded", function () {
	
    pop = Popcorn("#video");
    pop.controls(true);
    pop.volume(1);
    pop.autoplay(true);
	
    pop.footnote({
        start:1,
        end:10,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/unova.png') ><div class='bloque'><img src='layout/imagenes/video/unova.png'></div></a>",
        target:"bottomRight"
    });
    
    pop.footnote({
        start:40,
        end:59,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/unova3.jpg') ><div class='bloque'><img src='layout/imagenes/video/unova3.jpg' style='width: 300px;'><br><h3>Click me!</h3></div></a>",
        target:"topCenter"
    });
    
    pop.footnote({
        start:20,
        end:62,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/unova1.jpg') ><div class='bloque'><img src='layout/imagenes/video/unova1.jpg' style='width: 300px;'><br><h3>Click me!</h3></div></a>",
        target:"bottomRight"
    });
    
    pop.footnote({
        start:20,
        end:62,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/unova2.jpg') ><div class='bloque'><img src='layout/imagenes/video/unova2.jpg' style='width: 300px;'><br><h3>Click me!</h3></div></a>",
        target:"bottomLeft"
    });
    
    pop.footnote({
        start:67,
        end:75,
        text:"<div class='bloque'>This is a text!</div>",
        target:"middleCenter"
    });
    
    pop.footnote({
        start:68,
        end:77,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/bandera.jpg') ><div class='bloque'><img src='layout/imagenes/video/bandera.jpg' style='width: 200px;'><br><h3>Click me!</h3></div></a>",
        target:"topRight"
    });
    
    pop.footnote({
        start:69,
        end:78,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/maya.jpg') ><div class='bloque'><img src='layout/imagenes/video/maya.jpg' style='width: 200px;'><br><h3>Click me!</h3></div></a>",
        target:"topLeft"
    });
    
    pop.footnote({
        start:70,
        end:79,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/rev.jpg') ><div class='bloque'><img src='layout/imagenes/video/rev.jpg' style='width: 200px;'><br><h3>Click me!</h3></div></a>",
        target:"middleLeft"
    });
    
    pop.footnote({
        start:70,
        end:80,
        text:"<a href='#' onclick=mostrarSitioWeb('www.unova.mx')><div class='bloque'>Unova website!</div></a>",
        target:"middleCenter"
    });	
    
    pop.footnote({
        start:94,
        end:105,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/napoleon.jpg') ><div class='bloque'><h2>Napoleon</h2><br><img src='layout/imagenes/video/napoleon.jpg' style='width: 200px;'><br><h3>Click me!</h3></div></a>",
        target:"middleRight"
    });
    
    pop.footnote({
        start:101,
        end:106,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/Alexander.jpg') ><div class='bloque'><h2>Alexander the great</h2><br><img src='layout/imagenes/video/Alexander.jpg' style='width: 200px;'><br><h3>Click me!</h3></div></a>",
        target:"bottomCenter"
    });
    
    pop.footnote({
        start:101,
        end:106,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/JulioCesar.png') ><div class='bloque'><h2>Julius Cesar</h2><br><img src='layout/imagenes/video/JulioCesar.png' style='width: 200px;'><br><h3>Click me!</h3></div></a>",
        target:"topLeft"
    });
    
    pop.footnote({
        start:94,
        end:110,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/timeLine.jpg') ><div class='bloque'><h2>Time Line</h2><br><img src='layout/imagenes/video/timeLine.jpg' style='width: 200px;'><br><h3>Click me!</h3></div></a>",
        target:"topRight"
    });
    
    pop.footnote({
        start:110,
        end:113,
        text:"<a href='#' onclick=mostrarImagen('layout/imagenes/video/josephine.jpg') ><div class='bloque'><h2>Josephine</h2><br><img src='layout/imagenes/video/josephine.jpg' style='width: 200px;'><br><h3>Click me!</h3></div></a>",
        target:"bottomLeft"
    });

    
    pop.footnote({
        start:110,
        end:114,
        text:"<a href='#' onclick=mostrarWikiInfo('http://en.wikipedia.org/wiki/Jos%C3%A9phine_de_Beauharnais')><div class='bloque'><h3>Josephine in Wikipedia</h3><br><h3>Click me!</h3></div></a>",
        target:"topLeft"
    });
    

}, false);

function mostrarImagen(urlImagen){
    
    $('.infodiv').show();
    hideStripes();
    var currentTime = pop.currentTime();
    console.log(currentTime);
	
    pop.footnote({
        start: currentTime,
        end: currentTime+0.5,
        text: "<div style='float:left; width:95%; text-align:center;'><img style='width:100%;' src='"+urlImagen+"'></div>",        
        target: "infodiv"
    });
    pop.footnote({
        start: currentTime,
        end: currentTime+0.5,
        text: "<div class='btnCerrar'><a href='#'><img src='layout/imagenes/video/cross-white.png' onclick='cerrarInfo()'></a></div>",
        target: "infodiv"
    });
	
    pauseVideo();
    pop.controls(false);
}

function mostrarWikiInfo(pagina){
    console.log("Entre a la funcion mostrarWikiInfo() con la pagina = " + pagina);
   
    $('.infodiv').show();
    hideStripes();
    var currentTime = pop.currentTime();
    console.log(currentTime);
	
    pop.wikipedia({
        start: currentTime,
        end: currentTime+0.5,
        lang: 'en',
        src: pagina,
        target: "infodiv"
    });
    pop.footnote({
        start: currentTime,
        end: currentTime+0.5,
        text: "<div class='btnCerrar'><a href='#'><img src='layout/imagenes/video/cross-white.png' onclick='cerrarInfo()'></a></div>",
        target: "infodiv"
    });
	
    pauseVideo();
    pop.controls(false);
}

function mostrarSitioWeb(pagina){
    $('.infodiv').show();
    $('.webpages-a').css("min-height","900px");
    hideStripes();
    var currentTime = pop.currentTime();
    console.log(currentTime);
    pop.footnote({
        start: currentTime,
        end: currentTime+0.5,
        text: "<div class='btnCerrar'><a href='#'><img src='layout/imagenes/video/cross-white.png' onclick='cerrarInfo()'></a></div>",
        target: "infodiv"
    });
    pop.webpage({
        id: "webpages-a",
        start: currentTime,
        end: currentTime+0.5,
        src: pagina,
        target: "infodiv"
    });
    $('#webpages-a').css("min-height","700px");
    pauseVideo();
    pop.controls(false);
}

function cerrarInfo(){
    $('.infodiv').hide();
    $('.infodiv').html("");
    showStripes();
    pop.controls(true);
    playVideo();
}

function playVideo(){
    pop.play();
}

function pauseVideo(){
    pop.pause();
}

function mostrarEjercicio(){
    pauseVideo();
    pop.controls(false);
    hideStripes();
	
    $('.infodiv').show();
    $('.infodiv').load("ejercicio1.html");
    $('.error').hide();
}
function validarRespuesta(){
    if($('#correcto').is(':checked')){
        $('.infodiv').html('<h1>¡Respuesta correcta!</h1><button type="button" onclick="cerrarInfo()"> Continuar </button>');
    }else{
        $('.error').show();
    }
}

function hideStripes(){
    $('.top').hide();
    $('.middle').hide();
    $('.bottom').hide();
}
function showStripes(){
    $('.top').show();
    $('.middle').show();
    $('.bottom').show();
}

function setVideoTime(seconds){
    pop.currentTime(seconds);
}