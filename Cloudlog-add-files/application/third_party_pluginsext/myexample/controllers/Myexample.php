<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Myexample extends Pluginsext_extands { 

    // Exemple //
    public function index() {
        echo "USE CORRECT METHODE";
    }
    
    // Function for edit the plugins, if you are specifique data //
    public function cl_pluginsext_edit($_data) {
        // TODO HERE (dont delete return) //
        return $_data; 
    } 
    
    // Function called from the pluginext menu 
    public function cl_pluginsext_menu($_data) {
        return $_data;
    }
    
    // Create your owne fonction //
    public function myTestFunction($_data) {
        //$_data['q1'] = $this->_params->arg1;
    }
	
}
