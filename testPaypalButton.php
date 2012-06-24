<HTML>
    <?php
    $form = array('cmd' => '_xclick',
        'business' => 'neto.r27@gmail.com',
        'cert_id' => 'ELXHA9WDH3E28',
        'lc' => 'MX',
        'custom' => 'test',
        'invoice' => '',
        'currency_code' => 'MXN',
        'no_shipping' => '1',
        'item_name' => 'Curso ',
        'item_number' => '1',
        'amount' => '100'
    );

    require_once 'modulos/pagos/modelos/PayPalModelo.php';
    $encrypted = paypal_encrypt($form);
    ?> 
    <HEAD>
        <TITLE>Boton encriptado de Paypal</TITLE>
    </HEAD>
    <BODY bgcolor=white>
        <TABLE border=0>
            <TR><TD align=center>
                    <h1>Suscribirse a un curso</h1>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target=_blank>
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="encrypted" value="
<?PHP echo $encrypted; ?>">
                        <input type="image" src="https://www.paypalobjects.com/es_XC/MX/i/btn/btn_buynowCC_LG.gif" border="0" alt="PayPal, la forma más segura y rápida de pagar en línea.">
                    </form>
                </TD></TR></TABLE>
    </BODY>

</HTML>