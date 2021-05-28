<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examplemod extends Pluginsext_extands { 

    // Exemple //
    public function index() {
        echo "USE CORRECT METHODE";
    }
    
    // Function for edit the plugins, if you are specifique data //
    public function cl_pluginsext_edit($data) {
        // TODO HERE (dont delete return) //
        return $data; 
    } 
    
    // Function called from the pluginext menu 
    public function cl_pluginsext_menu($data) {
        return $data;
    }
    
    // Create your owne fonction //
    //   -- for calling a fonction from Cloodlog context, use : $this->_CLContext->xxx(); 
    public function myTestFunction() {
        $data['q1'] = $this->_params->arg1;
        $this->_CLContext->load->view('interface_assets/mini_header', $data);
        $this->_CLContext->load->add_package_path(APPPATH.$this->_CLContext->config->item('pluginsext_path').'/examplemod/');
        $this->_CLContext->load->view('examplemod/myTestFunction');
        $this->_CLContext->load->view('interface_assets/footer');
    }
	
}
