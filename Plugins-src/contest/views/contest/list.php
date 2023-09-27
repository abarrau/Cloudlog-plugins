<div class="card">
    <div class="card-header"><?php echo $this->lang->line('contest_list'); ?> <a class="btn btn-primary btn-sm float-right" href="<?php echo $contest_url2update; ?>"><i class="fas fa-plus"></i>&nbsp; <?php echo $this->lang->line('contest_add'); ?></a></div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="contest_list_table" class="table table-sm table-striped" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><?php echo $this->lang->line('contest_name'); ?></th>
                        <th scope="col"><?php echo $this->lang->line('contest_date'); ?></th>
                        <th scope="col"><?php echo $this->lang->line('contest_score_finalscore'); ?></th>
                        <th scope="col"><?php echo $this->lang->line('contest_nb_qso'); ?></th>
                        <th scope="col" style="text-align:right;"><?php echo $this->lang->line('pluginsext_options'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contest_list as $row) { 
                        if (isset($row['contest_name'])) {
                            if ($row['contest_inprogress']==true) { $row['contest_name'] = "<i class=\"fas fa-broadcast-tower\" style=\"color:var(--green);\" title=\"in progress\"></i> ".$row['contest_name']; }
                        } else { $row['contest_name'] = "ERROR"; }
                   ?>
                    <tr>
                        <td style="width:35%;"><?php echo $row['contest_name']."<br/><span style=\"font-size:80%;font-style:italic;\">(".((isset($row['contest_cl_n']))?$row['contest_cl_n']:'').")</span>"; ?></td>

                        <td style="width:20%"><?php echo (isset($row['contest_dhStart']))?($row['contest_dhStart']."<br/>&nbsp;&nbsp; > ".$row['contest_dhEnd']):''; ?></td>

                        <td style=""><?php echo (isset($row['contest_score_position_1'])&&($row['contest_score_position_1']>0))?($row['contest_score_position_1']." / ".$row['contest_score_nbparticipant_1']." <br/><span style=\"font-size:80%;font-style:italic;\">(".round((intval($row['contest_score_position_1'])*100/intval($row['contest_score_nbparticipant_1'])),1)."%)</span>"):(isset($row['contest_score_position_1'])&&($row['contest_score_position_1']==("checklog"||"swl"))?$row['contest_score_position_1']:""); ?></td>

                        <td style=""><?php echo (isset($row['contest_qso_nb']))?($row['contest_qso_nbv'].' / '.$row['contest_qso_nb']):''; ?></td>
                        
                        <td style="text-align:right;">
                            <? if (!isset($row['is_error'])) { 
                                echo "<a href=\"".$pluginsext_url2menu."/list_qso/".$row['pluginsdata_id']."\" class=\"btn btn-outline-primary btn-sm\" title=\"QSO List\"><i class=\"fas fa-list\"></i></a>";
                                echo "&nbsp;&nbsp;<a href=\"".$pluginsext_url2menu."/update/".$row['pluginsdata_id']."\" class=\"btn btn-outline-primary btn-sm\" title=\"Edit\"><i class=\"fas fa-edit\"></i></a>";
                            }
                            echo "&nbsp;&nbsp;<a href=\"javascript:contest_delete_confirm(".$row['pluginsdata_id'].");\" class=\"btn btn-danger btn-sm\" title=\"".$this->lang->line('pluginsext_delete')."\"><i class=\"fas fa-trash-alt\"></i></a>"; 
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>