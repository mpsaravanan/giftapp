<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>RealEstate Leade form</title>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <link href="{{ asset('css/bootstrap.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />     
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ asset('css/bootstrap-multiselect.css') }}" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}" />
    <link type="text/css" href="{{ asset('css/jquery.simple-dtpicker.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/chosen_multiselect.css') }}" />
<style>
.ui-autocomplete {
     z-index: 9999 !important;
}
.datepicker > .datepicker_header > .icon-close { padding: 0px; }
</style>

</head>
<body>
    <div class="container">
      <div class="marginadd">
            <div class="row">
                <div class="col-md-5 col-sm-5 col-xs-5">
                    <span class="login-img-add">
                        <img src="{{ asset('images/user-icon.png') }}" />
                    </span> 
                    <span class="name-id-add" style="width:80%;">
                    <input style="padding: 0px; font-size: 12px; height: 24px; width: 50%;" type="text" id="usernameData" name="usernameData" value="<?php echo $data->userName; ?>" readonly="readonly" />
                    <input style="padding: 0px; font-size: 11px; height: 18px; width: 10%;" value="Edit" class="btn btn-primary" name="usernameedit" id="usernameedit" onclick="editUname();" />
                    <b style="font-size:11px;"> <?php echo $data->userId; ?></b></span>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                  <div class="mobile-no-add"> 
                        Mob. No. <?php echo $data->phone1; ?>
                        <div class="edit-mobile-no">
                          <div class="dropdown">
                              <a href="javascript:void(0);" onclick="gethistoryPhone();" class="adit-bitton label label-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Edit
                                <span class="caret"></span>
                              </a>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li>
                                  <label id="updateMobileLabel">
                                      <input type="text" id="editPhone" name="editPhone" value="<?php echo $data->phone1; ?>" />
                                      <input type="button" name="updateMobile" onclick="updateMobile();" value="Update Mobile" class="btn btn-success" />
                                    </label>
                                </li>
                              </ul>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <div class="mobile-no-add"> 
                        Email-id. <?php echo $data->emailId1; ?>
                        <div class="edit-mobile-no">
                          <div class="dropdown">
                              <a href="javascript:void(0);" onclick="gethistoryEmail();" class="adit-bitton label label-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Edit
                                <span class="caret"></span>
                              </a>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li>
                                  <label id="updateEmailLabel">
                                      <input type="text" id="editEmail" name="editEmail" value="<?php echo $data->emailId1; ?>" />
                                      <input type="button" name="updateEmail" onclick="updateEmail();" value="Update Email" class="btn btn-success" />
                                    </label>
                                </li>
                              </ul>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            
            <div class="box1">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <span class="responce-id"><b>Responce Date:</b> <?php echo date('d-M-Y',($data->createdDate/1000)); ?></span>
                        <span class="responce-id"><b>Follow up count:</b> 2</span>
                        <span class="responce-id"><b>Source:</b> <?php echo $data->source1; ?></span>
                         <span class="responce-id"><b>Requirement ID:</b> <?php echo $data->id; ?></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <div class="responce-id"><b>Channel:</b> <?php echo $data->channel; ?>
                          <div class="postedby">
                              <span class="postd-radio">
                                    <input type="radio" <?php if($data->postedBy=="BROKER"){ ?> checked="checked" <?php } ?> value="BROKER" name="postedby"  />
                                    <label for="Broker">Broker</label>
                                </span>
                                <span class="postd-radio">
                                     <input type="radio" <?php if($data->postedBy=="INDIVIDUAL"){ ?> checked="checked" <?php } ?> value="INDIVIDUAL" name="postedby"  /> 
                                     <label for="Individual">Individual</label>
                                </span>
                                <span class="postd-radio">
                                    <input type="radio" <?php if($data->postedBy=="BUILDER"){ ?> checked="checked" <?php } ?> value="BUILDER" name="postedby"  />
                                    <label for="Builder">Builder</label>
                                </span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <span class="responce-id"><b>Intent Type:</b> Like/Comment</span>
                        <span class="responce-id"><b>Profession:</b> 
                          <select id="profession" class="" name="profession">
                                <option value="">Select</option>
                                <option <?php if($data->profession=="NRI"){ ?>selected="selected"<?php } ?> value="NRI">NRI</option>
                                <option <?php if($data->profession=="Relocator"){ ?>selected="selected"<?php } ?> value="Relocator">Relocator</option>
                                <option <?php if($data->profession=="MNC"){ ?>selected="selected"<?php } ?> value="MNC">MNC</option>
                                <option <?php if($data->profession=="Sr. Manager"){ ?>selected="selected"<?php } ?> value="Sr. Manager">Sr. Manager</option>
                                <option <?php if($data->profession=="Housewife"){ ?>selected="selected"<?php } ?> value="Housewife">Housewife</option>
                                <option <?php if($data->profession=="Govt"){ ?>selected="selected"<?php } ?> value="Govt">Government</option>
                                <option <?php if($data->profession=="self employed"){ ?>selected="selected"<?php } ?> value="self employed">Self Employed</option>
                            </select>
                        </span>
                        <span class="responce-id"><b>Gender:</b> 
                          <input type="radio" <?php if ($data->gender == "M"){ ?>checked="checked" <?php } ?> value="M" name="gender"  />
                                <label for="Male">Male</label>
                                <input type="radio" <?php if ($data->gender == "F"){ ?>checked="checked" <?php } ?> value="F" name="gender"  />
                                 <label for="Female">Female</label>
                        </span>
                    </div>
                </div>
          </div>
        <div class="according-add">
          <div class="panel-group" id="accordion">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                  <?php 
                    if ($data->bhks != "")
                    {
                        $bhkseries="";
                        $bhkcount = explode(',',$data->bhks);
                        foreach($bhkcount as $bhk)
                        {
                             $bhkseries.=$bhk."/";
                        }
                        echo rtrim($bhkseries, "/")." BHK";
                    }
                    ?>
                    <?php echo $data->areaMin; ?> - <?php echo $data->areaMax; ?> sqft  
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <b>Latest Call Disposition:</b> <?php echo $data->status; ?>
                    <a class="accordion-toggle pull-right" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                      <i class="indicator glyphicon glyphicon-chevron-down"></i>
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-2 col-sm-2 col-xs-2">
                            <span class="postd-radio floatnone">
                                <input <?php if (stripos($data->transactionType,"buy")!==false){ ?>checked="checked"<?php } ?> class="bstype propfr1" onclick="checkTransactype('bstype');"  type="radio" name="transactiontype" value="buy" />
                                <label for="Buy">Buy</label>
                            </span>
                            <span class="postd-radio floatnone">
                                <input <?php if (stripos($data->transactionType,"sale")!==false){ ?>checked="checked"<?php } ?> class="bstype propfr2" onclick="checkTransactype('bstype');"  type="radio" name="transactiontype" value="sale" />
                                <label for="Sale">Sale</label>
                            </span>
                          <span class="postd-radio floatnone">
                                <input <?php if (stripos($data->transactionType,"rent")!==false && $data->transactionType!="rent_in"){ ?>checked="checked"<?php } ?> onclick="checkTransactype('renttype');" class="renttype propfr1"   type="radio" name="transactiontype" value="rent" />
                                <label for="Rent">Rent</label>
                            </span>
                            <span class="postd-radio floatnone">
                                <input <?php if (stripos($data->transactionType,"rent_in")!==false){ ?>checked="checked"<?php } ?> class="renttype propfr2" onclick="checkTransactype('renttype');"  name="transactiontype" type="radio" value="rent_in" />
                                <label for="Rent-out">Rent In</label>
                            </span>
                            <span class="postd-radio floatnone">
                                <input <?php if (stripos($data->transactionType,"pg")!==false && $data->transactionType!="pg_in"){ ?>checked="checked"<?php } ?> onclick="checkTransactype('pgtype');" class="pgtype propfr1"  name="transactiontype" type="radio" value="pg" />
                                <label for="PG">PG</label>
                            </span>
                            <span class="postd-radio floatnone">
                               <input <?php if (stripos($data->transactionType,"pg_in")!==false){ ?>checked="checked"<?php } ?> class="pgtype propfr2" onclick="checkTransactype('pgtype');"  name="transactiontype" type="radio" value="pg_in" />
                                <label for="PG-out">PG In</label>
                            </span>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                          <span class="responce-id"><b>City:</b> <?php echo $data->cityName; ?></span>
                            <span class="responce-id"><b>Locality:<span class="redstarm" style="color:red;display:none;">*</span></b> 
                            <select id="locations" name="locations[]" multiple="multiple" style="width:92%;">
                            </select>
                            </span>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                          <div class="project-ad">
                                <span class="responce-id"><b>Projects</b></span>
                                <select id="projectsselect" name="projectsselect[]" multiple="multiple" style="width:92%;">
                            </select>
                            </div>
                            <div class="project-ad">
                              <span class="responce-id"><b>Project Name Search</b></span>
                              <input type="text" id="project_namesearch" style="width:98%;" name="project_name" placeholder="Enter Project Name"  value="" class="form-group" />
                            </div>
                            <div class="r-ch">
                              <span class="responce-id"><b>Construction Phase</b></span>
                                <span class="postd-radio margin-left-0">
                                <input <?php if(stripos($data->constructionPhases,"NEW_LAUNCH")!==false){ ?> checked="checked" <?php } ?> name="constructionphases" class="consph"  type="checkbox" value="NEW_LAUNCH" />
                                    <label for="New">New Launch</label>
                                </span>
                                <span class="postd-radio">
                                <input <?php if(stripos($data->constructionPhases,"READY_TO_MOVE_IN")!==false){ ?> checked="checked" <?php } ?> name="constructionphases" class="consph"  type="checkbox" value="READY_TO_MOVE_IN" />
                                <label for="RTM"> RTM</label>
                                </span>
                                <span class="postd-radio">
                                    <input <?php if(stripos($data->constructionPhases,"UNDER_CONSTRUCTION")!==false){ ?> checked="checked" <?php } ?> name="constructionphases" class="consph"  type="checkbox" value="UNDER_CONSTRUCTION" />
                                <label for="RTM"> Under Const</label>
                                 </span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                        <label for="users"><b>Property Type<span class="redstarm" style="color:red;display:none;">*</span></b></label>
                          <span class="postd-radio floatnone">
                                <input type="radio" name="propcategory" onclick="changeCategory();" value="Residential" <?php  if ($data->category == "Residential"){ ?>checked="checked"<?php } ?>  />
                                <label for="Residential"><b>Residential</b></label>
                            </span>
                            <div class="residential-ad">
                                 <span class="postd-radio">
                                    <input <?php if (stripos($data->propertyTypes,"Apartment")!==false){ ?>checked="checked"<?php } ?> class="aptprop"  type="checkbox" name="proptypes" value="Apartment" /><label for="Apartment">Apart. </label>
                                </span>
                                <span class="postd-radio">
                                    <input <?php if (stripos($data->propertyTypes,"BuilderFloor")!==false){ ?>checked="checked"<?php } ?> class="aptprop"  type="checkbox" name="proptypes" value="BuilderFloor" />
                                    <label for="bf">BuilderFloor </label>
                                </span>
                                <span class="postd-radio">
                                    <input <?php if (stripos($data->propertyTypes,"Villa")!==false){ ?>checked="checked"<?php } ?> class="aptprop"  type="checkbox" name="proptypes" value="Villa" />
                                    <label for="Villa ">Villa  </label>
                                </span>
                                <span class="postd-radio">
                                    <input <?php if (stripos($data->propertyTypes,"plot")!==false && $data->category == "Residential"){ ?>checked="checked"<?php } ?> class="aptprop" name="proptypes" type="checkbox" value="Plot" />
                                    <label for="Residentialp">Resid. plot </label>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                            
                            <span class="postd-radio floatnone">
                                <input type="radio" name="propcategory" onclick="changeCategory();" value="Commercial" <?php  if ($data->category == "Commercial"){ ?>checked="checked"<?php } ?>  />
                                <label for="Commercial"><b>Commercial</b></label>
                            </span>
                            
                            
                            <div class="residential-ad">
                                <span class="postd-radio">
                                    <input <?php if (stripos($data->propertyTypes,"Shop")!==false){ ?>checked="checked"<?php } ?> class="commprop" type="checkbox" name="proptypes" value="Shop" />
                                    <label for="Retail-Shop">Retail Shop </label>
                                </span>
                                <span class="postd-radio">
                                    <input <?php if (stripos($data->propertyTypes,"Complex")!==false){ ?>checked="checked"<?php } ?> class="commprop" type="checkbox" name="proptypes" value="Complex" />
                                    <label for="Complex">Complex</label>
                                </span>
                                <span class="postd-radio">
                                    <input <?php if (stripos($data->propertyTypes,"Office")!==false){ ?>checked="checked"<?php } ?> class="commprop" type="checkbox" name="proptypes" value="Office" />
                                    <label for="Office">Office</label>
                                </span>
                                <span class="postd-radio">
                                    <input <?php if (stripos($data->propertyTypes,"plot")!==false && $data->category == "Commercial"){ ?>checked="checked"<?php } ?> class="commprop"  name="proptypes" type="checkbox" value="Plot" />
                                    <label for="cp">Comm. Plot </label>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                            
                            <span class="postd-radio floatnone">
                                <input type="radio" name="propcategory" onclick="changeCategory();" value="Agriculture" <?php  if ($data->category == "Agriculture"){ ?>checked="checked"<?php } ?>  />
                                <label for="Agriculture"><b>Agriculture</b></label>
                            </span>
                            <div class="residential-ad">
                                <span class="postd-radio">
                                    <input <?php if (stripos($data->propertyTypes,"Land")!==false){ ?>checked="checked"<?php } ?>  class="agriprop"  type="checkbox" name="proptypes" value="Land" />
                                    <label for="AgricultureLand">Agriculture Land </label>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="facing-dr">
                        <div class="row">
                            <div class="col-md-5 col-sm-5 col-xs-5">
                                <span class="Facing">Facing</span>
                                <?php  $facingsarr= explode(',',$data->facings);   ?>
                                 <button type="button" <?php if (in_array('Pool', $facingsarr, true)){ ?>class="btn btn-success facingbuttons" <?php } ?> value="Pool" class="btn btn-default facingbuttons">Pool</button> 
                                 <button type="button" <?php if (in_array('Garden', $facingsarr, true)){ ?>class="btn btn-success facingbuttons" <?php } ?> value="Garden" class="btn btn-default facingbuttons">Garden</button> 
                                 <button type="button" <?php if (in_array('Lake', $facingsarr, true)){ ?>class="btn btn-success facingbuttons" <?php } ?> value="Lake" class="btn btn-default facingbuttons">Lake</button> 
                                 <button type="button" <?php if (in_array('Road', $facingsarr, true)){ ?>class="btn btn-success facingbuttons" <?php } ?> value="Road" class="btn btn-default facingbuttons">Road</button>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7">
                              <span class="Facing">Direction</span>
                                <?php  $directionsarr= explode(',',$data->directions);   ?>
                                 <button type="button" <?php if (in_array('East', $directionsarr, true)){ ?>class="btn btn-success dirbuttons" <?php } ?> value="East" class="btn btn-default dirbuttons">E</button> 
                                 <button type="button" <?php if (in_array('West', $directionsarr, true)){ ?>class="btn btn-success dirbuttons" <?php } ?> value="West" class="btn btn-default dirbuttons">W</button> 
                                 <button type="button" <?php if (in_array('North', $directionsarr, true)){ ?>class="btn btn-success dirbuttons" <?php } ?> value="North" class="btn btn-default dirbuttons">N</button> 
                                 <button type="button" <?php if (in_array('South', $directionsarr, true)){ ?>class="btn btn-success dirbuttons" <?php } ?> value="South" class="btn btn-default dirbuttons">S</button>
                                 <button type="button" <?php if (in_array('North East', $directionsarr, true)){ ?>class="btn btn-success dirbuttons" <?php } ?> value="North East" class="btn btn-default dirbuttons">NE</button> 
                                 <button type="button" <?php if (in_array('North West', $directionsarr, true)){ ?>class="btn btn-success dirbuttons" <?php } ?> value="North West" class="btn btn-default dirbuttons">NW</button> 
                                 <button type="button" <?php if (in_array('South East', $directionsarr, true)){ ?>class="btn btn-success dirbuttons" <?php } ?> value="South East" class="btn btn-default dirbuttons">SE</button> 
                                 <button type="button" <?php if (in_array('South West', $directionsarr, true)){ ?>class="btn btn-success dirbuttons" <?php } ?> value="South West" class="btn btn-default dirbuttons">SW</button>
                            </div>
                        </div>
                    </div>
                    <div class="map-section">
                      <div class="row">
                          <div class="col-md-4 col-sm-4 col-xs-4">
                          <div id="map" style="width: 100%; height:250px;"></div>
                              <!--<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d62187.52677173101!2d77.5985902114491!3d13.053459487288627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1squikr+bangalore!5e0!3m2!1sen!2sin!4v1449232905304" width="100%" height="185" frameborder="0" style="border:0" allowfullscreen></iframe>-->
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8">
                              <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <span class="responce-id"><b>Budget</b></span>
                                        <span class="responce-id padingtop">
                                          <b>Min:<span class="redstarm" style="color:red;display:none;">*</span></b> 
                                            <input type="text" name="pricemin" id="pricemin" value="<?php echo $data->priceMin; ?>" class="col-sm-5" />&nbsp;<span id="errmsg1"></span>
                                            <!--<input type="text" id="minPricedisplay" value="" class="form-control rightls" disabled>
                                            <a class="adit-bitton label label-primary" href="#">Edit</a>-->
                                            <div class="clearfix"></div>
                                        </span>
                                        <span class="responce-id padingtop">
                                          <b>Max:<span class="redstarm" style="color:red;display:none;">*</span></b> 
                                            <input type="text" name="pricemax" id="pricemax" value="<?php echo $data->priceMax; ?>" class="col-sm-5" />&nbsp;<span id="errmsg2"></span>
                                            <!--<input type="text" id="maxPricedisplay" value="" class="form-control rightls" disabled>
                                            <a class="adit-bitton label label-primary" href="#">Edit</a>-->
                                            <div class="clearfix"></div>
                                        </span>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                    <span class="Facing">BHKs</span>
                                        <div class="selectbk">
                                         <?php $bhkvalarr= explode(',',$data->bhks); ?>
                                         <button type="button" <?php if (in_array('1', $bhkvalarr, true)){ ?>class="btn btn-success bhkbuttons" <?php } ?> value="1" class="btn btn-default bhkbuttons">1</button> 
                                         <button type="button" <?php if (in_array('2', $bhkvalarr, true)){ ?>class="btn btn-success bhkbuttons" <?php } ?> value="2" class="btn btn-default bhkbuttons">2</button> 
                                         <button type="button" <?php if (in_array('3', $bhkvalarr, true)){ ?>class="btn btn-success bhkbuttons" <?php } ?> value="3" class="btn btn-default bhkbuttons">3</button> 
                                         <button type="button" <?php if (in_array('4', $bhkvalarr, true)){ ?>class="btn btn-success bhkbuttons" <?php } ?> value="4" class="btn btn-default bhkbuttons">4</button> 
                                         <button type="button" <?php if (in_array('5', $bhkvalarr, true)){ ?>class="btn btn-success bhkbuttons" <?php } ?> value="5" class="btn btn-default bhkbuttons">5</button> 
                                        </div>
                                        <div class="selectminmax">
                                            <span class="responce-id padingtop">
                                          <b>Area Range:<span class="redstarm" style="color:red;display:none;">*</span></b> 
                                            <input type="text" name="areamin" id="areamin" value="<?php echo $data->areaMin; ?>" class="col-sm-2" />&nbsp;<span id="errmsg3"></span>
                                            <b>-</b> 
                                            <input type="text" name="areamax" id="areamax" value="<?php echo $data->areaMax; ?>" class="col-sm-2" />&nbsp;<span id="errmsg4"></span>
                                            <select id="exampleSelect1" class="col-sm-3">
                                            <option>Sq.Feet</option>
                                            </select>
                                            <div class="clearfix"></div>
                                        </span>
                                        </div>
                                       <!-- <div class="selectminmax">
                                            Super Min: 1400 - 1600 <select><option>Sqft</option><option>Sqmtr</option><option>Sqyds</option></option></select>
                                        </div>-->
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="facing-dr">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <span class="Facing">Furnishing</span>
                                                    <div style="overflow-x: scroll ! important; width: auto; height: 37px; overflow-y: hidden;display:inherit;">
                                                    <div  style="width:1500px">
                                                    <?php  $furnishingsarr= explode(',',$data->furnishings);   ?>
                                                    <button type="button" <?php if (in_array('Air Conditioner', $furnishingsarr, true)){ ?>class="btn btn-success furnishingbuttons" <?php } ?> value="Air Conditioner" class="btn btn-default furnishingbuttons">AC</button> 
                                                    <button type="button" <?php if (in_array('Beds', $furnishingsarr, true)){ ?>class="btn btn-success furnishingbuttons" <?php } ?> value="Beds" class="btn btn-default furnishingbuttons">Beds</button> 
                                                    <button type="button" <?php if (in_array('Refrigerator', $furnishingsarr, true)){ ?>class="btn btn-success furnishingbuttons" <?php } ?> value="Refrigerator" class="btn btn-default furnishingbuttons">Refrigerator</button> 
                                                    <button type="button" <?php if (in_array('Dining Table', $furnishingsarr, true)){ ?>class="btn btn-success furnishingbuttons" <?php } ?> value="Dining Table" class="btn btn-default furnishingbuttons">Dining Table</button>
                                                    <button type="button" <?php if (in_array('Water Filter', $furnishingsarr, true)){ ?>class="btn btn-success furnishingbuttons" <?php } ?> value="Water Filter" class="btn btn-default furnishingbuttons">Water Filter</button> 
                                                    <button type="button" <?php if (in_array('Microwave', $furnishingsarr, true)){ ?>class="btn btn-success furnishingbuttons" <?php } ?> value="Microwave" class="btn btn-default furnishingbuttons">Microwave</button> 
                                                    <button type="button" <?php if (in_array('Washing Machine', $furnishingsarr, true)){ ?>class="btn btn-success furnishingbuttons" <?php } ?> value="Washing Machine" class="btn btn-default furnishingbuttons">Washing Mach.</button> 
                                                    <button type="button" <?php if (in_array('Sofa', $furnishingsarr, true)){ ?>class="btn btn-success furnishingbuttons" <?php } ?> value="Sofa" class="btn btn-default furnishingbuttons">Sofa</button>
                                                    <button type="button" <?php if (in_array('Wardrobes', $furnishingsarr, true)){ ?>class="btn btn-success furnishingbuttons" <?php } ?> value="Wardrobes" class="btn btn-default furnishingbuttons">Wardrobes</button>
                                                    <button type="button" <?php if (in_array('TV', $furnishingsarr, true)){ ?>class="btn btn-success furnishingbuttons" <?php } ?> value="TV" class="btn btn-default furnishingbuttons">TV</button>
                                                    <button type="button" <?php if (in_array('Dishwasher', $furnishingsarr, true)){ ?>class="btn btn-success furnishingbuttons" <?php } ?> value="Dishwasher" class="btn btn-default furnishingbuttons">Dishwasher</button>
                                                    </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                       <div class="facing-dr">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <span class="Facing">Amenities</span>
                                                    <div style="overflow-x: scroll ! important; width: auto; height: 37px; overflow-y: hidden;display:inherit;">
                                                    <div  style="width:3500px">
                                                     <?php  $amenitiesarr= explode(',',$data->amenities);   ?>
                                                    <button type="button" <?php if (in_array('Fire Safety', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Fire Safety" class="btn btn-default amenitiesbuttons">Fire Safety</button> 
                                                    <button type="button" <?php if (in_array('Earthquake Resistant', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Earthquake Resistant" class="btn btn-default amenitiesbuttons">Earthquake Resistant</button> 
                                                    <button type="button" <?php if (in_array('24Hr Backup Electricity', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="24Hr Backup Electricity" class="btn btn-default amenitiesbuttons">24Hr Backup Electricity</button> 
                                                    <button type="button" <?php if (in_array('Gated Community', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Gated Community" class="btn btn-default amenitiesbuttons">Gated Community</button>
                                                    <button type="button" <?php if (in_array('Gas Pipeline', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Gas Pipeline" class="btn btn-default amenitiesbuttons">Gas Pipeline</button> 
                                                    <button type="button" <?php if (in_array('Jogging Track', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Jogging Track" class="btn btn-default amenitiesbuttons">Jogging Track</button> 
                                                    <button type="button" <?php if (in_array('CCTV Cameras', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="CCTV Cameras" class="btn btn-default amenitiesbuttons">CCTV Cameras</button> 
                                                    <button type="button" <?php if (in_array('Lift', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Lift" class="btn btn-default amenitiesbuttons">Lift</button>
                                                    <button type="button" <?php if (in_array('Landscaped Garden', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Landscaped Garden" class="btn btn-default amenitiesbuttons">Landscaped Garden</button>
                                                    <button type="button" <?php if (in_array('Wifi', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Wifi" class="btn btn-default amenitiesbuttons">Wifi</button>
                                                    <button type="button" <?php if (in_array('Covered Car Parking', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Covered Car Parking" class="btn btn-default amenitiesbuttons">Covered Car Parking</button>
                                                    <button type="button" <?php if (in_array('Basement Car Parking', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Basement Car Parking" class="btn btn-default amenitiesbuttons">Basement Car Parking</button>
                                                    <button type="button" <?php if (in_array('Car Parking', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Car Parking" class="btn btn-default amenitiesbuttons">Car Parking</button>
                                                    <button type="button" <?php if (in_array('Intercom', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Intercom" class="btn btn-default amenitiesbuttons">Intercom</button>
                                                    <button type="button" <?php if (in_array('Swimming Pool', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Swimming Pool" class="btn btn-default amenitiesbuttons">Swimming Pool</button>
                                                    <button type="button" <?php if (in_array('Rain Water Harvesting', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Rain Water Harvesting" class="btn btn-default amenitiesbuttons">Rain Water Harvesting</button>
                                                    <button type="button" <?php if (in_array('Play Area', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Play Area" class="btn btn-default amenitiesbuttons">Play Area</button>
                                                    <button type="button" <?php if (in_array('Gymnasium', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Gymnasium" class="btn btn-default amenitiesbuttons">Gymnasium</button>
                                                    <button type="button" <?php if (in_array('Indoor Games', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Indoor Games" class="btn btn-default amenitiesbuttons">Indoor Games</button>
                                                    <button type="button" <?php if (in_array('Club House', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Club House" class="btn btn-default amenitiesbuttons">Club House</button>
                                                    <button type="button" <?php if (in_array('Health Facilities', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Health Facilities" class="btn btn-default amenitiesbuttons">Health Facilities</button>
                                                    <button type="button" <?php if (in_array('Maintenance Staff', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Maintenance Staff" class="btn btn-default amenitiesbuttons">Maintenance Staff</button>
                                                    <button type="button" <?php if (in_array('Cafeteria', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Cafeteria" class="btn btn-default amenitiesbuttons">Cafeteria</button>
                                                    <button type="button" <?php if (in_array('Basket Ball Court', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Basket Ball Court" class="btn btn-default amenitiesbuttons">Basket Ball Court</button>
                                                    <button type="button" <?php if (in_array('AC Lobby', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="AC Lobby" class="btn btn-default amenitiesbuttons">AC Lobby</button>
                                                    <button type="button" <?php if (in_array('Badminton Court', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Badminton Court" class="btn btn-default amenitiesbuttons">Badminton Court</button>
                                                    <button type="button" <?php if (in_array('Waste Disposal', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Waste Disposal" class="btn btn-default amenitiesbuttons">Waste Disposal</button>
                                                    <button type="button" <?php if (in_array('Tennis Court', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Tennis Court" class="btn btn-default amenitiesbuttons">Tennis Court</button>
                                                    <button type="button" <?php if (in_array('Community Hall', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Community Hall" class="btn btn-default amenitiesbuttons">Community Hall</button>
                                                    <button type="button" <?php if (in_array('Convenience Store', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Convenience Store" class="btn btn-default amenitiesbuttons">Convenience Store</button>
                                                    <button type="button" <?php if (in_array('Library', $amenitiesarr, true)){ ?>class="btn btn-success amenitiesbuttons" <?php } ?> value="Library" class="btn btn-default amenitiesbuttons">Library</button>
                                                    </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="facing-dr">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <span class="Facing">Bathrooms</span>
                                                    <?php 
                                                    foreach(explode(',',$data->bathrooms) as $bathrooms){
                                                    if(trim($bathrooms)!=''){
                                                    ?>
                                                    <span class="facing-select-box"><?php echo $bathrooms; ?></span>
                                                    <?php }
                                                     }
                                                     ?>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="facing-dr">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <span class="Facing">Balconies</span>
                                                    <?php 
                                                    foreach(explode(',',$data->balconies) as $balconies){
                                                    if(trim($balconies)!=''){
                                                    ?><span class="facing-select-box"><?php echo $balconies; ?></span>
                                                     <?php }
                                                     }
                                                     ?>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdownad clearfix"style="height: 54px;">
                      <div class="row">
                          <div class="col-md-2 col-sm-2 col-xs-2">
                              <div class="dropdownadd">
                                <label>Loan Requirement</label>
                                    <select id="loanrequirement" name="loanrequirement" class="form-control ">
                                        <option value="">Select</option>
                                        <option <?php if ($data->loanRequirement=="YES"){ ?>selected="selected"<?php } ?> value="YES">YES</option>
                                        <option <?php if ($data->loanRequirement=="NO"){ ?>selected="selected"<?php } ?> value="NO">NO</option>
                                        </select>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                              <div class="dropdownadd">
                                <label>Down Payment</label>
                                    <input type="text" class="form-control" value="<?php echo $data->downPayment;  ?>" id="downpayment" name="downpayment" />
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                              <div class="dropdownadd">
                                <label>Purpose</label>
                                    <select id="purpose" name="purpose" class="form-control ">
                                        <option value="">Select</option>
                                        <option <?php if ($data->purpose=="self use"){ ?>selected="selected"<?php } ?> value="self use">Self use</option>
                                        <option <?php if ($data->purpose=="investment"){ ?>selected="selected"<?php } ?> value="investment">Investment</option>
                                        <option <?php if ($data->purpose=="both"){ ?>selected="selected"<?php } ?> value="both">Both</option>
                                        </select>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                              <div class="dropdownadd">
                                <label>Payment option</label>
                                    <select id="paymentOption" name="paymentOption" class="form-control ">
                                        <option value="">Select</option>
                                        <option <?php if ($data->paymentOption=="PARTIAL_LOAN"){ ?>selected="selected"<?php } ?> value="PARTIAL_LOAN">PARTIAL LOAN</option>
                                        <option <?php if ($data->paymentOption=="SELF_FUNDING"){ ?>selected="selected"<?php } ?> value="SELF_FUNDING">SELF FUNDING</option>
                                        </select>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                              <div class="dropdownadd">
                                <label>Urgency</label>
                                    <?php if($data->urgency=='7'){ ?>
                                    <input type="text" name="urgency" id="urgency" placeholder="Urgency" value="1 Week" class="form-control" />
                                    <?php } elseif($data->urgency=='15'){ ?>
                                    <input type="text" name="urgency" id="urgency" placeholder="Urgency" value="2 Week" class="form-control" />
                                    <?php } elseif($data->urgency=='30'){ ?>
                                    <input type="text" name="urgency" id="urgency" placeholder="Urgency" value="1 Month" class="form-control" />
                                    <?php } elseif($data->urgency=='180'){ ?>
                                    <input type="text" name="urgency" id="urgency" placeholder="Urgency" value="6 Month" class="form-control" />
                                    <?php } else{ ?>
                                    <input type="text" name="urgency" id="urgency" placeholder="Urgency" value="<?php echo $data->urgency; ?>" class="form-control" /> 
                                    <?php
                                        }
                                     ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                              <div class="dropdownadd">
                                <label>Remarks</label>
                                    <input type="text" name="remarksByUser" id="remarksByUser" placeholder="Remarks" value="<?php if ($data->remarks != ""){ echo $data->remarks; } ?>" class="form-control" />
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <div class="dropdownadd">
                                    <label>Disposition option</label>
                                    <select id="dispositionOption" name="dispositionOption" class="form-control ">
                                        <option value="">Select</option>
                                        <option <?php if ($data->status=="ENQUIRY"){ ?>selected="selected"<?php } ?> value="ENQUIRY">ENQUIRY</option>
                                        <option <?php if ($data->status=="SPAM"){ ?>selected="selected"<?php } ?> value="SPAM">SPAM</option>
                                        <option <?php if ($data->status=="WRONG_PARTY"){ ?>selected="selected"<?php } ?> value="WRONG_PARTY">WRONG_PARTY</option>
                                        <option <?php if ($data->status=="CALL_BACK_LATER"){ ?>selected="selected"<?php } ?> value="CALL_BACK_LATER">CALL_BACK_LATER</option>
                                        <option <?php if ($data->status=="RIGHT_PARTY_NI"){ ?>selected="selected"<?php } ?> value="RIGHT_PARTY_NI">RIGHT_PARTY_NI</option>
                                        <option <?php if ($data->status=="CALL_BACK_AT"){ ?>selected="selected"<?php } ?> value="CALL_BACK_AT">CALL_BACK_AT</option>
                                        <option id="right_party_rd" <?php if ($data->status=="RIGHT_PARTY_INT_RD"){ ?>selected="selected"<?php } ?> value="RIGHT_PARTY_INT_RD">RIGHT_PARTY_INT_RD</option>
                                        <option <?php if ($data->status=="CALL_DROP"){ ?>selected="selected"<?php } ?> value="CALL_DROP">CALL_DROP</option>
                                        <option <?php if ($data->status=="CONT_CALL_BK_DETAILSENT_EMAIL"){ ?>selected="selected"<?php } ?> value="CONT_CALL_BK_DETAILSENT_EMAIL">CONT_CALL_BK_DETAILSENT_EMAIL</option>
                                        <option <?php if ($data->status=="CONT_BL_INT_LG_SVC"){ ?>selected="selected"<?php } ?> value="CONT_BL_INT_LG_SVC">CONT_BL_INT_LG_SVC</option>
                                        <option <?php if ($data->status=="CONT_BL_INT_LG"){ ?>selected="selected"<?php } ?> value="CONT_BL_INT_LG">CONT_BL_INT_LG</option>
                                        <option <?php if ($data->status=="CONT_NBL_QHWL_LOP_LOCALITY"){ ?>selected="selected"<?php } ?> value="CONT_NBL_QHWL_LOP_LOCALITY">CONT_NBL_QHWL_LOP_LOCALITY</option>
                                        <option <?php if ($data->status=="CONT_NBL_QHWL_LOP_POSSESSION"){ ?>selected="selected"<?php } ?> value="CONT_NBL_QHWL_LOP_POSSESSION">CONT_NBL_QHWL_LOP_POSSESSION</option>
                                        <option <?php if ($data->status=="CONT_NBL_QHWL_LOP_PRICE"){ ?>selected="selected"<?php } ?> value="CONT_NBL_QHWL_LOP_PRICE">CONT_NBL_QHWL_LOP_PRICE</option>
                                        <option <?php if ($data->status=="CONT_NBL_QHWL_LOP_PROPERTYTYPE"){ ?>selected="selected"<?php } ?> value="CONT_NBL_QHWL_LOP_PROPERTYTYPE">CONT_NBL_QHWL_LOP_PROPERTYTYPE</option>
                                        <option <?php if ($data->status=="CONT_NBL_QHWL_LOP_OTHERS"){ ?>selected="selected"<?php } ?> value="CONT_NBL_QHWL_LOP_OTHERS">CONT_NBL_QHWL_LOP_OTHERS</option>
                                        <option <?php if ($data->status=="CONT_NS_ALREADY_FINALIZED"){ ?>selected="selected"<?php } ?> value="CONT_NS_ALREADY_FINALIZED">CONT_NS_ALREADY_FINALIZED</option>
                                        <option <?php if ($data->status=="CONT_NS_BROKER_OR_AGENT"){ ?>selected="selected"<?php } ?> value="CONT_NS_BROKER_OR_AGENT">CONT_NS_BROKER_OR_AGENT</option>
                                        <option <?php if ($data->status=="CONT_NS_NOT_A_PROP_SEEKER"){ ?>selected="selected"<?php } ?> value="CONT_NS_NOT_A_PROP_SEEKER">CONT_NS_NOT_A_PROP_SEEKER</option>
                                        <option <?php if ($data->status=="CONT_NS_NOT_A_SEEKER_TEMP"){ ?>selected="selected"<?php } ?> value="CONT_NS_NOT_A_SEEKER_TEMP">CONT_NS_NOT_A_SEEKER_TEMP</option>
                                        <option <?php if ($data->status=="CONT_NS_BLANK_CALL"){ ?>selected="selected"<?php } ?> value="CONT_NS_BLANK_CALL">CONT_NS_BLANK_CALL</option>
                                        <option <?php if ($data->status=="MMRESULT_LOVL_PROJECT"){ ?>selected="selected"<?php } ?> value="MMRESULT_LOVL_PROJECT">MMRESULT_LOVL_PROJECT</option>
                                        <option <?php if ($data->status=="NON_CONT_INVALID_NO"){ ?>selected="selected"<?php } ?> value="NON_CONT_INVALID_NO">NON_CONT_INVALID_NO</option>
                                        <option <?php if ($data->status=="NON_CONT_BUSY_OR_WAITING"){ ?>selected="selected"<?php } ?> value="NON_CONT_BUSY_OR_WAITING">NON_CONT_BUSY_OR_WAITING</option>
                                        <option <?php if ($data->status=="NON_CONT_CUSTOMER_DISCONNECT"){ ?>selected="selected"<?php } ?> value="NON_CONT_CUSTOMER_DISCONNECT">NON_CONT_CUSTOMER_DISCONNECT</option>
                                        <option <?php if ($data->status=="NON_CONT_NOT_REACHABLE"){ ?>selected="selected"<?php } ?> value="NON_CONT_NOT_REACHABLE">NON_CONT_NOT_REACHABLE</option>
                                        <option <?php if ($data->status=="NON_CONT_RINGING_NO_RESPONSE"){ ?>selected="selected"<?php } ?> value="NON_CONT_RINGING_NO_RESPONSE">NON_CONT_RINGING_NO_RESPONSE</option>
                                        <option <?php if ($data->status=="NON_CONT_SWITCHED_OFF"){ ?>selected="selected"<?php } ?> value="NON_CONT_SWITCHED_OFF">NON_CONT_SWITCHED_OFF</option>
                                        <option <?php if ($data->status=="RINGING_NO_RESPONSE_CALLBACK_AT"){ ?>selected="selected"<?php } ?> value="RINGING_NO_RESPONSE_CALLBACK_AT">RINGING_NO_RESPONSE_CALLBACK_AT</option>
                                        <option <?php if ($data->status=="SEEKER_ALREADY_CONTACTED"){ ?>selected="selected"<?php } ?> value="SEEKER_ALREADY_CONTACTED">SEEKER_ALREADY_CONTACTED</option>
                                    </select>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                            <div class="call_later" style="display:none;">
                                <label>Call back Later Date:</label>
                                <input type="text" class="call_later" name="call_later" id="call_later" />
                            </div>
                            </div>
                            <div class="col-md-3 col-sm-2 col-xs-2">
                            <div class="Call_drop" style="display:none;">
                                <label style="font-size:9px;">Click to connect again:</label>
                               <button class=" btn btn-primary call_drop" name="call_drop" id="call_drop" onclick="call_drop();">Call Dropped Abruptly</button> 
                            </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                            <div class="dropped_call_connect" style="display:none;margin-left:30px;">
                                <label style="font-size:10px;">Click to call:</label>
                               <button class="btn btn-primary dropped_call_cnt" name="dropped_call_cnt" id="dropped_call_cnt" onclick="call_drop_connect();">Click to Call</button> 
                            </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-left: 62%;margin-top: 5px;position: absolute;display:block;" >
                    <button class="btn btn-primary call_hold" name="call_hold" id="call_hold" onclick="call_hold();">Click to Hold</button> 
                    <button style="display:none;" class="btn btn-primary call_unhold" name="call_unhold" id="call_unhold" onclick="call_unhold();">Click to Unhold</button> 
                    </div>
                    <div id="upd_valid" class="dropdownad clearfix"style="height: 30px;display:none;">
                    <button type="button" id="update_validate" onclick="updateRequirement(<?php echo $data->id; ?>);" class="btn btn-primary pull-right">UPDATE & Suggest</button>
                    </div>
                    <div id="update" class="dropdownad clearfix"style="height: 30px;">
                    <button type="button" id="update_disp" onclick="updateRequirement(<?php echo $data->id; ?>);" class="btn btn-primary pull-right">UPDATE</button>
                    </div>
                  </div>
                </div>
              </div>
                <input type="hidden" value="<?php echo $data->version; ?>" name="version" id="version" />
                <input type="hidden" value="<?php echo $data->userId; ?>" name="userid" id="userid" />
                <!--<input type="hidden" value="<?php //echo $data->userName; ?>" name="username" id="username" />-->
                <input type="hidden" value="<?php echo $data->phone1; ?>" name="phone1" id="phone1" />
                <input type="hidden" value="<?php echo $data->emailId1; ?>" name="emailId1" id="emailId1" />
                <input type="hidden" value="<?php echo $data->phases; ?>" name="call_phase" id="call_phase" />
                <input type="hidden" value="<?php echo $data->callRule; ?>" name="call_rule" id="call_rule" />

                <input type="hidden" value="<?php echo date('d/m/Y H:i',strtotime(' +1 day')); ?>" name="callback_later" id="callback_later" />
                <input type="hidden" value="" name="multilocid" id="multilocid" />
                <input type="hidden"  id="cityid" value="" name="cityid" class="form-control" />
                <input name="_token" id="_token" type="hidden" value="{!! csrf_token() !!}" />
            </div>
            <div id="disposition_history">
                <table class="table table-bordered" id="history">
                    <tr class="active">
                        <th>Date</th>
                        <th>Time</th>
                        <th>Mobile</th>
                        <th>Disposition</th>
                        <th>TC Name</th>
                        <th>TC Mail ID</th>
                        <th>TC Emp ID</th>
                        <th>Remarks</th>
                    </tr>
                    <?php 
                    if(count($data->teleCallersHistory)!='0'){
                        for($i=0;$i<count($data->teleCallersHistory);$i++){
                            $date_val=$data->teleCallersHistory[$i]->calledTime;
                        if($date_val==""){
                            $date="";
                            $time="";
                        }
                        elseif($date_val!=""){
                            $date_val=str_ireplace("/", "-", $date_val);
                            $date=date("d-m-Y",strtotime($date_val));
                            $time=date("H:i:s",strtotime($date_val));
                        } ?>
                        <tr>
                            <td><?php echo $date; ?></td>
                            <td><?php echo $time; ?></td>
                            <td><?php echo $data->teleCallersHistory[$i]->mobileCalled; ?></td>
                            <td><?php echo $data->teleCallersHistory[$i]->callDisposition; ?></td>
                            <td><?php echo $data->teleCallersHistory[$i]->teleCallerName; ?></td>
                            <td><?php echo $data->teleCallersHistory[$i]->teleCallerEmail; ?></td>
                            <td><?php echo $data->teleCallersHistory[$i]->teleCallerEmpId; ?></td>
                            <td><?php echo $data->teleCallersHistory[$i]->remarks; ?></td>
                        </tr>
                        <?php 
                        } 
                    }
                    else{ ?>
                    <tr><td colspan="8" style="text-align:center;"><?php echo "No Data Available"; ?></td></tr>
                        <?php }
                        ?> 
                 </table>
            </div>
            <div class="" >
                <label>Project Details</label>
                <div class="" id="projecttable" style="display:block;" >
                
                </div>
            </div>
            <div id="matchPrj" style="display:none;" ></div>
            <div> 
                <button  style="margin-right: 10px;display:none;"  onclick="disconnectCalllead();" class="btn btn-danger pull-right discon_back_button">Disconnect</button>
                <button  style="margin-right: 10px;display:none;"  onclick="backToCurrentPage();" class="btn btn-primary pull-right discon_back_button">Back</button>
            </div>
        </div>
    </div>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/moment-with-locales.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/chosen.jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.simple-dtpicker.js')}}"></script>
    <script type="text/javascript">
    var configAjax = {
    jsRoutes: [
        { leadformUpdate: "{{ route('Leadformupdate') }}" },  //0
        { leadFormcityname: "{{ route('Leadformcity') }}" }, //1
        { leadFormlocname: "{{route('Leadformcityloc')}}"}, //2
        { leadFormProjectname: "{{route('Leadformcityproject')}}" }, //3
        { leadFormMatchmaking: "{{route('leadFormMatchmaking')}}"},//4
        { sendAllMatchmaking: "{{route('sendAllMatchmaking')}}"},//5
        { sendMatchmaking: "{{route('sendMatchmaking')}}"},//6
        { projectDetail: "{{route('projectDetail')}}"},//7
        { lackProperties: "{{route('lackProperties')}}"},//8
        { ChangeStatusAfterupdate: "{{route('ChangeStatusAfterupdate')}}"},//9
        { callDropConnect: "{{route('callDropConnect')}}"},//10
        { HoldCall: "{{route('HoldCall')}}"},//11
        { UnholdCall: "{{route('UnholdCall')}}"},//12
        { ProjectSearch: "{{route('ProjectSearch')}}"},//13
        { SendMailproject: "{{route('SendMailproject')}}"},//14
        { UpdateEmail: "{{route('UpdateEmail')}}"},//15
        { HistoryEmail: "{{route('HistoryEmail')}}"},//16
        { HistoryMobile: "{{route('HistoryMobile')}}"},//17
        { UpdateMobile: "{{route('UpdateMobile')}}"}//18
        ]
    };
    $(function(){
      $('*[name=call_later]').appendDtpicker(
        { "dateFormat": "DD/MM/YYYY hh:mm" }
        );
      var telecallrmode=window.parent.$("#telecallerMode").val();
      if(telecallrmode=='a'){
        //$("#available_button").css('display','block');
        $("#available_button").css('display','none');
      }
      else{
        $("#available_button").css('display','none');
      }
    });
    //jQuery('#call_later').datetimepicker({format:'DD/MM/YYYY hh:mm'});
   $('#dispositionOption').click(function(event) {
    var category=$("[name='propcategory']:checked").val();
    var propertyTypes="";
    var areaMin=$("#areamin").val();
    var areaMax=$("#areamax").val();
    var priceMin=$("#pricemin").val();
    var priceMax=$("#pricemax").val();       
    if(category=="Residential"){
                var proptypes = $('input:checkbox:checked.aptprop').map(function () {
                  return this.value;
                }).get();
                if(proptypes.length<1){
                }
                else{
                  var propertyTypes = proptypes.join(","); 
                }
                
            }
         if(category=="Commercial"){
                var proptypes = $('input:checkbox:checked.commprop').map(function () {
                  return this.value;
                }).get();
                if(proptypes.length<1){
                    //alert("Please select Property Type");
                    //return false;
                } 
                else{
                  var propertyTypes = proptypes.join(","); 
                }               
            }
        if(category=="Agriculture"){
                var proptypes = $('input:checkbox:checked.agriprop').map(function () {
                  return this.value;
                }).get();
                if(proptypes.length<1){
                }   
                else{
                  var propertyTypes = proptypes.join(","); 
                }
            }
            if(category=='' || propertyTypes.length==0 || priceMin=='' || priceMax=='' || areaMin=='' || areaMax==''){
                $("#right_party_rd").css('display','none');
            }
            else{
                $("#right_party_rd").css('display','block');
            }
        var disp_val=$('#dispositionOption').val();
        var val_call_rule=$("#call_rule").val();
        var val_call_phase=$("#call_phase").val();
        if(disp_val=='RIGHT_PARTY_INT_RD')
        {  
            $('#upd_valid').css('display', 'block'); 
            $('.redstarm').css('display', 'inline'); 
            $('#update').css('display', 'none'); 
            $('.call_later').css('display','none');
            $('.Call_drop').css('display','none');  
            $(".dropped_call_connect").css('display','none'); 
        }
        else if(disp_val=='CALL_BACK_AT'){
            $("#call_later").val('');
            $('.call_later').css('display','block');
            $('.Call_drop').css('display','none');  
            $(".dropped_call_connect").css('display','none'); 
        }

        else if(disp_val=="NON_CONT_RINGING_NO_RESPONSE" || disp_val=="NON_CONT_BUSY_OR_WAITING"){
            //val_call_rule,val_call_phase
            $("#call_later").val('');
            if(val_call_phase==""){
                var calllaterTime=getCallBackTime('15M');
            }
            else if(val_call_phase=="1"){
                var calllaterTime=getCallBackTime('1H');
            }
            else if(val_call_phase="2"){
                var calllaterTime=getCallBackTime('3H');
            }
            else{
                var calllaterTime=getCallBackTime('2880M');
            }
            $('#call_later').val(calllaterTime);
        }
        else if(disp_val=='RINGING_NO_RESPONSE_CALLBACK_AT'){
            $("#call_later").val('');

            $('.call_later').css('display','block');
            $('.Call_drop').css('display','none');  
            $(".dropped_call_connect").css('display','none'); 
        }
        else if(disp_val=="CALL_BACK_LATER"){
            $("#call_later").val('');
            var callbackTime=getCallBackTime('3H');
            $('#call_later').val(callbackTime);
            $('.call_later').css('display','block');
            $('.Call_drop').css('display','none');  
            $(".dropped_call_connect").css('display','none'); 
        }
        else if(disp_val=='CALL_DROP'){
            $('.Call_drop').css('display','block');
        }
        else
        {
            $('#update').css('display', 'block'); 
            $('#upd_valid').css('display', 'none'); 
            $('.call_later').css('display','none'); 
            $('.Call_drop').css('display','none');  
            $(".dropped_call_connect").css('display','none');  
        }
    });
   
    function changeCategory(){
            var category=$("[name='propcategory']:checked").val();
            //agriprop commprop aptprop
            if(category=="Residential"){
                $(".commprop").attr('checked', false);
                $(".agriprop").attr('checked', false);
            }
            else if(category=="Commercial"){
                $(".aptprop").attr('checked', false);
                $(".agriprop").attr('checked', false);
            }
            else if(category=="Agriculture"){
                $(".aptprop").attr('checked', false);
                $(".commprop").attr('checked', false);                
            }
        }
        function checkTransactype(elem){
            if(elem=="bstype"){
                 $(".renttype").attr('checked', false);
                 $(".pgtype").attr('checked', false);
            }
            else if(elem=="renttype"){
                $(".bstype").attr('checked', false);
                $(".pgtype").attr('checked', false);
            }
            else if(elem=="pgtype"){
                $(".renttype").attr('checked', false);
                $(".bstype").attr('checked', false);
            }
        }
        $(document).ready(function(){  
             //called when key is pressed in textbox
              $("#pricemin").keypress(function (e) {
                 //if the letter is not digit then display error and don't type anything
                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    //display error message
                    $("#errmsg1").html("Digits Only").show().fadeOut("slow");
                           return false;
                }
               });
              $("#pricemax").keypress(function (e) {
                 //if the letter is not digit then display error and don't type anything
                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    //display error message
                    $("#errmsg2").html("Digits Only").show().fadeOut("slow");
                           return false;
                }
               });
              $("#areamin").keypress(function (e) {
                 //if the letter is not digit then display error and don't type anything
                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    //display error message
                    $("#errmsg3").html("Digits Only").show().fadeOut("slow");
                           return false;
                }
               });
              $("#areamax").keypress(function (e) {
                 //if the letter is not digit then display error and don't type anything
                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    //display error message
                    $("#errmsg4").html("Digits Only").show().fadeOut("slow");
                           return false;
                }
               });
            $('#dateOfBirth').datetimepicker();
            var disposition=$("#dispositionOption").val();
            if(disposition=="RIGHT_PARTY_INT_RD"){
                $("#matchPrj").css("display","block");
            }
            else if(disposition=="CALL_BACK_AT"){
              $('.call_later').css('display','block');
              $('.Call_drop').css('display','none');  
              $(".dropped_call_connect").css('display','none');
              $("#matchPrj").css("display","none");
            }
            else{
                $("#matchPrj").css("display","none");
            }
            $(".bhkbuttons").click(function(e){
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            $(".facingbuttons").click(function(e){
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            $(".furnishingbuttons").click(function(e){
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            $(".dirbuttons").click(function(e){
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            $(".amenitiesbuttons").click(function(e){
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            $(".discussedval").click(function(e){
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            var locexist='<?php echo $data->localities; ?>';
            var locexistarr=[];
            locexistarr=locexist.split(","); 
            var prjexist='<?php echo $data->projects; ?>';
            var prjexistexistarr=[];
            prjexistexistarr=prjexist.split(","); 
            $.ajax({
                url: configAjax.jsRoutes[1].leadFormcityname,
                data:{cityname:'<?php echo $data->cityName ?>'},
                dataType: "json",
                success: function(data) {
                    $('#cityid').val(data);
                    var cityid=$("#cityid").val();
                    $.ajax({
                        url: configAjax.jsRoutes[2].leadFormlocname,
                        dataType: "json",
                        data:{cityid:cityid},
                        success: function( data ) {
                            if(data.length>=1){
                                loc="";   
                                for(var i=0;i<data.length;i++){
                                    if(locexistarr.indexOf(data[i].name)!==-1){
                                        loc+='<option selected="selected" value="'+data[i].id+'_'+data[i].latitude+'--'+data[i].longitude+'">' +data[i].name+ '</option>';
                                    }
                                    else{
                                        loc+='<option value="'+data[i].id+'_'+data[i].latitude+'--'+data[i].longitude+'">' +data[i].name+ '</option>';
                                    }
                                }
                            }
                            $('#locations').html(loc);
                            $("#locations").data("placeholder","Select Locations...").chosen();
                        }
                    });
                        $.ajax({
                            url: configAjax.jsRoutes[3].leadFormProjectname,
                            dataType: "json",
                            data:{cityid:cityid},
                            success: function( data ) {
                                var proj="";
                                if(data.length>=1){
                                    proj="";   
                                    for(var i=0;i<data.length;i++){
                                        if(prjexistexistarr.indexOf(data[i].name)!==-1){
                                            proj+='<option selected="selected" value="'+data[i].id+'">' +data[i].name+ '</option>';
                                        }
                                    }
                                }
                                $('#projectsselect').html(proj);
                                $("#projectsselect").data("placeholder","Select Projects...").chosen();
                            }
                        });
                    }
                });
            });
        $(function(){
           $('#lstFruits').multiselect({
            includeSelectAllOption: true
           });
           var minprice=$("#minPrice").val();
           var maxprice=$("#maxPrice").val();
           $("#minPricedisplay").val(numDifferentiation(minprice));
           $("#maxPricedisplay").val(numDifferentiation(maxprice));
        });
        function numDifferentiation(val) {
            if(val >= 10000000) val = (val/10000000).toFixed(2) + ' Cr';
            else if(val >= 100000) val = (val/100000).toFixed(2) + ' Lakh';
            else if(val >= 1000) val = (val/1000).toFixed(2) + ' K';
            return val;
        }
        function send_all(){
            if($('input[name=sendall]').is(":checked")){
            $('.senddesp').each(function(){
                $(this).prop("checked", true);
            });   
            }
            else{
            $('.senddesp').each(function(){
                $(this).prop("checked", false);
            });  
            }
        }
        
        

$( "#project_namesearch" ).autocomplete({
  minLength: 4,
  source: function( request, response ) {
  $.ajax({
      url:configAjax.jsRoutes[13].ProjectSearch,
      type:"get",
      dataType: "json",
      data:{projectname:request.term,cityname:'<?php echo $data->cityName; ?>'},
      success: function(data) {
            response( $.map( data, function( item ) {
              return {
                  label: item.name+" ("+item.city+")",
                  value: item.name,
                  key:item.id,
                  city:item.city,
                  leadname:item.lead_rec_name,
                  leademail:item.lead_rec_email,
                  leadphone:item.lead_rec_mobile,
                  leadvl:item.vl_type
                  };
            }));
        }
    });
    },
  select: function (event, ui) {
        var req_id='<?php echo $data->id; ?>';
        var buyer_email='<?php echo $data->emailId1; ?>';
        var buyer_name='<?php echo $data->userName; ?>';
        var buyer_no='<?php echo $data->phone1; ?>';
        var urlvalfirst=ui.item.value.replace(" ", "+"); 
        var urlvalfinal="http://www.quikr.com/homes/project/"+urlvalfirst+"+"+ui.item.city+"+"+ui.item.key;
        var tblrow='<div id=""><table class="table table-bordered">';
        tblrow+='<thead><tr class="active">';
        tblrow+='<th>Project Name</th><th>City</th><th>Campaign Type</th>';
        tblrow+='<th>Send Email & SMS</th>';
        tblrow+='<th>Action</th></tr></thead>';
        tblrow+='<tbody><tr><td><a href="'+urlvalfinal+'" target="_blank">'+ui.item.value+'</a></td><td>'+ui.item.city+'</td>';
        if(ui.item.leadvl=='0'){
            tblrow+='<td>Not tagged as VL in Inventory Management Tool</td>';
        }else{
            tblrow+='<td>VL</td>';
        }
        if(ui.item.leademail!="" && ui.item.leadphone!=""){
            tblrow+='<td><button type="button" onclick="send_projectemail();" class="btn btn-primary pull-right">Send</button></td>';
            tblrow+='<td><button type="button" disabled="disabled" onclick="send_projectcall();" class="btn btn-primary pull-right">Call</button></td></tr></tbody></table>';
        }
        else{
            tblrow+='<td><button type="button" disabled="disabled" class="btn btn-primary pull-right">Send</button></td>';
            tblrow+='<td><button type="button" disabled="disabled" class="btn btn-primary pull-right">Call</button></td></tr></tbody></table>';
        }
        tblrow+='<input type="hidden" value="'+ui.item.key+'" name="send_projectid" id="send_projectid" />';
        tblrow+='<input type="hidden" value="'+ui.item.value+'" name="send_projectname" id="send_projectname" />';
        tblrow+='<input type="hidden" value="'+ui.item.leadname+'" name="send_leadrecname" id="send_leadrecname" />';
        tblrow+='<input type="hidden" value="'+ui.item.leademail+'" name="send_leadrecemail" id="send_leadrecemail" />';
        tblrow+='<input type="hidden" value="'+ui.item.leadphone+'" name="send_leadrecphone" id="send_leadrecphone" />';
        tblrow+='<input type="hidden" value="'+buyer_name+'" name="send_seekername" id="send_seekername" />';
        tblrow+='<input type="hidden" value="'+buyer_email+'" name="send_seekeremail" id="send_seekeremail" />';
        tblrow+='<input type="hidden" value="'+buyer_no+'" name="send_seekerphone" id="send_seekerphone" />';
        tblrow+='<input type="hidden" value="'+req_id+'" name="send_seeker_reqid" id="send_seeker_reqid" />';
        $('#projecttable').html(tblrow);
    }
});
</script>
<script type="text/javascript">
$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
</script>
</body>
</html>
