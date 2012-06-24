<div id="dialog-form-link" title="Agregar un link">
    <div id="linkAccordion">
        <h3><a href="#">Link</a></h3>
        <div>
            <label>Texto: </label><br>
            <input type="text" name="url" id="textoLink" class="text ui-widget-content ui-corner-all"  style="width:97%;"/>
            <br><br>
            <label>Link:</label><br>
            <input type="text" name="url" id="urlLink" class="text ui-widget-content ui-corner-all"  style="width:97%;"/>
        </div>

        <h3><a href="#">Tiempo</a></h3>
        <div>
            <table>
                <tr>
                    <td><label for="Tiempo Inicial">Tiempo inicial</label></td>
                    <td><input type="text" name="tiempoInicio" id="tiempoInicioLink" class="text ui-widget-content ui-corner-all" style="width:40px;"/><br></td>
                </tr>
                <tr>
                    <td><label for="Tiempo Final">Tiempo final</label></td>
                    <td><input type="text" name="tiempoFin" id="tiempoFinLink" class="text ui-widget-content ui-corner-all" style="width:40px;"/></td>
                </tr> 
            </table>
            <div id="tiempoRangeSliderLink"></div>
        </div>
        <h3><a href="#">Color de fondo</a></h3>
        <div>
            <div id="colorSelectorLink" ></div>
            <input type="hidden" name="colorHidden" id="colorHiddenLink"/>
            <br><br>
            <label>Color seleccionado:</label>
            <div id="colorSeleccionadoLink" class="colorButton"></div>
        </div>

    </div>
</div>	