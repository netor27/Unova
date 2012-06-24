<?php
require_once 'modulos/cdn/clases/cloudfiles.php';

$username = "netor27";
$api_key = "a4958be56757129de44332626cb0594b";
$auth = new CF_Authentication($username, $api_key);
$auth->authenticate();

print $auth->storage_url . "<br>";

$conn = new CF_Connection($auth, TRUE);

print_r($conn->list_containers());
?>
