<?php

Namespace Core ;

class AutoPilotConfigured extends AutoPilot {

    public $steps ;

    public function __construct() {
        $this->setSteps();
    }

    /* Steps */
    private function setSteps() {

    $this->steps =
        array(
            array ( "Logging" => array( "log" => array(
                "log-message" => "Lets begin invoking Configuration of a new Cleo and Dapper on environment "
            ), ), ),
            array ( "Logging" => array( "log" => array(
                "log-message" => "First lets SFTP over our Cleo Dapper CM Autopilot"
            ), ) ),
            array ( "SFTP" => array( "put" => array(
                "guess" => true,
                "source" => getcwd()."/build/config/cleopatra/cleofy/autopilots/generated/-cm-cleo-dapper.php",
                "target" => "/tmp/-cm-cleo-dapper.php",
                "environment-name" => "",
            ) , ) , ),
            array ( "Logging" => array( "log" => array(
                "log-message" => "Lets run that autopilot"
            ), ) ),
            array ( "Invoke" => array( "data" =>  array(
                "guess" => true,
                "ssh-data" => $this->setSSHData(),
                "environment-name" => ""
            ), ), ),
            array ( "Logging" => array( "log" => array(
                "log-message" => "Invoking a new Cleo and Dapper on environment  complete"
            ), ) ),
        );

    }

    private function setSSHData() {
        $sshData = <<<"SSHDATA"
cd /tmp
git clone https://github.com/PharaohTools/cleopatra.git
sudo php cleopatra/install-silent
sudo cleopatra autopilot execute --autopilot-file="/tmp/-cm-cleo-dapper.php"
rm /tmp/-cm-cleo-dapper.php
SSHDATA;
        return $sshData ;
    }

}