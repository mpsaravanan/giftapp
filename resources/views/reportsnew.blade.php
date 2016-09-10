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
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/chosen_multiselect.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}" />
    <link type="text/css" href="{{ asset('css/jquery.simple-dtpicker.css')}}" rel="stylesheet" />
    <style type="text/css">
        .requiredstar{color:red;}
        .chosen-rtl .chosen-drop { left: -9000px; }
        .text-overflow {
            width:50px;
            display:block;
            overflow:hidden;
        }
        .btn-overflow {
            display: none;
            text-decoration: none;
        }
        .freeclass{
            background-color: #f1f24f;color:darkgreen;text-align: center;font-weight:bold;
        }
        .idleclass{
            background-color: #e0ac40;color:ghostwhite;text-align: center;font-weight:bold;
        }
        .incallclass{
            background-color: darkgreen;color:yellow;text-align: center;font-weight:bold;
        }
        .ringingclass{
            background-color: #a479e2;color:whitesmoke;text-align: center;font-weight:bold;
        }
        .dialingclass{
            background-color: #C40D0D;color:whitesmoke;text-align: center;font-weight:bold;
        }
        .otherclass{
            background-color: red;color:whitesmoke;text-align: center;font-weight:bold;
        }
    </style>

</head>
<body style="background-color: #fff;">
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-brand" href="Userview">
                <img class="hidden-xs"  src="{{asset('images/XPORA_logo.jpg')}}"  width="320px" />
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
                    <li><a href="Logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
<div>
    <div id="col-lg-12" class="showReportDetails" style="display:block;margin:10px;">
        <ul class="nav nav-tabs nav-pills">
            <li class="active"><a href="#agent">Agent</a></li>
            <li><a href="#detail_call_report" >Detail Call Report</a></li>
        </ul>
        <div class="tab-content">
            <div id="agent" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Agent Details<label style="font-size:14px;font-weight:normal;">&nbsp;(Leave blank to select all)</label></h3>
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group" id="city_agent">
                                    <label for="city_name_agent" class="control-label">City</label>
                                    <select data-placeholder="Choose a City" class="chosen-select form-control" id="city_name_agent" style="width:240px;"  multiple name="city_name_agent" >
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" id="agentnames_list">
                                    <label class="control-label">Agent Name</label>
                                    <select  class="chosen-select form-control" id="agent_name_agent" style="width:240px;"  multiple name="agent_name_agent[]" >
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" id="tlnames_list">
                                    <label  class="control-label">TL Name</label>
                                    <select  class="chosen-select form-control" id="tl_name_agent" style="width:240px;"  multiple name="tl_name_agent[]" >
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" id="mgrnames_list">
                                    <label class="control-label">Manager Name</label>
                                    <select  class="chosen-select form-control" id="mgr_name_agent" style="width:240px;"  multiple name="mgr_name_agent[]" >
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="startDate" class="control-label">Start Date</label>
                                        <input name="start_date" class="form-control start_date" id="start_date" type="text"  value="" />
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="endDate" class="control-label">End Date</label>
                                        <input name="end_date" class="form-control end_date" id="end_date" type="text"  value="" />
                                    </div>
                                </div>
                                <div class="panel-body" style="margin-top:5px;">
                                    <button class="btn btn-primary pull-right" type="button" onclick="showAgentSummaryReportMongo();">Search</button>
                                    <button style="margin-right:5px;display: none;" id="agentdetailrepDownloadbtn" class="btn btn-primary pull-right" onclick="downLoadTable('agentDetailreportMongo');">Download</button>
                                </div>
                            </div>

                  <!--  </div> -->
                </div>
                <div id="AgentDetails"></div>
            </div>
        </div>

            <div id="detail_call_report" class="tab-pane fade">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Detail Call Report<label style="font-size:14px;font-weight:normal;">&nbsp;(Leave blank to select all)</label></h3>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                            <div class="form-group" id="city_name_dc">
                                <label class="control-label">City</label>
                                <select data-placeholder="Choose a City" class="chosen-select" id="city_name_call" style="width:230px;" multiple name="city_name_call" >
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group" id="agentnames_list1">
                                <label class="control-label">Agent Name</label>
                                <select  class="chosen-select form-control" id="agent_name_call" style="width:240px;"  multiple name="agent_name_call[]" >
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group" id="tlnames_list1">
                                <label class="control-label">TL Name</label>
                                <select  class="chosen-select form-control" id="tl_name_call" style="width:240px;"  multiple name="tl_name_call[]" >
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="control-label">Primary Intent</label>
                                <select  class="chosen-select form-control" id="primary_intent_call" style="width:240px;"  multiple name="primary_intent_call[]" >
                                    <option value="buy">Buy</option>
                                    <option value="Sale">Sale</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="city_name_agent" class="control-label">Category &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <select  class="chosen-select form-control" id="category_call" style="width:240px;"  multiple name="category_call[]" >
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Agriculture">Agriculture</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="city_name_agent" class="control-label">Property Type</label>
                                <select  class="chosen-select form-control" id="ptype_call" style="width:240px;"  multiple name="ptype_call[]" >
                                    <option value="Apartment">Apartment</option>
                                    <option value="Villa">Villa</option>
                                    <option value="Plot">Plot</option>
                                    <option value="Shop">Shop</option>
                                    <option value="Complex">Complex</option>
                                    <option value="Office">Office</option>
                                    <option value="Land">Land</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="city_name_agent" class="control-label">Source</label>
                                <select  class="chosen-select form-control" id="source_call" style="width:340px;"  multiple name="source_call[]" >
                                    <option value="CF_LISTING_RESPONSE_FLOW">CF_LISTING_RESPONSE_FLOW</option>
                                    <option value="CF_LOCALITY_FLOW">CF_LOCALITY_FLOW</option>
                                    <option value="CF_POST_REQUIREMENT_FLOW">CF_POST_REQUIREMENT_FLOW</option>
                                    <option value="CF_PROJECT_ENQUIRE_NOW_FLOW">CF_PROJECT_ENQUIRE_NOW_FLOW</option>
                                    <option value="CF_PROJECT_VN_CONTACT_FLOW">CF_PROJECT_VN_CONTACT_FLOW</option>
                                    <option value="CHAT_IN_LISTING">CHAT_IN_LISTING</option>
                                    <option value="CLICK_TO_CALL_IN_LISTING">CLICK_TO_CALL_IN_LISTING</option>
                                    <option value="CLICK_TO_VIEW_IN_BUILDER">CLICK_TO_VIEW_IN_BUILDER</option>
                                    <option value="CLICK_TO_VIEW_IN_LISTING">CLICK_TO_VIEW_IN_LISTING</option>
                                    <option value="CONTACT_IN_LISTING_FLP">CONTACT_IN_LISTING_FLP</option>
                                    <option value="CONTACT_IN_LISTING_INDIVIDUAL">CONTACT_IN_LISTING_INDIVIDUAL</option>
                                    <option value="CONTACT_IN_LISTING_LOCALITY">CONTACT_IN_LISTING_LOCALITY</option>
                                    <option value="CONTACT_IN_LISTING_PROJECT">CONTACT_IN_LISTING_PROJECT</option>
                                    <option value="CONTACT_IN_LISTING_SNB">CONTACT_IN_LISTING_SNB</option>
                                    <option value="ENQUIRY">ENQUIRY</option>
                                    <option value="HOME_PAGE_ALERT">HOME_PAGE_ALERT</option>
                                    <option value="IM_INTERESTED_IN_BUILDER">IM_INTERESTED_IN_BUILDER</option>
                                    <option value="IM_INTERESTED_IN_PROJECT">IM_INTERESTED_IN_PROJECT</option>
                                    <option value="LEMS_REPLY_IN_LISTING">LEMS_REPLY_IN_LISTING</option>
                                    <option value="MICROSITE">MICROSITE</option>
                                    <option value="MICROSITE_FORMFILL">MICROSITE_FORMFILL</option>
                                    <option value="MICROSITE_POPUP">MICROSITE_POPUP</option>
                                    <option value="PROJECT_CONTACT_IN_BUILDER">PROJECT_CONTACT_IN_BUILDER</option>
                                    <option value="PROJECT_CONTACT_IN_PROJECT">PROJECT_CONTACT_IN_PROJECT</option>
                                    <option value="PROJECT_CONTACT_IN_SNB">PROJECT_CONTACT_IN_SNB</option>
                                    <option value="QC">QC</option>
                                    <option value="REQUIREMENT_POPUP">REQUIREMENT_POPUP</option>
                                    <option value="WANT_AD">WANT_AD</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="phoneno" class="control-label">Phone No</label>
                                <input name="phoneno" class="form-control dc_phoneno" id="phone_no" type="text"  value="" />
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="startDate" class="control-label">Start Date of Call</label>
                                <input name="start_date" class="form-control dc_start_date" id="start_date1" type="text"  value="" />
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="endDate" class="control-label">End Date of Call</label>
                                <input name="end_date" class="form-control dc_end_date" id="end_date1" type="text"  value="" />
                            </div>
                        </div>
                        <div class="panel-body" style="margin-top:5px;">
                            <!--<button class="btn btn-primary pull-right" type="button" onclick="filterdetailReport(1);">Search</button>-->
                            <button class="btn btn-primary pull-right" type="button" onclick="showCallDetailreportMongo();">Search</button>
                            <button style="margin-right:5px;display: none;" id="calldetailrepDownloadbtn" class="btn btn-primary pull-right" onclick="downDetailCall();">Download</button>
                            <span id="downloadLinkDR"></span>
                        </div>
                    </div>
                </div>
                <div id="DetailCallReport"></div>
                <div id="DetailCallReportPaging"></div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm" id="searchPending" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                            <span class="glyphicon glyphicon-time">
                            </span>Please wait...
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
</div>
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('js/chosen.jquery.js') }}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.simple-dtpicker.js')}}"></script>
        <script type="text/javascript">
            var configAjax = { jsRoutes: [
                { Updatepassword: "{{ route('Updatepassword') }}" },//0
                { Createagentpost: "{{ route('Createagentpost') }}" },//1
                { Reportingto: "{{ route('Reportingto') }}" },//2
                { Deleteuser: "{{ route('Deleteuser') }}" },//3
                { Edituser: "{{ route('Edituser') }}" },//4
                { Getcity: "{{ route('Getcity') }}" },//5
                { Getlocation: "{{ route('Getlocation') }}" },//6
                { Getproject: "{{ route('Getproject') }}" },//7
                { createCompetency: "{{ route('createCompetency') }}" },//8
                { Agentdetails: "{{ route('Agentdetails') }}" },//9
                { ExistCompetency: "{{ route('Getuserexist') }}" },//10
                { NewCompetency: "{{ route('Getusernew') }}" },//11
                { Getavailsipnumber: "{{ route('Getavailsipnumber') }}" },//12
                { filterDashboard: "{{route('filterDashboard') }}" },//13
                { CallDetailReport: "{{route('CallDetailReport') }}" },//14
                { TotalLoginReport: "{{route('TotalLoginReport') }}" },//15
                { CampaignReport: "{{route('CampaignReport') }}" },//16
                { AgentLoggedinReport: "{{route('AgentLoggedinReport') }}" },//17
                { Viewcompetency: "{{ route('ViewCompetency') }}" },//18
                { PendingReport: "{{ route('PendingReport') }}" },//19
                { GetSinglecity: "{{ route('GetSinglecity') }}" },//20
                { GetTelecaller: "{{ route('GetTelecaller') }}" },//21
                { PendingCallpost: "{{ route('PendingCallpost') }}" },//22
                { MannualCallAssignment: "{{ route('MannualCallAssignment') }}" },//23
                { DashboardCounts: "{{ route('DashboardCounts') }}" },//24
                { Orgchart: "{{ route('Orgchart') }}" },//25
                { BrkDetails: "{{ route('BrkDetails') }}" },//26
                { ViewVLProjects: "{{route('ViewVLProjects') }}" },//27
                { CurrentStatus: "{{route('CurrentStatus') }}" },//28
                { updateCompetency: "{{route('updateCompetency') }}" },//29
                { CountsNotification: "{{route('CountsNotification') }}" },//30
                { CitySearch: "{{route('CitySearch') }}" },//31
                { CountsNotificationDetails: "{{route('CountsNotificationDetails') }}" },//32
                { GetLocationbaseCity: "{{route('GetLocationbaseCity') }}" },//33
                { GetProjectbaseLocation: "{{route('GetProjectbaseLocation') }}" },//34
                { GetUserSearchMakeCall: "{{route('GetUserSearchMakeCall') }}" },//35
                { GetSingleSearchLocality: "{{route('GetSingleSearchLocality') }}" }, //36
                { AssignUserSearchMakeCall: "{{route('AssignUserSearchMakeCall') }}" },//37
                { ForceToLogout: "{{route('ForceToLogout') }}" },//38
                { showManagerlist: "{{route('Showmanagerlist') }}"},//39
                { agentSummary: "{{route('Agentsummary') }}"},//40
                { CallDetailReportDownload: "{{route('CallDetailReportDownload') }}"},//41
                { AgentdetailsMongo: "{{route('agentDetailreportMongo') }}"},//42
                { ReqDetailsMongo: "{{route('ReqDetailsMongo') }}"},//43
                { GetAgentNames: "{{route('GetAgentNames') }}"},//44
                { GetTlNames: "{{route('GetTlNames') }}"},//45
                { GetManagerNames: "{{route('GetManagerNames') }}"},//46
                { DetailCallRepDownload:"{{route('DetailCallRepDownload') }}"}//47
            ]};
            $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
            var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
        </script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="{{ asset('js/download-table.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/xpora-main.js?v=9.24') }}" type="text/javascript"></script>
        <script src="{{ asset('js/xpora-sub.js?v=5') }}" type="text/javascript"></script>
       <script src="{{ asset('js/xpora-mongo.js?v=15.964') }}" type="text/javascript"> </script>

</body>
</html>
