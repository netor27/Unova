#
# Cron, agregar crontab -e, borrar crontab -r, listar crontab -l
#
#Se manda llamar cada domingo a las 5 am con este cron:
#   0 0 5 * * 0 /home/neto/public_html/unova/cronScripts/enviarMailSemanal.sh
#
#Script que manda llamar http://unova.co/email.php?llaveSecreta=199201302
#
wget -O - http://unova.co/email.php?llaveSecreta=199201302 >> /home/neto/logs/mailSemanal.log
date=`date`
echo Se ejecuto script mail semanal $date >> /home/neto/logs/mailSemanal.log
exit 0