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
    public $masspayArray = array();

    function __construct() {
        
    }

    function toString() {
        $res = "Mensaje recibido " + date("d/m/Y  H:i:s");
        $res.=" <br> txn_type => " . $this->txn_type;
        $res.=" <br> txn_id => " . $this->txn_id;
        $res.=" <br> receirver_email =>" . $this->receiver_email;
        $res.=" <br> item_name =>" . $this->item_name;
        $res.=" <br> item_number =>" . $this->item_number;
        $res.=" <br> payment_status =>" . $this->payment_status;
        $res.=" <br> parent_txt_id =>" . $this->parent_txt_id;
        $res.=" <br> mc_gross (importe bruto)=>" . $this->mc_gross;
        $res.=" <br> mc_fee (comision) =>" . $this->mc_fee;
        $res.=" <br> mc_currency =>" . $this->mc_currency;
        $res.=" <br> first_name =>" . $this->first_name;
        $res.=" <br> last_name =>" . $this->last_name;
        $res.=" <br> payer_email =>" . $this->payer_email;
        $res.=" <br> payment_date =>" . $this->payment_date;
        $res.=" <br> test_ipn =>" . $this->test_ipn;
        $res.=" <br> custom =>" . $this->custom;
        if (sizeof($this->masspayArray) > 0) {
            $res.="<br>";
            $res.="Mass payment data:<br>";
            $res.="" . sizeof($this->masspayArray) . " payments<br><br>";
            $n = 1;
            foreach ($this->masspayArray as $payment) {
                $res.="========== Payment " . $n . "============";
                $res.="<br>masspay_txn_id = " . $payment['masspay_txn_id'];
                $res.="<br>mc_currency = " . $payment['mc_currency'];
                $res.="<br>mc_fee = " . $payment['mc_fee'];
                $res.="<br>mc_gross = " . $payment['mc_gross'];
                $res.="<br>receiver_email = " . $payment['receiver_email'];
                $res.="<br>status = " . $payment['status'];
                $res.="<br>unique_id =" . $payment['unique_id'];
                $res.="<br>======== End Payment =========";
                $n++;
            }
        }

        $res.=" <br><br><br><br> Complete post<br><br><br> " . $this->complete_post;
        return $res;
    }

}

?>