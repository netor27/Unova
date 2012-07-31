<?php

# private key file to use
$MY_KEY_FILE = "/home/neto/paypal/my-prvkey.pem";

# public certificate file to use
$MY_CERT_FILE = "/home/neto/paypal/my-pubcert.pem";

# Paypal's public certificate
$PAYPAL_CERT_FILE = "/home/neto/paypal/paypal_cert.pem";

# path to the openssl binary
$OPENSSL = "/usr/bin/openssl";

function paypal_encrypt($hash) {
    global $MY_KEY_FILE;
    global $MY_CERT_FILE;
    global $PAYPAL_CERT_FILE;
    global $OPENSSL;


    if (!file_exists($MY_KEY_FILE)) {
        echo "ERROR: MY_KEY_FILE $MY_KEY_FILE not found\n";
    }
    if (!file_exists($MY_CERT_FILE)) {
        echo "ERROR: MY_CERT_FILE $MY_CERT_FILE not found\n";
    }
    if (!file_exists($PAYPAL_CERT_FILE)) {
        echo "ERROR: PAYPAL_CERT_FILE $PAYPAL_CERT_FILE not found\n";
    }

    //Assign Build Notation for PayPal Support
    $hash['bn'] = 'UNOVA DEVELOPMENT';

    $data = "";
    foreach ($hash as $key => $value) {
        if ($value != "") {
            //echo "Adding to blob: $key=$value\n";
            $data .= "$key=$value\n";
        }
    }

    $openssl_cmd = "($OPENSSL smime -sign -signer $MY_CERT_FILE -inkey $MY_KEY_FILE " .
            "-outform der -nodetach -binary <<_EOF_\n$data\n_EOF_\n) | " .
            "$OPENSSL smime -encrypt -des3 -binary -outform pem $PAYPAL_CERT_FILE";

    exec($openssl_cmd, $output, $error);

    if (!$error) {
        return implode("\n", $output);
    } else {
        return "ERROR: encryption failed";
    }
}

function encriptarInformacionBotonPago($nombreArticulo, $numeroArticulo, $precio, $variableId){
    //validar la longitud máxima de las variables
    if(strlen($nombreArticulo) > 127)
        $nombreArticulo = substr($nombreArticulo, 0, 127);
    if(strlen($numeroArticulo) > 127)
        $numeroArticulo = substr($numeroArticulo, 0, 127);
    if(strlen($variableId) > 256)
        $variableId = substr($variableId, 0, 256);
    
    $form = array(
        'cmd' => '_xclick',
        'business' => 'neto.r27@gmail.com',
        'cert_id' => '6Z8ETPUX39V7N',
        'lc' => 'ES_MX',
        'invoice' => '',
        'currency_code' => 'MXN',
        'no_shipping' => '1',
        'quantity' => '1',
        'item_name' => $nombreArticulo,
        'item_number' => $numeroArticulo,
        'amount' => $precio,
        'custom' => $variableId
    );
    $encrypted = paypal_encrypt($form);
    return $encrypted;
}

?>