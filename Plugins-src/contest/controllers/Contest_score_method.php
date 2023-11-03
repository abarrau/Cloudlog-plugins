<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Contest_score_method { 

    public $contest_list_method;

    function __construct() {
        $this->contest_list_method = array(
            'CQ-WW'=>array('nf'=>'CQ WW (SSB, CW)','m'=>'contest_cqww','adif'=>array('CQ-WW-SSB','CQ-WW-CW')),
            'EA-MAJESTAD'=>array('nf'=>'His Majesty The King of Spain (SSB)','m'=>'contest_eamajestad','adif'=>array('EA-MAJESTAD-SSB'))
        );
    }

    //=====================================================================================================================================================================
    //--------------------------------------------------
    // QSO Points: Stations may be contacted once on each band. QSO points are based on the location of the station worked.
    //      1. Contacts between stations on different continents count three (3) points.
    //      2. Contacts between stations on the same continent but in different countries count one (1) point. 
    //          Exception: Contacts between stations in different countries within the North American boundaries count two (2) points.
    //      3. Contacts between stations in the same country have zero (0) QSO point value, but count for zone and country multiplier credit.
    // Multiplier: There are two types of multipliers.
    //      1. Zone: A multiplier of one (1) for each different CQ Zone contacted on each band. The CQ Worked All Zones rules are the standard.
    //      2. Country: A multiplier of one (1) for each different country contacted on each band. 
    //          The DXCC entity list, Worked All Europe (WAE) multiplier list plus IG9/IH9, and continental boundaries are the standards for defining country multipliers. 
    //          Maritime mobile stations count only for a zone multiplier. 
    //--------------------------------------------------
    function contest_cqww_qsopts($_data, $_qso=null) {
        $_pts = array('othercont'=>3,'samecont'=>1,'othercount_us'=>2,'samedx'=>0);
        if (is_object($_qso)) {
            if ($_qso->COL_CONT <> $_data['pluginsdata_data']['contest_my_cont']) { return $_pts['othercont']; }
            else if ($_qso->COL_DXCC == $_data['pluginsdata_data']['contest_my_dxcc']) { return $_pts['samedx']; }
            else {
                // TODO US //
                return $_pts['samecont'];
            } 
        }
        return "";
    }
    function contest_cqww_sum($_data) {
        $CI =& get_instance();
        if (isset($_data['pluginsext_row']->pluginsext_params->bddcoluserdef_pts)) { $_bddcoluserdef_pts = "SUM(`".$_data['pluginsext_row']->pluginsext_params->bddcoluserdef_pts."`)"; } else { $_bddcoluserdef_pts = "0"; }
        $sql = "SELECT SUM(`PTS`) AS `PTS_T`, SUM(`MULTI`) AS `MULTI_T` FROM (
                    SELECT `COL_BAND`, sum(`NBCQZ`+`NBDXCC`) AS `MULTI`, `PTS` FROM (
                        SELECT `COL_BAND`, ".$_bddcoluserdef_pts." AS `PTS`, count(DISTINCT `COL_CQZ`) AS `NBCQZ`, count(DISTINCT `COL_DXCC`) AS `NBDXCC`
                        FROM ".$CI->config->item('table_name')." 
                        WHERE `station_id` = '".xss_clean($_data['pluginsdata_data']['contest_station_id'])."' 
                            AND `COL_CONTEST_ID` = '".xss_clean($_data['pluginsdata_data']['contest_cl_adif'])."'
                            AND (`COL_TIME_ON` >= '".$_data['pluginsdata_data']['contest_dhStart']."' AND `COL_TIME_OFF` <= '".$_data['pluginsdata_data']['contest_dhEnd']."')
                            GROUP BY `COL_BAND` 
                    ) AS T GROUP BY `COL_BAND`
                ) AS F ";
        $row = $CI->db->query($sql)->row();
        return $row->PTS_T*$row->MULTI_T;
    }

    //=====================================================================================================================================================================
    //
    function contest_get_method_info($_adif,$_arg,$_comp=null) {
        if (isset($this->contest_list_method[$_adif])) { 
            if (($_arg=="m")&&(!is_null($_comp))) { return $this->contest_list_method[$_adif][$_arg]."_".$_comp; } else { return $this->contest_list_method[$_adif][$_arg]; };
        }
        foreach($this->contest_list_method as $k => $method) { 
            if (in_array($_adif,$method['adif'])) {  if (($_arg=="m")&&(!is_null($_comp))) { return $method[$_arg]."_".$_comp; } else { return $method[$_arg]; } }
        }
    }
}
