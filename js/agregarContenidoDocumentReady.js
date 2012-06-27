
$(document).ready(function() {
    
    //Inicializar los dialogs
    $( "#videoSubidoDialog" ).dialog({
        height: 160,
        modal: true,
        autoOpen: false
    });
    $( "#dialog" ).dialog({
        height: 160,
        modal: true,
        autoOpen: false
    });
    
    //Cambiamos la forma en la que el navegador ejecuta el drag y el drop
    $(document).bind('drop dragover', function (e) {
        e.preventDefault();
    });

    $('#fileupload').fileupload({            
        url: '/uploader.php',
        sequentialUploads: true,
        maxFileSize: 1500000000,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(pdf|doc|docx|ppt|pptx|mov|mp4|wmv|avi|3gp|avi|flv|mpg|mpeg|mpe)$/i        
    });
    
    $('#fileupload').bind('fileuploaddone', 
        function (e, data) {             
            var resultado = data.result[0].errorDetalle;
            if(resultado.length > 0){
                $("#dialog").html("<p class='error'>" + resultado + "</p>");
                $( "#dialog" ).dialog('open');
            }                        
            $.each(data.files, function (index, file) {
                if(file.type.indexOf("video") != -1){
                    $( "#videoSubidoDialog" ).dialog('open');
                }
            });
        }
        ); 
            
//    $('#fileupload').bind('fileuploadadd', 
//        function (e, data) {
//            $("#dialog").html("<h3>Carga iniciada</h3><p>Recuerda que si cambias o cierras esta página, tu descarga se cancelará</p>");
//            $( "#dialog" ).dialog('open');
//        }
//        );  
            
    // Upload server status check for browsers with CORS support:
    if ($.support.cors) {
        $.ajax({
            url: '/uploader.php',
            type: 'HEAD'
        }).fail(function () {
            $('<span class="alert alert-error"/>')
            .text('Upload server currently unavailable - ' +
                new Date())
            .appendTo('#fileupload');
        });
    } 
});