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

    private $time ;

    public function __construct() {
        $this->setTime() ;
        $this->setSteps();
    }

    /* Steps */
    private function setSteps() {

        $lowercase_db_platform = strtolower("joomla30");

        $this->steps =
            array(
                array ( "Logging" => array( "log" => array( "log-message" => "Lets begin with ensuring the Project Container is initialized" ), ) ),
                array ( "Project" => array( "container" => array(
                    "proj-container" => "<%tpl.php%>dap_proj_cont_dir</%tpl.php%>"
                ), ) , ) ,

                array ( "Logging" => array( "log" => array( "log-message" => "Next lets do our git clone" ), ) ),
                array ( "GitClone" => array( "clone" => array (
                    "guess" => true,
                    "change-owner-permissions" => false,
                    "repository-url" => "<%tpl.php%>dap_git_repo_url</%tpl.php%>",
                    "custom-clone-dir" => $this->getTime(),
                    "custom-branch" => "<%tpl.php%>dap_git_custom_branch</%tpl.php%>",
                ), ), ),

                array ( "Logging" => array( "log" => array( "log-message" => "Lets initialize our new download directory as a dapper project"), ) ),
                array ( "Project" => array( "init" => array(), ) , ) ,

                array ( "Logging" => array( "log" => array( "log-message" => "Next create our virtual host"), ) ),
                array ( "ApacheVHostEditor" => array( "add" => array (
                    "guess" => true,
                    "vhe-docroot" => "<%tpl.php%>dap_proj_cont_dir</%tpl.php%>{$this->getTime()}/",
                    "vhe-url" => "<%tpl.php%>dap_apache_vhost_url</%tpl.php%>",
                    "vhe-ip-port" => "<%tpl.php%>dap_apache_vhost_ip</%tpl.php%>",
                    "vhe-vhost-dir" => "/etc/apache2/sites-available",
                    "vhe-template" => $this->getTemplate(),
                ), ), ),

                array ( "Logging" => array( "log" => array("log-message" => "Lets ensure our Joomla temp and cache directories are writable"), ) ),
                array ( "RunCommand" => array("install" => array(
                    "guess" => true,
                    "command" => "sudo chown -R www-data <%tpl.php%>dap_proj_cont_dir</%tpl.php%>{$this->getTime()}/src/cache",
                ),),),
                array ( "RunCommand" => array("install" => array(
                    "guess" => true,
                    "command" => "sudo chown -R www-data <%tpl.php%>dap_proj_cont_dir</%tpl.php%>{$this->getTime()}/src/tmp",
                ),),),
                array ( "RunCommand" => array("install" => array(
                    "guess" => true,
                    "command" => "sudo chown -R www-data <%tpl.php%>dap_proj_cont_dir</%tpl.php%>{$this->getTime()}/src/administrator/cache",
                ),),),

                array ( "Logging" => array( "log" => array( "log-message" => "Next ensure our db file configuration is reset to blank" ), ), ),
                array ( "DBConfigure" => array( "$lowercase_db_platform-reset" => array(
                    "parent-path" => "<%tpl.php%>dap_proj_cont_dir</%tpl.php%>{$this->getTime()}/",
                    "platform" => "joomla30"
                ), ), ),

                array ( "Logging" => array( "log" => array("log-message" => "Next configure our projects db configuration file"), ) ),
                array ( "DBConfigure" => array( "$lowercase_db_platform-conf" => array(
                    "parent-path" => "<%tpl.php%>dap_proj_cont_dir</%tpl.php%>{$this->getTime()}/",
                    "mysql-host" => "<%tpl.php%>dap_db_ip_address</%tpl.php%>",
                    "mysql-user" => "<%tpl.php%>dap_db_app_user_name</%tpl.php%>",
                    "mysql-pass" => "<%tpl.php%>dap_db_app_user_pass</%tpl.php%>",
                    "mysql-db" => "<%tpl.php%>dap_db_name</%tpl.php%>",
                    "mysql-platform" => "joomla30",
                    "mysql-admin-user" => "<%tpl.php%>dap_db_admin_user_name</%tpl.php%>",
                    "mysql-admin-pass" => "<%tpl.php%>dap_db_admin_user_pass</%tpl.php%>",
                ), ) , ) ,

                array ( "Logging" => array( "log" => array( "log-message" => "The application is installed now so lets do our versioning" ), ), ),
                array ( "Version" => array( "latest" => array(
                    "container" => "<%tpl.php%>dap_proj_cont_dir</%tpl.php%>",
                    "limit" => "<%tpl.php%>dap_version_num_revisions</%tpl.php%>"
                ), ), ),

                array ( "Logging" => array( "log" => array( "log-message" => "Now lets restart Apache so we are serving our new application version", ), ), ),
                array ( "ApacheControl" => array( "restart" => array(
                    "guess" => true,
                ), ), ),

                array ( "Logging" => array( "log" => array("log-message" => "Our deployment is done" ), ), ),
            );

	}

    private function setTime() {
        $this->time = time() ;
    }

    private function getTime() {
        return $this->time ;
    }

    private function getTemplate() {
        $template =
            <<<'TEMPLATE'
           NameVirtualHost ****IP ADDRESS****:80
 <VirtualHost ****IP ADDRESS****:80>
   ServerAdmin webmaster@localhost
 	ServerName ****SERVER NAME****
 	DocumentRoot ****WEB ROOT****src
 	<Directory ****WEB ROOT****src>
 		Options Indexes FollowSymLinks MultiViews
 		AllowOverride All
 		Order allow,deny
 		allow from all
 	</Directory>
   ErrorLog /var/log/apache2/error.log
   CustomLog /var/log/apache2/access.log combined
 </VirtualHost>

 NameVirtualHost ****IP ADDRESS****:443
 <VirtualHost ****IP ADDRESS****:443>
 	 ServerAdmin webmaster@localhost
 	 ServerName ****SERVER NAME****
 	 DocumentRoot ****WEB ROOT****src
   # SSLEngine on
 	 # SSLCertificateFile /etc/apache2/ssl/ssl.crt
   # SSLCertificateKeyFile /etc/apache2/ssl/ssl.key
   # SSLCertificateChainFile /etc/apache2/ssl/bundle.crt
 	 <Directory ****WEB ROOT****src>
 		 Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>
  ErrorLog /var/log/apache2/error.log
  CustomLog /var/log/apache2/access.log combined
  </VirtualHost>
TEMPLATE;

        return $template ;
    }


}
