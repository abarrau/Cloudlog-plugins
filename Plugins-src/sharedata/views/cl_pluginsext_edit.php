	<div class="card-header" style="padding:5px 50px!important;"><?php echo $this->lang->line('sharedata_last_qso'); ?></div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__nb_last_qso"><?php echo $this->lang->line('sharedata_nb_last_qso'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->nb_last_qso)) { $pluginsext_row->pluginsext_params->nb_last_qso = 0; } ?>
                <select class="custom-select" id="pluginsext_params__nb_last_qso" name="pluginsext_params__nb_last_qso">
                    <option value="0" <?php if ($pluginsext_row->pluginsext_params->nb_last_qso == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <?php for ($i=10;$i<=40;$i+=5) { echo '<option value="'.$i.'" '.(($pluginsext_row->pluginsext_params->nb_last_qso==$i)?"selected =\"selected\"":"").'>'.$i.'</option>'; } ?>
                </select>
            </div>
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__hide_contest_qso"><?php echo $this->lang->line('sharedata_hide_contest_qso'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->hide_contest_qso)) { $pluginsext_row->pluginsext_params->hide_contest_qso = 0; } ?>
                <select class="custom-select" id="pluginsext_params__hide_contest_qso" name="pluginsext_params__hide_contest_qso">
                    <option value="0" <?php if ($pluginsext_row->pluginsext_params->hide_contest_qso == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_row->pluginsext_params->hide_contest_qso == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                </select>
            </div>  
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__hide_ft8"><?php echo $this->lang->line('sharedata_hide_ft8'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->hide_ft8)) { $pluginsext_row->pluginsext_params->hide_ft8 = 0; } ?>
                <select class="custom-select" id="pluginsext_params__hide_ft8" name="pluginsext_params__hide_ft8">
                    <option value="0" <?php if ($pluginsext_row->pluginsext_params->hide_ft8 == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_row->pluginsext_params->hide_ft8 == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                </select>
            </div>  
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__qso_theme"><?php echo $this->lang->line('sharedata_qso_theme'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->qso_theme)) { $pluginsext_row->pluginsext_params->qso_theme = 'cosmo'; } ?>
                <select class="custom-select" id="pluginsext_params__qso_theme" name="pluginsext_params__qso_theme">
                    <?php
                    foreach ($themes as $theme) {
                        echo '<option value="' . $theme->foldername . '"' . (($pluginsext_row->pluginsext_params->qso_theme==$theme->foldername)?'selected="selected"':'') . '>' . $theme->name . '</option>';
                    }
                    ?>
                </select>
            </div>  
        </div>
        <div class="form-row">
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__show_time"><?php echo $this->lang->line('sharedata_show_time'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->show_time)) { $pluginsext_row->pluginsext_params->show_time = 0; } ?>
                <select class="custom-select" id="pluginsext_params__show_time" name="pluginsext_params__show_time">
                    <option value="0" <?php if ($pluginsext_row->pluginsext_params->show_time == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_row->pluginsext_params->show_time == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                </select>
            </div>  
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__show_country"><?php echo $this->lang->line('sharedata_show_country'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->show_country)) { $pluginsext_row->pluginsext_params->show_country = 0; } ?>
                <select class="custom-select" id="pluginsext_params__show_country" name="pluginsext_params__show_country">
                    <option value="0" <?php if ($pluginsext_row->pluginsext_params->show_country == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_row->pluginsext_params->show_country == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                </select>
            </div>  
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__show_stationcall"><?php echo $this->lang->line('sharedata_show_stationcall'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->show_stationcall)) { $pluginsext_row->pluginsext_params->show_stationcall = 0; } ?>
                <select class="custom-select" id="pluginsext_params__show_stationcall" name="pluginsext_params__show_stationcall">
                    <option value="0" <?php if ($pluginsext_row->pluginsext_params->show_stationcall == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_row->pluginsext_params->show_stationcall == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes')." (".$this->lang->line('sharedata_always').")"; ?></option>
                    <option value="2" <?php if ($pluginsext_row->pluginsext_params->show_stationcall == 2) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes')." (".$this->lang->line('sharedata_ifnotfiltered').")"; ?></option>
                </select>
            </div>  
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__show_mylocator"><?php echo $this->lang->line('sharedata_show_mylocator'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->show_mylocator)) { $pluginsext_row->pluginsext_params->show_mylocator = 0; } ?>
                <select class="custom-select" id="pluginsext_params__show_mylocator" name="pluginsext_params__show_mylocator">
                    <option value="0" <?php if ($pluginsext_row->pluginsext_params->show_mylocator == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_row->pluginsext_params->show_mylocator == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes')." (".$this->lang->line('sharedata_always').")"; ?></option>
                    <option value="2" <?php if ($pluginsext_row->pluginsext_params->show_mylocator == 2) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes')." (".$this->lang->line('sharedata_iffiltered').")"; ?></option>
                </select>
            </div>  
        </div>
        <div class="form-group">
            <label><?php echo $this->lang->line('sharedata_url2use'); ?> : </label>
            <label><?php echo $sharedata_url2use; ?></label><br/>
			<label style="margin-bottom:0px;"><?php echo $this->lang->line('sharedata_url2usewithfilter'); ?> : </label><br/>
            &nbsp;&nbsp;<label style="margin-bottom:0px;"><?php echo $sharedata_url2use."/filterstation/<i>&lt;station_callsign&gt;</i>"; ?>&nbsp;&nbsp;&nbsp;( <?php echo $this->lang->line('sharedata_infoforcallsign' ); ?>)</label><br/>
            &nbsp;&nbsp;<label style="margin-bottom:0px;"><?php echo $sharedata_url2use."/filterlocation/<i>&lt;location id&gt;</i>"; ?></label>               
        </div>
    </div>


	<div class="card-header" style="padding:5px 50px!important;"><?php echo $this->lang->line('sharedata_onair'); ?></div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__onair_allow"><?php echo $this->lang->line('sharedata_onair_allow'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->onair_allow)) { $pluginsext_row->pluginsext_params->onair_allow = 0; } ?>
                <select class="custom-select" id="pluginsext_params__onair_allow" name="pluginsext_params__onair_allow">
                    <option value="0" <?php if ($pluginsext_row->pluginsext_params->onair_allow == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_row->pluginsext_params->onair_allow == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                </select>
            </div>
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__onair_timeout"><?php echo $this->lang->line('sharedata_onair_timeout'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->onair_timeout)) { $pluginsext_row->pluginsext_params->onair_timeout = 0; } ?>
                <select class="custom-select" id="pluginsext_params__onair_timeout" name="pluginsext_params__onair_timeout">
                    <?php for ($i=5;$i<=30;$i+=5) { echo '<option value="'.$i.'" '.(($pluginsext_row->pluginsext_params->onair_timeout==$i)?"selected =\"selected\"":"").'>'.$i.' mins</option>'; } ?>
                </select>
            </div>  
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__onair_show_band"><?php echo $this->lang->line('sharedata_onair_show_band'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->onair_show_band)) { $pluginsext_row->pluginsext_params->onair_show_band = 0; } ?>
                <select class="custom-select" id="pluginsext_params__onair_show_band" name="pluginsext_params__onair_show_band">
                    <option value="0" <?php if ($pluginsext_row->pluginsext_params->onair_show_band == '0') { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="B" <?php if ($pluginsext_row->pluginsext_params->onair_show_band == 'B') { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('gen_hamradio_band'); ?></option>
                    <option value="F" <?php if ($pluginsext_row->pluginsext_params->onair_show_band == 'F') { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('gen_hamradio_frequency'); ?></option>
                </select>
            </div>  
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__onair_theme"><?php echo $this->lang->line('sharedata_onair_theme'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->onair_theme)) { $pluginsext_row->pluginsext_params->onair_theme = 'cosmo'; } ?>
                <select class="custom-select" id="pluginsext_params__onair_theme" name="pluginsext_params__onair_theme">
                    <?php
                    foreach ($themes as $theme) {
                        echo '<option value="' . $theme->foldername . '"' . (($pluginsext_row->pluginsext_params->onair_theme==$theme->foldername)?'selected="selected"':'') . '>' . $theme->name . '</option>';
                    }
                    ?>
                </select>
            </div>  
        </div>
        <div class="form-group">
            <label><?php echo $this->lang->line('sharedata_url2use'); ?> : </label>
            <label><?php echo $sharedata_url2use_onair; ?></label><br/>
        </div>
        <div class="form-row" style="border-top:2px solid rgba(255, 255, 255, 0.075);">
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__onair_showon"><?php echo $this->lang->line('sharedata_onair_showon'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->onair_showon)) { $pluginsext_row->pluginsext_params->onair_showon = 'microphone-alt'; } ?>
                <select class="custom-select" id="pluginsext_params__onair_showon" name="pluginsext_params__onair_showon">
                    <option value="microphone-alt" <?php if ($pluginsext_row->pluginsext_params->onair_showon == 'microphone-alt') { echo " selected =\"selected\""; } ?>>Microphone</option>
                    <option value="satellite-dish" <?php if ($pluginsext_row->pluginsext_params->onair_showon == 'satellite-dish') { echo " selected =\"selected\""; } ?>>Satellite dish</option>
                    <option value="satellite" <?php if ($pluginsext_row->pluginsext_params->onair_showon == 'satellite') { echo " selected =\"selected\""; } ?>>Satellite</option>
                    <option value="broadcast-tower" <?php if ($pluginsext_row->pluginsext_params->onair_showon == 'broadcast-tower') { echo " selected =\"selected\""; } ?>>Antenna</option>
                    <option value="rss" <?php if ($pluginsext_row->pluginsext_params->onair_showon == 'rss') { echo " selected =\"selected\""; } ?>>Wave</option>  
                    <option value="headset" <?php if ($pluginsext_row->pluginsext_params->onair_showon == 'headset') { echo " selected =\"selected\""; } ?>>Headset</option>                    
                </select>
            </div>
            <div class="form-group col-sm-3">
                <label for="pluginsext_params__onair_showoff"><?php echo $this->lang->line('sharedata_onair_showoff'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->onair_showoff)) { $pluginsext_row->pluginsext_params->onair_showoff = 'microphone-alt-slash'; } ?>
                <select class="custom-select" id="pluginsext_params__onair_showoff" name="pluginsext_params__onair_showoff">
                    <option value="microphone-alt-slash" <?php if ($pluginsext_row->pluginsext_params->onair_showoff == 'microphone-alt-slash') { echo " selected =\"selected\""; } ?>>Microphone</option>
                    <option value="bed" <?php if ($pluginsext_row->pluginsext_params->onair_showoff == 'bed') { echo " selected =\"selected\""; } ?>>Sleep</option>
                </select>
            </div>  

        </div>

    </div>


