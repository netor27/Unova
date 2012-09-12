<div id="dialog-form-imagen" title="Agregar una imagen">
    <div id="imagenAccordion">
        <h3><a >Inserta la URL de la imagen</a></h3>
        <div>
            <label>Link:</label>
            <input type="text" name="url" id="urlImagen" class="text ui-widget-content ui-corner-all" style="width:92%;"/>

        </div>

        <h3><a >Tiempo</a></h3>
        <div>
            <table>
                <tr>
                    <td><label for="Tiempo Inicial">Tiempo inicial</label></td>
                    <td><input type="text" name="tiempoInicio" id="tiempoInicioImagen" class="text ui-widget-content ui-corner-all" style="width:40px;"/><br></td>
                </tr>
                <tr>
                    <td><label for="Tiempo Final">Tiempo final</label></td>
                    <td><input type="text" name="tiempoFin" id="tiempoFinImagen" class="text ui-widget-content ui-corner-all"style="width:40px;"/></td>
                </tr> 
            </table>
            <div id="tiempoRangeSliderImagen"></div>
        </div>
        <h3><a >Color de fondo</a></h3>
        <div>
            <div id="colorSelectorImagen" ></div>
            <input type="hidden" name="colorHidden" id="colorHiddenImagen"/>
            <br><br>
            <label>Color seleccionado:</label>
            <div id="colorSeleccionadoImagen" class="colorButton"></div>
        </div>
        
    </div>
</div>	