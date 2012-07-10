<?php

//Application Configurations
$app_id = "294007460696661";
$app_secret = "beb28525091b61b76f36d2a76c875ca3";
$site_url = "http://unova.co/login";
try {
    include_once "lib/php/facebook/src/facebook.php";
} catch (Exception $e) {
    error_log($e);
    echo $e;
}
// Create our application instance
$facebook = new Facebook(array(
            'appId' => $app_id,
            'secret' => $app_secret,
        ));

// Get User ID
$user = $facebook->getUser();

if ($user) {
    // Get logout URL
    $logoutUrl = $facebook->getLogoutUrl();
    $queries = array(
        array('method' => 'GET', 'relative_url' => '/' . $user)
    );

    try {
        $batchResponse = $facebook->api('?batch=' . json_encode($queries), 'POST');
    } catch (Exception $o) {
        error_log($o);
    }
    $user_info = json_decode($batchResponse[0]['body'], TRUE);
} else {
    // Get login URL
    $loginUrl = $facebook->getLoginUrl(array(
        'scope' => 'email',
        'redirect_uri'	=> $site_url
            ));
}

//si ya inicio sesión en facebook, entonces hacemos varias validaciones
if ($user) {
    //tenemos un usuario logeado en facebook
    //Datos de facebook
    $email = $user_info['email'];
    $nombre = $user_info['name'];
    $avatar = 'http://graph.facebook.com/' . $user . '/picture?type=normal';
    require_once 'modulos/principal/modelos/loginModelo.php';
    require_once 'modulos/usuarios/modelos/usuarioModelo.php';
    //validamos si este usuario ya tiene su email registrado, sino creamos un usuario nuevo
    $usuario = getUsuarioFromEmail($email);
    if (isset($usuario)) {
        //el usuario ya existe en la bd, loggearlo!
        if (loginUsuario($usuario->email, $usuario->password) == 1) {
            setSessionMessage("<h4 class='success'>¡Bienvenido " . getUsuarioActual()->nombreUsuario . "!</h4>");
        }
    } else {
        //el usuario no existe en la bd, crearlo!
        require_once 'modulos/usuarios/clases/Usuario.php';
        require_once 'funcionesPHP/uniqueUrlGenerator.php';
        $usuario = new Usuario();
        $usuario->nombreUsuario = $nombre;
        $usuario->email = $email;
        $password = getUniqueCode(10);
        $usuario->password = md5($password);
        $usuario->uniqueUrl = getUsuarioUniqueUrl($nombre);

        $array = altaUsuario($usuario);
        $id = $array['id'];
        $usuario->idUsuario = $id;

        if ($id >= 0) {
            //Ya creamos el usuario, ahora actualizamos su avatar y su estado de activado
            echo 'se creo un usuario con id= ' . $id;
            $usuario->avatar = $avatar;
            actualizaAvatar($usuario);
            setActivado($id, 1);
            if (loginUsuario($email, md5($password)) == 1) {
                setSessionMessage("<h4 class='success'>¡Bienvenido " . getUsuarioActual()->nombreUsuario . "!</h4>");
            }
        }
    }
}

//if($user){
// POST your queries to the batch endpoint on the graph.
//Return values are indexed in order of the original array, content is in ['body'] as a JSON
//string. Decode for use as a PHP array.
//========= Batch requests over the Facebook Graph API using the PHP-SDK ends =====
// Update user's status using graph api
//	if(isset($_POST['pub'])){
//		try{
//			$statusUpdate = $facebook->api("/$user/feed", 'post', array(
//				'message'		=> 'Check out 25 labs',
//				'link'			=> 'http://25labs.com',
//				'picture'		=> 'http://25labs.com/images/25-labs-160-160.jpg',
//				'name'			=> '25 labs | A Technology Laboratory',
//				'caption'		=> '25labs.com',
//				'description'	=> '25 labs is a Technology blog that covers the tech stuffs happening around the globe. 25 labs publishes various tutorials and articles on web designing, Facebook API, Google API etc.',
//				));
//		}catch(FacebookApiException $e){
//			error_log($e);
//		}
//	}
//
//	// Update user's status using graph api
//	if(isset($_POST['status'])){
//		try{
//			$statusUpdate = $facebook->api("/$user/feed", 'post', array('message'=> $_POST['status']));
//		}catch(FacebookApiException $e){
//			error_log($e);
//		}
//	}
//}
?>