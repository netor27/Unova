<?php

class ColaMensajes {

    private $pheanstalk;
    private $tubeName;

    function __construct($tube) {
        $dir = dirname(__FILE__);
        require_once($dir . '/pheanstalk_init.php');
        $this->pheanstalk = new Pheanstalk('127.0.0.1');
        $this->pheanstalk->useTube($tube);
        $this->tubeName = $tube;
    }

    function push($data) {
        $this->pheanstalk->put($data);
    }

    function pop() {
        // $job->getData()
        try {
            $job = $this->pheanstalk->reserveFromTube("transformarvideos", 100);
            return $job;
        } catch (Exception $e) {
            return null;
        }
    }

    function deleteJob($job) {
        $this->pheanstalk->delete($job);
    }

    function printStats() {
        $this->pheanstalk->printTubeStats($this->tubeName);
    }

}

?>