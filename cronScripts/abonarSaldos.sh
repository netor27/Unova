#
# Cron, agregar crontab -e, borrar crontab -r, listar crontab -l
#
#Se manda llamar diario con este cron:
#   0 5 * * 0 /home/neto/public_html/unova/cronScripts/abonarSaldos.sh
#
#Script que manda llamar http://unova.co/usuarios.php?c=saldo&a=abonarSaldos&llaveSecreta=87293821
#
wget -O - -q http://unova.co/usuarios.php?c=saldo&a=abonarSaldos&llaveSecreta=87293821
date=`date`
echo Se ejecuto script abonar saldo diario $date >> /home/neto/logs/saldoDiario.log
exit 0