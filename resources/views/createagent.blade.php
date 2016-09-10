<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Agent/User Page | Leadform Quikr </title>
  <meta charset="utf-8" />
  <meta name="_token" content="{!! csrf_token() !!}"/>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" />
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" /> 
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css" />
  <style type="text/css">
  .panel-info > .panel-heading {
    background-color: #007fbf;
    border-color: #007fbf;
    color: #fff;
    }
    .active{background:#DFDFDF;}
    .requiredstar{color:red;}
  </style>
  </head>
<body>

<div class="container">
    <!---Header Starts Here -->
    <div class="page-header">
        <nav class="nav-header nav-desktop-border">
          <div class="col-xs-5 col-sm-5 col-md-4 col-lg-3 text-left nav-left-block pdrgnone">
              <a class="home-logo" href="http://www.quikr.com/homes/"  target="_self">
                <img class="hidden-xs"  src="http://teja3.kuikr.com/restatic/image/logo-quikr-homes-new.png" />
              </a>
            </div>
            <nav class="navbar">
              <div class="container-fluid">
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="javascript:void(0);"><span class="glyphicon glyphicon-user"></span></a></li>
                  <li><a href="javascript:voide(0);"><span class="glyphicon glyphicon-log-out"></span>Logout</a></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="javascript:voide(0);">Home</a></li>
                  <li class="active"><a href="javascript:voide(0);">Create User</a></li>
                </ul>
              </div>
            </nav>
         </nav>
     </div>
    <!---Header Ends Here --> 

    <!---Page Content Starts Here -->
    <div class="row">
    <div class="col-md-6" style="margin-left:23%;">
      <div class="panel panel-info">
        <div class="panel-heading">Create Agent/User</div>
        <div class="panel-body">
        <form role="form" action="{{config('constants.XPORA_ENDPOINT').'xpora-reloaded/public/Userview'}}" name="createAgent" id="createAgent">
          <div class="form-group">
            <label for="inputName" class="control-label">User Name<span class="requiredstar">*</span></label>
            <input type="text" class="form-control" name="inputName" id="inputName" placeholder="" required="required" />
          </div>
          <div class="form-group">
            <label for="inputEmpid" class="control-label">Employee Id<span class="requiredstar">*</span></label>
            <input type="text" class="form-control" name="inputEmpid" id="inputEmpid" placeholder="Employee Id" required="required" />
          </div>
          <div class="form-group">
            <label for="inputEmail" class="control-label">Email<span class="requiredstar">*</span></label>
            <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email"  />
          </div>
          <div class="form-group">
            <label for="inputPassword" class="control-label">Password<span class="requiredstar">*</span></label>
            <input type="password" autocomplete="off" class="form-control" name="inputPassword" id="inputPassword" placeholder="Password" required="required" />
          </div>
          <div class="form-group">
            <label for="inputPassword" class="control-label">Confirm Password<span class="requiredstar">*</span></label>
            <input type="password" autocomplete="off" class="form-control" name="inputConfirm" id="inputConfirm" placeholder="Confirm Password" required="required" />
          </div>
          <div class="form-group">
            <label for="inputMobile" class="control-label">Mobile No</label>
            <input type="text" class="form-control" name="inputMobile" id="inputMobile" placeholder="Mobile Number" />
          </div>
          <div class="form-group">
            <label for="inputLevel" class="control-label">Level<span class="requiredstar">*</span></label>
            <select class="form-control" name="inputLevel" id="inputLevel">
                <option value="">-Select-</option>
                <option value="0">Super User</option>
                <option value="1">Manager</option>
                <option value="2">Team Leader</option>
                <option value="3">Telecaller</option>
            </select>
          </div>
          <div class="form-group">
            <label for="inputReportingto" class="control-label">Reporting To<span class="requiredstar">*</span></label>
            <select class="form-control" name="inputReportingto" id="inputReportingto">
                <option value="">-Select-</option>
                <option value="0">Super User</option>
                <option value="1">Manager</option>
                <option value="2">Team Leader</option>
                <option value="3">Telecaller</option>
            </select>
          </div>
          <input name="_token" id="_token" type="hidden" value="{!! csrf_token() !!}" />
          <div class="panel-body">
            <button class="btn btn-primary pull-right" type="button" onclick="createUserAgent();">Create User</button>
          </div>
        </form>
        </div>
      </div>
    </div>
    <!---Page Content Ends Here -->
    <div class="row">
        <div class="col-sm-12">
            <hr /> 
        </div>
    </div>
    <!---Footer Starts Here --> 
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group text-center">
                <h6 class="text-primary"> Copyright &copy; 2008 - 2016 Quikr India Private Limited</h6>
            </div>
        </div>
    </div>
    <!---Footer Ends Here --> 
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
var configAjax = { jsRoutes: [{ Createagentpost: "{{ route('Createagentpost') }}" }] };
$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
function createUserAgent(){
    var username=$("#inputName").val();
    var empid=$("#inputEmpid").val();
    var emailid=$("#inputEmail").val();
    var pass1=$("#inputPassword").val();
    var pass2=$("#inputConfirm").val();
    var level=$("#inputLevel").val();
    var reportto=$("#inputReportingto").val();
    if(username==""){
        alert("Enter User Name");
        return false;
        }
    if(empid==""){
        alert("Enter Employee Id ");
        return false;
        }
    if(emailid==""){
        alert("Enter Email Id ");
        return false;
        }
    if(pass1== ""){
        alert("Enter Password");
        return false;
        }
    if(pass1!=pass2){
        alert("Confirm Password Not Matching");
        return false;
        }
    $.ajax({
          url: configAjax.jsRoutes[0].Createagentpost,
          type:"post",
          data	: $("#createAgent").serialize(),
          dataType: "json",
          success: function(resp) {
                if(resp.status=="success"){
                    alert("Created Successfully"); 
                    location.reload();
                }
                else if(resp.status=="exist"){
                    alert("Employee Id Already Exist"); 
                    location.reload();
                }
                else{
                    alert("Failed to Update");
                }
            }
          });
}
</script>
</body>
</html>