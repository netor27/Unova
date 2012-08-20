#
# Cron, agregar crontab -e, borrar crontab -r, listar crontab -l
#
#Se manda llamar cada domingo a las 5 am con este cron:
#   00 5 * * 0 /home/neto/public_html/unova/cronScripts/enviarMailSemanal.sh
#
#Script que manda llamar http://unova.co/email.php?llaveSecreta=199201302
#
wget -O - -q http://unova.co/email.php?llaveSecreta=199201302
date=`date`
echo Se ejecuto script mail semanal $date >> /home/neto/logs/mailSemanal.log
exit 0