<html>
    <head>

        <script type="text/javascript" src="http://gridster.net/assets/js/libs/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="http://gridster.net/dist/jquery.gridster.min.js" charset="utf-8"></script>
        <link rel="stylesheet" href="http://gridster.net/dist/jquery.gridster.min.css"  />
        <link rel="stylesheet" href="http://gridster.net/assets/css/style.css" />
    </head>
    <body>
        <div role="main">


            <section class="demo">

                <div class="gridster" style="background: #004756">
                    <ul>
                        <li data-row="1" data-col="1" data-sizex="2" data-sizey="1" ></li>
                        <li data-row="2" data-col="1" data-sizex="1" data-sizey="1" ></li>

                        <li data-row="4" data-col="2" data-sizex="2" data-sizey="1" ></li>
                        <li data-row="2" data-col="3" data-sizex="2" data-sizey="2"  ></li>

                        <li data-row="2" data-col="2" data-sizex="1" data-sizey="1" ></li>
                        <li data-row="1" data-col="3" data-sizex="2" data-sizey="1" ></li>
                        <li data-row="4" data-col="4" data-sizex="1" data-sizey="1" ></li>

                        <li data-row="1" data-col="6" data-sizex="1" data-sizey="1" ></li>
                        <li data-row="2" data-col="5" data-sizex="1" data-sizey="1" ></li>

                        <li data-row="1" data-col="5" data-sizex="1" data-sizey="1" ></li>
                        <li data-row="2" data-col="6" data-sizex="1" data-sizey="2" ></li>
                    </ul>
                </div>

            </section>
        </div>
        <script type="text/javascript">
            var gridster;

            $(function(){

                gridster = $(".gridster ul").gridster({
                    widget_margins: [10, 10],
                    widget_base_dimensions: [140, 140],
                    min_cols: 6,
                    min_rows: 20
                }).data('gridster');

            });
        </script>
    </body>
</html>