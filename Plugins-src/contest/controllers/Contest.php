<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Contest extends Pluginsext_extands { 
    
    private $contest_icon_stateqso;
    private $contest_band_freq;
    private $contest_mode_code;
    private $contest_measurement;
    private $contest_logEdi_param;

    // load construct //
    function __construct() {
        parent::__construct();
        $this->load->model('Stations');
        $this->contest_icon_stateqso = array('v'=> array('s'=>'v','i'=>'fas fa-check','c'=>'color:var(--green);'), 'nv'=> array('s'=>'nv','i'=>'fas fa-plus-circle','c'=>'color:var(--danger);'));
        $this->contest_band_freq = array('6m'=>array('f'=>'50 MHz','m'=>'1'),
                                        '4m'=>array('f'=>'70 MHz','m'=>'1'),
                                        '2m'=>array('f'=>'145 MHz','m'=>'1'),
                                        '70cm'=>array('f'=>'435 MHz','m'=>'1'),
                                        '23cm'=>array('f'=>'1,3 GHz','m'=>'1'),
                                        '13cm'=>array('f'=>'2,3 GHz','m'=>'1'),
                                        '9cm'=>array('f'=>'3,4 GHz','m'=>'1'),
                                        '6cm'=>array('f'=>'5,7 GHz','m'=>'1'),
                                        '3cm'=>array('f'=>'10 GHz','m'=>'1'),
                                        '1,25cm'=>array('f'=>'24 GHz','m'=>'1'),
                                        '6mm'=>array('f'=>'47 GHz','m'=>'2'), // From here, NOT EXIT IN CLOUD LOG //
                                        '4mm'=>array('f'=>'76 GHz','m'=>'3'),
                                        '2,5mm'=>array('f'=>'120 GHz','m'=>'4'),
                                        '2,2mm'=>array('f'=>'144 GHz','m'=>'8'),
                                        '1,2mm'=>array('f'=>'248 GHz','m'=>'10') );
        $this->contest_mode_code = array('TX-RX'=>'TEST','SSB-SSB'=>'1','CW-CW'=>'2','SSB-CW'=>'3','CW-SSB'=>'4','AM-AM'=>'5','FM-FM'=>'6','RTTY-RTTY'=>'7','SSTV-SSTV'=>'8','ATV-ATV'=>'9');
        $this->contest_measurement = array('M'=>'mi','K'=>'km','N'=>'nmi');
        $this->contest_logEdi_param = array('maxLengthLine'=>75,'km2degre'=>111,2);
    }

    // Function for edit the plugins, if you are specifique data //
    public function cl_pluginsext_edit($_data) {
        // TODO HERE (dont delete return) //
        return $_data; 
    } 
    
    // Function called from the pluginext menu 
    public function cl_pluginsext_menu($_data) {
        if ($_data['methode_name']=="cl_pluginsext_menu") $_data['methode_name'] = 'list';
        return $this->list($_data);
    }
    
    // Function list contest
    public function list($_data) {
        $this->load->model('Contesting_model');
        $_data['contest_url2update'] = $_data['pluginsext_url2menu'].'/update';
        $contest_list = $this->pluginsext_model->get_data_list_for_user($this->session->userdata('user_id'), $_data['pluginsext_row']->pluginsext_id);
        $_oUser = $this->user_model->get_by_id($this->CI->session->userdata('user_id'))->row();
        $_data['contest_list'] = array();
        $_now = gmdate('U');
        foreach ($contest_list->result() as $row) {
            $_pluginsdata_data = json_decode($row->pluginsdata_data,true);
            $_pluginsdata_data['contest_inprogress'] = false;
			if ((is_array($_pluginsdata_data))&&(isset($_pluginsdata_data['contest_name']))) {
				$_pluginsdata_data['pluginsdata_id'] = $row->pluginsdata_id;
				$_oContest = $this->Contesting_model->contest($_pluginsdata_data['contest_cl_id']);
				$_pluginsdata_data['contest_cl_n'] = (isset($_oContest->name))?$_oContest->name:'';
				$_pluginsdata_data['contest_dhStart'] = $_pluginsdata_data['contest_dateStart'].' '.$_pluginsdata_data['contest_hourStart'];
				$_pluginsdata_data['contest_dhEnd'] = $_pluginsdata_data['contest_dateEnd'].' '.$_pluginsdata_data['contest_hourEnd'];
                if (($_now >= strtotime($_pluginsdata_data['contest_dhStart'])) && ($_now < strtotime($_pluginsdata_data['contest_dhEnd']))) { $_pluginsdata_data['contest_inprogress'] = true; }
				$list_qso = $this->model_list_qso($_oUser, $_pluginsdata_data);
				$_pluginsdata_data['contest_qso_nb'] = count($list_qso->result());
                $_pluginsdata_data['contest_qso_nbv'] = count($this->model_list_qso($_oUser, $_pluginsdata_data, $_data['pluginsext_row']->pluginsext_params->bddcoluserdef_namecontest, true)->result());
				$_data['contest_list'][] = $_pluginsdata_data;
			} else {
                $_pluginsdata_data['pluginsdata_id'] = $row->pluginsdata_id;
                $_pluginsdata_data['is_error'] = true;
                $_data['contest_list'][] = $_pluginsdata_data;
            }
        }
        return $_data;
    }

    // Function for add/update contest
    public function update($_data) {
        // UPDATE FORMULAIRE //
        $_post = $this->CI->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pluginsdata_data__contest_name', '"'.$this->lang->line('contest_name').'"', 'required');
        $this->form_validation->set_rules('pluginsdata_data__contest_cl_id', '"'.$this->lang->line('contest_name_cloudlog').'"', 'required|greater_than[0]');
        $this->form_validation->set_rules('pluginsdata_data__contest_dateStart', '"'.$this->lang->line('contest_date_start').'"', 'required');
        $this->form_validation->set_rules('pluginsdata_data__contest_dateEnd', '"'.$this->lang->line('contest_date_end').'"', 'required');
        $this->form_validation->set_rules('pluginsdata_data__contest_bands', '"'.$this->lang->line('contest_bands').'"', 'required');
        if ($this->form_validation->run() !== FALSE) {
            $this->pluginsext_model->save_pluginsdata($_post, $this->session->userdata('user_id'));
            $this->session->set_flashdata('success', $_post['pluginsdata_data__contest_name'].' : this contest was updated.');
            redirect($_data['pluginsext_url2menu']);
        }

        // LOAD FORMULAIRE //
        $this->load->model('Contesting_model');
        $this->load->model('bands');

        $_data['contest_url2update'] = $_data['pluginsext_url2menu'].'/update';
        $_data['txt_cancel_confirm'] = str_replace("'","\'",$this->lang->line('contest_cancel_confirm_txt'));
        $_data['list_cl_contest'] =  $this->Contesting_model->getAllContests();
        $_data['list_cl_band'] =  $this->bands->get_user_bands_for_qso_entry();
        $_data['list_cl_stations'] =  $this->Stations->all_of_user();

        if (isset($_data['methode_args']['arg1']) && $_data['methode_args']['arg1']>0) { $_data['pluginsext_row']->pluginsdata_id = $_data['methode_args']['arg1']; }
            else { $_data['pluginsext_row']->pluginsdata_id = 0; }

        $pluginsdata_data = array('contest_name'=>'','contest_cl_id'=>'','contest_dateStart'=>'','contest_hourStart'=>'','contest_dateEnd'=>'','contest_hourEnd'=>'','contest_bands'=>'');
        if ($_data['pluginsext_row']->pluginsdata_id >0) {
            $pluginsdata_row = $this->pluginsext_model->get_data_by_id($_data['pluginsext_row']->pluginsdata_id)->row();
            $pluginsdata_data = $this->pluginsext_model->setArray($pluginsdata_data, json_decode($pluginsdata_row->pluginsdata_data,true));
            $_data['contest_url2update'] .= '/'.$_data['pluginsext_row']->pluginsdata_id;
        } else {
            $pluginsdata_data = $this->pluginsext_model->setArray($pluginsdata_data, $_post, "pluginsdata_data");
        }
        $_data['pluginsdata_data'] = json_decode(json_encode($pluginsdata_data),false);
        return $_data;
    }

    // Function for add/update contest
    public function delete($_data) {
        if (isset($_data['methode_args']['arg1']) && $_data['methode_args']['arg1']>0) { 
            $_data['pluginsext_row']->pluginsdata_id = $_data['methode_args']['arg1']; 
            //$pluginsdata_q = $this->pluginsext_model->get_data_by_id($_data['pluginsext_row']->pluginsdata_id)->row();
            if ($this->pluginsext_model->delete_pluginsdata($_data['pluginsext_row']->pluginsdata_id,$this->session->userdata('user_id'))) {
                $this->session->set_flashdata('success', '"'.$_data['pluginsext_row']->pluginsdata_id.'" : this contest was deleted.');
                redirect($_data['pluginsext_url2menu']);
            }
        }
        // ERROR //
        $this->session->set_flashdata('message', 'ERROR found for delete this contest.');
        redirect($_data['pluginsext_url2menu']);
    }

    // get list contest with same station //
    public function ws_getcontestlist($_data) {
        $_data['_for_select']['contest_station_id'] = intval($this->input->post("pe_contest_station_id"));
        $_data['_for_select']['contest_log_type'] = str_replace('"', "", $this->input->post("pe_contest_log_type"));

        if (($_data['_for_select']['contest_station_id']>0) && ($_data['methode_args']['arg1']>0)) {
            $contest_list = $this->pluginsext_model->get_data_list_for_user($this->session->userdata('user_id'), $_data['pluginsext_row']->pluginsext_id);
            $_data['contest_list'] = array();
            foreach ($contest_list->result() as $row) {
                if ($_data['methode_args']['arg1'] != $row->pluginsdata_id) {
                    $_pluginsdata_data = json_decode($row->pluginsdata_data,true);
                    if ((is_array($_pluginsdata_data))&&(isset($_pluginsdata_data['contest_name']))) {
                        if (($_pluginsdata_data['contest_station_id']==$_data['_for_select']['contest_station_id']) && ($_pluginsdata_data['contest_log_type']==$_data['_for_select']['contest_log_type'])) {
                            $_data['contest_list'][] = $_pluginsdata_data;
                        }
                    }                    
                }
            }
            $_data['pe_json_return'] = array('contest_list'=>$_data['contest_list']);
            return $_data;
        } else $_msg = "not filter station id";
        $_data['pe_json_return'] = array('pe_stat'=>'KO','pe_msg'=>'ERROR: on this method : '.$_data['methode_name'].' ('.$_msg.')', 'd'=>$_data);
        return $_data;        
    }

    // --- QSO LIST -------------------------------------------------------------- //
    // Function list qso for a contest //
    public function list_qso($_data) {
        $this->load->model('Contesting_model');

        if (isset($_data['methode_args']['arg1']) && $_data['methode_args']['arg1']>0) { $_data['pluginsext_row']->pluginsdata_id = $_data['methode_args']['arg1']; }
            else { $_data['pluginsext_row']->pluginsdata_id = 0; }

        if ($_data['pluginsext_row']->pluginsdata_id >0) {
            $pluginsdata_q = $this->pluginsext_model->get_data_by_id($_data['pluginsext_row']->pluginsdata_id)->row();
            $_data['pluginsdata_data'] = json_decode($pluginsdata_q->pluginsdata_data,true);
            $_data['pluginsdata_data']['measurement_base'] = ($this->session->userdata('user_measurement_base') == NULL)?$this->config->item('measurement_base'):$this->session->userdata('user_measurement_base');
            $_data['pluginsdata_data']['measurement_base'] = $this->contest_measurement[$_data['pluginsdata_data']['measurement_base']];
            $_oContest = $this->Contesting_model->contest($_data['pluginsdata_data']['contest_cl_id']);
            $_data['pluginsdata_data']['contest_cl_n'] = (isset($_oContest->name))?$_oContest->name:'';
            $_oUser = $this->user_model->get_by_id($this->session->userdata('user_id'))->row();
            $_data['pluginsdata_data']['contest_dhStart'] = $_data['pluginsdata_data']['contest_dateStart']." ".$_data['pluginsdata_data']['contest_hourStart'].":00";
            $_data['pluginsdata_data']['contest_dhEnd'] = $_data['pluginsdata_data']['contest_dateEnd']." ".$this->define_second_end_hour($_data['pluginsdata_data']['contest_hourEnd']);
            $_oStation = $this->Stations->profile($_data['pluginsdata_data']['contest_station_id'])->row();
            $_data['pluginsdata_data']['contest_station'] = $_oStation->station_profile_name."&nbsp;&nbsp;:&nbsp;&nbsp;".$_oStation->station_gridsquare."&nbsp;&nbsp;-&nbsp;&nbsp;".$_oStation->station_city;

            $_bddcoluserdef_namecontest = $_data['pluginsext_row']->pluginsext_params->bddcoluserdef_namecontest;
            $list_qso = $this->model_list_qso($_oUser, $_data['pluginsdata_data'], $_bddcoluserdef_namecontest);
            $_data['pluginsdata_data']['list_info'] = array('nb'=>0, 'nbv'=>0);
            $_data['list_qso'] = array();
            $_data['pluginsdata_data']['duration_activity'] = 0;
            $_duration_activity_last = '';

            foreach ($list_qso->result() as $row) {
                $row->_html_valid_btn = "<div style=\"display:none;\">".$this->contest_icon_stateqso['nv']['s']."</div><span style=\"cursor:pointer; ".$this->contest_icon_stateqso['nv']['c']."\" class=\"pe_contest_validbtn\" data-qsostate=\"".$this->contest_icon_stateqso['nv']['s']."\"><i class=\"".$this->contest_icon_stateqso['nv']['i']."\"></i></span>";
                $row->COL_MODE_PE = (!empty($row->COL_SUBMODE))?$row->COL_SUBMODE:$row->COL_MODE;
                $row->COL_STX_PE = $row->COL_STX_STRING.((!empty($row->COL_STX)&&!empty($row->COL_STX_STRING))?" / ":"").((!empty($row->COL_STX))?($this->format_serial($row->COL_STX)):"");
                $row->COL_SRX_PE = $row->COL_SRX_STRING.((!empty($row->COL_SRX)&&!empty($row->COL_SRX_STRING))?" / ":"").((!empty($row->COL_SRX))?($this->format_serial($row->COL_SRX)):"");
                if ($row->$_bddcoluserdef_namecontest == $_data['pluginsdata_data']['contest_name']) {
                    $_data['pluginsdata_data']['list_info']['nbv']++;
                    $row->_html_valid_btn = "<div style=\"display:none;\">".$this->contest_icon_stateqso['v']['s']."</div><span class=\"pe_contest_validbtn\" style=\"cursor:pointer; ".$this->contest_icon_stateqso['v']['c']."\" data-qsostate=\"".$this->contest_icon_stateqso['v']['s']."\"><i class=\"".$this->contest_icon_stateqso['v']['i']."\"></i></span>";
                }
                // Calcul des durées //
                if ($_duration_activity_last=='') { $_duration_activity_last=date('U',strtotime($row->COL_TIME_ON)); }
                $_duration_activity_delta = intval(date('U',strtotime($row->COL_TIME_ON))) - intval($_duration_activity_last);
                if ($_duration_activity_delta <= intval($_data['pluginsext_row']->pluginsext_params->contest_period_not_activity_allowed)) {
                    $_data['pluginsdata_data']['duration_activity'] = intval($_data['pluginsdata_data']['duration_activity']) + $_duration_activity_delta;
                }
                $_duration_activity_last= intval(date('U',strtotime($row->COL_TIME_ON)));
                $row->_duration_activity_delta = $_duration_activity_delta/60; // debug //
                $row->_duration_activity = $_data['pluginsdata_data']['duration_activity']/60; // debug //
                $_data['list_qso'][] = $row;
            }
            $_data['pluginsdata_data']['list_info']['nb'] = count($_data['list_qso']);
            $_data['pluginsdata_data']['duration_activity'] = $_data['pluginsdata_data']['duration_activity'];
        } else {
            // TODO ERROR
        }
        return $_data;
    }

    // Set distance on Logbook field //
    public function ws_setdistance($_data) {
        $_data['_for_do']['COL_PRIMARY_KEY'] = str_replace('"', "", $this->input->post("pe_contest_qsoid"));
        $_data['_for_do']['isallupdate'] = (str_replace('"', "", $this->input->post("pe_contest_all_update"))=="true")?true:false;
        $_data['_for_do']['isallupdate'] = ($_data['_for_do']['COL_PRIMARY_KEY']>0)?false:$_data['_for_do']['isallupdate'];
        $_msg = ""; 
        if ($_data['methode_args']['arg1'] > 0) {
            $_nbupdate = 0;
            $pluginsdata_row = $this->pluginsext_model->get_data_by_id($_data['methode_args']['arg1'])->row();
            $_data['pluginsdata_data'] = json_decode($pluginsdata_row->pluginsdata_data,true);
            $_oStation = $this->Stations->profile($_data['pluginsdata_data']['contest_station_id'])->row();
            $_data['pluginsdata_data']['contest_station_gridsquare'] = $_oStation->station_gridsquare;
            $_data['_for_do']['measurement_base'] = ($this->session->userdata('user_measurement_base') == NULL)?$this->config->item('measurement_base'):$this->session->userdata('user_measurement_base');
            if (($_data['_for_do']['isallupdate']==false) && ($_data['_for_do']['COL_PRIMARY_KEY'] > 0)) {
                // TODO //
                //contest_qso_id
            } else if ($_data['_for_do']['isallupdate']==true) {
                $_bddcoluserdef_namecontest = $_data['pluginsext_row']->pluginsext_params->bddcoluserdef_namecontest;
                $list_qso = $this->model_list_qso($this->user_model->get_by_id($this->session->userdata('user_id'))->row(), $_data['pluginsdata_data'], $_bddcoluserdef_namecontest, true);
                foreach ($list_qso->result() as $row) {
                    if ((strlen($row->COL_GRIDSQUARE)==4)||(strlen($row->COL_GRIDSQUARE)==6)) {
                        $_data['_for_do']['gridsquare2'] = $row->COL_GRIDSQUARE;
                        $_data['_for_do']['COL_PRIMARY_KEY'] = $row->COL_PRIMARY_KEY;
                        $this->set_distance($_data);
                        $_nbupdate++;                        
                    }
                }
                $_data['pe_json_return'] = array('nbupdate'=>$_nbupdate, 'd'=>$_data);
                return $_data;                
            } else $_msg = "not info for update type";
        } else $_msg = "not contest id";
        $_data['pe_json_return'] = array('pe_stat'=>'KO','pe_msg'=>'ERROR: on this method : '.$_data['methode_name'].' ('.$_msg.')', 'd'=>$_data);
        return $_data;        
    }

    // Set distance //
    public function set_distance($_data) {
        $this->load->model('Distances_model');
        $_data['_for_do']['COL_DISTANCE'] = $this->Distances_model->bearing_dist($_data['pluginsdata_data']['contest_station_gridsquare'], $_data['_for_do']['gridsquare2'], $_data['_for_do']['measurement_base']);
        $this->model_set_distance($_data);
    }

    // Set contest name on COL_USER_DEFINED_x field //
    public function ws_setqsostate($_data) {
        $_data['_for_do']['COL_PRIMARY_KEY'] = str_replace('"', "", $this->input->post("pe_contest_qsoid"));
        $_data['_for_do']['isallupdate'] = (str_replace('"', "", $this->input->post("pe_contest_all_update"))=="true")?true:false;
        $_data['_for_do']['isallupdate'] = ($_data['_for_do']['COL_PRIMARY_KEY']>0)?false:$_data['_for_do']['isallupdate'];
        $_data['_for_do']['qsostate'] = ($_data['_for_do']['isallupdate']==true)?"v":((str_replace('"', "", $this->input->post("pe_contest_qsostate"))=="v")?"v":"nv");
        $_msg = ""; 
        if ($_data['methode_args']['arg1'] > 0) {
            if ((($_data['_for_do']['isallupdate']==false) && ($_data['_for_do']['COL_PRIMARY_KEY'] > 0)) || ($_data['_for_do']['isallupdate']==true)) {
                $pluginsdata_row = $this->pluginsext_model->get_data_by_id($_data['methode_args']['arg1'])->row();
                // if contest data exist and is for this user //
                if (is_object($pluginsdata_row) && $pluginsdata_row->pluginsext_user_id==$this->session->userdata('user_id')) {
                    $_data['pluginsdata_data'] = json_decode($pluginsdata_row->pluginsdata_data,true);
                    // set info //
                    if (!empty($_data['pluginsext_row']->pluginsext_params->bddcoluserdef_namecontest)) {
                        $_data['_for_do']['COL_USER_DEFINED_name'] = $_data['pluginsext_row']->pluginsext_params->bddcoluserdef_namecontest;
                        $_data['_for_do']['COL_USER_DEFINED_value'] = ($_data['_for_do']['qsostate']=='v')?$_data['pluginsdata_data']['contest_name']:"";
                        $_data['pluginsdata_data']['contest_dhStart'] = $_data['pluginsdata_data']['contest_dateStart']." ".$_data['pluginsdata_data']['contest_hourStart'].":00";
                        $_data['pluginsdata_data']['contest_dhEnd'] = $_data['pluginsdata_data']['contest_dateEnd']." ".$this->define_second_end_hour($_data['pluginsdata_data']['contest_hourEnd']);                            
                        $this->model_set_contest_set_userdefined($_data);
                        $_qso_nbv = count($this->model_list_qso($this->user_model->get_by_id($this->session->userdata('user_id'))->row(), $_data['pluginsdata_data'], $_data['pluginsext_row']->pluginsext_params->bddcoluserdef_namecontest, true)->result());
                        $_data['pe_json_return'] = array('icon_info'=>$this->contest_icon_stateqso[$_data['_for_do']['qsostate']],'nbv'=>$_qso_nbv, 'd'=>$_data);
                        return $_data;
                    } else $_msg = "no field name of user_defined found";
                } else $_msg = "no data found";
            } else $_msg = "qso id not ok (".$_data['_for_do']['COL_PRIMARY_KEY'].")";
        } else $_msg = "not contest id";
        $_data['pe_json_return'] = array('pe_stat'=>'KO','pe_msg'=>'ERROR: on this method : '.$_data['methode_name'].' ('.$_msg.')');
        return $_data;        
    }


    // --- STATISTIQUES -------------------------------------------------------------- //
    // Function show statistiques about contest //
    public function statistiques($_data) {
        $this->load->model('Contesting_model');

        if (isset($_data['methode_args']['arg1']) && $_data['methode_args']['arg1']>0) { $_data['pluginsext_row']->pluginsdata_id = $_data['methode_args']['arg1']; }
            else { $_data['pluginsext_row']->pluginsdata_id = 0; }

        if ($_data['pluginsext_row']->pluginsdata_id >0) {
            $pluginsdata_q = $this->pluginsext_model->get_data_by_id($_data['pluginsext_row']->pluginsdata_id)->row();
            $_data['pluginsdata_data'] = json_decode($pluginsdata_q->pluginsdata_data,true);
            $_data['pluginsdata_data']['measurement_base'] = ($this->session->userdata('user_measurement_base') == NULL)?$this->config->item('measurement_base'):$this->session->userdata('user_measurement_base');
            $_data['pluginsdata_data']['measurement_base'] = $this->contest_measurement[$_data['pluginsdata_data']['measurement_base']];
            $_oContest = $this->Contesting_model->contest($_data['pluginsdata_data']['contest_cl_id']);
            $_data['pluginsdata_data']['contest_cl_n'] = (isset($_oContest->name))?$_oContest->name:'';
            $_oUser = $this->user_model->get_by_id($this->session->userdata('user_id'))->row();
            $_data['pluginsdata_data']['contest_dhStart'] = $_data['pluginsdata_data']['contest_dateStart']." ".$_data['pluginsdata_data']['contest_hourStart'].":00";
            $_data['pluginsdata_data']['contest_dhEnd'] = $_data['pluginsdata_data']['contest_dateEnd']." ".$this->define_second_end_hour($_data['pluginsdata_data']['contest_hourEnd']);
            $_data['pluginsdata_data']['contest_duration'] = (intval(date('U',strtotime($_data['pluginsdata_data']['contest_dhEnd']))) - intval(date('U',strtotime($_data['pluginsdata_data']['contest_dhStart'])))) + (((substr($_data['pluginsdata_data']['contest_hourEnd'], -2))=="59")?1:0);

            $_oStation = $this->Stations->profile($_data['pluginsdata_data']['contest_station_id'])->row();
            $_data['pluginsdata_data']['contest_station'] = $_oStation->station_profile_name."&nbsp;&nbsp;:&nbsp;&nbsp;".$_oStation->station_gridsquare."&nbsp;&nbsp;-&nbsp;&nbsp;".$_oStation->station_city;

            $_bddcoluserdef_namecontest = $_data['pluginsext_row']->pluginsext_params->bddcoluserdef_namecontest;
            $list_qso = $this->model_list_qso($_oUser, $_data['pluginsdata_data'], $_bddcoluserdef_namecontest);
            $_data['pluginsdata_data']['list_info'] = array('nb'=>0, 'nbv'=>0);
            $_data['list_qso'] = array();
            $_contest_stat_range = $_data['pluginsext_row']->pluginsext_params->contest_period_timeplotter;
            $_data['pluginsdata_data']['duration_activity'] = 0;
            $_duration_activity_last = '';
            
            foreach ($list_qso->result() as $row) {
                $mins = floor(date('i',strtotime($row->COL_TIME_ON))/intval($_contest_stat_range))*intval($_contest_stat_range);
                $date = date('Y-m-d',strtotime($row->COL_TIME_ON))." ".date('H',strtotime($row->COL_TIME_ON)).":".($mins).":00";
                $row->contest_dateRange = date('U', strtotime($date));
                if ($row->$_bddcoluserdef_namecontest == $_data['pluginsdata_data']['contest_name']) $_data['pluginsdata_data']['list_info']['nbv']++;
                
                // Calcul des durées //
                if ($_duration_activity_last=='') { $_duration_activity_last=date('U',strtotime($row->COL_TIME_ON)); }
                $_duration_activity_delta = intval(date('U',strtotime($row->COL_TIME_ON))) - intval($_duration_activity_last);
                if ($_duration_activity_delta <= intval($_data['pluginsext_row']->pluginsext_params->contest_period_not_activity_allowed)) {
                	$_data['pluginsdata_data']['duration_activity'] = intval($_data['pluginsdata_data']['duration_activity']) + $_duration_activity_delta;
                }
               	$_duration_activity_last= intval(date('U',strtotime($row->COL_TIME_ON)));
                $row->_duration_activity_delta = $_duration_activity_delta/60; // debug //
                $row->_duration_activity = $_data['pluginsdata_data']['duration_activity']/60; // debug //
                $_data['list_qso'][] = $row;
            }
			$_data['pluginsdata_data']['list_info']['nb'] = count($_data['list_qso']);
        	$this->load->model('Timeplotter_model');
        	$_data['pluginsdata_data']['contest_timeplotter'] = json_encode($this->model_set_timeplotter($_data));
        } else {
            // TODO ERROR
        }
        return $_data;
    }

    // --- EXPORT LOGS -------------------------------------------------------------- //
    // Function set to export for a contest //
    public function logs_export($_data) {
        $this->load->model('Contesting_model');

        if (isset($_data['methode_args']['arg1']) && $_data['methode_args']['arg1']>0) { $_data['pluginsext_row']->pluginsdata_id = $_data['methode_args']['arg1']; }
            else { $_data['pluginsext_row']->pluginsdata_id = 0; }

        if ($_data['pluginsext_row']->pluginsdata_id >0) {
            $pluginsdata_q = $this->pluginsext_model->get_data_by_id($_data['pluginsext_row']->pluginsdata_id)->row();
            $_data['pluginsdata_data'] = json_decode($pluginsdata_q->pluginsdata_data,true);
            //$_data['pluginsext_row']->pluginsext_params = json_decode($_data['pluginsext_row']->pluginsext_params);

            $_oContest = $this->Contesting_model->contest($_data['pluginsdata_data']['contest_cl_id']);
            $_data['pluginsdata_data']['contest_cl_n'] = (isset($_oContest->name))?$_oContest->name:'';
            $_oUser = $this->user_model->get_by_id($this->session->userdata('user_id'))->row();
            $_data['pluginsdata_data']['contest_dhStart'] = $_data['pluginsdata_data']['contest_dateStart']." ".$_data['pluginsdata_data']['contest_hourStart'].":00";
            $_data['pluginsdata_data']['contest_dhEnd'] = $_data['pluginsdata_data']['contest_dateEnd']." ".$this->define_second_end_hour($_data['pluginsdata_data']['contest_hourEnd']);
            $_oStation = $this->Stations->profile($_data['pluginsdata_data']['contest_station_id'])->row();
            $_data['pluginsdata_data']['contest_station'] = $_oStation->station_profile_name."&nbsp;&nbsp;:&nbsp;&nbsp;".$_oStation->station_gridsquare."&nbsp;&nbsp;-&nbsp;&nbsp;".$_oStation->station_city;
            $_data['pluginsdata_data']['list_band'] = array();
            if ($_data['pluginsdata_data']['contest_log_type']=="Edi") {
                foreach (explode(',',$_data['pluginsdata_data']['contest_bands']) as $row) {
                    if (isset($this->contest_band_freq[$row]['f'])) { $_data['pluginsdata_data']['list_band'][$row] = $this->contest_band_freq[$row]['f']; }
                }     
            }

        } else {
            // TODO ERROR
        }
        return $_data;
    }
    // format content file for Edi //
    public function file_edi($_data) {
        $this->load->model('Stations');
        $this->load->model("logbook_model");
        $_paramfixe = array('CQSOs_multi'=>'1','CDXCs_multi'=>'1');

        $_logreturn = "[REG1TEST;1]\n";
        $_logreturn .= "TName=".strtoupper($_data['pluginsdata_data']['log_edi_TName'])."\n";
        $_logreturn .= "TDate=".str_replace("-","",$_data['pluginsdata_data']['contest_dateStart']).";".str_replace("-","",$_data['pluginsdata_data']['contest_dateEnd'])."\n";
        $_logreturn .= "PCall=".strtoupper($_data['pluginsdata_data']['log_edi_PCall'])."\n";
        $_oStation = $this->Stations->profile($_data['pluginsdata_data']['contest_station_id'])->row();
        $_logreturn .= "PWWLo=".strtoupper($_oStation->station_gridsquare)."\n";
        $_logreturn .= "PExch=".strtoupper($_data['pluginsdata_data']['log_edi_PExch'])."\n";
        $_logreturn .= "PAdr1=".strtoupper($_data['pluginsdata_data']['log_edi_PAdr1'])."\n";
        $_logreturn .= "PAdr2=".strtoupper($_data['pluginsdata_data']['log_edi_PAdr2'])."\n";
        $_logreturn .= "PSect=".strtoupper($_data['pluginsdata_data']['log_edi_PSect'])."\n";
        $_logreturn .= "PBand=".strtoupper($this->contest_band_freq[$_data['_for_export']['contest_band']]['f'])."\n";
        $_logreturn .= "PClub=".strtoupper($_data['pluginsdata_data']['log_edi_PClub'])."\n";
        $_logreturn .= "RName=".strtoupper($_data['pluginsdata_data']['log_edi_RName'])."\n";
        $_logreturn .= "RCall=".strtoupper($_data['pluginsdata_data']['log_edi_RCall'])."\n";
        $_logreturn .= "RAdr1=".strtoupper($_data['pluginsdata_data']['log_edi_RAdr1'])."\n";
        $_logreturn .= "RAdr2=".strtoupper($_data['pluginsdata_data']['log_edi_RAdr2'])."\n";
        $_logreturn .= "RPoCo=".strtoupper($_data['pluginsdata_data']['log_edi_RPoCo'])."\n";
        $_logreturn .= "RCity=".strtoupper($_data['pluginsdata_data']['log_edi_RCity'])."\n";
        $_logreturn .= "RCoun=".strtoupper($_data['pluginsdata_data']['log_edi_RCoun'])."\n";
        $_logreturn .= "RPhon=".strtoupper($_data['pluginsdata_data']['log_edi_RPhon'])."\n";
        $_logreturn .= "RHBBS=".strtoupper($_data['pluginsdata_data']['log_edi_RHBBS'])."\n";
        if (strlen($_data['pluginsdata_data']['log_edi_MOpe1'])>intval($this->contest_logEdi_param['maxLengthLine']-strlen("MOpe1="))) {
            // TODO //
            $_tmpMOpe1 = substr($_data['pluginsdata_data']['log_edi_MOpe1'],0,($this->contest_logEdi_param['maxLengthLine']-strlen("MOpe1=")));
            $_lastSep = strrpos($_tmpMOpe1,";");
            $_logreturn .= "MOpe1=".strtoupper(substr($_tmpMOpe1,0,$_lastSep))."\n";
            $_logreturn .= "MOpe2=".strtoupper(substr($_data['pluginsdata_data']['log_edi_MOpe1'],($_lastSep+1)))."\n";
        } else {
            $_logreturn .= "MOpe1=".strtoupper($_data['pluginsdata_data']['log_edi_MOpe1'])."\n";
        }
        $_logreturn .= "SPowe=".strtoupper($_data['pluginsdata_data']['log_edi_SPowe'])."\n";
        $_logreturn .= "STXEq=".strtoupper($_data['pluginsdata_data']['log_edi_STXEq'])."\n";
        $_logreturn .= "SRXEq=".(($_data['pluginsdata_data']['log_edi_SRXEq']=="")?strtoupper($_data['pluginsdata_data']['log_edi_STXEq']):strtoupper($_data['pluginsdata_data']['log_edi_SRXEq']))."\n";
        $_logreturn .= "SAnte=".strtoupper($_data['pluginsdata_data']['log_edi_SAnte'])."\n";
        $_logreturn .= "SAntH=".strtoupper($_data['pluginsdata_data']['log_edi_SAntH1']).";".strtoupper($_data['pluginsdata_data']['log_edi_SAntH2'])."\n";
		$_logreturn .= "%%RESULT%%";
        $_logreturn .= "[Remarks]\n";
        $_logreturn .= strtoupper($_data['pluginsdata_data']['log_edi_remarks'])."\n";

        $_oUser = $this->user_model->get_by_id($this->session->userdata('user_id'))->row();
        $_data['pluginsdata_data']['contest_bands'] = $_data['_for_export']['contest_band']; // force band //
        $list_qso = $this->model_list_qso($_oUser, $_data['pluginsdata_data'], $_data['pluginsext_row']->pluginsext_params->bddcoluserdef_namecontest, true, "asc")->result();
        $_logreturn .= "[QSORecords;".count($list_qso)."]\n";
        $_info = array('exchange'=>array(),'wwl'=>array(),'dxcc'=>array(),'call'=>array(),'bestdistance'=>0,'bestqso'=>'','qsopoints'=>0);
        $_mode = 0; // check with the 1st QSO, concidering : only 1 mode for a contest //
        foreach ($list_qso as $row) {
            if ($_mode==0) { 
            	if (isset($this->contest_mode_code[$row->COL_MODE.'-'.$row->COL_MODE])) { $_mode = $this->contest_mode_code[$row->COL_MODE.'-'.$row->COL_MODE]; }
            		elseif (isset($this->contest_mode_code[$row->COL_SUBMODE.'-'.$row->COL_SUBMODE])) { $_mode = $this->contest_mode_code[$row->COL_SUBMODE.'-'.$row->COL_SUBMODE]; }
            }
            $_dh = date("ymd;hi",strtotime($row->COL_TIME_ON));
            $_pointQso = 0;
            $_newExch = "";
        	$_newLoc = "";
			$_newDxcc = "";
        	$_dblQso = "";
        	if (empty($row->COL_RST_SENT) || empty($row->COL_RST_RCVD) || empty($row->COL_SRX) || empty($row->COL_GRIDSQUARE)) {
        		$row->COL_RST_SENT = "";
        		$row->COL_RST_RCVD = "";
        		$row->COL_SRX = "";
        		$row->COL_GRIDSQUARE = "";
        		$row->COL_CALL = "ERROR";
        	} else {
	        	if (in_array($row->COL_CALL, $_info['call'])) {
	        		$_dblQso = "D";
	        		$_pointQso = 0;
	        	} else {
                    $_info['call'][] = $row->COL_CALL;
	        		$_pointQso = $row->COL_DISTANCE;
                    if ($_pointQso > $_info['bestdistance']) {
                        $_info['bestdistance'] = $_pointQso;
                        $_info['bestqso'] = $row->COL_CALL.";".$row->COL_GRIDSQUARE.";".$_pointQso;
                    }
                    $_info['qsopoints'] = intval($_info['qsopoints']) + intval($_pointQso);
		            if ($row->COL_SRX_STRING!="") { if (!in_array($row->COL_SRX_STRING, $_info['exchange'])) { $_info['exchange'][] = $row->COL_SRX_STRING; $_newExch = "N"; } }
		            if (!in_array(substr($row->COL_GRIDSQUARE,0,4), $_info['wwl'])) { $_info['wwl'][] = substr($row->COL_GRIDSQUARE,0,4); $_newLoc = "N"; }
					$_rowdxcc = $this->logbook_model->dxcc_lookup($row->COL_CALL, date("Y-m-d",strtotime($row->COL_TIME_ON)));
		        	if (!in_array($_rowdxcc['entity'], $_info['dxcc'])) { $_info['dxcc'][] = $_rowdxcc['entity']; $_newDxcc = "N"; }
	        	}
        	}
            $_logreturn .= $_dh.";".$row->COL_CALL.";".(($row->COL_CALL=="ERROR")?"":$_mode).";".$row->COL_RST_SENT.";".$this->format_serial($row->COL_STX).";".$row->COL_RST_RCVD.";".$this->format_serial($row->COL_SRX).";".$row->COL_GRIDSQUARE.";".$_pointQso.";".$_newExch.";".$_newLoc.";".$_newDxcc.";".$_dblQso."\n";
        }

		$_logreturntmp = "";
        $_logreturntmp .= "CQSOs=".count($_info['call']).";".$this->contest_band_freq[$_data['_for_export']['contest_band']]['m']."\n";
        $_logreturntmp .= "CQSOP=".$_info['qsopoints']."\n";
        $_logreturntmp .= "CWWLs=".count($_info['wwl']).";0;".$_data['pluginsdata_data']['contest_gridsquare_multi']."\n"; // ? TODO Bonus ? //
        $_logreturntmp .= "CWWLB=\n"; // ? TODO ? //
        $_logreturntmp .= "CExcs=".count($_info['exchange']).";0;".$_data['pluginsdata_data']['contest_exchange_multi']."\n"; // ? TODO Bonus ? //
        $_logreturntmp .= "CExcB=\n"; // ? TODO ? //
        $_logreturntmp .= "CDXCs=".count($_info['dxcc']).";0;".$_data['pluginsdata_data']['contest_dxcc_multi']."\n"; // ? TODO Bonus ? //
        $_logreturntmp .= "CDXCB=\n"; // ? TODO ? //
        $_score = (intval($_info['qsopoints'] * $this->contest_band_freq[$_data['_for_export']['contest_band']]['m'])) * (count($_info['wwl']) * intval($_data['pluginsdata_data']['contest_gridsquare_multi']));
        $_logreturntmp .= "CToSc=".$_score."\n";
        $_logreturntmp .= "CODXC=".strtoupper($_info['bestqso'])."\n";

		$_logreturn = str_replace("%%RESULT%%",$_logreturntmp,$_logreturn);
        return $_logreturn;
    }
    // return info for Cabrillo and format in jquery on cabrillo export cloudlog function //
    public function file_cabrillo($_data) {
        $this->load->model("Stations");
        $this->load->model("Contesting_model");
        $_oStation = $this->Stations->profile($_data['pluginsdata_data']['contest_station_id'])->row();
        $_oContest = $this->Contesting_model->contest($_data['pluginsdata_data']['contest_cl_id']);
        $_cabrillo_info['contest_station_id'] = $_data['pluginsdata_data']['contest_station_id'];
        $_cabrillo_info['contest_cl_adif'] = (isset($_oContest->adifname))?$_oContest->adifname:'';
        $_cabrillo_info['contest_dateEnd'] = $_data['pluginsdata_data']['contest_dateEnd'];
        $_cabrillo_info['contest_dateStart'] = $_data['pluginsdata_data']['contest_dateStart'];
        $_cabrillo_info['contest_station_callsign'] = isset($_oStation->station_callsign)?$_oStation->station_callsign:'';
        $_cabrillo_info['contest_station_city'] = isset($_oStation->station_city)?$_oStation->station_city:'';
        $_cabrillo_info['contest_station_cnty'] = isset($_oStation->station_cnty)?$_oStation->station_cnty:'';

        return $_cabrillo_info;
    }
    // Set the content log file (edi) or information (cabrillo) for export //
    public function ws_getexportlog($_data) {
        $_data['_for_export']['contest_band'] = str_replace('"', "", $this->input->post("pe_contest_band"));
        $_data['_for_export']['contest_log_type'] = str_replace('"', "", $this->input->post("pe_contest_log_type"));

        if ($_data['methode_args']['arg1'] > 0) {
            $pluginsdata_row = $this->pluginsext_model->get_data_by_id($_data['methode_args']['arg1'])->row();
            // if contest data exist and is for this user //
            if (is_object($pluginsdata_row) && $pluginsdata_row->pluginsext_user_id==$this->session->userdata('user_id')) {
                $_data['pluginsdata_data'] = json_decode($pluginsdata_row->pluginsdata_data,true);
                switch ($_data['_for_export']['contest_log_type']) {
                    case 'Edi': $_logreturn = $this->file_edi($_data); break;
                    case 'Cabrillo': $_logreturn = $this->file_cabrillo($_data); break;
                    default: $_logreturn = ''; break;
                }
                
                $_data['pe_json_return'] = array('log_content'=>$_logreturn,'d'=>$_data);
                return $_data;
            } else $_msg = "no data found";
        } else $_msg = "not contest id";
        $_data['pe_json_return'] = array('pe_stat'=>'KO','pe_msg'=>'ERROR: on this method : '.$_data['methode_name'].' ('.$_msg.')');
        return $_data;        
    }

    // --- OTHERS -------------------------------------------------------------- //
    //
    private function format_serial($_v) { return ($_v=="")?"":(($_v<100)?(($_v<10)?"00".$_v:"0".$_v):$_v); }
    private function define_second_end_hour($_hourEnd) { return (substr($_hourEnd,-2)=='59')?($_hourEnd.':59'):($_hourEnd.':00'); }

    // --- MODEL -------------------------------------------------------------- //
    //
    private function model_set_contest_set_userdefined($_data) {
        $fieldsupdate = array(
            $_data['_for_do']['COL_USER_DEFINED_name'] => xss_clean($_data['_for_do']['COL_USER_DEFINED_value'])
        );
        $this->CI->db->where('station_id', xss_clean($_data['pluginsdata_data']['contest_station_id']));
        //$this->CI->db->where('COL_CONTEST_ID', xss_clean($_data['pluginsdata_data']['contest_cl_id']));
        if ($_data['_for_do']['isallupdate']==true) {
            $this->CI->db->where(" (COL_TIME_ON >= '".xss_clean($_data['pluginsdata_data']['contest_dhStart'])."' AND COL_TIME_OFF <= '".xss_clean($_data['pluginsdata_data']['contest_dhEnd'])."') ");
            $this->CI->db->where_in('COL_BAND', explode(",",xss_clean($_data['pluginsdata_data']['contest_bands'])));
        } else {
            $this->CI->db->where('COL_PRIMARY_KEY', xss_clean($_data['_for_do']['COL_PRIMARY_KEY']));
        }
        $this->CI->db->update($this->CI->config->item('table_name'), $fieldsupdate);
    }
    //
    private function model_list_qso($_oUser=null,$_pluginsdata_data,$_bddcoluserdef_namecontest="",$_filter=false,$_orderbytime="asc") {
        if (!$_oUser) return false;
        $_bddcoluserdef_namecontest_tmp = (!empty($_bddcoluserdef_namecontest))?(", ".$_bddcoluserdef_namecontest):"";
        $this->CI->db->select('COL_PRIMARY_KEY, COL_CALL, COL_BAND, COL_TIME_ON, COL_RST_RCVD, COL_RST_SENT, COL_MODE, COL_SUBMODE, COL_SRX_STRING, COL_SRX, COL_STX_STRING, COL_STX, COL_GRIDSQUARE, COL_DISTANCE'.$_bddcoluserdef_namecontest_tmp);
        if ($_filter && !empty($_bddcoluserdef_namecontest)) { $this->CI->db->where($_bddcoluserdef_namecontest, xss_clean($_pluginsdata_data['contest_name'])); }
        $this->CI->db->where('station_id', xss_clean($_pluginsdata_data['contest_station_id']));
        //$this->CI->db->where('COL_CONTEST_ID', xss_clean($_pluginsdata_data['contest_cl_id']));
        if (isset($_pluginsdata_data['contest_qso_id']) && ($_pluginsdata_data['contest_qso_id']>0)) { 
            $this->CI->db->where('COL_PRIMARY_KEY', xss_clean($_pluginsdata_data['contest_qso_id']));
        } else {
            if ((!isset($_pluginsdata_data['contest_dhStart'])) || (!isset($_pluginsdata_data['contest_dhEnd']))) {
                $_pluginsdata_data['contest_dhStart'] = $_pluginsdata_data['contest_dateStart'].' '.$_pluginsdata_data['contest_hourStart'].'00';
                $_pluginsdata_data['contest_dhEnd'] = $_pluginsdata_data['contest_dateEnd'].' '.$this->define_second_end_hour($_pluginsdata_data['contest_hourEnd']);
            }
            $this->CI->db->where(" (COL_TIME_ON >= '".$_pluginsdata_data['contest_dhStart']."' AND COL_TIME_OFF <= '".$_pluginsdata_data['contest_dhEnd']."') ");
            $this->CI->db->where_in('COL_BAND', explode(",",xss_clean($_pluginsdata_data['contest_bands'])));
            $this->CI->db->order_by("COL_TIME_ON", $_orderbytime);
        }
        return $this->CI->db->get($this->CI->config->item('table_name'));
    }
    //
    private function model_set_distance($_data) {
        $fieldsupdate = array(
            'COL_DISTANCE' => xss_clean($_data['_for_do']['COL_DISTANCE'])
        );
        $this->CI->db->where('station_id', xss_clean($_data['pluginsdata_data']['contest_station_id']));
        $this->CI->db->where('COL_PRIMARY_KEY', xss_clean($_data['_for_do']['COL_PRIMARY_KEY']));
        $this->CI->db->update($this->CI->config->item('table_name'), $fieldsupdate);
    }
    //
    private function model_set_timeplotter($_data) {
        $tEnd = strtotime($_data['pluginsdata_data']['contest_dhEnd']);
        $tStart_c = strtotime($_data['pluginsdata_data']['contest_dhStart']);
        $_data_bands = array();
		$contest_stat_range = $_data['pluginsext_row']->pluginsext_params->contest_period_timeplotter;

        while ($tStart_c <= $tEnd) {
            $_data_times[date("U",$tStart_c)] = array('total'=>'0', 'bands'=>array(), 'label_time'=>(((strtotime($_data['pluginsdata_data']['contest_dhStart'])==$tStart_c)||(date("Hi",$tStart_c)=="0000"))?(date("Y-m-d H:i",$tStart_c).'z'):(date("H:i",$tStart_c).'z')) );
            $tStart_c = strtotime("+".$contest_stat_range." minutes",$tStart_c);
        }
        foreach ($_data['list_qso'] as $row) {
            $_data_times[$row->contest_dateRange]['total']++;
            if (!isset($_data_times[$row->contest_dateRange]['bands'][$row->COL_BAND])) { $_data_times[$row->contest_dateRange]['bands'][$row->COL_BAND]=0; }
            $_data_times[$row->contest_dateRange]['bands'][$row->COL_BAND]++;
            if (!in_array($row->COL_BAND, $_data_bands)) { $_data_bands[] = $row->COL_BAND; }
        }
        return array('data_times'=>$_data_times, 'data_bands'=>$_data_bands);
    }
}
