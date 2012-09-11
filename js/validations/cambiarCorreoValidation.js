$(document).ready(function(){
    var form = $("#customForm");  
    var email = $("#email");  
    var emailInfo = $("#emailInfo");  
    
    function validateEmail(){
        
        var a = $("#email").val();
        var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
        
        if(filter.test(a)){
            email.removeClass("error");
            emailInfo.text("");
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
    

    //On blur
    email.blur(validateEmail);  
    //On key press  
    email.keyup(validateEmail);
    
    form.submit(function(){  
        if(validateEmail())
            return true  
        else  
            return false;  
    });  
});