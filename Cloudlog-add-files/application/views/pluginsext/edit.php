<div class="container">
    <br>
    <h2><?php echo $page_title; ?> | <span style="font-size:70%"><?php echo $title_edit; ?></span></h2>

    <?php 
        // Display Success Message //
        if ($this->session->flashdata('success')) { echo "<div class=\"alert alert-success\">".$this->session->flashdata('success')."</div>"; }
        // Display Message //
        if ($this->session->flashdata('message')) { echo "<div class=\"alert alert-danger\">".$this->session->flashdata('message')."</div>"; }
        // Validation Error //
        if (validation_errors()) { echo "<div class=\"alert alert-danger\"><a class=\"close\" data-dismiss=\"alert\">x</a>".validation_errors()."</div>"; }
        $this->load->helper('form');
    ?>

	<form method="post" action="<?php echo site_url('pluginsext/edit')."/".$pluginsext_id; ?>" name="pluginsext" id="pluginsext" >
            <input type="hidden" id="pluginsext_name" name="pluginsext_name" value="<?php echo $pluginsext_row->pluginsext_name; ?>" />
            <input type="hidden" id="pluginsext_migration" name="pluginsext_migration" value="<?php echo $pluginsext_row->pluginsext_migration; ?>" />
            <input type="hidden" name="pluginsext_id" value="<?php echo $pluginsext_id; ?>" />
        
        <div class="row">
           <div class="col-md">
                <div class="card">
                    <div class="card-header"><?php echo $this->lang->line('pluginsext_general_info_title'); ?></div>
                    <div class="card-body">
                        <div class="form-row"> 
                            <div class="form-group col-sm-3"><b><?php echo $this->lang->line('pluginsext_version'); ?> : </b><?php echo $pluginsext_row->pluginsext_info->version; ?></div>
                            <!--div class="form-group col-sm-4">(<b><?php echo $this->lang->line('pluginsext_migration'); ?> : </b><?php echo $pluginsext_row->pluginsext_info->migration; ?>)</div-->
                            <div class="form-group col-sm-5"><b><?php echo $this->lang->line('pluginsext_author'); ?> : </b> <?php echo $pluginsext_row->pluginsext_info->author; ?></div>
                        </div>
                        <div class="form-row"> 
                            <div class="form-group"><b><?php echo $this->lang->line('pluginsext_source'); ?> : </b> <a href="<?php echo $pluginsext_row->pluginsext_info->source; ?>" target="_blank"><?php echo $pluginsext_row->pluginsext_info->source; ?></a></div>
                        </div>   
                        <div class="form-row"> 
                            <div class="form-group"><b><?php echo $this->lang->line('pluginsext_description'); ?> : </b> <?php echo nl2br($pluginsext_row->pluginsext_info->description); ?></div>
                        </div>                                  
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card">
                    <div class="card-header"><?php echo $this->lang->line('pluginsext_params_common_title'); ?></div>
                    <div class="card-body">
                        <!-- Enable pluginsext by user --> 
                        <div class="form-group">
                            <label for="pluginsext_user_allow"><?php echo ucfirst($this->lang->line('pluginsext_allow_title')); ?></label>
                            <select class="custom-select" id="pluginsext_user_allow" name="pluginsext_user_allow">
                                <option value="0" <?php if ($pluginsext_row->pluginsext_user_allow == 0) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_no'); ?></option>
                                <option value="1" <?php if ($pluginsext_row->pluginsext_user_allow == 1) { echo " selected =\"selected\""; } ?>><?php echo $this->lang->line('general_word_yes'); ?></option>
                            </select>
                            <div class="small form-text text-muted"><?php echo $this->lang->line('pluginsext_allow_helpertxt'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
           <div class="col-md">
                <div class="card">
                    <div class="card-header"><?php echo $this->lang->line('pluginsext_params_specific_title'); ?></div>
                    <?php
                        if (file_exists($pluginsext_path.'/views/cl_pluginsext_edit.php')) { require_once($pluginsext_path.'/views/cl_pluginsext_edit.php'); }  
                            else { echo "<div class='card-body'>".$pluginsext_error_filenotfound."</div>"; }    
                    ?>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">

        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <?php echo $this->lang->line('pluginsext_save'); ?></button>&nbsp;&nbsp;
        <a href="javascript:pluginsext_back('<?php echo $cancel_confirm_txt; ?>');" class="btn btn-danger"><i class="far fa-times-circle"></i> <?php echo $this->lang->line('pluginsext_cancel'); ?></a>
    </form>
</div>
<script>
    function pluginsext_back(_txt) {
        if (confirm(_txt) == true) { history.back(); }
    }
</script>
