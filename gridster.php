<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headGridster.php');
require_once('layout/headers/headCierre.php');
?>
<div class="contenido">
    <section class="demo">

        <div class="gridster ready">
            <ul style="height: 480px; position: relative; ">
                <li data-row="1" data-col="1" data-sizex="2" data-sizey="1" class="gs_w"></li>
                <li data-row="3" data-col="1" data-sizex="1" data-sizey="1" class="gs_w"></li>

                <li data-row="3" data-col="2" data-sizex="2" data-sizey="1" class="gs_w"></li>
                <li data-row="1" data-col="3" data-sizex="2" data-sizey="2" class="gs_w"></li>

                <li class="try gs_w" data-row="1" data-col="5" data-sizex="1" data-sizey="1"></li>
                <li data-row="2" data-col="1" data-sizex="2" data-sizey="1" class="gs_w"></li>
                <li data-row="3" data-col="4" data-sizex="1" data-sizey="1" class="gs_w"></li>

                <li data-row="1" data-col="6" data-sizex="1" data-sizey="1" class="gs_w"></li>
                <li data-row="3" data-col="5" data-sizex="1" data-sizey="1" class="gs_w"></li>

                <li data-row="2" data-col="5" data-sizex="1" data-sizey="1" class="gs_w"></li>
                <li data-row="2" data-col="6" data-sizex="1" data-sizey="2" class="gs_w"></li>
            </ul>
        </div>

    </section>

    <script src="/lib/js/jqueryGridster/jquery.gridster.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        var gridster;

        $(function(){

            gridster = $(".gridster ul").gridster({
                widget_margins: [5, 5],
                widget_base_dimensions: [140, 140],
                min_cols: 6,
                min_rows: 20
            }).data('gridster');

        });
    </script>
</div>
<?php
require_once('layout/foot.php');
?>