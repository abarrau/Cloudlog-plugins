<div class="form-row">

    <div class="card col-md-<?php echo (($pluginsdata_data['contest_log_type']=='Edi')?'8':'12'); ?>" style="padding:0px!important;">
        <div class="card-header"><?php echo $this->lang->line('general_word_info'); ?> <a href="<?php echo $pluginsext_url2menu."/update/".$pluginsext_row->pluginsdata_id; ?>" class="btn btn-primary btn-sm float-right" title="Edit"><i class="fas fa-edit"></i></a></div>
        <div class="card-body">
            <div class="form-row"><div class="col-sm-4"><?php echo $this->lang->line('contest_name'); ?> :</div><div class="col-sm-8"><?php echo $pluginsdata_data['contest_name']; ?>&nbsp; <br/><span style="font-size:85%;font-style:italic;">(<?php echo $pluginsdata_data['contest_cl_n']; ?>)</span></div></div>
            <div class="form-row"><div class="col-sm-4"><?php echo $this->lang->line('contest_date'); ?> :</div><div class="col-sm-8"><?php echo $pluginsdata_data['contest_dhStart']." - ".$pluginsdata_data['contest_dhEnd']; ?></div></div>
            <div class="form-row"><div class="col-sm-4"><?php echo $this->lang->line('gen_hamradio_station'); ?> :</div><div class="col-sm-8"><?php echo $pluginsdata_data['contest_station']; ?></div></div>
            
        </div>
    </div>
    <?php if ($pluginsdata_data['contest_log_type']=='Edi') { ?>
    <div class="card col-md-4" style="padding:0px!important;">
        <div class="card-header"><?php echo $this->lang->line('contest_log_select_band_title'); ?> </div>
        <div class="card-body" style="text-align:center;">
            <?php
                foreach ($pluginsdata_data['list_band'] as $k => $v) {  echo "<a href=\"#\" class=\"btn btn-primary context_exportbtn\" style=\"margin-right:10px;\" data-type=\"".$pluginsdata_data['contest_log_type']."\" data-band=\"".$k."\"><i class=\"fas fa-download\"></i> ".$v."</a>"; }
            ?>
        </div>
    </div>
    <?php } ?>
</div>
<br/>
<div class="card">
    <div class="card-header"><?php echo $this->lang->line('contest_log_export'); ?> 
        <a href="javascript:contest_copy2clipboard();" class="btn btn-primary contest_btn_log btn-sm float-right" title="Copy" style="margin-left:10px;display:none;"><i class="fas fa-copy"></i></a>
        <a href="#" class="btn btn-primary btn-sm contest_btn_log contest_btn_log_download float-right" title="Download" style="margin-left:10px;display:none;"><i class="fas fa-download"></i></a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <input type="hidden" name="pluginsdata_id" value="<?php echo $pluginsext_row->pluginsdata_id; ?>" />
            <input type="hidden" name="contest_name" value="<?php echo str_replace(" ","_",$pluginsdata_data['contest_name']); ?>" />
            <input type="hidden" name="contest_band" value="" />
            <?php if ($pluginsdata_data['contest_log_type']=='Edi') { 
                echo "<div class=\"contest_log_content\">".$this->lang->line('contest_log_select_band')."</div>";
            } else {
                echo $this->lang->line('contest_log_use_cabrillo_cloudlog')." : <a class=\"btn btn-info pe_contest_btn_goto_cabrillo\" style=\"cursor:pointer;\"><i class=\"fas fa-file-download\"></i> ".$this->lang->line('contest_log_use_cabrillo_btn')."</a>";
            }
            ?>
        </div>
    </div>
</div>
<br/>
<a href="<?php echo $pluginsext_url2menu; ?>" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i> <?php echo $this->lang->line('pluginsext_back'); ?></a>
<br/>

