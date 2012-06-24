$(document).ready(function(){
    var form = $("#customForm");  
    var nombre = $("#nombre");  
    var nombreInfo = $("#nombreInfo");  
    var tituloPersonal = $("#tituloPersonal");
    var tituloPersonalInfo = $("#tituloPersonalInfo");
    
    function validateName(){  
        //Si no es valido
        if(nombre.val().length < 4 ){  
            nombre.addClass("error");  
            nombreInfo.text("Tu nombre debe tener por lo menos 4 letras");  
            nombreInfo.addClass("error");  
            return false;  
        } else if(nombre.val().length > 50){
            nombre.addClass("error");  
            nombreInfo.text("Tu nombre no puede tener más de 50 letras");  
            nombreInfo.addClass("error");  
            return false;  
        }
        //Si es valido 
        else{  
            nombre.removeClass("error");  
            nombreInfo.text("¿Cúal es tu nombre?");  
            nombreInfo.removeClass("error");  
            return true;  
        }  
    }  
    function validateTituloPersonal(){  
        //Si no es valido
        if(tituloPersonal.val().length > 100){
            tituloPersonal.addClass("error");  
            tituloPersonalInfo.text("Tu título personal no puede tener más de 100 letras");  
            tituloPersonalInfo.addClass("error");  
            return false;  
        }
        //Si es valido 
        else{  
            tituloPersonal.removeClass("error");  
            tituloPersonalInfo.text("Ejemplos: Experto en tocar la guitarra, Profesor de tiempo completo, diseñador web en Unova, etc.");  
            tituloPersonalInfo.removeClass("error");  
            return true;  
        }  
    }  
    
    //On blur
    nombre.blur(validateName);  
    tituloPersonal.blur(validateTituloPersonal);
    //On key press  
    nombre.keyup(validateName);  
    tituloPersonal.keyup(validateTituloPersonal);
    
    form.submit(function(){  
        if(validateName() && validateTituloPersonal())
            return true  
        else  
            return false;  
    });  
});