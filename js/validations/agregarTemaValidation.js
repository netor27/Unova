$(document).ready(function(){
    var form = $("#customForm");  
    var titulo = $("#titulo");  
    var tituloInfo = $("#tituloInfo");  
    
    function validateTitulo(){  
        //Si no es valido
        
        if(trim(titulo.val()).length < 5 ){  
            titulo.addClass("error");  
            tituloInfo.text("El título debe tener por lo menos 5 letras");  
            tituloInfo.addClass("error");  
            return false;  
        } else if(trim(titulo.val()).length > 50){
            titulo.addClass("error");  
            tituloInfo.text("El título no puede tener más de  50 letras");  
            tituloInfo.addClass("error");  
            return false;  
        }
        //Si es valido 
        else{  
            titulo.removeClass("error");  
            tituloInfo.text("Título");  
            tituloInfo.removeClass("error");  
            return true;  
        }  
    }  
   
    //On blur
    titulo.blur(validateTitulo);  
    //On key press  
    titulo.keyup(validateTitulo);  
    
    form.submit(function(){  
        if(validateTitulo())  
            return true  
        else  
            return false;  
    });  
});