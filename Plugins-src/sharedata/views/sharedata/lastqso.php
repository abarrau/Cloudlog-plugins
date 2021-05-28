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
                    <th><?php echo ($show_country==1)?$this->lang->line('general_word_country'):''; ?></th>
                </tr>
            </thead>
            <?php 
            $i = 0; 
            foreach ($last_qsos as $row) {
                echo '<tr class="tr'.($i & 1).'">';
                    $custom_date_format = $this->config->item('qso_date_format');
                    $timestamp = strtotime($row->COL_TIME_ON);
            ?>
                    <td><?php echo date($custom_date_format, $timestamp)." &nbsp;".(($show_time==1)?date('H:i', $timestamp):date('H:**', $timestamp)); ?></td>
                    <td><?php echo str_replace("0","&Oslash;",strtoupper($row->COL_CALL)); ?></td>
                    <td><?php echo ($row->COL_SAT_NAME != null)?$row->COL_SAT_NAME:strtolower($row->COL_BAND); ?></td>
                    <td><?php echo $row->COL_SUBMODE==null?$row->COL_MODE:$row->COL_SUBMODE; ?></td>
                    <td><?php echo $row->COL_RST_SENT; ?> <?php if ($row->COL_STX_STRING) { ?><span class="label"><?php echo $row->COL_STX_STRING;?></span><?php } ?></td>
                    <td><?php echo $row->COL_RST_RCVD; ?> <?php if ($row->COL_SRX_STRING) { ?><span class="label"><?php echo $row->COL_SRX_STRING;?></span><?php } ?></td>
                    <td><?php echo ($show_country==1)?ucwords(strtolower(($row->COL_COUNTRY))):''; ?></td>
                </tr>
            <?php $i++; } ?>
                <tr><td colspan="7" style="text-align:right;padding:0px 10px!important;">Generate by <a href="https://www.magicbug.co.uk/cloudlog/" target="_blank" style="color:unset;">Cloudlog</a></td></tr>
        </table>
    </div>
</div>
<style>
.logdata .table th, .logdata .table td { padding:1px!important; font-size:14px!important; }
</style>