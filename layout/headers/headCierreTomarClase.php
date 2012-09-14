</head>

<body>
    <script>
        var layout = "<?php echo getTipoLayout(); ?>";
    </script>
    <div id="e_bar">
        <div id="top-bar">
            <a href="/" class="logo left" id="logo"> <img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
            <?php
            $usuarioHead = getUsuarioActual();
            if (isset($usuarioHead)) {
                ?>
                <div style="margin-left: 20px;">
                    <div  class="element left ease3" style="width:190px;">
                        <?php
                        if (getTipoLayout() == "desktop") {
                            ?>
                            <a class="link" > 
                                <div id="menuClasesLink">
                                    <span class="left">
                                        Clases de este curso 
                                    </span>
                                    <div id="flechaClases" class="flechaAbajo left"></div>
                                </div>
                            </a>
                            <div id="flechitaClases"></div>
                            <div id="clases_menu">                            
                                <?php
                                if (isset($temas) && isset($clases)) {
                                    foreach ($temas as $tema) {
                                        echo '<div class="clasesMenuHeader">';
                                        echo $tema->nombre;
                                        echo '</div>';
                                        foreach ($clases as $claseF) {
                                            if ($tema->idTema == $claseF->idTema) {

                                                echo '<a href="/curso/' . $curso->uniqueUrl . '/' . $claseF->idClase . '">';
                                                if ($claseF->idClase == $clase->idClase)
                                                    echo '<div class="clasesMenuElement clasesMenuElementActual">';
                                                else
                                                    echo '<div class="clasesMenuElement">';

                                                switch ($claseF->idTipoClase) {
                                                    case 0:
                                                        echo '<img src="/layout/imagenes/video.png">';
                                                        break;
                                                    case 1:
                                                        echo '<img src="/layout/imagenes/document.png">';
                                                        break;
                                                    case 2:
                                                        echo '<img src="/layout/imagenes/presentation.png">';
                                                        break;
                                                    default:
                                                        echo '<img src="/layout/imagenes/document.png">';
                                                        break;
                                                }
                                                echo '<span class="left">' . $claseF->titulo . '</span>';
                                                if ($claseF->idTipoClase == 0) {
                                                    echo '<br><span class="left">' . $claseF->duracion . '</span>';
                                                }

                                                echo ' </div>';
                                                echo '</a>';
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        } else {
                            //si no es desktop no mostramos la lista de cursos
                            ?>
                            <a class="link" href="/curso/<?php echo $curso->uniqueUrl; ?>"> 
                                <div id="menuClasesLink">
                                    <span class="left">
                                        Clases de este curso 
                                    </span>
                                </div>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                    <div  class="element left ease3">
                        <?php
                        if ($idSiguienteClase > 0) {
                            ?>
                            <a href="/curso/<?php echo $curso->uniqueUrl . "/" . $idSiguienteClase; ?>" class="link" id="menuSiguienteClase" > 
                                Siguiente Clase 
                                <img src="/layout/imagenes/siguiente.png">
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="element right ease3">
                    <?php
                    if (getTipoLayout() == "desktop") {
                        ?>
                        <a class="link">
                            <div id="menuPerfilLink">
                                <span class="left">
                                    <?php echo substr($usuarioHead->nombreUsuario, 0, 14); ?>
                                </span>
                                <div id="flechaPerfil" class="flechaAbajo left"></div>
                            </div>
                        </a>                
                        <div id="perfil_menu"> 
                            <div id="flechitaPerfil"></div>
                            <a href="/usuario/<?php echo $usuarioHead->uniqueUrl; ?>">
                                <div id="perfil_image">
                                    <img src="<?php echo $usuarioHead->avatar; ?>">
                                    <span><?php echo substr($usuarioHead->nombreUsuario, 0, 14); ?></span>
                                    <br><br>
                                    <span style="font-size: smaller">Editar perfil</span>
                                </div>
                            </a>
                            <div id="perfil_links">
                                <!--<a href="/usuarios/saldo">-->
                                <a >
                                    <span>Cuenta</span>
                                    <br>
                                    <?php
                                    if ($usuarioHead->saldo > 0) {
                                        echo '<span id="perfil_saldo">Saldo: $' . $usuarioHead->saldo . '</span>';
                                    } else {
                                        echo '<span id="perfil_saldo_cero">Saldo: $' . $usuarioHead->saldo . '</span>';
                                    }
                                    ?>
                                </a>
                                <br>
                                <a href="/login/login/logout"><span>Cerrar Sesión</span></a><br>
                            </div>
                        </div>
                    </div>
                    <div class="element right ease3">
                        <a class="link" >
                            <div id="menuCursosLink">
                                <span class="left">Mis cursos</span>
                                <div id="flechaCursos" class="flechaAbajo left"></div>
                            </div>
                        </a>                
                        <div id="cursos_menu">
                            <div id="flechitaCursos"></div>
                            <div class="cursosMenuHeader">
                                Cursos de los que soy instructor
                            </div>                
                            <?php
                            if (isset($_SESSION['cursosPropios'])) {
                                $cursosSession = $_SESSION['cursosPropios'];
                                foreach ($cursosSession as $cursoSess) {
                                    ?>
                                    <a href="/curso/<?php echo $cursoSess->uniqueUrl; ?>">
                                        <div class="cursoMenuElement">
                                            <img src="<?php echo $cursoSess->imagen; ?>"/><?php echo $cursoSess->titulo; ?>
                                            <div class=""><h6>Editar</h6></div>
                                        </div>
                                    </a>
                                    <?php
                                }
                            } else {
                                ?>                
                                <div class="cursoMenuElement">
                                    <h3>No has creado ningún curso</h3>
                                </div>
                            <?php } ?>
                            <a href="/usuarios/cursos/instructor">
                                <div class="cusosMenuVerMas">
                                    Ver todos >>
                                </div>
                            </a>
                            <div class="cursosMenuHeader">
                                Cursos que estoy tomando
                            </div>                
                            <?php
                            if (isset($_SESSION['cursos'])) {
                                $cursosSession = $_SESSION['cursos'];
                                foreach ($cursosSession as $cursoSess) {
                                    ?>
                                    <a href="/curso/<?php echo $cursoSess->uniqueUrl; ?>">
                                        <div class="cursoMenuElement">
                                            <img src="<?php echo $cursoSess->imagen; ?>"/><?php echo $cursoSess->titulo; ?>
                                        </div>
                                    </a>
                                    <?php
                                }
                            } else {
                                ?>                
                                <div class="cursoMenuElement">
                                    <h3>No te has inscrito a ningún curso</h3>
                                </div>
                            <?php } ?>
                            <a href="/usuarios/cursos/inscrito">
                                <div class="cusosMenuVerMas">
                                    Ver todos >>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                } else {
                    //no es desktop, no mostrar estos menus
                    ?>
                    <div class="element right ease3" style="width:200px;">
                        <a class="link" href="/curso/<?php echo $curso->uniqueUrl; ?>"> 
                            <div id="menuCursosLink">
                                <span class="left">Regresar a la página del curso</span>
                                <div id="flechaCursos" class="flechaAbajo left"></div>
                            </div>
                        </a> 
                    </div>
                    <?php
                }
                ?>

                <?php
            }
            ?>
        </div>
    </div>
    <div id="e_site">    
        <div id="modalDialog"></div>
        <?php
        $sessionMessage = getSessionMessage();
        if (!is_null($sessionMessage)) {
            echo '<div id="sessionMessage" class="centerText" >';
            echo $sessionMessage;
            echo '</div>';
        }
        ?>