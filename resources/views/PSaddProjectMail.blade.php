
<p>Dear <?php echo $buyer_name; ?>,</p>

<p>Greetings from Quikr.com
It was a pleasure speaking to you again, and we are delighted to have you as a member of Quikr Family.</p>

<p>As per our discussion, I am hereby sending you the project details of, <strong>
<?php foreach ($project as $proName) {
	echo $proName.",";
}  ?></strong> and arrange for a hassle free site visit without any brokerage charges after you confirm the project.<p>

<?php 
for($j=0;$j<count($project);$j++){ 
$qkr_plink=prop_generate_url($project[$j],$city[$j],$loc[$j],$qkr_pid[$j]);
   ?>
<div style="border:solid 1px #000;padding:5px;">
<p><a href="http://www.quikr.com/homes/project/<?php echo $qkr_plink;?>"><?php echo $project[$j]; ?></a></p>
<p>Contact Builder personal directly at <br>
Lead Receiver Name: <?php if($lead_rec_name[$j]!='null'){ echo $lead_rec_name[$j]; } else{ echo "N/A";} ?><br>
Lead Receiver Mail: <?php if($lead_rec_mail[$j]!='null'){ echo $lead_rec_mail[$j]; } else{ echo "N/A";} ?><br>
Lead Receiver Mobile: <?php if($lead_rec_no[$j]!='null'){ echo $lead_rec_no[$j]; } else{ echo "N/A";} ?></p></div><br><br><div style="clear:both;"></div>
 <?php }  ?>
<p>For any further requirement to buy or sell we are just a click/call away and your requirement will be fulfilled, below the array of services you could avail from Quikr, www.quikr.com as we are one stop solutions to our customers/partners/family member for anything and everything! </p>

<p>Have a Quikr Day!!!</p>
 
<p>Thanks and regards</p>
<p>QuikrHomes</p>

<?php

 function prop_generate_url($project_name_ex,$city_name_ex,$loc_name_ex,$propmastid)
 {
  $project_name_ex = strtolower($project_name_ex);
  $project_name_ex = str_replace('/', 'slashhh', $project_name_ex);
  $project_name_ex = str_replace('@', 'attt', $project_name_ex);
  $project_name_ex = str_replace('&', 'amppp', $project_name_ex);
  $project_name_ex = str_replace("'", 'singlequote', $project_name_ex);
  $project_name_ex = str_replace("(", 'openbrace', $project_name_ex);
  $project_name_ex = str_replace(")", 'closedbrace', $project_name_ex);
  $project_name_ex = str_replace(",", 'commaaa', $project_name_ex);
  $project_name_ex = str_replace('-', '_', $project_name_ex);
  $project_name_ex = str_replace(' ', '-', $project_name_ex);
      
        
  $city_name_ex = strtolower($city_name_ex);
  $city_name_ex = str_replace(' ', '-', $city_name_ex);

  $loc_name_ex = strtolower($loc_name_ex);
  $loc_name_ex = str_replace(' ', '-', $loc_name_ex);
  
  $final_url_ex = $project_name_ex."+".$loc_name_ex."+".$city_name_ex."+".$propmastid;
  $final_url_ex = str_replace('---', '-', $final_url_ex);
  $final_url_ex = str_replace('--', '-', $final_url_ex);
  
  
  if(!empty($final_url_ex)){ return $final_url_ex; }
  
 }
?>