$(document).ready(function(){
    
    if(layout == "desktop"){
        //Agregar los eventos de click a los links del topnav
        $("#menuPerfilLink").click(function(e){                 
            //cambiamos la flecha
            if($("#flechaPerfil").hasClass('flechaAbajo')){
                $("#flechaPerfil").removeClass('flechaAbajo');
                $("#flechaPerfil").addClass('flechaArriba');  
            }else{
                $("#flechaPerfil").removeClass('flechaArriba');
                $("#flechaPerfil").addClass('flechaAbajo');
            }
            $("#perfil_menu").toggle("swing"); 
        });   
        
        $("#menuCursosLink").click(function(e){      
            $("#cursos_menu").toggle("swing");    
            //cambiamos la flecha
            if($("#flechaCursos").hasClass('flechaAbajo')){
                $("#flechaCursos").addClass("flechaArriba");
                $("#flechaCursos").removeClass("flechaAbajo");
            }else{
                $("#flechaCursos").removeClass("flechaArriba");
                $("#flechaCursos").addClass("flechaAbajo");
            }
        });
   
        //Evento para evitar que se cierre al dar click dentro del menu
        $("#perfil_menu").mouseup(function(){            
            return false;
        });
        $("#cursos_menu").mouseup(function(){
            return false;
        });   
        //Evento en todo el body que cierra el menu 
        $(document).mouseup(function(e){       
            var id = $(e.target).parents("div").attr("id");
            if(id != "menuPerfilLink"){
                cerrarPerfilMenu();
            }        
            if(id != "menuCursosLink"){
                cerrarCursosMenu();
            }    
        });
    }else{
        //Agregar los eventos de touch a los links del topnav
        $("#menuPerfilLink").bind("touchstart",function(e){       
            $("#perfil_menu").toggle("swing");  
            //cerramos el otro menu
            cerrarCursosMenu();
            //cambiamos la flecha
            if($("#flechaPerfil").hasClass("flechaArriba")){
                $("#flechaPerfil").removeClass("flechaArriba");
                $("#flechaPerfil").addClass("flechaAbajo");
            }else{
                $("#flechaPerfil").addClass("flechaArriba");
                $("#flechaPerfil").removeClass("flechaAbajo");
            }
        });   
        $("#menuCursosLink").bind("touchstart",function(e){       
            $("#cursos_menu").toggle("swing");  
            //cerramos el otro menu
            cerrarPerfilMenu();
            //cambiamos la flecha
            if($("#flechaCursos").hasClass("flechaArriba")){
                $("#flechaCursos").removeClass("flechaArriba");
                $("#flechaCursos").addClass("flechaAbajo");
            }else{
                $("#flechaCursos").addClass("flechaArriba");
                $("#flechaCursos").removeClass("flechaAbajo");
            }
        });
    }
});

function cerrarPerfilMenu(){
    $("#perfil_menu").hide("swing");
    $("#flechaPerfil").removeClass("flechaArriba");
    $("#flechaPerfil").addClass("flechaAbajo");
}
function cerrarCursosMenu(){
    $("#cursos_menu").hide("swing");
    $("#flechaCursos").removeClass("flechaArriba");
    $("#flechaCursos").addClass("flechaAbajo");
}
