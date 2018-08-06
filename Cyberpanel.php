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
        return TRUE;
    }
    public function synchronizeAccount(Server_Account $a)
    {
        $this->getLog()->info('Synchronizing account with server '.$a->getUsername());
        return $a;
    }
}
