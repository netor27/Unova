<?php

function ordenar() {    
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (isset($_POST['clase']) && isset($_GET['idTema'])) {
            require_once 'modulos/cursos/modelos/ClaseModelo.php';
            $clases = $_POST['clase'];
            $idTema = $_GET['idTema'];
            $orden = 0;
            foreach ($clases as $key => $value) {
                echo "key = " . $key . " value = " . $value;
                if (actualizaOrdenClase($value, $idTema, $orden))
                    echo 'Se hizo el cambio';
                else
                    echo 'no se hizo el cambio';
                $orden++;
            }
        }
    }
}

?>