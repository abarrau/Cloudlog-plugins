<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Sharedata extends Pluginsext_extands {

    public $_user_stylesheet_change = true;

    //
    public function cl_pluginsext_edit($_data) {
        $this->load->model('user_model');
        $_data['themes'] = $this->user_model->getThemes();
        $_data['sharedata_url2use'] = $this->get_url_ex('sharedata','lastqso');
        $_data['sharedata_url2use_onair'] = $this->get_url_ex('sharedata','onair');
        return $_data; 
    } 
    
    public function lastqso($_data) {
        $this->load->model('user_model');
        $this->lang->load('general_words','english');  
        $_data['pluginsext_row']->pluginsext_params->show_time = isset($_data['pluginsext_row']->pluginsext_params->show_time)?$_data['pluginsext_row']->pluginsext_params->show_time:0;
        $_data['pluginsext_row']->pluginsext_params->show_country = isset($_data['pluginsext_row']->pluginsext_params->show_country)?$_data['pluginsext_row']->pluginsext_params->show_country:0;
        $_data['pluginsext_row']->pluginsext_params->show_stationcall = isset($_data['pluginsext_row']->pluginsext_params->show_stationcall)?$_data['pluginsext_row']->pluginsext_params->show_stationcall:0;
        $_data['pluginsext_row']->pluginsext_params->show_mylocator = isset($_data['pluginsext_row']->pluginsext_params->show_mylocator)?$_data['pluginsext_row']->pluginsext_params->show_mylocator:0;
        $_data['pluginsext_row']->pluginsext_params->qso_theme = isset($_data['pluginsext_row']->pluginsext_params->qso_theme)?$_data['pluginsext_row']->pluginsext_params->qso_theme:'cosmo';
        $this->change_user_stylesheet($_data['pluginsext_row']->pluginsext_params->qso_theme);

        if (!isset($_data['_oUser'])) {
            $_data['_oUser'] = $this->user_model->get_by_id($this->session->userdata('user_id'))->row();
        }

        $filter_qso = null;
        if (isset($_data['methode_args']['arg1']) && isset($_data['methode_args']['arg2'])) {
        	switch($_data['methode_args']['arg1']) {
        		case "filterstation": 
        			if ($_data['pluginsext_row']->pluginsext_params->show_stationcall==2) $_data['pluginsext_row']->pluginsext_params->show_stationcall=0;
        			if ($_data['pluginsext_row']->pluginsext_params->show_mylocator==2) $_data['pluginsext_row']->pluginsext_params->show_mylocator=1;
        			$filter_qso = " (COL_STATION_CALLSIGN='".str_replace("-","/",$_data['methode_args']['arg2'])."') "; break;
        		case "filterlocation": $filter_qso = " (station_id='".$_data['methode_args']['arg2']."') "; break;  
        	}
        }
        $hide_contest_qso = true; // ALWAYS HIDE // isset($_data['pluginsext_row']->pluginsext_params->hide_contest_qso)?$_data['pluginsext_row']->pluginsext_params->hide_contest_qso:1;
        $hide_ft8 = isset($_data['pluginsext_row']->pluginsext_params->hide_ft8)?$_data['pluginsext_row']->pluginsext_params->hide_ft8:1;
        $_data['pluginsext_row']->list_qso = isset($_data['pluginsext_row']->pluginsext_params->nb_last_qso)?$this->model_lastqso($_data['_oUser'], $_data['pluginsext_row']->pluginsext_params->nb_last_qso,$filter_qso,$hide_contest_qso,$hide_ft8)->result():array();

        $_data['page_title'] = "Last QSO for ".$_data['_oUser']->user_callsign;
        $this->load->view('interface_assets/mini_header', $_data);
        $this->load->add_package_path(APPPATH.$this->config->item('pluginsext_path').'/sharedata/');
        $this->load->view('sharedata/lastqso');
        $this->change_user_stylesheet(false);
	}

    public function onair($_data) {
        $_onair_theme = isset($_data['pluginsext_row']->pluginsext_params->onair_theme)?$_data['pluginsext_row']->pluginsext_params->onair_theme:'cosmo';
        $this->change_user_stylesheet($_onair_theme);
        $_data = $this->get_onair($_data);
        $_data['pe_json_return']['onair_state_txt'] = ($_data['pe_json_return']['onair_state']==1)?'ON AIR'.(($_data['pe_json_return']['onair_band']!='')?' ('.$_data['pe_json_return']['onair_band'].')':''):'not active';
        $this->load->view('interface_assets/mini_header', $_data);
        $this->load->add_package_path(APPPATH.$this->config->item('pluginsext_path').'/sharedata/');
        $this->load->view('sharedata/onair');
        $this->change_user_stylesheet(false);
    }

    public function ws_setonair($_data) {
        return $this->set_onair($_data);
    }

    public function ws_onair($_data) {
        return $this->get_onair($_data);
    }

    private function set_onair($_data) {
        $onair_state = str_replace('"', "", $this->input->post("onair_state"));
        $_data['pluginsext_row']->pluginsext_values->onair_date = ($onair_state==1)?date('U'):'';
        $_userid = ((isset($data['_oUser']))&&($data['_oUser']->user_id>0))?$data['_oUser']->user_id:$this->session->userdata('user_id');
        $this->pluginsext_model->set_value($_data['pluginsext_row']->pluginsext_id, $_userid, $_data['pluginsext_row']->pluginsext_values);
        if ($onair_state==1) {
            $onair_icon = $_data['pluginsext_row']->pluginsext_params->onair_showon;
        } else {
            $onair_icon = $_data['pluginsext_row']->pluginsext_params->onair_showoff;
        }
        $_data['pe_json_return'] = array('onair_state'=>$onair_state,'onair_icon'=>'fa-'.$onair_icon);
        return $_data;
    }

    private function get_onair($_data) {
        $this->load->model('logbook_model');
        $onair_state = 0;
        if (!isset($_data['_oUser'])) {
            $_data['_oUser'] = $this->user_model->get_by_id($this->session->userdata('user_id'))->row();
        }
        $_data['sharedata_last_qso'] = $this->model_lastqso($_data['_oUser'], 1)->result();
        if (count($_data['sharedata_last_qso'])>0) {
            $onair_dateref = 0;
            if ($_data['pluginsext_row']->pluginsext_values->onair_date > strtotime($_data['sharedata_last_qso'][0]->COL_TIME_ON)) {
                $onair_dateref = $_data['pluginsext_row']->pluginsext_values->onair_date;
                log_message('debug','[Pluginsext]['.get_called_class().'] C1:'.date('Y-m-d H:i:s',$_data['pluginsext_row']->pluginsext_values->onair_date).'>'.$_data['sharedata_last_qso'][0]->COL_TIME_ON);
            } else {
                $onair_dateref = strtotime($_data['sharedata_last_qso'][0]->COL_TIME_ON);
                log_message('debug','[Pluginsext]['.get_called_class().'] C2:"'.((intval($_data['pluginsext_row']->pluginsext_values->onair_date>0))?date('Y-m-d H:i:s',$_data['pluginsext_row']->pluginsext_values->onair_date):'').'"<'.$_data['sharedata_last_qso'][0]->COL_TIME_ON);
            }
            if (($onair_dateref+($_data['pluginsext_row']->pluginsext_params->onair_timeout*60)) >= date('U')) {
                $_data['pluginsext_row']->pluginsext_values->onair_date = $onair_dateref;
                $onair_state = 1;
                log_message('debug','[Pluginsext]['.get_called_class().'] ON AIR: '.date('Y-m-d H:i:s',$onair_dateref+($_data['pluginsext_row']->pluginsext_params->onair_timeout*60)).'>='.date('Y-m-d H:i:s'));
            } else {
                $_data['pluginsext_row']->pluginsext_values->onair_date = '';
                $onair_dateref = 0;
                log_message('debug','[Pluginsext]['.get_called_class().'] NOT AIR ');
            }  
            $this->pluginsext_model->set_value($_data['pluginsext_row']->pluginsext_id, $_data['_oUser']->user_id, $_data['pluginsext_row']->pluginsext_values);
        }
        if ($onair_state==1) {
            $onair_icon = $_data['pluginsext_row']->pluginsext_params->onair_showon;
            if ($_data['sharedata_last_qso'][0]->COL_CONTEST_ID>0) { $_data['pluginsext_row']->pluginsext_params->onair_show_band = 0; }
            switch($_data['pluginsext_row']->pluginsext_params->onair_show_band) {
                case "1":
                case "B": $onair_band = ($_data['sharedata_last_qso'][0]->COL_SAT_NAME!='')?$_data['sharedata_last_qso'][0]->COL_SAT_NAME:$_data['sharedata_last_qso'][0]->COL_BAND;
                    break;
                case "F": $onair_band = $this->frequency->hz_to_mhz($_data['sharedata_last_qso'][0]->COL_FREQ);
                    break;
                default : $onair_band = '';
            }
        } else {
            $onair_icon = $_data['pluginsext_row']->pluginsext_params->onair_showoff;
            $onair_band = '';
        }

        $_data['pe_json_return'] = array('onair_state'=>$onair_state,'onair_band'=>$onair_band, 'onair_icon'=>'fa-'.$onair_icon);
        return $_data;
    }
	

    // --- MODEL -------------------------------------------------------------- //
    
    private function model_lastqso($_oUser=null, $nb=10,$filter=null,$hidecontest=true,$hideft8=true) {
        if (!$_oUser) return false;

        $this->load->model('logbooks_model');
        $logbooks_locations_array = $this->logbooks_model->list_logbook_relationships($_oUser->active_station_logbook);
        if(!empty($logbooks_locations_array)) {
            $this->db->select('COL_CALL, COL_BAND, COL_FREQ, COL_TIME_ON, COL_RST_RCVD, COL_RST_SENT, COL_MODE, COL_SUBMODE, COL_NAME, COL_COUNTRY, COL_PRIMARY_KEY, COL_SAT_NAME, COL_STATION_CALLSIGN, COL_MY_GRIDSQUARE, COL_CONTEST_ID');
            $this->db->where(" (COL_CONTEST_ID IS NULL OR COL_CONTEST_ID='') "); // if ($hidecontest) { }
            if ($hideft8) { $this->db->where(" !( ((COL_MODE = 'MFSK')&&(COL_SUBMODE = 'FT4')) || (COL_MODE = 'FT8') ) "); }
            if ($filter) { $this->db->where($filter); }
            $this->db->where_in('station_id', $logbooks_locations_array);
            $this->db->order_by("COL_TIME_ON", "desc");
            $this->db->limit($nb);
            return $this->db->get($this->config->item('table_name'));
        } else {
            return false;
        }
    }
}
