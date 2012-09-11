$(document).ready(function() {
    $("#tableOne").tablesorter({
        debug: false, 
        sortList: [[0, 0]], 
        widgets: ['zebra']
    })
    .tablesorterPager({
        container: $("#pagerOne"), 
        positionFixed: false,
        size: 20
    })
    .tablesorterFilter({
        filterContainer: $("#filterBoxOne"),
        filterClearContainer: $("#filterClearOne"),
        filterColumns: [0, 1],
        filterCaseSensitive: false
    });

    $("#tableOne .header").click(function() {
        $("#tableOne tfoot .first").click();
    });                
});   

function validarTotal(){
    var total = 0;
    $(".solicitud_checkbox:checked").each(function(){
        var $id = $(this).attr("id");
        var $aux = $("#cantidad_"+$id).text();
        $aux = $aux.replace("$","");
        total = total + parseFloat($aux);
    });
    
    if(total <= 0){
        alert("Selecciona alguna solicitud de pago");
        return false;
    }else{
        var $msg = "Vas a generar un archivo de pago, \ncon un total de $"+total+"\n¿Estas seguro?";
        return confirm($msg);
    }
}
