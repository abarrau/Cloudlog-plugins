<?php
if (file_exists($pluginsext_path.'/views/'.$pluginsext_row->pluginsext_nameid.'/'.$methode_name.'.php')) { require_once($pluginsext_path.'/views/'.$pluginsext_row->pluginsext_nameid.'/'.$methode_name.'.php'); }  
    else { echo "<div class='card-body'>".$this->lang->line('pluginsext_error_filenotfound')." : ".$pluginsext_path.'/views/'.$pluginsext_row->pluginsext_nameid.'/'.$methode_name.'.php'."</div>"; } 
?>