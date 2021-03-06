<?php

Namespace Core ;

class AutoPilotConfigured extends AutoPilot {

    public $steps ;
//    protected $myUser ;

    public function __construct() {
        $this->setSteps();
    }

    /* Steps */
    private function setSteps() {

        // @todo find a better way to get this filename
        $reverseProxyAutopilot = "/opt/cleopatra/cleopatra/src/Modules/GitBucket/Autopilots/Dapperstrano/proxy-8080-to-80.php" ;

        $this->steps =
            array(
                array ( "Logging" => array( "log" => array( "log-message" => "Lets begin Configuration of a Git SCM Server on environment medium-bastion"),),),

//                // Install Keys - Bastion Public Key, DevOps Public Key, Bastion Private Key
//                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure our Bastion Public Key is installed" ),),),
//                array ( "SshKeyInstall" => array( "file" =>
//                    array("public-key-file" => "build/config/cleopatra/SSH/keys/public/raw/bastion"),
//                    array("user-name" => "{$this->myUser}"),),),
//                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure our DevOps Public Key is installed" ),),),
//                array ( "SshKeyInstall" => array( "file" =>
//                    array("public-key-file" => "build/config/cleopatra/SSH/keys/public/raw/bastion"),
//                    array("user-name" => "{$this->myUser}"),),),
//                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure our Bastion Private Key is installed" ),),),
//                // @todo if this is run over ssh from another machine (DevOps laptop), the encryption key never needs to be on the target
//                // box might not even need encryption... look at this
//                array ( "Encryption" => array( "uninstall" =>
//                    array("encrypted-data" => "build/config/cleopatra/SSH/keys/private/encrypted/bastion"),
//                    array("encryption-target-file" => "{$this->myUserHome}/.ssh/bastion"),
//                    // @todo the key thing
//                    array("encryption-key" => "{$this->myUser}"),
//                    array("encryption-file-permissions" => ""),
//                    array("encryption-file-owner" => ""),
//                    array("encryption-group" => ""),
//                ),),

                // SSH Hardening
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure we have some SSH Security" ),),),
                array ( "SshHarden" => array( "ensure" => array(),),),

                // Standard Tools
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure some standard tools are installed" ),),),
                array ( "StandardTools" => array( "ensure" => array(),),),

                // Git Tools
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure some git tools are installed" ),),),
                array ( "GitTools" => array( "ensure" => array(),),),

                // Git Key Safe
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Git SSH Key Safe version is are installed" ),),),
                array ( "GitKeySafe" => array( "ensure" => array(),),),

                // PHP Modules
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure our common PHP Modules are installed" ),),),
                array ( "PHPModules" => array( "ensure" => array(),),),

                // Apache
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Apache Server is installed" ),),),
                array ( "ApacheServer" => array( "ensure" =>  array("version" => "2.2"), ), ),

                // Apache Modules
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure our common Apache Modules are installed" ),),),
                array ( "ApacheModules" => array( "ensure" => array(),),),

                // Apache Modules
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure our Reverse Proxy Apache Modules are installed" ),),),
                array ( "ApacheReverseProxyModules" => array( "ensure" => array(),),),

                // Restart Apache for new modules
                array ( "Logging" => array( "log" => array( "log-message" => "Lets restart Apache for our PHP and Apache Modules" ),),),
                array ( "RunCommand" => array( "install" => array(
                    "guess" => true,
                    "command" => "dapperstrano ApacheCtl restart --yes",
                ) ) ),

                // Install Git Bucket
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure GitBucket is installed" ),),),
                array ( "GitBucket" => array( "ensure" => array(
                    "guess" => true,
                    "with-http-port-proxy" => true
                ),),),

                // Start Git Bucket
                array ( "Logging" => array( "log" => array( "log-message" => "Lets start GitBucket" ),),),
                array ( "RunCommand" => array( "install" => array(
                    "guess" => true,
                    "command" => "gitbucket",
                ) ) ),

                // Reverse proxy port 8080 to port 80, so we can close 80800 in the firewall
                array ( "Logging" => array( "log" => array( "log-message" => "Lets dapper a reverse proxy"),),),
                array ( "RunCommand" => array("install" => array(
                    "guess" => true,
                    "command" => "dapperstrano autopilot execute --autopilot-file=$reverseProxyAutopilot --vhe-url=",
                ),),),

                // Firewall
                // @todo when the dapper reverse proxy works we can deny 8080 requests
                array ( "Logging" => array( "log" => array( "log-message" => "Lets disable Firewall to change settings"), ) , ) ,
                array ( "Firewall" => array( "disable" => array(), ) , ) ,
                array ( "Logging" => array( "log" => array( "log-message" => "Lets deny all input"), ) , ) ,
                array ( "Firewall" => array( "default" => array("policy" => "deny" ), ) , ) ,
                array ( "Logging" => array( "log" => array( "log-message" => "Lets allow SSH input"), ) , ) ,
                array ( "Firewall" => array( "allow" => array("firewall-rule" => "ssh/tcp" ), ) , ) ,
                array ( "Logging" => array( "log" => array( "log-message" => "Lets allow HTTP input"), ) , ) ,
                array ( "Firewall" => array( "allow" => array("firewall-rule" => "http/tcp" ), ) , ) ,
                array ( "Logging" => array( "log" => array( "log-message" => "Lets allow HTTPS input"), ) , ) ,
                array ( "Firewall" => array( "allow" => array("firewall-rule" => "https/tcp" ), ) , ) ,
                array ( "Logging" => array( "log" => array( "log-message" => "Lets allow 8080 input"), ) , ) ,
                array ( "Firewall" => array( "allow" => array("firewall-rule" => "8080/tcp" ), ) , ) ,
                array ( "Logging" => array( "log" => array( "log-message" => "Lets enable Firewall again"), ) , ) ,
                array ( "Firewall" => array( "enable" => array(), ) , ) ,

                array ( "Logging" => array( "log" => array( "log-message" => "Configuring a Git SCM server on environment medium-bastion complete"),),),

        );

    }

}
