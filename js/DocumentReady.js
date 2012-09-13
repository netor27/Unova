$(document).ready(function(){
    
    if(layout == "desktop"){
        //Agregar los eventos de click a los links del topnav
        $("#menuPerfilLink").click(function(e){       
            $("#perfil_menu").toggle("swing");       
        });   
        $("#menuCursosLink").click(function(e){       
            $("#cursos_menu").toggle("swing");       
        });
   
        //Evento para evitar que se cierre al dar click dentro del menu
        $("#perfil_menu").mouseup(function(){
            return false;
        });
        $("#cursos_menu").mouseup(function(){
            return false;
        });   
        //Evento en todo el body que cierra el menu si no 
        $(document).mouseup(function(e){       
            if($(e.target).attr("id") != "menuPerfilLink"){
                $("#perfil_menu").hide("swing");
            }        
            if($(e.target).attr("id") != "menuCursosLink"){
                $("#cursos_menu").hide("swing");
            }        
        
        });
    }else{
        //Agregar los eventos de click a los links del topnav
        $("#menuPerfilLink").bind("touchstart",function(e){       
            $("#perfil_menu").toggle("swing");       
        });   
        $("#menuCursosLink").bind("touchstart",function(e){       
            $("#cursos_menu").toggle("swing");       
        });
   
        //Evento para evitar que se cierre al dar click dentro del menu
        $("#perfil_menu").bind("touchend",function(){
            return false;
        });
        $("#cursos_menu").bind("touchend",function(){
            return false;
        });   
        //Evento en todo el body que cierra el menu si no 
        $(document).bind("touchend",function(e){       
            if($(e.target).attr("id") != "menuPerfilLink"){
                $("#perfil_menu").hide("swing");
            }        
            if($(e.target).attr("id") != "menuCursosLink"){
                $("#cursos_menu").hide("swing");
            }      
        });
    }
});