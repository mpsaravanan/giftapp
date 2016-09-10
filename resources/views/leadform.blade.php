<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lead Form</title>
<link href="{{ asset('css/bootstrap.css') }}" type="text/css" rel="stylesheet" >
<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<style>
.ui-autocomplete {
     z-index: 9999 !important;
}
.btn {
    height:28px;
    font-size:11px;
}
.radio, .checkbox {
    margin-top: 6px!important;
}
</style>
</head>

<body>
<?php if (stripos($data->transactionType,"rent")!==false){ ?>
<div class="wrapper-add" style="background-color:#8ABCD0;">
<?php }
else{ ?>
<div class="wrapper-add">

<?php } ?>
    <div class="row">
    	<div class="col-lg-12">
            <div class="col-lg-3">
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-horizontal">
                            <div class="form-group">
                                
                                    <div class="col-sm-12">
                                        <p class="name">
                                        <img src="{{ asset('images/usericon.png') }}" class = "img-circle circle-img">
                                        <?php echo $data->userName; ?></p>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 left-line name-top">ID</label>
                                <div class="col-sm-10 right-line">
                                    <p class="form-control-static name-top name-top2"><?php echo $data->userId; ?></p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 left-line name-top ">Mobile #</label>
                                    <div class="col-sm-10 right-line">
                                         <p class="form-control-static name-top2"><?php echo $data->phone1; ?> <i class="glyphicon glyphicon-ok-sign icon-green"></i>
                                            <span><a href="#" class="btn btn-info btn-xs edit-btne" role="button">Edit</a></span>
                                         </p>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 left-line name-top ">Email ID</label>
                                    <div class="col-sm-10 right-line">
                                         <p class="form-control-static name-top2"><?php echo $data->emailId1; ?></p>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 left-line name-top ">Gender</label>
                                    <div class="col-sm-10 right-line">
                                         <input type="radio" <?php if ($data->gender == "M"){ ?>checked="checked" <?php } ?> value="M" name="gender"  /> &nbsp;Male &nbsp;&nbsp;&nbsp;
                                         <input type="radio" <?php if ($data->gender == "F"){ ?>checked="checked" <?php } ?>  value="F" name="gender"  /> &nbsp;Female &nbsp;&nbsp;&nbsp;
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 left-line name-top ">Date Of Birth</label>
                                    <div class="col-sm-10 right-line" >
                                        <input type="text" value="<?php echo $data->dateOfBirth; ?>" id="dateOfBirth" name="dateOfBirth" />
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 left-line name-top ">Profession</label>
                                    <div class="col-sm-10 right-line" >
                                    <select id="profession" name="profession">
                                        <option value="">Select</option>
                                        <option <?php if($data->profession=="NRI"){ ?>selected="selected"<?php } ?> value="NRI">NRI</option>
                                        <option <?php if($data->profession=="Relocator"){ ?>selected="selected"<?php } ?> value="Relocator">Relocator</option>
                                        <option <?php if($data->profession=="MNC"){ ?>selected="selected"<?php } ?> value="MNC">MNC</option>
                                        <option <?php if($data->profession=="Sr. Manager"){ ?>selected="selected"<?php } ?> value="Sr. Manager">Sr. Manager</option>
                                        <option <?php if($data->profession=="Housewife"){ ?>selected="selected"<?php } ?> value="Housewife">Housewife</option>
                                        <option <?php if($data->profession=="Govt"){ ?>selected="selected"<?php } ?> value="Govt">Government</option>
                                        <option <?php if($data->profession=="self employed"){ ?>selected="selected"<?php } ?> value="self employed">Self Employed</option>
                                    </select>
                                        
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 left-line name-top ">Posted By</label>
                                    <div class="col-sm-10 right-line">
                                         <input type="radio" <?php if($data->postedBy=="BROKER"){ ?> checked="checked" <?php } ?> value="BROKER" name="postedby"  /> &nbsp;Broker &nbsp;&nbsp;&nbsp;
                                         <input type="radio" <?php if($data->postedBy=="INDIVIDUAL"){ ?> checked="checked" <?php } ?> value="INDIVIDUAL" name="postedby"  /> &nbsp;Individual &nbsp;&nbsp;&nbsp;
                                         <input type="radio" <?php if($data->postedBy=="BUILDER"){ ?> checked="checked" <?php } ?> value="BUILDER" name="postedby"  /> &nbsp;Builder &nbsp;&nbsp;&nbsp;
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 left-line name-top ">Created Date</label>
                                    <div class="col-sm-10 right-line">
                                         <p class="form-control-static name-top2"><?php echo date('d-M-Y',($data->createdDate/1000)); ?></p>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 left-line name-top ">Follow up Count</label>
                                    <div class="col-sm-10 right-line">
                                         <p class="form-control-static name-top2">2</p>
                                    </div>
                            </div>
                        </div>
                    </div>       
                    <div class="col-md-12">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 left-line name-top">Lead Source Channel</label>
                            <div class="col-sm-10 right-line">
                                <p class="form-control-static name-top name-top2"><?php echo $data->channel; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 left-line name-top ">Campaign Channel</label>
                                <div class="col-sm-10 right-line">
                                    <p class="form-control-static name-top2"><?php echo $data->source1; ?></p>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 left-line name-top ">Mobile #</label>
                                <div class="col-sm-10 right-line">
                                     <p class="form-control-static name-top2">080-23452345</p>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 left-line name-top ">Toll Free</label>
                                <div class="col-sm-10 right-line">
                                     <p class="form-control-static name-top2">18008333300</p>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 left-line name-top ">Referal URL</label>
                                <div class="col-sm-10 right-line">
                                     <p class="form-control-static name-top2">www.quikr.com/homes</p>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 left-line name-top ">Intent Type</label>
                                <div class="col-sm-10 right-line">
                                     <p class="form-control-static name-top2">Like/Comment/Alert</p>
                                </div>
                        </div>
                    	 <div class="row">
		                  <div  class="col-lg-12"><iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d62187.52677173101!2d77.5985902114491!3d13.053459487288627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1squikr+bangalore!5e0!3m2!1sen!2sin!4v1449232905304" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe></div>
		                 </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
            	<div class="row">
            	<div class="col-lg-12">
                	
                    
                    
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                         <label for="inputEmail3">City &nbsp;</label>
                         <input type="text" disabled="disabled"  id="newcity" value="<?php echo $data->cityName; ?>" name="newcity" class="form-control" />
                         <input type="hidden"  id="cityid" value="" name="cityid" class="form-control" />
                        </div>
                        
                        <div class="col-lg-3 "> 
                        	<label for="inputEmail3">Locality</label>
                            <select id="localitySelect" style="width:400px;" class="form-control chosen" multiple="true">
                                <option>Choose the Location</option>
                                @if ($data->localities != "")
                                @foreach(explode(',',$data->localities) as $localities)
                                {{$localities}}
                                <option value="{{$localities}}" selected="selected">{{$localities}}</option>
                                @endforeach
                                @else
                                @endif 
                            </select>
                            
                        </div>

                        <div class="col-lg-12">
                        <div class="col-lg-4 m-top">
                            <label for="inputEmail3">Projects</label>
                            <select disabled="disabled" id="selectproject" style="width:300px;" class="form-control selectproject"  multiple="true">
                                <option>Choose the Project</option>-->
                                @if ($data->projects != "")
                                @foreach(explode(',',$data->projects) as $projects)
                                <option value="{{$projects}}" selected="selected">{{$projects}}</option>
                                @endforeach
                                @else
                                <option>Prestige</option>
                                @endif 
                               
                            </select>
                        </div>
                        
                        
                        <div class="col-lg-5 m-top type2" <?php if ($data->category != "Commercial"){ ?>style="display:block;"<?php } ?>>
                         <label for="inputEmail3">Bedroom Type</label>
                         <div class="checkbox radio-m"> 
                         <?php
                            $bhkvalarr= explode(',',$data->bhks);
                         ?>
                         <button type="button" <?php if (in_array('1', $bhkvalarr, true)){ ?>class="btn btn-success bhkbuttons" <?php } ?> value="1" class="btn btn-default bhkbuttons">1</button> 
                         <button type="button" <?php if (in_array('2', $bhkvalarr, true)){ ?>class="btn btn-success bhkbuttons" <?php } ?> value="2" class="btn btn-default bhkbuttons">2</button> 
                         <button type="button" <?php if (in_array('3', $bhkvalarr, true)){ ?>class="btn btn-success bhkbuttons" <?php } ?> value="3" class="btn btn-default bhkbuttons">3</button> 
                         <button type="button" <?php if (in_array('4', $bhkvalarr, true)){ ?>class="btn btn-success bhkbuttons" <?php } ?> value="4" class="btn btn-default bhkbuttons">4</button> 
                         <button type="button" <?php if (in_array('5', $bhkvalarr, true)){ ?>class="btn btn-success bhkbuttons" <?php } ?> value="5" class="btn btn-default bhkbuttons">5</button> 
                         </div>
                        </div>

                        <div class="col-lg-3 m-top">
                        	<label for="inputEmail3">Requirement</label>
                        	<p class="form-control-static name-top2">
                            <?php if ($data->bhks != ""){
                            foreach(explode(',',$data->bhks) as $bhks){
                            echo $bhks."/";
                                }
                            }
                            echo "BHK in $data->cityName"; 
                            ?>
                           </p>
                       		<!--<button type="button" class="btn btn-info btn-xs edit-btne">Edit</button>
                            <button type="button" class="btn btn-info btn-xs edit-btne">Create New</button>
                            <button type="button" class="btn btn-info btn-xs edit-btne">Delete</button>-->
                        </div>
                       
			         </div>

                        <div class="clearfix"></div>
                        
                    <div class="col-lg-12 radio-bg">
                        <span class=""><label>
                        &nbsp;&nbsp; Property For</label>
                        </span>
                        <div class="checkbox">
                        <label><input <?php if (stripos($data->transactionType,"buy")!==false){ ?>checked="checked"<?php } ?> class="bstype propfr1" onclick="checkTransactype('bstype');"  type="checkbox" name="transactiontype" value="buy" />Buy</label> &nbsp;  &nbsp;
                        <label><input <?php if (stripos($data->transactionType,"sale")!==false){ ?>checked="checked"<?php } ?> class="bstype propfr2" onclick="checkTransactype('bstype');"  type="checkbox" name="transactiontype" value="sale" />Sale</label> &nbsp;  &nbsp;
                        <label><input <?php if (stripos($data->transactionType,"rent")!==false && $data->transactionType!="rent_in"){ ?>checked="checked"<?php } ?> onclick="checkTransactype('renttype');" class="renttype propfr1"   type="checkbox" name="transactiontype" value="rent" />Rent</label> &nbsp;  &nbsp;
                        <label><input <?php if (stripos($data->transactionType,"rent_in")!==false){ ?>checked="checked"<?php } ?> class="renttype propfr2" onclick="checkTransactype('renttype');"  name="transactiontype" type="checkbox" value="rent_in" />Rent In</label> &nbsp;  &nbsp;
                        <label><input <?php if (stripos($data->transactionType,"pg")!==false && $data->transactionType!="pg_in"){ ?>checked="checked"<?php } ?> onclick="checkTransactype('pgtype');" class="pgtype propfr1"  name="transactiontype" type="checkbox" value="pg" />PG</label> &nbsp;  &nbsp;
                        <label><input <?php if (stripos($data->transactionType,"pg_in")!==false){ ?>checked="checked"<?php } ?> class="pgtype propfr2" onclick="checkTransactype('pgtype');"  name="transactiontype" type="checkbox" value="pg_in" />PG In</label> &nbsp;  &nbsp;
                        </div>
                    </div>
                        
                    <div class="col-lg-12 radio-bg">
                        <span class=""><label>
                        <input type="radio" name="propcategory" onclick="changeCategory();" value="Residential" <?php  if ($data->category == "Residential"){ ?>checked="checked"<?php } ?>  />&nbsp; Residential</label>
                        </span>
                        <div class="checkbox">
                        <label><input <?php if (stripos($data->propertyTypes,"Apartment")!==false){ ?>checked="checked"<?php } ?> class="aptprop"  type="checkbox" name="proptypes" value="Apartment" />Apartment</label> &nbsp;  &nbsp;
                        <label><input <?php if (stripos($data->propertyTypes,"BuilderFloor")!==false){ ?>checked="checked"<?php } ?> class="aptprop"  type="checkbox" name="proptypes" value="BuilderFloor" />BuilderFloor</label> &nbsp;  &nbsp;
                        <label><input <?php if (stripos($data->propertyTypes,"Villa")!==false){ ?>checked="checked"<?php } ?> class="aptprop"  type="checkbox" name="proptypes" value="Villa" />Villa</label> &nbsp;  &nbsp;
                        <label><input <?php if (stripos($data->propertyTypes,"plot")!==false && $data->category == "Residential"){ ?>checked="checked"<?php } ?> class="aptprop" name="proptypes" type="checkbox" value="Plot" />Residential plot</label> &nbsp;  &nbsp;
                        </div>
                    </div>
                    
                    <div class="col-lg-12 radio-bg">
                    <span class="">
                    <label><input type="radio" name="propcategory" onclick="changeCategory();" value="Commercial" <?php  if ($data->category == "Commercial"){ ?>checked="checked"<?php } ?>  />&nbsp; Commercial</label>
                    </span>
                    <div class="checkbox">
                        <label><input <?php if (stripos($data->propertyTypes,"Shop")!==false){ ?>checked="checked"<?php } ?> class="commprop" type="checkbox" name="proptypes" value="Shop" />Retail Shop/ Showroom</label> &nbsp;  &nbsp;
                        <label><input <?php if (stripos($data->propertyTypes,"Complex")!==false){ ?>checked="checked"<?php } ?> class="commprop" type="checkbox" name="proptypes" value="Complex" />Complex</label> &nbsp;  &nbsp;
                        <label><input <?php if (stripos($data->propertyTypes,"Office")!==false){ ?>checked="checked"<?php } ?> class="commprop" type="checkbox" name="proptypes" value="Office" />Office</label> &nbsp;  &nbsp;
                        <label><input <?php if (stripos($data->propertyTypes,"plot")!==false && $data->category == "Commercial"){ ?>checked="checked"<?php } ?> class="commprop"  name="proptypes" type="checkbox" value="Plot" />Commercial plot</label> &nbsp;  &nbsp;
                    </div>
                    </div>
                    
                    <div class="col-lg-12 radio-bg">
                    <span class="">
                    <label><input type="radio" name="propcategory" onclick="changeCategory();" value="Agriculture" <?php  if ($data->category == "Agriculture"){ ?>checked="checked"<?php } ?>  />&nbsp; Agriculture</label>
                    </span>
                    <div class="checkbox">
                        <label><input <?php if (stripos($data->propertyTypes,"Land")!==false){ ?>checked="checked"<?php } ?>  class="agriprop"  type="checkbox" name="proptypes" value="Land" />Agriculture Land</label> &nbsp;  &nbsp;
                    </div>
                    </div>
                       
                        
                        <div class="col-lg-5 m-top">
                        	<div class="col-lg-12">
                        		<label for="inputEmail3">Plot Area Range (Sq. Feet) &nbsp;</label>
                            </div>

                            <div class="col-lg-3 form-small">
                                 <input name="areamin" id="areamin" type="text" id="minAreadata" value="<?php echo $data->areaMin; ?>" class="form-control" />
                            </div>
                            
                            <div class="col-lg-3 form-small">
                                <input name="areamax" id="areamax" type="text" value="<?php echo $data->areaMax; ?>" class="form-control" />
                            </div>
                            <div class="col-lg-3 form-small-both">
                            	<select id="exampleSelect1" class="form-control">
                                <option>Sq.Feet</option>
                                <!--<option>Sq.Yards</option>
                                <option>Sq.Meters</option>
                                <option>Acres</option>
                                <option>Hectares</option>
                                <option>Grounds</option>
                                <option>Cents</option>-->
                                </select>
                            </div>
                           

                        </div>
                        <div class="col-lg-5 m-top">
                        	<div class="col-lg-12">
                        		<label for="inputEmail3">Budget Range  &nbsp;</label>
                            </div>
                            
                            <div class="col-lg-3 form-small">
                                <input type="text" name="pricemin" id="pricemin" value="<?php echo $data->priceMin; ?>" class="form-control" />
                            </div>
                            
                            <div class="col-lg-3 form-small">
                                <input type="text" name="pricemax" id="pricemax" value="<?php echo $data->priceMax; ?>" class="form-control" />
                            </div>
                            <div class="col-lg-3 form-small-both">
                            	
                            </div>
                        </div>
                        
                       
                        <div class="clearfix"></div>
                        <div class="col-lg-12 m-top radio-bg">
                        	<span class="resdi"><label>
                            Construction Phase  
                            </label></span>
                                <div class="checkbox">
                                	<label><input <?php if(stripos($data->constructionPhases,"NEW_LAUNCH")!==false){ ?> checked="checked" <?php } ?> name="constructionphases" class="consph"  type="checkbox" value="NEW_LAUNCH">New Launch</label> &nbsp;  &nbsp;
                                    <label><input <?php if(stripos($data->constructionPhases,"READY_TO_MOVE_IN")!==false){ ?> checked="checked" <?php } ?> name="constructionphases" class="consph"  type="checkbox" value="READY_TO_MOVE_IN">Redy to Move</label> &nbsp;  &nbsp;
                                    <label><input <?php if(stripos($data->constructionPhases,"UNDER_CONSTRUCTION")!==false){ ?> checked="checked" <?php } ?> name="constructionphases" class="consph"  type="checkbox" value="UNDER_CONSTRUCTION">Under Construction</label> &nbsp;  &nbsp;
                                </div>
                        </div>
                        <div class="col-lg-12 radio-bg">
                        	<span class="resdi"><label>
                           Furnishing 
                            </label>
                            </span>
                            <div style="overflow-x: scroll ! important; width: auto; height: 54px; overflow-y: hidden;display:inherit;">
                               <div class="checkbox" style="width:1500px">
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
                        </div>
                        <div class="col-lg-12 radio-bg">
                        	<span class="resdi"><label>
                            Amenities 
                            </label>
                            </span>
                            <div style="overflow-x: scroll ! important; width: auto; height: 54px; overflow-y: hidden;display:inherit;">
                            <div class="checkbox" style="width:3300px">
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
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="col-lg-3">
                                <span class="resdi"><label>
                                <?php if ($data->bathrooms != ""){ ?>
                                Bathrooms 
                                </label>
                                </span>
                                    <div class="checkbox">
                                        <label>
                                        <?php 
                                        foreach(explode(',',$data->bathrooms) as $bathrooms){
                                        if(trim($bathrooms)!=''){
                                        ?>
                                        <span style="padding:5px;background-color:white;border:1px solid grey"> <?php echo $bathrooms; ?></span>
                                        <?php }
                                        }
                                        ?>
                                        </label>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-lg-3">
                                <span class="resdi"><label>
                                <?php if ($data->balconies != ""){ ?>
                                Balconies 
                                </label>
                                </span>
                                    <div class="checkbox">
                                        <label>
                                        <?php 
                                        foreach(explode(',',$data->balconies) as $balconies){
                                        if(trim($balconies)!=''){
                                        ?>
                                        <span style="padding:5px;background-color:white;border:1px solid grey"> <?php echo $balconies; ?></span>
                                        <?php }
                                        }
                                        ?>
                                        </label>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-lg-3">
                                <span class=""><label>
                                Payment Option 
                                </label>
                                </span>
                                    <div class="checkbox">
                                        <select id="paymentOption" name="paymentOption" class="form-control ">
                                        <option value="">Select</option>
                                        <option <?php if ($data->paymentOption=="PARTIAL_LOAN"){ ?>selected="selected"<?php } ?> value="PARTIAL_LOAN">PARTIAL LOAN</option>
                                        <option <?php if ($data->paymentOption=="SELF_FUNDING"){ ?>selected="selected"<?php } ?> value="SELF_FUNDING">SELF FUNDING</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-lg-3">
                                <span class="resdi"><label>
                                Load Requirement
                                </label>
                                </span>
                                    <div class="checkbox">
                                        <select id="loanrequirement" name="loanrequirement" class="form-control ">
                                        <option value="">Select</option>
                                        <option <?php if ($data->loanRequirement=="YES"){ ?>selected="selected"<?php } ?> value="YES">YES</option>
                                        <option <?php if ($data->loanRequirement=="NO"){ ?>selected="selected"<?php } ?> value="NO">NO</option>
                                        </select>
                                    </div>
                            </div>
                            
                          </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="col-lg-2">
                                <span class="resdi"><label>
                                Purpose
                                </label>
                                </span>
                                    <div class="checkbox">
                                        <select id="purpose" name="purpose" class="form-control ">
                                        <option value="">Select</option>
                                        <option <?php if ($data->purpose=="self use"){ ?>selected="selected"<?php } ?> value="self use">Self use</option>
                                        <option <?php if ($data->purpose=="investment"){ ?>selected="selected"<?php } ?> value="investment">Investment</option>
                                        <option <?php if ($data->purpose=="both"){ ?>selected="selected"<?php } ?> value="both">Both</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-lg-2">
                                <span class=""><label>
                                Down Payment
                                </label>
                                </span>
                                    <div class="checkbox">
                                        <input type="text" class="form-control" value="<?php echo $data->downPayment;  ?>" id="downpayment" name="downpayment" />
                                    </div>
                            </div>
                            <div class="col-lg-2">
                                <span class=""><label>
                                Min Floor Range
                                </label>
                                </span>
                                    <div class="checkbox">
                                        <input type="number" min="0" class="form-control" value="<?php echo $data->minFloorRange; ?>" id="minFloorRange" name="minFloorRange" />
                                    </div>
                            </div>
                            <div class="col-lg-2">
                                <span class=""><label>
                                Max Floor Range
                                </label>
                                </span>
                                    <div class="checkbox">
                                        <input type="number" min="0" class="form-control" value="<?php echo $data->maxFloorRange;  ?>" id="maxFloorRange" name="maxFloorRange" />
                                    </div>
                            </div>
                            
                            <div class="col-lg-2">
                                <span class=""><label>Urgency</label></span>
                                 <div class="checkbox">
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
                                 </div>
                        </div>
                        <div class="col-lg-2">
                                <span class=""><label>Remarks</label></span>
                                 <div class="checkbox">
                                    <input type="text" name="remarksByUser" id="remarksByUser" placeholder="Remarks" value="<?php if ($data->remarks != ""){ echo $data->remarks; } ?>" class="form-control" />
                                </div>
                        </div>
                       </div>
                    </div>
                            
                       

                        <div class="col-lg-6 m-top">
                    	<label for="inputEmail3">Facings&nbsp;</label>
                        <?php  $facingsarr= explode(',',$data->facings);   ?>
                         <button type="button" <?php if (in_array('Pool', $facingsarr, true)){ ?>class="btn btn-success facingbuttons" <?php } ?> value="Pool" class="btn btn-default facingbuttons">Pool</button> 
                         <button type="button" <?php if (in_array('Garden', $facingsarr, true)){ ?>class="btn btn-success facingbuttons" <?php } ?> value="Garden" class="btn btn-default facingbuttons">Garden</button> 
                         <button type="button" <?php if (in_array('Lake', $facingsarr, true)){ ?>class="btn btn-success facingbuttons" <?php } ?> value="Lake" class="btn btn-default facingbuttons">Lake</button> 
                         <button type="button" <?php if (in_array('Road', $facingsarr, true)){ ?>class="btn btn-success facingbuttons" <?php } ?> value="Road" class="btn btn-default facingbuttons">Road</button>
                        </div>
                        
                        <div class="col-lg-6 m-top">
                    	<label for="inputEmail3">Directions&nbsp;</label>
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
                    <div class="col-lg-12"></div>
                    <div class="col-lg-12"></div>
            <div class="col-lg-12">
            <div class="row">
            <div class="col-lg-12">
            <div class="table-bg-part">
            <div class="table-responsive scroll" >
            
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Contacted Date</th>
                    <th>Contacted Time</th>
                    <th>Mobile</th>
                    <th>Call Disposition</th>
                    <th>TC Name</th>
                    <th>TC Mail ID</th>
                    <th>TC Emp ID</th>
                    <th>Remarks</th>
                   
                    
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2 Nov 15</td>
                    <td>05:00 PM</td>
                    <td>+91 9899673878</td>
                    <td>Call back leter</td>
                    <td>Rajiv</td>
                    <td>raj@quikr.com</td>
                    <td>123</td>
                    <td>Client's requirement confirmed and given options.
                    
                  </tr>
                  </tbody>
              </table>
              
                    
                    </div>
                    </div>
                </div>
                    </div>
                     </div>

                        <div class="col-lg-12 mar-top-10">
                            <input type="hidden" value="<?php echo $data->version; ?>" name="version" id="version" />
                            <input type="hidden" value="<?php echo $data->userId; ?>" name="userid" id="userid" />
                            <input type="hidden" value="<?php echo $data->userName; ?>" name="username" id="username" />
                            <input type="hidden" value="<?php echo $data->phone1; ?>" name="phone1" id="phone1" />
                            <input type="hidden" value="<?php echo $data->emailId1; ?>" name="emailId1" id="emailId1" />

                            <button type="button" onclick="updateRequirement(<?php echo $data->id; ?>);" class="btn btn-primary pull-right">Update</button>
                            <span  class="advance-search">+ Advance Search</span>
                        </div>
                        
                    </div>
                </div>
                
            </div>
    	</div>
    </div>
</div>
 



    <!--<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>


    <script type="text/javascript" src="{{ asset('js/chosen.jquery.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/chosen_multiselect.css') }}">
    <script type="text/javascript">
    $(document).ready(function(){
                $("#localitySelect").data("placeholder","Select Locations...").chosen();

                $("#selectproject").data("placeholder","Select Projects...").chosen();
            });
    </script>
    <style type="text/css">
    .radio-bg-2{margin-bottom: 20px;}
    </style>
        
        <script type="text/javascript">
        function changeCategory()
        {
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
        function checkTransactype(elem)
        {
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
        function updateRequirement(elem){
            var req_id=elem;
            var version=$("#version").val();
            var userid=$("#userid").val();
            var username=$("#username").val();
            var phone1=$("#phone1").val();
            var emailId1=$("#emailId1").val();
            var gender=$("[name='gender']:checked").val();
            var profession=$("#profession").val();
            var dateOfBirth=$("#dateOfBirth").val();
            var purpose=$("#purpose").val();
            
            var cityid=$("#cityid").val();
            
            var getCallsBack="no";
            var verifiedMethod="yes";
            var totalFollowUps=2;
            
            var postedby=$("[name='postedby']:checked").val();
            var category=$("[name='propcategory']:checked").val();

            //agriprop commprop aptprop
            if(category=="Residential"){
                var proptypes = $('input:checkbox:checked.aptprop').map(function () {
                  return this.value;
                }).get();
                if(proptypes.length<1)
                {
                    alert("Please select Property Type");
                    return false;
                }
                else
                {
                  var propertyTypes = proptypes.join(","); 
                }
                
            }
            else if(category=="Commercial"){
                var proptypes = $('input:checkbox:checked.commprop').map(function () {
                  return this.value;
                }).get();
                if(proptypes.length<1)
                {
                    alert("Please select Property Type");
                    return false;
                } 
                else
                {
                  var propertyTypes = proptypes.join(","); 
                }               
            }
            else if(category=="Agriculture"){
                var proptypes = $('input:checkbox:checked.agriprop').map(function () {
                  return this.value;
                }).get();
                if(proptypes.length<1)
                {
                    alert("Please select Property Type");
                    return false;
                }   
                else
                {
                  var propertyTypes = proptypes.join(","); 
                }
            }
            
            var propertyfor1="";
            var propfor1 = $('input:checkbox:checked.propfr1').map(function () {
                  return this.value;
                }).get();
                if(propfor1.length>=1)
                {
                    propertyfor1=propfor1.join(","); 
                }
            var propertyfor2="";
            var propfor2 = $('input:checkbox:checked.propfr2').map(function () {
                  return this.value;
                }).get();
                if(propfor2.length>=1)
                {
                    propertyfor2=propfor2.join(","); 
                }
            //console.log(propertyfor2+" "+propertyfor1);
            
              var bhkarraynew=[];
              var bhksval="";
              var bhkarray = $('.btn-success.bhkbuttons').map(function(){
                return this.value;
                });
                bhkarraynew=jQuery.makeArray(bhkarray);
                if(bhkarraynew.length>=1)
                {
                  bhksval = bhkarraynew.join(","); 
                } 
                                
                var dirarraynew=[];
                var directions="";
                var dirarray = $('.btn-success.dirbuttons').map(function(){
                return this.value;
                });
                dirarraynew=jQuery.makeArray(dirarray);
                if(dirarraynew.length>=1)
                {
                   directions = dirarraynew.join(","); 
                } 
                
                
                var facingarraynew=[];
                var facings="";
                var facarray = $('.btn-success.facingbuttons').map(function(){
                return this.value;
                });
                facingarraynew=jQuery.makeArray(facarray);
                if(facingarraynew.length>=1)
                {
                  facings = facingarraynew.join(","); 
                } 
                
                var furnishingnew=[];
                var furnishing="";
                var furarray = $('.btn-success.furnishingbuttons').map(function(){
                return this.value;
                });
                furnishingnew=jQuery.makeArray(furarray);
                if(furnishingnew.length>=1)
                {
                  furnishing = furnishingnew.join(","); 
                }
                
                var amenitiesnew=[];
                var amenities="";
                var amenarray = $('.btn-success.amenitiesbuttons').map(function(){
                return this.value;
                });
                amenitiesnew=jQuery.makeArray(amenarray);
                if(amenitiesnew.length>=1)
                {
                  amenities = amenitiesnew.join(","); 
                }
                //console.log(amenities);
                
            var constructionPhases="";
            var constructionph = $('input:checkbox:checked.consph').map(function () {
                return this.value;
                }).get();
                if(constructionph.length>=1)
                {
                   constructionPhases = constructionph.join(","); 
                }   
            var loanRequirement=$("#loanrequirement").val();  
            var paymentOption=$("#paymentOption").val(); 
            
            var areaMin=$("#areamin").val();
            var areaMax=$("#areamax").val();
            var priceMin=$("#pricemin").val();
            var priceMax=$("#pricemax").val();
            var remarksByUser=$("#remarksByUser").val();
            var downPayment=$("#downpayment").val();
            var urgency=$("#urgency").val();
            var minFloorRange=$("#minFloorRange").val();
            var maxFloorRange=$("#maxFloorRange").val();
            var callDisposition="call me later";
            var tcEmpId="cz123";
            var projectIds = '1001,1002';
            var localityIds= "880,881";
            var postData={
            req_id:req_id, version:version, userId:userid, phone1:phone1, emailId1:emailId1, gender:gender, profession:profession, 
            dateOfBirth:dateOfBirth, purpose:purpose, cityId:cityid, getCallsBack:getCallsBack, verifiedMethod:verifiedMethod, 
            totalFollowUps:totalFollowUps,postedBy:postedby, category:category, propertyTypes:propertyTypes, loanRequirement:loanRequirement, 
            paymentOption:paymentOption, areaMin:areaMin, areaMax:areaMax, priceMin:priceMin, priceMax:priceMax, remarksByUser:remarksByUser, 
            downPayment:downPayment, urgency:urgency, minFloorRange:minFloorRange, maxFloorRange:maxFloorRange, callDisposition:callDisposition,
            tcEmpId:tcEmpId, projectIds:projectIds, localityIds:localityIds, amenities, constructionPhases:constructionPhases, 
            furnishings:furnishing, facings:facings, propertyFor1:propertyfor1, propertyFor2:propertyfor2, directions:directions, bhks:bhksval
            };
            
            $.ajax({
                url: "/Leadformupdate/",
                type:"POST",
                dataType: "json",
                data:postData,
                success: function(response) {
                    
                  }
                });
            

        }

        $(document).ready(function(){    
            $('#dateOfBirth').datetimepicker();
            $(".bhkbuttons").click(function(e)
            {
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            $(".facingbuttons").click(function(e)
            {
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            $(".furnishingbuttons").click(function(e)
            {
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            $(".dirbuttons").click(function(e)
            {
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            $(".amenitiesbuttons").click(function(e)
            {
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            $(".discussedval").click(function(e)
            {
                $(this).toggleClass("btn-default btn-success"); //you can list several class names 
                e.preventDefault();
            });
            
            $.ajax({
                url: "/Leadformdetails/city/<?php echo $data->cityName ?>",
                dataType: "json",
                success: function(data) {
                    $('#cityid').val(data);
                  }
                });
            });
        </script>
    </body>
</html>
