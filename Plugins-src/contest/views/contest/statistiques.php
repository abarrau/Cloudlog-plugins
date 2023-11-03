
<div class="form-row">
    <div class="card col-md-12" style="padding:0px!important;">
        <div class="card-header"><?php echo $this->lang->line('general_word_info'); ?> <a href="<?php echo $pluginsext_url2menu."/update/".$pluginsext_row->pluginsdata_id; ?>" class="btn btn-primary btn-sm float-right" title="Edit"><i class="fas fa-edit"></i></a></div>
        <div class="card-body">
            <div class="form-row"><div class="col-sm-3"><?php echo $this->lang->line('contest_name'); ?> :</div><div class="col-sm-9"><?php echo $pluginsdata_data['contest_name']; ?>&nbsp; <br/><span style="font-size:85%;font-style:italic;">(<?php echo $pluginsdata_data['contest_cl_n']; ?>)</span></div></div>
            <div class="form-row"><div class="col-sm-3"><?php echo $this->lang->line('contest_date'); ?> :</div><div class="col-sm-9"><?php echo $pluginsdata_data['contest_dhStart']." - ".$pluginsdata_data['contest_dhEnd']; ?></div></div>
            <div class="form-row"><div class="col-sm-3"><?php echo $this->lang->line('gen_hamradio_station'); ?> :</div><div class="col-sm-9"><?php echo $pluginsdata_data['contest_station']; ?></div></div>
            
        </div>
    </div>
</div>

<div class="form-row" style="margin-top:15px;">
    <div class="card col-md-12" style="padding:0px!important;">
        <div class="card-header contest_titlezone"><i class="fas fa-globe"></i>&nbsp;&nbsp;<?php echo $this->lang->line('contest_stat_global'); ?><span class="contest_elapse_zone float-right"><i class="fas fa-caret-down"></i></span></div>
        <div class="card-body" >
            <div class="form-row">
                <div class="col-sm-1"><i class="fas fa-clock" style="font-size:200%;padding-top:10px;"></i></div>
                <div class="col-sm-2" style="text-align:center;"><?php echo "<span class=\"contest_labelinfo\">".$this->lang->line('contest_duration')."</span><br/>";
                    $pe_min = floor(($pluginsdata_data['contest_duration']/60)%60);
                    echo (floor($pluginsdata_data['contest_duration']/3600)."h".(($pe_min<10)?("0".$pe_min):$pe_min)); ?>
                </div>
                <div class="col-sm-2" style="text-align:center;"><?php echo "<span class=\"contest_labelinfo\">".$this->lang->line('contest_active')."</span><br/>";
                    echo gmdate("H\hi", $pluginsdata_data['duration_activity'])."&nbsp;&nbsp;";
                    echo "<span class=\"contest_valueinfo\">(".(round(intval($pluginsdata_data['duration_activity'])*100/intval($pluginsdata_data['contest_duration']),1))."%)</span>";?>
                </div>
                <div class="col-sm-2" style="text-align:center;"><?php echo "<span class=\"contest_labelinfo\">".$this->lang->line('contest_inactive')."</span><br/>";
                    $pe_duration_inactivity = $pluginsdata_data['contest_duration'] - $pluginsdata_data['duration_activity'];
                    $pe_duration_inactivity_min = floor(($pe_duration_inactivity/60)%60);
                    echo (floor($pe_duration_inactivity/3600)."h".(($pe_duration_inactivity_min<10)?("0".$pe_duration_inactivity_min):$pe_duration_inactivity_min)). "&nbsp;&nbsp;";
                    echo "<span class=\"contest_valueinfo\">(".(round(intval($pe_duration_inactivity)*100/intval($pluginsdata_data['contest_duration']),1))."%)</span>";?>        
                </div>
                <div class="col-sm-2" style="text-align:center;"><?php $pe_contest_period = $pluginsext_row->pluginsext_params->contest_period_timeplotter;
                    echo "<span class=\"contest_labelinfo\">".$this->lang->line('contest_qso_by_hour')." "; echo ($pe_contest_period!=60)?("(".$pe_contest_period."mins)"):""; echo "</span><br/>";
                    echo round((($pluginsdata_data['list_info']['qso_nb']/($pluginsdata_data['duration_activity']/60))*60),1);
                    echo ($pe_contest_period!=60)?(" (".round((($pluginsdata_data['list_info']['qso_nb']/($pluginsdata_data['duration_activity']/60))*$pe_contest_period),1).")"):"";
                    ?>        
                </div>
                <div class="col-sm-2" style="text-align:center;"><?php 
                    echo "<span class=\"contest_labelinfo\">".$this->lang->line('contest_inactive')."<>2 QSO</span><br/>";
                    echo round((($pluginsdata_data['duration_activity']/60)/$pluginsdata_data['list_info']['qso_nb']),2)." mins";
                    ?>        
                </div>
            </div> 
            <div class="form-row" style="margin-top:15px;">
                <div class="col-sm-1"><i class="fas fa-list-ol" style="font-size:200%;padding-top:5px;"></i></div>
                <div class="col-sm-2" style="text-align:center;"><?php echo "<span class=\"contest_labelinfo\">QSO</span><br/>".$pluginsdata_data['list_info']['qso_nb']."</span>"; ?></div>
                <div class="col-sm-2" style="text-align:center;"><?php echo "<span class=\"contest_labelinfo\">".$this->lang->line('gen_hamradio_dxcc')."</span><br/>".$pluginsdata_data['list_info']['dxcc']." <span class=\"contest_valueinfo\" title=\"".$this->lang->line('contest_new')."\">(".count($pluginsdata_data['list_info']['dxcc_new_list']).")</span>"; ?></div>
                <div class="col-sm-2" style="text-align:center;"><?php echo "<span class=\"contest_labelinfo\">".$this->lang->line('gen_hamradio_cq_zone')."</span><br/>".$pluginsdata_data['list_info']['cqz']." <span class=\"contest_valueinfo\" title=\"".$this->lang->line('contest_new')."\">(".count($pluginsdata_data['list_info']['cqz_new_list']).")</span>"; ?></div>
                
            </div>
            <div class="form-row" style="margin-top:15px;">
                <div class="col-sm-1"><i class="fas fa-check-double" style="font-size:200%;padding-top:10px;"></i></div>
                <div class="col-sm-2" style="text-align:center;"><?php echo "<span class=\"contest_labelinfo\">QSO ".$this->lang->line('general_word_confirmed')."</span><br/>".$pluginsdata_data['list_info']['qso_valid'];
                echo " <span class=\"contest_valueinfo\">(".(round(intval($pluginsdata_data['list_info']['qso_valid'])*100/intval($pluginsdata_data['list_info']['qso_nb']),1))."%)</span>"; ?></div>
                <div class="col-sm-2" style="text-align:center;"><?php echo "<span class=\"contest_labelinfo\">".$this->lang->line('contest_best_distance')."</span><br/>".$pluginsdata_data['list_info']['best_dist_row']->COL_DISTANCE." ".$pluginsdata_data['measurement_base']." <span class=\"contest_valueinfo\">(<a id=\"edit_qso\" href=\"javascript:displayQso(".$pluginsdata_data['list_info']['best_dist_row']->COL_PRIMARY_KEY.");\">".str_replace("0","&Oslash;",strtoupper($pluginsdata_data['list_info']['best_dist_row']->COL_CALL))."</a>)</span>"; ?></div>
            </div> 
            <?php  if (count($pluginsdata_data['list_info']['dxcc_new_list'])>0) {  
                    echo "<div class=\"form-row\" style=\"margin-top:15px;\">
                            <div class=\"col-sm-1\"></div>
                            <div class=\"col-sm-2\"><span class=\"contest_labelinfo\">".$this->lang->line('contest_new')." ".$this->lang->line('gen_hamradio_dxcc')."</span> :</div>
                            <div class=\"col-sm-8\">"; foreach($pluginsdata_data['list_info']['dxcc_new_list'] as $pe_dxcc) { echo ucfirst(strtolower($pe_dxcc->name))." <span class=\"contest_valueinfo\">(".$pe_dxcc->COL_DXCC.")</span>, "; } 
                            echo "</div>
                    </div>";
            } ?>
            <?php  if (count($pluginsdata_data['list_info']['cqz_new_list'])>0) { 
                    echo "<div class=\"form-row\" style=\"margin-top:15px;\">
                            <div class=\"col-sm-1\"></div>
                            <div class=\"col-sm-2\"><span class=\"contest_labelinfo\">".$this->lang->line('contest_new')." ".$this->lang->line('gen_hamradio_cq_zone')."</span> :</div>
                            <div class=\"col-sm-8\">"; foreach($pluginsdata_data['list_info']['cqz_new_list'] as $pe_cqz) { echo $pe_cqz->COL_CQZ.", "; } 
                            echo "</div>
                    </div>";
            } ?>
    	</div>
    </div>
</div>

<div class="form-row" style="margin-top:15px;">
    <div class="card col-md-12" style="padding:0px!important;">
        <div class="card-header contest_titlezone"><i class="fas fas fa-trophy"></i>&nbsp;&nbsp;<?php echo $this->lang->line('contest_conf_offical_result'); ?><span class="contest_elapse_zone float-right"><i class="fas fa-caret-down"></i></span></div>
        <div class="card-body">
            <div class="contest_not_result_yet"><?php echo $this->lang->line('contest_not_result_yet'); ?></div>
    		<?php for ($i=1; $i<=10; $i++) {
    			eval('if (isset($pluginsdata_data["contest_score_category_'.$i.'"]) && ($pluginsdata_data["contest_score_category_'.$i.'"]!="")) { 
    				echo "<div class=\"form-row contest_score_by_category\">";
                    echo "<div class=\"col-sm-5\" style=\"font-weight:bold;\">".$pluginsdata_data["contest_score_category_'.$i.'"]."</div>";
                    echo "<div class=\"col-sm-3\">".$this->lang->line("contest_score_position")." : ".$pluginsdata_data["contest_score_position_'.$i.'"]." / ".$pluginsdata_data["contest_score_nbparticipant_'.$i.'"]." <span style=\"font-size:80%;font-style:italic;\">(".round((intval($pluginsdata_data[\'contest_score_position_'.$i.'\'])*100/intval($pluginsdata_data[\'contest_score_nbparticipant_'.$i.'\'])),1)."%)</span></div>";
                    echo "<div class=\"col-sm-3\">".$this->lang->line("contest_score")." : ".$pluginsdata_data["contest_score_finalscore_'.$i.'"]."</div>";
                    echo "</div>";
                } else if (isset($pluginsdata_data["contest_score_position_'.$i.'"]) && ($pluginsdata_data["contest_score_position_'.$i.'"]!="")) { 
                    echo "<div class=\"form-row\">".$pluginsdata_data["contest_score_position_'.$i.'"]."</div>";
                } ');
            } ?>
            <?php if (substr($pluginsdata_data['contest_cl_adif'],0,5)=="CQ-WW") {
                echo "<div class=\"contest_cqww_info\" style=\"display:none;\" data-call=\"".$pluginsdata_data['contest_operator_callsign']."\" data-year=\"".date('Y',strtotime($pluginsdata_data['contest_dateStart']))."\"></div>";
            } ?>
    	</div>
    </div>
</div>

<div class="form-row" style="margin-top:15px;">
    <div class="card col-md-12" style="padding:0px!important;">
    	<div class="card-header contest_titlezone"><i class="fas fa-calculator"></i>&nbsp;&nbsp;<?php echo $this->lang->line('contest_score_synth'); ?><span class="contest_elapse_zone float-right"><i class="fas fa-caret-down"></i></span></div>
        <div class="card-body">
            <div class="form-row" style="text-align:center;">
				<table class="table table-sm table-striped pe_contest_score_array" data-update="0"></table>
                <div class="pe_contest_score_final" style="text-align:center;width:100%;"><?php echo $this->lang->line('contest_score_finalscore'); ?> : <span>0</span></div>
            </div>
    	</div>
    </div>
</div>

<div class="form-row" style="margin-top:15px;">
    <div class="card col-md-12" style="padding:0px!important;">
    	<div class="card-header contest_titlezone"><i class="fas fa-hourglass-half"></i>&nbsp;&nbsp;<?php echo $this->lang->line('contest_stat_bytime')." (".$pluginsext_row->pluginsext_params->contest_period_timeplotter."mins)"; ?><span class="contest_elapse_zone float-right"><i class="fas fa-caret-down"></i></span></div>
        <div class="card-body">
            <div class="form-row">
            	<div id="pe_contest_timeplotter_view" class="col-sm-12"></div>
            	<div id="pe_contest_timeplotter_data" style="display:none;"><?php echo $pluginsdata_data["contest_timeplotter"]; ?></div>
            </div>
    	</div>
    </div>
</div>

<div class="form-row" style="margin-top:15px;">
    <div class="card col-md-12" style="padding:0px!important;">
        <div class="card-header contest_titlezone"><i class="fas fa-users"></i>&nbsp;&nbsp;<?php echo $this->lang->line('contest_dup'); ?><span class="contest_elapse_zone float-right"><i class="fas fa-caret-down"></i></span></div>
        <div class="card-body">
            <div class="form-row">
                <table id="contest_list_dup_qso_table" class="table table-sm table-striped contacttable table-hover">
                    <thead>
                        <tr class="titles bg-light" style="color:var(--dark);">
                            <th><?php echo $this->lang->line('gen_hamradio_band'); ?></th>
                            <th><?php echo $this->lang->line('gen_hamradio_call'); ?></th>
                            <th><?php echo $this->lang->line('gen_hamradio_dxcc'); ?></th>
                            <th><?php echo $this->lang->line('gen_hamradio_continent'); ?></th>
                            <th><?php echo $this->lang->line('contest_nb_qso'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($score['list_dup'] as $row) {  ?>
                        <tr class="contest_qso_one" >
                            <td><?php echo $row->COL_BAND; ?></td>
                            <td><a id="edit_qso" href="#"><?php echo str_replace("0","&Oslash;",strtoupper($row->COL_CALL)); ?></a></td>
                            <td><?php echo ucfirst(strtolower($row->DXCC_N))." (".$row->COL_DXCC.")"; ?></td>
                            <td><?php echo $row->COL_CONT; ?></td>
                            <td><?php echo $row->NBCALL; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br/>
<a href="<?php echo $pluginsext_url2menu; ?>" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i> <?php echo $this->lang->line('pluginsext_back'); ?></a>
<input type="hidden" name="pluginsdata_id" id="pluginsdata_id" value="<?php echo $pluginsext_row->pluginsdata_id; ?>" />

<br/>
<style>
    .contest_valueinfo { font-size:80%; font-style:italic; }
    .contest_labelinfo { font-weight:bold; font-style:italic; }
    .contest_titlezone { padding:5px 15px!important; }
    .contest_elapse_zone { cursor:pointer; }
    .contest_cqww_info { margin-top:10px;border:1px solid; }
</style>
