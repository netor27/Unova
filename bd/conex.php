<?php
require_once('bd/bd.php');
try{	
	$BDhost = 'localhost';
	$BDbase = 'dbunova';
	//$BDusuario = 'root';
	//$BDpswd = 'root';
	
	$BDusuario = 'UnoVaUser';
	$BDpswd = 'dbUnovaPass2012';
        global $conex;
	$conex = new Configpdo('mysql',$BDhost,$BDbase,$BDusuario,$BDpswd);
}catch(PDOException $e){
    echo "ocurrió un error con la base de datos";
}

function beginTransaction(){
    global $conex;
    $conex->beginTransaction();
}

function commitTransaction(){
    global $conex;
    $conex->commit();
}

function rollBackTransaction(){
    global $conex;
    $conex->rollBack();
}
?>
