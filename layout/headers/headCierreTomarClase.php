</head>

<body>

    <div id="e_bar">
        <div id="top-bar">
            <a href="/" class="logo left" id="logo"> <img src="/layout/imagenes/Unova_Logo_135x47.png"></a>
            <div style="margin-left: 20px;">
                <a href="#" class="element left ease3" id="menuClasesLink"> Clases de este curso <img src="/layout/imagenes/down.png"></a>                
                <?php
                if($idSiguienteClase > 0){
                    echo '<a href="/curso/'.$curso->uniqueUrl . '/' . $idSiguienteClase .'" class="element left ease3" id="menuSiguienteClase"> Siguiente Clase <img src="/layout/imagenes/siguiente.png"></a>';
                }
                ?>
                
            </div>
            <?php
            $usuarioHead = getUsuarioActual();
            if (isset($usuarioHead)) {
                ?>
                <a href="#" class="element right ease3" id="menuPerfilLink"><?php echo substr($usuarioHead->nombreUsuario, 0, 14); ?><img src="/layout/imagenes/down.png"></a>                
                <a href="#" class="element right ease3" id="menuCursosLink">Mis cursos  <img src="/layout/imagenes/down.png"></a>                
                <?php
            }
            ?>
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
                    <a href="#">
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
            <div id="clases_menu">
                <?php
                if (isset($temas) && isset($clases)) {
                    foreach ($temas as $tema) {
                        echo '<div class="clasesMenuHeader">';
                        echo $tema->nombre;
                        echo '</div>';
                        foreach ($clases as $claseF) {
                            if ($tema->idTema == $claseF->idTema) {
                                ?>
                                <a href="/curso/<?php echo $curso->uniqueUrl . "/" . $claseF->idClase; ?>">
                                    <?php
                                    if ($claseF->idClase == $clase->idClase)
                                        echo '<div class="clasesMenuElement clasesMenuElementActual">';
                                    else
                                        echo '<div class="clasesMenuElement">';
                                    ?>
                                    <?php
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
                                    ?>
                            </div>
                        </a>
                        <?php
                    }
                }
            }
        }
        ?>
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