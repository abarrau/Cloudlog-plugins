<?php

/* pluginsext_model.php
 *
 * This model implements external plugin
 *
 */

class Pluginsext_Model extends CI_Model {

    private $table_name = 'pluginsext';
    private $table_name_user = 'pluginsext_users';
    private $table_name_data = 'pluginsext_plugindata';
    
    // return list of all plugin //
    function list_all() {
        return $this->db->get($this->table_name);
    }

    // return list of user
    function list_for_user($userid) {
        $this->db->where('pluginsext_user_id', $this->security->xss_clean($userid));
        $r = $this->db->get($this->table_name_user);
        return $r;
    }
    
    // return one plugin by nameid
    function get_by_nameid($pluginsextnameid) {
        $this->db->where('pluginsext_nameid', $this->security->xss_clean($pluginsextnameid));
        $r = $this->db->get($this->table_name);
        return $r;
    }

    // return one plugin by id
    function get_by_id($id) {
        $this->db->where('pluginsext_id', $this->security->xss_clean($id));
        $r = $this->db->get($this->table_name);
        return $r;
    }

    // return list of plugin by user id
    function get_by_user($user_id,$user_allow=null) {
        $this->security->xss_clean($user_id);
        $sql = 'SELECT m.*, mu.pluginsext_user_allow, mu.pluginsext_params FROM pluginsext m LEFT JOIN pluginsext_users mu ON m.pluginsext_id = mu.pluginsext_id WHERE mu.pluginsext_user_id='.$user_id;
        if (!is_null($user_allow)) { $sql .= ' AND mu.pluginsext_user_allow=\''.$user_allow.'\' '; }
        $r = $this->db->query($sql);
        return $r;
    }
    
    // return param of plugin by id and user id
    function get_params_user_by_id($id, $user_id) {
        $this->db->where('pluginsext_id', $this->security->xss_clean($id));
        $this->db->where('pluginsext_user_id', $this->security->xss_clean($user_id));
        $r = $this->db->get($this->table_name_user);
        return $r;
    }
    

    // set value of param for a plugin by id and user id
    function set_value($id, $user_id, $pluginsext_values) {
        $data['pluginsext_values'] = json_encode($pluginsext_values);
        $this->db->where('pluginsext_id', $id);
        $this->db->where('pluginsext_user_id', $user_id);
        $this->db->update($this->table_name_user, $data); 
    }
    
    // save plugin by id
    function save($fields) {
        $data = array(
            'pluginsext_nameid' => xss_clean($fields['pluginsext_nameid']),
            'pluginsext_name' => xss_clean($fields['pluginsext_name']),
            'pluginsext_allow' => xss_clean($fields['pluginsext_allow']),
            'pluginsext_migration' => $fields['pluginsext_migration'],
        );
        if(isset($fields['pluginsext_info'])) { $data['pluginsext_info'] = xss_clean($fields['pluginsext_info']); }
        if(isset($fields['pluginsext_config'])) { $data['pluginsext_config'] = xss_clean($fields['pluginsext_config']); }
        
        if (isset($fields['pluginsext_id']) && ($fields['pluginsext_id']>0)) {
            $this->db->where('pluginsext_id', xss_clean($fields['pluginsext_id']));
            $this->db->update($this->table_name, $data); 
        } else {
            $this->db->insert($this->table_name, $data);
        }
    }

    // set param for a plugin by id and user id
    function save_params_user($fields, $user_id) {
        $fields = $this->_convertFieldsIsArray2json($fields);
        $data = array(
            'pluginsext_user_allow' => xss_clean($fields['pluginsext_user_allow']),
            'pluginsext_params' => xss_clean($fields['pluginsext_params']),
            'pluginsext_id' => xss_clean($fields['pluginsext_id']),
            'pluginsext_user_id' => xss_clean($user_id),
        );
        $pluginsext_q = $this->get_params_user_by_id($data['pluginsext_id'],$data['pluginsext_user_id']);
        if (isset($pluginsext_q->row()->pluginsext_user_allow)) {
            $this->db->where('pluginsext_id', $data['pluginsext_id']);
            $this->db->where('pluginsext_user_id', $data['pluginsext_user_id']);
            $this->db->update($this->table_name_user, $data); 
        } else {
            $this->db->insert($this->table_name_user, $data);
        }
    }

    // merge list of plugin and allow by users
    function list_merge_data($list_pluginsext, $list_pluginsext_for_user) {
        $alist_pluginsext_for_user = array();
        foreach ($list_pluginsext_for_user->result() as $row) { $alist_pluginsext_for_user[$row->pluginsext_id] = (array)$row; }
        //
        $alist_pluginsext = array();
        foreach ($list_pluginsext->result() as $row) { 
            $arow = (array)$row;
            if (isset($alist_pluginsext_for_user[$row->pluginsext_id])) {
                $arow['pluginsext_user_allow'] = $alist_pluginsext_for_user[$row->pluginsext_id]['pluginsext_user_allow'];
                $arow['pluginsext_params'] = $alist_pluginsext_for_user[$row->pluginsext_id]['pluginsext_params'];
            } else {
                $arow['pluginsext_user_allow'] = 0;
                $arow['pluginsext_params'] = '{}';
            }
            $alist_pluginsext[$arow['pluginsext_nameid']] = (object)$arow;
        }
        ksort($alist_pluginsext);
        return $alist_pluginsext;
    }

    
    // -- DATA --------------------------------------------------- //
    // save data of plugin //
    function save_pluginsdata($fields, $user_id) {
        $fields = $this->_convertFieldsIsArray2json($fields);
        $data = array(
            'pluginsext_id' => xss_clean($fields['pluginsext_id']),
            'pluginsext_user_id' => $user_id,
            'pluginsdata_data' => ((isset($fields['pluginsdata_data']))?xss_clean($fields['pluginsdata_data']):'{}'),
        );
        // TEST du get_data_by_id pour refuser si user et data //
        if (isset($fields['pluginsdata_id']) && ($fields['pluginsdata_id']>0)) {
            $this->db->where('pluginsdata_id', xss_clean($fields['pluginsdata_id']));
            $this->db->update($this->table_name_data, $data); 
        } else {
            $this->db->insert($this->table_name_data, $data);
        }
    }

    // delete data of plugin //
    function delete_pluginsdata($data_id, $user_id) {
        if ($data_id>0) {
            $this->db->where('pluginsdata_id', xss_clean($data_id));
            if ($this->db->delete($this->table_name_data)) return true;
        }
        return false;
    }

    // return one plugin by id
    function get_data_by_id($pluginsdata_id,$pluginsext_id=false) {
        $this->db->where('pluginsdata_id', $this->security->xss_clean($pluginsdata_id));
        if ($pluginsext_id !== FALSE) $this->db->where('pluginsext_id', $this->security->xss_clean($pluginsext_id));
        $this->db->where('pluginsext_user_id', $this->security->xss_clean($this->session->userdata('user_id')));
        $r = $this->db->get($this->table_name_data);
        return $r;
    }

    // return list of data for user
    function get_data_list_for_user($pluginsext_user_id,$pluginsext_id) {
        $this->db->where('pluginsext_user_id', $this->security->xss_clean($pluginsext_user_id));
        $this->db->where('pluginsext_id', $this->security->xss_clean($pluginsext_id));
        $r = $this->db->get($this->table_name_data);
        return $r;
    }

    // -- GENERIC --------------------------------------------------- //
    // search fiedls name with __ and convert to array/json
    private function _convertFieldsIsArray2json($fields) {
        $aSet = array();
        foreach($fields as $f => $fv) {
            if (strpos($f,'__')) {
                $a = explode('__',$f);
                if (!array_key_exists($a[0],$fields)) { $fields[$a[0]] = array(); $aSet[] = $a[0]; }
                $fields[$a[0]][$a[1]] = $fv;
                unset($fields[$f]);
            }
        } 
        foreach($aSet as $v) { $fields[$v] = json_encode($fields[$v]); }
        return $fields;
    }
    
    // convert json to fields
    function convertJson2Fields($array, $jsonField) {
        if (!is_array($jsonField)) { $jsonField = array($jsonField); }
        foreach($jsonField as $jsonFieldName) {
            foreach (json_decode($array[$jsonFieldName],true) as $k=>$v) { $array[$jsonFieldName.'__'.$k] = $v; }
            unset($array[$jsonFieldName]);
        }
        return $array;
    }

    // convert json to fields
    function setArray($aFullEmtpy, $aData, $subarray_name="") {
        if (!empty($subarray_name)) { $subarray_name = $subarray_name."__"; }
        foreach($aData as $_k=>$_v) { $aFullEmtpy[str_replace($subarray_name,"",$_k)] = $_v; }
        return $aFullEmtpy;
    }

    // FUNCTION : convertUrlForMainMenu($url)
    // convert url for javascript or other
    /*function convertUrlForMainMenu($url) {
        $return = $url;
        switch(substr($url,0,2)) {
            case "js":
                $return = 'javascript'.substr($url,2);
                break;
            case "fc":
                $return = ''.substr($url,2);
                break;
        } 
        return $return;
    }*/
}

?>
