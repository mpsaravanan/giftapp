<!DOCTYPE html>
<html lang="en">
<head>
  <title>Xpora Reset Password | Quikr Homes</title>
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
                    <img class="hidden-xs" src="{{asset('images/XPORA_logo.jpg')}}" width="320px" />
                  </a>
                </div>
               </div>
            </nav>
        </div>
    </div>
    <div class="row" style="margin-top:10%;">
    	<div class="col-md-6 col-md-offset-3" id="resetForm">
    		<div class="panel panel-login">
    			<div class="panel-heading">
    				<div class="row">
    					<div class="col-xs-6">
    						<h4 class="text-primary">Xpora - Reset Password</h4>
    					</div>
    				</div>
    				<hr />
    			</div>
    			<div class="panel-body">
    				<div class="row">
    					<div class="col-lg-12">
    						<form id="reset-form" role="form" style="display: block;">
    							<div class="form-group">
    								<input type="password" autocomplete="off" name="inputPassword" id="inputPassword" tabindex="1" class="form-control" placeholder="New Password" value="" />
                                    <input type="hidden" name="inputEmpid" id="inputEmpid" class="form-control" value="{{ $data->emp_id }}" />
							        <input type="hidden" name="inputId" id="inputId"  class="form-control" value="{{ $data->id }}" />
    							</div>
    							<div class="form-group">
    								<input type="password" name="inputConfirm" id="inputConfirm" tabindex="2" class="form-control" placeholder="Confirm Password" />
    							</div>
    							<div class="form-group text-center">
                                <label class="pull-left" style="color:red;font-weight: normal;font-size:12px;"  id="errormsg"></label>
   								</div>
    							<div class="form-group">
    								<div class="row">
    									<div class="col-sm-4 col-sm-offset-8">
                                        <input name="_token" id="_token" type="hidden" value="{!! csrf_token() !!}" />
    										<input type="button" onclick="resetPassword();" name="reset-submit" id="reset-submit" tabindex="3" class="form-control btn btn-primary" value="Reset Password" />
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
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
var configAjax = { jsRoutes: [
                    { Updatepassword: "{{ route('Updatepassword') }}" },
                    { Login: "{{ route('Viewlogin') }}" }
                    ] };
$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});

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
            $("#errormsg").html(resp.message+" <a href='"+configAjax.jsRoutes[1].Login+"'>Click Here to Login</a>");
          }
          else{
            $("#errormsg").html(resp.message);
          }
        }
      });
}
</script>
</body>
</html>