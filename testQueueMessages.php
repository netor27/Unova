<?php
// register Pheanstalk class loader
require_once('lib/php/beanstalkd/pheanstalk_init.php');

$pheanstalk = new Pheanstalk('127.0.0.1');

$accion;
if (!isset($_GET['a'])) {
    $accion = "publicar";
} else {
    $accion = $_GET['a'];
}

if ($accion == "publicar") {
    // ----------------------------------------
    // producer (queues jobs)
    $pheanstalk
            ->useTube('testtube')
            ->put("job payload goes here\n");
}

if ($accion == "leer") {
// ----------------------------------------
// worker (performs jobs)
    $job = $pheanstalk
            ->watch('testtube')
            ->ignore('default')
            ->reserve();
    echo $job->getData() . '<br><br>';
    $pheanstalk->delete($job);
}

$pheanstalk->printTubeStats('testtube');
?>