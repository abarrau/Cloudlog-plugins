var sharedata_icon = "<div class='sharedata_onair' data-info='0' style='display:none;cursor:pointer;color:#FFFFFF;padding:2px 6px;'><i class='fas fa-rss'></i></div>";
var sharedata_base_url= "<?php echo base_url();?>";
var sharedata_user_id = "<?php echo $this->session->userdata('user_name'); ?>";
    
$('.cl_pluginsext_info .pluginsext_infozone_sharedata').append(sharedata_icon);
$('.cl_pluginsext_info .pluginsext_infozone_sharedata').show();
$('.sharedata_onair').off('click').on('click',function() { sharedata_set_onair($(this)); });

//
function sharedata_set_onair(_this) {
    $.ajax({
            url: sharedata_base_url+'index.php/pluginsext/ws/sharedata/ws_setonair',
            type: 'POST', dataType: 'json',
            data: { onair_state:((_this.attr('data-info')==0)?1:0) },
            error: function() { console.log('ERROR: ajax set_onair() function return error.'); },
            success: function(res) {
                if (_this.attr('data-info')=='0') {
                    _this.addClass('alert-warning');
                    _this.attr('data-info','1');
                } else {
                    _this.removeClass('alert-warning');
                    _this.attr('data-info','0');
                }
                $('.sharedata_onair i').removeAttr('class').addClass('fas').addClass(res.onair_icon);
                $('.sharedata_onair').show();
            }
    });
}

function sharedata_get_onair() {
    $.ajax({
            url: sharedata_base_url+'index.php/pluginsext/ws/sharedata/ws_onair',
            type: 'POST', dataType: 'json',
            error: function() { console.log('ERROR: ajax get_onair() function return error.'); },
            success: function(res) {
                if (res.onair_state==1) {
                    $('.sharedata_onair').addClass('alert-warning');
                    if (res.onair_band!='') $('.sharedata_onair').attr('title',res.onair_band);
                } else {
                    $('.sharedata_onair').removeClass('alert-warning');
                }
                $('.sharedata_onair').attr('data-info',res.onair_state);
                $('.sharedata_onair i').removeClass('fa-rss').addClass(res.onair_icon);
                $('.sharedata_onair').show();
            }
    });
}
sharedata_get_onair();
