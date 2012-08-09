#
#Se manda llamar cada minuto con el comando de cron:
#  * * * * *  /home/neto/public_html/unova/cronScripts/tranformarVideo.sh
#Se manda llamar cada 2 minutos con el comando de cron:
#  */2 * * * *  /home/neto/public_html/unova/cronScripts/tranformarVideo.sh
#
#Script que manda llamar 
#
#wget -O - -q http://unova.co/email.php?llaveSecreta=199201302
date=`date`
echo Transformacion de video $date >> /home/neto/logs/transformarVideo.log
exit 0