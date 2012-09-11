$(function() {    
    
    $("#mostrarMasOperaciones").click(function () {
        var url = '/usuarios.php?c=saldo&a=getOperacionesAnteriores&offset=' + $offset;
        $.ajax({
            type: 'get',
            url: url, 
            success: function(data) {
                var str = data.toString();
                $("#tableBodyOperaciones").append(data);
                if(str.indexOf("notice") != -1){
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
        if(!isNaN(cantidad) && cantidad >= 50){
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
            $( "#modalDialog" ).attr("title", "Recargar saldo");
            $("#modalDialog").html("<div class='center' style='text-align:center;'><h3 class='error'>No es una cantidad válida</h3><h4>La cantidad mínima para recargar es de $50.00</h4></div>");
            $("#modalDialog").dialog({
                height: 450,
                width: 800,
                modal: true
            });
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
        value: 50,
        min: 50,
        max: $maxSaldo,
        slide: function( event, ui ) {
            $( "#cantidad" ).val( "$" + ui.value );
        }
    });
    $( "#cantidad" ).val( "$" + $( "#slider-range-min" ).slider( "value" ) );
});

