$(function(){
    $('.wow').rating();
    $('#cursoTabs').tabs();
    $('#pageMe').quickPager({
        pageSize: 6
    });
    
});

function validarInscripcionCurso(){
    return confirm("¿Deseas inscribirte a este curso?");
}
