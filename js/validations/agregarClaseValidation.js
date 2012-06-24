$(document).ready(function(){
    var form = $("#customForm");  
    var titulo = $("#titulo");  
    var tituloInfo = $("#tituloInfo");  
    var descripcion = $("#descripcion");  
    var descripcionInfo = $("#descripcionInfo ");  
    
    function validateTitulo(){  
        //Si no es valido
        
        if(trim(titulo.val()).length < 5 ){  
            titulo.addClass("error");  
            tituloInfo.text("El título debe tener por lo menos 5 letras");  
            tituloInfo.addClass("error");  
            return false;  
        } else if(trim(titulo.val()).length > 100){
            titulo.addClass("error");  
            tituloInfo.text("El título no puede tener más de  100 letras");  
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
    function validateDescripcion(){        
        //Si no es valido        
        
        if(trim(descripcion.val()).length < 10 ){  
            descripcion.addClass("error");  
            descripcionInfo.text("La descripción  debe tener por lo menos 10 letras");  
            descripcionInfo.addClass("error");  
            return false;  
        }
        //Si es valido 
        else{  
            descripcion.removeClass("error");  
            descripcionInfo.text("Escribe la descripción de la clase.");  
            descripcionInfo.removeClass("error");  
            return true;  
        }  
    }
   
    //On blur
    titulo.blur(validateTitulo);  
    descripcion.blur(validateDescripcion);  
    
    //On key press  
    titulo.keyup(validateTitulo);  
    descripcion.keyup(validateDescripcion);
   
    form.submit(function(){  
        if(validateTitulo() && validateDescripcion())  
            return true  
        else  
            return false;  
    });  
});