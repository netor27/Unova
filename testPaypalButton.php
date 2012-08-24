<HTML>
    <?php
    require_once 'modulos/pagos/modelos/PayPalModelo.php';
    //Ejemplo para crear un boton de pago de paypal con la información encriptada
    //La funcion recibe 4 variables:
    //$nombreArticulo => Descripción de lo que el usuario va a comprar. Aparecerá en la página de paypal 
    //                  como descripción de máximo 127 caracteres. La longitud se valida dentro de la función,
    //                  si hace un substring.
    //$numeroArticulo => Variable que aparece como "numero de articulo", esta variable se muestra al usuario.
    //                  Máximo 127 caracteres, se valida dentro de la función
    //$precio         =>    Precio total
    //$variableId     => Variable que no se muestra al usuario, es para usarse dentro del sistema. Cuando paypal
    //                  avisa que se realizo el pago, envía esta variable para que el sistema pueda identificar
    //                  que pedido se pago. Lo mejor sería poner el idPedido o algo así en esta variable
    //                  Máximo 256 caracteres, se valida dentro de la función
    //
    $encrypted = encriptarInformacionBotonPago("Recarga de saldo de $300.00", "123456", "300", "123custom456");
    
    ?> 
    <HEAD>
        <TITLE>Boton encriptado de Paypal</TITLE>
    </HEAD>
    <BODY bgcolor=white>
        <TABLE border=0>
            <TR><TD align=center>
                    <h1>Pagar</h1>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="encrypted" value="
                               <?PHP echo $encrypted; ?>">
                        <input type="image" src="https://www.paypalobjects.com/es_XC/MX/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal, la forma más segura y rápida de pagar en línea.">
                        
                    </form>
                </TD></TR></TABLE>
    </BODY>

</HTML>