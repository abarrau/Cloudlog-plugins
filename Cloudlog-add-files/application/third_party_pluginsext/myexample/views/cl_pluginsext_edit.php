
    <div class="card-body" style="padding-bottom:5px">
        <div class="form-row">
            <div class="form-group col-sm-4">
                <label for="pluginsext_params__arg1"><?php echo $this->lang->line('pluginsext_params__arg1'); ?></label>
                <?php if (!isset($pluginsext_row->pluginsext_params->arg1)) { $pluginsext_row->pluginsext_params->arg1 = 0; } ?>
                <select class="custom-select" id="pluginsext_params__arg1" name="pluginsext_params__arg1">
                    <option value="No" <?php if ($pluginsext_row->pluginsext_params->arg1 == 'No') { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                    <option value="Yes" <?php if ($pluginsext_row->pluginsext_params->arg1 == 'Yes') { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                </select>
            </div>  
        </div>
    </div>

