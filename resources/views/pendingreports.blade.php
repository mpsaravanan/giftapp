<!-- Competency Profile -->
         <div id="page-wrapper" class="pendingDetails" style="display:none">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Pending Report</h3>
                </div>
                <div class="col-lg-10" id="pendingreportFilter">
                       <div class="col-lg-3">
                        <div class="form-group">
                            <label for="tcName" class="control-label">Telecaller Name<span class="requiredstar">*</span></label>
                            <input name="tc_name" class="form-control tc_name" id="tc_name" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="source" class="control-label">Source<span class="requiredstar">*</span></label>
                            <input name="source" class="form-control source" id="source" type="text"  value="" />
                        </div>
                        </div>
                       <div class="col-lg-3">
                       <div class="form-group">
                            <label for="category" class="control-label">Category<span class="requiredstar">*</span></label>
                            <input name="category" class="form-control category" id="category" type="text"  value="" />
                        </div>
                        </div>
                        
                        <div class="panel-body" style="margin-top:5px;">
                            <button class="btn btn-primary pull-right" type="button" onclick="manualMode();">Search</button>
                        </div>
                        <div id="pendingDetails"></div>
                    </div>
            </div>
        </div>