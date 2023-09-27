    <div class="card-body" style="padding-bottom:5px">
        <div class="form-row">
            <div class="form-group col-sm-4">
                <label for="pluginsext_params__bddcoluserdef_namecontest"><?php echo $this->lang->line('contest_bddcoluserdef_namecontest'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->bddcoluserdef_namecontest)) { $pluginsext_row->pluginsext_params->bddcoluserdef_namecontest = 'COL_USER_DEFINED_0'; } ?>
                <select class="custom-select" id="pluginsext_params__bdd_coluserdef_namecontest" name="pluginsext_params__bddcoluserdef_namecontest">
                    <?php for ($i=0;$i<10;$i++) { 
                        echo '<option value="COL_USER_DEFINED_'.$i.'" '.(($pluginsext_row->pluginsext_params->bddcoluserdef_namecontest=='COL_USER_DEFINED_'.$i)?'selected="selected"':'').'>COL_USER_DEFINED_'.$i.'</option>';
                    } ?>
                </select>
            </div>  
            <div class="form-group col-sm-4">
                <label for="pluginsext_params__contest_period_timeplotter"><?php echo $this->lang->line('contest_period_timeplotter'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->contest_period_timeplotter)) { $pluginsext_row->pluginsext_params->contest_period_timeplotter = '30'; } ?>
                <select class="custom-select" id="pluginsext_params__contest_period_timeplotter" name="pluginsext_params__contest_period_timeplotter">
                    <?php foreach(array("10","15","20","30","60") as $_p) { 
                        echo '<option value="'.$_p.'" '.(($pluginsext_row->pluginsext_params->contest_period_timeplotter==$_p)?'selected="selected"':'').'>'.$_p.'mins</option>';
                    } ?>
                </select>
            </div> 
            <div class="form-group col-sm-4">
                <label for="pluginsext_params__contest_period_not_activity_allowed"><?php echo $this->lang->line('contest_period_not_activity_allowed'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->contest_period_not_activity_allowed)) { $pluginsext_row->pluginsext_params->contest_period_not_activity_allowed = '30'; } ?>
                <select class="custom-select" id="pluginsext_params__contest_period_not_activity_allowed" name="pluginsext_params__contest_period_not_activity_allowed">
                    <?php for ($i=5;$i<=60;$i+=5) { 
                        echo '<option value="'.($i*60).'" '.(($pluginsext_row->pluginsext_params->contest_period_not_activity_allowed==($i*60))?'selected="selected"':'').'>'.$i.'mins</option>';
                    } ?>
                </select>
            </div>             
            <!--<div class="form-group col-sm-3">
                <label for="pluginsext_params__show_screen_oncontestpage"><?php echo $this->lang->line('contest_allow_screen_oncontestpage'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->show_screen_oncontestpage)) { $pluginsext_row->pluginsext_params->show_screen_oncontestpage = 0; } ?>
                <select class="custom-select" id="pluginsext_params__show_time" name="pluginsext_params__show_screen_oncontestpage">
                    <option value="0" <?php if ($pluginsext_row->pluginsext_params->show_screen_oncontestpage == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="1" <?php if ($pluginsext_row->pluginsext_params->show_screen_oncontestpage == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                </select>
            </div>-->  
        </div>
    </div>


