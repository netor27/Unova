$(function() {
    $( "#selectable" ).selectable({ 
        tolerance: 'fit',
        stop: function() {            
            $( ".ui-selected", this ).each(function() {
                var index = $( "#selectable li" ).index( this );
                $('#tipoClase').val(index);
            });
        }
    });
});