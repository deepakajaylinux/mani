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
                    "log-message" => "Lets begin invoking Configuration of Standalone App/DB Server on environment prod"
                ), ) ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "First lets SFTP over our Standalone Server CM Autopilot",
                ), ), ),
                array ( "SFTP" => array( "put" =>  array(
                    "guess" => true,
                    "source" => getcwd()."/build/config/cleopatra/cleofy/autopilots/generated/prod-cm-standalone-server.php",
                    "target" => "/tmp/prod-cm-standalone-server.php",
                    "environment-name" => "prod",
                ), ), ),
                array ( "Logging" => array( "log" =>array(
                    "log-message" => "Lets run that autopilot"
                ), ), ),
                array ( "Invoke" => array( "data" => array(
                    "guess" => true,
                    "ssh-data" => $this->setSSHData(),
                    "environment-name" => "prod",
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "Invoking Configuration of Standalone App/DB Server on environment prod complete"
                ), ), ),
            );

    }


    private function setSSHData() {
        $sshData = <<<"SSHDATA"
sudo cleopatra autopilot execute --autopilot-file="/tmp/prod-cm-standalone-server.php"
rm /tmp/prod-cm-standalone-server.php
SSHDATA;
        return $sshData ;
    }

}
