<?php
/*
* API for Cyberpanel based on WHMCS module by jetchirag ////
*/

class CyberApi
{
	private function callUrl($params, $url)
	{
        return (($params["serversecure"]) ? "https" : "http"). "://".$params["serverhostname"].":8090/api/".$url;
	}
	
	private function call_cyberpanel($params,$url,$post = array())
	{
		$call = curl_init();
		curl_setopt($call, CURLOPT_URL, $this->callUrl($params,$url));	
		curl_setopt($call, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($call, CURLOPT_RETURNTRANSFER, true);	
		curl_setopt($call, CURLOPT_POST, true);
		curl_setopt($call, CURLOPT_POSTFIELDS, json_encode($post));
		curl_setopt($call, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($call, CURLOPT_SSL_VERIFYPEER, false);

		// Fire api
		$result = curl_exec($call);
		$info = curl_getinfo($call);
		curl_close($call);
		$result = json_decode($result,true);

		// Return data
		return $result;
	}

	public function get_packages($params, $adminUser, $adminPass){
		$url = "verifyConn";
        $postParams =
            [
                "adminUser" => $adminUser,
                "adminPass" => $adminPass,
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
	}
	
    public function create_new_account($params, $adminUser, $adminPass, $domainName, $ownerEmail, $packageName, $websiteOwner, $ownerPassword)
    {
        $url = "createWebsite";
        $postParams =
            [
                "adminUser" => $adminUser,
                "adminPass" => $adminPass,
                "domainName" => $domainName,
                "ownerEmail" => $ownerEmail,
                "packageName" => $packageName,
                "websiteOwner" => $websiteOwner,
                "ownerPassword" => $ownerPassword,
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }

    // Suspend Account
    public function change_account_status($params, $adminUser, $adminPass, $domainName, $status)
    {
        $url = "submitWebsiteStatus";
        $postParams =
            [
                "adminUser" => $adminUser,
                "adminPass" => $adminPass,
                "websiteName" => $domainName,
                "state" => $status,
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }

    // Test connection
    public function verify_connection($params, $adminUser, $adminPass)
    {
        $url = "verifyConn";
        $postParams =
            [
                "adminUser" => $adminUser,
                "adminPass" => $adminPass,
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }
    public function terminate_account($params, $adminUser, $adminPass, $domainName)
    {
        $url = "deleteWebsite";
        $postParams =
            [
                "adminUser" => $adminUser,
                "adminPass" => $adminPass,
                "domainName"=> $domainName
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }
    public function change_account_password($params, $adminUser, $adminPass, $websiteOwner, $ownerPassword)
    {
        $url = "changeUserPassAPI";
        $postParams =
            [
                "adminUser" => $adminUser,
                "adminPass" => $adminPass,
                "websiteOwner"=> $websiteOwner,
                "ownerPassword"=> $ownerPassword
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }
    public function change_account_package($params, $adminUser, $adminPass, $domainName, $packageName)
    {
        $url = "changePackageAPI";
        $postParams =
            [
                "adminUser" => $adminUser,
                "adminPass" => $adminPass,
                "websiteName"=> $domainName,
                "packageName"=> $packageName
            ];
        $result = $this->call_cyberpanel($params, $url, $postParams);
        return $result;
    }
