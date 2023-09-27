<!-- ADD pluginsext functions (F4ANS) -->
<script>

    // ==== functions ==== //
    // show alert //
    function pluginsext_alert(type,msg) {
        $('#pluginsext_alert').attr('class','alert').html('');
        if (type=='hide') {
            $('#pluginsext_alert').hide(); 
            return;
        }
        if ((msg!="")&&(typeof msg !=="undefined")) { $('#pluginsext_alert').addClass('alert-'+type).html(msg).show(); }
    }
    // convert br to n //
    function pluginsext_br2n(txt) {
        return txt.replaceAll('<br>','\n');
    }
    // add pluginsext menu //
    function pluginsext_add2mainmenu(data) {
        var item = "<a class=\"dropdown-item pluginsext_main_menu_"+data.nameid+"\" href=\""+data.url+"\" title=\""+data.name+"\"> "+data.name+"</a>";
        $(".cl_pluginsext_menu_list").append(item);
        $(".cl_pluginsext_menu").show();
    }
    // add pluginsext info //
    function pluginsext_add_infozone(data) {
        var item = "<div class=\"pluginsext_infozone_"+data.nameid+"\" style=\"display:none;\"></div>";
        $(".cl_pluginsext_info").append(item);
    }
    // ==== var and event ==== //
    // add pluginsext zone to main menu //
    var pluginsext_menu_zone = "<ul class=\"navbar-nav cl_pluginsext_menu\" style=\"display:none;\"><li class=\"nav-item dropdown\"><a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><i class=\"fas fa-cogs\"></i></a><div class=\"dropdown-menu cl_pluginsext_menu_list\" aria-labelledby=\"navbarDropdown\"></div></li></ul>";
    pluginsext_menu_zone += "<div class=\"cl_pluginsext_info\"></div>";
    $('#navbarNav').append(pluginsext_menu_zone);
    // add pluginsext item to account item //
    var pluginsext_menu_account = "<a class=\"dropdown-item\" href=\"<?php echo site_url('pluginsext'); ?>\" title=\"External plugin\"><i class=\"fas fa-cog\"></i> External Plugins</a>";
    $(pluginsext_menu_account).insertAfter('#navbarNav .dropdown-menu .dropdown-item[title=\"Account\"]');
    
    // ====== add pluginsext item to main menu & external javascript ====== //
    <?php 
        if(($this->config->item('use_auth')) && ($this->session->userdata('user_type') >= 2)) {
        if ($this->config->item('pluginsext_allow')) {                
            $CI =& get_instance();
            $CI->load->model('pluginsext_model');
            $pluginsext_q = $CI->pluginsext_model->get_by_user($this->session->userdata('user_id'),1);
            
            if ($pluginsext_q->num_rows() > 0) {
                foreach($pluginsext_q->result_array() as $pluginsext_row) {
                    //echo "/* ARRAY ---------------- "; print_r($pluginsext_row); echo "*/";
                    $pluginsext_config_json = json_decode($pluginsext_row['pluginsext_config']);
                    // Set Info Zone //
                    if (isset($pluginsext_config_json->top_main_add_infozone) && ($pluginsext_config_json->top_main_add_infozone==1)) {
                       echo "\n// ------------- pluginsext ADD info zone : ".$pluginsext_row['pluginsext_nameid']." // \n";
                       echo "pluginsext_add_infozone({'nameid':'".$pluginsext_row['pluginsext_nameid']."','name':'".$pluginsext_row['pluginsext_name']."'}); \n";                     
                    }
                    // add JS //
                    if (isset($pluginsext_config_json->js_include) && ($pluginsext_config_json->js_include==1) && (file_exists(APPPATH.$this->config->item('pluginsext_path').'/'.$pluginsext_row['pluginsext_nameid'].'/views/cl_pluginsext_javascript.php'))) {
                       require_once(APPPATH.$this->config->item('pluginsext_path').'/'.$pluginsext_row['pluginsext_nameid'].'/views/cl_pluginsext_javascript.php');
                    }
                    // Set Main Menu //
                    if (isset($pluginsext_config_json->top_main_add_menu) && ($pluginsext_config_json->top_main_add_menu==1)) {
                        echo "\n// ------------- pluginsext ADD Menu : ".$pluginsext_row['pluginsext_nameid']." // \n";
                        echo "pluginsext_add2mainmenu({'nameid':'".$pluginsext_row['pluginsext_nameid']."','name':'".$pluginsext_row['pluginsext_name']."','url':'".site_url('pluginsext/menu/'.$pluginsext_row['pluginsext_nameid'])."'}); \n"; 
                    }
                } 

            }
        }
    } ?>
</script>
<!-- END pluginsext functions -->