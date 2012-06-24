$(document).ready(function(){
    var form = $("#customForm");  
    var passAnterior = $("#passAnterior");
    
    var pass1 = $("#pass1");  
    var pass1Info = $("#pass1Info");  
    var pass2 = $("#pass2");  
    var pass2Info = $("#pass2Info");  

    function validatePassAnterior(){
        if(passAnterior.val().length == 0){
            return 0;
        }
    }
    
    function validatePass1(){  
        var a = $("#password1");  
        var b = $("#password2");  
  
        if(pass1.val().length <5){  
            pass1.addClass("error");  
            pass1Info.text("Introduce una contraseña. Mínimo 5 caracteres");  
            pass1Info.addClass("error");  
            return false;  
        }  
        else{  
            pass1.removeClass("error");  
            pass1Info.text("Introduce una contraseña. Mínimo 5 caracteres");  
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
            pass2Info.text("Repetir contraseña");  
            pass2Info.removeClass("error");  
            return true;  
        }  
    } 

    //On blur
    pass1.blur(validatePass1);  
    pass2.blur(validatePass2);  
    //On key press  
    pass1.keyup(validatePass1);  
    pass2.keyup(validatePass2);  

    form.submit(function(){  
        if(validatePassAnterior() && validatePass1() && validatePass2())  
            return true  
        else  
            return false;  
    });  
});