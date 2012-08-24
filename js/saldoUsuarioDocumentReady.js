$(function() {    
    
    $("#mostrarMasOperaciones").click(function () {
        var url = '/usuarios.php?c=saldo&a=getOperacionesAnteriores&offset=' + $offset;
        $.ajax({
            type: 'get',
            url: url, 
            success: function(data) {
                var str = data.toString();
                $("#tableBodyOperaciones").append(data);
                if(str.indexOf("notification") != -1){
                    $("#mostrarMasOperaciones").remove();
                }else{                    
                    $offset += 6;
                }
            }
        });
        
    });
    
    $("#botonRecargar").click(function () {
        var cantidad = $("#cantidadRecargar").val();
        cantidad = parseFloat(cantidad);
        if(!isNaN(cantidad)){
            var url = '/pagos.php?a=getFormaRecargarSaldo&cnt=' + cantidad + '&des=Recarga+de+saldo';
            $.ajax({
                type: 'get',
                url: url, 
                success: function(data) {
                    $( "#modalDialog" ).attr("title", "Recargar saldo");
                    $("#modalDialog").html(data);
                    $("#modalDialog").dialog({
                        height: 450,
                        width: 800,
                        modal: true
                    });
                }
            }); 
        }else{
            //valor de cantidad no númerico
            alert("el valor a recargar no es un numero");
        }
    });  
    
    $( "#modalDialogRetirarSaldo" ).dialog({
        height: 450,
        width: 500,
        modal: true,
        autoOpen: false
    });
        
    $("#btnRetirarSaldo").click(function (){
        $( "#modalDialogRetirarSaldo" ).dialog("open");
    });
    
    $( "#slider-range-min" ).slider({
        range: "min",
        value: 10,
        min: 10,
        max: $maxSaldo,
        slide: function( event, ui ) {
            $( "#cantidad" ).val( "$" + ui.value );
        }
    });
    $( "#cantidad" ).val( "$" + $( "#slider-range-min" ).slider( "value" ) );
});

