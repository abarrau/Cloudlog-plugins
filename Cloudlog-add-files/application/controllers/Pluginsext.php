<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pluginsext extends CI_Controller {

    // load construct // ['.get_called_class().']
	function __construct() {
        parent::__construct();
        $this->lang->load('pluginsext');
        $this->load->model('pluginsext_model');
        $this->load->model('user_model');
        log_message('debug','[Pluginsext] Load class');
    }
            
    // default methode : list plugins //
    public function index() {
        if($this->user_model->validate_session() == 0) { redirect('user/login'); }
        // check new plugin exist in folder //
        $this->check_new_update_pluginsext(true);
        log_message('debug','[Pluginsext] Load class');
        // set data //
        $list_pluginsext = $this->pluginsext_model->list_all();
        $list_pluginsext_for_user = $this->pluginsext_model->list_for_user($this->session->userdata('user_id'));
        $data['list_pluginsext'] = $this->pluginsext_model->list_merge_data($list_pluginsext, $list_pluginsext_for_user);
        $data['page_title'] = $this->lang->line('pluginsext_title_page');
        // load view //
        $this->load->view('interface_assets/header', $data);
        $this->load->view('pluginsext/index');
        $this->load->view('interface_assets/footer');
    }

    // edit an external plugin //
    // argument : 
    //      segment(3) : methode //
    public function edit() {
        if($this->user_model->validate_session() == 0) { redirect('user/login'); }
        // UPDATE FORMULAIRE //
        $_post = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pluginsext_user_allow', 'Allow', 'required');
        if ($this->form_validation->run() !== FALSE) {
            $this->pluginsext_model->save_params_user($_post, $this->session->userdata('user_id'));
            $this->session->set_flashdata('success', $_post['pluginsext_name'].' ('.$_post['pluginsext_id'].'): this external plugin was updated.');
            log_message('debug','[Pluginsext]['.$_post['pluginsext_name'].'] edit(): this external plugin was updated.');
            redirect('pluginsext');
        }

        // LOAD FORMULAIRE //
        $data['pluginsext_id'] = $this->uri->segment(3);
        // verif if plugin can used & get info plugin for user //
        $data = $this->cheack_is_allow($data);
        if ($data['_msg_error']['s'] == 'ne') { 
            $this->session->set_flashdata('message', $data['_msg_error']['t']);
            log_message('debug','[Pluginsext]['.$data["pluginsext_row"]->pluginsext_nameid.'] edit(): ne/'.$data['_msg_error']['t']);
            redirect('pluginsext');
        }
        if ($data['_msg_error']['s'] == 'na') { 
            log_message('debug','[Pluginsext]['.$data["pluginsext_row"]->pluginsext_nameid.'] edit(): na/'.$data['_msg_error']['t']);
            $this->session->set_flashdata('message', $data['_msg_error']['t']); 
        }

        // Set data //
        $data['page_title'] = $this->lang->line('pluginsext_title_page');
        $data['title_edit'] = $this->lang->line('pluginsext_title_edit').' : '.$data['pluginsext_row']->pluginsext_name.' ('.$data['pluginsext_row']->pluginsext_nameid.')';
        $data['pluginsext_path'] = APPPATH.$this->config->item('pluginsext_path').'/'.$data['pluginsext_row']->pluginsext_nameid; 
        $data['pluginsext_error_filenotfound'] =  $this->lang->line('pluginsext_error_filenotfound').' :  /views/cl_pluginsext_edit.php !';
        $data['cancel_confirm_txt'] = str_replace("'","\'",$this->lang->line('pluginsext_cancel_confirm_txt'));
        // load plugin class //
        $this->load_pluginext_class($data['pluginsext_row']->pluginsext_nameid);
        $_pe_class = ucfirst($data['pluginsext_row']->pluginsext_nameid);
        if (method_exists($this->$_pe_class, 'cl_pluginsext_edit')) {
            log_message('debug','[Pluginsext]['.$data["pluginsext_row"]->pluginsext_nameid.'] Load cl_pluginsext_edit with data='.print_r($data,true));
            $data = $this->$_pe_class->cl_pluginsext_edit($data);
        }
        // load view //
        $this->load->view('interface_assets/header', $data);
        $this->load->view('pluginsext/edit');
        $this->load->view('interface_assets/footer');
    }

    // menu(): Execute plugin from menu //
    // argument : 
    //      segment(3) : nameid of plugin, obligatory //
    //      segment(4) : methode //
    //      segment(5 > 7) : 3 arguments for the methode , optionnal //
    public function menu() {
        if($this->user_model->validate_session() == 0) { redirect('user/login'); }
        // get arguments //
        $data['pluginsext_nameid'] = $this->uri->segment(3);
        $data['methode_name'] = $this->uri->segment(4);
        $data['methode_args'] = array('arg1'=>$this->uri->segment(5), 'arg2'=>$this->uri->segment(6), 'arg3'=>$this->uri->segment(7));
        
        // verif if plugin can used & get info plugin for user //
        $data = $this->cheack_is_allow($data);
        if ($data['_msg_error']['s'] == 'ne') { 
            $this->session->set_flashdata('message', $data['_msg_error']['t']);
            log_message('debug','[Pluginsext]['.$data['pluginsext_nameid'].'] menu(): Load cl_pluginsext_edit');
            redirect('pluginsext');
        }
        if ($data['_msg_error']['s'] != 'ok') {
            $this->session->set_flashdata('message', $data['_msg_error']['t']);
            $data['title_menu'] = 'ERROR';
            $data['pluginsext_path'] = '';
        }

        if (!isset($data['pluginsext_path'])) $data['pluginsext_path'] = APPPATH.$this->config->item('pluginsext_path').'/'.$data['pluginsext_row']->pluginsext_nameid; 
        $data['page_title'] = $this->lang->line('pluginsext_title_page')." / ".$data['pluginsext_row']->pluginsext_name;
        $data['title_menu'] = $data['pluginsext_row']->pluginsext_name;

        // load plugin class & call method //
        if (empty($data['methode_name'])) $data['methode_name'] = "cl_pluginsext_menu";
		$this->load_pluginext_class($data['pluginsext_row']->pluginsext_nameid);
        $_pe_class = ucfirst($data['pluginsext_row']->pluginsext_nameid);
        $data['pluginsext_url2menu'] = $this->$_pe_class->get_url_menu($data['pluginsext_nameid']);
        if (method_exists($this->$_pe_class, $data['methode_name'])) {
            $_m = $data['methode_name'];
			$data = $this->$_pe_class->$_m($data);
        }
        // load view //
        $this->load->view('interface_assets/header', $data);
        $this->load->view('pluginsext/menu');
        $this->load->view('interface_assets/footer');
    }

    // ws(): Execute plugin from ws/ajax request //
    // argument : 
    //      segment(3) : nameid of plugin, obligatory //
    //      segment(4) : methode //
    //      segment(5 > 7) : 3 arguments for the methode , optionnal //
    public function ws() {
        if($this->user_model->validate_session() == 0) { 
            header('Content-Type: application/json');
            log_message('warning','[Pluginsext][WS]['.$this->uri->segment(3).']['.$this->uri->segment(4).'] ERROR: User not authentified !');
            echo json_encode(array('pe_stat'=>'KO','pe_msg'=>'ERROR: User not authentified !'));
            return false;
        }
        // get arguments //
        $data['pluginsext_nameid'] = $this->uri->segment(3);
        $data['methode_name'] = $this->uri->segment(4);
        $data['methode_args'] = array('arg1'=>$this->uri->segment(5), 'arg2'=>$this->uri->segment(6), 'arg3'=>$this->uri->segment(7));
        log_message('debug','[Pluginsext][WS]['.$data['pluginsext_nameid'].']['.$data['methode_name'].'] ws request with args='.print_r($data['methode_args'],true));

        // verif if plugin can used & get info plugin for user //
        $data = $this->cheack_is_allow($data);
        if (($data['_msg_error']['s'] == 'ok') && (!empty($data['methode_name']))) {
            $data['pluginsext_path'] = APPPATH.$this->config->item('pluginsext_path').'/'.$data['pluginsext_row']->pluginsext_nameid;
            // load plugin class & call method //
            $this->load_pluginext_class($data['pluginsext_row']->pluginsext_nameid);
            $_pe_class = ucfirst($data['pluginsext_row']->pluginsext_nameid);
            if (method_exists($this->$_pe_class, $data['methode_name'])) {
                $_m = $data['methode_name'];
                $data = $this->$_pe_class->$_m($data);
                if (!isset($data['pe_json_return']['pe_stat'])) { $data['pe_json_return']['pe_stat'] = 'OK'; }
                header('Content-Type: application/json');
                echo json_encode($data['pe_json_return']);
                return true;          
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array('pe_stat'=>'KO','pe_msg'=>'ERROR: this method not allowed or not found : '.$data['methode_name']));
        return false;
    }

    // ex(): Execute plugin //
    // argument : 
    //      segment(3) : username (associate of user id)) //
    //      segment(4) : name of plugin, obligatory //
    //      segment(5) : name of methode, obligatory (index is not a default) //
    //      segment(6 > 8) : 3 arguments for the methode , optionnal //
    public function ex() {
        // get arguments //
        $data['_username'] = $this->uri->segment(3);
        $data['pluginsext_nameid'] = $this->uri->segment(4);
        $data['methode_name'] = $this->uri->segment(5);
        $data['methode_args'] = array('arg1'=>$this->uri->segment(6), 'arg2'=>$this->uri->segment(7), 'arg3'=>$this->uri->segment(8));
        log_message('debug','[Pluginsext][EX]['.$data['pluginsext_nameid'].']['.$data['methode_name'].'] external request with args='.print_r($data['methode_args'],true));

        // verif username exist //
        $data['_oUser'] = $this->user_model->get($data['_username'])->row();
        if (!is_object($data['_oUser'])) {
            echo "<b>Error : Username (".$data['_username'].") not exist !<br/><br/></b>";
            show_404();
        }
        // verif if plugin can used & get info plugin for user //
        $data = $this->cheack_is_allow($data);
        if ($data['_msg_error']['s'] != 'ok') { 
            echo "<b>Error : External plugin (".$data['pluginsext_nameid'].") : ".$data['_msg_error']['t']." !<br/><br/></b>";
            show_404();
        }
        $data['page_title'] = $this->lang->line('pluginsext_title_page')." / ".$data['pluginsext_row']->pluginsext_name;
        // load plugin class & call method //
        $this->load_pluginext_class($data['pluginsext_row']->pluginsext_nameid);
        $_pe_class = ucfirst($data['pluginsext_row']->pluginsext_nameid);
        if (method_exists($this->$_pe_class, $data['methode_name'])) {
            $_m = $data['methode_name'];
            $data = $this->$_pe_class->$_m($data);
        } else {
            echo "<b>Error : External plugin (".$data['pluginsext_nameid'].") : method not exist !<br/><br/></b>";
            show_404();            
        }
    }

    // Check folder : new or update //
 	public function check_new_update_pluginsext() {
        $list_pluginsext_folder = $this->get_pluginsext_folder_list();
        foreach($list_pluginsext_folder as $pluginsext_nameid) {
            $pluginsext_q = $this->pluginsext_model->get_by_nameid($pluginsext_nameid);
            // get Json info file //
            $pluginsext_info_json = '{}';
            $pluginsext_config_json = '{}';
            $pluginsext_name = $pluginsext_nameid;
            if (file_exists(APPPATH.$this->config->item('pluginsext_path').'/'.$pluginsext_nameid.'/config/'.$pluginsext_nameid.'.json')) {
                $pluginsext_info_json = file_get_contents(APPPATH.$this->config->item('pluginsext_path').'/'.$pluginsext_nameid.'/config/'.$pluginsext_nameid.'.json');
                if (!empty($pluginsext_info_json)) { $pluginsext_info_json = json_decode($pluginsext_info_json); }
                if (isset($pluginsext_info_json->config)) {
                    $pluginsext_config_json = $pluginsext_info_json->config;
                    unset($pluginsext_info_json->config);
                }
                if (isset($pluginsext_info_json->name)) { $pluginsext_name = $pluginsext_info_json->name; }
            }
            $doSave = false;
            $fileds = array('pluginsext_id'=>0, 'pluginsext_nameid'=>$pluginsext_nameid, 'pluginsext_name'=>$pluginsext_name, 'pluginsext_allow'=>1, 'pluginsext_migration'=>0, 'pluginsext_info'=>json_encode($pluginsext_info_json), 'pluginsext_config'=>json_encode($pluginsext_config_json));
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
            } else { $doSave = true; } // why true ?
            if ($doSave) { $this->pluginsext_model->save($fileds); }
        }
    }
        
    // Get folder plugin list //
 	public function get_pluginsext_folder_list() {
        $list_folder_pluginsext = array();
        if (APPPATH != APPPATH.$this->config->item('pluginsext_path')) {
            if (is_dir(APPPATH.$this->config->item('pluginsext_path'))) {
                $list_folder_pluginsext = array_diff(scandir(APPPATH.$this->config->item('pluginsext_path')), array('..', '.','.DS_Store','@eaDir'));
                sort($list_folder_pluginsext);
                for ($i=0; $i<count($list_folder_pluginsext); $i++) { 
                    if (!ctype_alnum($list_folder_pluginsext[$i])) { unset($list_folder_pluginsext[$i]); }
                }
                sort($list_folder_pluginsext);
            } else log_message('error','[Pluginsext] pluginsext_path ('.APPPATH.$this->config->item('pluginsext_path').') not a directory.');
        } else log_message('error','[Pluginsext] pluginsext_path not configured in config.php file.');
        log_message('error','[Pluginsext] Folder found : '.count($list_folder_pluginsext).', in '.APPPATH.$this->config->item('pluginsext_path'));
        return $list_folder_pluginsext;
    }
    
    // load pluginext class //
    private function load_pluginext_class($_class) {
        $this->load->file(APPPATH.'controllers/Pluginsext_extands.php');
        $_cn = ucfirst($_class);
        $this->$_cn =& load_class($_cn, $this->config->item('pluginsext_path').'/'.$_class.'/controllers');
        // load specifiqe lang //
        $this->lang->load($_class,'',FALSE,TRUE, APPPATH.$this->config->item('pluginsext_path').'/'.$_class.'/');
        log_message('error','[Pluginsext] Class "'.$_cn.'" loaded.');
        return $this;
    }

    // verif pluginext allow for user //
    private function cheack_is_allow($_data, $external=false) {
        $_msg_notexist = "External plugin not exist";
        $_msg_notactiv = "External plugin is not active";
        $_data['_msg_error'] = array('s'=>'ok','t'=>'');
        // verif is plugin exist //
        if (isset($_data['pluginsext_nameid']) && (!empty($_data['pluginsext_nameid']))) {
            $pluginsext_q = $this->pluginsext_model->get_by_nameid($_data['pluginsext_nameid']);
            log_message('debug','[Pluginsext] cheack_is_allow().pluginsext_nameid='.$_data['pluginsext_nameid']);
        } else if (isset($_data['pluginsext_id']) && ($_data['pluginsext_id']>0)) {
            $pluginsext_q = $this->pluginsext_model->get_by_id($_data['pluginsext_id']);
            log_message('debug','[Pluginsext] cheack_is_allow().pluginsext_id='.$_data['pluginsext_id']);
        } else {
            $_data['_msg_error'] = array('s'=>'ne', 't'=>$_msg_notexist.' (id error)');
            log_message('debug','[Pluginsext] cheack_is_allow().msg=ne/'.$_msg_notexist.' (id error)');
            return $_data;            
        } 
        // get info et verif is plugin exist //
        $_data['pluginsext_row'] = $pluginsext_q->row();
		if ((!is_object($_data['pluginsext_row'])) || (!isset($_data['pluginsext_row']->pluginsext_nameid))) {
			$_data['_msg_error'] = array('s'=>'ne', 't'=>$_msg_notexist.' (not object)');
            log_message('debug','[Pluginsext] cheack_is_allow().msg=ne/'.$_msg_notexist.' (not object)');
			return $_data;
		}
        $_data['pluginsext_id'] = $_data['pluginsext_row']->pluginsext_id;
        // verif plugin allow on cloudlog //
        log_message('debug','[Pluginsext] cheack_is_allow()._data["pluginsext_row"]->pluginsext_allow='.$_data['pluginsext_row']->pluginsext_allow);
        if ($_data['pluginsext_row']->pluginsext_allow != 1) {
			$_data['pluginsext_row']->pluginsext_user_allow = 0;
			$_data['pluginsext_row']->pluginsext_params = json_decode('{}');
            $_data['pluginsext_row']->pluginsext_info = json_decode($_data['pluginsext_row']->pluginsext_info);
            $_data['pluginsext_row']->pluginsext_config = json_decode($_data['pluginsext_row']->pluginsext_config);
			$_data['_msg_error'] = array('s'=>'ne', 't'=>$_msg_notexist.' (not allowed)');
            log_message('debug','[Pluginsext] cheack_is_allow().msg=ne/'.$_msg_notexist.' (not allowed)');
			return $_data;
        }
        // if allow, get param of this plugin for current user //
		$_userid = ((isset($_data['_oUser']))&&($_data['_oUser']->user_id>0))?$_data['_oUser']->user_id:$this->session->userdata('user_id');
        log_message('debug','[Pluginsext] cheack_is_allow()._userid='.$_userid);
		$pluginsext_q = $this->pluginsext_model->get_params_user_by_id($_data['pluginsext_id'], $_userid);

		// Verif if user is allow //
		if (isset($pluginsext_q->row()->pluginsext_user_allow)) {
            log_message('debug','[Pluginsext] cheack_is_allow().pluginsext_user_allow is exit ('.$pluginsext_q->row()->pluginsext_user_allow.')');
			$_data['pluginsext_row']->pluginsext_user_allow = $pluginsext_q->row()->pluginsext_user_allow;
			$_data['pluginsext_row']->pluginsext_params = json_decode($pluginsext_q->row()->pluginsext_params);
            $_data['pluginsext_row']->pluginsext_values = json_decode($pluginsext_q->row()->pluginsext_values);
			$_data['pluginsext_row']->pluginsext_info = json_decode($_data['pluginsext_row']->pluginsext_info);
            $_data['pluginsext_row']->pluginsext_config = json_decode($_data['pluginsext_row']->pluginsext_config);
		} else {
            log_message('debug','[Pluginsext] cheack_is_allow().pluginsext_user_allow NOT exit /!\\');
			$_data['pluginsext_row']->pluginsext_user_allow = 0;
			$_data['pluginsext_row']->pluginsext_params = json_decode('{}');
            $_data['pluginsext_row']->pluginsext_info = json_decode($_data['pluginsext_row']->pluginsext_info);
            $_data['pluginsext_row']->pluginsext_config = json_decode($_data['pluginsext_row']->pluginsext_config);
			$_data['_msg_error'] = array('s'=>'ne', 't'=>$_msg_notexist);
		}
        if ($_data['pluginsext_row']->pluginsext_user_allow != 1) { $_data['_msg_error'] = array('s'=>'na', 't'=>$_msg_notactiv); }
		return $_data;
    }

    // Check installation //
    public function check_install() {
        $_files = array(
            'controllers/Pluginsext.php',
            'controllers/Pluginsext_extands.php',
            'language/english/pluginsext_lang.php',
            'language/french/pluginsext_lang.php',
            'models/Pluginsext_model.php',
            'views/pluginsext/footer.php',
            'views/pluginsext/edit.php',
            'views/pluginsext/index.php',
            'views/pluginsext/menu.php'
        );
        $_config = array('pluginsext_allow','pluginsext_path');
        $_tablebdd = array('pluginsext','pluginsext_plugindata','pluginsext_users');

        if($this->user_model->validate_session() == 0) { redirect('user/login'); }
        echo "<b>[PLUGINEXT] CHECK INSTALL</b><br/>";
        
        echo "<br/><u>*** Verif files :</u><br/>";
        foreach($_files as $f) { echo "<span style=\"padding-left:15px;\">-- ".APPPATH.$f." : ".((file_exists(APPPATH.$f))?"<span style='color:#3BBB3B;'>OK</span>":"<span style='font-weight:bold;color:#EE0000;'>NOT EXIST</span>, get if from github."); echo "</span><br/>"; }

        echo "<br/><u>*** Verif external folder config :</u><br/>";
        $_folderconfig=false;
        foreach($_config as $c) {
            echo "<span style=\"padding-left:15px;\">-- config item \"".$c."\" : ";
            $_tmp = $this->config->item($c);
            if (isset($_tmp)) { echo "<span style='color:#3BBB3B;'>OK</span> (".(($_tmp===false)?"false":$_tmp).")"; if($c=="pluginsext_path") { $_folderconfig=true; } } 
                else { echo "<span style='font-weight:bold;color:#EE0000;'>NOT EXIST</span>, check doc for create it !"; }
            echo "</span><br/>";
        }

        if($_folderconfig) {
            echo "<br/><u>*** Verif external folder exist :</u><br/>";
            echo "<span style=\"padding-left:15px;\">-- folder \"".APPPATH.$this->config->item('pluginsext_path')."\" : </span>";
            if (is_dir(APPPATH.$this->config->item('pluginsext_path'))) { 
                echo "<span style='color:#3BBB3B;'>OK</span> <br/>"; 
                $_list_folder_pluginsext = array_diff(scandir(APPPATH.$this->config->item('pluginsext_path')), array('..', '.','.DS_Store','@eaDir'));
                sort($_list_folder_pluginsext);
                echo "<span style=\"padding-left:15px;\">-- content folder : </span>";
                if (count($_list_folder_pluginsext)>0) {
                    foreach($_list_folder_pluginsext as $f) { echo "<br/><span style=\"padding-left:45px;\">* /".$f; }
                } else { echo "<b>is empty !</b>"; }
            } else { echo "<span style='font-weight:bold;color:#EE0000;'>NOT EXIST</span>, check doc for create folder ! </span>"; }
            echo "<br/>";
        }

        echo "<br/><u>*** Verif database :</u>";
        $_tmplist = $this->db->list_tables();
        foreach($_tablebdd as $t) {
            echo "<br/><span style=\"padding-left:15px;\">-- table \"".$t."\" : ";
            if (in_array($t, $_tmplist)) { 
                echo "<span style='color:#3BBB3B;'>OK</span>";
                foreach($this->db->list_fields($t) as $f) { echo "<br/><span style=\"padding-left:45px;\">* ".$f; }
            } else { echo "<span style='font-weight:bold;color:#EE0000;'>NOT EXIST</span>, check doc for create it !"; }
            echo "</span>";
        }
        echo "<br/>";

        $_footer = APPPATH."views/interface_assets/footer.php";
        echo "<br/><u>*** Verif change on file : \"".$_footer."\" :</u><br/>";
        $_add = "<?php require_once(APPPATH.'/views/pluginsext/footer.php'); ?>";
        $_footercontent = file_get_contents($_footer);
        echo "<span style=\"padding-left:15px;\">-- content search \"".htmlspecialchars($_add)."\" : ";
        if(($_pos=strpos($_footercontent, $_add)) !== false) { 
            echo "<span style='color:#3BBB3B;'>OK</span> (".$_pos.")<br/>";
            echo "<div style='margin-left:45px;padding:3px;font-style:italic;background-color:#DDDDDD;width:70%;font-size:85%;'>...".nl2br(htmlspecialchars(substr($_footercontent,($_pos-5))))."</div>";
        } else { echo "<span style='font-weight:bold;color:#EE0000;'>NOT EXIST</span>, check doc for add it in file just BEFORE : ".htmlspecialchars("</body></html>")." !"; }
        echo "<br/>";

        echo "<br/><b>[PLUGINEXT] CHECK INSTALL FINISH (".date('Y-m-d H:i').")</b><br/>";
    }

}
