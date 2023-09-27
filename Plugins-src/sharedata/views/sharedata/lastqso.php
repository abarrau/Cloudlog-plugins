<div class="logdata">
    <div class="table-responsive">
    	<table class="table table-striped table-hover">
            <thead>
                <tr class="titles">
                    <th><?php echo $this->lang->line('general_word_date'); ?></th>
                    <th><?php echo $this->lang->line('gen_hamradio_call'); ?></th>
                    <th><?php echo $this->lang->line('gen_hamradio_band'); ?></th>
                    <th><?php echo $this->lang->line('gen_hamradio_mode'); ?></th>
                    <th><?php echo $this->lang->line('gen_hamradio_rsts'); ?></th>
                    <th><?php echo $this->lang->line('gen_hamradio_rstr'); ?></th>
                    <th><?php echo ($pluginsext_row->pluginsext_params->show_country==1)?$this->lang->line('general_word_country'):''; ?></th>
                    <th><?php echo ($pluginsext_row->pluginsext_params->show_stationcall>0)?$this->lang->line('gen_hamradio_station'):''; ?></th>
                    <th><?php echo ($pluginsext_row->pluginsext_params->show_mylocator==1)?$this->lang->line('gen_hamradio_locator'):''; ?></th>
                </tr>
            </thead>
            <?php 
            $i = 0; 
            foreach ($pluginsext_row->list_qso as $rowqso) {
                echo '<tr class="tr'.($i & 1).'">';
                    $custom_date_format = $this->config->item('qso_date_format');
                    $timestamp = strtotime($rowqso->COL_TIME_ON);
            ?>
                    <td><?php echo date($custom_date_format, $timestamp)." &nbsp;".(($pluginsext_row->pluginsext_params->show_time==1)?date('H:i', $timestamp):date('H:**', $timestamp)); ?></td>
                    <td><?php echo str_replace("0","&Oslash;",strtoupper($rowqso->COL_CALL)); ?></td>
                    <td><?php echo ($rowqso->COL_SAT_NAME != null)?$rowqso->COL_SAT_NAME:strtolower($rowqso->COL_BAND); ?></td>
                    <td><?php echo $rowqso->COL_SUBMODE==null?$rowqso->COL_MODE:$rowqso->COL_SUBMODE; ?></td>
                    <td><?php echo $rowqso->COL_RST_SENT; ?> <?php //if ($rowqso->COL_STX_STRING) { echo "<span class=\"label\">".$rowqso->COL_STX_STRING."</span>"; } ?></td>
                    <td><?php echo $rowqso->COL_RST_RCVD; ?> <?php //if ($rowqso->COL_SRX_STRING) { echo "<span class=\"label\">".$rowqso->COL_SRX_STRING."</span>"; } ?></td>
                    <td><?php echo ($pluginsext_row->pluginsext_params->show_country==1)?ucwords(strtolower(($rowqso->COL_COUNTRY))):''; ?></td>
                    <td><?php echo ($pluginsext_row->pluginsext_params->show_stationcall>0)?$rowqso->COL_STATION_CALLSIGN:''; ?></td>
                    <td><?php echo ($pluginsext_row->pluginsext_params->show_mylocator==1)?$rowqso->COL_MY_GRIDSQUARE:''; ?></td>
                </tr>
            <?php $i++; } ?>
                <tr><td colspan="9" style="text-align:right;padding:0px 10px!important;">Generate by <a href="https://www.magicbug.co.uk/cloudlog/" target="_blank" style="color:unset;">Cloudlog</a></td></tr>
        </table>
    </div>
</div>
<style>
.logdata .table th, .logdata .table td { padding:1px!important; font-size:14px!important; }
</style>