<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//------------------ Extends of PluginExt Class //
class Pluginsext_extands {
    // Dont Delete : is necessary for use plugin //
    public $_CLContext;
    public $_pluginsext_user;
    public $_args; 
    public $_user_id; 
    
    public function __construct($_this, $pluginsext_user=null, $_args=null, $_user_id=null) {
        $this->_CLContext = $_this;
        $this->_pluginsext_user = $pluginsext_user;
        $this->_args = $_args;
        $this->_user_id = $_user_id;
    }
}