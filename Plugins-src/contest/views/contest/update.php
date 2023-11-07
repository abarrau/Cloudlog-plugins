<?php 
    // Validation Error //
    if (validation_errors()) { echo "<div class=\"alert alert-danger\"><a class=\"close\" data-dismiss=\"alert\">x</a>".validation_errors()."</div>"; }        
    $this->load->helper('form');
?>

<form method="post" action="<?php echo $contest_url2update; ?>" name="pluginsext_<?php echo $pluginsext_row->pluginsext_nameid; ?>" id="pluginsext_<?php echo $pluginsext_row->pluginsext_nameid; ?>" >
        <input type="hidden" name="pluginsext_nameid" value="<?php echo $pluginsext_row->pluginsext_nameid; ?>" />
        <input type="hidden" name="pluginsdata_id" value="<?php echo $pluginsext_row->pluginsdata_id; ?>" />
        <input type="hidden" name="pluginsext_id" value="<?php echo $pluginsext_row->pluginsext_id; ?>" />
    
    <div class="row">
       <div class="col-md">
            <div class="card">
                <div class="card-header"><?php echo $this->lang->line('contest_conf'); ?></div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm-5">
                            <label for="pluginsdata_data__contest_name"><?php echo $this->lang->line('contest_name'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_name)) { $pluginsdata_data->contest_name = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__contest_name" name="pluginsdata_data__contest_name" value="<?php echo $pluginsdata_data->contest_name; ?>" />
                        </div>
                        <div class="form-group col-sm-7">
                            <label for="pluginsdata_data__contest_cl_id"><?php echo $this->lang->line('contest_name_cloudlog'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_cl_id)) { $pluginsdata_data->contest_cl_id = 0; } ?>
                            <select class="custom-select" id="pluginsdata_data__contest_cl_id" name="pluginsdata_data__contest_cl_id" >
                                <?php 
                                echo "<option value=\"0\" ".(($pluginsdata_data->contest_cl_id == 0)?"selected =\"selected\"":"")." > </option>";
                                foreach ($list_cl_contest as $row) { 
                                        echo "<option value=\"".$row['id']."\" ".(($pluginsdata_data->contest_cl_id == $row['id'])?"selected =\"selected\"":"")." >".$row['name'].(($row['active']!=1)?(" (".$this->lang->line('pluginsext_desactive').")"):"")."</option>";
                                } ?>
                            </select>
                        </div>  
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-2">
                            <label class="form-label" for="pluginsdata_data__contest_dateStart"><?php echo $this->lang->line('contest_date_start'); ?></label>
                            <div class="dxatlasdatepicker input-group date" id="pluginsdata_data__contest_dateStart" data-target-input="nearest">
                                <input name="pluginsdata_data__contest_dateStart" type="text" placeholder="DD/MM/YYYY" class="form-control datetimepicker-input" data-target="#pluginsdata_data__contest_dateStart" value="<?php echo $pluginsdata_data->contest_dateStart; ?>"/>
                                <div class="input-group-append"  data-target="#pluginsdata_data__contest_dateStart" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-1">
                            <label for="pluginsdata_data__contest_hourStart">&nbsp;</label>
                            <?php if (!isset($pluginsdata_data->contest_hourStart)) { $pluginsdata_data->contest_hourStart = '00:00'; } ?>
                            <select class="custom-select" style="width:85px!important;" id="pluginsdata_data__contest_hourStart" name="pluginsdata_data__contest_hourStart">
                                <?php for ($h=0;$h<24;$h++) { echo "<option value=\"".(($h<10)?("0".$h):$h).":00\" ".(($pluginsdata_data->contest_hourStart == $h)?"selected =\"selected\"":"")." >".(($h<10)?("0".$h):$h).":00</option>"; } 
                                        echo "<option value=\"23:59\" ".(($pluginsdata_data->contest_hourStart == '23:59')?"selected =\"selected\"":"")." >23:59</option>";
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-1"></div>
                        <div class="form-group col-sm-2">
                            <label class="form-label" for="pluginsdata_data__contest_dateEnd"><?php echo $this->lang->line('contest_date_end'); ?></label>
                            <div class="dxatlasdatepicker input-group date" id="pluginsdata_data__contest_dateEnd" data-target-input="nearest">
                                <input name="pluginsdata_data__contest_dateEnd" type="text" placeholder="DD/MM/YYYY" class="form-control datetimepicker-input" data-target="#pluginsdata_data__contest_dateEnd" value="<?php echo $pluginsdata_data->contest_dateEnd; ?>"/>
                                <div class="input-group-append"  data-target="#pluginsdata_data__contest_dateEnd" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-1">
                            <label for="pluginsdata_data__contest_hourEnd">&nbsp;</label>
                            <?php if (!isset($pluginsdata_data->contest_hourEnd)) { $pluginsdata_data->contest_hourEnd = '00:00'; } ?>
                            <select class="custom-select" style="width:85px!important;" id="pluginsdata_data__contest_hourEnd" name="pluginsdata_data__contest_hourEnd">
                                <?php for ($h=0;$h<24;$h++) { echo "<option value=\"".(($h<10)?("0".$h):$h).":00\" ".(($pluginsdata_data->contest_hourEnd == $h)?"selected =\"selected\"":"")." >".(($h<10)?("0".$h):$h).":00</option>"; } 
                                        echo "<option value=\"23:59\" ".(($pluginsdata_data->contest_hourEnd == '23:59')?"selected =\"selected\"":"")." >23:59</option>";
                                ?>
                            </select>
                        </div>  
                        <div class="form-group col-sm-1"></div>
                        <div class="form-group col-sm-4">
                            <label for="pluginsdata_data__contest_name"><?php echo $this->lang->line('contest_bands'); ?></label>
                            <?php 
                                if (!isset($pluginsdata_data->contest_bands)) { $pluginsdata_data->contest_bands = ""; }
                                $_aContest_bands = explode(",", $pluginsdata_data->contest_bands);
                                $pluginsdata_data->contest_bands = ($pluginsdata_data->contest_bands=="")?$this->lang->line('contest_select_value'):$pluginsdata_data->contest_bands; 
                            ?>
                            <div class="contest_selectBox" data-boxcontent="contest_bands">
                                <select class="custom-select" name="pluginsdata_data__contest_bands"><option><?php echo $pluginsdata_data->contest_bands; ?></option></select>
                                <div class="contest_overSelect"></div>
                            </div>
                            <div class="col-sm-11 dropdown-menu bg-light contest_selectBox_data" data-boxcontent="contest_bands"> <!--id="contest_bands_checkboxes" -->
                                <?php foreach($list_cl_band as $_k=>$_bandgp) {
                                    echo "<label for=\"".strtoupper($_k)."\">".strtoupper($_k)."</label>";
                                    foreach($_bandgp as $_band) { echo "<label for=\"".$_band."\"><input type=\"checkbox\" value=\"".$_band."\" ".((in_array($_band,$_aContest_bands))?"checked":"")." /> ".$_band."</label> "; }
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="pluginsdata_data__contest_station_id"><?php echo $this->lang->line('gen_hamradio_station'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_station_id)) { $pluginsdata_data->contest_station_id = ''; } ?>
                            <select class="custom-select" id="pluginsdata_data__contest_station_id" name="pluginsdata_data__contest_station_id">
                            <?php foreach ($list_cl_stations->result() as $row) {  
                                echo "<option value=\"".$row->station_id."\" ".(($pluginsdata_data->contest_station_id == $row->station_id)?"selected =\"selected\"":"").">".$row->station_profile_name." (".$row->station_city." | ".$row->station_gridsquare.")</option>";
                            } ?>  
                            </select>
                        </div>   
                        <div class="form-group col-sm-1"></div>
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__contest_log_type"><?php echo $this->lang->line('contest_log_type'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_log_type)) { $pluginsdata_data->contest_log_type = ''; } ?>
                            <select class="custom-select" id="pluginsdata_data__contest_log_type" name="pluginsdata_data__contest_log_type">
                                <option value="none" <?php echo (($pluginsdata_data->contest_log_type == "none")?"selected =\"selected\"":""); ?> >-</option>
                                <option value="Edi" <?php echo (($pluginsdata_data->contest_log_type == "Edi")?"selected =\"selected\"":""); ?> >Edi</option>
                                <option value="Cabrillo" <?php echo (($pluginsdata_data->contest_log_type == "Cabrillo")?"selected =\"selected\"":""); ?> >Cabrillo</option>
                            </select>                            
                        </div>                         
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <div class="row">
       <div class="col-md">
            <div class="card">
                <div class="card-header"><?php echo $this->lang->line('contest_conf_score_tab'); ?></div>
                <div class="card-body">
                   <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="pluginsdata_data__contest_score_conf_col"><?php echo $this->lang->line('contest_score_tab_col'); ?></label>
                            <?php 
                                if (!isset($pluginsdata_data->contest_score_conf_col)) { $pluginsdata_data->contest_score_conf_col = "BAND,QSO"; }
                                $_aContest_score_conf_col = explode(",", $pluginsdata_data->contest_score_conf_col);
                                $pluginsdata_data->contest_score_conf_col = ($pluginsdata_data->contest_score_conf_col=="")?$this->lang->line('contest_select_value'):$pluginsdata_data->contest_score_conf_col; 
                            ?>
                            <div class="contest_selectBox" data-boxcontent="contest_score_conf_col">
                                <select class="custom-select" name="pluginsdata_data__contest_score_conf_col"><option><?php echo $pluginsdata_data->contest_score_conf_col; ?></option></select>
                                <div class="contest_overSelect"></div>
                            </div>
                            <div class="dropdown-menu bg-light contest_selectBox_data" style="width:110%;" data-boxcontent="contest_score_conf_col">
                                <?php foreach($list_score_tab_col as $_kcol => $_vcol) { 
                                    echo "<label for=\"".$_kcol."\">
                                            <input type=\"checkbox\" value=\"".$_kcol."\" ".((in_array($_kcol,$_aContest_score_conf_col)||($_vcol['c']===true))?"checked":"")." ".(($_vcol['c']===true)?"disabled":"")." /> 
                                            ".$_kcol." | ".$_vcol['nf']." ".(($_vcol['t']=='i')?"(".$this->lang->line('contest_tooltip').")":"")."</label> "; 
                                } ?>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="pluginsdata_data__contest_score_conf_row"><?php echo $this->lang->line('contest_score_tab_row'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_score_conf_row)) { $pluginsdata_data->contest_score_conf_row = ''; } ?>
                            <select class="custom-select" id="pluginsdata_data__contest_score_conf_row" name="pluginsdata_data__contest_score_conf_row">
                                <?php foreach($list_score_tab_row as $_krow => $_vrow) { echo "<option value=\"".$_krow."\" ".(($pluginsdata_data->contest_score_conf_row == $_krow)?"selected =\"selected\"":"")." >".$_vrow['nf']."</option>"; } ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="pluginsdata_data__contest_score_calcul_point_method"><?php echo $this->lang->line('contest_score_calcul_point_method'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_score_calcul_point_method)) { $pluginsdata_data->contest_score_calcul_point_method = ''; } ?>
                            <select class="custom-select" id="pluginsdata_data__contest_score_calcul_point_method" name="pluginsdata_data__contest_score_calcul_point_method">
                                <option value="0" <?php echo (($pluginsdata_data->contest_score_calcul_point_method == "O")?"selected =\"selected\"":""); ?> >-</option>
                                <?php foreach($list_score_calcul_point_method as $_krow => $_vrow) { echo "<option value=\"".$_krow."\" ".(($pluginsdata_data->contest_score_calcul_point_method == $_krow)?"selected =\"selected\"":"")." >".$_vrow['nf']."</option>"; } ?>
                            </select>
                        </div>                           
    	            </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    
    <div class="row">
       <div class="col-md">
            <div class="card">
                <div class="card-header"><?php echo $this->lang->line('contest_conf_log'); ?><span class="contest_log_type"></span> <a href="javascript:contest_copyFromOther();" class="btn btn-primary contest_log_param_edi contest_btn_log float-right" title="Copy" style="margin-left:10px;display:none;"><i class="fas fa-copy"></i></a></div>
                <!-- ==== None ==== -->
                <div class="card-body contest_log_param contest_log_param_none">
                    <div class="form-row">
                        <label for="pluginsdata_data__contest_log_param_none"><?php echo $this->lang->line('contest_log_select'); ?></label>
                    </div>
                </div>
                <!-- ==== EDI ==== -->
                <div class="card-body contest_log_param contest_log_param_edi" style="display:none;">
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="pluginsdata_data__log_edi_TName"><?php echo $this->lang->line('contest_name'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_TName)) { $pluginsdata_data->log_edi_TName = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_TName" name="pluginsdata_data__log_edi_TName" value="<?php echo $pluginsdata_data->log_edi_TName; ?>" />                   
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__log_edi_PCall"><?php echo $this->lang->line('contest_log_callsign'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_PCall)) { $pluginsdata_data->log_edi_PCall = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_PCall" name="pluginsdata_data__log_edi_PCall" value="<?php echo $pluginsdata_data->log_edi_PCall; ?>" />                    
                        </div>
                        <div class="form-group col-sm-1">&nbsp;</div>
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__log_edi_PSect"><?php echo $this->lang->line('contest_log_sect'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_PSect)) { $pluginsdata_data->log_edi_PSect = ''; } ?>
                            <select class="custom-select" id="pluginsdata_data__log_edi_PSect" name="pluginsdata_data__log_edi_PSect">
                                <?php $_aCategoryItem = array('SINGLE'=>'SINGLE','SINGLE-OP-6H'=>'SINGLE 6 HOURS','SINGLE-OP-MGM'=>'SINGLE with MGM','MULTI'=>'MULTI','MULTI-OP-6H'=>'MULTI 6 HOURS','MULTI-OP-MGM'=>'MULTI with MGM','CHECKLOG'=>'CHECKLOG','SWL'=>'SWL');
                                    foreach ($_aCategoryItem as $_k => $_v) { echo "<option value=\"".$_k."\" ".(($pluginsdata_data->log_edi_PSect == $_k)?"selected =\"selected\"":"")." >".$_v."</option>"; }
                                ?>
                            </select>                        
                        </div>
                        <div class="form-group col-sm-1">&nbsp;</div>
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__log_edi_PExch"><?php echo $this->lang->line('contest_log_exch'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_PExch)) { $pluginsdata_data->log_edi_PExch = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_PExch" name="pluginsdata_data__log_edi_PExch" value="<?php echo $pluginsdata_data->log_edi_PExch; ?>" maxlength="6"/>                   
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-5">
                            <label for="pluginsdata_data__log_edi_PClub"><?php echo $this->lang->line('contest_log_club'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_PClub)) { $pluginsdata_data->log_edi_PClub = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_PClub" name="pluginsdata_data__log_edi_PClub" value="<?php echo $pluginsdata_data->log_edi_PClub; ?>" />                    
                        </div>  
                        <div class="form-group col-sm-7">
                            <label for="pluginsdata_data__log_edi_MOpe1"><?php echo $this->lang->line('contest_log_ops'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_MOpe1)) { $pluginsdata_data->log_edi_MOpe1 = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_MOpe1" name="pluginsdata_data__log_edi_MOpe1" value="<?php echo $pluginsdata_data->log_edi_MOpe1; ?>" />         
                        </div>  
                    </div>
                    <div class="form-row"><div class="form-group" style="border-bottom:1px solid;padding:5px;"><i class="fas fa-broadcast-tower"></i>&nbsp;&nbsp;<?php echo $this->lang->line('contest_log_Pinfos'); ?></div></div>
                    <div class="form-row">
                        <div class="form-group col-sm-7">
                            <label for="pluginsdata_data__log_edi_PAdr1"><?php echo $this->lang->line('contest_log_padr1'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_PAdr1)) { $pluginsdata_data->log_edi_PAdr1 = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_PAdr1" name="pluginsdata_data__log_edi_PAdr1" value="<?php echo $pluginsdata_data->log_edi_PAdr1; ?>" maxlength="68" />                   
                        </div>
                        <div class="form-group col-sm-5">
                            <label for="pluginsdata_data__log_edi_PAdr2"><?php echo $this->lang->line('contest_log_padr2'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_PAdr2)) { $pluginsdata_data->log_edi_PAdr2 = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_PAdr2" name="pluginsdata_data__log_edi_PAdr2" value="<?php echo $pluginsdata_data->log_edi_PAdr2; ?>" maxlength="68" />                  
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-5">
                            <label for="pluginsdata_data__log_edi_STXEq"><?php echo $this->lang->line('contest_log_equip'); ?> (TX)</label>
                            <?php if (!isset($pluginsdata_data->log_edi_STXEq)) { $pluginsdata_data->log_edi_STXEq = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_STXEq" name="pluginsdata_data__log_edi_STXEq" value="<?php echo $pluginsdata_data->log_edi_STXEq; ?>" maxlength="68" />                    
                        </div>  
                        <div class="form-group col-sm-5">
                            <label for="pluginsdata_data__log_edi_SRXEq"><?php echo $this->lang->line('contest_log_equip'); ?> (RX)</label>
                            <?php if (!isset($pluginsdata_data->log_edi_SRXEq)) { $pluginsdata_data->log_edi_SRXEq = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_SRXEq" name="pluginsdata_data__log_edi_SRXEq" value="<?php echo $pluginsdata_data->log_edi_SRXEq; ?>" maxlength="68" />         
                        </div>  
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__log_edi_SPowe"><?php echo $this->lang->line('contest_log_power'); ?> (W)</label>
                            <?php if (!isset($pluginsdata_data->log_edi_SPowe)) { $pluginsdata_data->log_edi_SPowe = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_SPowe" name="pluginsdata_data__log_edi_SPowe" value="<?php echo $pluginsdata_data->log_edi_SPowe; ?>" maxlength="68" />         
                        </div>  
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-5">
                            <label for="pluginsdata_data__log_edi_SAnte"><?php echo $this->lang->line('contest_log_antenna'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_SAnte)) { $pluginsdata_data->log_edi_SAnte = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_SAnte" name="pluginsdata_data__log_edi_SAnte" value="<?php echo $pluginsdata_data->log_edi_SAnte; ?>" maxlength="68" />                    
                        </div>  
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__log_edi_SAntH1"><?php echo $this->lang->line('contest_log_antenna_h1'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_SAntH1)) { $pluginsdata_data->log_edi_SAntH1 = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_SAntH1" name="pluginsdata_data__log_edi_SAntH1" value="<?php echo $pluginsdata_data->log_edi_SAntH1; ?>" maxlength="44" />         
                        </div>  
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__log_edi_SAntH2"><?php echo $this->lang->line('contest_log_antenna_h2'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_SAntH2)) { $pluginsdata_data->log_edi_SAntH2 = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_SAntH2" name="pluginsdata_data__log_edi_SAntH2" value="<?php echo $pluginsdata_data->log_edi_SAntH2; ?>" maxlength="44" />         
                        </div>  
                    </div>
                    <div class="form-row"><div class="form-group" style="border-bottom:1px solid;padding:5px;"><i class="fas fa-user"></i>&nbsp;&nbsp;<?php echo $this->lang->line('contest_log_Presp'); ?></div></div>
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="pluginsdata_data__log_edi_RName"><?php echo $this->lang->line('contest_log_rname'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_RName)) { $pluginsdata_data->log_edi_RName = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_RName" name="pluginsdata_data__log_edi_RName" value="<?php echo $pluginsdata_data->log_edi_RName; ?>" maxlength="68" />                   
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__log_edi_RCall"><?php echo $this->lang->line('contest_log_rcallsign'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_RCall)) { $pluginsdata_data->log_edi_RCall = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_RCall" name="pluginsdata_data__log_edi_RCall" value="<?php echo $pluginsdata_data->log_edi_RCall; ?>" maxlength="68" />              
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__log_edi_RPhon"><?php echo $this->lang->line('contest_log_rphone'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_RPhon)) { $pluginsdata_data->log_edi_RPhon = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_RPhon" name="pluginsdata_data__log_edi_RPhon" value="<?php echo $pluginsdata_data->log_edi_RPhon; ?>" maxlength="68" />              
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="pluginsdata_data__log_edi_RHBBS"><?php echo $this->lang->line('contest_log_remail'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_RHBBS)) { $pluginsdata_data->log_edi_RHBBS = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_RHBBS" name="pluginsdata_data__log_edi_RHBBS" value="<?php echo $pluginsdata_data->log_edi_RHBBS; ?>" maxlength="68" />              
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="pluginsdata_data__log_edi_RAdr1"><?php echo $this->lang->line('contest_log_radr1'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_RAdr1)) { $pluginsdata_data->log_edi_RAdr1 = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_RAdr1" name="pluginsdata_data__log_edi_RAdr1" value="<?php echo $pluginsdata_data->log_edi_RAdr1; ?>" maxlength="68" />                   
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="pluginsdata_data__log_edi_RAdr3"><?php echo $this->lang->line('contest_log_radr2'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_RAdr2)) { $pluginsdata_data->log_edi_RAdr2 = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_RAdr2" name="pluginsdata_data__log_edi_RAdr2" value="<?php echo $pluginsdata_data->log_edi_RAdr2; ?>" maxlength="68" />                  
                        </div>
                        <div class="form-group col-sm-1">
                            <label for="pluginsdata_data__log_edi_RPoCo"><?php echo $this->lang->line('contest_log_rpostcode'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_RPoCo)) { $pluginsdata_data->log_edi_RPoCo = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_RPoCo" name="pluginsdata_data__log_edi_RPoCo" value="<?php echo $pluginsdata_data->log_edi_RPoCo; ?>" maxlength="68" />                  
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__log_edi_RCity"><?php echo $this->lang->line('contest_log_rcity'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_RCity)) { $pluginsdata_data->log_edi_RCity = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_RCity" name="pluginsdata_data__log_edi_RCity" value="<?php echo $pluginsdata_data->log_edi_RCity; ?>" maxlength="68" />                  
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__log_edi_RCoun"><?php echo $this->lang->line('contest_log_rcountry'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_RCoun)) { $pluginsdata_data->log_edi_RCoun = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__log_edi_RCoun" name="pluginsdata_data__log_edi_RCoun" value="<?php echo $pluginsdata_data->log_edi_RCoun; ?>" maxlength="68" />                  
                        </div>                        
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="pluginsdata_data__log_edi_remarks"><?php echo $this->lang->line('contest_log_remarks'); ?></label>
                            <?php if (!isset($pluginsdata_data->log_edi_remarks)) { $pluginsdata_data->log_edi_remarks = ''; } ?>
                            <textarea type="text" class="form-control" id="pluginsdata_data__log_edi_remarks" name="pluginsdata_data__log_edi_remarks" rows="4"><?php echo $pluginsdata_data->log_edi_remarks; ?></textarea>
                        </div>
                    </div>
                    <div class="form-row"><div class="form-group" style="border-bottom:1px solid;padding:5px;"><i class="fas fa-times"></i>&nbsp;&nbsp;<?php echo $this->lang->line('contest_conf_multi'); ?></div></div>
                    <div class="form-row">
                        <div class="form-group col-sm-12 contest_bands_multi_list">
                            <?php 
                                /* // NOT USED (defined in static array) // echo "<b>".$this->lang->line('contest_bands')." :</b> ";
                                $_aContest_bands = explode(",", $pluginsdata_data->contest_bands);
                                foreach ($_aContest_bands as $_band) {
                                    eval('if (isset($pluginsdata_data->contest_bands_multi_'.$_band.')) { $_contest_bands_multi = $pluginsdata_data->contest_bands_multi_'.$_band.'; } else { $_contest_bands_multi = "1"; }');
                                    echo "<label for=\"pluginsdata_data__contest_bands_multi_".$_band."\">".$_band." : <input type=\"text\" value=\"".$_contest_bands_multi."\" id=\"pluginsdata_data__contest_bands_multi_".$_band."\" name=\"pluginsdata_data__contest_bands_multi_".$_band."\" style=\"margin:0px 5px;padding:0.375rem 0.75rem;width:60px;\"/></label> ";
                            	} echo "<br/>"; */
                            	if (!isset($pluginsdata_data->contest_gridsquare_multi)) { $pluginsdata_data->contest_gridsquare_multi = '1'; }
                            	echo "Locator : <input type=\"text\" value=\"".$pluginsdata_data->contest_gridsquare_multi."\" id=\"pluginsdata_data__contest_gridsquare_multi\" name=\"pluginsdata_data__contest_gridsquare_multi\" style=\"margin:0px 30px 0px 5px;padding:0.375rem 0.75rem;width:60px;\"/></label>";
                                if (!isset($pluginsdata_data->contest_exchange_multi)) { $pluginsdata_data->contest_exchange_multi = '1'; }
                                echo "Exchange : <input type=\"text\" value=\"".$pluginsdata_data->contest_exchange_multi."\" id=\"pluginsdata_data__contest_exchange_multi\" name=\"pluginsdata_data__contest_exchange_multi\" style=\"margin:0px 30px 0px 5px;padding:0.375rem 0.75rem;width:60px;\"/></label>";
                                if (!isset($pluginsdata_data->contest_dxcc_multi)) { $pluginsdata_data->contest_dxcc_multi = '1'; }
                                echo "DXCC : <input type=\"text\" value=\"".$pluginsdata_data->contest_dxcc_multi."\" id=\"pluginsdata_data__contest_dxcc_multi\" name=\"pluginsdata_data__contest_dxcc_multi\" style=\"margin:0px 30px 0px 5px;padding:0.375rem 0.75rem;width:60px;\"/></label>";
                            ?>                                
                        </div>
                    </div>
				</div>
                <!-- ==== Cabrillo ==== -->
                <div class="card-body contest_log_param contest_log_param_cabrillo" style="display:none;">
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="pluginsdata_data__contest_log_param_cabrillo"><?php echo $this->lang->line('contest_log_use_cabrillo_cloudlog'); ?></label>
                        </div>
                    </div>
                    <!--<div class="form-row">
                        <div class="form-group col-sm-3">
                            <label for="pluginsdata_data__contest_log_name"><?php echo $this->lang->line('contest_name'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_log_name)) { $pluginsdata_data->contest_log_name = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__contest_log_name" name="pluginsdata_data__contest_log_name" value="<?php echo $pluginsdata_data->contest_log_name; ?>" />                   
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__contest_log_callsign"><?php echo $this->lang->line('contest_log_callsign'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_log_callsign)) { $pluginsdata_data->contest_log_callsign = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__contest_log_callsign" name="pluginsdata_data__contest_log_callsign" value="<?php echo $pluginsdata_data->contest_log_callsign; ?>" />                        
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="pluginsdata_data__contest_log_club"><?php echo $this->lang->line('contest_log_club'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_log_club)) { $pluginsdata_data->contest_log_club = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__contest_log_club" name="pluginsdata_data__contest_log_club" value="<?php echo $pluginsdata_data->contest_log_club; ?>" />                        
                        </div>  
                        <div class="form-group col-sm-4">
                            <label for="pluginsdata_data__contest_log_ops"><?php echo $this->lang->line('contest_log_ops'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_log_ops)) { $pluginsdata_data->contest_log_ops = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__contest_log_ops" name="pluginsdata_data__contest_log_ops" value="<?php echo $pluginsdata_data->contest_log_ops; ?>" />                        
                        </div>  
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__contest_log_cat_ope"><?php echo $this->lang->line('contest_log_cat_ope'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_log_cat_ope)) { $pluginsdata_data->contest_log_cat_ope = '00'; } ?>
                            <select class="custom-select" id="pluginsdata_data__contest_log_cat_ope" name="pluginsdata_data__contest_log_cat_ope">
                                <?php $_aCategoryItem = array('SINGLE-OP','MULTI-OP','CHECKLOG');
                                    foreach ($_aCategoryItem as $_item) { echo "<option value=\"".$_item."\" ".(($pluginsdata_data->contest_log_cat_ope == $_item)?"selected =\"selected\"":"")." >".$_item."</option>"; }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__contest_log_cat_assist"><?php echo $this->lang->line('contest_log_cat_assist'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_log_cat_assist)) { $pluginsdata_data->contest_log_cat_assist = ''; } ?>
                            <select class="custom-select" id="pluginsdata_data__contest_log_cat_assist" name="pluginsdata_data__contest_log_cat_assist">
                                <?php $_aCategoryItem = array('NON-ASSISTED','ASSISTED');
                                    foreach ($_aCategoryItem as $_item) { echo "<option value=\"".$_item."\" ".(($pluginsdata_data->contest_log_cat_assist == $_item)?"selected =\"selected\"":"")." >".$_item."</option>"; }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__contest_log_cat_trans"><?php echo $this->lang->line('contest_log_cat_trans'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_log_cat_trans)) { $pluginsdata_data->contest_log_cat_trans = ''; } ?>
                            <select class="custom-select" id="pluginsdata_data__contest_log_cat_trans" name="pluginsdata_data__contest_log_cat_trans">
                                <?php $_aCategoryItem = array('ONE','TWO','UNLIMITED');
                                    foreach ($_aCategoryItem as $_item) { echo "<option value=\"".$_item."\" ".(($pluginsdata_data->contest_log_cat_trans == $_item)?"selected =\"selected\"":"")." >".$_item."</option>"; }
                                ?>
                            </select>
                        </div>  
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__contest_log_cat_trans"><?php echo $this->lang->line('contest_log_cat_trans'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_log_cat_trans)) { $pluginsdata_data->contest_log_cat_trans = ''; } ?>
                            <select class="custom-select" id="pluginsdata_data__contest_log_cat_trans" name="pluginsdata_data__contest_log_cat_trans">
                                <?php $_aCategoryItem = array('ONE','TWO','UNLIMITED');
                                    foreach ($_aCategoryItem as $_item) { echo "<option value=\"".$_item."\" ".(($pluginsdata_data->contest_log_cat_trans == $_item)?"selected =\"selected\"":"")." >".$_item."</option>"; }
                                ?>
                            </select>
                        </div>  
                    </div>-->
                </div>
            </div>
        </div>
    </div>
    <br/>
    
    <div class="row">
       <div class="col-md">
            <div class="card">
                <div class="card-header"><?php echo $this->lang->line('contest_conf_offical_result'); ?> <a class="btn btn-primary btn-sm pe_contest_btn_category_add float-right" title="<?php echo $this->lang->line('contest_score_category_add'); ?>" style="margin-left:10px;"><i class="fas fa-plus"></i>&nbsp; <?php echo $this->lang->line('contest_score_category_add'); ?></a></div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm-10">
                            <label for="pluginsdata_data__contest_score_url"><?php echo $this->lang->line('contest_score_url'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_score_url)) { $pluginsdata_data->contest_score_url = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__contest_score_url" name="pluginsdata_data__contest_score_url" value="<?php echo $pluginsdata_data->contest_score_url; ?>" />
                        </div> 
                    </div>
                    <div class="form-row contest_score_category" data-categoryid="1">
                        <div class="form-group col-sm-5">
                            <label for="pluginsdata_data__contest_score_category"><?php echo $this->lang->line('contest_score_category'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_score_category_1)) { $pluginsdata_data->contest_score_category_1 = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__contest_score_category_1" name="pluginsdata_data__contest_score_category_1" value="<?php echo $pluginsdata_data->contest_score_category_1; ?>" />
                        </div> 
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__contest_score_position"><?php echo $this->lang->line('contest_score_position'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_score_position_1)) { $pluginsdata_data->contest_score_position_1 = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__contest_score_position_1" name="pluginsdata_data__contest_score_position_1" value="<?php echo $pluginsdata_data->contest_score_position_1; ?>" />
                        </div> 
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__contest_score_nbparticipant"><?php echo $this->lang->line('contest_score_nbparticipant'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_score_nbparticipant_1)) { $pluginsdata_data->contest_score_nbparticipant_1 = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__contest_score_nbparticipanty_1" name="pluginsdata_data__contest_score_nbparticipant_1" value="<?php echo $pluginsdata_data->contest_score_nbparticipant_1; ?>" />
                        </div> 
                        <div class="form-group col-sm-2">
                            <label for="pluginsdata_data__contest_score_finalscore"><?php echo $this->lang->line('contest_conf_offical_result'); ?></label>
                            <?php if (!isset($pluginsdata_data->contest_score_finalscore_1)) { $pluginsdata_data->contest_score_finalscore_1 = ''; } ?>
                            <input type="text" class="form-control" id="pluginsdata_data__contest_score_finalscore_1" name="pluginsdata_data__contest_score_finalscore_1" value="<?php echo $pluginsdata_data->contest_score_finalscore_1; ?>" />
                        </div> 
                    </div>
                    <?php 
                        for ($i=2; $i<=10; $i++) {
                            eval('if (isset($pluginsdata_data->contest_score_category_'.$i.')) { 
                                echo "<div class=\"form-row contest_score_category\" data-categoryid=\"'.$i.'\">";
                                echo "<div class=\"form-group col-sm-5\"><input type=\"text\" class=\"form-control\" id=\"pluginsdata_data__contest_score_category_'.$i.'\" name=\"pluginsdata_data__contest_score_category_'.$i.'\" value=\"".$pluginsdata_data->contest_score_category_'.$i.'."\" /></div>";
                                echo "<div class=\"form-group col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"pluginsdata_data__contest_score_position_'.$i.'\" name=\"pluginsdata_data__contest_score_position_'.$i.'\" value=\"".$pluginsdata_data->contest_score_position_'.$i.'."\" /></div>";
                                echo "<div class=\"form-group col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"pluginsdata_data__contest_score_nbparticipant_'.$i.'\" name=\"pluginsdata_data__contest_score_nbparticipant_'.$i.'\" value=\"".$pluginsdata_data->contest_score_nbparticipant_'.$i.'."\" /></div>";
                                echo "<div class=\"form-group col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"pluginsdata_data__contest_score_finalscore_'.$i.'\" name=\"pluginsdata_data__contest_score_finalscore_'.$i.'\" value=\"".$pluginsdata_data->contest_score_finalscore_'.$i.'."\" /></div>";
                                echo "<div class=\"form-group col-sm-1\"><a href=\"javascript:contest_category_delete('.$i.');\" class=\"btn btn-danger btn-sm\" title=\"\"><i class=\"fas fa-trash-alt\"></i></a></div>";
                                echo "</div>"; }');
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <br/>
    
    <div class="row">
       <div class="col-md">
            <div class="card">
                <div class="card-header"><?php echo $this->lang->line('contest_conf_other'); ?></div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm-3">
                            <label for="pluginsext_params__calcul_pts"><?php echo $this->lang->line('contest_other_update_pts'); ?></label><br/>
                            <a class="btn btn-info pe_contest_btn_calcul_pts" style="cursor:pointer;"><i class="fas fa-tasks"></i> <?php echo $this->lang->line('pluginsext_update'); ?></a>
                        </div>
                        <div class="form-group col-sm-3"><label>&nbsp;</label><br/><span class="contest_listinfo_nbv" style="display:none;"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>

	<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <?php echo $this->lang->line('pluginsext_save'); ?></button>&nbsp;&nbsp;
    <a href="javascript:contest_back();" class="btn btn-danger"><i class="far fa-times-circle"></i> <?php echo $this->lang->line('pluginsext_cancel'); ?></a>
</form>
<br/>

<style>
.contest_selectBox { position: relative; }
.contest_overSelect { position: absolute; left:0;right:0; top:0; bottom:0; }
.contest_selectBox_data { display: none; position:absolute; z-index:50; left:initial; padding:5px 15px; }
.contest_selectBox_data label { display: block; margin-bottom:0px!important; }
.contest_selectBox_data input { margin-right:5px; }
</style>
