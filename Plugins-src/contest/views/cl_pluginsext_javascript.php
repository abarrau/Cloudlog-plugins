// === FOR ALL PAGE ==========
// add event on ahref for qso popup detail //
$('a[href*=displayQso]').click(function(e) {
    //setTimeout(pluginsext_addcontexte2qso,1000); // standby for the moment /
});
// add info of contest on qso popup //
function pluginsext_addcontexte2qso() {
    var _tr = "<tr><td>concours</td><td>test</td></tr>";
    $('.modal.qso-dialog #qsodetails tbody').append(_tr);
}

<?php if ($this->uri->segment(1) == "pluginsext" && $this->uri->segment(3) == "contest") { ?>

var pluginext_location = window.location.pathname;
var pluginext_contest_select_value = "<?php echo $this->lang->line('contest_select_value'); ?>";
var pluginext_contest_base_url = "<?php echo base_url(); ?>";
var pluginext_contest_stateqso = <?php echo isset($pluginsext_contest_icon_stateqso)?json_encode($pluginsext_contest_icon_stateqso):"{}"; ?>;
var pluginext_contest_log_type = "<?php echo (isset($pluginsdata_data->contest_log_type))?$pluginsdata_data->contest_log_type:""; ?>";
var pluginext_contest_url_cabrillo = pluginext_contest_base_url+'index.php/cabrillo';

// === FUNCTIONS ==========
// calcul pts of all qso //
function contest_setqsopts(_this) {
	pluginsext_alert('hide','');
	if (parseInt($('input[name=pluginsdata_id]').attr('value'))>0) {
		var _txt = "<?php echo str_replace("'","\'",$this->lang->line('contest_other_update_pts_alert')); ?>";
		if (confirm(pluginsext_br2n(_txt)) !== true) { return; } 
	    $.ajax({
	            url: pluginext_contest_base_url+'index.php/pluginsext/ws/contest/ws_setqsopts/'+$('input[name=pluginsdata_id]').attr('value'),
	            type: 'POST', dataType: 'json',
	            data: { },
	            error: function() { console.log('ERROR: ajax contest_setqsopts() function return error.'); },
	            success: function(res) {
					console.log(res);
		            if (res.pe_stat!="OK") {
		            	var _msg = "ERROR found";
		            	if (typeof res.pe_msg != "undefined") { _msg = res.pe_msg; }
						pluginsext_alert('danger',_msg);
						return false;
		            }
	            	var _txt = "QSO <?php echo str_replace("'","\'",$this->lang->line('pluginsext_updated')); ?>";
	            	_txt = _txt + " : " + res.qso_updated;
	            	$('.contest_listinfo_nbv').show();
		            $('.contest_listinfo_nbv').html(_txt);
	            }
	    });
	} else {
		var _txt = "<?php echo str_replace("'","\'",$this->lang->line('contest_save_first_before_action')); ?>";
		pluginsext_alert('danger',_txt);
	}
}
//
/* function contest_setqsostate(_this,_all) {
	pluginsext_alert('hide','');
	if (parseInt($('input[name=pluginsdata_id]').attr('value'))>0) {
		if (_all===true) {
			var _txt = "<?php echo str_replace("'","\'",$this->lang->line('contest_other_autoupdate_now_alert')); ?>";
			if (confirm(pluginsext_br2n(_txt)) !== true) { return; } 
			var _pe_contest_qsostate = '';
			var _pe_contest_qsoid = '';
		} else {
			var _pe_contest_qsostate = (_this.attr('data-qsostate')=='nv')?'v':'nv';
			var _pe_contest_qsoid = _this.closest('tr').attr('data-qsoid');		
		}
	    $.ajax({
	            url: pluginext_contest_base_url+'index.php/pluginsext/ws/contest/ws_setqsostate/'+$('input[name=pluginsdata_id]').attr('value'),
	            type: 'POST', dataType: 'json',
	            data: { pe_contest_qsostate:_pe_contest_qsostate, pe_contest_qsoid:_pe_contest_qsoid, pe_contest_all_update:_all},
	            error: function() { console.log('ERROR: ajax contest_setqsostate() function return error.'); },
	            success: function(res) {
					//console.log(res);
		            if (res.pe_stat!="OK") {
		            	var _msg = "ERROR found";
		            	if (typeof res.pe_msg != "undefined") { _msg = res.pe_msg; }
						pluginsext_alert('danger',_msg);
						return false;
		            }
		            if (_all===true) {
		            	var _txt = "QSO <?php echo str_replace("'","\'",$this->lang->line('pluginsext_updated')); ?>";
		            	res.qso_nbv = _txt + " : " + res.qso_nbv;
		            	$('.contest_listinfo_nbv').show();
		            } else {
			            _this.attr('style','cursor:pointer; '+res.icon_info.c);
			            _this.attr('data-qsostate',res.icon_info.s);
			            _this.closest('td').find('div').html(res.icon_info.s);
			            _this.find('i').attr('class','fas '+res.icon_info.i);
			            _this.find('i').attr('class','fas '+res.icon_info.i);
			        }
		            $('.contest_listinfo_nbv').html(res.qso_nbv);
	            }
	    });
	} else {
		var _txt = "<?php echo str_replace("'","\'",$this->lang->line('contest_save_first_before_action')); ?>";
		pluginsext_alert('danger',_txt);
	}
} */
// change state of contest qso //
/* function contest_setqsodistance(_this,_all) {
	pluginsext_alert('hide','');
	if (parseInt($('input[name=pluginsdata_id]').attr('value'))>0) {
		if (_all===true) {
			var _txt = "<?php echo str_replace("'","\'",$this->lang->line('contest_other_autoupdate_now_alert')); ?>";
			if (confirm(pluginsext_br2n(_txt)) !== true) { return; } 
			var _pe_contest_qsoid = '';
		} else {
			var _pe_contest_qsoid = ''; // TODO //_this.closest('tr').attr('data-qsoid');
		}
	    $.ajax({
	            url: pluginext_contest_base_url+'index.php/pluginsext/ws/contest/ws_setdistance/'+$('input[name=pluginsdata_id]').attr('value'),
	            type: 'POST', dataType: 'json',
	            data: { pe_contest_qsoid:_pe_contest_qsoid, pe_contest_all_update:_all},
	            error: function() { console.log('ERROR: ajax contest_setqsostate() function return error.'); },
	            success: function(res) {
					console.log(res);
		            if (res.pe_stat!="OK") {
		            	var _msg = "ERROR found";
		            	if (typeof res.pe_msg != "undefined") { _msg = res.pe_msg; }
						pluginsext_alert('danger',_msg);
						return false;
		            }
		            if (_all===true) {
		            	var _txt = "QSO <?php echo str_replace("'","\'",$this->lang->line('pluginsext_updated')); ?>";
		            	$('.contest_listinfo_distance').show();
		            } else {
		            	// TODO
			        }
		            $('.contest_listinfo_distance').html(res.qso_nbv);
	            }
	    });
	} else {
		var _txt = "<?php echo str_replace("'","\'",$this->lang->line('contest_save_first_before_action')); ?>";
		pluginsext_alert('danger',_txt);
	}
} */
// get content log file //
function contest_getcontentlog(_this) {
	pluginsext_alert('hide','');
	if (parseInt($('input[name=pluginsdata_id]').attr('value'))>0) {
		var _pe_contest_band = _this.attr('data-band');
		var _pe_contest_log_type = _this.attr('data-type');
	    $.ajax({
	            url: pluginext_contest_base_url+'index.php/pluginsext/ws/contest/ws_getexportlog/'+$('input[name=pluginsdata_id]').attr('value'),
	            type: 'POST', dataType: 'json',
	            data: { pe_contest_band:_pe_contest_band, pe_contest_log_type:_pe_contest_log_type },
	            error: function() { console.log('ERROR: ajax contest_getcontentlog() function return error.'); },
	            success: function(res) {
					if (res.pe_stat!="OK") {
		            	var _msg = "ERROR found";
		            	if (typeof res.pe_msg != "undefined") { _msg = res.pe_msg; }
						pluginsext_alert('danger',_msg);
						return false;
		            }
	            	//console.log(res);
	            	$('.contest_log_content').empty();
	            	if (res.log_content != "") { 
	            		$('.contest_log_content').html(res.log_content.replace(/\n/g, "<br/>"));
	            		$('.contest_btn_log').show();
	            		// create download button //
	            		var _fileName = $('input[name=contest_name]').attr('value')+"_"+_pe_contest_band+".edi";
	            		var _myBlob = new Blob([res.log_content], { type: "application/octetstream" });
	            		var isIE = false || !!document.documentMode;
					    if (isIE) {
					        //window.navigator.msSaveBlob(_myBlob, _fileName);
					        console.log('Not download with IE'); 
					    } else {
					        var url = window.URL || window.webkitURL;
					        var a = $('.contest_btn_log_download');
					        a.attr("download", _fileName).attr("href", url.createObjectURL(_myBlob));
					    }	            		
	            	}
	            }
	    });
	} else {
		var _txt = "<?php echo str_replace("'","\'",$this->lang->line('contest_save_first_before_action')); ?>";
		pluginsext_alert('danger',_txt);
	}
}
// copy to clipboard //
function contest_copy2clipboard() {
	var _myCopy = $(".contest_log_content").html();
	navigator.clipboard.writeText(pluginsext_br2n(_myCopy));
}
// change log type param //
function contest_logtype_view(_ftype) {
	    $('.contest_log_param').hide();
	    $('.contest_btn_log').hide();
	    $('.contest_log_param_'+_ftype.toLowerCase()).show();
}
// back html //
function contest_back() { 
	var _txt = "<?php echo str_replace("'","\'",$this->lang->line('pluginsext_cancel_confirm_txt')); ?>";
	var url_back = "<?php echo (isset($pluginsext_url2menu))?$pluginsext_url2menu:base_url(); ?>";
	if (confirm(_txt) == true) { if (url_back!="") { window.location = url_back; } else { history.back(); } } 
}
// confirm delete //
function contest_delete_confirm(_id) { 
	if (parseInt(_id)<=0) { console.log('[EROOR] Cloudlog: id for delete, not a number ('+_id+') !'); return false; }
	var _txt = "<?php echo str_replace("'","\'",$this->lang->line('pluginsext_delete_confirm_txt')); ?>";
	var url_delete = "<?php echo (isset($pluginsext_url2menu))?$pluginsext_url2menu.'/delete/':''; ?>";
	if (confirm(_txt) == true) { if (url_delete!="") { window.location = url_delete+_id; }} 
}
//
function contest_copyFromOther() {
	if (parseInt($('input[name=pluginsdata_id]').attr('value'))>0) {
		var _pe_contest_station_id = $('#pluginsdata_data__contest_station_id').val();
		var _pe_contest_log_type = $('#pluginsdata_data__contest_log_type').val();

	    $.ajax({
            url: pluginext_contest_base_url+'index.php/pluginsext/ws/contest/ws_getcontestlist/'+$('input[name=pluginsdata_id]').attr('value'),
            type: 'POST', dataType: 'json',
            data: { pe_contest_station_id:_pe_contest_station_id, pe_contest_log_type:_pe_contest_log_type },
            error: function() { console.log('ERROR: ajax contest_copyFromOther() function return error.'); },
            success: function(res) {
				if (res.pe_stat!="OK") {
	            	var _msg = "ERROR found";
	            	if (typeof res.pe_msg != "undefined") { _msg = res.pe_msg; }
					pluginsext_alert('danger',_msg);
					return false;
	            }
	           	var _html = "<div class=\"alert alert-warning\"><?php echo str_replace('"','\"',$this->lang->line('contest_copy_paramlog_warning')); ?></div>";
	           		_html += "<table class=\"table table-sm table-striped\" class=\"table table-striped\">";
	           		_html += "<thead><tr><th scope=\"col\"><?php echo $this->lang->line('contest_name'); ?></th><th></th></tr></thead>";
            		_html += "<tbody>";
            		$.each(res.contest_list, function(k, contestOne) {
					var contest_edi = "{'log_edi_PAdr1':'"+contestOne.log_edi_PAdr1.replaceAll("'","\'")+"', 'log_edi_PAdr2':'"+contestOne.log_edi_PAdr2.replaceAll("'","\'")+"', 'log_edi_RAdr1':'"+contestOne.log_edi_RAdr1.replaceAll("'","\'")+"', 'log_edi_RAdr2':'"+contestOne.log_edi_RAdr2.replaceAll("'","\'")+"', 'log_edi_RCall':'"+contestOne.log_edi_RCall.replaceAll("'","\'")+"', 'log_edi_RCity':'"+contestOne.log_edi_RCity.replaceAll("'","\'")+"', 'log_edi_RCoun':'"+contestOne.log_edi_RCoun.replaceAll("'","\'")+"', 'log_edi_RHBBS':'"+contestOne.log_edi_RHBBS.replaceAll("'","\'")+"', 'log_edi_RName':'"+contestOne.log_edi_RName.replaceAll("'","\'")+"', 'log_edi_RPhon':'"+contestOne.log_edi_RPhon.replaceAll("'","\'")+"', 'log_edi_RPoCo':'"+contestOne.log_edi_RPoCo.replaceAll("'","\'")+"', 'log_edi_SAntH1':'"+contestOne.log_edi_SAntH1.replaceAll("'","\'")+"', 'log_edi_SAntH2':'"+contestOne.log_edi_SAntH2.replaceAll("'","\'")+"', 'log_edi_SAnte':'"+contestOne.log_edi_SAnte.replaceAll("'","\'")+"', 'log_edi_SPowe':'"+contestOne.log_edi_SPowe.replaceAll("'","\'")+"', 'log_edi_SRXEq':'"+contestOne.log_edi_SRXEq.replaceAll("'","\'")+"', 'log_edi_STXEq':'"+contestOne.log_edi_STXEq.replaceAll("'","\'")+"' }";
            			_html += "<tr><td><a class=\"contest_docopy\" href=\"#\" data-edi=\""+contest_edi+"\">"+contestOne.contest_name+"</a></td><td>"+contestOne.log_edi_PAdr1+" "+contestOne.log_edi_PAdr2+"</td></tr>";
            		});
            		_html += "</tbody></table>";
				BootstrapDialog.show({
					title: '<?php echo $this->lang->line('contest_copy_paramlog'); ?>',
					cssClass: 'contest_copy',
					size: BootstrapDialog.SIZE_WIDE,
					nl2br: false,
					message: _html,
					onshown: function(dialog) {
						$('.contest_docopy').off('click').on('click',function() {
							var _oEdi = JSON.parse($(this).attr('data-edi').replaceAll("'",'"'));
							$.each(_oEdi, function(k,v) { $('input[name=pluginsdata_data__'+k+']').attr('value',v); });
							$('.bootstrap-dialog-close-button').click();
						})
					},
				});
            }
	    });
	}
}
// change state of contest qso //
function contest_cabrilloexport() {
	if (parseInt($('input[name=pluginsdata_id]').attr('value'))>0) {
		window.location.href = pluginext_contest_url_cabrillo+'?fromPEContest='+$('input[name=pluginsdata_id]').attr('value');
	} else {
		var _txt = "<?php echo str_replace("'","\'",$this->lang->line('contest_save_first_before_action')); ?>";
		pluginsext_alert('danger',_txt);
	}
}
// add category score to contest //
function contest_category_add() {
	var _last = parseInt($(".contest_score_category").last().attr('data-categoryid'));
	var _new = parseInt(_last)+1;
	var _html = "<div class=\"form-row contest_score_category\" data-categoryid=\""+_new+"\">";
		_html += "<div class=\"form-group col-sm-5\"><input type=\"text\" class=\"form-control\" id=\"pluginsdata_data__contest_score_category_"+_new+"\" name=\"pluginsdata_data__contest_score_category_"+_new+"\" value=\"\" /></div>";
		_html += "<div class=\"form-group col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"pluginsdata_data__contest_score_position_"+_new+"\" name=\"pluginsdata_data__contest_score_position_"+_new+"\" value=\"\" /></div>";
		_html += "<div class=\"form-group col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"pluginsdata_data__contest_score_nbparticipant_"+_new+"\" name=\"pluginsdata_data__contest_score_nbparticipant_"+_new+"\" value=\"\" /></div>";
		_html += "<div class=\"form-group col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"pluginsdata_data__contest_score_finalscore_"+_new+"\" name=\"pluginsdata_data__contest_score_finalscore_"+_new+"\" value=\"\" /></div>";
		_html += "<div class=\"form-group col-sm-1\"><a href=\"javascript:contest_category_delete("+_new+");\" class=\"btn btn-danger btn-sm\" title=\"\"><i class=\"fas fa-trash-alt\"></i></a></div>";
		_html += "</div>";
	console.log('n='+_new);
	$(_html).insertAfter('.contest_score_category[data-categoryid="'+_last+'"]');
}
// delete category score to contest //
function contest_category_delete(v) {
	$('.contest_score_category[data-categoryid="'+v+'"]').remove();
}
// set plot for time graph //
function contest_plotTimeplotterChart(_jsondata,_renderTo) {
	var color = ifDarkModeThemeReturn('white', 'grey');
	var options = {
		chart: { type:'column', renderTo:_renderTo, backgroundColor:getBodyBackground() },
		title: { text:'', style:{ color:color } },
		xAxis: { categories: [], type:"category", labels:{ style:{ color:color } } },
		yAxis: { min:0, title: { text:'', style:{ color:color } }, labels:{ style:{ color:color } } },
		rangeSelector: { selected:1 },
		legend: { itemStyle:{ color:color } },
		plotOptions: { column:{ stacking:'normal' } },
		series: []
	};
	var serieBand = { };
	$.each(_jsondata.data_bands, function(k, bn){
		eval('serieBand.b'+(bn.replace('.','_'))+' = { "name":"'+bn+'", "data":[] };');
	});
	$.each(_jsondata.data_times, function(){
		var _this_time = this;
		options.xAxis.categories.push(_this_time.label_time);
		$.each(_jsondata.data_bands, function(k, bn){ eval('serieBand.b'+bn+'.data.push(((_this_time.bands[bn] === undefined)?0:_this_time.bands[bn]))'); });
	});
	$.each(serieBand, function(k, data){ options.series.push(data); });
	var chart = new Highcharts.Chart(options);
}
// get stat for array contest info //
function contest_getgetstatarray() {
	_pe_contest_id = $('input[name=pluginsdata_id]').attr('value');
    $.ajax({
        url: pluginext_contest_base_url+'index.php/pluginsext/ws/contest/ws_getstatarray',
        type: 'POST', dataType: 'json',
        data: { pe_contest_id:_pe_contest_id },
        error: function() { console.log('ERROR: ajax contest_getgetstatarray() function return error.'); },
        success: function(res) {
			if (res.pe_stat!="OK") {
            	var _msg = "ERROR found";
            	if (typeof res.pe_msg != "undefined") { _msg = res.pe_msg; }
				pluginsext_alert('danger',_msg);
				return false;
            }
            var _html = "";
            var _error = false;
            console.log(res);
            if ($('.pe_contest_score_array').attr('data-update')=='0') {
	            if (typeof res.d.score.title != "undefined") {
					_html += "<thead><tr>";
					var _sizecoltitle=parseInt(100)/parseInt(res.d.score.title.length);
	            	$.each(res.d.score.title, function(k, v){
	            		eval('var _jtitle = res.d.list_score_tab_col.'+v+';');
	            		if (_jtitle.t=='p') { _html += "<th scope='col' class='bg-light' style='width:"+_sizecoltitle+"%;color:var(--dark);'>"+_jtitle.nf+"</th>"; }
	            	});
	            	_html += "</tr></thead>";
	            	$('.pe_contest_score_array').html(_html);
	            } else { _error = true; }
	            if ((!_error) && (typeof res.d.score.bands != "undefined")) {
					_html = "";
					res.d.score.title.shift();
	            	$.each(res.d.score.bands, function(k, v){ 
	            		_html += "<tr><td class='pe_contest_score_field "+((v=='TOTAL')?"bg-light' style='color:var(--dark);'":"")+"'>"+v+"</td>";
	            		var _total = 0;
	            		$.each(res.d.score.title, function(k2, v2){ 
	            			eval('var _jtitle = res.d.list_score_tab_col.'+v2+';');
	           				if (_jtitle.t=='p') { _html += "<td class='pe_contest_score_field "+((v=='TOTAL')?"bg-light' style='color:var(--dark);'":"")+"' data-band='"+v+"' data-col='"+v2+"'>0</td>"; }
	            		});
	            		_html += "</tr>";
	            	});
	            	$('.pe_contest_score_array thead').after(_html);
	            	$('.pe_contest_score_final span').html(res.d.score.final);
	            } else { _error = true; }
	            if (_error) {
	            	// TODO //
	            }
            }
            if (typeof res.d.score.result != "undefined") {
            	$.each(res.d.score.result, function(band, col){
            		var _qso_moreinfo = "";
            		$.each(col, function(k, v){ 
	            		eval('var _jtitle = res.d.list_score_tab_col.'+k+';');
	            		if (_jtitle.t=='p') { $('.pe_contest_score_field[data-band="'+band+'"][data-col="'+k+'"]').html(v); }
	            			else if (_jtitle.t=='i') { _qso_moreinfo += _jtitle.nf+" : "+v+"\n"; }
	            	}); 
	            	if (_qso_moreinfo!="") $('.pe_contest_score_field[data-band="'+band+'"][data-col="QSO"]').attr("title",_qso_moreinfo);
	            });
            	var _total = 0;
            	$.each(res.d.score.title, function(k, col){ 
            		_total = 0;
            		$('.pe_contest_score_field[data-col="'+col+'"]').each(function(){ _total += parseInt($(this).html()); }); 
            		$('.pe_contest_score_field[data-band="TOTAL"][data-col="'+col+'"]').html(_total);
            	});
            	$('.pe_contest_score_array').attr('data-update','1');
            }
        }
    });
}
//
function contest_elapse_zone(_this) {
	if (_this.find('i').hasClass('fa-caret-down')) {
		_this.closest('.card-header').next('.card-body').hide();
		_this.find('i').removeClass('fa-caret-down').addClass('fa-caret-left');
	} else {
		_this.closest('.card-header').next('.card-body').show();
		_this.find('i').removeClass('fa-caret-left').addClass('fa-caret-down');
	}
}
//
function contest_cqww_score_from_cq_api() { // TODO //
	var _year = $('.contest_cqww_info').attr('data-year');
	var _callsign = $('.contest_cqww_info').attr('data-call');
	var _url_cq_api = "https://cqww.com/api/get/score/ph"+"/"+_year+"/"+_callsign; // example=https://cqww.com/api/get/score/ph/2023/f4ans
	//$.get(_url_cq_api);
    /*var _res = $.ajax({
        url: _url_cq_api,
        type: 'GET', async: false
        //dataType: 'jsonp',
        //error: function() { console.log('ERROR: ajax contest_cqww_score_from_cq_api() function return error.'); },
        //success: function(res) {console.log(res); }
    }).responseText;*/
}

//---------------------------------------------------
//function 
//

// === LIST ==========
if (pluginext_location.substring(pluginext_location.length-13)=="/menu/contest") {
	$('#contest_list_table').DataTable({ 
		//"stateSave":true, 
		columns:[null,null,null,null,{orderable:false}],
		order: [[1,'desc']], pageLength:25
	});
}
if (pluginext_location.indexOf("/menu/contest/list_qso/")>0) {
	$('.pe_contest_validbtn').off('click').on('click',function() { contest_setqsostate($(this),false);  });
	$('#contest_list_qso_table').DataTable({ 
		//columns:[null,null,null,null,null,null,null,null,null,{orderable:false}],
		order: [[0,'desc']], pageLength:25
	});
}

// === LOGS EXPORT ==========
if (pluginext_location.indexOf("/menu/contest/logs_export")>0) {
	$('.context_exportbtn').off('click').on('click', function(){ contest_getcontentlog($(this)); });
	$('.pe_contest_btn_goto_cabrillo').off('click').on('click',function() { contest_cabrilloexport(); });	
}

// === UPDATE ==========
if (pluginext_location.indexOf("/menu/contest/update")>0) {
	$(document).ready( function (){
	   	$('#pluginsdata_data__contest_dateStart').datetimepicker({'format':'YYYY-MM-DD'});
	    $('#pluginsdata_data__contest_dateEnd').datetimepicker({'format':'YYYY-MM-DD'});
	    if ((pluginext_contest_log_type != "none") && (pluginext_contest_log_type != "")) { contest_logtype_view(pluginext_contest_log_type); }
	});
	$('#pluginsdata_data__contest_log_type').off('change').on('change', function(){ contest_logtype_view($(this).val()); });

	$('.contest_selectBox').off('click').on('click', function(){
		var _boxcontent = $(this).attr('data-boxcontent');
	    if ($('.contest_selectBox_data[data-boxcontent="'+_boxcontent+'"]').is(":hidden")) { $('.contest_selectBox_data[data-boxcontent="'+_boxcontent+'"]').show(); } else { $('.contest_selectBox_data[data-boxcontent="'+_boxcontent+'"]').hide(); }
	});
	$('.contest_selectBox_data').off('mouseleave').on('mouseleave', function(){
	    if ($(this).is(":visible")) { $(this).hide(); }
	});
	$('.contest_selectBox_data input[type="checkbox"]').off('click').on('click', function(){ 
		var _boxcontent = $(this).closest('.contest_selectBox_data').attr('data-boxcontent');
		var _checked = "";
		if ($('.contest_selectBox_data[data-boxcontent="'+_boxcontent+'"] input[type="checkbox"]:checked').length > 0) {
			$('.contest_selectBox_data[data-boxcontent="'+_boxcontent+'"] input[type="checkbox"]:checked').each(function() {
				_checked += $(this).attr('value') + ","; 
			});
		} else { 
			_checked = pluginext_contest_select_value; 
		}
		if (_checked.substring(_checked.length-1)==",") { _checked = _checked.substring(0,_checked.length-1); }
		$('.contest_selectBox[data-boxcontent="'+_boxcontent+'"] select option').html(_checked);
	});

	$('#pluginsext_contest').submit(function(event) {
		if ($('.contest_selectBox[data-boxcontent="contest_bands"] select option').html()==pluginext_contest_select_value) { $('.contest_selectBox[data-boxcontent="contest_bands"] select option').html(""); }
		if ($('.contest_selectBox[data-boxcontent="contest_score_conf_col"] select option').html()==pluginext_contest_select_value) { $('.contest_selectBox[data-boxcontent="contest_score_conf_col"] select option').html(""); }
	});
	//$('.pe_contest_btn_updateall_name').off('click').on('click',function() { contest_setqsostate(false,true); });
	//$('.pe_contest_btn_updateall_distance').off('click').on('click',function() { contest_setqsodistance(false,true); });
	$('.pe_contest_btn_calcul_pts').off('click').on('click',function() { contest_setqsopts(false,true); });
	$('.pe_contest_btn_goto_cabrillo').off('click').on('click',function() { contest_cabrilloexport(); });
	$('.pe_contest_btn_category_add').off('click').on('click',function() { contest_category_add(); });
	
}

// === STATISTIQUES ==========
if (pluginext_location.indexOf("/menu/contest/statistiques")>0) {
	$(document).ready( function (){
	    contest_plotTimeplotterChart(JSON.parse($('#pe_contest_timeplotter_data').html()),'pe_contest_timeplotter_view');
	    contest_getgetstatarray();
	    if ($('.contest_score_by_category').length>0) { $('.contest_not_result_yet').hide(); } else { contest_elapse_zone($('.contest_not_result_yet').closest('.card-body').prev('.card-header').find('.contest_elapse_zone')); }
	    if ($('.contest_cqww_info').length>0) { contest_cqww_score_from_cq_api(); }
	});
	$('.contest_elapse_zone').off('click').on('click',function() { contest_elapse_zone($(this)); });

}

</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tempusdominus-bootstrap-4.min.js"></script>

	<?php if ($this->uri->segment(1) == "pluginsext" && $this->uri->segment(3) == "contest" && $this->uri->segment(4) == "statistiques") { ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/highstock.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/highstock/exporting.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/highstock/offline-exporting.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/highstock/export-data.js"></script>
	<?php } ?>
<script>

<?php } ?>

<?php if ($this->uri->segment(1) == "cabrillo") { ?>

var pluginext_contest_id = "<?php echo isset($_GET['fromPEContest'])?$_GET['fromPEContest']:0; ?>";
var pluginext_contest_base_url = "<?php echo base_url(); ?>";

$(document).ready( function (){
	updateCabrilloForm();
});

// === FUNCTIONS ==========
// update Cabrillo Cloudlog Form //
function updateCabrilloForm() {
	var pe_wait_time = 500;
	if (parseInt(pluginext_contest_id)<=0) { return false; }
	$("<div class=\"alert alert-danger\">Please wait while data is initialized...</div>").insertAfter("h2");
    $.ajax({
        url: pluginext_contest_base_url+'index.php/pluginsext/ws/contest/ws_getexportlog/'+pluginext_contest_id,
        type: 'POST', dataType: 'json',
        data: { pe_contest_band:'', pe_contest_log_type:'Cabrillo' },
        error: function() { console.log('ERROR: ajax updateCabrilloForm() function return error.'); },
        success: function(res) {
			//console.log(res);
			var contest_station_id = res.log_content.contest_station_id;
			var contest_year = res.log_content.contest_dateStart.substring(0,4);
			var contest_cl_adif = res.log_content.contest_cl_adif;
			var contest_dateEnd = res.log_content.contest_dateEnd;
			var contest_dateStart = res.log_content.contest_dateStart;
			var contest_station_callsign = res.log_content.contest_station_callsign;
	        var contest_station_city = res.log_content.contest_station_city;
        	var contest_station_cnty = res.log_content.contest_station_cnty;

			if (contest_station_id>0) { 
				$('#station_id').val(contest_station_id); loadYears(); 
				setTimeout(function(){
					$('#year').val(contest_year); loadContests();
					setTimeout(function(){
						$('#contestid').val(contest_cl_adif); loadContestDates();
						setTimeout(function(){
							$('#contestdatesfrom').val(contest_dateStart); $('#contestdatesto').val(contest_dateEnd); addAdditionalInfo();
							setTimeout(function(){
								$('#operators').val(contest_station_callsign);
								$('#addresscity').val(contest_station_city);
								$('#addresscountry').val(contest_station_cnty);
								$('.alert-danger').empty().html('Action completed, check and correct if necessary');
								$('.alert-danger').addClass('alert-success').removeClass('alert-danger');
							},pe_wait_time);
						},pe_wait_time);
					},pe_wait_time);
				},pe_wait_time);
			}
        }
    });
}

</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sections/cabrillo.js"></script>
<script>

<?php } ?>


