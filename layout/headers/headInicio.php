<!DOCTYPE html>
<html lang="es" xml:lang="es">
    <head>
        <meta name="google" value="notranslate">
        <meta charset="utf-8" />
        <title>
            <?php
            if (isset($tituloPagina))
                echo $tituloPagina . " en Unova";
            else
                echo "Unova";
            ?>
        </title>
        <link REL="SHORTCUT ICON" HREF="/layout/faviconUnova.ico">
        <link rel="stylesheet" href="/layout/css/MainStyle.css" />
        <link rel="stylesheet" href="/layout/css/forms.css" />
        <link rel="stylesheet" href="/layout/css/redmond/jquery-ui-1.8.17.custom.css" />
        <script src="/js/jquery-1.7.1.min.js"></script>		
        <script src="/js/jquery-ui-1.8.17.custom.min.js"></script>
        <script src="/js/popcorn-complete.min.js"></script>
        <script src="/js/funciones.js"></script>	
        <script src="/js/DocumentReady.js"></script>
        
        <!--Google analytics Unova.co-->
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-31533649-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
