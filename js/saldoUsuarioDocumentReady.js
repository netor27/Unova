$(function() {
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
});

