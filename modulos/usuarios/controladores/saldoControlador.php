<?php

function principal() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/pagos/modelos/operacionModelo.php';
        $numOperaciones = 6;
        $usuario = getUsuarioActual();
        $operaciones = getUltimasOperacionesPorUsuario(0, $numOperaciones, $usuario->idUsuario);
        if (isset($operaciones)) {
            $operaciones = array_reverse($operaciones);
        }

        require_once 'modulos/usuarios/vistas/saldoUsuario.php';
    }
}

function getOperacionesAnteriores() {
    if (validarUsuarioLoggeadoParaSubmits()) {
        if (!empty($_GET['offset'])) {
            $offset = intval($_GET['offset']);
            $numOperaciones = 6;
            $usuario = getUsuarioActual();
            require_once 'modulos/pagos/modelos/operacionModelo.php';
            $operaciones = getUltimasOperacionesPorUsuario($offset, $numOperaciones, $usuario->idUsuario);
            if (isset($operaciones)) {
                $i = 0;
                foreach ($operaciones as $operacion) {
                    if ($i % 2 == 0)
                        echo '<tr class="par">';
                    else
                        echo '<tr class="non">';
                    if (operacionEsPositiva($operacion->idTipoOperacion)) {

                        echo '<td class="operacionFecha">' . transformaMysqlDateDDMMAAAAConHora($operacion->fecha) . '</td>';
                        echo '<td class="operacionTipo cantidadPositiva">' . getTipoOperacion($operacion->idTipoOperacion) . '</td>';
                        echo '<td class="operacionDetalle">' . $operacion->detalle . '</td>';
                        echo '<td class="cantidadPositiva">$' . $operacion->cantidad . '</td>';
                        echo '<td ></td>';
                    } else {
                        echo '<td class="operacionFecha">' . transformaMysqlDateDDMMAAAAConHora($operacion->fecha) . '</td>';
                        echo '<td class="operacionTipo cantidadNegativa">' . getTipoOperacion($operacion->idTipoOperacion) . '</td>';
                        echo '<td class="operacionDetalle">' . $operacion->detalle . '</td>';
                        echo '<td></td>';
                        echo '<td class="cantidadNegativa" >- $' . $operacion->cantidad . '</td>';
                    }
                    echo '</tr>';
                    $i++;
                }
            }else{
                echo "<h4 class='notification'>Ya no hay operaciones</h4>";
            }
        }
    }
}

function recargar() {
    if (validarUsuarioLoggeado()) {
        require_once 'modulos/pagos/vistas/recargarSaldo.php';
    }
}

function abonarSaldos() {

    $numUsuariosAbonados = 0;
    $cantidadAbonada = 0;

    //El profesor gana un 70% de la venta
    $porcentajeDeGananciaParaProfesores = 0.70;

    $secret = -1;
    if (isset($_GET['llaveSecreta'])) {
        $secret = $_GET['llaveSecreta'];
    }
    //Si esta llave no es igual, no hacer nada
    if ($secret == "87293821") {
        require_once 'modulos/usuarios/modelos/UsuarioCursosModelo.php';
        require_once 'modulos/usuarios/modelos/usuarioModelo.php';
        require_once 'modulos/pagos/modelos/operacionModelo.php';

        $cursosPorAbonar = getCursosPorAbonarSaldo();
        //por cada curso, hay que abonar el porentaje del precio al que fue vendido
        //y crear el registro de la operación
        //Después actualizamos la bd en usuariocurso para establecer que ya fue abonado
        $cantidadPorAbonar = 0;
        foreach ($cursosPorAbonar as $curso) {
            $cantidadPorAbonar = $curso['precioCurso'] * $porcentajeDeGananciaParaProfesores;
            if (actualizaSaldoUsuario($curso['idUsuario'], $cantidadPorAbonar)) {
                //Se actualizó correctamente el saldo del usuario
                //Creamos la operación
                $operacion = new Operacion();
                $operacion->cantidad = $cantidadPorAbonar;
                $operacion->completada = 1;
                $operacion->detalle = "Curso: <a href='/curso/" . $curso['uniqueUrl'] . "'>" . $curso['titulo'] . '</a>';
                $operacion->idTipoOperacion = 3; //ganancia por ventas = 3
                $operacion->idUsuario = $curso['idUsuario'];
                $operacion->idOperacion = altaOperacion($operacion);
                $banderaOperacion = ($operacion->idOperacion >= 0 );
                $banderaUsuarioCurso = false;
                if ($banderaOperacion) {
                    //se dió de alta correctamente la operación
                    //establecemos el usuariocurso como abonado
                    $banderaUsuarioCurso = establecerUsuarioCursoComoAbonado($curso['idAlumno'], $curso['idCurso']);
                }
                if ($banderaUsuarioCurso) {
                    //TODO BIEN!!
                    $numUsuariosAbonados = $numUsuariosAbonados + 1;
                    $cantidadAbonada = $cantidadAbonada + $cantidadPorAbonar;
                } else {
                    //si no fue actualizado correctamente el usuariocurso, revertimos la operación y el saldo
                    if ($banderaOperacion) {
                        //la operación si fue insertada correctamente, la borramos
                        bajaOperacion($operacion->idOperacion);
                    }
                    //regresamos el saldo a la cantidad anterior
                    actualizaSaldoUsuario($curso['idUsuario'], -$cantidadPorAbonar);
                }
            } else {
                //Ocurrió un error al abonar, no cambiamos la bd
            }
        }
        echo "Cursos abonados=" . $numUsuariosAbonados . " ;cantidad=" . $cantidadAbonada . " ;";
    } else {
        //no hacer nada
    }
}

function retirarSaldoSubmit() {
    if (validarUsuarioLoggeadoParaSubmits() && !empty($_POST['cantidad'])) {
        $cantidad = str_replace("$", "", $_POST['cantidad']);
        $cantidad = floatval($cantidad);
        $todoBien = false;
        $usuario = getUsuarioActual();
        if ($cantidad > 0 && $cantidad <= $usuario->saldo) {
            require_once 'modulos/pagos/modelos/solicitudSaldoModelo.php';
            require_once 'modulos/usuarios/modelos/usuarioModelo.php';
            require_once 'modulos/pagos/modelos/operacionModelo.php';
            require_once 'funcionesPHP/CargarInformacionSession.php';

            if (actualizaSaldoUsuario($usuario->idUsuario, -$cantidad)) {
                //Se actualizó correctamente el saldo, entonces generamos una operación
                $operacion = new Operacion();
                $operacion->idUsuario = $usuario->idUsuario;
                $operacion->cantidad = $cantidad;
                $operacion->idTipoOperacion = 4;
                $operacion->completada = 1;
                $operacion->detalle = "Retiro de saldo";
                $operacion->idOperacion = altaOperacion($operacion);
                if ($operacion->idOperacion >= 0) {
                    //se dio de alta correctamente la operacion, generamos la solicitud
                    $solicitudSaldo = new SolicitudSaldo();
                    $solicitudSaldo->idUsuario = $usuario->idUsuario;
                    $solicitudSaldo->cantidad = $cantidad;
                    $solicitudSaldo->entregado = 0;
                    if (altaSolicitudSaldo($solicitudSaldo)) {
                        setSessionMessage("<h4 class='success'>Tu solicitud de retirar saldo fue enviada correctamente</h4>");
                        cargarUsuarioSession();
                    } else {
                        //si ocurre un error, damos de baja la operación y regresamos el saldo a como estaba
                        bajaOperacion($operacion->idOperacion);
                        actualizaSaldoUsuario($usuario->idUsuario, $cantidad);
                        setSessionMessage("<h4 class='error'>Ocurrió un error al realizar tu solicitud. Intenta de nuevo más tarde</h4>");
                    }
                } else {
                    //no se dió de alta la operación, regresamos el saldo
                    actualizaSaldoUsuario($usuario->idUsuario, $cantidad);
                    setSessionMessage("<h4 class='error'>Ocurrió un error al realizar tu solicitud. Intenta de nuevo más tarde</h4>");
                }
            } else {
                //no se actualizó el saldo
                setSessionMessage("<h4 class='error'>Ocurrió un error al realizar tu solicitud. Intenta de nuevo más tarde</h4>");
            }
        } else {
            //no es una cantidad válida
            setSessionMessage("<h4 class='error'>La cantidad no es válida</h4>");
        }
        redirect("/usuarios/saldo");
    } else {
        goToIndex();
    }
}

?>