<?php
class Configpdo extends PDO {
    public function __construct($tipo,$host,$database,$user,$pass){
        $dns = $tipo.':dbname='.$database.";host=".$host;
        parent::__construct( $dns, $user, $pass );
    }
}
?>

