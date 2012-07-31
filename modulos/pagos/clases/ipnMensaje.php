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
        $res.=" /n txn_type => " . $txn_type;
        $res.=" /n txn_id => " . $txn_id;
        $res.=" /n receirver_email =>" . $receiver_email;
        $res.=" /n item_name =>" . $item_name;
        $res.=" /n item_number =>" . $item_number;
        $res.=" /n payment_status =>" . $payment_status;
        $res.=" /n parent_txt_id =>" . $parent_txt_id;
        $res.=" /n mc_gross (cantidad depositada)=>" . $mc_gross;
        $res.=" /n mc_fee (comision) =>" . $mc_fee;
        $res.=" /n mc_currency =>" . $mc_currency;
        $res.=" /n first_name =>" . $first_name;
        $res.=" /n last_name =>" . $last_name;
        $res.=" /n payer_email =>" . $payer_email;        
        $res.=" /n payment_date =>" . $payment_date;
        $res.=" /n test_ipn =>" . $test_ipn;
        $res.=" /n custom =>" . $custom;
        $res.=" /n/n/n/n Complete post/n/n/n " . $complete_post;
        return $res;
    }

}

?>
