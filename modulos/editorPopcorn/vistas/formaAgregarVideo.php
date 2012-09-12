<div id="dialog-form-video" title="Agregar un video">
    <div id="videoAccordion">
        <h3><a >Inserta la URL del videon</a></h3>
        <div>
            <label>Link:</label>
            <input type="text" name="url" id="urlVideo" class="text ui-widget-content ui-corner-all"  style="width:92%;"/>

        </div>

        <h3><a >Tiempo</a></h3>
        <div>
            <table>
                <tr>
                    <td><label for="Tiempo Inicial">Tiempo inicial</label></td>
                    <td><input type="text" name="tiempoInicio" id="tiempoInicioVideo" class="text ui-widget-content ui-corner-all" style="width:40px;"/><br></td>
                </tr>
                <tr>
                    <td><label for="Tiempo Final">Tiempo final</label></td>
                    <td><input type="text" name="tiempoFin" id="tiempoFinVideo" class="text ui-widget-content ui-corner-all" style="width:40px;"/></td>
                </tr> 
            </table>
            <div id="tiempoRangeSliderVideo"></div>
        </div>
        <h3><a >Color de fondo</a></h3>
        <div>
            <div id="colorSelectorVideo" ></div>
            <input type="hidden" name="colorHidden" id="colorHiddenVideo"/>
            <br><br>
            <label>Color seleccionado:</label>
            <div id="colorSeleccionadoVideo" class="colorButton"></div>
        </div>

    </div>
</div>	