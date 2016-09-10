<style type="text/css">
.fontDash{font-size:10px;}
.showenqdetails{
    background: #fff none repeat scroll 0 0;
    border: 1px dashed #bcbcbc;
    display: block;
    padding: 12px;
}
.table {
    margin-bottom: 1px;
}
</style>
<!--<div class="row">
<div class="col-lg-3 col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                     <i class="fa fa-tasks fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div id="noofenq" class="huge">26</div>
                    <div class="fontDash">Number Of Enquiries!</div>
                </div>
            </div>
        </div>
        <a href="javascript:void(0);">
            <div class="panel-footer" onclick="showfilterEnq();">
                <span class="pull-left" >View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="panel panel-green">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-check-square fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div id="completedcalls" class="huge">12</div>
                    <div class="fontDash">Successfull Connections!</div>
                </div>
            </div>
        </div>
        <a href="javascript:void(0);">
            <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-hourglass-half  fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div id="assignededcalls" class="huge">124</div>
                    <div class="fontDash">Assigned Calls!</div>
                </div>
            </div>
        </div>
        <a href="javascript:void(0);">
            <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="panel panel-red">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-exclamation-triangle fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div id="pendingcalls" class="huge">13</div>
                    <div class="fontDash">Pending Calls!</div>
                </div>
            </div>
        </div>
        <a href="javascript:void(0);">
            <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
</div>-->
<div class="row showenqdetails" style="display:none;">
<div class="col-lg-12">
<form role="form" id="showEnqdetailFrom" name="showEnqdetailFrom">
    <div class="col-lg-3">
      <div class="form-group">
        <label class="control-label">City</label>
        <input type="text" placeholder="Enter City" id="citysearch" name="citysearch" class="form-control citysearchinput" />
        <input type="hidden" id="cityidsearch" name="cityidsearch" class="form-control" />
      </div>
    </div>
    <div class="col-lg-3">
      <div class="form-group">
        <label class="control-label" >From Date</label>
        <input type="text" placeholder="From Date" id="fromdatesearch" name="fromdatesearch" class="form-control" />
      </div>
    </div>
    <div class="col-lg-3">
      <div class="form-group">
        <label class="control-label">To Date</label>
        <input type="text" placeholder="To Date" id="todatesearch" name="todatesearch" class="form-control" />
      </div>
    </div>
     <div class="col-lg-3">
      <input style='margin-top:8%' type="button"  value="Search" id="searchButton" name="searchButton" onclick="showNoofEnq();" class="btn btn-primary" />
    </div>
</form>
</div>
    <div class="col-lg-12">
        <div id="customNotification">
        </div>
         <div class="col-lg-12 viewdetails" style="display:none;">
            <input type='button' class="btn btn-default pull-right" onclick='getcustomViewdetails();' value="View Details" name="downloadTable" />&nbsp;&nbsp;
            <input style="margin-right:2%;" type='button' class="btn btn-default pull-right" onclick='downLoadTable("countsDashboard");' value="Download" name="downloadTable" />
        </div>
        <div class="col-lg-12">
        &nbsp;
        </div>
        <div id="customViewDetails" style="display:none;">
        
        </div>
        <div id="customViewDetailsdownload" class="col-lg-12" style="display:none;">
            <input style="margin-right:2%;" type='button' class="btn btn-default pull-right" onclick='downLoadTable("viewcountsDetails");' value="Download" name="downloadTable" />
        </div>
    </div>
</div>