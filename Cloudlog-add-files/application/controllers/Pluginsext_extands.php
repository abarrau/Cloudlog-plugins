<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//------------------ Extends of PluginExt Class //
class Pluginsext_extands {
    // Dont Delete : is necessary for use plugin //
    public $user_stylesheet_backup;
    protected $CI;
    
    // Constructor //
    public function __construct() {
        $this->CI =& get_instance();
    }
    // return get key of instance //
    public function __get($key) {
        return get_instance()->$key;
    }
    // default index (not used) //
    public function index() {
        echo "USE CORRECT METHODE";
    }

    // change user_stylesheet during ex //
    public function change_user_stylesheet($user_stylesheet='cosmo') {
        if ($user_stylesheet===false) $back=true; else $back=false;
        if ($back) {
            if (!empty($this->user_stylesheet_backup)) { $this->session->__set('user_stylesheet',$this->user_stylesheet_backup); }
        } else {
            if ($this->session->userdata('user_stylesheet') <> $user_stylesheet) {
                $this->user_stylesheet_backup = $this->session->userdata('user_stylesheet');
                $this->session->__set('user_stylesheet',$user_stylesheet);
            }
        }
    }

    // return url of ex() methode //
    public function get_url_ex($pluginsext_nameid, $method) {
        return site_url("/pluginsext/ex/".$this->session->userdata('user_name')."/".$pluginsext_nameid."/".$method);
    }

    // return url of menu() methode //
    public function get_url_menu($pluginsext_nameid, $method="", $arg1="") {
        if ($method != "") $method = "/".$method;
        if ($arg1 != "") $arg1 = "/".$arg1;
        return site_url("/pluginsext/menu/".$pluginsext_nameid.$method.$arg1);
    }

}