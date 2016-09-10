$('.row .btn').on('click', function(e) {
    e.preventDefault();
    var $this = $(this);
    var $collapse = $this.closest('.collapse-group').find('.collapse');
    $collapse.collapse('toggle');
    
});
function showManagers(level){
   $.ajax({
        url: configAjax.jsRoutes[39].showManagerlist,
        type:"get",
        dataType: "json",
        data:{level:level},
        success: function(resp) {
            if(resp.length>=1){
                var disp_val="<div>";
                for(var i=0; i<=resp.length; i++){
                    //alert(resp[i].name);
                    disp_val += "<a class='collapse' href='#'>" + resp[i].name + "</a>";
                //alert(disp_val);
                }
                disp_val += "</div>";
                alert(disp_val);
                $('.manager').html(disp_val);
                //$('.manager').collapse('toggle');
            }
        }
    });
}
/*window.setInterval(function() {
    getSummaryDetails();
}, 120000);*/
function getSummaryDetails(){
    var start_date=$("#Sstart_date").val();
    var end_date=$("#Send_date").val();
    var pIntent=$("#SpIntent").val();
    var sIntent=$("#SIntent").val();
    var sourceType=$("#SsourceType").val();
    var cityVal=$("#Scity_name_agent").val();
    if(start_date==''){ start_date='N'; }
    if(end_date==''){ end_date='N'; }
    if(pIntent==null){ pIntent='N'; }
    if(sIntent==null){ sIntent='N'; }
    if(sourceType==null){ sourceType='N'; }
    if(cityVal==null){ cityVal='N'; }
    var agent_name=$("#Sagent_name").val();
    if(agent_name==''){ agent_name='N';}
    var getAgent={agent_name:agent_name,start_date:start_date,end_date:end_date,cityVal:cityVal,pIntent:pIntent,sIntent:sIntent,sourceType:sourceType,action:"val"};
  $.ajax({
        url: configAjax.jsRoutes[40].agentSummary,
        type:"get",
        dataType: "json",
        data:getAgent,
        success: function(resp) {
            //alert(resp.data.length);
            var tbl_row='<div class="col-sm-12 table-responsive" id="searchTable"  style="border:none;"">';
            tbl_row+='<span style="color:#286090;font-weight:bold;margin-left:5px;">Number of records:'+resp.data.length+ '</span>';
            tbl_row+='<table id="example234" style="font-size:10px;" class="table table-striped table-bordered agentDetailreport" cellspacing="0" width="100%">';
            tbl_row += '<thead><tr style="background:#FFFFCC;color:#6D6D6D;font-size:13px;text-align:center;">';
            tbl_row += '<th colspan="15" style="border-top:1px solid red;border-bottom:1px solid red;"><label class="tophtable">Loggedin: ' + resp.loggedin + '</label>';
            tbl_row += '<label class="tophtable">Ringing: ' + resp.ringing + '</label>';
            tbl_row += '<label class="tophtable">Dailing: ' + resp.dialing + '</label>';
            tbl_row += '<label class="tophtable">Incall: ' + resp.incall + '</label>';
            tbl_row += '<label class="tophtable">Not Ready: ' + resp.notready + '</label>';
            tbl_row += '<label class="tophtable">Logged in-Idle: ' + resp.free + '</label>';
            tbl_row += '<label class="tophtable">Logged Out: ' + resp.loggedout + '</label></th></tr>';
            tbl_row+='<tr style="background:#6F6F6F;color:#fff;"><th>SI.no</th><th>Adviser Name</th><th>Adviser ID</th><th>City</th><th>Source</th><th>Primary Intent</th><th>Property Type</th><th>TL</th><th>Free Time(Idle Time)</th><th>Call State</th><th>Login Time</th><th>Logout Time</th><th>Loggedin Duration</th><th>Current Mode</th><th>Sip Number</th><th>Caller Number</th><th>Call From</th><th>Call Received</th><th>Call Answered</th><th>Count of Disposition Set</th><th>Count of No Disposition Set</th><th>Counts  for re-schedule(B)</th><th>Requirement Captured</th><th>BL Count</th><th>Count of Non BL</th><th>Call Duration</th><th>Talk Time</th><th>Avg Talk time</th><th>Actual Time</th><th>Avg Actual talktime</th><th>Ring Duration</th><th>Total Break Time in a Day</th><th>Break For Tea</th><th>Break For Lunch</th><th>Break For TL Breifing</th><th>Break For Training</th><th>Break For QA Feedback</th><th>Break For Others</th><th>Calls kept on Hold</th><th>Total Hold Time</th><th>Avg Hold Time</th><th>Call Handling Time</th><th>Avg Call Handling Time</th></tr>';
            tbl_row+='<tbody id="app_table_body">';
            if (typeof resp.data != 'undefined') {
      if(resp.data.length>=1){
          for(var i=0;i<resp.data.length;i++){
            var source=resp.data[i].source;
            tbl_row+="<tr>";
            tbl_row+="<td>"+(i+1)+"</td>";
            tbl_row+="<td>"+resp.data[i].agent_name+"</td>";
            tbl_row+="<td>"+resp.data[i].agent_id+"</td>";
            tbl_row+="<td>"+resp.data[i].city+"</td>";
            tbl_row+="<td><div class='more'>"+source+"</div></td>";
            tbl_row+="<td>"+resp.data[i].pri_intent+"</td>";
            tbl_row+="<td>"+resp.data[i].sec_intent+"</td>";
            tbl_row+="<td>"+resp.data[i].teamleader+"</td>";
            if (resp.data[i].call_status == '1') {
                            if (resp.data[i].incall == '2') {
                                tbl_row += "<td>00:00:00</td>";
                                tbl_row += "<td class='dialing'>DIALING</td>";
                            }
                            else if (resp.data[i].incall == '3') {
                                tbl_row += "<td>00:00:00</td>";
                                tbl_row += "<td class='ringing'>RINGING</td>";
                            }
                            else if (resp.data[i].incall == '1') {
                                tbl_row += "<td>00:00:00</td>";
                                tbl_row += "<td class='incall'>INCALL</td>";
                            }
                            else {
                                tbl_row += "<td>" + resp.data[i].free_time + "</td>";
                                tbl_row += "<td class='free'>Logged in-Idle</td>";
                            } 
                        }
                        else{
                            if(resp.data[i].pick_call_status=='yes' && resp.data[i].call_status=='0'){
                                tbl_row += "<td>" + resp.data[i].free_time + "</td>";
                                tbl_row += "<td class='free'>Logged in-Idle</td>";
                            }
                            else if(resp.data[i].pick_call_status=='no' && resp.data[i].call_status=='0'){
                                tbl_row += "<td>" + resp.data[i].free_time + "</td>";
                                tbl_row += "<td class='closure'>NOT READY</td>";
                            }
                            else{
                                tbl_row += "<td>00:00:00</td>";
                                tbl_row += "<td class='loggedout'>LOGGED OUT</td>";
                            }
                        } 

            tbl_row+="<td>"+resp.data[i].login_time+"</td>";
            tbl_row+="<td>"+resp.data[i].logout_date+"</td>";
            tbl_row+="<td>"+resp.data[i].loggedin_account_duration+"</td>";
            tbl_row+="<td>"+resp.data[i].curent_mode+"</td>";
            tbl_row+="<td>"+resp.data[i].sip_number+"</td>";
            tbl_row+="<td>"+resp.data[i].caller_no+"</td>";
            tbl_row+="<td>"+resp.data[i].call_queue+"</td>";
            tbl_row+="<td>"+resp.data[i].calls_received+"</td>";
            tbl_row+="<td>"+resp.data[i].calls_answered+"</td>";
            tbl_row+="<td>"+resp.data[i].dispos_set+"</td>";
            tbl_row+="<td>"+resp.data[i].nodispos_set+"</td>";
            tbl_row+="<td>"+resp.data[i].reschedule+"</td>";
            tbl_row+="<td>"+resp.data[i].req_capture+"</td>";
            tbl_row+="<td>"+resp.data[i].req_bhcapture+"</td>";
            tbl_row+="<td>"+resp.data[i].req_nbhcapture+"</td>";
            tbl_row+="<td>"+resp.data[i].duration+"</td>";
            tbl_row+="<td>"+resp.data[i].talktime+"</td>";
            tbl_row+="<td>"+resp.data[i].avg_talktime+"</td>";
            tbl_row+="<td>"+resp.data[i].actual_talktime+"</td>";
            tbl_row+="<td>"+resp.data[i].avg_actual_talktime+"</td>";
            tbl_row+="<td>"+resp.data[i].ring_duration+"</td>";
            tbl_row+="<td>"+resp.data[i].brkcount+"</td>";
            tbl_row+="<td>"+resp.data[i].brkfortea+"</td>";
            tbl_row+="<td>"+resp.data[i].brkforlunch+"</td>";
            tbl_row+="<td>"+resp.data[i].brkfortl+"</td>";
            tbl_row+="<td>"+resp.data[i].brkfortraining+"</td>";
            tbl_row+="<td>"+resp.data[i].brkforqa+"</td>";
            tbl_row+="<td>"+resp.data[i].brkforothers+"</td>";
            tbl_row+="<td>"+resp.data[i].holdcount+"</td>";
            tbl_row+="<td>"+resp.data[i].hold_time+"</td>";
            tbl_row+="<td>"+resp.data[i].avg_hold_time+"</td>";
            tbl_row+="<td>"+resp.data[i].call_handling_time+"</td>";
            tbl_row+="<td>"+resp.data[i].avg_call_handling_time+"</td>";
            tbl_row+="</tr>";
            }
            tbl_row+="</tbody></table></div>";
            $('#AgentSummary').html(tbl_row);
            $('#example234').DataTable({"paging":   false});

             // Configure/customize these variables.
    var showChar = 30; // How many characters are shown by default
    var moretext = "Show more >";
    var lesstext = "Show less";
    $('.more').each(function() {
        var content = $(this).html();
        if(content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
            $(this).html(html);
        }
    });
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
        }
        else{
            tbl_row+="";
            $('#AgentSummary').html(tbl_row);
            $('#example234').DataTable({"paging":   false});
        }
    }
    else{
            tbl_row+="";
            $('#AgentSummary').html(tbl_row);
            $('#example234').DataTable({"paging":   false});
        }

        }
    });  
}

function filterAgent(){
    $('#searchPending').modal('show'); 
    var start_date=$("#start_date").val();
    var end_date=$("#end_date").val();
    var pIntent=$("#pIntent").val();
    var sIntent=$("#sIntent").val();
    var sourceType=$("#sourceType").val();
    var cityVal=$("#city_name_agent").val();
    if(start_date==''){ start_date='N'; }
    if(end_date==''){ end_date='N'; }
    if(pIntent==null){ pIntent='N'; }
    if(sIntent==null){ sIntent='N'; }
    if(sourceType==null){ sourceType='N'; }
    if(cityVal==null){ cityVal='N'; }
    var agent_name=$("#agent_name").val();
    if(agent_name==''){ agent_name='N';}
    var getAgent={agent_name:agent_name,start_date:start_date,end_date:end_date,cityVal:cityVal,pIntent:pIntent,sIntent:sIntent,sourceType:sourceType,action:"val"};
    $.ajax({
    url: configAjax.jsRoutes[9].Agentdetails,
    type:"get",
    dataType: "json",
    data:getAgent,
    success: function(resp) {
        $('#searchPending').modal('hide');
            var tbl_row='<div class="col-sm-12 table-responsive" id="searchTable"  style="border:none;"">';
            tbl_row+='<span style="color:#286090;font-weight:bold;margin-left:5px;">Number of records:'+resp.length+ '</span>';
            tbl_row+='<table id="example2" style="font-size:10px;" class="table table-striped table-bordered agentDetailreport" cellspacing="0" width="100%">';
            tbl_row+='<thead><tr style="background:#6F6F6F;color:#fff;"><th>SI.no</th><th>Agent Name</th><th>Agent ID</th><th>City</th><th>Source</th><th>Primary Intent</th><th>Property Type</th><th>Calls Answered</th><th>Calls Answered 0-2 Mins</th><th>Calls Answered 2-5 Mins</th><th>Calls Answered >5 Mins</th><th>Calls Answerd in Present Queue</th><th>Calls Answered in Future dialling</th><th>Talk Time</th><th>Actual Talk Time</th><th>Avg Call Handling Time</th><th>Avg Talk Time</th><th>Hold Time</th></tr></thead>';
            tbl_row+='<tbody id="app_table_body">';
      if(resp.length>=1){
          for(var i=0;i<resp.length;i++){
            var source=resp[i].source;
            tbl_row+="<tr>";
            tbl_row+="<td>"+(i+1)+"</td>";
            tbl_row+="<td>"+resp[i].agent_name+"</td>";
            tbl_row+="<td>"+resp[i].agent_id+"</td>";
            tbl_row+="<td>"+resp[i].city+"</td>";
            tbl_row+="<td><div class='more'>"+source+"</div></td>";
            tbl_row+="<td>"+resp[i].pri_intent+"</td>";
            tbl_row+="<td>"+resp[i].sec_intent+"</td>";
            tbl_row+="<td>"+resp[i].calls_answered+"</td>";
            tbl_row+="<td>"+resp[i].ans_02+"</td>";
            tbl_row+="<td>"+resp[i].ans_35+"</td>";
            tbl_row+="<td>"+resp[i].ans_5+"</td>";
            tbl_row+="<td>"+resp[i].auto_mode+"</td>";
            tbl_row+="<td>"+resp[i].manual_mode+"</td>";
            tbl_row+="<td>"+resp[i].talktime+"</td>";
            tbl_row+="<td>"+resp[i].actual_talktime+"</td>";
            tbl_row+="<td>"+resp[i].avg_talktime+"</td>";
            tbl_row+="<td>"+resp[i].avg_actual_talktime+"</td>";
            tbl_row+="<td>"+resp[i].hold_time+"</td>";
            tbl_row+="</tr>";
            }
            tbl_row+="</tbody></table></div>";
            $('#AgentDetails').html(tbl_row);
            $('#example2').DataTable({"paging":   false});

             // Configure/customize these variables.
    var showChar = 30; // How many characters are shown by default
    var moretext = "Show more >";
    var lesstext = "Show less";
    $('.more').each(function() {
        var content = $(this).html();
        if(content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
            $(this).html(html);
        }
    });
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
        }
        else{
            tbl_row+="";
            $('#AgentDetails').html(tbl_row);
            $('#example2').DataTable({"paging":   false});
        }
    } 
    });
}
function downloadFile(elem){
    $("#downloadLinkDR").html('');
    var start_date=$("#dc_start_date").val();
    var end_date=$("#dc_end_date").val();
    var dc_city=$("#city_name_call").val();
    var dc_pIntent=$("#dc_pIntent").val();
    var dc_sIntent=$("#dc_sIntent").val();
    var dc_sourceType=$("#dc_sourceType").val();
    var dc_agent_name=$("#dc_agent_name").val();
    var phoneno=$("#dc_phoneno").val();
    if(start_date==''){ start_date='N'; }
    if(end_date==''){ end_date='N'; }
    if(dc_agent_name==''){dc_agent_name='N';}
    if(dc_city==null){ dc_city='N'; }
    if(dc_pIntent==null){ dc_pIntent='N'; }
    if(dc_sIntent==null){ dc_sIntent='N'; }
    if(dc_sourceType==null){ dc_sourceType='N'; }
    if(phoneno==null){ phoneno='N'; }
    var getCall={dc_agent_name:dc_agent_name,start_date:start_date,end_date:end_date,dc_city:dc_city,dc_pIntent:dc_pIntent,dc_sIntent:dc_sIntent,dc_sourceType:dc_sourceType,phoneno:phoneno,action:"val"};
    $.ajax({
        url: configAjax.jsRoutes[41].CallDetailReportDownload,
        type:"get",
        data:getCall,
        success: function(res){
           // alert(res);
            var response="<a href='"+res+"'>Click Here To Download </a>";
            $("#downloadLinkDR").html(response);
        }
    });
}
function filterdetailReport(page){
    $('#searchPending').modal('show'); 
    var start_date=$("#dc_start_date").val();
    var end_date=$("#dc_end_date").val();
    var dc_city=$("#city_name_call").val();
    var dc_pIntent=$("#dc_pIntent").val();
    var dc_sIntent=$("#dc_sIntent").val();
    var dc_sourceType=$("#dc_sourceType").val();
    var dc_agent_name=$("#dc_agent_name").val();
    var phoneno=$("#dc_phoneno").val();
    if(start_date==''){ start_date='N'; }
    if(end_date==''){ end_date='N'; }
    if(dc_agent_name==''){dc_agent_name='N';}
    if(dc_city==null){ dc_city='N'; }
    if(dc_pIntent==null){ dc_pIntent='N'; }
    if(dc_sIntent==null){ dc_sIntent='N'; }
    if(dc_sourceType==null){ dc_sourceType='N'; }
    if(phoneno==null){ phoneno='N'; }
    var getCall={page:page,dc_agent_name:dc_agent_name,start_date:start_date,end_date:end_date,dc_city:dc_city,dc_pIntent:dc_pIntent,dc_sIntent:dc_sIntent,dc_sourceType:dc_sourceType,phoneno:phoneno,action:"val"};
    $.ajax({
    url: configAjax.jsRoutes[14].CallDetailReport,
    type:"get",
    dataType: "json",
    data:getCall,
    success: function(res) {
        var resp=res.details;
        $('#searchPending').modal('hide');
            var tbl_row='<div class="col-sm-12 table-responsive" id="searchTable"  style="border:none;">';
            tbl_row+='<span style="color:#286090;font-weight:bold;margin-left:5px;">Number of records:'+res.total_records+ '</span>';
            tbl_row+='<table id="example3" style="font-size:10px;" class="table table-striped table-bordered filterdetailReport" cellspacing="0" width="100%">';
            tbl_row+='<thead><tr style="background:#6F6F6F;color:#fff;"><th>SI.no</th><th>Agent ID</th><th>Agent Name</th><th>Req ID</th><th>City</th><th>Source</th><th>Primary Intent</th><th>Property Type</th><th>Call Status</th><th>Customer Name</th><th>Customer No</th><th>Call Duration</th><th>Talk Time</th><th>Call Type</th><th>Orientation Type</th><th>Created Time</th><th>Disposition</th><th>Ring StartTime</th><th>Ring EndTime</th><th>Ring Duration</th><th>Actual Talktime</th><th>Lead Sent</th><th>Recording URL</th><th>Next Call Time</th><th>Remarks</th></tr></thead>';
            tbl_row+='<tbody id="app_table_body">';
      if(resp.length>=1){
          for(var i=0;i<resp.length;i++){
            tbl_row+="<tr>";
            tbl_row+="<td>"+(i+1)+"</td>";
            tbl_row+="<td>"+resp[i].agent_id+"</td>";
            tbl_row+="<td>"+resp[i].agent_name+"</td>";
            tbl_row+="<td>"+resp[i].req_id+"</td>";
            tbl_row+="<td>"+resp[i].city+"</td>";
            tbl_row+="<td><div class='more'>"+resp[i].source+"</div></td>";
            tbl_row+="<td>"+resp[i].pri_intent+"</td>";
            tbl_row+="<td>"+resp[i].sec_intent+"</td>";
            tbl_row+="<td>"+resp[i].call_status+"</td>";
            tbl_row+="<td>"+resp[i].cust_name+"</td>";
            tbl_row+="<td>"+resp[i].cust_number+"</td>";
            tbl_row+="<td>"+resp[i].call_duration+"</td>";
            tbl_row+="<td>"+resp[i].talktime+"</td>";
            tbl_row+="<td>"+resp[i].call_type+"</td>";
            tbl_row+="<td>"+resp[i].orientation_type+"</td>";
            tbl_row+="<td>"+resp[i].call_datetime+"</td>";
            tbl_row+="<td>"+resp[i].cust_disposition+"</td>";
            tbl_row+="<td>"+resp[i].ring_start_time+"</td>";
            tbl_row+="<td>"+resp[i].ring_end_time+"</td>";
            tbl_row+="<td>"+resp[i].ring_duration+"</td>";
            tbl_row+="<td>"+resp[i].actual_talktime+"</td>";
            tbl_row+="<td>"+resp[i].lead_sent+"</td>";
            if(resp[i].recording_url!='' && resp[i].recording_url!='nil'){
                tbl_row+="<td><a href='"+resp[i].recording_url+"'>Click Here to Play Audio</a></td>";
            }
            else{
                tbl_row+="<td>-</td>";    
            }
            //tbl_row+="<td><a href='javascript:void(0);' onclick='showVLProjectPopup("+resp[i].req_id+")'>"+resp[i].dispos_count+"</a></td>";
            //tbl_row+="<td>"+resp[i].queue_time+"</td>";
            tbl_row+="<td>"+resp[i].next_calltime+"</td>";
            tbl_row+="<td>"+resp[i].remarks+"</td>";
            tbl_row+="</tr>";
            }
            tbl_row+="</tbody></table></div>";
            $('#DetailCallReport').html(tbl_row);
          var pageslis="<ul class='pagination text-center' id='pagination'>";
          for(var j=1; j<=res.pages; j++){
              pageslis+="<li><a href='javascript:void(0);' onclick='filterdetailReport("+j+");'>"+j+"</a></li>";
          }
          pageslis+="</ul>";
          $("#DetailCallReportPaging").html(pageslis);
            $('#example3').DataTable({"paging":   false});


            var showChar = 30; // How many characters are shown by default
            var moretext = "Show more >";
            var lesstext = "Show less";
            $('.more').each(function() {
                var content = $(this).html();
                if(content.length > showChar) {
                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar, content.length - showChar);
                    var html = c + '<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
                    $(this).html(html);
                }
            });
            $(".morelink").click(function(){
                if($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });
        }
        else{
            tbl_row+="";
            $('#DetailCallReport').html(tbl_row);
            $('#example3').DataTable({"paging":   false});
        }
    } 
    });
}
function filtertotalLogin(){
    $('#searchPending').modal('show'); 
    var start_date=$("#tlstart_date").val();
    var end_date=$("#tlend_date").val();
    if(start_date==''){ start_date='N'; }
    if(end_date==''){ end_date='N'; }
    var agent_name=$("#tlagent_name").val();
    if(agent_name==''){agent_name='N';}
    var gettotalLog={agent_name:agent_name,start_date:start_date,end_date:end_date,action:"val"};
    $.ajax({
    url: configAjax.jsRoutes[15].TotalLoginReport,
    type:"get",
    dataType: "json",
    data:gettotalLog,
    success: function(resp) {
        $('#searchPending').modal('hide');
            var tbl_row='<div class="col-sm-12" id="searchTable">';
            tbl_row+='<span style="color:#286090;font-weight:bold;margin-left:5px;">Number of records:'+resp.length+ '</span>';
            tbl_row+='<table id="example4" style="font-size:12px;" class="table table-striped table-bordered totalLoginDownload" cellspacing="0" width="100%">';
            tbl_row+='<thead><tr style="background:#6F6F6F;color:#fff;"><th>SI.no</th><th>Agent ID</th><th>Agent Name</th><th>Login Time</th><th>Logout Time</th><th>Agent Status</th><th>Total Login Time</th></tr></thead>';
            tbl_row+='<tbody id="app_table_body">';
      if(resp.length>=1){
          for(var i=0;i<resp.length;i++){
            var logout=resp[i].logout_time;
            var logout_time="";
            if(logout=='0000-00-00 00:00:00'){ logout_time='N/A'; }
            else{ logout_time=logout; }
            tbl_row+="<tr>";
            tbl_row+="<td>"+(i+1)+"</td>";
            tbl_row+="<td>"+resp[i].agent_id+"</td>";
            tbl_row+="<td>"+resp[i].agent_name+"</td>";
            tbl_row+="<td>"+resp[i].login_time+"</td>";
            tbl_row+="<td>"+logout_time+"</td>";
            tbl_row+="<td>"+resp[i].agent_status+"</td>";
            tbl_row+="<td>"+resp[i].total_login_time+"</td>";
            tbl_row+="</tr>";
            }
            tbl_row+="</tbody></table></div>";
            $('#TotalLogin').html(tbl_row);
            $('#example4').DataTable({"paging":   false});
        }
        else{
            tbl_row+="";
            $('#TotalLogin').html(tbl_row);
            $('#example4').DataTable({"paging":   false});
        }
    } 
    });
}
function filterCampaign(){
    $('#searchPending').modal('show'); 
    var start_date=$("#start_date_campaign").val();
    var end_date=$("#end_date_campaign").val();
    if(start_date==''){ start_date='N'; }
    if(end_date==''){ end_date='N'; }
    var primary_intent=$("#pIntent_campaign").val();
    if(primary_intent==null){primary_intent='N';}
    var source_type=$("#sourceType_campaign").val();
    if(source_type==null){source_type='N';}
    var city_name=$("#city_name_campaign").val();
    if(city_name==null){city_name='N';}
    var getCampaign={city_name:city_name,source_type:source_type,primary_intent:primary_intent,start_date:start_date,end_date:end_date};
    $.ajax({
    url: configAjax.jsRoutes[16].CampaignReport,
    type:"get",
    dataType: "json",
    data:getCampaign,
    success: function(resp) {
        $('#searchPending').modal('hide');
            var tbl_row='<div class="col-sm-12" id="searchTable">';
            tbl_row+='<span style="color:#286090;font-weight:bold;margin-left:5px;">Number of records:'+resp.length+ '</span>';
            tbl_row+='<table id="example5" style="font-size:10px;" class="table table-striped table-bordered campaignReporttable" cellspacing="0" width="100%">';
            tbl_row+='<thead><tr style="background:#6F6F6F;color:#fff;"><th>SI.no</th><th>City</th><th>Source</th><th>Primary Intent</th><th>Channel</th><th>Actual Talk Time</th><th>Talk Time</th><th>Avg Actual Talk Time</th><th>Avg Talk Time</th></tr></thead>';
            tbl_row+='<tbody id="app_table_body">';
      if(resp.campaign_details.length>=1){
          for(var i=0;i<resp.campaign_details.length;i++){
            tbl_row+="<tr>";
            tbl_row+="<td>"+(i+1)+"</td>";
            tbl_row+="<td>"+resp.campaign_details[i].city+"</td>";
            tbl_row+="<td>"+resp.campaign_details[i].source+"</td>";
            tbl_row+="<td>"+resp.campaign_details[i].primary_intent+"</td>";
            tbl_row+="<td>SIP</td>";
            tbl_row+="<td>"+resp.campaign_details[i].actual_talktime+"</td>";
            tbl_row+="<td>"+resp.campaign_details[i].talktime+"</td>";
            tbl_row+="<td>"+resp.campaign_details[i].avg_actual_talktime+"</td>";
            tbl_row+="<td>"+resp.campaign_details[i].avg_talktime+"</td>";
            tbl_row+="</tr>";
            }
            tbl_row+="</tbody></table></div>";
            $('#CampaignDetails').html(tbl_row);
            $('#example5').DataTable({"paging":   false});
         }
        else{
            tbl_row+="";
            $('#CampaignDetails').html(tbl_row);
            $('#example5').DataTable({"paging":   false});
        }
   } 
    });
}
function filterAgentLog(){
    $('#searchPending').modal('show'); 
    var start_date=$("#alstart_date").val();
    var end_date=$("#alend_date").val();
    var city=$("#city_name_al").val();
    var source=$("#al_sourceType").val();
    var p_intent=$("#al_pIntent").val();
    var s_intent=$("#al_sIntent").val();
    if(start_date==''){ start_date='N'; }
    if(end_date==''){ end_date='N'; }
    if(city==null){city='N';}
    if(source==null){source='N';}
    if(p_intent==null){p_intent='N';}
    if(s_intent==null){s_intent='N';}
    var gettotalLog={start_date:start_date,end_date:end_date,city:city,source:source,p_intent:p_intent,s_intent:s_intent,action:"val"};
    $.ajax({
    url: configAjax.jsRoutes[17].AgentLoggedinReport,
    type:"get",
    dataType: "json",
    data:gettotalLog,
    success: function(resp) {
            $('#searchPending').modal('hide'); 
            var tbl_row='<div class="col-sm-12" id="searchTable">';
            tbl_row+='<span style="color:#286090;font-weight:bold;margin-left:5px;">Number of records:'+resp.length+ '</span>';
            tbl_row+='<table id="example6" style="font-size:12px;" class="table table-striped table-bordered" cellspacing="0" width="100%">';
            tbl_row+='<thead><tr style="background:#6F6F6F;color:#fff;"><th>SI.no</th><th>Call Date</th><th>Day</th><th>Week</th><th>City</th><th>Source</th><th>Primary Intent</th><th>Property Type</th><th>Agent Loggedin based on Ext</th><th>Agent Loggedin based on id</th></tr></thead>';
            tbl_row+='<tbody id="app_table_body">';
      if(resp.length>=1){
          for(var i=0;i<resp.length;i++){
            tbl_row+="<tr>";
            tbl_row+="<td>"+(i+1)+"</td>";
            tbl_row+="<td>"+resp[i].call_date+"</td>";
            tbl_row+="<td>"+resp[i].day+"</td>";
            tbl_row+="<td>"+resp[i].week+"</td>";
            tbl_row+="<td>"+resp[i].city+"</td>";
            tbl_row+="<td><div class='more'>"+resp[i].source+"</div></td>";
            tbl_row+="<td>"+resp[i].pri_intent+"</td>";
            tbl_row+="<td>"+resp[i].sec_intent+"</td>";
            tbl_row+="<td>"+resp[i].sip_number+"</td>";
            tbl_row+="<td>"+resp[i].agent_id+"</td>";
            tbl_row+="</tr>";
            }
            tbl_row+="</tbody></table></div>";
            $('#AgentLogDetails').html(tbl_row);
            $('#example6').DataTable();
            var showChar = 50; // How many characters are shown by default
            var moretext = "Show more >";
            var lesstext = "Show less";
            $('.more').each(function() {
                var content = $(this).html();
                if(content.length > showChar) {
                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar, content.length - showChar);
                    var html = c + '<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
                    $(this).html(html);
                }
            });
            $(".morelink").click(function(){
                if($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });
        }
        else{
            tbl_row+="";
            $('#AgentLogDetails').html(tbl_row);
            $('#example6').DataTable();
        }
   } 
    });
}
function filterBreak(){
    $('#searchPending').modal('show'); 
    var start_date=$("#bstart_date").val();
    var end_date=$("#bend_date").val();
    if(start_date==''){ start_date='N'; }
    if(end_date==''){ end_date='N'; }
    var agent_name=$("#bagent_name").val();
    if(agent_name==''){agent_name='N';}
    var break_reason=$('#break_reason').val();
    if(break_reason==null){break_reason='N';}
    var city=$("#city_name_brk").val();
    var brk_source=$("#brk_sourceType").val();
    var brk_pintent=$("#brk_pIntent").val();
    var brk_sintent=$("#brk_sIntent").val();
    if(city==null){city='N';}
    if(brk_source==null){brk_source='N';}
    if(brk_pintent==null){brk_pintent='N';}
    if(brk_sintent==null){brk_sintent='N';}
    var gettotalLog={city:city,brk_source:brk_source,brk_pintent:brk_pintent,brk_sintent:brk_sintent,start_date:start_date,end_date:end_date,agent_name:agent_name,break_reason:break_reason,action:"val"};
    $.ajax({
    url: configAjax.jsRoutes[26].BrkDetails,
    type:"get",
    dataType: "json",
    data:gettotalLog,
    success: function(resp) {
        $('#searchPending').modal('hide');
            var tbl_row='<div class="col-sm-12 table-responsive" id="searchTable" style="border:none;">';
            tbl_row+='<span style="color:#286090;font-weight:bold;margin-left:5px;">Number of records:'+resp.length+ '</span>';
            tbl_row+='<table id="example01" style="font-size:12px;" class="table table-striped table-bordered filterBreakReport" cellspacing="0" width="100%">';
            tbl_row+='<thead><tr style="background:#6F6F6F;color:#fff;"><th>S.no</th><th>Agent ID</th><th>Agent Name</th><th>City</th><th>Source</th><th>Primary Intent</th><th>Property Type</th><th>Expora Agent State</th><th>Login at Account Date</th><th>Login at Account Time(Hrs:Mins:Secs)</th><th>Login at Dialler Time(Hrs:Mins:Secs)</th><th>Break Reason</th><th>Break Time(Logout at Dialler)(Hrs:Mins:Secs)</th><th>Logout at Account Date</th><th>Logout at Account Time(Hrs:Mins:Secs)</th><th>Idle Time(Hrs:Mins:Secs)</th><th>Dialing Mode</th><th>Status</th><th>Duration of Logged in Dialler(Hrs:Mins:Secs)</th><th>Duration of Logged in Account(Hrs:Mins:Secs)</th></tr></thead>';
            tbl_row+='<tbody id="app_table_body">';
        if(resp.length>=1){
          for(var i=0;i<resp.length;i++){
            var login_dialer_time;
            var break_reason;
            var break_time;
            if(resp[i].login_dialer_time=='N/A' && resp[i].break_reason=='N/A' && resp[i].break_time=='N/A'){
                login_dialer_time="IDLE";
                break_reason="IDLE";
                break_time="IDLE";
            }
            else{
                login_dialer_time=resp[i].login_dialer_time;
                break_reason=resp[i].break_reason;
                break_time=resp[i].break_time;
            }
            tbl_row+="<tr>";
            tbl_row+="<td>"+(i+1)+"</td>";
            tbl_row+="<td>"+resp[i].agent_id+"</td>";
            tbl_row+="<td>"+resp[i].agent_name+"</td>";
            tbl_row+="<td>"+resp[i].city+"</td>";
            tbl_row+="<td><div class='more'>"+resp[i].source+"</div></td>";
            tbl_row+="<td>"+resp[i].pri_intent+"</td>";
            tbl_row+="<td>"+resp[i].sec_intent+"</td>";
            tbl_row+="<td>"+resp[i].login_status+"</td>";
            tbl_row+="<td>"+resp[i].login_date+"</td>";
            tbl_row+="<td>"+resp[i].login_time+"</td>";
            tbl_row+="<td ";
            if(login_dialer_time=='IDLE'){
            tbl_row+="style='color:red;font-weight:bold;'";
            } else{ }
            tbl_row+=">"+login_dialer_time+"</td>";
            tbl_row+="<td ";
            if(break_reason=='IDLE'){
            tbl_row+="style='color:red;font-weight:bold;'";
            } else{ }
            tbl_row+=">"+break_reason+"</td>";
            tbl_row+="<td ";
            if(break_time=='IDLE'){
            tbl_row+="style='color:red;font-weight:bold;'";
            } else{ }
            tbl_row+=">"+break_time+"</td>"; 
            tbl_row+="<td>"+resp[i].logout_date+"</td>";
            tbl_row+="<td>"+resp[i].logout_time+"</td>";
            tbl_row+="<td>"+resp[i].idle_time+"</td>";
            tbl_row+="<td>"+resp[i].dialing_mode+"</td>";
            tbl_row+="<td>"+resp[i].status+"</td>";
            tbl_row+="<td>"+resp[i].loggedin_dialer_duration+"</td>";
            tbl_row+="<td>"+resp[i].loggedin_account_duration+"</td>";
            tbl_row+="</tr>";
            }
            tbl_row+="</tbody></table></div>";
            $('#BreakDetails').html(tbl_row);
            $('#example01').DataTable({"paging":   false});
            var showChar = 30; // How many characters are shown by default
            var moretext = "Show more >";
            var lesstext = "Show less";
            $('.more').each(function() {
                var content = $(this).html();
                if(content.length > showChar) {
                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar, content.length - showChar);
                    var html = c + '<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
                    $(this).html(html);
                }
            });
            $(".morelink").click(function(){
                if($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });
        }
        else{
            tbl_row+="";
            $('#BreakDetails').html(tbl_row);
            $('#example01').DataTable({"paging":   false});
        }
   } 
    });  
}

$("#city_name_campaign").autocomplete({
    source: function( request, response ) {
    $.ajax({
    url: configAjax.jsRoutes[31].CitySearch+"?cityidsearch="+request.term,
    dataType: "json",
    success: function(data) {
      response( $.map( data, function( value,key ) {
          return {
              label: value,
              value: value,
              key:key
            }
          }));
          }
      });
    },
});