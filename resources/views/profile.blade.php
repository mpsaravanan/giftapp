        <div id="page-wrapper" class="showProfile" style="display:none">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Profile</h3>
            </div>
           <div class="col-lg-6  col-md-offset-1"> 
           <table id="example" style="font-size:12px;" class="table table-bordered" cellspacing="0" width="100%">
                  <tbody><tr><td>UserName </td><td>{{ $_SESSION['username'] }}</td></tr>
                  <tr><td>Email ID </td><td>{{ $_SESSION['email'] }}</td></tr>
                  <tr><td>Employee ID </td><td>{{ $_SESSION['useremp_id'] }}</td></tr>
                  <tr><td>SIP Number </td><td>{{ $_SESSION['sipnumber'] }}</td></tr>
                  <tr><td>Mobile </td><td>{{ $_SESSION['mobile'] }}</td></tr></tbody>
            </table>
           </div>
        </div>
        </div>
       <div id="page-wrapper" class="showSettings" style="display:none">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Settings - Change Password</h3>
            </div>
           <div class="col-lg-6  col-md-offset-1"> 
           <form id="reset-form" action="{{config('constants.XPORA_ENDPOINT').'xpora-reloaded/public/Userview'}}" role="form" style="display: block;">
    		  <div class="form-group">
    				<input type="password" autocomplete="off" name="inputPassword" id="inputPassword" tabindex="1" class="form-control" placeholder="New Password" value="" />
                    <input type="hidden" name="inputEmpid" id="inputEmpid" class="form-control" value="{{ $_SESSION['useremp_id'] }}" />
    		        <input type="hidden" name="inputId" id="inputId"  class="form-control" value="{{ $_SESSION['userid'] }}" />
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