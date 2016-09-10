<style type="text/css">
 .form-control{
    font-size:10px;
    height:30px;
    width:82%;
 }
 .morecontent span {
    display: none;
}
.morelink {
    display: block;
}
 </style>
    
 <div id="page-wrapper" class="showReportDetails" style="display:none">
            <ul class="nav nav-tabs nav-pills">
                <li class="active"><a href="#agent">Agent</a></li>
                <li><a href="#campaign" onclick="filterCampaign();">Campaign</a></li>
                <li><a href="#detail_call_report" onclick="filterdetailReport(1);">Detail Call Report</a></li>
                <li><a href="#total_login" onclick="filtertotalLogin();">Total Login</a></li>
                <li><a href="#agent_loggedin" onclick="filterAgentLog();">Agent Loggedin</a></li>
                <li><a href="#break" onclick="filterBreak();">Break</a></li>
                <!-- <li><a href="#manual_call_assignment" >Manual Call Assignment</a></li> -->
                <li><a href="#user_search_call" >Search & Re-Queue</a></li>
            </ul>
            <div class="tab-content">
                <div id="agent" class="tab-pane fade in active">
                    <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Agent Details</h3>
                    </div>
                    <div class="col-lg-12">
                    <div class="col-lg-3">
                        <div class="form-group" id="city_agent">
                            <label for="city_name_agent" class="control-label">City</label>
                            <select data-placeholder="Choose a City" class="chosen-select form-control" id="city_name_agent" style="width:240px;" tabindex="4" multiple name="city_name_agent" >
                             </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="sourceType" class="control-label">Source</label>
                            <select id="sourceType" name="sourceType" data-placeholder="Choose a Source" class="chosen-select form-control" style="width:240px;" multiple>
                                <option value="">Select</option>
                                <option value="WANT_AD">WANT_AD</option>
                                <option value="REQUIREMENT_POPUP">REQUIREMENT_POPUP</option>
                                <option value="ENQUIRY">ENQUIRY</option>
                                <option value="CLICK_TO_CALL_IN_LISTING">CLICK_TO_CALL_IN_LISTING</option>
                                <option value="IM_INTERESTED_IN_PROJECT">IM_INTERESTED_IN_PROJECT</option>
                                <option value="CLICK_TO_VIEW_IN_LISTING">CLICK_TO_VIEW_IN_LISTING</option>
                                <option value="CONTACT_IN_LISTING_SNB">CONTACT_IN_LISTING_SNB</option>
                                <option value="PROJECT_CONTACT_IN_BUILDER">PROJECT_CONTACT_IN_BUILDER</option>
                                <option value="PROJECT_CONTACT_IN_PROJECT">PROJECT_CONTACT_IN_PROJECT</option>
                                <option value="CONTACT_IN_LISTING_PROJECT">CONTACT_IN_LISTING_PROJECT</option>
                                <option value="CONTACT_IN_LISTING_FLP">CONTACT_IN_LISTING_FLP</option>
                                <option value="IM_INTERESTED_IN_BUILDER">IM_INTERESTED_IN_BUILDER</option>
                                <option value="CHAT_IN_LISTING">CHAT_IN_LISTING</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="pIntent" class="control-label">Primary Intent</label>
                            <select id="pIntent" name="pIntent"  data-placeholder="Choose a Primary Intent" class="chosen-select form-control" style="width:200px;" multiple>
                                <option value="">Select</option>
                                <option value="buy">Buy</option>
                                <option value="sell">Sell</option>
                                <option value="rent in">Rent In</option>
                                <option value="rent out">Rent Out</option>
                                <option value="pg in">PG In</option>
                                <option value="pg out">PG Out</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="sIntent" class="control-label">Property Type</label>
                            <select id="sIntent" name="sIntent"  data-placeholder="Choose a Property Type" class="chosen-select form-control" style="width:200px;" multiple>
                                <option value="">Select</option>
                                <option value="residential">Residential</option>
                                <option value="commercial">Commercial</option>
                                <option value="agriculture">Agriculture</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="agentName" class="control-label">Agent Name</label>
                            <input name="agent_name" class="form-control agent_name" id="agent_name" type="text"  value="" />
                        </div>
                       </div>
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
                            <button class="btn btn-primary pull-right" type="button" onclick="filterAgent();">Search</button>
                            <button style="margin-right:5px;" class="btn btn-primary pull-right" onclick="downLoadTable('agentDetailreport');">Download</button>
                        </div>
                    </div>
                    </div>
                    <div id="AgentDetails"></div>
                </div>
                <div id="campaign" class="tab-pane fade">
                    <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Campaign Details</h3>
                    </div>
                    <div class="col-lg-12">
                       <div class="col-lg-3">
                        <div class="form-group" id="city_name_camp">
                            <label for="city_name_campaign" class="control-label">City</label>
                            <select data-placeholder="Choose a City" class="chosen-select" id="city_name_campaign" style="width:230px;" tabindex="4" multiple name="city_name_campaign" >
                             </select>
                        </div>
                       </div>
                       <div class="col-lg-3">
                        <div class="form-group">
                            <label for="sourceType_campaign" class="control-label">Source</label>
                            <select id="sourceType_campaign" data-placeholder="Choose a Source" class="chosen-select form-control" style="width:240px;" multiple name="sourceType_campaign" >
                                <option value="">Select</option>
                                <option value="WANT_AD">WANT_AD</option>
                                <option value="REQUIREMENT_POPUP">REQUIREMENT_POPUP</option>
                                <option value="ENQUIRY">ENQUIRY</option>
                                <option value="CLICK_TO_CALL_IN_LISTING">CLICK_TO_CALL_IN_LISTING</option>
                                <option value="IM_INTERESTED_IN_PROJECT">IM_INTERESTED_IN_PROJECT</option>
                                <option value="CLICK_TO_VIEW_IN_LISTING">CLICK_TO_VIEW_IN_LISTING</option>
                                <option value="CONTACT_IN_LISTING_SNB">CONTACT_IN_LISTING_SNB</option>
                                <option value="PROJECT_CONTACT_IN_BUILDER">PROJECT_CONTACT_IN_BUILDER</option>
                                <option value="PROJECT_CONTACT_IN_PROJECT">PROJECT_CONTACT_IN_PROJECT</option>
                                <option value="CONTACT_IN_LISTING_PROJECT">CONTACT_IN_LISTING_PROJECT</option>
                                <option value="CONTACT_IN_LISTING_FLP">CONTACT_IN_LISTING_FLP</option>
                                <option value="IM_INTERESTED_IN_BUILDER">IM_INTERESTED_IN_BUILDER</option>
                                <option value="CHAT_IN_LISTING">CHAT_IN_LISTING</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="pIntent_campaign" class="control-label">Primary Intent</label>
                            <select id="pIntent_campaign" data-placeholder="Choose a Primary Intent" class="chosen-select form-control" style="width:200px;" multiple name="pIntent_campaign" >
                                <option value="">Select</option>
                                <option value="buy">Buy</option>
                                <option value="sell">Sell</option>
                                <option value="rent in">Rent In</option>
                                <option value="rent out">Rent Out</option>
                                <option value="pg in">PG In</option>
                                <option value="pg out">PG Out</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="start_date_campaign" class="control-label">Start Date</label>
                            <input name="start_date_campaign" class="form-control start_date" id="start_date_campaign" type="text"  value="" />
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                        <div class="form-group">
                            <label for="end_date_campaign" class="control-label">End Date</label>
                            <input name="end_date_campaign" class="form-control end_date" id="end_date_campaign" type="text"  value="" />
                        </div>
                        </div>
                        <div class="panel-body" style="margin-top:5px;">
                            <button  class="btn btn-primary pull-right" type="button" onclick="filterCampaign();">Search</button>
                            <button style="margin-right:5px;" class="btn btn-primary pull-right" onclick="downLoadTable('campaignReporttable');">Download</button>
                        </div>
                    </div>
                    </div>
                    <div id="CampaignDetails"></div>
                </div>
                <div id="detail_call_report" class="tab-pane fade">
                    <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Detail Call Report</h3>
                    </div>
                    <div class="col-lg-12">
                    <div class="col-lg-3">
                        <div class="form-group" id="city_name_dc">
                            <label for="city_name_call" class="control-label">City</label>
                            <select data-placeholder="Choose a City" class="chosen-select" id="city_name_call" style="width:230px;" tabindex="4" multiple name="city_name_call" >
                             </select>
                        </div>
                       </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="sourceType" class="control-label">Source</label>
                            <select id="dc_sourceType" name="sourceType"data-placeholder="Choose a Source" class="chosen-select form-control" style="width:245px;" multiple>
                                <option value="">Select</option>
                                <option value="WANT_AD">WANT_AD</option>
                                <option value="REQUIREMENT_POPUP">REQUIREMENT_POPUP</option>
                                <option value="ENQUIRY">ENQUIRY</option>
                                <option value="CLICK_TO_CALL_IN_LISTING">CLICK_TO_CALL_IN_LISTING</option>
                                <option value="IM_INTERESTED_IN_PROJECT">IM_INTERESTED_IN_PROJECT</option>
                                <option value="CLICK_TO_VIEW_IN_LISTING">CLICK_TO_VIEW_IN_LISTING</option>
                                <option value="CONTACT_IN_LISTING_SNB">CONTACT_IN_LISTING_SNB</option>
                                <option value="PROJECT_CONTACT_IN_BUILDER">PROJECT_CONTACT_IN_BUILDER</option>
                                <option value="PROJECT_CONTACT_IN_PROJECT">PROJECT_CONTACT_IN_PROJECT</option>
                                <option value="CONTACT_IN_LISTING_PROJECT">CONTACT_IN_LISTING_PROJECT</option>
                                <option value="CONTACT_IN_LISTING_FLP">CONTACT_IN_LISTING_FLP</option>
                                <option value="IM_INTERESTED_IN_BUILDER">IM_INTERESTED_IN_BUILDER</option>
                                <option value="CHAT_IN_LISTING">CHAT_IN_LISTING</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="pIntent" class="control-label">Primary Intent</label>
                            <select id="dc_pIntent" name="pIntent"  data-placeholder="Choose a Primary Intent" class="chosen-select form-control" style="width:200px;" multiple>
                                <option value="">Select</option>
                                <option value="buy">Buy</option>
                                <option value="sell">Sell</option>
                                <option value="rent in">Rent In</option>
                                <option value="rent out">Rent Out</option>
                                <option value="pg in">PG In</option>
                                <option value="pg out">PG Out</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="sIntent" class="control-label">Property Type</label>
                            <select id="dc_sIntent" name="sIntent"  data-placeholder="Choose a Property Type" class="chosen-select form-control" style="width:200px;" multiple>
                                <option value="">Select</option>
                                <option value="residential">Residential</option>
                                <option value="commercial">Commercial</option>
                                <option value="agriculture">Agriculture</option>
                            </select>
                        </div>
                    </div>
                    </div>
                   <div class="col-lg-12"> 
                   <!--<div class="col-lg-3">
                        <div class="form-group">
                            <label for="agentName" class="control-label">Agent Name</label>-->
                            <input name="agent_name" class="form-control dc_agent_name" id="dc_agent_name" type="hidden"  value="" />
                      <!--  </div>
                       </div>-->
                       <div class="col-lg-3">
                        <div class="form-group">
                            <label for="phoneno" class="control-label">Phone No</label>
                            <input name="phoneno" class="form-control dc_phoneno" id="dc_phoneno" type="text"  value="" />
                        </div>
                        </div>
                       <div class="col-lg-3">
                       <div class="form-group">
                            <label for="startDate" class="control-label">Start Date</label>
                            <input name="start_date" class="form-control dc_start_date" id="dc_start_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="endDate" class="control-label">End Date</label>
                            <input name="end_date" class="form-control dc_end_date" id="dc_end_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="panel-body" style="margin-top:5px;">
                            <button class="btn btn-primary pull-right" type="button" onclick="filterdetailReport(1);">Search</button>
                            <button style="margin-right:5px;" class="btn btn-primary pull-right" onclick="downloadFile('filterdetailReport');">Download</button>
                       <span id="downloadLinkDR"></span>
                        </div>
                    </div>
                    </div>
                    <div id="DetailCallReport"></div>
                    <div id="DetailCallReportPaging"></div>
                </div>
                <div id="total_login" class="tab-pane fade">
                    <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Total Login</h3>
                    </div>
                    <div class="col-lg-10">
                        <div class="col-lg-3">
                       <div class="form-group">
                            <label for="tlagentName" class="control-label">Agent Name<span class="requiredstar">*</span></label>
                            <input name="tlagent_name" class="form-control tlagent_name" id="tlagent_name" type="text"  value="" />
                        </div>
                        </div>
                       <div class="col-lg-3">
                       <div class="form-group">
                            <label for="tlstartDate" class="control-label">Start Date<span class="requiredstar">*</span></label>
                            <input name="tlstart_date" class="form-control tlstart_date" id="tlstart_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="endDate" class="control-label">End Date<span class="requiredstar">*</span></label>
                            <input name="end_date" class="form-control tlend_date" id="tlend_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="panel-body" style="margin-top:5px;">
                            <button class="btn btn-primary pull-right" type="button" onclick="filtertotalLogin();">Search</button>
                            <button style="margin-right:5px;" class="btn btn-primary pull-right" onclick="downLoadTable('totalLoginDownload');">Download</button>
                        </div>
                    </div>
                    </div>
                    <div id="TotalLogin"></div>
                </div>
                <div id="agent_loggedin" class="tab-pane fade">
                    <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Agent Loggedin</h3>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                        <div class="form-group" id="city_agentlog">
                            <label for="city_name_al" class="control-label">City</label>
                            <select data-placeholder="Choose a City" class="chosen-select form-control" id="city_name_al" style="width:240px;" tabindex="4" multiple name="city_name_al" >
                             </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="al_sourceType" class="control-label">Source</label>
                            <select id="al_sourceType" name="al_sourceType" data-placeholder="Choose a Source" class="chosen-select form-control" style="width:240px;" multiple>
                                <option value="">Select</option>
                                <option value="WANT_AD">WANT_AD</option>
                                <option value="REQUIREMENT_POPUP">REQUIREMENT_POPUP</option>
                                <option value="ENQUIRY">ENQUIRY</option>
                                <option value="CLICK_TO_CALL_IN_LISTING">CLICK_TO_CALL_IN_LISTING</option>
                                <option value="IM_INTERESTED_IN_PROJECT">IM_INTERESTED_IN_PROJECT</option>
                                <option value="CLICK_TO_VIEW_IN_LISTING">CLICK_TO_VIEW_IN_LISTING</option>
                                <option value="CONTACT_IN_LISTING_SNB">CONTACT_IN_LISTING_SNB</option>
                                <option value="PROJECT_CONTACT_IN_BUILDER">PROJECT_CONTACT_IN_BUILDER</option>
                                <option value="PROJECT_CONTACT_IN_PROJECT">PROJECT_CONTACT_IN_PROJECT</option>
                                <option value="CONTACT_IN_LISTING_PROJECT">CONTACT_IN_LISTING_PROJECT</option>
                                <option value="CONTACT_IN_LISTING_FLP">CONTACT_IN_LISTING_FLP</option>
                                <option value="IM_INTERESTED_IN_BUILDER">IM_INTERESTED_IN_BUILDER</option>
                                <option value="CHAT_IN_LISTING">CHAT_IN_LISTING</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="al_pIntent" class="control-label">Primary Intent</label>
                            <select id="al_pIntent" name="al_pIntent"  data-placeholder="Choose a Primary Intent" class="chosen-select form-control" style="width:200px;" multiple>
                                <option value="">Select</option>
                                <option value="buy">Buy</option>
                                <option value="sell">Sell</option>
                                <option value="rent in">Rent In</option>
                                <option value="rent out">Rent Out</option>
                                <option value="pg in">PG In</option>
                                <option value="pg out">PG Out</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="al_sIntent" class="control-label">Property Type</label>
                            <select id="al_sIntent" name="al_sIntent"  data-placeholder="Choose a Property Type" class="chosen-select form-control" style="width:200px;" multiple>
                                <option value="">Select</option>
                                <option value="residential">Residential</option>
                                <option value="commercial">Commercial</option>
                                <option value="agriculture">Agriculture</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-12">
                       <div class="col-lg-3">
                       <div class="form-group">
                            <label for="startDate" class="control-label">Start Date<span class="requiredstar">*</span></label>
                            <input name="alstart_date" class="form-control alstart_date" id="alstart_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="endDate" class="control-label">End Date<span class="requiredstar">*</span></label>
                            <input name="alend_date" class="form-control alend_date" id="alend_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="panel-body" style="margin-top:5px;">
                            <button class="btn btn-primary pull-right" type="button" onclick="filterAgentLog();">Search</button>
                        </div>
                    </div>
                    </div>
                    <div id="AgentLogDetails"></div>
                </div>
                <div id="break" class="tab-pane fade">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Break Details</h3>
                    </div>
                    <div class="col-lg-12">
                    <div class="col-lg-3">
                        <div class="form-group" id="city_brk">
                            <label for="city_name_brk" class="control-label">City</label>
                            <select data-placeholder="Choose a City" class="chosen-select form-control" id="city_name_brk" style="width:240px;" tabindex="4" multiple name="city_name_brk" >
                             </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="brk_sourceType" class="control-label">Source</label>
                            <select id="brk_sourceType" name="brk_sourceType" data-placeholder="Choose a Source" class="chosen-select form-control" style="width:240px;" multiple>
                                <option value="">Select</option>
                                <option value="WANT_AD">WANT_AD</option>
                                <option value="REQUIREMENT_POPUP">REQUIREMENT_POPUP</option>
                                <option value="ENQUIRY">ENQUIRY</option>
                                <option value="CLICK_TO_CALL_IN_LISTING">CLICK_TO_CALL_IN_LISTING</option>
                                <option value="IM_INTERESTED_IN_PROJECT">IM_INTERESTED_IN_PROJECT</option>
                                <option value="CLICK_TO_VIEW_IN_LISTING">CLICK_TO_VIEW_IN_LISTING</option>
                                <option value="CONTACT_IN_LISTING_SNB">CONTACT_IN_LISTING_SNB</option>
                                <option value="PROJECT_CONTACT_IN_BUILDER">PROJECT_CONTACT_IN_BUILDER</option>
                                <option value="PROJECT_CONTACT_IN_PROJECT">PROJECT_CONTACT_IN_PROJECT</option>
                                <option value="CONTACT_IN_LISTING_PROJECT">CONTACT_IN_LISTING_PROJECT</option>
                                <option value="CONTACT_IN_LISTING_FLP">CONTACT_IN_LISTING_FLP</option>
                                <option value="IM_INTERESTED_IN_BUILDER">IM_INTERESTED_IN_BUILDER</option>
                                <option value="CHAT_IN_LISTING">CHAT_IN_LISTING</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="brk_pIntent" class="control-label">Primary Intent</label>
                            <select id="brk_pIntent" name="brk_pIntent"  data-placeholder="Choose a Primary Intent" class="chosen-select form-control" style="width:200px;" multiple>
                                <option value="">Select</option>
                                <option value="buy">Buy</option>
                                <option value="sell">Sell</option>
                                <option value="rent in">Rent In</option>
                                <option value="rent out">Rent Out</option>
                                <option value="pg in">PG In</option>
                                <option value="pg out">PG Out</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="brk_sIntent" class="control-label">Property Type</label>
                            <select id="brk_sIntent" name="brk_sIntent"  data-placeholder="Choose a Property Type" class="chosen-select form-control" style="width:200px;" multiple>
                                <option value="">Select</option>
                                <option value="residential">Residential</option>
                                <option value="commercial">Commercial</option>
                                <option value="agriculture">Agriculture</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                       <div class="form-group">
                            <label for="Agent_Name" class="control-label">Agent Name</label>
                            <input name="agent_name" class="form-control bagent_name" id="bagent_name" type="text"  value="" />
                        </div>
                        </div>
                       <div class="col-lg-3">
                       <div class="form-group">
                            <label for="break_reasonn" class="control-label">Break Reason</label>
                            <select data-placeholder="Choose a reason" class="chosen-select form-control" id="break_reason" style="width:220px;" multiple name="break_reason" >
                                <option value="">Select</option>
                                <option  value="Tea">Tea</option>
                                <option  value="Lunch">Lunch</option>
                                <option  value="Training">Training</option>
                                <option  value="TL Briefing">TL Briefing</option>
                                <option  value="QA Feedback">QA Feedback</option>
                                <option  value="Others">Others</option>
                            </select>
                        </div>
                        </div>
                       <div class="col-lg-2">
                       <div class="form-group">
                            <label for="startDate" class="control-label">Login Start Date</label>
                            <input name="start_date" class="form-control bstart_date" id="bstart_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-2">
                        <div class="form-group">
                            <label for="endDate" class="control-label">Login End Date</label>
                            <input name="end_date" class="form-control bend_date" id="bend_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="" style="margin-top:20px;">
                            <button class="btn btn-primary" type="button" onclick="filterBreak();">Search</button>
                            <button class="btn btn-primary pull-right" onclick="downLoadTable('filterBreakReport');">Download</button>
                        </div>
                    </div>
                    </div>
                    <div id="BreakDetails"></div>
                </div>

                <div id="manual_call_assignment" class="tab-pane fade">
                 <form id="manual_call-form" name="manual_call-form"  role="form" >

                 <input name="_token" id="_token" type="hidden" value="{!! csrf_token() !!}" />
                 <div class="row">

                    <div class="col-lg-12">
                        <h3 class="page-header">Manual Call Assignment</h3>
                    </div>
                      <div class="col-lg-12">
                        <div class="col-lg-3">
                        <div class="form-group" id="cityValue">
                            <label for="city" class="control-label">Assign Calls From<span class="requiredstar">*</span></label>
                             <select data-placeholder="Choose a City" class="chosen-select form-control" id="mcacity" style="width:220px;" tabindex="4" name="mcacity" onchange="filter_telecaller(this.value);" >
                             <option value="N">Choose City</option></select>
                        </div>
                       </div>
                       
                       
                        <div class="col-lg-2">
                       <div class="form-group">
                            <label for="startDate" class="control-label">Start Date<span class="requiredstar">*</span></label>
                            <input name="mcastart_date" class="form-control mcastart_date" id="mcastart_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-2">
                        <div class="form-group">
                            <label for="endDate" class="control-label">End Date<span class="requiredstar">*</span></label>
                            <input name="mcaend_date" class="form-control mcaend_date" id="mcaend_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="panel-body">
                            <button  style="margin-top:5px;" class="btn btn-primary pull-right" type="button" onclick="filter_manual_call_assignment();">Search</button>
                        </div>
                    </div>
                    </div>
                    <div id="manual_call_assignmentDetails"></div>
                    <div class="row" >
                        <br><br><br><br>
                      <div class="col-lg-12 showbutton"  style="display:none;" >

                       <div class="col-lg-3">
                       <div class="form-group" id="telecallerValue">
                           <br><br><br><br>
                            <label for="telecaller" class="control-label">Available Telecallers for cities <span class="requiredstar">*</span></label>
                            <select data-placeholder="Tele Caller" class="chosen-select" id="mcatelecaller" style="width:220px;" tabindex="4" name="mcatelecaller" >
                            <option value="N">Tele Caller</option></select>
                       </div>
                       </div>
                       <div class="panel-body">
                          <br><br><br>  <button  style="margin-top:5px;" class="btn btn-primary pull-right" type="button" onclick="assign_call_to_caller_val();">Submit</button>
                       </div>
                     
                    </div>
                    </div>

                </form>
                </div>


                 <div id="user_search_call" class="tab-pane fade">
                 <form id="user_search_call-form" name="user_search_call-form"  role="form" >

                 <input name="_token" id="_token" type="hidden" value="{!! csrf_token() !!}" />
                 <div class="row">

                    <div class="col-lg-12">
                        <h3 class="page-header">User Search Call</h3>
                    </div>
                      <div class="col-lg-12">
                        <div class="col-lg-2">
                        <div class="form-group">
                            <label for="ustart_date" class="control-label">Start Date</label>
                            <input name="ustart_date" class="form-control ustart_date" id="ustart_date" type="text"  value="" />
                        </div>
                        </div>
                       

                        <div class="col-lg-2">
                        <div class="form-group">
                            <label for="usend_date" class="control-label">End Date</label>
                            <input name="usend_date" class="form-control usend_date" id="usend_date" type="text"  value="" />
                        </div>
                        </div>
                       <!-- 
                        <div class="col-lg-2">
                        <div class="form-group">
                            <label for="usseeker" class="control-label">Name</label>
                            <input name="usseeker" class="form-control usseeker" id="usseeker" type="text"  value="" />
                         <select data-placeholder="Choose a City" class="chosen-select form-control" id="uscity" style="width:220px;" tabindex="4" name="uscity" multiple="multiple" >
                       </select>
                        </div>
                        </div> -->
                        <div class="col-lg-2">
                        <div class="form-group">
                            <label for="usreqid" class="control-label">Req ID</label>
                            <input name="usreqid" class="form-control usreqid" id="usreqid" type="text"  value="" />
                        </div>
                        </div>


                       <!-- <div class="col-lg-2">
                        <div class="form-group">
                            <label for="uslast_assigned_tl" class="control-label">Last Assigned TL</label>
                            <input name="uslast_assigned_tl" class="form-control uslast_assigned_tl" id="uslast_assigned_tl" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-2">
                        <div class="form-group">
                            <label for="uslead_dropped_to_project_name" class="control-label">Lead Dropped To(Project Name)</label>
                            <input name="uslead_dropped_to_project_name" class="form-control uslead_dropped_to_project_name" id="uslead_dropped_to_project_name" type="text"  value="" />
                        </div>
                        </div> -->
                        <div class="col-lg-3">
                        <div class="form-group" id="uscityValue">
                            <label for="city" class="control-label">City</label>
                        <select data-placeholder="Choose a City" class="chosen-select " id="uscity" style="width:220px;" tabindex="4" name="uscity" multiple >
                        </select>
                        
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group"  id="uslocalityValue">
                            <label for="uslocality" class="control-label">Locality</label>
                            <select data-placeholder="Choose a Locality" class="chosen-select form-control" id="uslocality" style="width:220px;" tabindex="4" name="uslocality" multiple="multiple" >
                        </select>
                 
                        </div>
                        </div>
                       </div>
                       <div class="col-lg-12">
                        <div class="col-lg-5">
                        <div class="form-group">
                            <label for="uslast_call_dispotion" class="control-label">Last Call Dispotion</label>
                                      <select name="uslast_call_dispotion" style="width:330px;" class="chosen-select form-control" id="uslast_call_dispotion" multiple="multiple" >
                                        <option value="ENQUIRY">ENQUIRY</option>
                                        <option value="SPAM">SPAM</option>
                                        <option value="WRONG_PARTY">WRONG_PARTY</option>
                                        <option value="CALL_BACK_LATER">CALL_BACK_LATER</option>
                                        <option value="RIGHT_PARTY_NI">RIGHT_PARTY_NI</option>
                                        <option value="CALL_BACK_AT">CALL_BACK_AT</option>
                                        <option value="RIGHT_PARTY_INT_RD">RIGHT_PARTY_INT_RD</option>
                                        <option value="CALL_DROP">CALL_DROP</option>
                                        <option value="CONT_CALL_BK_DETAILSENT_EMAIL">CONT_CALL_BK_DETAILSENT_EMAIL</option>
                                        <option value="CONT_BL_INT_LG_SVC">CONT_BL_INT_LG_SVC</option>
                                        <option value="CONT_BL_INT_LG">CONT_BL_INT_LG</option>
                                        <option value="CONT_NBL_QHWL_LOP_LOCALITY">CONT_NBL_QHWL_LOP_LOCALITY</option>
                                        <option value="CONT_NBL_QHWL_LOP_POSSESSION">CONT_NBL_QHWL_LOP_POSSESSION</option>
                                        <option value="CONT_NBL_QHWL_LOP_PRICE">CONT_NBL_QHWL_LOP_PRICE</option>
                                        <option value="CONT_NBL_QHWL_LOP_PROPERTYTYPE">CONT_NBL_QHWL_LOP_PROPERTYTYPE</option>
                                        <option value="CONT_NBL_QHWL_LOP_OTHERS">CONT_NBL_QHWL_LOP_OTHERS</option>
                                        <option value="CONT_NS_ALREADY_FINALIZED">CONT_NS_ALREADY_FINALIZED</option>
                                        <option value="CONT_NS_BROKER_OR_AGENT">CONT_NS_BROKER_OR_AGENT</option>
                                        <option value="CONT_NS_NOT_A_PROP_SEEKER">CONT_NS_NOT_A_PROP_SEEKER</option>
                                        <option value="CONT_NS_NOT_A_SEEKER_TEMP">CONT_NS_NOT_A_SEEKER_TEMP</option>
                                        <option value="CONT_NS_BLANK_CALL">CONT_NS_BLANK_CALL</option>
                                        <option value="MMRESULT_LOVL_PROJECT">MMRESULT_LOVL_PROJECT</option>
                                        <option value="NON_CONT_INVALID_NO">NON_CONT_INVALID_NO</option>
                                        <option value="NON_CONT_BUSY_OR_WAITING">NON_CONT_BUSY_OR_WAITING</option>
                                        <option value="NON_CONT_CUSTOMER_DISCONNECT">NON_CONT_CUSTOMER_DISCONNECT</option>
                                        <option value="NON_CONT_NOT_REACHABLE">NON_CONT_NOT_REACHABLE</option>
                                        <option value="NON_CONT_RINGING_NO_RESPONSE">NON_CONT_RINGING_NO_RESPONSE</option>
                                        <option value="NON_CONT_SWITCHED_OFF">NON_CONT_SWITCHED_OFF</option>
                                        <option value="RINGING_NO_RESPONSE_CALLBACK_AT">RINGING_NO_RESPONSE_CALLBACK_AT</option>
                                        <option value="SEEKER_ALREADY_CONTACTED">SEEKER_ALREADY_CONTACTED</option>
                                    </select>


                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="usemail" class="control-label">Email Id</label>
                            <input name="usemail" class="form-control usemail" id="usemail" type="text"  value="" />
                        </div>
                        </div>

                        <div class="col-lg-3">
                        <div class="panel-body">
                            <button  style="margin-top:5px;" class="btn btn-primary pull-right" type="button" onclick="user_search_make_call();">Search</button>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div id="user_search_callDetails"></div>
                    <div class="row" >
                        
                      <div class="col-lg-12 showbutton"  style="display:none;" >

                           <div class="col-lg-2">
                        <div class="form-group">
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="scheduled_date" class="control-label">Start Calling @(In future Queue) Date & Time </label>
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group">
                            <input name="scheduled_date" class="form-control scheduled_date" id="scheduled_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="panel-body">
                          <button  style="margin-top:5px;" class="btn btn-primary pull-right" type="button" onclick="assign_user_search_make_call();">Re-queue</button>
                        </div>
                        </div>
                        

                        
                        </div>
                    </div>

                </form>
                </div>



                

            </div>
        </div>

<!-- Competency Profile Modal Add-->
      <div class="modal fade" id="myCompetencyModel" role="dialog">
        <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Competency Profile Details</h4>
            </div>
            <div class="modal-body">
              <div id="competency_prof"></div>
            </div>
            </div>
        </div>
      </div>
<!-- Competency Profile Modal End-->

<!-- Competency Profile Modal Add-->
      <div class="modal fade" id="VlProjectModel" role="dialog">
        <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">VL Project Details</h4>
            </div>
            <div class="modal-body">
              <div id="vl_projects"></div>
            </div>
            </div>
        </div>
      </div>
<!-- Competency Profile Modal End-->