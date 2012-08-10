#!/usr/bin/php -q
<?php
/**
 * System_Daemon turns PHP-CLI scripts into daemons.
 *
 * PHP version 5
 *
 * @category  System
 * @package   System_Daemon
 * @author    Kevin <kevin@vanzonneveld.net>
 * @copyright 2008 Kevin van Zonneveld
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://github.com/kvz/system_daemon
 */
/**
 * System_Daemon Example Code
 *
 * If you run this code successfully, a daemon will be spawned
 * but unless have already generated the init.d script, you have
 * no real way of killing it yet.
 *
 * In this case wait 3 runs, which is the maximum for this example.
 *
 *
 * In panic situations, you can always kill you daemon by typing
 *
 * killall -9 logparser.php
 * OR:
 * killall -9 php
 *
 */
// Allowed arguments & their defaults
$runmode = array(
    'no-daemon' => false,
    'help' => false,
    'write-initd' => false,
);

// Scan command line attributes for allowed arguments
foreach ($argv as $k => $arg) {
    if (substr($arg, 0, 2) == '--' && isset($runmode[substr($arg, 2)])) {
        $runmode[substr($arg, 2)] = true;
    }
}

// Help mode. Shows allowed argumentents and quit directly
if ($runmode['help'] == true) {
    echo 'Usage: ' . $argv[0] . ' [runmode]' . "\n";
    echo 'Available runmodes:' . "\n";
    foreach ($runmode as $runmod => $val) {
        echo ' --' . $runmod . "\n";
    }
    die();
}

// Make it possible to test in source directory
// This is for PEAR developers only
ini_set('include_path', ini_get('include_path') . ':..');

// Include Class
error_reporting(E_STRICT);
require_once 'System/Daemon.php';

// Setup
$options = array(
    'appName' => 'transviddaemon',
    'appDir' => dirname(__FILE__),
    'appDescription' => 'Revisa la cola de videos por transformar y si hay algo lo transforma',
    'authorName' => 'Ernesto Rubio F',
    'authorEmail' => 'neto.r27@gmail.com',
    'sysMaxExecutionTime' => '0',
    'sysMaxInputTime' => '0',
    'sysMemoryLimit' => '1024M',
    'appRunAsGID' => 1000,
    'appRunAsUID' => 1000,
);

System_Daemon::setOptions($options);

// This program can also be run in the forground with runmode --no-daemon
if (!$runmode['no-daemon']) {
    // Spawn Daemon
    System_Daemon::start();
}

// With the runmode --write-initd, this program can automatically write a
// system startup file called: 'init.d'
// This will make sure your daemon will be started on reboot
if (!$runmode['write-initd']) {
    System_Daemon::info('not writing an init.d script this time');
} else {
    if (($initd_location = System_Daemon::writeAutoRun()) === false) {
        System_Daemon::notice('unable to write init.d script');
    } else {
        System_Daemon::info(
                'sucessfully written startup script: %s', $initd_location
        );
    }
}

// Run your code
// Here comes your own actual code
// This variable gives your own code the ability to breakdown the daemon:
$runningOkay = true;

// While checks on 3 things in this case:
// - That the Daemon Class hasn't reported it's dying
// - That your own code has been running Okay
// - That we're not executing more than 3 runs
while (!System_Daemon::isDying() && $runningOkay) {
    //System_Daemon::info("entrando al while");
    // What mode are we in?
    // $mode = '"' . (System_Daemon::isInBackground() ? '' : 'non-' ) .
    //         'daemon" mode';
    // System_Daemon::info('{appName}  in %s %s/300', $a, $b);
    try {
        require_once 'lib/php/beanstalkd/ColaMensajes.php';
        $colaMensajes = new ColaMensajes("transformarvideos");

        $job = $colaMensajes->pop();
        if ($job == "") {
            //Time out
            //System_Daemon::info("Time out!");
        } else {
            $json = $job->getData();
            require_once 'modulos/videos/controladores/videoControlador.php';
            if (transformar($json)) {
                System_Daemon::notice('Video transformado correctamente');                
            }else{
                System_Daemon::info("ERROR! el resultado de la transformación no es cero");
            }
            $colaMensajes->deleteJob($job);
        }
    } catch (Exception $e) {
        System_Daemon::info('ERROR! %s', $e->getMessage());
    }
    if (!$runningOkay) {
        System_Daemon::err('parseLog() produced an error, ' .
                'so this will be my last run');
    }
    // Relax the system by sleeping for a little bit iterate also clears statcache
    System_Daemon::iterate(2);
}
// Shut down the daemon nicely
// This is ignored if the class is actually running in the foreground
System_Daemon::stop();
?>