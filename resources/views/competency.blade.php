<!-- Competency Profile -->
         <div id="page-wrapper" class="competency" style="display:none">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Competency Profile</h3>
                </div>
                <div class="col-lg-12">
                    <div class="col-lg-2">
                        <button class="btn btn-primary" onclick="addEditCompetency(1);">Add New Profile</button>
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-primary" onclick="addEditCompetency(0);">Edit Existing Profile</button>
                    </div>
               </div><br />
            <div class="col-lg-12">
                <form role="form" action="{{config('constants.XPORA_ENDPOINT').'xpora-reloaded/public/Userview'}}" name="competencyForm" id="competencyForm" style="font-size:12px;display:none;" >
                <div id="addNewcomp" >
                   <div class="col-lg-12  hrclass">
                        <label for="role" class="control-label">User</label>
                        <div class="form-group" id="newuserComp">
                        </div>
                        <div class="form-group" id="competencyprofilev" style="display:none;">
                        </div>
                   </div>
                   <div id="existNewcomp" >
                    <div class="col-lg-6  hrclass"  style="background: #bcbcbc;"  >
                        <label for="channel" class="control-label">Channel</label>
                        <div class="form-group" id="channel">
                            <label class="checkbox-inline"><input name="channel[]" class="channel" type="checkbox" checked="checked" value="Desktop" />Desktop</label>
                            <label class="checkbox-inline"><input name="channel[]" class="channel" type="checkbox" checked="checked" value="Mobile site" />Mobile site</label>
                            <label class="checkbox-inline"><input name="channel[]" class="channel" type="checkbox" checked="checked" value="Android" />Android</label>
                            <label class="checkbox-inline"><input name="channel[]" class="channel" type="checkbox" checked="checked" value="iOS" />iOS</label>
                        </div>
                     </div>
                     <div class="col-lg-6  hrclass"  style="background: #bcbcbc;"  >
                        <label for="role" class="control-label">Role</label>
                        <div class="form-group" id="role">
                            <label class="checkbox-inline"><input name="role[]" class="role" type="checkbox" checked="checked" value="Individual" />Individual</label>
                            <label class="checkbox-inline"><input name="role[]" class="role" type="checkbox" checked="checked" value="Broker" />Broker</label>
                            <label class="checkbox-inline"><input name="role[]" class="role" type="checkbox" checked="checked" value="Builder" />Builder</label>
                        </div>
                     </div>
                     <div class="col-lg-6 hrclass"  style="background: #bcbcbc;"  >
                        <label for="gender" class="control-label">Gender</label>
                        <div class="form-group" id="gender">
                            <label class="checkbox-inline"><input name="gender[]" class="gender" type="checkbox" checked="checked" value="M" />Male</label>
                            <label class="checkbox-inline"><input name="gender[]" class="gender" type="checkbox" checked="checked" value="F" />Female</label>
                        </div>
                     </div>
                     <div class="col-lg-6 hrclass"  style="background: #bcbcbc;"  >
                        <label for="follow_up_count" class="control-label">Follow up count</label>
                        <div class="form-group" id="followups">
                            <label class="checkbox-inline"><input name="total_followups[]" class="followups" type="checkbox" checked="checked" value="0-2" />0-2</label>
                            <label class="checkbox-inline"><input name="total_followups[]" class="followups" type="checkbox" checked="checked" value="3-5" />3-5</label>
                            <label class="checkbox-inline"><input name="total_followups[]" class="followups" type="checkbox" checked="checked" value="5+" />Above 5</label>
                        </div>
                     </div>
                     <div class="col-lg-12 hrclass">
                        <label for="follow_up_count" class="control-label">Source</label>
                        <div class="form-group" id="source_1">
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Want Ad" />WANT AD</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Requirement Popup" />REQUIREMENT POPUP</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Enquiry" />ENQUIRY</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Click To Call In Listing" />CLICK TO CALL IN LISTING</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Im Interested In Project" />IM INTERESTED IN PROJECT</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Click To View In Listing" />CLICK TO VIEW IN LISTING</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Contact In Listing SNB" />CONTACT IN LISTING SNB</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Project Contact In BUILDER" />PROJECT CONTACT IN BUILDER</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Project Contact In Project" />PROJECT CONTACT IN PROJECT</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Contact In Listing Project" />CONTACT IN LISTING PROJECT</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Contact In Listing Flp" />CONTACT IN LISTING FLP</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Im Interested In Builder" />IM INTERESTED IN BUILDER</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Chat in Listing" />CHAT</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="QC" />QUIKR CONNECT</label>
                        <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Home Page Alert" />HOME PAGE ALERT</label>
                           <!-- <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Want Ad" />Want Ad</label>
                            <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Enquiry" />Subscription Alert Popup(Enquiry)</label>
                            <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Reply on search result" />Reply on search result</label>
                            <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Reply on VAP" />Reply on VAP</label>
                            <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Chat" />Chat</label>
                            <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="I am interested to buy" />I am interested to buy</label>
                            <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Pop up" />Pop up</label>
                            <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Toll Free" />Toll Free</label><br />
                            <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Contact" />Contact</label>
                            <label class="checkbox-inline"><input name="source[]" class="source" type="checkbox" checked="checked" value="Click to view phone number" />Click to view phone number</label>-->
                        </div>
                     </div>
                     <div class="col-lg-12 hrclass" style="background: #bcbcbc;" >
                        <label for="profession" class="control-label">Profession</label>
                        <div class="form-group" id="profession">
                            <label class="checkbox-inline"><input name="profession[]" class="prof" type="checkbox" checked="checked" value="NRI" />NRI</label>
                            <label class="checkbox-inline"><input name="profession[]" class="prof" type="checkbox" checked="checked" value="Relocator" />Relocator</label>
                            <label class="checkbox-inline"><input name="profession[]" class="prof" type="checkbox" checked="checked" value="MNC" />MNC</label>
                            <label class="checkbox-inline"><input name="profession[]" class="prof" type="checkbox" checked="checked" value="Sr. Manager" />Sr. Manager</label>
                            <label class="checkbox-inline"><input name="profession[]" class="prof" type="checkbox" checked="checked" value="House wife" />House wife</label>
                            <label class="checkbox-inline"><input name="profession[]" class="prof" type="checkbox" checked="checked" value="Government" />Government</label>
                            <label class="checkbox-inline"><input name="profession[]" class="prof" type="checkbox" checked="checked" value="Self Employed" />Self Employed</label>
                        </div>
                     </div>
                     <div class="col-lg-12 hrclass" >
                        <label for="primay_intent" class="control-label">Primay Intent</label>
                        <div class="form-group" id="primary_intent">
                            <label class="checkbox-inline"><input name="primary_in[]" class="bstype propfr1" type="checkbox" checked="checked" value="Buy" />Buy</label>
                            <label class="checkbox-inline"><input name="primary_in[]" class="bstype propfr2" type="checkbox" checked="checked" value="Sell" />Sell</label>
                            <label class="checkbox-inline"><input name="primary_in[]" class="renttype propfr1" type="checkbox" checked="checked" value="Rent In" />Rent In</label>
                            <label class="checkbox-inline"><input name="primary_in[]" class="renttype propfr2" type="checkbox" checked="checked" value="Rent Out" />Rent Out</label>
                            <label class="checkbox-inline"><input name="primary_in[]" class="pgtype propfr1" type="checkbox" checked="checked" value="Pg in" />Pg in</label>
                            <label class="checkbox-inline"><input name="primary_in[]" class="pgtype propfr2" type="checkbox" checked="checked" value="Pg out" />Pg out</label>
                        </div>
                     </div>
                     <div class="col-lg-6 ">
                        <label for="property_intent" class="control-label">Secondary property category intent</label>
                        <div class="form-group" id="category1">
                            <label class="checkbox-inline colorprop"><input type="checkbox" id="residential" checked="checked" class="propcategory" name="propcategory" id="prop_type_res" value="Residential" />Residential </label><br />
                            <label class="checkbox-inline"><input name="property_type[]" type="checkbox" class="residential subcatptype" checked="checked" value="Apartment" />Apartment</label>
                                <label class="checkbox-inline"><input name="property_type[]" type="checkbox" class="residential subcatptype" checked="checked" value="Builder Floor" />Builder Floor</label>
                                <label class="checkbox-inline"><input name="property_type[]" type="checkbox" class="residential subcatptype" checked="checked" value="Villa" />Villa</label>
                                <label class="checkbox-inline"><input name="property_type[]" type="checkbox" class="residential subcatptype" checked="checked" value="Residential Plot" />Residential Plot</label>
                        </div>
                     </div>
                      <div class="col-lg-6 ">
                      <label for="property_intent" class="control-label">&nbsp;</label>
                      <div class="form-group" id="category2">
                            <label class="checkbox-inline colorprop"><input id="commercial" type="checkbox" checked="checked" class="propcategory" name="propcategory" id="prop_type_com" value="Commercial" />Commercial</label><br />
                                <label class="checkbox-inline"><input name="property_type[]" type="checkbox" class="commercial subcatptype" checked="checked" value="Retail Shop" />Retail Shop</label>
                                <label class="checkbox-inline"><input name="property_type[]" type="checkbox" class="commercial subcatptype" checked="checked" value="Complex Office" />Complex Office</label>
                                <label class="checkbox-inline"><input name="property_type[]" type="checkbox" class="commercial subcatptype" checked="checked" value="Commercial Plot" />Commercial Plot</label>
                        </div>
                     </div>
                     <div class="col-lg-12 hrclass">
                      <div class="form-group" id="category3">
                            <label class="checkbox-inline colorprop"><input id="agriculture" type="checkbox" checked="checked" class="propcategory" name="propcategory" id="prop_type_agri" value="Agriculture" />Agriculture</label><br />
                                <label class="checkbox-inline"><input name="property_type[]" type="checkbox" class="agriculture subcatptype" checked="checked" value="Agriculture Plot" />Agriculture Plot</label>
                       </div>
                     </div>  
                     <div class="col-lg-12 hrclass"  style="background: #bcbcbc;" >
                        <label for="construction_phase" class="control-label">Construction Phase</label>
                        <div class="form-group" id="cons_phases">
                            <label class="checkbox-inline"><input name="con_phase[]" class="consph" type="checkbox" checked="checked" value="RTM" />RTM</label>
                            <label class="checkbox-inline"><input name="con_phase[]" class="consph" type="checkbox" checked="checked" value="New Launch" />New Launch</label>
                            <label class="checkbox-inline"><input name="con_phase[]" class="consph" type="checkbox" checked="checked" value="Under Construction" />Under Construction</label>
                        </div>
                     </div>
                     <div class="col-lg-3 hrclass" style="display:none;"  >
                        <label for="state" class="control-label">State</label>
                        <div class="form-group" id="projVal">
                            <select disabled="" data-placeholder="Choose a State" class="chosen-select" multiple style="width:220px;" tabindex="4" id="inputState" name="inputState[]">
                            </select>
                        </div>
                     </div>
                     <div id="justRefresh">
                       <div class="col-lg-3 hrclass">
                        <label for="city" class="control-label">City</label>
                        <div class="form-group" id="cityVal">
                            <select data-placeholder="Choose a City" class="chosen-select" id="inputCity" style="width:220px;" tabindex="4" multiple name="inputCity[]" >
                            </select>
                        </div>
                      </div>
                      <!--<div class="col-lg-3 hrclass">
                        <label for="Locality" class="control-label">Locality</label>
                        <div class="form-group" id="localityVal">
                            <select data-placeholder="Choose a Locality" class="chosen-select" id="inputLocality" style="width:220px;"  tabindex="4" name="inputLocality[]" ></select>
                        </div>
                      </div>
                        <div class="col-lg-3 hrclass">
                        <label for="Project" class="control-label">Project</label>
                        <div class="form-group" id="proVal">
                            <select data-placeholder="Choose a Project" class="chosen-select" id="inputProject" style="width:220px;" multiple tabindex="4" name="inputProject[]" >
                            </select>
                        </div>
                     </div>
                   
                    <input type="button" value="ADD" onclick="AddLocality_select();" name="addlocality" id="addlocality" class="btn btn-primary" style="margin-top:20px;" />-->
                   
                   </div>

                       
                   <div id="justRefresh_txt"> </div>
                        <div class="col-lg-3 hrclass">
                        <div class="form-group pull-right">
                            
                            <input name="cityIdsval" id="cityIdsval" type="hidden" />
                            <input name="inputLocalityval" id="inputLocalityval" type="hidden" />
                            <input name="inputProjectval" id="inputProjectval" type="hidden" />     
                        </div>
                     </div>



                     <div class="col-lg-12 hrclass"  style="background: #bcbcbc;" >
                        <label for="budget_range" class="control-label">Budget Range</label>
                        <div class="form-group" id="budget_range">
                            <label class="checkbox-inline"><input name="price[]" class="price_range" type="checkbox" checked="checked" value="1000000-2000000" />10-20 lakhs</label>
                            <label class="checkbox-inline"><input name="price[]" class="price_range" type="checkbox" checked="checked" value="2100000-3500000" />21-35 lakhs</label>
                            <label class="checkbox-inline"><input name="price[]" class="price_range" type="checkbox" checked="checked" value="3600000-5000000" />36-50 lakhs</label>
                            <label class="checkbox-inline"><input name="price[]" class="price_range" type="checkbox" checked="checked" value="5100000-7500000" />51-75 lakhs</label>
                            <label class="checkbox-inline"><input name="price[]" class="price_range" type="checkbox" checked="checked" value="7600000-9500000" />76-95 lakhs</label>
                            <label class="checkbox-inline"><input name="price[]" class="price_range" type="checkbox" checked="checked" value="9500000-abv" />Above 95 lakhs</label>
                        </div>
                     </div>
                     <div class="col-lg-12 hrclass"  style="background: #bcbcbc;"  >
                        <label for="area_range" class="control-label">Area Range(Sq feet)</label>
                        <div class="form-group" id="area_range">
                            <label class="checkbox-inline"><input name="area[]" class="area" type="checkbox" checked="checked" value="0-100" />0-100 Sq.ft</label>
                            <label class="checkbox-inline"><input name="area[]" class="area" type="checkbox" checked="checked" value="101-600" />101-600 Sq.ft</label>
                            <label class="checkbox-inline"><input name="area[]" class="area" type="checkbox" checked="checked" value="601-800" />601-800 Sq.ft</label>
                            <label class="checkbox-inline"><input name="area[]" class="area" type="checkbox" checked="checked" value="801-1300" />801-1300 Sq.ft</label>
                            <label class="checkbox-inline"><input name="area[]" class="area" type="checkbox" checked="checked" value="1301-1600" />1301-1600 Sq.ft</label>
                            <label class="checkbox-inline"><input name="area[]" class="area" type="checkbox" checked="checked" value="1601-1800" />1601-1800 Sq.ft</label>
                            <label class="checkbox-inline"><input name="area[]" class="area" type="checkbox" checked="checked" value="1800-abv" />Above 1800 Sq.ft</label>
                        </div>
                     </div>
                     <div class="col-lg-12 hrclass"  style="background: #bcbcbc;"  >
                        <label for="bhk_range" class="control-label">BHKs</label>
                        <div class="form-group" id="bedroom">
                            <label class="checkbox-inline"><input name="bhk[]" class="bhkbuttons" type="checkbox" checked="checked" value="1RK" />1RK</label>
                            <label class="checkbox-inline"><input name="bhk[]" class="bhkbuttons" type="checkbox" checked="checked" value="1" />1BHK</label>
                            <label class="checkbox-inline"><input name="bhk[]" class="bhkbuttons" type="checkbox" checked="checked" value="2" />2BHK</label>
                            <label class="checkbox-inline"><input name="bhk[]" class="bhkbuttons" type="checkbox" checked="checked" value="3" />3BHK</label>
                            <label class="checkbox-inline"><input name="bhk[]" class="bhkbuttons" type="checkbox" checked="checked" value="4" />4BHK</label>
                            <label class="checkbox-inline"><input name="bhk[]" class="bhkbuttons" type="checkbox" checked="checked" value="4+" />4+ BHKs</label>
                        </div>
                     </div>
                     <div class="col-lg-4 hrclass"  style="background: #bcbcbc;"  >
                        <label for="home_loan" class="control-label">Home Loan requirement</label>
                        <div class="form-group" id="loan_requirement">
                            <label class="checkbox-inline"><input name="loan_req[]" class="loan_req" type="checkbox" checked="checked" value="Yes" />Yes</label>
                            <label class="checkbox-inline"><input name="loan_req[]" class="loan_req" type="checkbox" checked="checked" value="No" />No</label>
                        </div>
                     </div>
                     <div class="col-lg-4 hrclass" style="display:none;" >
                        <label for="purpose" class="control-label">Purpose</label>
                        <div class="form-group" id="purpose">
                            <label class="checkbox-inline"><input name="purpose[]" class="purpose" type="checkbox" checked="checked" value="Self use" />Self use</label>
                            <label class="checkbox-inline"><input name="purpose[]" class="purpose" type="checkbox" checked="checked" value="Investment" />Investment</label>
                            <label class="checkbox-inline"><input name="purpose[]" class="purpose" type="checkbox" checked="checked" value="Both" />Both</label>
                        </div>
                     </div>
                     <div class="col-lg-4 hrclass"  style="background: #bcbcbc;"  >
                        <label for="purpose" class="control-label">Urgency</label>
                        <div class="form-group" id="urgency">
                            <label class="checkbox-inline"><input name="urgency[]" class="urgency" type="checkbox" checked="checked" value="Duration 1" />Duration 1</label>
                            <label class="checkbox-inline"><input name="urgency[]" class="urgency" type="checkbox" checked="checked" value="Duration 2" />Duration 2</label>
                            <label class="checkbox-inline"><input name="urgency[]" class="urgency" type="checkbox" checked="checked" value="Duration 3" />Duration 3</label>
                        </div>
                     </div>
                     <div class="col-lg-12 hrclass" >
                        <label for="purpose" class="control-label">&nbsp;</label>
                        <div class="form-group pull-right">
                        <input name="_tokencomp" id="_tokencomp" type="hidden" value="{!! csrf_token() !!}" />
                        <input type="button" value="Submit" onclick="createCompetency();" name="competency" id="competency" class="btn btn-primary" />
                        </div>
                     </div>
                     </div>
                   </div>
                </form>
            </div>
            </div>
        </div>
        
    <div class="modal fade" id="editCompetencyModal" role="dialog">
        <div class="modal-dialog" style="width:800px;">
         <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit Competency Profile</h4>
            </div>
            <div class="modal-body" style="min-height:600px;">
                <div class="col-lg-12">
                    <label for="follow_up_count" class="control-label">Source</label>
                    <div class="form-group" id="source_1edit">
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceWA" type="checkbox" value="Want Ad" />WANT AD</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceRP" type="checkbox" value="Requirement Popup" />REQUIREMENT POPUP</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceEnq" type="checkbox" value="Enquiry" />ENQUIRY</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceCCL" type="checkbox" value="Click To Call In Listing" />CLICK TO CALL IN LISTING</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceIP" type="checkbox" value="Im Interested In Project" />IM INTERESTED IN PROJECT</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceVL" type="checkbox" value="Click To View In Listing" />CLICK TO VIEW IN LISTING</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceCLS" type="checkbox" value="Contact In Listing SNB" />CONTACT IN LISTING SNB</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourcePCB" type="checkbox" value="Project Contact In BUILDER" />PROJECT CONTACT IN BUILDER</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourcePCP" type="checkbox" value="Project Contact In Project" />PROJECT CONTACT IN PROJECT</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceCLP" type="checkbox" value="Contact In Listing Project" />CONTACT IN LISTING PROJECT</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceCLF" type="checkbox" value="Contact In Listing Flp" />CONTACT IN LISTING FLP</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceIIB" type="checkbox" value="Im Interested In Builder" />IM INTERESTED IN BUILDER</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceCL" type="checkbox" value="Chat in Listing" />CHAT</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceQC" type="checkbox" value="QC" />QUIKR CONNECT</label>
                        <label class="checkbox-inline"><input name="source_edit[]" class="source_edit" id="sourceHPA" type="checkbox" checked="checked" value="Home Page Alert" />HOME PAGE ALERTt</label>
                    </div>
                 </div>
                 <div class="col-lg-12" >
                        <label for="primay_intentedit" class="control-label">Primay Intent</label>
                        <div class="form-group" id="primary_intentedit">
                            <label class="checkbox-inline"><input name="primary_inedit[]" class="bstype propfor1" id="primaryBuy" type="checkbox" value="Buy" />Buy</label>
                            <label class="checkbox-inline"><input name="primary_inedit[]" class="bstype propfor2" id="primarySell" type="checkbox" value="Sell" />Sell</label>
                            <label class="checkbox-inline"><input name="primary_inedit[]" class="renttype propfor1" id="primaryRI" type="checkbox" value="Rent In" />Rent In</label>
                            <label class="checkbox-inline"><input name="primary_inedit[]" class="renttype propfor2" id="primaryRO" type="checkbox" value="Rent Out" />Rent Out</label>
                            <label class="checkbox-inline"><input name="primary_inedit[]" class="pgtype propfor1" id="primaryPI" type="checkbox" value="Pg in" />Pg in</label>
                            <label class="checkbox-inline"><input name="primary_inedit[]" class="pgtype propfor2" id="primaryPO" type="checkbox" value="Pg out" />Pg out</label>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <label for="property_intentedit" class="control-label">Secondary property category intent</label>
                        <div class="form-group" id="category1edit">
                                <label class="checkbox-inline colorprop"><input type="checkbox" id="residentialedit" class="propcategoryedit" name="propcategoryedit" id="prop_type_resedit" value="Residential" />Residential </label><br />
                                <label class="checkbox-inline"><input name="property_typeedit[]" type="checkbox" id="secondaryApt" class="residentialedit sub_catptype" value="Apartment" />Apartment</label>
                                <label class="checkbox-inline"><input name="property_typeedit[]" type="checkbox" id="secondaryBF" class="residentialedit sub_catptype" value="Builder Floor" />Builder Floor</label>
                                <label class="checkbox-inline"><input name="property_typeedit[]" type="checkbox" id="secondaryVilla" class="residentialedit sub_catptype" value="Villa" />Villa</label>
                                <label class="checkbox-inline"><input name="property_typeedit[]" type="checkbox" id="secondaryRP" class="residentialedit sub_catptype" value="Residential Plot" />Residential Plot</label>
                        </div>
                     </div>
                      <div class="col-lg-6">
                      <label for="property_intentedit" class="control-label">&nbsp;</label>
                      <div class="form-group" id="category2edit">
                            <label class="checkbox-inline colorprop"><input id="commercialedit" type="checkbox" class="propcategoryedit" name="propcategoryedit" id="prop_type_comedit" value="Commercial" />Commercial</label><br />
                                <label class="checkbox-inline"><input name="property_typeedit[]" type="checkbox" id="secondaryRS" class="commercialedit sub_catptype" value="Retail Shop" />Retail Shop</label>
                                <label class="checkbox-inline"><input name="property_typeedit[]" type="checkbox" id="secondaryCO" class="commercialedit sub_catptype" value="Complex Office" />Complex Office</label>
                                <label class="checkbox-inline"><input name="property_typeedit[]" type="checkbox" id="secondaryCP" class="commercialedit sub_catptype" value="Commercial Plot" />Commercial Plot</label>
                        </div>
                     </div>
                     <div class="col-lg-12">
                      <div class="form-group" id="category3edit">
                            <label class="checkbox-inline colorprop"><input id="agricultureedit" type="checkbox" class="propcategoryedit" name="propcategoryedit" id="prop_type_agriedit" value="Agriculture" />Agriculture</label><br />
                                <label class="checkbox-inline"><input name="property_typeedit[]" type="checkbox" id="secondaryAP" class="agricultureedit sub_catptype" value="Agriculture Plot" />Agriculture Plot</label>
                       </div>
                     </div> 
                     
                     <div id="justRefreshedit">
                     <div class="col-lg-4">
                        <label for="city" class="control-label">City</label>
                         <div class="form-group" id="cityValedit">
                             <select data-placeholder="Choose a City" class="chosen-select" id="inputCityedit" style="width:200px;" tabindex="4" name="inputCityedit[]" >
                             </select>
                         </div>
                    </div>
                    <!--<div class="col-lg-4">
                        <label for="Locality" class="control-label">Locality</label>
                        <div class="form-group" id="localityValedit">
                            <select data-placeholder="Choose a Locality" class="chosen-select" id="inputLocalityedit" style="width:200px;"  tabindex="4" name="inputLocalityedit[]" >
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="Project" class="control-label">Project</label>
                        <div class="form-group" id="proValedit">
                            <select data-placeholder="Choose a Project" class="chosen-select" id="inputProjectedit" style="width:150px;" multiple tabindex="4" name="inputProjectedit[]" >
                            </select>
                        </div>
                    </div>-->
                     <!--<input type="button" style="float:right;margin-top:20px;" value="ADD" onclick="AddLocality_selectEdit();" name="addlocalityedit" id="addlocalityedit" class="btn btn-primary" />-->
                     </div>
                     <div id="justRefreshedit_txt"> </div>
                     <div class="col-lg-3 hrclass">
                        <div class="form-group pull-right">
                            
                            <input name="cityIdsvaledit" id="cityIdsvaledit" type="hidden" />
                            <input name="inputLocalityvaledit" id="inputLocalityvaledit" type="hidden" />
                            <input name="inputProjectvaledit" id="inputProjectvaledit" type="hidden" />     
                        </div>
                     </div>
                     <input type="hidden" name="agent_idedit" id="agent_idedit" value="" />
                     <div class="col-lg-12">
                     <input name="_tokencompedit" id="_tokencompedit" type="hidden" value="{!! csrf_token() !!}" />
                        <button class="btn btn-primary pull-right" onclick="editUpdateCompetency()">Update</button>
                     </div>
            </div>
            </div>
        </div>
      </div>
        <!-- Competency Profile Ends Here -->
        