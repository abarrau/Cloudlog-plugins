<div class="form-row">
    <div class="card col-md-8" style="padding:0px!important;">
        <div class="card-header"><?php echo $this->lang->line('general_word_info'); ?> <a href="<?php echo $pluginsext_url2menu."/update/".$pluginsext_row->pluginsdata_id; ?>" class="btn btn-primary btn-sm float-right" title="Edit"><i class="fas fa-edit"></i></a></div>
        <div class="card-body">
            <div class="form-row"><div class="col-sm-4"><?php echo $this->lang->line('contest_name'); ?> :</div><div class="col-sm-8"><?php echo $pluginsdata_data['contest_name']; ?>&nbsp; <br/><span style="font-size:85%;font-style:italic;">(<?php echo $pluginsdata_data['contest_cl_n']; ?>)</span></div></div>
            <div class="form-row"><div class="col-sm-4"><?php echo $this->lang->line('contest_date'); ?> :</div><div class="col-sm-8"><?php echo $pluginsdata_data['contest_dhStart']." - ".$pluginsdata_data['contest_dhEnd']; ?></div></div>
            <div class="form-row"><div class="col-sm-4"><?php echo $this->lang->line('gen_hamradio_station'); ?> :</div><div class="col-sm-8"><?php echo $pluginsdata_data['contest_station']; ?></div></div>
            
        </div>
    </div>
    <div class="card col-md-4" style="padding:0px!important;">
        <div class="card-header"><?php echo $this->lang->line('contest_statistic'); ?> <a href="<?php echo $pluginsext_url2menu."/statistiques/".$pluginsext_row->pluginsdata_id; ?>" class="btn btn-primary btn-sm float-right"><i class="fas fa-chart-bar" title="Statistic"></i></a></div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-sm-8"><?php echo $this->lang->line('contest_nb_qso'); ?> :</div>
                <div class="col-sm-4"><?php echo "<span class=\"contest_listinfo_nbv\">".$pluginsdata_data['list_info']['qso_nb']."</span>"; //echo " (".$pluginsdata_data['list_info']['qso_nb'].")"; ?></div>
            </div>
            <div class="form-row">
                <div class="col-sm-8"><?php echo $this->lang->line('contest_duration')." (".$this->lang->line('contest_active').")"; ?> :</div>
                <div class="col-sm-4"><?php echo gmdate("H\hi", $pluginsdata_data['duration_activity']); ?></div>
            </div>
        </div>
    </div>
    </div>
<br/>
<div class="card">
    <div class="card-header"><?php echo $this->lang->line('gen_hamradio_logbook'); ?> <a href="<?php echo $pluginsext_url2menu."/logs_export/".$pluginsext_row->pluginsdata_id; ?>" class="btn btn-primary btn-sm float-right" title="Logs download"><i class="fas fa-file-download"></i></a></div>
    <div class="card-body">
        <div class="table-responsive">
            <input type="hidden" name="pluginsdata_id" value="<?php echo $pluginsext_row->pluginsdata_id; ?>" />
            <table id="contest_list_qso_table" class="table table-sm table-striped contacttable table-hover">
                <thead>
                    <tr class="titles">
                        <th><?php echo $this->lang->line('general_word_date'); ?>/<?php echo $this->lang->line('general_word_time'); ?></th>
                        <th><?php echo $this->lang->line('gen_hamradio_call'); ?></th>
                        <th><?php echo $this->lang->line('gen_hamradio_band'); ?></th>
                        <th><?php echo $this->lang->line('gen_hamradio_mode'); ?></th>
                        <th><?php echo $this->lang->line('gen_hamradio_rsts'); ?></th>
                        <th><?php echo $this->lang->line('gen_hamradio_exchange_sent_short'); ?> / Serial</th>
                        <th><?php echo $this->lang->line('gen_hamradio_rstr'); ?></th>
                        <th><?php echo $this->lang->line('gen_hamradio_exchange_rcvd_short'); ?> / Serial</th>
                        <th><?php echo $this->lang->line('gen_hamradio_gridsquare'); ?></th>
                        <th><?php echo $this->lang->line('gen_hamradio_distance'); ?></th>
                        <th style="width:20px;">Pts</th>
                        <!--<th><?php echo $this->lang->line('contest_include'); ?></th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_qso as $row) {  ?>
                    <tr class="contest_qso_one" data-qsoid="<?php echo $row->COL_PRIMARY_KEY; ?>" >
                        <td title="<?php echo "(delta:".$row->_duration_activity_delta." | accum:".$row->_duration_activity.")"; ?>"><?php echo $row->COL_TIME_ON; ?></td>
                        <td title="<?php echo "DXCC:".$row->COL_DXCC; ?>"><a id="edit_qso" href="javascript:displayQso(<?php echo $row->COL_PRIMARY_KEY; ?>);"><?php echo str_replace("0","&Oslash;",strtoupper($row->COL_CALL)); ?></a></td>
                        <td><?php echo $row->COL_BAND; ?></td>
                        <td><?php echo $row->COL_MODE_PE; ?></td>
                        <td><?php echo $row->COL_RST_SENT; ?></td>
                        <td><?php echo $row->COL_STX_PE; ?></td>
                        <td><?php echo $row->COL_RST_RCVD; ?></td>
                        <td><?php echo $row->COL_SRX_PE; ?></td>
                        <td><?php echo $row->COL_GRIDSQUARE." (".$row->COL_CONT.")"; ?></td>
                        <td><span style="display:none;"><?php echo intval($row->COL_DISTANCE); ?></span><?php echo ($row->COL_DISTANCE>0)?($row->COL_DISTANCE.' '.$pluginsdata_data['measurement_base']):""; ?></td>
                        <td><?php echo $row->_pts; ?></td>
                        <!--<td style="text-align:center;"><?php echo $row->_html_valid_btn; ?></td>-->
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br/>
<a href="<?php echo $pluginsext_url2menu; ?>" class="btn btn-warning"><i class="fas fa-arrow-circle-left"></i> <?php echo $this->lang->line('pluginsext_back'); ?></a>

<br/>
