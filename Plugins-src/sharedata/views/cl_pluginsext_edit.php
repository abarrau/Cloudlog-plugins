
    <div class="card-body" style="padding-bottom:5px">
        <div class="form-row">
            <div class="form-group col-sm-4">
                <label for="pluginsext_params__nb_last_qso"><?php echo $this->lang->line('sharedata_last_qso'); ?></label>
                <?php if (!isset($pluginsext_params->nb_last_qso)) { $pluginsext_params->nb_last_qso = 0; } ?>
                <select class="custom-select" id="pluginsext_params__nb_last_qso" name="pluginsext_params__nb_last_qso">
                    <option value="0" <?php if ($pluginsext_params->nb_last_qso == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <?php for ($i=10;$i<=40;$i+=5) { echo '<option value="'.$i.'" '.(($pluginsext_params->nb_last_qso==$i)?"selected =\"selected\"":"").'>'.$i.'</option>'; } ?>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="pluginsext_params__show_time"><?php echo $this->lang->line('sharedata_show_time'); ?></label>
                <?php if (!isset($pluginsext_params->show_time)) { $pluginsext_params->show_time = 0; } ?>
                <select class="custom-select" id="pluginsext_params__show_time" name="pluginsext_params__show_time">
                    <option value="0" <?php if ($pluginsext_params->show_time == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_params->show_time == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                </select>
            </div>  
            <div class="form-group col-sm-4">
                <label for="pluginsext_params__show_country"><?php echo $this->lang->line('sharedata_show_country'); ?></label>
                <?php if (!isset($pluginsext_params->show_country)) { $pluginsext_params->show_country = 0; } ?>
                <select class="custom-select" id="pluginsext_params__show_country" name="pluginsext_params__show_country">
                    <option value="0" <?php if ($pluginsext_params->show_country == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_params->show_country == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                </select>
            </div>  
        </div>
        <div class="form-group">
            <label><?php echo $this->lang->line('sharedata_url2use'); ?> : </label>
            <label><?php echo base_url().$sharedata_url2use; ?></label>               
        </div>
    </div>

    <div class="card-body" style="border-top:2px solid rgba(255, 255, 255, 0.075);"><!-- Show "On air", time out / show fréquence -->
        <div class="form-row">
            <div class="form-group col-sm-4">
                <label for="pluginsext_params__onair_allow"><?php echo $this->lang->line('sharedata_onair_allow'); ?></label>
                <?php if (!isset($pluginsext_params->onair_allow)) { $pluginsext_params->onair_allow = 0; } ?>
                <select class="custom-select" id="pluginsext_params__onair_allow" name="pluginsext_params__onair_allow">
                    <option value="0" <?php if ($pluginsext_params->onair_allow == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_params->onair_allow == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="pluginsext_params__onair_timeout"><?php echo $this->lang->line('sharedata_onair_timeout'); ?></label>
                <?php if (!isset($pluginsext_params->onair_timeout)) { $pluginsext_params->onair_timeout = 0; } ?>
                <select class="custom-select" id="pluginsext_params__onair_timeout" name="pluginsext_params__onair_timeout">
                    <?php for ($i=5;$i<=30;$i+=5) { echo '<option value="'.$i.'" '.(($pluginsext_params->onair_timeout==$i)?"selected =\"selected\"":"").'>'.$i.' mins</option>'; } ?>
                </select>
            </div>  
            <div class="form-group col-sm-4">
                <label for="pluginsext_params__onair_show_band"><?php echo $this->lang->line('sharedata_onair_show_band'); ?></label>
                <?php if (!isset($pluginsext_params->onair_show_band)) { $pluginsext_params->onair_show_band = 0; } ?>
                <select class="custom-select" id="pluginsext_params__onair_show_band" name="pluginsext_params__onair_show_band">
                    <option value="0" <?php if ($pluginsext_params->onair_show_band == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_params->onair_show_band == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                </select>
            </div>  
        </div>
        <div class="form-group">
            <label><?php echo $this->lang->line('sharedata_url2use'); ?> : </label>
            <label><?php echo base_url().$sharedata_url2use_onair; ?></label>               
        </div>
        <div class="form-row" style="border-top:2px solid rgba(255, 255, 255, 0.075);">
            <div class="form-group col-sm-6">
                <label for="pluginsext_params__onair_showon"><?php echo $this->lang->line('sharedata_onair_showon'); ?></label>
                <?php if (!isset($pluginsext_params->onair_showon)) { $pluginsext_params->onair_showon = 'microphone-alt'; } ?>
                <select class="custom-select" id="pluginsext_params__onair_showon" name="pluginsext_params__onair_showon">
                    <option value="microphone-alt" <?php if ($pluginsext_params->onair_showon == 'microphone-alt') { echo " selected =\"selected\""; } ?>>Microphone</option>
                    <option value="satellite-dish" <?php if ($pluginsext_params->onair_showon == 'satellite-dish') { echo " selected =\"selected\""; } ?>>Satellite dish</option>
                    <option value="satellite" <?php if ($pluginsext_params->onair_showon == 'satellite') { echo " selected =\"selected\""; } ?>>Satellite</option>
                    <option value="broadcast-tower" <?php if ($pluginsext_params->onair_showon == 'broadcast-tower') { echo " selected =\"selected\""; } ?>>Antenna</option>
                    <option value="rss" <?php if ($pluginsext_params->onair_showon == 'rss') { echo " selected =\"selected\""; } ?>>Wave</option>  
                    <option value="headset" <?php if ($pluginsext_params->onair_showon == 'headset') { echo " selected =\"selected\""; } ?>>Headset</option>                    
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label for="pluginsext_params__onair_showoff"><?php echo $this->lang->line('sharedata_onair_showoff'); ?></label>
                <?php if (!isset($pluginsext_params->onair_showoff)) { $pluginsext_params->onair_showoff = 'microphone-alt-slash'; } ?>
                <select class="custom-select" id="pluginsext_params__onair_showoff" name="pluginsext_params__onair_showoff">
                    <option value="microphone-alt-slash" <?php if ($pluginsext_params->onair_showoff == 'microphone-alt-slash') { echo " selected =\"selected\""; } ?>>Microphone</option>
                    <option value="bed" <?php if ($pluginsext_params->onair_showoff == 'bed') { echo " selected =\"selected\""; } ?>>Sleep</option>
                </select>
            </div>  

        </div>

    </div>


