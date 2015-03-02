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
                "log-message" => "Lets begin invoking Configuration of a Git SCM Server on environment medium-bastion",
            ), ), ),
            array ( "Logging" => array( "log" => array(
                "log-message" => "First lets SFTP over our Git SCM Server CM Autopilot",
            ), ), ),
            array ( "SFTP" => array( "put" =>  array(
                "guess" => true,
                "source" => getcwd()."/build/config/cleopatra/cleofy/autopilots/generated/medium-bastion-cm-git.php",
                "target" => "/tmp/medium-bastion-cm-git.php",
                "environment-name" => "medium-bastion",
            ), ), ),
            array ( "Logging" => array( "log" =>array(
                "log-message" => "Lets run that autopilot"
            ), ), ),
            array ( "Invoke" => array( "data" => array(
                "guess" => true,
                "ssh-data" => $this->setSSHData(),
                "environment-name" => "medium-bastion",
            ), ), ),
            array ( "Logging" => array( "log" => array(
                "log-message" => "Invoking Git SCM Server on environment medium-bastion complete",
            ), ), ),
        );

    }

    private function setSSHData() {
        $sshData = <<<"SSHDATA"
sudo cleopatra autopilot execute --autopilot-file="/tmp/medium-bastion-cm-git.php"
rm /tmp/medium-bastion-cm-git.php
SSHDATA;
        return $sshData ;
    }

}