<?php

class Server_Manager_CyberPanel extends Server_Manager {
  
  public function init() {
    
  }
  
      public static function getForm()
    {
        return array(
            'label'     =>  'Cyber Panel',
        );
    }
    public function getLoginUrl()
    {
        $host     = $this->_config['host'];
        return 'http://'.$host.':8090';
    }
    public function getResellerLoginUrl()
    {
        $host     = $this->_config['host'];
        return 'http://'.$host.':8090';
    }
    public function testConnection()
    {
        
      try {
        $adminUser = $params["serverusername"];
        $adminPass = $params["serverpassword"];

        $api = new CyberApi();
        $test_conn = $api->verify_connection($params, $adminUser, $adminPass);

        // Checking for errors
        $errorMsg = '';
        if (!$test_conn["verifyConn"]){
        	$errorMsg =  $test_conn["error_message"];
        	$success = false;
        }
        else {
        	$success = true;
        	$errorMsg = '';
        }
        } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        $success = false;
        $errorMsg = $e->getMessage();
    }

    return array(
        'success' => $success,
        'error' => $errorMsg,
    );
    }
  
    public function synchronizeAccount(Server_Account $a)
    {
        $this->getLog()->info('Synchronizing account with server '.$a->getUsername());
        return $a;
    }
  
  
  public function createAccount(Server_Account $a) {
    
    try {
    	// Set all parameters
        $adminUser = $params["serverusername"];
        $adminPass = $params["serverpassword"];
        $websiteOwner = $params["username"];
        $ownerPassword = $params["password"];
        $ownerEmail = $params["clientsdetails"]["email"];
        $domainName = $params["domain"];
        $adminPass = $params["serverpassword"];
        $packageName = $params['configoption1'];

        $api = new CyberApi();
        $new_account = $api->create_new_account($params, $adminUser, $adminPass, $domainName, $ownerEmail, $packageName, $websiteOwner, $ownerPassword);

        // Checking for errors
        if (!$new_account["createWebSiteStatus"]){
        	return $new_account["error_message"];
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'cyberpanel',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
    
  }
}
