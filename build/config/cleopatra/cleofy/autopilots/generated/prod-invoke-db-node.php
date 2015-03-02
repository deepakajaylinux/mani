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
                    "log-message" => "Lets begin invoking Configuration of Mysql DB Server Slave Node on environment prod"
                ), ) ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "First lets SFTP over our Mysql DB Server Slave Node CM Autopilot",
                ), ), ),
                array ( "SFTP" => array( "put" =>  array(
                    "guess" => true,
                    "source" => getcwd()."/build/config/cleopatra/cleofy/autopilots/generated/prod-cm-db-node.php",
                    "target" => "/tmp/prod-cm-db-node.php",
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
                    "log-message" => "Invoking Configuration of Mysql DB Server Slave Node on environment prod complete"
                ), ), ),
            );

    }


    private function setSSHData() {
        $sshData = <<<"SSHDATA"
sudo cleopatra autopilot execute  --autopilot-file="/tmp/prod-cm-db-node.php"
rm /tmp/prod-cm-db-node.php
SSHDATA;
        return $sshData ;
    }

}
