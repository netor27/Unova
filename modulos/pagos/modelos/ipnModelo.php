<?php

require_once 'modulos/pagos/clases/ipnMensaje.php';
require_once 'bd/conx.php';

function agregarIpnMensaje($ipnMensaje) {
    global $conex;
    $stmt = $conex->prepare("INSERT INTO ipnmensajepaypal (txn_type, txn_id, receiver_email, item_name,
                                item_number, payment_status, parent_txn_id, mc_gross, mc_fee,
                                mc_currency, first_name, last_name, payer_email, complete_post,
                                payment_date, test_ipn, custom)
                             VALUES(:txn_type, :txn_id, :receiver_email, :item_name,
                              :item_number, :payment_status, :parent_txn_id, :mc_gross, :mc_fee,
                             :mc_currency, :first_name, :last_name, :payer_email, :complete_post,
                             :payment_date, :test_ipn, :custom)");
    $stmt->bindParam(':txn_type', $ipnMensaje->txn_type);
    $stmt->bindParam(':txn_id', $ipnMensaje->txn_id);
    $stmt->bindParam(':receiver_email', $ipnMensaje->receiver_email);
    $stmt->bindParam(':item_name', $ipnMensaje->item_name);
    $stmt->bindParam(':item_number', $ipnMensaje->item_number);
    $stmt->bindParam(':payment_status', $ipnMensaje->payment_status);
    $stmt->bindParam(':parent_txn_id', $ipnMensaje->parent_txn_id);
    $stmt->bindParam(':mc_gross', $ipnMensaje->mc_gross);
    $stmt->bindParam(':mc_fee', $ipnMensaje->mc_fee);
    $stmt->bindParam(':mc_currency', $ipnMensaje->mc_currency);
    $stmt->bindParam(':first_name', $ipnMensaje->first_name);
    $stmt->bindParam(':last_name', $ipnMensaje->last_name);
    $stmt->bindParam(':payer_email', $ipnMensaje->payer_email);
    $stmt->bindParam(':complete_post', $ipnMensaje->complete_post);
    $stmt->bindParam(':payment_date', $ipnMensaje->payment_date);
    $stmt->bindParam(':test_ipn', $ipnMensaje->test_ipn);
    $stmt->bindParam(':custom', $ipnMensaje->custom);
    $idRes = -1;
    if($stmt->execute()){        
        $idRes = $conex->lastInsertId();
    }else{
        print_r($stmt->errorInfo());
    }    
    return $idRes;
}

function txnRecibido($txn_id) {
    global $conex;
    $stmt = $conex->prepare("SELECT idIpnMensajePaypal
                             FROM ipnmensajepaypal
                             WHERE txn_id = :id");
    $stmt->bindParam(':id', $txn_id);
    $stmt->execute();
    if ($stmt->rowCount() > 0)
        return true;
    else
        return false;
}

function obtenerIpnMensajes() {
    global $conex;
    $stmt = $conex->query("SELECT * From ipnmensajepaypal");
    $arreglo = $stmt->fetchAll();
    return $arreglo;
}

?>