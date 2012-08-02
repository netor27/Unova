</head>

<body>

    <div id="e_bar">
        <div id="top-bar">
            <a href="/" class="logo left" id="logo"> <img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
            <div id="e_search-box-wrapper">
                <div id="e_search-box"  class="right">
                    <form action="/busqueda.php" id="search-form" method="get">
                        <input id="q" class="search-input ease3 ui-autocomplete-input" autocomplete="off" name="q" type="text" placeholder="Buscar" role="textbox" aria-autocomplete="list" aria-haspopup="true"/>
                        <input type="submit" id="u_search-submit" value/>
                    </form>
                </div>
            </div>            
            <?php
            require_once 'funcionesPHP/funcionesGenerales.php';
            require_once 'modulos/usuarios/clases/Usuario.php';

            if (tipoUsuario() == 'visitante') {
                ?>
                <a href="/usuarios/registro" class="element right ease3">Registrarse</a>
                <a href="/login" class="element right ease3">Iniciar Sesión</a>
                <?php
            } else {
                $usuarioHead = getUsuarioActual();
                if (isset($usuarioHead)) {
                    ?>
                    <a href="#" class="element right ease3" id="menuPerfilLink"><?php echo substr($usuarioHead->nombreUsuario, 0, 14); ?><img src="/layout/imagenes/down.png"></a>                
                    <a href="#" class="element right ease3" id="menuCursosLink">Mis cursos  <img src="/layout/imagenes/down.png"></a>                
                    <?php
                }
            }
            ?>
            <a href="/cursos/curso/crearCurso" class="element right ease3">Crear un curso</a>
        </div>
    </div>
    <?php
    if (tipoUsuario() == 'usuario' || tipoUsuario() == 'administrador') {
        ?>
        <div class="dropdownContainer">
            <div id="perfil_menu">   
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
                    <a href="/usuarios/saldo">
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
            <div id="cursos_menu">
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
    }
    ?>
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