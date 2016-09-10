<!DOCTYPE html>
<html lang="en">
<head>
  <title>Xpora Login | Quikr Homes</title>
  <meta charset="utf-8" />
  <meta name="_token" content="{!! csrf_token() !!}"/>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
  <style>
  .panel{ border: 1px solid lightgray;}
  </style>
  </head>
<body>
<div class="container">
   <div class="page-header">
       <div style="position: relative;z-index: 99;" class="nav-mobile-border">
            <nav class="nav-header nav-desktop-border">
              <div class="row">
                <div class="col-xs-5 col-sm-5 col-md-4 col-lg-3 text-left nav-left-block pdrgnone">
                  <!-- end category -->
                  <a class="home-logo" href="http://www.quikr.com/homes/"  target="_self">
                    <img class="hidden-xs"  src="{{asset('images/XPORA_logo.jpg')}}" width="320px" />
                  </a>
                </div>
               </div>
            </nav>
        </div>
    </div>
    <div class="row" style="margin-top:10%;">
    	<div class="col-md-4 col-md-offset-4" id="loginForm">
    		<div class="panel panel-login">
    			<div class="panel-heading">
    				<div class="row">
    					<div class="col-xs-6">
    						<h4 class="text-primary">Xpora Login</h4>
    					</div>
    				</div>
    				<hr />
    			</div>
    			<div class="panel-body">
    				<div class="row">
    					<div class="col-lg-12">
    						<form id="login-form" action="{{config('constants.XPORA_ENDPOINT').'xpora-reloaded/public/Checklogin'}}"  role="form" style="display: block;">
    							<div class="form-group">
    								<input type="text" name="inputEmpid" id="inputEmpid" tabindex="1" class="form-control" placeholder="Employee Id" value="" />
    							</div>
    							<div class="form-group">
    								<input type="password" autocomplete="off" name="inputPassword" id="inputPassword" tabindex="2" class="form-control" placeholder="Password" />
    							</div>
    							<div class="form-group text-center">
                                <label class="pull-left" style="color:red;font-weight: normal;font-size:12px;"  id="errormsg"></label>
   								<a class="pull-right" href="javascript:void(0);" onclick="forgotPassform();" style="color:skyblue;font-size:12px;">Forgot Password?</a>
    							</div>
    							<div class="form-group">
    								<div class="row">
    									<div class="col-sm-4 col-sm-offset-8">
                                        <input name="_token" id="_token" type="hidden" value="{!! csrf_token() !!}" />
    										<input type="button" onclick="loginInventory();" name="login-submit" id="login-submit" tabindex="3" class="form-control btn btn-primary" value="Sign In" />
    									</div>
    								</div>
    							</div>
    						</form>
     					</div>
    				</div>
    			</div>
    		</div>
        </div>
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login" id="forgotpassForm" style="display:none;">
    			<div class="panel-heading">
    				<div class="row">
    					<div class="col-xs-12">
    						<h4 class="text-primary">Forgot Password - Send Email</h4>
    					</div>
    				</div>
    				<hr />
    			</div>
                <div class="row">
                    <div class="col-xs-10 col-md-offset-1">
                        <form id="forgotpass-form" action="{{config('constants.XPORA_ENDPOINT').'xpora-reloaded/public/Forgotpassword'}}" role="form" style="display: block;">
                        	<div class="form-group">
                        		<input type="text" name="inputEmail" id="inputEmail" tabindex="1" class="form-control" placeholder="Enter Email Id" value="" />
                        	</div>
                        	<div class="form-group text-center">
                            <label class="pull-left" style="color:red;font-weight: normal;font-size:12px;"  id="errormsg2"></label>
                        	</div>
                        	<div class="form-group">
                        		<div class="row">
                        			<div class="col-sm-4 col-sm-offset-8">
                                    <input name="_token" id="_token" type="hidden" value="{!! csrf_token() !!}" />
                        				<input type="button" onclick="forgotPassword();" name="forgotpass-submit" id="forgotpass-submit" tabindex="3" class="form-control btn btn-primary" value="Send" />
                        			</div>
                        		</div>
                        	</div>
                        </form>
                    </div>
                </div>
            </div>
   		 </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
var configAjax = { jsRoutes: [
                    { Checklogin: "{{ route('Checklogin') }}" },
                    { Forgotpassword: "{{ route('Forgotpassword') }}" },
                    { Userview: "{{ route('Userview') }}" }
                    ] };
$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
function loginInventory(){
    var empid=$("#inputEmpid").val();
    var pass=$("#inputPassword").val();
    if(empid==""){
        $("#errormsg").html("*Enter Employee Id");
        return false;
        }
    if(pass==""){
        $("#errormsg").html("*Enter Password");
        return false;
        }
    $.ajax({
        url: configAjax.jsRoutes[0].Checklogin,
        type:"post",
        dataType: "json",
        data:$('#login-form').serialize(),
        success: function(resp) {
          if(resp.status=="success"){
             window.location=configAjax.jsRoutes[2].Userview;
          }
          else{
            $("#errormsg").html(resp.message);
          }
        }
      });
} 
function forgotPassform(){
    $("#loginForm").css('display','none');
    $("#forgotpassForm").css('display','block');
}
function forgotPassword(){
    var emailid=$("#inputEmail").val();
    if(emailid==""){
        $("#errormsg2").html("*Enter Email Id");
        return false;
        }
    $.ajax({
        url: configAjax.jsRoutes[1].Forgotpassword,
        type:"post",
        dataType: "json",
        data:$('#forgotpass-form').serialize(),
        success: function(resp) {
          if(resp.status=="success"){
            $("#errormsg2").css('color','green');
            $("#errormsg2").html(resp.message);
          }
          else{
            $("#errormsg2").html(resp.message);
          }
        }
      });
}
</script>
</body>
</html>