<?php

/*************************************
*      Generated Autopilot file      *
*     ---------------------------    *
*Autopilot Generated By Dapperstrano *
*     ---------------------------    *
*************************************/

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
                    "log-message" => "Lets begin invoking Rollback to Previous Version on environment prod"
                ), ) ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "First lets SFTP over our Dapper Autopilot"
                ), ) ),
                array ( "SFTP" => array( "put" => array(
                    "guess" => true,
                    "source" => getcwd()."/build/config/dapperstrano/dapperfy/autopilots/generated/prod-node-install-rollback-previous.php",
                    "target" => "prod-node-install-rollback-previous.php",
                    "environment-name" => "prod"
                ) , ) , ) ,
                array ( "Logging" => array( "log" => array(
                    "log-message" => "Lets run that autopilot"
                ), ) ),
                array ( "Invoke" => array( "data" =>  array(
                    "guess" => true,
                    "ssh-data" => $this->setSSHData(),
                    "environment-name" => "prod"
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "Invoking Rollback to Previous Version on environment prod complete"
                ), ) ),
            );
    }

    private function setSSHData() {
        $sshData = <<<"SSHDATA"
cd 
sudo dapperstrano autopilot execute --autopilot-file="prod-node-install-rollback-previous.php"
sudo rm prod-node-install-rollback-previous.php
SSHDATA;
        return $sshData ;
    }

}
