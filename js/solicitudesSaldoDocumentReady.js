$(function() {    
    $("#toggle_checkbox").click(function(){
        if($(this).hasClass("selected")){
            //seleccionar todos
            $(".solicitud_checkbox").attr('checked', true);
            $(this).removeClass("selected");
            $(this).text("Quitar selección de todos");
        }else{
            //deseleccionar todos
            $(".solicitud_checkbox").attr('checked', false);
            $(this).text("Seleccionar todos");
            $(this).addClass("selected");
        }
    });
});