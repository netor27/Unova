<?php
require_once 'modulos/usuarios/modelos/usuarioModelo.php';
//Depositamos 100.50
actualizaSaldoUsuario(3, 100.50);
//Depositamos 50
actualizaSaldoUsuario(3, 50);
//Sacamos 80
actualizaSaldoUsuario(3,-80);
//sacamos 3
actualizaSaldoUsuario(3, -3);
?>
