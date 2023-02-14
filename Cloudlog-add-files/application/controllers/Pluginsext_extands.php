<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//------------------ Extends of PluginExt Class //
class Pluginsext_extands {
    // Dont Delete : is necessary for use plugin //
    public $_CLContext;
    public $_isloadforparam = false;
    public $_pluginsext_user;
    public $_args; 
    public $_user_id; 
    public $user_stylesheet_backup;

    // 
    public function __construct($_this, $_isloadforparam=false, $pluginsext_user=null, $_args=null, $_user_id=null) {
        $this->_CLContext = $_this;
        $this->_isloadforparam = $_isloadforparam;
        $this->_pluginsext_user = $pluginsext_user;
        $this->_args = $_args;
        $this->_user_id = $_user_id;
        
        if (empty($this->_CLContext->session->userdata('user_id')) && $_user_id>0 && !$_isloadforparam)  {
            //$this->_CLContext->load->model('user_model');
            $this->_CLContext->user_model->update_session($this->_user_id); 
        }
    }

    // Change user_stylesheet during ex //
    public function change_user_stylesheet($back=false) {
        $user_stylesheet_default = "cosmo";
        if ($back) {
            if (!empty($this->user_stylesheet_backup)) { $this->_CLContext->session->__set('user_stylesheet',$this->user_stylesheet_backup); }
        } else {
            if ($this->_CLContext->session->userdata('user_stylesheet') <> $user_stylesheet_default) {
                $this->user_stylesheet_backup = $this->_CLContext->session->userdata('user_stylesheet');
                if (!$this->_isloadforparam) $this->_CLContext->session->__set('user_stylesheet',$user_stylesheet_default);                
            }
        }
    }
}