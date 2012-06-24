$(document).ready(function(){
    //Agregar los eventos de click a los links del topnav
    $("#menuPerfilLink").click(function(e){       
        e.preventDefault();
        $("#perfil_menu").show();       
    });   
    $("#menuCursosLink").click(function(e){       
        e.preventDefault();
        $("#cursos_menu").show();       
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
        if($(e.target).parent("a.menuPerfilLink").length == 0){
            $("#perfil_menu").hide();
        }        
        if($(e.target).parent("a.menuCursosLink").length == 0){
            $("#cursos_menu").hide();
        }        
        
    });

});