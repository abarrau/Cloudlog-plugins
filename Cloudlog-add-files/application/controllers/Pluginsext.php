<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pluginsext extends CI_Controller {

        private $pluginsext_current = array();
        
        // load construct //
	function __construct()
	{
            parent::__construct();
            $this->lang->load('pluginsext');
            $this->load->model('pluginsext_model');
        }
            
        // default methode : list plugins //
        public function index() {
            // check new plugin exist in folder //
            $this->check_new_update_pluginsext(true);
            
            $list_pluginsext = $this->pluginsext_model->list_all();
            $list_pluginsext_for_user = $this->pluginsext_model->list_for_user($this->session->userdata('user_id'));
            $data['list_pluginsext'] = $this->pluginsext_model->list_merge_data($list_pluginsext, $list_pluginsext_for_user);
       
            $data['page_title'] = $this->lang->line('pluginsext_title_page');
            
            $this->load->view('interface_assets/header', $data);
            $this->load->view('pluginsext/index');
            $this->load->view('interface_assets/footer');
        }

        // edit an external plugin //
        public function edit() {
            $this->load->library('form_validation');
            
            $data['page_title'] = $this->lang->line('pluginsext_title_page');
            $data['pluginsext_id'] = $this->uri->segment(3);
            $pluginsext_q = $this->pluginsext_model->get_by_id($data['pluginsext_id']);
            $data['pluginsext_data'] = $pluginsext_q->row();
            // Verif if plugin can be editable //
            if ($data['pluginsext_data']->pluginsext_allow != 1) {
                if (isset($data['pluginsext_data']->pluginsext_name)) {
                    $this->session->set_flashdata('message', $data['pluginsext_data']->pluginsext_name.' : this external pluginsext can not be edited, because is not enable.');
                } else {
                    $this->session->set_flashdata('message', 'External plugin not exist.');
                }
                redirect('pluginsext');               
            }

            $pluginsext_q = $this->pluginsext_model->get_params_user_by_id($data['pluginsext_id'], $this->session->userdata('user_id'));

            if (isset($pluginsext_q->row()->pluginsext_user_allow)) {
                $data['pluginsext_data']->pluginsext_user_allow = $pluginsext_q->row()->pluginsext_user_allow;
                $data['pluginsext_data']->pluginsext_params = $pluginsext_q->row()->pluginsext_params;
            } else {
                $data['pluginsext_data']->pluginsext_user_allow = 0;
                $data['pluginsext_data']->pluginsext_params = '{}';
            }
            $class_name = $data['pluginsext_data']->pluginsext_name;
            
            $data['pluginsext_params'] = json_decode($data['pluginsext_data']->pluginsext_params);
            $data['pluginsext_info'] = json_decode($data['pluginsext_data']->pluginsext_info);
            
            $data['title_edit'] = $this->lang->line('pluginsext_edit').' : '.$data['pluginsext_data']->pluginsext_name;
            $data['pluginsext_path'] = APPPATH.$this->config->item('pluginsext_path').'/'.$data['pluginsext_data']->pluginsext_name;
            $data['pluginsext_error_filenotfound'] =  $this->lang->line('pluginsext_error_filenotfound').' :  /views/cl_pluginsext_edit.php !';
            $data['cancel_confirm_txt'] = str_replace("'","\'",$this->lang->line('pluginsext_cancel_confirm_txt'));
            
            $this->form_validation->set_rules('pluginsext_user_allow', 'Allow', 'required');
            
            if ($this->form_validation->run() == FALSE)
            {
                // load plugin class //
                if (file_exists($data['pluginsext_path'].'/controllers/'.ucfirst($class_name).'.php')) { 
                    // load extands of plugin class //
                    require_once(APPPATH.'controllers/Pluginsext_extands.php'); 
                    require_once($data['pluginsext_path'].'/controllers/'.ucfirst($class_name).'.php');  
                }
                // load method for specific information //
                if (method_exists(ucfirst($class_name), 'cl_pluginsext_edit')) {
                    $CPLUGINSEXT = new $class_name($this);
                    $data = $CPLUGINSEXT->cl_pluginsext_edit($data);
                }
                // load specifiqe lang //
                $this->lang->load($class_name,'',FALSE,TRUE, $data['pluginsext_path'].'/');
        	$this->load->view('interface_assets/header', $data);
                $this->load->view('pluginsext/edit');
                $this->load->view('interface_assets/footer');
            }
            else
            {
                unset($data);
                $this->pluginsext_model->save_params_user($this->input->post(), $this->session->userdata('user_id'));
                $this->session->set_flashdata('success', $class_name.' : this external plugin was updated.');
                redirect('pluginsext');
            }
        }


        // menu(): Execute plugin from menu //
        public function menu() {
            $this->load->model('user_model');
            if(!$this->user_model->authorize(99)) { $this->session->set_flashdata('notice', 'You\'re not allowed to do that!'); redirect('dashboard'); }
            
            $data['pluginsext_id'] = $this->uri->segment(3);
            $pluginsext_q = $this->pluginsext_model->get_by_id($data['pluginsext_id']);
            $data['pluginsext_data'] = $pluginsext_q->row();
            // Verif if plugin can be editable //
            $allow = false;
            if ($data['pluginsext_data']->pluginsext_allow == 1) {
                $pluginsext_q = $this->pluginsext_model->get_params_user_by_id($data['pluginsext_id'], $this->session->userdata('user_id'));
                if (isset($pluginsext_q->row()->pluginsext_user_allow)) {
                    $allow = true;
                }
            }
            if ($allow) {
                $data['title_menu'] = $data['pluginsext_data']->pluginsext_name;
                $data['pluginsext_path'] = APPPATH.$this->config->item('pluginsext_path').'/'.$data['pluginsext_data']->pluginsext_name;
                $data['pluginsext_error_filenotfound'] =  $this->lang->line('pluginsext_error_filenotfound').' :  /views/cl_pluginsext_menu.php !';
                $data['pluginsext_data']->pluginsext_params = $pluginsext_q->row()->pluginsext_params;

                $pluginsext_q = $this->pluginsext_model->get_params_user_by_id($data['pluginsext_id'], $this->session->userdata('user_id'));
                $class_name = $data['pluginsext_data']->pluginsext_name;
                
               // load plugin class //
                if (file_exists($data['pluginsext_path'].'/controllers/'.ucfirst($class_name).'.php')) { 
                    // load extands of plugin class //
                    require_once(APPPATH.'controllers/Pluginsext_extands.php'); 
                    require_once($data['pluginsext_path'].'/controllers/'.ucfirst($class_name).'.php');  
                }
                // load method for specific information //
                if (method_exists(ucfirst($class_name), 'cl_pluginsext_menu')) {
                    $CPLUGINSEXT = new $class_name($this);
                    $data = $CPLUGINSEXT->cl_pluginsext_menu($data);
                }
            } else {
                $data['title_menu'] = 'ERROR';
                $data['pluginsext_path'] = '';
                $data['pluginsext_error_filenotfound'] =  'No external plugin found';
            }
            
            $this->load->view('interface_assets/header', $data);
            $this->load->view('pluginsext/menu');
            $this->load->view('interface_assets/footer');
        }


        // ex(): Execute plugin //
        // argument : 
        //      segment(3) : user id //
        //      segment(4) : name of plugin, obligatory //
        //      segment(5) : name of methode, obligatory (index is not a default) //
        //      segment(6 > 8) : 3 arguments for the methode , optionnal //
        public function ex() {
            $this->load->model('user_model');
            
            $user_id = $this->uri->segment(3);
            $class_name = $this->uri->segment(4);
            $method = $this->uri->segment(5);
            $args = array('arg1'=>$this->uri->segment(6), 'arg2'=>$this->uri->segment(7), 'arg3'=>$this->uri->segment(8));
            
            // test class/plugin exist //
            $pluginsext_q = $this->pluginsext_model->get_by_name($class_name);
            if ($pluginsext_q->num_rows() == 0) {
                echo "<b>Error : External plugin name (".$class_name.") not exist !<br/><br/></b>";
                show_404();
            }
            // test plugin can be use //
            $pluginsext_config = json_decode($pluginsext_q->row()->pluginsext_config);
            if (($pluginsext_q->row()->pluginsext_allow != 1) || ($pluginsext_config->is_public_plugins != 1)) {
                echo "<b>Error : External plugin (".$class_name.") not enable !<br/><br/></b>";
                show_404();
            }
            
            // load plugin class //
            $pluginsext_path = APPPATH.$this->config->item('pluginsext_path').'/'.$class_name;
            if (file_exists($pluginsext_path.'/controllers/'.ucfirst($class_name).'.php')) { 
                // load extands of plugin class //
                require_once(APPPATH.'controllers/Pluginsext_extands.php');  
                require_once($pluginsext_path.'/controllers/'.ucfirst($class_name).'.php');    
                               
                // test if this plugin is actived for this user //
                $pluginsext_user = $this->pluginsext_model->get_params_user_by_id($pluginsext_q->row()->pluginsext_id, $user_id);
                if ($pluginsext_user->num_rows() == 0) {
                    echo "<b>Error : External plugin is not active !<br/><br/></b>";
                    show_404();
                }
                if ($pluginsext_user->row()->pluginsext_user_allow != 1) {
                    echo "<b>Error : External plugin is not active !<br/><br/></b>";
                    show_404();
                } 
                // load method for specific information //
                if (!method_exists(ucfirst($class_name), $method)) {
                    echo "<b>Error : External plugin mehtod (".$class_name.":".$method.") not exist !<br/><br/></b>";
                    show_404();
                }
                $pluginsext_user->row()->pluginsext_params = json_decode($pluginsext_user->row()->pluginsext_params);
                $CPLUGINSEXT = new $class_name($this, $pluginsext_user->row(), $args, $user_id);
                $CPLUGINSEXT->$method();
                
            } else {
                echo "<b>Error : External plugin file (".$class_name.") not exist !<br/><br/></b>";
                show_404();
            }
        }

        // Check folder : new or update //
 	public function check_new_update_pluginsext() {
            $list_pluginsext_folder = $this->get_pluginsext_folder_list();
            foreach($list_pluginsext_folder as $pluginsext_name) {
                $pluginsext_q = $this->pluginsext_model->get_by_name($pluginsext_name);
                // get Json info file //
                $pluginsext_info_json = '{}';
                $pluginsext_config_json = '{}';
                if (file_exists(APPPATH.$this->config->item('pluginsext_path').'/'.$pluginsext_name.'/config/'.$pluginsext_name.'.json')) {
                    $pluginsext_info_json = file_get_contents(APPPATH.$this->config->item('pluginsext_path').'/'.$pluginsext_name.'/config/'.$pluginsext_name.'.json');
                    if (!empty($pluginsext_info_json)) { $pluginsext_info_json = json_decode($pluginsext_info_json); }
                    if (isset($pluginsext_info_json->config)) {
                        $pluginsext_config_json = $pluginsext_info_json->config;
                        unset($pluginsext_info_json->config);
                    }
                }
                $doSave = false;
                $fileds = array('pluginsext_id'=>0, 'pluginsext_name'=>$pluginsext_name, 'pluginsext_allow'=>1, 'pluginsext_migration'=>0, 'pluginsext_info'=>json_encode($pluginsext_info_json), 'pluginsext_config'=>json_encode($pluginsext_config_json));
                if ($pluginsext_q->num_rows() == 1) {
                    $fileds['pluginsext_id'] = $pluginsext_q->row()->pluginsext_id;
                    $fileds['pluginsext_allow'] = $pluginsext_q->row()->pluginsext_allow;
                    $pluginsext_row_info = json_decode($pluginsext_q->row()->pluginsext_info);

                    if (($pluginsext_q->row()->pluginsext_config != json_encode($pluginsext_config_json)) || ($pluginsext_row_info != json_encode($pluginsext_info_json))) {
                    //($pluginsext_info_json->source != $pluginsext_row_info->source) || ($pluginsext_info_json->version != $pluginsext_row_info->version) || ($pluginsext_info_json->migration != $pluginsext_row_info->migration) || ($pluginsext_info_json->description != $pluginsext_row_info->description)) {
                        $doSave = true;
                    }
                    // DO MIGRATION //
                    /*if ($pluginsext_info_json->migration != $pluginsext_row_info->migration) {
                        $migration = array('migration_enabled' => 1, 'migration_version'=>$pluginsext_info_json->migration, 'migration_path'=>APPPATH.$this->config->item('pluginsext_path').'/'.$pluginsext_name.'/migrations/' ); 
                        // TODO //
                        //$this->load->library('Migration', $migration);
                        //$this->migration->find_migrations();
                    }*/
                } else { $doSave = true; }
                if ($doSave) { $this->pluginsext_model->save($fileds); }
            }
        }
        
        // Get folder plugin list //
 	public function get_pluginsext_folder_list() {
            $list_folder_pluginsext = array();
            if (APPPATH != APPPATH.$this->config->item('pluginsext_path')) {
                if (is_dir(APPPATH.$this->config->item('pluginsext_path'))) {
                    $list_folder_pluginsext = array_diff(scandir(APPPATH.$this->config->item('pluginsext_path')), array('..', '.','.DS_Store'));
                    sort($list_folder_pluginsext);
                    for ($i=0; $i<count($list_folder_pluginsext); $i++) { 
                        if (!ctype_alnum($list_folder_pluginsext[$i])) { unset($list_folder_pluginsext[$i]); }
                    }
                    sort($list_folder_pluginsext);
                }
            }
            return $list_folder_pluginsext;
        }
        
        // return url of ex() methode //
        public function get_url_ex($pluginsext_name, $method) {
            return "index.php/pluginsext/ex/".$this->session->userdata('user_id')."/".$pluginsext_name."/".$method;
        }

}
