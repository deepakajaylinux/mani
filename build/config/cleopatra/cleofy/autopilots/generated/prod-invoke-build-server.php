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
                    "log-message" => "Lets begin invoking Configuration of a build server on environment prod"
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "First lets SFTP over our Build Server CM Autopilot"
                ), ), ),
                array ( "SFTP" => array( "put" => array(
                    "guess" => true,
                    "source" => getcwd()."/build/config/cleopatra/cleofy/autopilots/generated/prod-cm-build-server.php" ,
                    "target" => "/tmp/prod-cm-build-server.php",
                    "environment-name" => "prod",
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "Next lets SFTP over our Papyrus File"
                ), ), ),
                array ( "SFTP" => array( "put" => array(
                    "guess" => true,
                    "source" => getcwd()."/papyrusfile" ,
                    "target" => "/tmp/papyrusfile",
                    "environment-name" => "prod",
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "Lets run that autopilot"
                ), ), ),
                array ( "Invoke" => array( "data" => array(
                    "guess" => true,
                    "ssh-data" => $this->setSSHData(),
                    "environment-name" => "prod"
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "Invoking a build server on environment prod complete"
                ), ), ),
            );

    }

    private function setSSHData() {
        $sshData = <<<"SSHDATA"
cd /tmp
sudo cleopatra autopilot execute --autopilot-file="/tmp/prod-cm-build-server.php"
rm /tmp/prod-cm-build-server.php
SSHDATA;
        return $sshData ;
    }

}
