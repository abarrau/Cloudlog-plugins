<div class="container">
<br>
<h2><?php echo $page_title; ?></h2>

<?php 
    // Display Success Message
    if ($this->session->flashdata('success')) { echo "<div class=\"alert alert-success\">".$this->session->flashdata('success')."</div>"; }
    // Display Message
    if ($this->session->flashdata('message')) { echo "<div class=\"alert alert-danger\">".$this->session->flashdata('message')."</div>"; }
?>
        
<div class="card">
    <div class="card-header"><?php echo $this->lang->line('pluginsext_list'); ?></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><?php echo $this->lang->line('general_word_name'); ?></th>
                        <th scope="col"><?php echo $this->lang->line('general_word_name'); ?> (id)</th>
                        <th scope="col"><?php echo ucfirst($this->lang->line('pluginsext_active')); ?></th>
                        <th scope="col" style="text-align:right;"><?php echo $this->lang->line('pluginsext_options'); ?></th>
		    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_pluginsext as $row) { ?>
                    <tr>
                        <td style="width:40%;"><?php echo $row->pluginsext_name;?></td>
                         <td style="width:20%;"><?php echo $row->pluginsext_nameid;?></td>
                        <td class='mode_<?php echo $row->pluginsext_id ?>'>
                            <?php if ($row->pluginsext_user_allow == 1) { echo $this->lang->line('general_word_yes'); } else { echo $this->lang->line('general_word_no');} ?>
                        </td>
                        <td style="text-align:right;">
                            <? if ($row->pluginsext_allow == 1) { ?> <a href="<?php echo site_url('pluginsext/edit')."/".$row->pluginsext_id; ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i> Edit</a> <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
	</div>
    </div>
</div>
