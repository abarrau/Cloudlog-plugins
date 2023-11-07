<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_PE_Contest_model extends CI_Model { 
    
    // load construct //
    function __construct() { }

    //
    public function get_timeplotter($_data) {
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

    //
    public function set_contest_set_userdefined($_data) {
        $fieldsupdate = array(
            $_data['_tmp']['COL_USER_DEFINED_name'] => xss_clean($_data['_tmp']['COL_USER_DEFINED_value'])
        );
        $this->db->where('station_id', xss_clean($_data['pluginsdata_data']['contest_station_id']));
        $this->db->where('COL_CONTEST_ID', xss_clean($_data['pluginsdata_data']['contest_cl_adif']));
        if (isset($_data['_tmp']['isallupdate']) && ($_data['_tmp']['isallupdate']==true)) {
            $this->db->where(" (COL_TIME_ON >= '".xss_clean($_data['pluginsdata_data']['contest_dhStart'])."' AND COL_TIME_OFF <= '".xss_clean($_data['pluginsdata_data']['contest_dhEnd'])."') ");
            $this->db->where_in('COL_BAND', explode(",",xss_clean($_data['pluginsdata_data']['contest_bands'])));
        } else {
            $this->db->where('COL_PRIMARY_KEY', xss_clean($_data['_tmp']['COL_PRIMARY_KEY']));
        }
        $this->db->update($this->config->item('table_name'), $fieldsupdate);
    }
    
    // 
    public function get_stat_info($_pluginsdata_data,$_what="",$_filter=array()) {
        switch($_what) {
            case "CQZ":
                $this->db->select('count(DISTINCT `COL_CQZ`) as `NB`');
                break;
            case "DXCC":
                $this->db->select('count(DISTINCT `COL_DXCC`) AS `NB`');
                break;
            case "BEST_DIST":
                $this->db->select('COL_CALL, COL_DISTANCE, COL_PRIMARY_KEY');
                $this->db->limit(1);
                $this->db->order_by('COL_DISTANCE','DESC');
                break;
            case "QSO_VALID":
                $this->db->select('count(`COL_PRIMARY_KEY`) as `NB`');
                $this->db->where("(`COL_EQSL_QSL_RCVD`='Y' OR `COL_LOTW_QSL_RCVD`='Y' OR `COL_QSL_RCVD`='Y')");
                break;
            case "DXCC_NEW":
                $sql = "SELECT DISTINCT `COL_DXCC`, `dxcc_entities`.`name` FROM ".$this->config->item('table_name')."
                        LEFT JOIN `dxcc_entities` ON ".$this->config->item('table_name').".`COL_DXCC` = `dxcc_entities`.`adif`
                        WHERE `COL_DXCC`>0 AND (`COL_TIME_ON` >= '".$_pluginsdata_data['contest_dhStart']."' AND `COL_TIME_OFF` <= '".xss_clean($_pluginsdata_data['contest_dhEnd'])."') AND `COL_DXCC` NOT IN (
                            SELECT DISTINCT `COL_DXCC` FROM ".$this->config->item('table_name')."
                            WHERE `COL_DXCC`>0 AND `COL_TIME_ON` < '".$_pluginsdata_data['contest_dhStart']."'
                        ) ORDER BY `dxcc_entities`.`name` ASC";
                return $this->db->query($sql);              
                break;
            case "CQZ_NEW":
                $sql = "SELECT DISTINCT `COL_CQZ` FROM ".$this->config->item('table_name')."
                        WHERE `COL_CQZ`>0 AND (`COL_TIME_ON` >= '".$_pluginsdata_data['contest_dhStart']."' AND `COL_TIME_OFF` <= '".xss_clean($_pluginsdata_data['contest_dhEnd'])."') AND `COL_CQZ` NOT IN (
                            SELECT DISTINCT `COL_CQZ` FROM ".$this->config->item('table_name')."
                            WHERE `COL_CQZ`>0 AND `COL_TIME_ON` < '".$_pluginsdata_data['contest_dhStart']."'
                        )";
                return $this->db->query($sql);              
                break;
            case "CALL_IS_DUP":
                $sql = "SELECT 1 AS `CALL_EXIST` FROM ".$this->config->item('table_name')."
                        WHERE (`COL_TIME_ON` >= '".xss_clean($_pluginsdata_data['contest_dhStart'])."' AND `COL_TIME_OFF` < '".xss_clean($_filter['qso']->COL_TIME_ON)."')
                            AND `COL_BAND` = '".xss_clean($_filter['qso']->COL_BAND)."'
                            AND `COL_CALL` = '".xss_clean($_filter['qso']->COL_CALL)."'
                            AND `station_id` = '".xss_clean($_pluginsdata_data['contest_station_id'])."' 
                            AND `COL_CONTEST_ID` = '".xss_clean($_pluginsdata_data['contest_cl_adif'])."' ";
                return $this->db->query($sql);              
                break;

        }
        //$this->db->where($_bddcoluserdef_namecontest, xss_clean($_pluginsdata_data['contest_name']));
        $this->db->where('station_id', xss_clean($_pluginsdata_data['contest_station_id']));
        $this->db->where('COL_CONTEST_ID', xss_clean($_pluginsdata_data['contest_cl_adif']));
        $this->db->where(" (COL_TIME_ON >= '".$_pluginsdata_data['contest_dhStart']."' AND COL_TIME_OFF <= '".$_pluginsdata_data['contest_dhEnd']."') ");
        
        return $this->db->get($this->config->item('table_name'));
    }

    // 
    public function get_stat_info_by_band($_data,$_what="",$_filter=array()) { 
        if ($_what=="DUP") {
            $sql = "SELECT `COL_BAND`, count(`COL_CALL`) AS NB FROM (
                        SELECT `COL_BAND`,`COL_CALL`,count(`COL_CALL`) AS `NBCALL` FROM ".$this->config->item('table_name')." 
                        WHERE `station_id` = '".xss_clean($_data['pluginsdata_data']['contest_station_id'])."' 
                            AND `COL_CONTEST_ID` = '".xss_clean($_data['pluginsdata_data']['contest_cl_adif'])."'
                            AND (`COL_TIME_ON` >= '".$_data['pluginsdata_data']['contest_dhStart']."' AND `COL_TIME_OFF` <= '".$_data['pluginsdata_data']['contest_dhEnd']."')
                            GROUP BY `COL_BAND`, `COL_CALL` ) AS T
                    WHERE NBCALL > 1 GROUP BY `COL_BAND`";
            return $this->db->query($sql);
        } else if ($_what=="DUP_LIST") {
            $sql = "SELECT * FROM (
                        SELECT `COL_BAND`,`COL_CALL`,`dxcc_entities`.`name` AS `DXCC_N`,`COL_DXCC`,`COL_CONT`,count(`COL_CALL`) AS `NBCALL` FROM ".$this->config->item('table_name')." 
                        LEFT JOIN `dxcc_entities` ON ".$this->config->item('table_name').".`COL_DXCC` = `dxcc_entities`.`adif`
                        WHERE `COL_DXCC`>0 
                            AND `station_id` = '".xss_clean($_data['pluginsdata_data']['contest_station_id'])."' 
                            AND `COL_CONTEST_ID` = '".xss_clean($_data['pluginsdata_data']['contest_cl_adif'])."'
                            AND (`COL_TIME_ON` >= '".$_data['pluginsdata_data']['contest_dhStart']."' AND `COL_TIME_OFF` <= '".$_data['pluginsdata_data']['contest_dhEnd']."')
                            GROUP BY `COL_BAND`, `COL_CALL` ) AS T
                    WHERE NBCALL > 1 ORDER BY `NBCALL` DESC";
            return $this->db->query($sql);
        } else if ($_what=="PTS_Q") {
            if (isset($_data['pluginsext_row']->pluginsext_params->bddcoluserdef_pts)) { $_bddcoluserdef_pts = "SUM(`".$_data['pluginsext_row']->pluginsext_params->bddcoluserdef_pts."`)"; } else { $_bddcoluserdef_pts = "0"; }
            $sql = " SELECT `COL_BAND`, SUM(`PTS`/`QSO`) AS `NB` FROM (
                        SELECT count(`COL_PRIMARY_KEY`) AS `QSO`, ".$_bddcoluserdef_pts." AS `PTS`, `COL_BAND` FROM ".$this->config->item('table_name')."
                        WHERE `station_id` = '".xss_clean($_data['pluginsdata_data']['contest_station_id'])."' 
                            AND `COL_CONTEST_ID` = '".xss_clean($_data['pluginsdata_data']['contest_cl_adif'])."'
                            AND (`COL_TIME_ON` >= '".$_data['pluginsdata_data']['contest_dhStart']."' AND `COL_TIME_OFF` <= '".$_data['pluginsdata_data']['contest_dhEnd']."')
                            GROUP BY `COL_BAND`) AS T
                    GROUP BY `COL_BAND`";
            return $this->db->query($sql);
        }
        //
        switch($_what) {
            case "QSO":
            case "QSO_OOC":
            case "QSO_OODX":
                $this->db->select('count(COL_PRIMARY_KEY) AS NB, COL_BAND');
                if ($_what=="QSO_OOC") { $this->db->where("COL_CONT != '".$_filter['COL_CONT']."'"); }
                if ($_what=="QSO_OODX") { $this->db->where("COL_DXCC != '".$_filter['COL_DXCC']."'"); }
                $this->db->group_by("COL_BAND");
                break;
            case "CQZ":
                $this->db->select('count(DISTINCT COL_CQZ) as NB, COL_BAND');
                $this->db->group_by("COL_BAND");
                break;
            case "DXC": 
                $this->db->select('count(DISTINCT COL_DXCC) AS NB, COL_BAND');
                $this->db->group_by("COL_BAND");
                break;
            case "DPT":
                $this->db->select('count(DISTINCT COL_SRX_STRING) AS NB, COL_BAND');
                $this->db->group_by("COL_BAND");
                break;                
            case "PTS":
                if (isset($_data['pluginsext_row']->pluginsext_params->bddcoluserdef_pts)) { $_bddcoluserdef_pts = "SUM(`".$_data['pluginsext_row']->pluginsext_params->bddcoluserdef_pts."`)"; } else { $_bddcoluserdef_pts = "0"; }
                $this->db->select($_bddcoluserdef_pts.' AS `NB`, COL_BAND');
                $this->db->group_by("COL_BAND");
                break;
        }
        //$this->db->where($_bddcoluserdef_namecontest, xss_clean($_pluginsdata_data['contest_name'])); // not used //
        $this->db->where('station_id', xss_clean($_data['pluginsdata_data']['contest_station_id']));
        $this->db->where('COL_CONTEST_ID', xss_clean($_data['pluginsdata_data']['contest_cl_adif']));
        $this->db->where(" (COL_TIME_ON >= '".$_data['pluginsdata_data']['contest_dhStart']."' AND COL_TIME_OFF <= '".$_data['pluginsdata_data']['contest_dhEnd']."') ");
        
        return $this->db->get($this->config->item('table_name'));
    }

    //
    public function get_dxcc_info($adif, $col) {
        $query = $this->db->query('SELECT * FROM dxcc_entities WHERE adif = "'.$adif.'" LIMIT 1');
        return $query->row()->$col;
    }
}
