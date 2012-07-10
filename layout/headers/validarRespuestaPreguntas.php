<?php

if ($numPreguntas > 0) {
    ?>
    <script>
        $(document).ready(function(){
            $("#modalDialog").html("<h3>Tienes <?php echo $numPreguntas; ?> preguntas sin responder, <a href='/usuarios/cursos/responderPreguntas'>Respóndelas aquí</a> </h3>");
            $("#modalDialog").dialog({
                autoOpen: true,
                height:150,
                width: 550,
                modal: true,
                buttons:{
                    "Aceptar": function(){
                        $(this).dialog("close");
                    }
                }
            });	
        });
    </script>

    <?php

}
?>
