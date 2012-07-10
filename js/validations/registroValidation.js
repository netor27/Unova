$(document).ready(function(){
    var form = $("#customForm");  
    var nombre = $("#nombre");  
    var nombreInfo = $("#nombreInfo");  
    var email = $("#email");  
    var emailInfo = $("#emailInfo");  
    var pass1 = $("#pass1");  
    var pass1Info = $("#pass1Info");  
    var pass2 = $("#pass2");  
    var pass2Info = $("#pass2Info");  

    function validateName(){  
        //Si no es valido
        if(nombre.val().length < 4 ){  
            nombre.addClass("error");  
            nombreInfo.text("Tu nombre debe tener por lo menos 4 letras");  
            nombreInfo.addClass("error");  
            return false;  
        }  else if(nombre.val().length > 50){
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
    function validateEmail(){
        
        var a = $("#email").val();
        var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
        
        if(filter.test(a)){
            email.removeClass("error");
            emailInfo.text("Por favor introduce un correo electrónico válido");
            emailInfo.removeClass("error");
            return true;
        }
        else{
            email.addClass("error");
            emailInfo.text("Introduce un correo electrónico válido");
            emailInfo.addClass("error");
            return false;
        }
    }
    
    function validatePass1(){  
        var a = $("#password1");  
        var b = $("#password2");  
  
        if(pass1.val().length <5){  
            pass1.addClass("error");  
            pass1Info.text("Por lo menos 5 caracteres");  
            pass1Info.addClass("error");  
            return false;  
        }  
        else{  
            pass1.removeClass("error");  
            pass1Info.text("Por lo menos 5 caracteres");  
            pass1Info.removeClass("error");  
            validatePass2();  
            return true;  
        }  
    }  
    function validatePass2(){  
        var a = $("#password1");  
        var b = $("#password2");  

        if( pass1.val() != pass2.val() ){  
            pass2.addClass("error");  
            pass2Info.text("Las contraseñas no coinciden");  
            pass2Info.addClass("error");  
            return false;  
        }  
        else{  
            pass2.removeClass("error");  
            pass2Info.text("Confirma tu password");  
            pass2Info.removeClass("error");  
            return true;  
        }  
    } 

    //On blur
    nombre.blur(validateName);  
    email.blur(validateEmail);  
    pass1.blur(validatePass1);  
    pass2.blur(validatePass2);  
    //On key press  
    /*nombre.keyup(validateName);  
    email.keyup(validateEmail);
    pass1.keyup(validatePass1);  
    */
    pass2.keyup(validatePass2);  
    

    form.submit(function(){  
        if(validateName() && validateEmail() && validatePass1() && validatePass2())  
            return true  
        else  
            return false;  
    });  
});