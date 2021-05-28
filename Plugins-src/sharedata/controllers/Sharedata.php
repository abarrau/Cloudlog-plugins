<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sharedata extends Pluginsext_extands { 

        //
        public function index() {
            echo "USE CORRECT METHODE";
        }
        
        public function cl_pluginsext_edit($_data) {
            $_data['sharedata_url2use'] = $this->_CLContext->get_url_ex('sharedata','lastqso');
            $_data['sharedata_url2use_onair'] = $this->_CLContext->get_url_ex('sharedata','onair');
            return $_data; 
        } 
        
        public function lastqso() {
            $this->_CLContext->load->model('logbook_model');
            $this->_CLContext->load->model('user_model');
            $this->_CLContext->lang->load('general_words','english');        
            $data['last_qsos'] = isset($this->_pluginsext_user->pluginsext_params->nb_last_qso)?$this->_CLContext->logbook_model->get_last_qsos($this->_pluginsext_user->pluginsext_params->nb_last_qso)->result():array();
            $data['show_time'] = isset($this->_pluginsext_user->pluginsext_params->show_time)?$this->_pluginsext_user->pluginsext_params->show_time:0;
            $data['show_country'] = isset($this->_pluginsext_user->pluginsext_params->show_country)?$this->_pluginsext_user->pluginsext_params->show_country:0;
            $user = $this->_CLContext->user_model->get_by_id($this->_user_id)->row();
            $data['page_title'] = "Last QSO for ".$user->user_callsign;
            $this->_CLContext->load->view('interface_assets/mini_header', $data);
            $this->_CLContext->load->add_package_path(APPPATH.$this->_CLContext->config->item('pluginsext_path').'/sharedata/');
            $this->_CLContext->load->view('sharedata/lastqso');
            //$this->_CLContext->load->view('interface_assets/footer');
	}
        
        public function onair() {
            $state_json = json_decode($this->get_onair(false),true);
            
            $data['onair_state'] = $state_json['onair_state'];
            $data['onair_txt'] = ($state_json['onair_state']==1)?'ON AIR'.(($state_json['onair_band']!='')?' ('.$state_json['onair_band'].')':''):'not active';
            $data['onair_icon'] = $state_json['onair_icon'];
            $this->_CLContext->load->view('interface_assets/mini_header', $data);
            $this->_CLContext->load->add_package_path(APPPATH.$this->_CLContext->config->item('pluginsext_path').'/sharedata/');
            $this->_CLContext->load->view('sharedata/onair');
            //$this->_CLContext->load->view('interface_assets/footer');
        }

        
        public function set_onair($returnecho=true) {
            $onair_state = str_replace('"', "", $this->_CLContext->input->post("onair_state"));
            $value_json = json_decode($this->_pluginsext_user->pluginsext_values, true);
            $value_json['onair_date'] = ($onair_state==1)?date('U'):'';
            $this->_CLContext->pluginsext_model->set_value($this->_pluginsext_user->pluginsext_id, $this->_CLContext->session->userdata('user_id'), $value_json);
            if ($onair_state==1) {
                $onair_icon = $this->_pluginsext_user->pluginsext_params->onair_showon;
            } else {
                $onair_icon = $this->_pluginsext_user->pluginsext_params->onair_showoff;
            }
            $return = json_encode(array('message'=>'OK','onair_state'=>$onair_state, 'onair_icon'=>'fa-'.$onair_icon));
            if ($returnecho) echo $return; else return $return;
        }

        public function get_onair($returnecho=true) {
            $this->_CLContext->load->model('logbook_model');
            $onair_state = 0;
            $onair_band = '';
            $value_json = json_decode($this->_pluginsext_user->pluginsext_values, true);
            $data['last_qso'] = $this->_CLContext->logbook_model->get_last_qsos(1)->result();
            if (count($data['last_qso'])>0) {
                $onair_dateref = 0;
                if ($value_json['onair_date'] > strtotime($data['last_qso'][0]->COL_TIME_ON)) {
                    $onair_dateref = $value_json['onair_date'];
                    $onair_band = '';
                } else {
                    $onair_dateref = strtotime($data['last_qso'][0]->COL_TIME_ON);
                    $onair_band = ($data['last_qso'][0]->COL_SAT_NAME!='')?$data['last_qso'][0]->COL_SAT_NAME:$data['last_qso'][0]->COL_BAND;
                }
                if (($onair_dateref+($this->_pluginsext_user->pluginsext_params->onair_timeout*60)) >= date('U')) {
                    $value_json['onair_date'] = $onair_dateref;
                    $onair_state = 1;
                } else {
                    $value_json['onair_date'] = '';
                    $onair_band = '';
                    $onair_dateref = 0;
                }  
                $this->_CLContext->pluginsext_model->set_value($this->_pluginsext_user->pluginsext_id, $this->_user_id, $value_json);
            }
            if ($onair_state==1) {
                $onair_icon = $this->_pluginsext_user->pluginsext_params->onair_showon;
            } else {
                $onair_icon = $this->_pluginsext_user->pluginsext_params->onair_showoff;
            }
            if ($this->_pluginsext_user->pluginsext_params->onair_show_band != 1) $onair_band = '';
            $return = json_encode(array('message'=>'OK','onair_state'=>$onair_state,'onair_band'=>$onair_band, 'onair_icon'=>'fa-'.$onair_icon));
            if ($returnecho) echo $return; else return $return;            
        }
	
}
