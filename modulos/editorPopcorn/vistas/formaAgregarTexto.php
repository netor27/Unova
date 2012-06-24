<div id="dialog-form-texto" title="Cuadro de Texto">
    <div id="textAccordion">
        <h3><a href="#">Texto</a></h3>
        <div>
            <div style="height: 320px;">
                <textarea id="textoTinyMce"></textarea>
            </div>
        </div>
        
        <h3><a href="#">Tiempo</a></h3>
        <div>
            <table>
                <tr>
                    <td><label for="Tiempo Inicial">Tiempo inicial</label></td>
                    <td><input type="text" name="tiempoInicio" id="tiempoInicioTexto" class="text ui-widget-content ui-corner-all" style="width:40px;"/><br></td>
                </tr>
                <tr>
                    <td><label for="Tiempo Final">Tiempo final</label></td>
                    <td><input type="text" name="tiempoFin" id="tiempoFinTexto" class="text ui-widget-content ui-corner-all" style="width:40px;"/></td>
                </tr> 
            </table>
            <div id="tiempoRangeSliderTexto"></div>
        </div>
        <h3><a href="#">Color de fondo</a></h3>
        <div>
            <div id="colorSelectorTexto" ></div>
            <input type="hidden" name="colorHidden" id="colorHiddenTexto"/>
            <br><br>
            <label>Color seleccionado:</label>
            <div id="colorSeleccionadoTexto" class="colorButton"></div>
        </div>
        
    </div>
</div>	