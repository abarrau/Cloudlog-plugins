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
<br/>
<div class="form-row">
    <div class="card col-md-12" style="padding:0px!important;">
        <div class="card-header"><?php echo $this->lang->line('contest_statistics'); ?></div>
        
        <div class="card-header" style="padding:5px 50px!important;"><i class="fas fa-chart-bar"></i>&nbsp;<?php echo $this->lang->line('contest_stat_global'); ?></div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-sm-3" style="font-weight:bold;"><?php echo $this->lang->line('contest_nb_qso')." (".$this->lang->line('contest_include')."/".$this->lang->line('pluginsext_total').")"; ?> :</div>
                <div class="col-sm-2"><span title="<?php echo $this->lang->line('contest_stat_nb_qso_descrip'); ?>"><?php echo $pluginsdata_data['list_info']['nbv']." / ".$pluginsdata_data['list_info']['nb']; ?></span></div>
            </div>
            <div class="form-row">
                <div class="col-sm-3" style="font-weight:bold;"><?php echo $this->lang->line('contest_period_activity'); ?> :</div>
                <div class="col-sm-2"><?php $pe_min = floor(($pluginsdata_data['contest_duration']/60)%60);
                    echo gmdate("H\hi", $pluginsdata_data['duration_activity'])." / ".(floor($pluginsdata_data['contest_duration']/3600)."h".(($pe_min<10)?("0".$pe_min):$pe_min)). "&nbsp; <span style=\"font-size:85%;font-style:italic;\">(".(round(intval($pluginsdata_data['duration_activity'])*100/intval($pluginsdata_data['contest_duration']),1))."%)</span>";?>        
                </div>
               <div class="col-sm-3" style="font-weight:bold; text-align:right;"><?php echo $this->lang->line('contest_period_inactivity'); ?> :</div>
                <div class="col-sm-2"><?php $pe_duration_inactivity = $pluginsdata_data['contest_duration'] - $pluginsdata_data['duration_activity'];
                    $pe_duration_inactivity_min = floor(($pe_duration_inactivity/60)%60);
                    echo (floor($pe_duration_inactivity/3600)."h".(($pe_duration_inactivity_min<10)?("0".$pe_duration_inactivity_min):$pe_duration_inactivity_min)). "&nbsp; <span style=\"font-size:85%;font-style:italic;\">(".(round(intval($pe_duration_inactivity)*100/intval($pluginsdata_data['contest_duration']),1))."%)</span>";?>        
                </div>
            </div>            
    	</div>
    	
        <div class="card-header" style="padding:5px 50px!important;"><i class="fas fa-chart-bar"></i>&nbsp;<?php echo $this->lang->line('contest_score_finalscore'); ?></div>
        <div class="card-body">
    		<?php for ($i=1; $i<=10; $i++) {
    			eval('if (isset($pluginsdata_data["contest_score_category_'.$i.'"]) && ($pluginsdata_data["contest_score_category_'.$i.'"]!="")) { 
    				echo "<div class=\"form-row\">";
                    echo "<div class=\"col-sm-5\" style=\"font-weight:bold;\">".$pluginsdata_data["contest_score_category_'.$i.'"]."</div>";
                    echo "<div class=\"col-sm-3\">".$this->lang->line("contest_score_position")." : ".$pluginsdata_data["contest_score_position_'.$i.'"]." / ".$pluginsdata_data["contest_score_nbparticipant_'.$i.'"]." <span style=\"font-size:80%;font-style:italic;\">(".round((intval($pluginsdata_data[\'contest_score_position_'.$i.'\'])*100/intval($pluginsdata_data[\'contest_score_nbparticipant_'.$i.'\'])),1)."%)</span></div>";
                    echo "<div class=\"col-sm-3\">".$this->lang->line("contest_score")." : ".$pluginsdata_data["contest_score_finalscore_'.$i.'"]."</div>";
                    echo "</div>";
                } else if (isset($pluginsdata_data["contest_score_position_'.$i.'"]) && ($pluginsdata_data["contest_score_position_'.$i.'"]!="")) { 
                    echo "<div class=\"form-row\">".$pluginsdata_data["contest_score_position_'.$i.'"]."</div>";
                } ');
            } ?>
    	</div>
    	
    	<div class="card-header" style="padding:5px 50px!important;"><i class="fas fa-chart-bar"></i>&nbsp;<?php echo $this->lang->line('contest_stat_bytime'); ?></div>
        <div class="card-body">
            <div class="form-row">
            	<div id="pe_contest_timeplotter_view" class="col-sm-12"></div>
            	<div id="pe_contest_timeplotter_data" style="display:none;"><?php echo $pluginsdata_data["contest_timeplotter"]; ?></div>
            </div>
    	</div>

    </div>
</div>
<br/>
<a href="<?php echo $pluginsext_url2menu; ?>" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i> <?php echo $this->lang->line('pluginsext_back'); ?></a>
<input type="hidden" name="pluginsdata_id" value="<?php echo $pluginsext_row->pluginsdata_id; ?>" />

<br/>
