$(document).ready(function (){
$("#start_date1").datepicker({
    dateFormat: "yy-mm-dd"
});
$("#end_date1").datepicker({
    dateFormat: "yy-mm-dd"
});
    getTlNames();
    getAgentNames();
    getManagerNames();
});
function getTlNames(){
    $.ajax({
        url: configAjax.jsRoutes[45].GetTlNames,
        type: "get",
        dataType: "json",
        success: function(resp) {
            if (resp.length >= 1) {
                var dropdownval = '<label for="city" class="control-label">TL Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><select data-placeholder="Choose a TL" class="chosen-select" style="width:220px;"  name="tl_name_agent[]" id="tl_name_agent" multiple>';
                var dropdownval1 = '<label for="city" class="control-label">TL Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><select data-placeholder="Choose a TL" class="chosen-select" style="width:220px;" name="tl_name_call[]" id="tl_name_call" multiple>';
                for (var i = 0; i < resp.length; i++) {
                    dropdownval += '<option value="' + resp[i].name + '">' + resp[i].name + '</option>';
                    dropdownval1 += '<option value="' + resp[i].name + '">' + resp[i].name + '</option>';
                }
                dropdownval += '</select>';
                $("#tlnames_list").html(dropdownval);
                $("#tlnames_list1").html(dropdownval1);
                dropDownconfig();
            }
        }
    });
}
function getAgentNames(){
    $.ajax({
        url: configAjax.jsRoutes[44].GetAgentNames,
        type: "get",
        dataType: "json",
        success: function(resp) {
            if (resp.length >= 1) {
                var dropdownval = '<label for="city" class="control-label">Agent Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><select data-placeholder="Choose a Agent" class="chosen-select" style="width:220px;" tabindex="4" name="agent_name_agent[]" id="agent_name_agent" multiple>';
                var dropdownval1 = '<label for="city" class="control-label">Agent Name</label><select data-placeholder="Choose a Agent" class="chosen-select" style="width:220px;" tabindex="4" name="agent_name_call[]" id="agent_name_call" multiple>';
                for (var i = 0; i < resp.length; i++) {
                    dropdownval += '<option value="' + resp[i].name + '">' + resp[i].name + '</option>';
                    dropdownval1 += '<option value="' + resp[i].name + '">' + resp[i].name + '</option>';
                }
                dropdownval += '</select>';
                dropdownval1 += '</select>';
                $("#agentnames_list").html(dropdownval);
                $("#agentnames_list1").html(dropdownval1);
                dropDownconfig();
            }
        }
    });
}
function getManagerNames(){
    $.ajax({
        url: configAjax.jsRoutes[46].GetManagerNames,
        type: "get",
        dataType: "json",
        success: function(resp) {
            if (resp.length >= 1) {
                var dropdownval = '<label for="city" class="control-label">Manager Name</label><select data-placeholder="Choose a Manager" class="chosen-select" style="width:220px;" tabindex="4" name="mgr_name_agent[]" id="mgr_name_agent" multiple>';
                for (var i = 0; i < resp.length; i++) {
                    dropdownval += '<option value="' + resp[i].name + '">' + resp[i].name + '</option>';
                }
                dropdownval += '</select>';
                $("#mgrnames_list").html(dropdownval);
                dropDownconfig();
            }
        }
    });
}
function showAgentSummaryReportMongo(){
    $('#searchPending').modal('show'); 
    var start_date=$("#start_date").val();
    var end_date=$("#end_date").val();
    var cityVal=$("#city_name_agent").val();
    if(start_date==''){ start_date='N'; }
    if(end_date==''){ end_date='N'; }
    var agent_name=$("#agent_name").val();
    if(agent_name==''){ agent_name='N';}
    if(cityVal==''){ cityVal='N';}
    var tl_name=$("#tl_name_agent").val();
    if(tl_name==''){ tl_name='N'; }
    var manager_name=$("#mgr_name_agent").val();
    if(manager_name==''){ manager_name='N'; }
    var agent_name=$("#agent_name_agent").val();
    if(agent_name==''){ agent_name='N'; }
    var getAgent={agent_name:agent_name,start_date:start_date,end_date:end_date,cityVal:cityVal,agent_name:agent_name,manager_name:manager_name,tl_name:tl_name,action:"val"};
    $.ajax({
    url: configAjax.jsRoutes[42].AgentdetailsMongo,
    type:"get",
    dataType: "json",
    data:getAgent,
    success: function(resp) {
        $('#searchPending').modal('hide');
            var tbl_row='<div class="col-sm-12 table-responsive" id="searchTable"  style="border:none;"">';
            tbl_row+='<span style="color:#286090;font-weight:bold;margin-left:5px;">Number of records:'+resp.length+ '</span>';
            tbl_row+='<table id="example2" style="font-size:10px;" class="table table-striped table-bordered agentDetailreportMongo" cellspacing="0" width="100%">';
            tbl_row+= '<thead><tr style="background:#6F6F6F;color:#fff;"><th>SI.no</th><th>Agent Name</th><th>Agent ID</th><th>Primary Intent</th><th>Cities</th><th>TL</th><th>Status</th><th>Total calls dialled by dialer</th><th>Calls Answered</th><th>Count of Disposition Set</th><th>Count of No Disposition Set</th><th>Call Duration</th><th>First Login time</th><th>Last Logout time</th><th>total login duration</th><th>Total break time</th><th>Break for tea</th><th>Break for lunch</th><th>Break for TL briefing</th><th>Break for training</th><th>Break for IT Downtime</th><th>break for QA feedback</th><th>Break for others</th><th>total idle time</th><th>Call Handling Time</th><th>Avg Call Handling Time</th><th>Actual Talk Time</th><th>Ring Time</th><th>dialling time</th><th>Total ACW Time</th><th>total Avg Talk Time</th><th>Calls kept on hold</th><th>Hold Time</th><th>Avg Hold Time of Held</th><th>Avg ACW Time</th><th>Average Wait Time</th><th>total call waiting time</th><th>Total calls received as of now(A)</th><th>Average Talk time BL</th><th>Counts  for re-schedule(B)</th><th>lead multiplier</th><th>total talk time for the business leads</th><th>Total Time in non-BL requirement</th><th>Average talk time for non buisness leads</th><th>BL count(during production hours)(D)</th><th>count of non business lead(sum of the following)(E)</th><th>total requirements captured(D+E)</th><th>unique seekers converted to BL</th><th>overall conversion rate</th><th>unique conversion rate</th></tr></thead>';
            tbl_row+='<tbody id="app_table_body">';
        if(resp.length>=1){
            $("#agentdetailrepDownloadbtn").css('display','block');
          for(var i=0;i<resp.length;i++){
            var source=resp[i].source;
            tbl_row+="<tr>";
            tbl_row+="<td>"+(i+1)+"</td>";
            tbl_row+="<td>"+resp[i].agent_name+"</td>";
            tbl_row+="<td>"+resp[i].agent_id+"</td>";
            tbl_row+="<td>"+resp[i].pri_intent+"</td>";
            tbl_row+='<td><div style="max-width:50px !important;overflow: hidden;" >'+resp[i].cities+'</div></td>';
            tbl_row+="<td>"+resp[i].team_leader+"</td>";

            if(resp[i].status=="FREE"){
                tbl_row+="<td class='freeclass' >"+resp[i].status+"</td>";
            }else if(resp[i].status=="IDLE"){
                tbl_row+="<td class='idleclass' >"+resp[i].status+"</td>";
            }else if(resp[i].status=="INCALL"){
                tbl_row+="<td class='incallclass' >"+resp[i].status+"</td>";
            }else if(resp[i].status=="RINGING"){
                tbl_row+="<td class='ringingclass' >"+resp[i].status+"</td>";
            }else if(resp[i].status=="DIALING"){
                tbl_row+="<td class='dialingclass' >"+resp[i].status+"</td>";
            }else{
                  tbl_row+="<td class='otherclass'>"+resp[i].status+"</td>";
            }
            tbl_row+="<td>"+resp[i].total_calls_dialled+"</td>";
            tbl_row+="<td>"+resp[i].calls_answered+"</td>";
            //tbl_row+="<td>"+resp[i].total_connects+"</td>";
            tbl_row+="<td>"+resp[i].disposition_set+"</td>";
            tbl_row+="<td>"+resp[i].disposition_set_num+"</td>";

            tbl_row+="<td>"+resp[i].call_duration+"</td>";
            tbl_row+="<td>"+resp[i].first_login_time+"</td>";
           // tbl_row+="<td>"+resp[i].last_login_time+"</td>";
            tbl_row+="<td>"+resp[i].last_logout_time+"</td>";
            tbl_row+="<td>"+resp[i].total_login_duration+"</td>";
            tbl_row+="<td>"+resp[i].btime_day+"</td>";
            tbl_row+="<td>"+resp[i].btime_tea+"</td>";
            tbl_row+="<td>"+resp[i].btime_lunch+"</td>";
            tbl_row+="<td>"+resp[i].btime_tl+"</td>";
            tbl_row+="<td>"+resp[i].btime_training+"</td>";
            tbl_row+="<td>"+resp[i].btime_it+"</td>";
            tbl_row+="<td>"+resp[i].btime_qa+"</td>";
            tbl_row+="<td>"+resp[i].btime_others+"</td>";
            tbl_row+="<td>"+resp[i].itime_total+"</td>";
            tbl_row+="<td>"+resp[i].call_handling_time+"</td>";
            tbl_row+="<td>"+resp[i].call_handling_time_a+"</td>";
            tbl_row+="<td>"+resp[i].total_a_talk_time+"</td>";
            tbl_row+="<td>"+resp[i].ring_time+"</td>";
            tbl_row+="<td>"+resp[i].dial_time+"</td>";
            tbl_row+="<td>"+resp[i].total_awc_time+"</td>";
            tbl_row+="<td>"+resp[i].average_talk_time+"</td>";
            tbl_row+="<td>"+resp[i].calls_kept_on_hold+"</td>";
            tbl_row+="<td>"+resp[i].hold_time+"</td>";
            tbl_row+="<td>"+resp[i].average_hold_time+"</td>";
            tbl_row+="<td>"+resp[i].average_acw_time+"</td>";
            tbl_row+="<td>"+resp[i].average_wait_time+"</td>";
            tbl_row+="<td>"+resp[i].total_call_waiting_time+"</td>";
            tbl_row+="<td>"+resp[i].average_call_waiting_time+"</td>";
            tbl_row+="<td>"+resp[i].total_calls_recieved+"</td>";
            tbl_row+="<td>"+resp[i].re_schedule+"</td>";
            tbl_row+="<td>"+resp[i].lead_multiplier+"</td>";
            tbl_row+="<td>"+resp[i].bl_talktime+"</td>";
            tbl_row+="<td>"+resp[i].nonbl_talktime+"</td>";
            tbl_row+="<td>"+resp[i].nonbl_average_talktime+"</td>";
            tbl_row+="<td>"+resp[i].bl_count+"</td>";
            tbl_row+="<td>"+resp[i].non_bl_count+"</td>";
            tbl_row+="<td>"+resp[i].total_requirement_captured+"</td>";
            tbl_row+="<td>"+resp[i].unique_seekers_BL+"</td>";
            tbl_row+="<td>"+resp[i].overall_crate+"</td>";
            tbl_row+="<td>"+resp[i].unique_crate+"</td>";
            tbl_row+="</tr>";
            }
            tbl_row+="</tbody></table></div>";

            $('#AgentDetails').html(tbl_row);
            $('#example2').DataTable({"paging":   false,"bLengthChange": false});
        }
        else{
            $("#agentdetailrepDownloadbtn").css('display','none');
            tbl_row+="";
            $('#AgentDetails').html(tbl_row);
            $('#example2').DataTable({"paging":   false,"bLengthChange": false});
        }
    } 
    });
}

function showCallDetailreportMongo(){
    $('#searchPending').modal('show'); 
    var start_date=$("#start_date1").val();
    var end_date=$("#end_date1").val();
    var cityVal=$("#city_name_call").val();
    console.log(cityVal);
    if(start_date==''){ start_date='N'; }
    if(end_date==''){ end_date='N'; }
    var agent_name=$("#agent_name_call").val();
    if(agent_name==''){ agent_name='N';}
    var p_intent=$("#primary_intent_call").val();
    if(p_intent==''){ p_intent='N';}
    var p_type=$("#ptype_call").val();
    if(p_type==''){ p_type='N';}
    var p_category=$("#category_call").val();
    if(p_category==''){ p_category='N';}
    var source=$("#source_call").val();
    if(source==''){ source='N';}
    var tl_name=$("#tl_name_call").val();
    if(tl_name==''){ tl_name='N';}
    if(cityVal==''){ cityVal='N';}
    var phone_no=$('#phone_no').val();
    if(phone_no==''){phone_no='N'};
    var getAgent={agent_name:agent_name,tl_name:tl_name,p_intent:p_intent,p_type:p_type,p_category:p_category,source:source,start_date:start_date,end_date:end_date,cityVal:cityVal,phone_no:phone_no,action:"val"};
    $.ajax({
    url: configAjax.jsRoutes[43].ReqDetailsMongo,
    type:"get",
    dataType: "json",
    data:getAgent,
    success: function(response) {
        $('#searchPending').modal('hide');
            var tbl_row='<div class="col-sm-12 table-responsive" id="searchTable"  style="border:none;"">';
        if(response.total_call>50) {
            tbl_row += '<span style="color:#286090;font-weight:bold;margin-left:5px;">Number of records:' + response.total_call + ' (Please do download to view ' + response.total_call + ' records)</span>';
        }
        else{
            tbl_row += '<span style="color:#286090;font-weight:bold;margin-left:5px;">Number of records:' + response.total_call + '</span>';
        }
            tbl_row+='<table id="example3" style="font-size:10px;" class="table table-striped table-bordered showCallDetailreportMongo" cellspacing="0" width="100%">';
            tbl_row+= '<thead><tr style="background:#6F6F6F;color:#fff;"><th>SI.no</th><th>Raw req id</th><th>merged req id</th><th>date  of form fill at the front end</th><th>time of form fill at the front end</th><th>Source name from raw requirement</th><th>Primary intent etc.</th><th>Call Datetime</th><th>Call start date stamp</th><th>Call start time stamp</th><th>Call end date stamp</th><th>Call end time stamp</th><th>Recording URL</th><th>Total time on the call</th><th>Total after call work time</th><th>Dialer hang up cause</th><th>Managers name</th><th>TL name</th><th>Name of the Seeker</th><th>Email ID of seeker</th><th>Contact Number of the seeker</th><th>BHK Info</th><th>Locality Name</th><th>Regions</th><th>City</th><th>Property</th><th>category</th><th>Property Type</th><th>Min Budget</th><th>Max Budget</th><th>Week No</th><th>Telecaller Employee id</th><th>Telecaller Name</th><th>Call Status (Disposition)</th><th>Remarks</th><th>Name of the Seeker - Final</th><th>Contact Number - Final</th><th>Email ID - Final</th><th>Area Name - Final</th><th>City - Final</th><th>Property Type - Final</th><th>BHK Info - Final</th><th>Min Budget - Final</th><th>Max Budget - Final</th><th>Possession Category - status</th><th>Projects leads sent in the past</th><th>Suggested Projects</th><th>Suggested Projects(lead generated for) - P2(locality matching)</th><th>Suggested Projects - (similar projects)</th><th>Region/zone area mapping</th><th>Seekers Country</th><th>City Zone(ZAM=Zone Area Mapping)</th><th>Total Promoted Project Leads</th><th>total revenue(as sold to the seller) of the leads sent</th><th>No. Promoted Project Leads- CF (PLs)</th><th>Name of the Promoted Projects -CF PLs (Separate with comma)</th><th>povp IDs of the Promoted Projects -CF PLs (Separate with comma)  No. Promoted Project Leads- QH (PLs)</th><th>Name of the Promoted Projects -QH PLs (Separate with comma)</th><th>povp IDs of the Promoted Projects -QH PLs (Separate with comma)</th><th>Call follow up date</th><th>Call follow up time</th></tr></thead>';
            tbl_row+='<tbody id="app_table_body">';
        var resp=response.call_details;
        if(response.total_call>=1){
            $("#calldetailrepDownloadbtn").css('display','block');
          for(var i=0;i<resp.length;i++){
            var source=resp[i].source;
            tbl_row+="<tr>";
            tbl_row+="<td>"+(i+1)+"</td>";
            tbl_row+='<td><div style="max-width:50px !important;overflow: hidden;" title="'+resp[i].raw_req_id+'" >'+resp[i].raw_req_id+'</div></td>';
            tbl_row+="<td>"+resp[i].merged_req_id+"</td>"
            tbl_row+="<td>"+resp[i].date_form_fill+"</td>"
            tbl_row+="<td>"+resp[i].time_form_fill+"</td>"  
            tbl_row+="<td>"+resp[i].source_raw_requirement+"</td>"  
            tbl_row+="<td>"+resp[i].p_intent+"</td>"
            tbl_row+="<td>"+resp[i].call_datetime+"</td>"
            tbl_row+="<td>"+resp[i].call_start_date+"</td>"
            tbl_row+="<td>"+resp[i].call_start_time+"</td>" 
            tbl_row+="<td>"+resp[i].call_end_date+"</td>"   
            tbl_row+="<td>"+resp[i].call_end_time+"</td>"
              if(resp[i].rec_url!='' && resp[i].rec_url!='nil'){
                  tbl_row+="<td><a target='_blank' href='"+resp[i].rec_url+"'>Click Here to Play Audio</a></td>";
              }
              else{
                  tbl_row+="<td>-</td>";
              }
            tbl_row+="<td>"+resp[i].total_call_time+"</td>" 
            tbl_row+="<td>"+resp[i].total_acw_time+"</td>"  
            tbl_row+="<td>"+resp[i].dialer_hangup_cause+"</td>" 
            tbl_row+="<td>"+resp[i].manager_name+"</td>"    
            tbl_row+="<td>"+resp[i].tl_name+"</td>" 
            tbl_row+="<td>"+resp[i].seeker_name+"</td>" 
            tbl_row+="<td>"+resp[i].seeker_email+"</td>"    
            tbl_row+="<td>"+resp[i].seeker_number+"</td>"   
            tbl_row+="<td>"+resp[i].bhk_info+"</td>"
            tbl_row+="<td>"+resp[i].locality_name+"</td>"   
            tbl_row+="<td>"+resp[i].regions+"</td>" 
            tbl_row+="<td>"+resp[i].city+"</td>"    
            tbl_row+="<td>"+resp[i].property+"</td>" 
            tbl_row+="<td>"+resp[i].category+"</td>"    
            tbl_row+="<td>"+resp[i].prop_type+"</td>"   
            tbl_row+="<td>"+resp[i].min_budget+"</td>"  
            tbl_row+="<td>"+resp[i].max_budget+"</td>"
            tbl_row+="<td>"+resp[i].week_no+"</td>" 
            tbl_row+="<td>"+resp[i].telecaller_id+"</td>"   
            tbl_row+="<td>"+resp[i].telecaller_name+"</td>"     
            tbl_row+="<td>"+resp[i].call_status+"</td>"
            tbl_row+='<td><div style="max-width:50px !important;max-height:35px !important;overflow: hidden;" >'+resp[i].Remarks+'</div></td>';
            tbl_row+="<td>"+resp[i].name_of_seeker_final+"</td>"
            tbl_row+="<td>"+resp[i].contact_number_final+"</td>"    
            tbl_row+="<td>"+resp[i].email_id_final+"</td>"  
            tbl_row+="<td>"+resp[i].area_name_final+"</td>" 
            tbl_row+="<td>"+resp[i].city_final+"</td>"  
            tbl_row+="<td>"+resp[i].property_type+"</td>"   
            tbl_row+="<td>"+resp[i].bhk_info_final+"</td>"
            tbl_row+="<td>"+resp[i].min_budget_final+"</td>"
            tbl_row+="<td>"+resp[i].max_budget_final+"</td>"    
            tbl_row+="<td>"+resp[i].possession_category+"</td>"
            tbl_row+="<td>null</td>"
            tbl_row+="<td>null</td>"
            tbl_row+="<td>"+resp[i].plead_locality_match+"</td>"
            tbl_row+="<td>"+resp[i].plead_project_match+"</td>"
            tbl_row+="<td>"+resp[i].ram_zam+"</td>"
            tbl_row+="<td>"+resp[i].seeker_country+"</td>"
            tbl_row+="<td>"+resp[i].city_zone+"</td>"
              tbl_row+="<td>"+resp[i].total_promoted_leads+"</td>"
              tbl_row+="<td>"+resp[i].total_revenue+"</td>"
              tbl_row+="<td>"+resp[i].promoted_project_leads+"</td>"
              tbl_row+="<td>"+resp[i].name_projected_projects+"</td>"
              tbl_row+="<td>"+resp[i].povp_id_promoted_project+"</td>"
              tbl_row+="<td>"+resp[i].name_promoted_project+"</td>"
              tbl_row+="<td>"+resp[i].povp_id_promoted_project+"</td>"
              tbl_row+="<td>"+resp[i].call_follow_up_date+"</td>"
              tbl_row+="<td>"+resp[i].call_follow_up_time+"</td>"
            tbl_row+="</tr>";
            }
            tbl_row+="</tbody></table></div>";
            $('#DetailCallReport').html(tbl_row);
            $('#example3').DataTable({"paging":   true,"bLengthChange": false});
        }
        else{
            $("#calldetailrepDownloadbtn").css('display','none');
            tbl_row+="";
            $('#DetailCallReport').html(tbl_row);
            $('#example3').DataTable({"paging":   true,"bLengthChange": false});
        }
    }

    });

}
function downDetailCall(){
    $('#searchPending').modal('show');
    var start_date=$("#start_date1").val();
    var end_date=$("#end_date1").val();
    var cityVal=$("#city_name_call").val();
    console.log(cityVal);
    if(start_date==''){ start_date='N'; }
    if(end_date==''){ end_date='N'; }
    var agent_name=$("#agent_name_call").val();
    if(agent_name==''){ agent_name='N';}
    var p_intent=$("#primary_intent_call").val();
    if(p_intent==''){ p_intent='N';}
    var p_type=$("#ptype_call").val();
    if(p_type==''){ p_type='N';}
    var p_category=$("#category_call").val();
    if(p_category==''){ p_category='N';}
    var source=$("#source_call").val();
    if(source==''){ source='N';}
    var tl_name=$("#tl_name_call").val();
    if(tl_name==''){ tl_name='N';}
    if(cityVal==''){ cityVal='N';}
    var phone_no=$('#phone_no').val();
    if(phone_no==''){phone_no='N'};
    var getAgent={agent_name:agent_name,tl_name:tl_name,p_intent:p_intent,p_type:p_type,p_category:p_category,source:source,start_date:start_date,end_date:end_date,cityVal:cityVal,phone_no:phone_no,action:"val"};

    $.ajax({
        url: configAjax.jsRoutes[47].DetailCallRepDownload,
        type: "get",
        dataType: "json",
        data:getAgent,
        success: function(resp) {
            $('#searchPending').modal('hide');
            location.href=resp;
        }
    });
}


