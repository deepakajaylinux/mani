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
                "log-message" => "Lets begin invoking Configuration of a Git SCM Server on environment prod",
            ), ), ),
            array ( "Logging" => array( "log" => array(
                "log-message" => "First lets SFTP over our Git SCM Server CM Autopilot",
            ), ), ),
            array ( "SFTP" => array( "put" =>  array(
                "guess" => true,
                "source" => getcwd()."/build/config/cleopatra/cleofy/autopilots/generated/prod-cm-git.php",
                "target" => "/tmp/prod-cm-git.php",
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
                "log-message" => "Invoking Git SCM Server on environment prod complete",
            ), ), ),
        );

    }

    private function setSSHData() {
        $sshData = <<<"SSHDATA"
sudo cleopatra autopilot execute --autopilot-file="/tmp/prod-cm-git.php"
rm /tmp/prod-cm-git.php
SSHDATA;
        return $sshData ;
    }

}