<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Quikr Homes" />
    <title>Xpora Team Leader View | Quikr Homes</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/prism.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/chosen_multiselect.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}" />
    <link type="text/css" href="{{ asset('css/jquery.simple-dtpicker.css')}}" rel="stylesheet" />
     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    .requiredstar{color:red;}
    .chosen-rtl .chosen-drop { left: -9000px; }
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
                        <li><a href="Logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                            <a href="javascript:void(0);" onclick="showDashboard();" ><i class="fa fa-dashboard fa-fw"></i> My Team Details</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="showCreateuser();" ><i class="fa fa-user fa-fw"></i> Create User</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="showCompetency();" ><i class="fa fa-edit fa-fw"></i>Competency Profile</a>
                        </li>
                        <li>
                            <a href="Reports"><i class="fa fa-edit fa-fw"></i>Reports</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper" class="dashboardCont">
                <!-----Start Main Top Details----->
        @include('counts') 
            <!-----End Main Top Details----->
            <div class="row">
                <div class="col-lg-12"><h3><a style="text-decoration:none;color:#fff;font-size:16px" href="http://172.16.31.128/locality-svc/reports/LeadReport/index.php" target= '_blank' ><label class="text-primary pull-right">View TV Dashboard</label></a></h3></div>
                <div class="col-lg-12">
                    <h3 class="page-header">My Team Details</h3>
                </div>

            <div class="col-lg-10  col-md-offset-1">
                <form id="agentsDashboard" name="agentsDashboard" role="form">
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="control-label" for="nameSearch">Name</label>
                    <input type="text" required="required" placeholder="Enter Name" id="nameSearch" name="nameSearch" class="form-control" />
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="control-label" for="empidSearch">Employee Id</label>
                    <input type="text" required="required" placeholder="Employee Id" id="empidSearch" name="empidSearch" class="form-control" />
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                    <div ><label class="control-label">Level:</label>
                    <select class="form-control" id="levelSearch" name="levelSearch">
                        <option value="">-Select-</option>
                        <option value="1">Manager</option>
                        <option value="2">Team Leader</option>
                        <option value="3">Telecaller</option>
                    </select>
                  </div>
                </div>
                </div>
                <div class="col-lg-2">
                  <div ><label class="control-label" >&nbsp;</label>
                  <div class="form-group">
                    <button id="userAgentSearch" onclick="filterDashboard();" type="button" class="btn btn-primary pull-right">Search</button>
                  </div>
                </div>
                </div>
                </form>
            </div>

                <div class="col-sm-12" id="agentsDashboardTable">
                  <table id="example1" style="font-size:10px;" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead><tr style="background:#6F6F6F;color:#fff;"><th>Name</th><th>Emp ID</th><th>Email ID</th><th>Level</th><th>Reporting To</th><th>Profile Created at</th><th>Profile Updated at</th><th>View/Edit</th></tr></thead>
                    <tbody>
                    @if(count($dashboard)>=1)
                    @foreach ($dashboard as $_user)
                    <tr>
                    <td><a href="javascript:void(0);" onclick="showOrgChart({{$_user['id']}},{{$_user['level']}});">{{$_user['name']}}</a></td>
                    <td>{{$_user['emp_id']}}</td>
                    <td>{{$_user['email']}}</td>
                    @if($_user['level']==1)
                    <td>Manager</td>
                    @elseif($_user['level']==2)
                    <td>Team Leader</td>
                    @elseif($_user['level']==3)
                    <td>Telecaller</td>
                    @endif
                    <td>{{$_user['reporting_name']}} - ({{$_user['reporting_level']}})</td>
                    <td>{{$_user['created_time']}}</td>
                    <td>{{$_user['updated_time']}}</td>
                    <td><a href="javascript:void(0);" data-id="{{$_user['id']}}" data-empid="{{$_user['emp_id']}}" data-name="{{$_user['name']}}" data-email="{{$_user['email']}}" data-toggle="modal" data-target="#myModal" class="editButton">Edit</a>&nbsp;/&nbsp;
                    <a href="javascript:void(0);" onclick="confirmDelete('{{ $_user['id'] }}')">Delete</a></td>
                    </tr>
                    @endforeach
                    @endif
                    </tbody>
                   </table> 
                </div>
            </div>
                <!-- /.col-lg-12 -->
        </div>
        
              <!-- Org Chart Modal Add-->
      <div class="modal fade" id="myOrgModel" role="dialog">
        <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">My Team Info</h4>
            </div>
            <div class="modal-body">
              <div id="chart_div"></div>
            </div>
            </div>
        </div>
      </div>
      <!-- Org Chart Modal End-->
        <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit Profile</h4>
            </div>
            <form class="editProfile" name="editProfile">
            <div class="modal-body">
                <div class="form-group">
                    <label for="inputuEmpidnew" class="control-label">Emp ID</label>
                    <input type="text" readonly="readonly" class="form-control u_empid" name="inputuEmpid" id="inputuEmpid" />
                </div>
                <div class="form-group">
                    <label for="inputName" class="control-label">Name<span class="requiredstar">*</span></label>
                    <input type="text" class="form-control u_name" name="inputuName" id="inputuName" placeholder="Enter Name" required="required" />
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="control-label">Email<span class="requiredstar">*</span></label>
                    <input type="text" class="form-control u_email" name="inputuEmail" id="inputuEmail" placeholder="Enter Email" required="required"/>
                    <input type="hidden" class="form-control u_id" name="inputId" id="inputId"/>
                </div>
            </div>
            <div class="modal-footer">
                 <input name="_token" id="_token" type="hidden" value="{!! csrf_token() !!}" />
              <button class="btn btn-primary pull-right" type="button" onclick="updateProfile();">Update</button>
            </div>
            </form>
          </div><!-- Modal content Ends Here-->
        </div>
      </div><!-- Modal Ends Here-->
                <div id="page-wrapper" class="createuserCont" style="display:none">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Create User</h3>
                </div>
                <div class="col-lg-8  col-md-offset-1">
                    <form role="form" action="{{config('constants.XPORA_ENDPOINT').'xpora-reloaded/public/Userview'}}" name="createAgent" id="createAgent">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="inputName" class="control-label">Name<span class="requiredstar">*</span></label>
                        <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Enter Name" required="required" />
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="inputEmpidnew" class="control-label">Employee Id<span class="requiredstar">*</span></label>
                        <input type="text" class="form-control" name="inputEmpidnew" id="inputEmpidnew" placeholder="Employee Id" required="required" />
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <div id="sip_nonew"></div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="inputPasswordnew" class="control-label">Password<span class="requiredstar">*</span></label>
                        <input type="password" autocomplete="off" class="form-control" name="inputPasswordnew" id="inputPasswordnew" placeholder="Password" required="required" />
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="inputConfirmnew" class="control-label">Confirm Password<span class="requiredstar">*</span></label>
                        <input type="password" autocomplete="off" class="form-control" name="inputConfirmnew" id="inputConfirmnew" placeholder="Confirm Password" required="required" />
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="inputEmail" class="control-label">Email<span class="requiredstar">*</span></label>
                        <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email"  />
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="inputMobile" class="control-label">Mobile No</label>
                        <input type="text" class="form-control" name="inputMobile" id="inputMobile" placeholder="Mobile Number" />
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="inputLevel" class="control-label">Level<span class="requiredstar">*</span></label>
                        <select class="form-control" name="inputLevel" onchange="getReportingto(this.value);" id="inputLevel">
                            <option value="">-Select-</option>
                            <option value="1">Manager</option>
                            <option value="2">Team Leader</option>
                            <option value="3">Telecaller</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <div id="reporting_tonew"></div>
                      </div>
                    </div>
                      <input name="_token" id="_token" type="hidden" value="{!! csrf_token() !!}" />
                      <div class="panel-body">
                        <button class="btn btn-primary pull-right" type="button" onclick="createUserAgent();" id="createUserbutton">Create User</button>
                        <button style="margin-right:2%" class="btn btn-primary pull-right" type="button" onclick="resetForm();">Reset</button>
                      </div>
                    </form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
       <!-- Competency Profile starts Here -->
        @include('competency') 
        @include('profile') 
        <!-- Competency Profile Ends Here -->
        <!-- Agent details start here -->
        @include('reports') 
       <!-- Agent Details ends here-->
       @include('currentstatus') 
        <!-- Pending details start here -->
        @include('pendingreports') 
       <!-- Pending Details ends here-->
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
    <!-- /#wrapper -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.js') }}"></script>
<script src="{{ asset('js/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/prism.js') }}" type="text/javascript" charset="utf-8"></script>
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
                    { CallDetailReportDownload: "{{route('CallDetailReportDownload') }}"}//41
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
    <script src="{{ asset('js/xpora-main.js?v=9.25') }}" type="text/javascript"></script>
    <script src="{{ asset('js/xpora-sub.js?v=5') }}" type="text/javascript"></script>
</body>
</html>