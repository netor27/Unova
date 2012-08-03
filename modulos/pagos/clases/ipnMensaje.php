<?php

class IpnMensaje {

    public $txn_type = null;
    public $txn_id = null;
    public $receiver_email = null;
    public $item_name = null;
    public $item_number = null;
    public $payment_status = null;
    public $parent_txt_id = null;
    public $mc_gross = null;
    public $mc_fee = null;
    public $mc_currency = null;
    public $first_name = null;
    public $last_name = null;
    public $payer_email = null;
    public $payment_date = null;
    public $test_ipn = 0;
    public $custom = null;
    public $complete_post = null;

    function __construct() {
        
    }

    function toString() {
        $res = "Mensaje recibido " + date("d/m/Y  H:i:s");
        $res.=" <br> txn_type => " . $txn_type;
        $res.=" <br> txn_id => " . $txn_id;
        $res.=" <br> receirver_email =>" . $receiver_email;
        $res.=" <br> item_name =>" . $item_name;
        $res.=" <br> item_number =>" . $item_number;
        $res.=" <br> payment_status =>" . $payment_status;
        $res.=" <br> parent_txt_id =>" . $parent_txt_id;
        $res.=" <br> mc_gross (cantidad depositada)=>" . $mc_gross;
        $res.=" <br> mc_fee (comision) =>" . $mc_fee;
        $res.=" <br> mc_currency =>" . $mc_currency;
        $res.=" <br> first_name =>" . $first_name;
        $res.=" <br> last_name =>" . $last_name;
        $res.=" <br> payer_email =>" . $payer_email;        
        $res.=" <br> payment_date =>" . $payment_date;
        $res.=" <br> test_ipn =>" . $test_ipn;
        $res.=" <br> custom =>" . $custom;
        $res.=" <br><br><br><br> Complete post<br><br><br> " . $complete_post;
        return $res;
    }

}

?>
