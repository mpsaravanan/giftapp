<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Quikr Homes" />
    <title>Xpora Super User View | Quikr Homes</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}" />
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}" />
    <style type="text/css">
    .requiredstar{color:red;}
    </style>
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="javascript:void(0);">
                    <img class="hidden-xs" src="{{asset('images/XPORA_logo.jpg')}}" width="320px" />
                </a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
               <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>&nbsp; {{$_SESSION['username']}} &nbsp;<i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="javascript:void(0);" onclick="showProfile();"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="javascript:void(0);" onclick="showSettings();"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a style="cursor: pointer;" onclick="logOut();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search..." />
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="showDashboard();" ><i class="fa fa-key fa-fw"></i> My Status</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="showLeadform();" ><i class="fa fa-file-image-o fa-fw"></i> Lead Details</a>
                        </li>
                        <li>
                            <a  id="leave-submit" name="leave-submit" data-keyboard="false" data-backdrop="static" data-target="#myModalLeadform" data-toggle="modal" style="margin-right: 10px; display: block;color:red;" href="javascript:void(0);" style='color:red;'>
                            <i class="fa fa-sign-out"></i> I want to Take a Break
                            </a>                     
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

       <div id="page-wrapper" class="dashboardCont">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">My Status</h3>
                </div>
                <div class="col-lg-4 hidebutton pull-right" style="display:none;">
                    <input type="button" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" name="leave-submit" id="leave-submit" tabindex="3" class="form-control btn btn-danger" value="I want to Leave" />
                </div>
              
                 <div class="col-lg-12">
                 &nbsp;
                 </div>
                <div class="col-lg-4 showbutton">
                <div class="btn-group" data-toggle="buttons">
                  <!-- <button onclick="changeModeofCall('m');" class="btn btn-primary" id="manual_mode" style="border-bottom-right-radius: 5px;border-top-right-radius: 5px;margin-right:10px">
                    Manual Mode
                  </button> -->
                  <button onclick="changeModeofCall('a');" class="btn btn-primary" id="auto_mode" style="border-bottom-left-radius: 5px;border-top-left-radius: 5px;">
                    Ready To Take Call
                  </button>
                </div>
                 <!-- <input type="button" onclick="readyToGetCallsInventory();" name="ready-submit" id="ready-submit" tabindex="3" class="form-control btn btn-primary" value="I am ready" />-->
                </div>
                <div class="showManualDetails" style="display:none">
                <ul class="nav nav-tabs nav-pills">
                    <li class="active"><a href="#manual_call">To Be Called Manaully</a></li>
                    <li><a href="#assigned_call">Freshly Assigned Calls</a></li>
                </ul>
                <div class="tab-content">
                    <div id="manual_call" class="tab-pane fade in active">
                    <div class="col-lg-12" id="pendingreportFilter" style="display:none">
                        <div class="col-lg-2">
                        <div class="form-group">
                            <label for="date" class="control-label">Date<span class="requiredstar">*</span></label>
                            <input name="date" class="form-control date" id="date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-2">
                        <div class="form-group">
                            <label for="source" class="control-label">Source<span class="requiredstar">*</span></label>
                            <input name="source" class="form-control source" id="source" type="text"  value="" />
                        </div>
                        </div>
                       <div class="col-lg-2">
                       <div class="form-group">
                            <label for="category" class="control-label">Category<span class="requiredstar">*</span></label>
                            <input name="category" class="form-control category" id="category" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-2">
                       <div class="form-group">
                            <label for="prop_type" class="control-label">Property Type<span class="requiredstar">*</span></label>
                            <input name="prop_type" class="form-control prop_type" id="prop_type" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-2" style="display:none">
                       <div class="form-group">
                            <label for="disposition" class="control-label">Disposition Status<span class="requiredstar">*</span></label>
                            <div class="form-group" >
                            <select data-placeholder="Choose a disposition" class="chosen-select form-control" id="disposition" style="width:200px;" name="disposition" >
                                <option value="">Select</option>
                                <option  value="ENQUIRY">ENQUIRY</option>
                                <option  value="SPAM">SPAM</option>
                                <option  value="WRONG_PARTY">WRONG_PARTY</option>
                                <option  value="RIGHT_PARTY_NI">RIGHT_PARTY_NI</option>
                                <option  value="RIGHT_PARTY_INT_CL">RIGHT_PARTY_INT_CL</option>
                            </select>
                        </div>
                        </div>
                        </div>
                        
                        <div class="panel-body" style="margin-top:5px;">
                            <button class="btn btn-primary pull-right" type="button" onclick="manualMode();">Search</button>
                        </div>
                    </div>
                    <div id="PendingDetails" class="col-lg-12"></div>
                    
                    </div>
                    <div id="assigned_call"  class="tab-pane fade">
                    <div class="col-lg-10" id="assignedreportFilter" style="display:none">
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="adate" class="control-label">Date<span class="requiredstar">*</span></label>
                            <input name="adate" class="form-control adate" id="adate" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="asource" class="control-label">Source<span class="requiredstar">*</span></label>
                            <input name="asource" class="form-control asource" id="asource" type="text"  value="" />
                        </div>
                        </div>
                       <div class="col-lg-3">
                       <div class="form-group">
                            <label for="city" class="control-label">city<span class="requiredstar">*</span></label>
                            <input name="city" class="form-control city" id="city" type="text"  value="" />
                        </div>
                        </div>
                        
                        <div class="panel-body" style="margin-top:5px;">
                            <button class="btn btn-primary pull-right" type="button" onclick="assignedCall();">Search</button>
                        </div>
                    </div>
                    <div id="AssignedDetails" class="col-lg-12"></div>
                    
                    </div>
                </div>
                </div>
            </div>
                <!-- /.col-lg-12 -->

        </div>
        <div id="page-wrapper" class="leadformCont" style="display:none">
            <div class="row">
                <div id="leadFormdiv">
                </div>                
            </div>
                <!-- /.col-lg-12 -->
        </div>
        @include('profile') 
        <!-- /#page-wrapper -->
        <!-- Modal -->
          <div class="modal fade" id="myNotyfication" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-body">
                  <p>Are you ready to attend this Call?</p>
                    <div class="row">
                    <div class="col-sm-4 pull-right">
                        <input type="hidden" name="callaccept" id="callaccept" />
                        <button data-dismiss="modal" class="btn btn-success" type="button" onclick="showLeadform()">Accept</button>
                    </div>
                </div>
                </div>
             </div>
          </div>
        </div>
    </div>
    <input type="hidden" value="{{$_SESSION['userid']}}" name="tcEmpid" id="tcEmpid" />
    <input type="hidden" value="" name="disconnectlagAuuid" id="disconnectlagAuuid" />
    <input type="hidden" value="" name="holdlagAuuid" id="holdlagAuuid" />
    <input type="hidden" value="" name="holdlagBuuid" id="holdlagBuuid" />
    <input type="hidden" value="" name="holdCallmode" id="holdCallmode" />
    <input type="hidden" value="" name="holdagentidval" id="holdagentidval" />
    <input type="hidden" value="" name="holdreqval" id="holdreqval" />
    <input type="hidden" value="" name="telecallerMode" id="telecallerMode" />
    <div class="modal fade bs-example-modal-sm" id="myPleaseWait" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <span class="glyphicon glyphicon-time">
                        </span>Please wait !!! Don't press Back, Esc or Refresh
                     </h4>
                </div>
                <div class="modal-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-info
                        progress-bar-striped active"
                        style="width: 100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="modal fade bs-example-modal-sm" id="call_processing_event" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <span class="glyphicon glyphicon-time">
                        </span><label id="call_processTxt">Please Wait...</label>
                     </h4>
                     <div id="disconnectOption" style="display:none;">
                        <button id="disconnectOut"  onclick="disconnectCall();" class="btn btn-danger pull-right">Disconnect</button>
                     </div>
                </div>
                <div class="modal-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-info
                        progress-bar-striped active"
                        style="width: 100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
     <div class="modal fade bs-example-modal-sm" id="emailSmsSending" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <span class="glyphicon glyphicon-time">
                        </span>Please wait !!! Don't press Back or Refresh
                     </h4>
                </div>
                <div class="modal-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-info
                        progress-bar-striped active"
                        style="width: 100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#wrapper -->
          <div class="modal fade" id="myModalLeadform" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Reason for Leaving:</h4>
            </div>
            <form class="editProfile" name="break_reason">
            <div class="modal-body">
                <div class="form-group" style="line-height:1.0;">
                    <label  for="reason" class="control-label">Reason:<span class="requiredstar">*</span></label>
                    <select data-placeholder="Choose a reason" class="chosen-select form-control" id="brk_reason" style="width:200px;" name="disposition" >
                                <option value="">Select</option>
                                <option  value="Tea">Tea</option>
                                <option  value="Lunch">Lunch</option>
                                <option  value="Training">Training</option>
                                <option  value="TL Briefing">TL Briefing</option>
                                <option  value="QA Feedback">QA Feedback</option>
                                <option  value="IT Downtime">IT Downtime</option>
                                <option  value="Others">Others</option>
                            </select>
                </div>
                <table cellspacing="0" border="1" style="font-size: 12px; width: 50%;">
                    <tbody>
                    <tr><th>S.No</th>
                        <th>Reason</th>
                        <th>Permissible Time</th>
                    </tr>
                    <tr><td>1</td>
                        <td>Tea</td>
                        <td> 30 Minutes</td>
                    </tr>
                    <tr><td>2</td>
                        <td>Lunch</td>
                        <td> 30 Minutes</td>
                    </tr>
                    <tr><td>3</td>
                        <td>Training</td>
                        <td> 1 Hour</td>
                    </tr>
                    <tr><td>4</td>
                        <td>TL Briefing</td>
                        <td> 15 Minutes</td>
                    </tr>
                    <tr><td>5</td>
                        <td>QA Feedback</td>
                        <td> 15 Minutes</td>
                    </tr>
                    <tr><td>6</td>
                        <td>IT Downtime</td>
                        <td> #NA</td>
                    </tr>
                    <tr><td>7</td>
                        <td>Others</td>
                        <td> 1 Hour</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                 <input name="_token" id="_token" type="hidden" value="{!! csrf_token() !!}" />
              <button class="btn btn-primary pull-right" type="button" onclick="brkReasonLeadform();">Submit</button>
            </div>
            </form>
          </div><!-- Modal content Ends Here-->
        </div>
      </div><!-- Modal Ends Here-->
       <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Reason for Leaving:</h4>
            </div>
            <form class="editProfile" name="break_reason">
            <div class="modal-body">
                <div class="form-group" style="line-height:1.0;">
                    <label  for="reason" class="control-label">Reason:<span class="requiredstar">*</span></label>
                    <select data-placeholder="Choose a reason" class="chosen-select form-control" id="brk_reason1" style="width:200px;" name="disposition" >
                                <option value="">Select</option>
                                <option  value="Tea">Tea</option>
                                <option  value="Lunch">Lunch</option>
                                <option  value="Training">Training</option>
                                <option  value="TL Briefing">TL Briefing</option>
                                <option  value="QA Feedback">QA Feedback</option>
                                <option  value="IT Downtime">IT Downtime</option>
                                <option  value="Others">Others</option>
                            </select>
                </div>
                <table cellspacing="0" border="1" style="font-size: 12px; width: 50%;">
                    <tbody>
                    <tr><th>S.No</th>
                        <th>Reason</th>
                        <th>Permissible Time</th>
                    </tr>
                    <tr><td>1</td>
                        <td>Tea</td>
                        <td> 30 Minutes</td>
                    </tr>
                    <tr><td>2</td>
                        <td>Lunch</td>
                        <td> 30 Minutes</td>
                    </tr>
                    <tr><td>3</td>
                        <td>Training</td>
                        <td> 1 Hour</td>
                    </tr>
                    <tr><td>4</td>
                        <td>TL Briefing</td>
                        <td> 15 Minutes</td>
                    </tr>
                    <tr><td>5</td>
                        <td>QA Feedback</td>
                        <td> 15 Minutes</td>
                    </tr>
                    <tr><td>6</td>
                        <td>IT Downtime</td>
                        <td> #NA</td>
                    </tr>
                    <tr><td>7</td>
                        <td>Others</td>
                        <td> 1 Hour</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                 <input name="_token" id="_token" type="hidden" value="{!! csrf_token() !!}" />
              <button class="btn btn-primary pull-right" type="button" onclick="brkReason();">Submit</button>
            </div>
            </form>
          </div><!-- Modal content Ends Here-->
        </div>
      </div><!-- Modal Ends Here-->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.js') }}"></script>
<script type="text/javascript">
var configAjax = { jsRoutes: [
                    { Updatepassword: "{{ route('Updatepassword') }}" },//0
                    { ReadyTogetCall: "{{ route('ReadyTogetCall') }}" },//1
                    { ReadyToLeaveCall: "{{ route('ReadyToLeaveCall') }}" },//2
                    { CallstatusOnPusher: "{{ route('CallstatusOnPusher') }}" },//3 
                    { Manualmode: "{{ route('Manualmode') }}" },//4
                    { ManualCall: "{{ route('ManualCall') }}" },//5  
                    { Assignedcall: "{{ route('Assignedcall') }}" },//6   
                    { AssignCall: "{{ route('AssignCall') }}" },//7  
                    { DisconnectCall: "{{ route('DisconnectCall') }}" }, //8        
                    { CheckagentMode: "{{ route('CheckagentMode') }}" }, //9   
                    { Logout: "{{ route('Logout') }}" }, //10   
                    { InitNextAutoCall: "{{ route('InitNextAutoCall') }}" }, //11  
                    { BrkReason: "{{ route('BrkReason') }}" }, //12  
                    { BrkReasonfromLeadform: "{{ route('BrkReasonfromLeadform') }}" }, //13
                    { inCallstatusOnPusher: "{{ route('inCallstatusOnPusher') }}" },//14
                    { CronBackbuttonClick: "{{ route('CronBackbuttonClick') }}" }//15              
                   ] };
$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
$(document).ready(function(){
   $('#example1').DataTable(); 
   $(".nav-tabs a").click(function(){
        $(this).tab('show');
    });
   $("#adate").datepicker({ dateFormat: "yy-mm-dd" });
   $("#date").datepicker({ dateFormat: "yy-mm-dd" });
   /* Check User Mode */
    refreshPage('page');    
});
function runCron(){
    $.ajax({
        url: configAjax.jsRoutes[15].CronBackbuttonClick,
        type:"get",
        dataType: "json",
        success: function(resp){
        }
    });
}
function refreshPage(elem){
    $('#myPleaseWait').modal('show'); 
    if(typeof(localStorage) !== "undefined") {
        var localstorageid = localStorage.getItem("requirement_id"); 
    }
    else{
        var localstorageid="";
    }
    var req_id=localstorageid;
    $.ajax({
        url: configAjax.jsRoutes[9].CheckagentMode,
        type:"get",
        dataType: "json",
        data:{type:elem,req_id:req_id},
        success: function(resp){
            $('#myPleaseWait').modal('hide'); 
            if(resp.mode=="manual"){
                    $("#telecallerMode").val('m');
                    localStorage.setItem("requirement_id","");
                    //alert("Manual");
                    showDashboard();
                    changeModeofCall('m');
                }
                else if(resp.mode=="auto"){
                    //alert("Auto");
                    $("#telecallerMode").val('a');
                    localStorage.setItem("requirement_id","");
                    showDashboard();
                    $("#leave-submit").val("I want to Leave") ;
                    $(".showbutton").css("display","none"); 
                    $("#pendingreportFilter").css("display","none");
                    $("#PendingDetails").css("display","none"); 
                    $(".hidebutton").css("display","block");
                    runCron();
                }
                else if (resp.mode.indexOf('cookie') !== -1) {
                   var req_idval = resp.mode.split("_"); 
                   if(req_idval!='' && req_idval!='0'){
                        $(".leadformCont").css('display','block');
                        $(".dashboardCont").css('display','none');
                        $(".showSettings").css('display','none');
                        $(".showProfile").css('display','none');
                        getLeadform(req_idval[1]); 
                    }else{
                        localStorage.setItem("requirement_id","");
                        $(".dashboardCont").css('display','block');
                        $(".showSettings").css('display','none');
                        $(".showProfile").css('display','none');
                        $(".leadformCont").css('display','none');
                    }                    
                }
                else{
                    localStorage.setItem("requirement_id","");
                    $(".dashboardCont").css('display','block');
                    $(".showSettings").css('display','none');
                    $(".showProfile").css('display','none');
                    $(".leadformCont").css('display','none');
                }
            }
        });
}
function changeModeofCall(elem){
    if(elem=='m'){
        manualMode();
        assignedCall();
        $("#telecallerMode").val('m');
    }
    else{
        $("#telecallerMode").val('a');
        readyToGetCallsInventory();
    }
}   
function manualMode(){
    var tc_id='{{$_SESSION['userid']}}';
    var source=$("#source").val();
    var category=$("#category").val();
    var disposition=$("#disposition").val();
    var prop_type=$("#prop_type").val();
    var date=$("#date").val();
    var getVal={tc_id:tc_id,source:source,category:category,disposition:disposition,prop_type:prop_type,date:date};
    $.ajax({
        url: configAjax.jsRoutes[4].Manualmode,
        type:"get",
        data:getVal,
        dataType: "json",
        success: function(resp){
            $("#autoMode").css('display','none');
            $(".showbutton").css('display','none');
             $(".hidebutton").css("display","block");
             $(".showManualDetails").css("display","block");
             $("#pendingreportFilter").css("display","block");
             $("#PendingDetails").css("display","block"); 
             //$("#AssignedDetails").css("display","block"); 
             //$("#assignedreportFilter").css("display","none");
             $("#leave-submit").val("I want to Leave Manual Mode") ;
            var tbl_row='<div class="col-sm-12" id="searchTable">';
                tbl_row+='<table id="example7" style="font-size:9px;" class="table table-striped table-bordered" cellspacing="0" width="100%">';
                tbl_row+='<thead><tr style="background:#6F6F6F;color:#fff;"><th>Date/Time</th><th>Telecaller Name</th><th>(Competency Profile)City</th><th>Source</th><th>Category</th><th>Property type</th><th>Dialer Call Cause Status</th><th>Buyer No</th><th>Action</th></tr></thead>';
                tbl_row+='<tbody id="app_table_body">';
          if(resp.length>=1){
              for(var i=0;i<resp.length;i++){
                
                tbl_row+="<tr>";
                tbl_row+="<td>"+resp[i].datetime+"</td>";
               // tbl_row+="<td>"+resp[i].req_username+"</td>";
                tbl_row+="<td>"+resp[i].agent_name+"</td>";
                tbl_row+="<td>"+resp[i].city+"</td>";
                tbl_row+="<td>"+resp[i].source+"</td>";
                tbl_row+="<td>"+resp[i].category+"</td>";
                tbl_row+="<td>"+resp[i].property_types+"</td>";
                //tbl_row+="<td>"+resp[i].dis_status+"</td>";
                tbl_row+="<td>"+resp[i].call_status+"</td>";
                tbl_row+="<td>"+resp[i].seeker_no+"</td>";
                tbl_row+="<td><button type='button' onclick='Manualcall("+resp[i].req_id+","+resp[i].agent_id+","+resp[i].sip_no+","+resp[i].seeker_no+");openLeadform("+resp[i].req_id+");' class='btn btn-primary'>Call</button></td>";
                tbl_row+="</tr>";
                }
                tbl_row+="</tbody></table></div>";
                $('#PendingDetails').html(tbl_row);
                $('#example7').DataTable();
            }
            else{
                tbl_row+="</tbody></table></div>";
                tbl_row+="";
                $('#PendingDetails').html(tbl_row);
                $('#example7').DataTable();
            } 
        }    
      });
}
function assignedCall(){
    var tc_id='{{$_SESSION['userid']}}';
    //var tc_name=$("#tc_name").val();
    var date=$("#adate").val();
    var source=$("#asource").val();
    var city=$("#city").val();
    var getValue={tc_id:tc_id,date:date,source:source,city:city};
    $.ajax({
        url: configAjax.jsRoutes[6].Assignedcall,
        type:"get",
        data:getValue,
        dataType: "json",
        success: function(resp){
            $("#autoMode").css('display','none');
            $(".showbutton").css('display','none');
             $(".hidebutton").css("display","block");
             $(".showManualDetails").css("display","block");
             //$("#pendingreportFilter").css("display","none");
             $("#assignedreportFilter").css("display","block");
             $("#assignedreportFilter").css("display","block");
             //$("#PendingDetails").css("display","none"); 
             $("#leave-submit").val("I want to Leave Manual Mode") ;
            var tbl_row='<div class="col-sm-12" id="searchTable">';
                tbl_row+='<table id="example9" style="font-size:9px;" class="table table-striped table-bordered" cellspacing="0" width="100%">';
                tbl_row+='<thead><tr style="background:#6F6F6F;color:#fff;"><th>Assigned Date</th><th>Requirement Id</th><th>Telecaller Name</th><th>City</th><th>Source</th><th>Buyer Number</th><th>Assigned By</th><th>Action</th></tr></thead>';
                tbl_row+='<tbody id="app_table_body">';
          if(resp.length>=1){
            if(resp.status=='success'){
              for(var i=0;i<resp.length;i++){
                
                tbl_row+="<tr>";
                tbl_row+="<td>"+resp[i].datetime+"</td>";
                tbl_row+="<td>"+resp[i].req_id+"</td>";
                tbl_row+="<td>"+resp[i].agent_name+"</td>";
                tbl_row+="<td>"+resp[i].city+"</td>";
                tbl_row+="<td>"+resp[i].source+"</td>";
                tbl_row+="<td>"+resp[i].seeker_no+"</td>";
                tbl_row+="<td>"+resp[i].assigned_by+"</td>";
                tbl_row+="<td><button type='button' onclick='assignCall("+resp[i].outbound_id+","+resp[i].req_id+","+resp[i].agent_id+","+resp[i].sip_no+","+resp[i].seeker_no+");openLeadform("+resp[i].req_id+");' class='btn btn-primary'>Call</button></td>";
                tbl_row+="</tr>";
                }
            }
            else{
                location.reload();
            }
                tbl_row+="</tbody></table></div>";
                $('#AssignedDetails').html(tbl_row);
                $('#example9').DataTable();
            }
            else{
                tbl_row+="</tbody></table></div>";
                tbl_row+="";
                $('#AssignedDetails').html(tbl_row);
                $('#example9').DataTable();
            } 
        }    
      });
}
function readyToGetCallsInventory(){ 
    var ready="1";
    $.ajax({
        url: configAjax.jsRoutes[1].ReadyTogetCall,
        type:"get",
        dataType: "json",
        success: function(resp){
            if(resp.status=='success'){ 
               $("#leave-submit").val("I want to Leave") ;
               $(".showbutton").css("display","none"); 
               $("#pendingreportFilter").css("display","none");
               $("#PendingDetails").css("display","none"); 
               $(".hidebutton").css("display","block"); 
               alert("Ready to take call");
               //$("#form-content").modal('hide');
               //location.reload();
            }
            else if(resp.status=='logout'){
                location.reload();
            }
            else{
               alert("Error: Please try Again");
               //location.reload();
            }
        }    
      });
 }

function readyToLeaveCallsInventory(val){ 
    var ready="1";
    $("#telecallerMode").val('');
    $.ajax({
        url: configAjax.jsRoutes[2].ReadyToLeaveCall,
        type:"get",
        dataType: "json",
        data:{pick_call_status:val,manual_call_status:val},
        success: function(resp){
            if(resp.status=='Auto-success'){ 
               $(".showbutton").css("display","block"); 
               $(".hidebutton").css("display","none");
               $("#pendingreportFilter").css("display","none");
               $("#PendingDetails").css("display","none"); 
               $(".showManualDetails").css("display","none");
               //alert("Need rest");
                //$("#form-content").modal('hide');
               //location.reload();
            }
            else if(resp.status=='Manual-success'){ 
               $(".showbutton").css("display","block"); 
               $("#autoMode").css('display','block');
               $(".hidebutton").css("display","none");
               $("#pendingreportFilter").css("display","none");
               $("#PendingDetails").css("display","none");  
               $(".showManualDetails").css("display","none");
               //alert("Need rest");
                //$("#form-content").modal('hide');
               //location.reload();
            }
            else if(resp.status=='logout'){
                location.reload();
            } 
            else{
               alert("Error: Please try Again");
               //location.reload();
            }
        }    
      });
 }
 function Manualcall(req_id,tc_id,sip_no,seeker_no){
    $('#myPleaseWait').modal('show'); 
    $('#disconnectOption').css('display','none');
    getValue={req_id:req_id,tc_id:tc_id,sip_no:sip_no,seeker_no:seeker_no};
    $.ajax({
        url: configAjax.jsRoutes[5].ManualCall,
        type:"get",
        dataType: "json",
        data:getValue,
        success: function(resp){
        }
    });
 }
 function assignCall(outbound_id,r_id,tc_id,s_no,sk_no){
   $('#myPleaseWait').modal('show'); 
   getV={outbound_id:outbound_id,r_id:r_id,tc_id:tc_id,s_no:s_no,sk_no:sk_no};
    $.ajax({
        url: configAjax.jsRoutes[7].AssignCall,
        type:"get",
        dataType: "json",
        data:getV,
        success: function(resp){

        }
    }); 
 }
function callStatus(elem){
    $.ajax({
        url: configAjax.jsRoutes[3].CallstatusOnPusher,
        type:"get",
        dataType: "json",
        data:{agentid:elem},
        success: function(resp){
            console.log("updated");
        }
    });
}
function incallStatus(elem,status){
    $.ajax({
        url: configAjax.jsRoutes[14].inCallstatusOnPusher,
        type:"get",
        dataType: "json",
        data:{agentid:elem,status:status},
        success: function(resp){
            console.log("updated");
        }
    });
}
function showDashboard(){
    $(".dashboardCont").css('display','block');
    $(".showSettings").css('display','none');
    $(".showProfile").css('display','none');
    $(".leadformCont").css('display','none');
}
function showLeadform(){
    pauseAudio();
    var reqid=$('#callaccept').val();
    localStorage.setItem("requirement_id",reqid);
    $(".leadformCont").css('display','block');
    $(".dashboardCont").css('display','none');
    $(".showSettings").css('display','none');
    $(".showProfile").css('display','none');
        if(reqid!=''){
            $(".leadformCont").css('display','block');
            $(".dashboardCont").css('display','none');
            $(".showSettings").css('display','none');
            $(".showProfile").css('display','none');
            getLeadform(reqid);
        }
        else{
            $(".dashboardCont").css('display','block');
            $(".showSettings").css('display','none');
            $(".showProfile").css('display','none');
            $(".leadformCont").css('display','none');
        }
}
function openLeadform(elem){
    $('#callaccept').val(elem);
    showLeadform();
}
function showProfile(){
    $(".dashboardCont").css('display','none');
    $(".showSettings").css('display','none');
    $(".showProfile").css('display','block');
    $(".leadformCont").css('display','none');
}
function showSettings(){
    $(".dashboardCont").css('display','none');
    $(".showSettings").css('display','block');
    $(".showProfile").css('display','none');
    $(".leadformCont").css('display','none');
}

function resetPassword(){
    var pass1=$("#inputPassword").val();
    var pass2=$("#inputConfirm").val();
    if(pass1=="" || pass2==""){
        $("#errormsg").html("*Enter Password");
        return false;
        }
    if(pass1!=pass2){
        $("#errormsg").html("*Password not Matching");
        return false;
        }
    $.ajax({
        url: configAjax.jsRoutes[0].Updatepassword,
        type:"post",
        dataType: "json",
        data:$('#reset-form').serialize(),
        success: function(resp) {
          if(resp.status=="success"){
            $("#errormsg").css('color','green');
            $('#reset-form')[0].reset();
            $("#errormsg").html("Password Updated Successfully");
          }
          else{
            $("#errormsg").html(resp.message);
          }
        }
      });
}
function getLeadform(elem){
     var iframhtml='<iframe src="Leadform/'+elem+'" style="width:100%;height:800px;"></iframe>';
     $("#leadFormdiv").html(iframhtml);
}
var fileaudio="{{ asset('audio/alarm.mp3') }}";
var audio = new Audio(fileaudio);
function playAudio(){
    audio.play();
}
function pauseAudio(){
    audio.pause();
}
</script>
<script src="{{ asset('js/pusher.min.js') }}"></script>
<script>

if (window.location.href.indexOf('172.16.31.128') !== -1) {
    var pusher_api_key='efbb477895cc9a43c152';
}
else{
    var pusher_api_key='4fa9e83244b0df66a057';
}
// Enable pusher logging - don't include this in production
Pusher.log = function(message) {
  if (window.console && window.console.log) {
    window.console.log(message);
  }
};

var pusher = new Pusher(pusher_api_key, {
  encrypted: true
});

var channel = pusher.subscribe('<?php echo $_SESSION['userid']; ?>');
var channel2 = pusher.subscribe('<?php echo $_SESSION['userid']; ?>'+"012345");
var channel3 = pusher.subscribe('<?php echo $_SESSION['userid']; ?>'+"012345_call");
var channel4 = pusher.subscribe('<?php echo $_SESSION['userid']; ?>'+"012345_Leadform");
channel.bind('my_event', function(data) {
  $('#myPleaseWait').modal('hide'); 
  $('#call_processing_event').modal('hide'); 
  $('#disconnectOption').css('display','none'); 
  $('#callaccept').val(data.req_id);
  $('#holdlagAuuid').val(data.lagAuuid);
  $('#holdCallmode').val(data.call_modenew);
  $('#disconnectlagAuuid').val(data.lagAuuid);
  $('#holdlagBuuid').val(data.lagBuuid);
  $('#holdagentidval').val(data.agentid);
  $('#holdreqval').val(data.req_id);
  playAudio();
  callStatus('<?php echo $_SESSION['userid']; ?>');
  incallStatus('<?php echo $_SESSION['userid']; ?>','connected');
  showLeadform();
});
channel2.bind('my_eventfailed', function(data) {
  $('#myPleaseWait').modal('hide'); 
  $('#call_processing_event').modal('hide'); 
  $('#disconnectOption').css('display','none'); 
  alert("Call could not be connected Right Now! Try Later.");
});
channel3.bind('my_event_callprocessing', function(data) {
    $('#myPleaseWait').modal('hide');
    $('#call_processTxt').html(data.status);
    $('#call_processing_event').modal('show'); 
    $('#disconnectlagAuuid').val(data.lagAuiid_id);
    $('#disconnectOption').css('display','none'); 
    if(data.status=='Dialing'){
        incallStatus('<?php echo $_SESSION['userid']; ?>','dialing');
    }
    if(data.status=='Ringing'){
        incallStatus('<?php echo $_SESSION['userid']; ?>','ringing');
    }
    setTimeout(function() { showboxDisconnect(); },10000);
});
channel4.bind('my_event_open_leadform', function(data) {
    openLeadform(data.req_id);
});
function showboxDisconnect(){
    $('#disconnectOption').css('display','block'); 
}
function disconnectCall(){

    $("#disconnectOut").prop('disabled',true);
    $("#disconnectOut").html('Please Wait..');
        var lagaUiid=$('#disconnectlagAuuid').val();
         $.ajax({
            url: configAjax.jsRoutes[8].DisconnectCall,
            type:"get",
            dataType: "json",
            data:{lagaUiid:lagaUiid,agent_id:'<?php echo $_SESSION['userid']; ?>'},
            success: function(resp) {
                $("#disconnectOut").prop('disabled',false);
                $("#disconnectOut").html('Disconnect');
                if(resp.status=='success'){
                    $('#myPleaseWait').modal('hide'); 
                    $('#call_processing_event').modal('hide'); 
                    $('#disconnectOption').css('display','none');
                    alert("Call Disconnected Successfully");
                }
            }
         });
}
function brkReason(){
    var break_reason=$("#brk_reason1").val();
    var leaveMode=$("#leave-submit").val();
    if(break_reason==''){
        alert("Please select any one of the reason");
        return false;
    }
    $.ajax({
        url: configAjax.jsRoutes[12].BrkReason,
        type:"get",
        dataType: "json",
        data:{break_reason:break_reason},
        success: function(resp) {
            if(resp.status=='success'){
                //alert("Break Details Added");
                $("#myModal").modal('hide');
                location.reload();
                //readyToLeaveCallsInventory(leaveMode);
                //location.reload();
            }
            else if(resp.status=='logout'){
              location.reload();  
            }
        }
    });
}
function dropDownconfig(){
    var config = {
      '.chosen-select'           : {},
      '.chosen-select'           : {max_selected_options: 1},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
}
function logOut(){
    localStorage.setItem("requirement_id","");
     $.ajax({
        url: configAjax.jsRoutes[10].Logout,
        type:"get",
        success: function(resp) {
            location.reload();
        }
     });
}
function brkReasonLeadform(){
    var r = confirm("Are You Sure Want to Leave?");
    if (r != true) {
        return false;
    } 
    localStorage.setItem("requirement_id","");
    var req_id=$('#callaccept').val();
    var break_reason=$("#brk_reason").val();
    var leaveMode=$("#leave-submit").val();
    if(break_reason==''){
        alert("Please select any one of the reason");
        return false;
    }
    $.ajax({
        url: configAjax.jsRoutes[13].BrkReasonfromLeadform,
        type:"get",
        dataType: "json",
        data:{break_reason:break_reason,req_id:req_id},
        success: function(resp) {
            if(resp.status=='success'){
                //alert("Break Details Added");
                $("#myModalLeadform").modal('hide');
                //readyToLeaveCallsInventory(leaveMode);
                location.reload();
            }
            else if(resp.status=='logout'){
                location.reload();
            }
        }
    });
}
</script>
</head>
</body>
</html>
