<div style="text-align:center;">
    <h2 >Pagar con tarjeta de crédito o débito  </h2>
    <img style="float:left;" src="/layout/imagenes/tipoPagos/pagosPorPaypal.gif" style="padding-right:20px;">
    <h3>Serás redirigido al sitio de Paypal donde realizaras el pago de una manera segura</h3>
    <br><br>
    <h3><strong>No es necesario tener una cuenta de paypal</strong></h3>
    <br><br>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="encrypted" value="<?php echo $encrypted; ?>">
        <input type="submit" name="submit" value=" Realizar pago ">
    </form>
</div>