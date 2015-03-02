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
                    "log-message" => "Lets begin invoking PHP initial install on environment prod"
                ), ), ),
                array ( "Logging" => array( "log" => array(
                    "log-message" => "Lets SSH our PHP Install Command"
                ), ), ),
                array ( "Invoke" => array( "data" => array(
                    "guess" => true,
                    "ssh-data" => $this->setSSHData(),
                    "environment-name" => "prod"
                ), ), ),
                array ( "Logging" => array( "log" => array(
                     "log-message" => "Invoking a PHP initial install on environment prod complete"
                ), ), ),
            );

    }

    private function setSSHData() {
        $sshData = <<<"SSHDATA"
sudo apt-get update
sudo apt-get install -y php5 git
SSHDATA;
        return $sshData ;
    }

}
