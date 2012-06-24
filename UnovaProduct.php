<?php
require_once 'layout/headers/headInicio.php';
?>

<link rel="stylesheet" href="/layout/css/videos/videos.css" />
<script src="/js/video/funcionesProduct.js" type="text/javascript"></script>

<?php
require_once 'layout/headers/headCierreSinEsite.php';
?>

<div style="text-align: center;">
    <h1>Unova Product</h1>
</div>
<div style="width: 100%">
    <div id="main-container">
        <div id="video-container">
            <video id="video">
                <source src="http://c332434.r34.cf1.rackcdn.com/unova_product.mp4" type="video/mp4"></source>      
                <source src="http://c332434.r34.cf1.rackcdn.com/unova_product.ogv" type="video/ogg"></source>      
            </video>         
        </div>
        <div class="infodiv" id="infodiv"><div class="infobottom" id="infobottom"></div></div>
        <div class="top left"  id="topLeft"></div>
        <div class="top center"  id="topCenter"></div>
        <div class="top right"  id="topRight"></div>
        <div class="middle left"  id="middleLeft"></div>
        <div class="middle center"  id="middleCenter"></div>
        <div class="middle right"  id="middleRight"></div>
        <div class="bottom left"  id="bottomLeft"></div>
        <div class="bottom center"  id="bottomCenter"></div>
        <div class="bottom right"  id="bottomRight"></div>

    </div>
</div>

<?php
require_once 'layout/foot.php';
?>