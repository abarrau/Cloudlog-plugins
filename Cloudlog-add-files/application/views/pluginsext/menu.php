<div class="container">
    <br>
    <h2><?php echo $title_menu; ?></h2>
    <?php 
        // Display Success Message //
        if ($this->session->flashdata('success')) { echo "<div class=\"alert alert-success\">".$this->session->flashdata('success')."</div>"; }
        // Display Message //
        if ($this->session->flashdata('message')) { echo "<div class=\"alert alert-danger\">".$this->session->flashdata('message')."</div>"; }
    ?>

    <div id="pluginsext_alert" class="alert" style="display:none;"></div>
    <div class="row">
       <div class="col-md">
            <?php
                if ($_msg_error['s']!='na') {
					if (file_exists($pluginsext_path.'/views/cl_pluginsext_menu.php')) { require_once($pluginsext_path.'/views/cl_pluginsext_menu.php'); }  
						else { echo "<div class='card-body'>".$this->lang->line('pluginsext_error_filenotfound')." : ".$pluginsext_path.'/views/cl_pluginsext_menu.php'."</div>"; }    
				}
            ?>
        </div>
    </div>

</div>

