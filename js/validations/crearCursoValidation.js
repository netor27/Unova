$(document).ready(function(){
    var form = $("#customForm");  
    var titulo = $("#titulo");  
    var tituloInfo = $("#tituloInfo");  
    var descripcionCorta = $("#descripcionCorta");  
    var descripcionCortaInfo = $("#descripcionCortaInfo ");  
    var palabrasClave = $("#palabrasClave");  
    var palabrasClaveInfo = $("#palabrasClaveInfo"); 

    function validateTitulo(){  
        //Si no es valido
        
        if(trim(titulo.val()).length < 10 ){  
            titulo.addClass("error");  
            tituloInfo.text("El título debe tener por lo menos 10 letras");  
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
    function validateDescripcionCorta(){        
        //Si no es valido        
        
        if(trim(descripcionCorta.val()).length < 10 ){  
            descripcionCorta.addClass("error");  
            descripcionCortaInfo.text("La descripción corta debe tener por lo menos 10 letras");  
            descripcionCortaInfo.addClass("error");  
            return false;  
        } else if(trim(descripcionCorta.val()).length > 140){
            descripcionCorta.addClass("error");  
            descripcionCortaInfo.text("La descripción corta no puede tener más de  140 letras");  
            descripcionCortaInfo.addClass("error");  
            return false;  
        }
        //Si es valido 
        else{  
            descripcionCorta.removeClass("error");  
            descripcionCortaInfo.text("Escribe una descripción corta de tu curso.");  
            descripcionCortaInfo.removeClass("error");  
            return true;  
        }  
    }
    function validatePalabrasClave(){  
        if(trim(palabrasClave.val()).length > 140){
            palabrasClave.addClass("error");  
            palabrasClaveInfo.text("Las palabras clave no pueden sobrepasar 140 letras");  
            palabrasClaveInfo.addClass("error");  
            return false;  
        }
        //Si es valido 
        else{  
            palabrasClave.removeClass("error");  
            palabrasClaveInfo.text("Palabras clave para identificar tu curso. Separadas con comas.");  
            palabrasClaveInfo.removeClass("error");  
            return true;  
        }  
    }  
    
    //On blur
    titulo.blur(validateTitulo);  
    descripcionCorta.blur(validateDescripcionCorta);  
    palabrasClave.blur(validatePalabrasClave);  
    
    //On key press  
    titulo.keyup(validateTitulo);  
    descripcionCorta.keyup(validateDescripcionCorta);
    palabrasClave.keyup(validatePalabrasClave);  

    form.submit(function(){  
        if(validateTitulo() && validateDescripcion() && validatePalabrasClave())  
            return true  
        else  
            return false;  
    });  
    
    //Llamadas AJAX al servidor para llenar los dropdown de las categorias
    $('#categoria').change(function(e) {                    
        $.get("/categorias/categoria/subcategorias/"+$('#categoria').val(),
            function(data){
                $('#subcategoria').empty();
                var i;
                for(i = 0; i < data.length; i++){
                    if(i == 0)
                        $('#subcategoria').append("<option value='" + data[i].idSubcategoria + "' selected >"+data[i].nombre+"</option>");
                    else
                        $('#subcategoria').append("<option value='" + data[i].idSubcategoria + "' >"+data[i].nombre+"</option>");
                }
            }, "json");
    });
});