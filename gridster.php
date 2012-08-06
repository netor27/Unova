<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headGridster.php');
require_once('layout/headers/headCierre.php');
?>
<div class="contenido">
    <section class="demo">

        <div class="gridster ready">
            <ul style="height: 480px; position: relative; ">
                <li id="1" class="cuadro" data-row="1" data-col="1" data-sizex="2" data-sizey="1" class="gs_w">
                    A <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>               
                <li id="2"  class="cuadro" data-row="3" data-col="1" data-sizex="1" data-sizey="1" class="gs_w">
                    B <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>

                <li id="3"  class="cuadro" data-row="3" data-col="2" data-sizex="2" data-sizey="1" class="gs_w">
                    C <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
                <li id="4"  class="cuadro" data-row="1" data-col="3" data-sizex="2" data-sizey="2" class="gs_w">
                    D <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>

                <li id="5"  class="cuadro try gs_w" data-row="1" data-col="5" data-sizex="1" data-sizey="1">
                    E <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
                <li id="6"  class="cuadro" data-row="2" data-col="1" data-sizex="2" data-sizey="1" class="gs_w">
                    F <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
                <li id="7"  class="cuadro" data-row="3" data-col="4" data-sizex="1" data-sizey="1" class="gs_w">
                    G <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>

                <li id="8"  class="cuadro" data-row="1" data-col="6" data-sizex="1" data-sizey="1" class="gs_w">
                    H <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
                <li id="9"  class="cuadro" data-row="3" data-col="5" data-sizex="1" data-sizey="1" class="gs_w">
                    I <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>

                <li id="10"  class="cuadro" data-row="2" data-col="5" data-sizex="1" data-sizey="1" class="gs_w">
                    J <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
                <li  id="11" class="cuadro" data-row="2" data-col="6" data-sizex="1" data-sizey="2" class="gs_w">
                    K <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
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
                min_rows: 20,
                serialize_params: function($w, wgd) { 
                    return { 
                        col: wgd.col, 
                        row: wgd.row,
                        size_x: wgd.size_x,
                        size_y: wgd.size_y,
                        id: $w.attr("id")
                    } 
                }
            }).data('gridster');
            
            $(".cuadro").hover(
            function () {
                $(this).append($("<span> ***</span>"));
            }, 
            function () {
                $(this).find("span:last").remove();
                
            });
            
            $(".cuadroLink").click(function(){
                var x = $(this).parent().attr("data-sizex");
                var y = $(this).parent().attr("data-sizey");
                if(x == 1){
                    $(this).parent().attr("data-sizex",2);
                }else{
                    if(y == 1){
                        $(this).parent().attr("data-sizex",1);
                        $(this).parent().attr("data-sizey",2);
                    }else{
                        $(this).parent().attr("data-sizex",1);
                        $(this).parent().attr("data-sizey",1);
                    }
                }
                var array = gridster.serialize();
                var gridsterArray = new Array();
                var i=0;
                var aux;
                for(i=0; i< array.length; i++){                    
                    aux = { 
                        col: array[i].col, 
                        row: array[i].row,
                        size_x: array[i].size_x,
                        size_y: array[i].size_y,
                        id: array[i].id
                    };
                    console.log(aux);
                    gridsterArray.push(aux);
                }
                gridster.destory();
                gridster = null;
                $(".gridster ul").gridster({
                    widget_margins: [5, 5],
                    widget_base_dimensions: [140, 140],
                    min_cols: 6,
                    min_rows: 20,
                    serialize_params: function($w, wgd) { 
                        return { 
                            col: wgd.col, 
                            row: wgd.row,
                            size_x: wgd.size_x,
                            size_y: wgd.size_y,
                            id: $w.attr("id")
                        } 
                    }
                }).data('gridster');
            });
                
            function generarGridster(arreglo){
                
            }
        });
    </script>
</div>
<?php
require_once('layout/foot.php');
?>