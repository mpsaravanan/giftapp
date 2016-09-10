<!-- Competency Profile -->
         <div id="page-wrapper" class="summaryDetails" style="display:none">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Agent Summary Report</h3>
                </div>
                <div class="col-lg-12">
                    <div class="col-lg-3">
                        <div class="form-group" id="Scity_summary">
                            <label for="Scity_name_agent" class="control-label">City</label>
                            <select data-placeholder="Choose a City" class="chosen-select form-control" id="Scity_name_agent" style="width:240px;" tabindex="4" multiple name="Scity_name_agent" >
                             </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="sourceType" class="control-label">Source</label>
                            <select id="SsourceType" name="SsourceType" data-placeholder="Choose a Source" class="chosen-select form-control" style="width:240px;" multiple>
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
                            <label for="SpIntent" class="control-label">Primary Intent</label>
                            <select id="SpIntent" name="SpIntent"  data-placeholder="Choose a Primary Intent" class="chosen-select form-control" style="width:200px;" multiple>
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
                            <select id="SIntent" name="SIntent"  data-placeholder="Choose a Property Type" class="chosen-select form-control" style="width:200px;" multiple>
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
                            <input name="Sagent_name" class="form-control agent_name" id="Sagent_name" type="text"  value="" />
                        </div>
                       </div>
                       <div class="col-lg-3">
                       <div class="form-group">
                            <label for="startDate" class="control-label">Start Date</label>
                            <input name="Sstart_date" class="form-control start_date" id="Sstart_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="endDate" class="control-label">End Date</label>
                            <input name="Send_date" class="form-control end_date" id="Send_date" type="text"  value="" />
                        </div>
                        </div>
                        <div class="panel-body" style="margin-top:5px;">
                            <button class="btn btn-primary pull-right" type="button" onclick="getSummaryDetails();">Search</button>
                            <button style="margin-right:5px;" class="btn btn-primary pull-right" onclick="downLoadTable('agentDetailreport');">Download</button>
                        </div>
                    </div>
                    </div>
                    <div id="AgentSummary"></div>
            </div>
