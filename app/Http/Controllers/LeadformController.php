<?php
namespace App\Http\Controllers;

use Request;
//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;

use DB;
use Mail;
class LeadformController extends Controller
{
    public function __construct(){
        $this->apiModel = new Api();
    }
    public function show($id){
	   $result=$this->apiModel->getRequirement($id);
       $result1=$result['response'];
       $result2=json_decode($result1);
       return view('lead', array('data' => $result2->data));
    }
    public function leadformReq($id){
      
	   $result=$this->apiModel->getRequirement($id);
       $result1=$result['response'];
       $result2=json_decode($result1);
       return view('reqlead', array('data' => $result2->data));
    }
    public function update(){
      
       session_start();
       $data=json_encode($_POST);
       $result=$this->apiModel->updateRequirement($data);
       $autoQry=DB::connection('mysql_master')->Select("SELECT id,xpora_req_id,telecaller_id,call_uuid,legA_hcause,legB_hcause ,caller_no,timestamp,call_mode FROM `re2_agent_call_cdr` where xpora_req_id='".$_POST['req_id']."' order by id desc");
       if(count($autoQry)>=1){
            $req_id=$autoQry[0]->xpora_req_id;
            $call_uuid=$autoQry[0]->call_uuid;
            $phone_no=$autoQry[0]->caller_no;
            $cause_codeA=$autoQry[0]->legA_hcause;
            $cause_codeB=$autoQry[0]->legB_hcause;
            $telecallerid=$autoQry[0]->telecaller_id;
            $_mongo1=new MongoController();
            $_lead_update=$_mongo1->updateCallReqDetail($call_uuid,$req_id);
            $_add_calldisposition=$this->addCallDisposition($call_uuid,$req_id,$telecallerid,$_POST['callDisposition']);
            if($cause_codeA=='SERVICE_UNAVAILABLE' || $cause_codeA=='UNALLOCATED_NUMBER' || $cause_codeA=='INVALID_NUMBER_FORMAT' || $cause_codeA=='DESTINATION_OUT_OF_ORDER' || $cause_codeB=='SERVICE_UNAVAILABLE' || $cause_codeB=='UNALLOCATED_NUMBER' || $cause_codeB=='INVALID_NUMBER_FORMAT' || $cause_codeB=='DESTINATION_OUT_OF_ORDER'){
                $agent_ad=DB::connection('mysql_master')->update("update re2_agent_ad_detail set req_status='2', assign_status='2' where req_id='$req_id' and phone_no='$phone_no'");
            }
            else{
                $updatesreq= DB::connection('mysql_master')->update("update re2_agent_ad_detail set req_status='1' where req_id='".$_POST['req_id']."'");
            }
       }
       else{
          $updatesreq= DB::connection('mysql_master')->update("update re2_agent_ad_detail set req_status='1' where req_id='".$_POST['req_id']."'");
       }
       if($_POST['callDisposition']!="RIGHT_PARTY_INT_RD"){
           if($_POST['callDisposition']=="CALL_BACK_AT" || $_POST['callDisposition']=="NON_CONT_RINGING_NO_RESPONSE" || $_POST['callDisposition']=="NON_CONT_BUSY_OR_WAITING" || $_POST['callDisposition']=="RINGING_NO_RESPONSE_CALLBACK_AT"){
              $adagentDetails=DB::connection('mysql_master')->Select("Select req_id from re2_agent_ad_detail where req_id='".$_POST['req_id']."'");
              if(count($adagentDetails)==1){
                $delQry=DB::connection('mysql_master')->delete("Delete from re2_agent_ad_detail where req_id='".$_POST['req_id']."'");
              }
            }
            $resp['call_status'] = $_POST['callDisposition']; 
            $resp['status'] = $result['status'];
            $resp['version'] = $_POST['version']+1;
       }
       else{
            $resp['call_status'] = $_POST['callDisposition']; 
            $resp['status'] = $result['status'];
            $resp['version'] = $_POST['version']+1;
       }
       //Push It to Rabbit MQ..
       $push_to_queue=new QueueController();
       $push=$push_to_queue->postCallCaseQueue($_POST['req_id']);
       //$call_case=$this->callcaseCheckaftrCall($_POST['req_id']);
       header('Content-type: application/json');
       echo json_encode($resp);
       //echo ($result['status']);
    }
    public function addCallDisposition($uuid,$reqid,$agentid,$disposition){
        $adagentDetails=DB::connection('mysql_master')->Select("Select id from re2_agent_call_disposition where cdr_call_uuid='".$uuid."'");
        if(count($adagentDetails)>=1){
            $updates_call_disposition= DB::connection('mysql_master')->update("update re2_agent_call_disposition set call_disposition='".$disposition."' where cdr_call_uuid='".$uuid."'");
        }
        else{
            $insert_call_disposition= DB::connection('mysql_master')->insert("insert into re2_agent_call_disposition(cdr_call_uuid,cdr_req_id,cdr_agent_id,call_disposition,added_datetime) values('".$uuid."','$reqid','$agentid','".$disposition."',NOW())");
        }
    }
    public function changeStatusAfterupdate(){
        session_start();
        $updatesip= DB::connection('mysql_master')->update("update re2_agent_active set status='0',manual_call_status='0',pick_call_status='0' where agent_id='".$_SESSION['userid']."'");
        $_mongo2=new MongoController();
        $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid']);
        $resp['status'] = "Successfully Updated call Status";
        header('Content-type: application/json');
        echo json_encode($resp);
    }
    public function getcityval(){
        $_city = Request::all();
        $cityname=$_city['cityname'];
        $result=$this->apiModel->getCity();
        $result1=$result['response'];
        $result2=json_decode($result1);
        $firstcity=$result2->topCities;
        $secondcity=$result2->allCities;
        $finalarray=array_merge($firstcity,$secondcity);
        foreach($finalarray as $key=>$val){
            if($val->name==$cityname){
                echo $val->id;
            }
        }
    }
    public function cityBaselocations(){
      
       $_city = Request::all();
       $cityid=$_city['cityid'];
       $locs = DB::connection('mysql_slave')->select("select id,name,latitude,longitude from re2_locations where city_id='$cityid'");
       $result2=json_encode($locs);
       echo $result2;
    }
    public function cityBaseprojects(){
      
       $_city = Request::all();
       $cityid=$_city['cityid'];
       $projects = DB::connection('mysql_slave')->select("select id,name from re2_projects where city_id='$cityid'");
       $result2=json_encode($projects);
       echo $result2;
    }
    public function projectDetails(){
      
        $_projects = Request::all();
        $_projectsarray=explode(",",$_projects['projectval']);
        $projectdetails=array();
        $_projectarray=array();
        foreach($_projectsarray as $projectid){
            $result=$this->apiModel->getProjectdetails($projectid);
            $result1=$result['response'];
            $finalres=json_decode($result1);
            //Company Name	Builder Name	Project Name	Amenities	Budget
            if($finalres->statusCode==200){
                $_units=$finalres->data->projectSnippet->projectUnits;
                if(count($_units)>=1){
                    for($i=0;$i<count($_units);$i++){
                        $_projectId=$finalres->data->projectSnippet->id;
                        $_projectname=$finalres->data->projectSnippet->name;
                        $_buildername=$finalres->data->projectSnippet->builder->name;
                        $_budget=$finalres->data->projectSnippet->priceRange->low." - ".$finalres->data->projectSnippet->priceRange->high;
                        $_location=$finalres->data->projectSnippet->address->locality;
                        $_city=$finalres->data->projectSnippet->address->city;
                        
                        //$_amenities=implode(",",$finalres->data->projectSnippet->amenities->amenities);
                        $projectdetails['project_id']=$_projectId;
                        $projectdetails['projectname']=$_projectname;
                        $projectdetails['buildername']=$_buildername;
                        $projectdetails['budget']=$_budget;
                        $projectdetails['bhk']=$_units[$i]->type;
                        $projectdetails['area']=$_units[$i]->superArea;
                        $projectdetails['pricesqft']="-";
                        $projectdetails['city']=$_city;
                        $projectdetails['location']=$_location;
                        $_projectarray[]=$projectdetails;
                    }
                }
                else{
                    $projectdetails['project_id']=$_projectId;
                    $projectdetails['projectname']=$_projectname;
                    $projectdetails['buildername']=$_buildername;
                    $projectdetails['budget']=$_budget;
                    $projectdetails['bhk']="-";
                    $projectdetails['area']="-";
                    $projectdetails['pricesqft']="-";
                    $projectdetails['city']=$_city;
                    $projectdetails['location']=$_location;
                    $_projectarray[]=$projectdetails;
                }
            }
        }
        echo json_encode($_projectarray);
    }
    public function matchMakingdetails(){
      
       $id=Request::all();
       $req_id=$id['req_id'];
       $result=$this->apiModel->matchMakingAPi($req_id);
       $result1=$result['response'];
       $result2=json_decode($result1);
        if($result2->statusCode=='200'){
          echo json_encode($result2->data);
        }
        else{
          $resp['status']="failed";
          echo json_encode($result2);
        }
    }
    public function sendAll(){
      
      session_start();
      if(!empty($_POST['action'])){
        $arrVal=json_decode($_POST['value']);
        $rec_date=date('Y-m-d');
        $received_date=date("l jS \of F Y ",strtotime($rec_date));
        $recei_date=date('Y-m-d', strtotime($rec_date. ' + 3 days'));
        $report_date=date("l jS \of F Y",strtotime($recei_date));
        $req_ids=$_POST['req_id'];
        $buyer_mail=$_POST['buyer_email'];
        $buyer_name=$_POST['buyer_name'];
        $buyer_no=$_POST['buyer_no'];
        foreach ($arrVal as $val) {
          $builder[]=$val->builder;
          $project[]=$val->project;
          $projectid[]=$val->project_id;
          $locs[]=$val->loc;
          $rec_mails[]=$val->rec_mail;
          $rec_names[]=$val->rec_name;
          $rec_nos[]=$val->rec_no;
          if($val->rec_mail!='null'){
          $rec_mail1[]=$val->rec_mail;
          }
          if($val->rec_name!='null'){
          $rec_name1[]=$val->rec_name;
          }
          if($val->rec_no!='null'){
          $rec_no1[]=$val->rec_no;
          }
          $citys[]=$val->city;

          $project_det=$val->r_pro_details;
          $n=explode(',', $project_det);
          $bhk=array();
          $area=array();
          $budget=array();
          for($a=0;$a<count($n);$a++){
            $m=$n[$a];
            $p=explode('-', $m);
            $bhk[]=$p[0];
            $area[]=$p[1];
            $budget[]=$p[2];
          }
          $rbhk=implode(',',$bhk);
          $rarea=implode(',',$area);
          $rbudget=implode(',',$budget);
          //Seller SMS
          if($val->rec_no!='null' && !empty($val->rec_no) && !empty($buyer_name) && !empty($buyer_no)){
            $seller_content="Dear $val->rec_name,
  $buyer_name,$buyer_no for investing in $rbhk, $val->project, $val->loc.
  Call now! Or check E-Mail for details, Quikr Homes";
  
            $seller_res=$this->apiModel->SMSAPI($val->rec_no,$seller_content);
            $s_res1=$seller_res['response'];
            $s_res2=json_decode($s_res1);
          }
            if($val->rec_mail!='null' && !empty($val->rec_mail)){
              $rec_mail=$val->rec_mail;
              $rec_name=$val->rec_name;
              $data_val=array('lead_receiver'=>$rec_name, 'lead_receiver_email'=>$rec_mail,'rece_mail'=>$buyer_mail,'receiver_name'=>$buyer_name,'rec_no'=>$buyer_no,'city'=>$val->city,'loc'=>$val->loc,'r_price'=>$rbudget,'project'=>$val->project,'r_bhk'=>$rbhk,'rec_date'=>$received_date,'report_date'=>$report_date,'agent_name'=>$_SESSION['username']);
              Mail::send('matchingSellerLeadMail',$data_val,function( $message ) use ($data_val)
                {
                  $message->bcc('venkatesh.madhu@quikr.co.in','Venkatesh')->subject('New Lead, Quikr Homes');
                  $message->to($data_val['lead_receiver_email'], $data_val['lead_receiver'])->subject('New Lead, Quikr Homes');
                });
              $resp['status'] = 'success'; 
              $resp['message'] = 'Email Send Sucessfully. Check your Mail'; 
              $res_seller=DB::connection('mysql_master')->Select("select req_id,project_id,project,builder from re2_agent_matchmaking_email_status where req_id='".$req_ids."' and project_id='".$val->project_id."'");
                  if(count($res_seller)==0){
                    $seller=DB::connection('mysql_master')->Insert("insert into re2_agent_matchmaking_email_status (req_id,agent_id,project_id,project,builder,seller_name,seller_email_id,seller_phn_no,seeker_name,seeker_email_id,seeker_phn_no,seller_mail_status,created_date) values('".$req_ids."','".$_SESSION['userid']."','".$val->project_id."','".$val->project."','".$val->builder."','".$val->rec_name."','".$val->rec_mail."','".$val->rec_no."','".$buyer_name."','".$buyer_mail."','".$buyer_no."','".$resp['status']."',NOW())");
                  }
                  else{
                    $seller=DB::connection('mysql_master')->Update("update re2_agent_matchmaking_email_status set seller_mail_status='".$resp['status']."',created_date=NOW() where req_id='".$res_seller[0]->req_id."' and project_id='".$res_seller[0]->project_id."'");
                  }
            }
        }
        foreach ($project as $proName) {
          $result=DB::connection('mysql_master')->Select("Select * from re2_projects where name='$proName'");
          $qkr_pid[]=$result[0]->id;
        }
        //Buyer Mail
        if(!empty($rec_name1)){
        $rec_name=implode(',',$rec_name1);
        }
        else{
          $rec_name='';
        }
        if(!empty($rec_no1)){
        $rec_no=implode(',',$rec_no1); 
        }
        else{
          $rec_no='';
        }
        $builder_name=implode(',',$builder);
        $project_name=implode(',',$project);
        //Buyer SMS
        if($buyer_no!='null' && !empty($buyer_no) && !empty($rec_name1) && !empty($rec_no1)){
        $content="Dear $buyer_name
Please call $rec_name, $rec_no, $project_name for your property needs.
They will help you find the right deal.
Thanks, QuikrHomes";
        $buyer_no=$buyer_no;
        $result=$this->apiModel->SMSAPI($buyer_no,$content);
        $result1=$result['response'];
        $result2=json_decode($result1);
      }
       // var_dump($result2);
          if($buyer_mail!='null' && !empty($buyer_mail) && !empty($rec_name1) && !empty($rec_no1)){
              $buyer_email=$buyer_mail;
              $buyer_name=$buyer_name;
              $dataVal=array('builder'=>$builder,'buyer_name'=>$buyer_name,'email'=>$buyer_email,'project'=>$project,'qkr_pid'=>$qkr_pid,'city'=>$citys,'loc'=>$locs,'lead_rec_name'=>$rec_names,'lead_rec_mail'=>$rec_mails,'lead_rec_no'=>$rec_nos);
                Mail::send('PSaddProjectMail',$dataVal,function( $message ) use ($dataVal)
                {
                  $message->to($dataVal['email'], $dataVal['buyer_name'])->subject('Good News, - QuikrHomes');
                });
                  $resp['status'] = 'success'; 
                  $resp['message'] = 'Email Send Sucessfully. Check your Mail';
                  foreach ($arrVal as $val) {
                    $res_buyer=DB::connection('mysql_master')->Select("select req_id,project_id,project,builder from re2_agent_matchmaking_email_status where req_id='".$req_ids."' and project_id='".$val->project_id."'");
                      if(count($res_buyer)==0){
                        $buyer=DB::connection('mysql_master')->Insert("insert into re2_agent_matchmaking_email_status (req_id,agent_id,project_id,project,builder,seller_name,seller_email_id,seller_phn_no,seeker_name,seeker_email_id,seeker_phn_no,buyer_mail_status,created_date) values('".$req_ids."','".$_SESSION['userid']."','".$val->project_id."','".$val->project."','".$val->builder."','".$val->rec_name."','".$val->rec_mail."','".$val->rec_no."','".$buyer_name."','".$buyer_mail."','".$buyer_no."','".$resp['status']."',NOW())");
                      }
                      else{
                        $buyer=DB::connection('mysql_master')->Update("update re2_agent_matchmaking_email_status set buyer_mail_status='".$resp['status']."' where req_id='".$res_buyer[0]->req_id."' and project_id='".$res_buyer[0]->project_id."'");
                      }
                  }
               $res=DB::connection('mysql_master')->Select("select req_id,project,project_id,builder,count(buyer_mail_status) as buyer_count,count(seller_mail_status) as receiver_count from re2_agent_matchmaking_email_status where req_id='".$req_id."' and (buyer_mail_status='sucsess' or seller_mail_status='success') group by project_id");
                  foreach ($res as $key => $resVal) {
                    $resultD=DB::connection('mysql_master')->Select("select * from re2_agent_disposition where req_id='".$resVal->req_id."' and project_id='".$resVal->project_id."'");
                    if(count($resultD)==0){
                      $strNew=DB::connection('mysql_master')->Insert("INSERT INTO `re2_agent_disposition` ( `req_id` , `builder` ,project_id, `project` , `buyer_mail_count` , `seller_mail_count` , `created_date` ) VALUES ('".$resVal->req_id."','".$resVal->builder."','".$resVal->project_id."','".$resVal->project."','".$resVal->buyer_count."','".$resVal->receiver_count."',NOW())");
                    }
                    else{
                        $strNew=DB::connection('mysql_master')->Update("Update re2_agent_disposition set buyer_mail_count='".$resVal->buyer_count."', seller_mail_count='".$resVal->receiver_count."' where req_id='".$resVal->req_id."' ");
                    }
                  }
                if($resp['status']=='success'){
                  header('Content-type: application/json');
                  echo json_encode($resp);
                }
                else{
                  $resp['status']='Failed';
                  header('Content-type: application/json');
                  echo json_encode($resp);
                }
            }
      }
      else{
        $resp['status'] = 'error'; 
            $resp['message'] = '*Please Check Email ID';   
            header('Content-type: application/json');
            echo json_encode($resp);
      }
    }

    public function sendMail(){
      
      session_start();
      if(!empty($_POST['action']) && !empty($_POST['b_builder'])){
        $build=$_POST['b_builder'];
        $project=$_POST['b_project'];
        $project_id=$_POST['b_project_id'];
        $result=DB::connection('mysql_master')->Select("Select * from re2_projects where name='$project'");
        $qkr_pid=$result[0]->id;
        //$cityid=$_POST['b_cityid'];
        $buyer_mail=$_POST['buyer_email'];
        $buyer_name=$_POST['buyer_name'];
        $buyer_no=$_POST['buyer_no'];
        $req_id=$_POST['req_id'];
       
        $rec_name=$_POST['rc_name'];
        $rec_mail=$_POST['rc_mail'];
        $rec_no=$_POST['rc_no'];
        $city=$_POST['rc_city'];
        $loc=$_POST['rc_loc'];
        $project_det=$_POST['rc_pro_details'];
          $n=explode(',', $project_det);
          $bhk=array();
          $area=array();
          $budget=array();
          for($a=0;$a<count($n);$a++){
            $m=$n[$a];
            $p=explode('-', $m);
            $bhk[]=$p[0];
            $area[]=$p[1];
            $budget[]=$p[2];
          }
          $rcbhk=implode(',',$bhk);
          $rcarea=implode(',',$area);
          $rcbudget=implode(',',$budget);

          //Seller Mail Starts here 
          //Seller SMS
          if($rec_no!='null' && !empty($rec_no) && $rec_name!='null' && !empty($buyer_name) && !empty($buyer_no)){
          $seller_content="Dear $rec_name,
$buyer_name,$buyer_no for investing in $rcbhk, $project, $loc.
Call now! Or check E-Mail for details, Quikr Homes";
          $rec_no=$rec_no;
          $seller_res=$this->apiModel->SMSAPI($rec_no,$seller_content);
          $s_res1=$seller_res['response'];
          $s_res2=json_decode($s_res1);
          }
          if($rec_mail!='null' && !empty($rec_mail)){
          $rec_email=$rec_mail;
          $rec_name=$rec_name;
          $rec_date=date('Y-m-d');
          $received_date=date("l jS \of F Y ",strtotime($rec_date));
          $recei_date=date('Y-m-d', strtotime($rec_date. ' + 3 days'));
          $report_date=date("l jS \of F Y",strtotime($recei_date));
          $data_val=array('lead_receiver'=>$rec_name, 'lead_receiver_email'=>$rec_email,'receiver_name'=>$buyer_name,'rece_mail'=>$buyer_mail,'receiver_name'=>$buyer_name,'rec_no'=>$buyer_no,'city'=>$city,'loc'=>$loc,'r_price'=>$rcbudget,'r_bhk'=>$rcbhk,'rec_date'=>$received_date,'report_date'=>$report_date,'agent_name'=>$_SESSION['username']);
          Mail::send('sellerMail',$data_val,function( $message ) use ($data_val)
          {
            $message->bcc('venkatesh.madhu@quikr.co.in','Venkatesh')->subject('New Lead, Quikr Homes');
            $message->to($data_val['lead_receiver_email'], $data_val['lead_receiver'])->subject('New Lead, Quikr Homes');
          });
          $res['status'] = 'success'; 
          $res['message'] = 'Email Send Sucessfully. Check your Mail';   
          $res_seller=DB::connection('mysql_master')->Select("select req_id,project_id,project,builder from re2_agent_matchmaking_email_status where req_id='".$req_id."' and project_id='".$project_id."'");
            if(count($res_seller)==0){
              $seller=DB::connection('mysql_master')->Insert("insert into re2_agent_matchmaking_email_status (req_id,agent_id,project_id,project,builder,seller_name,seller_email_id,seller_phn_no,seeker_name,seeker_email_id,seeker_phn_no,seller_mail_status,created_date) values('".$req_id."','".$_SESSION['userid']."','".$project_id."','".$project."','".$build."','".$rec_name."','".$rec_mail."','".$rec_no."','".$buyer_name."','".$buyer_mail."','".$buyer_no."','".$res['status']."',NOW())");
            }
            else{
                $seller=DB::connection('mysql_master')->Update("update re2_agent_matchmaking_email_status set seller_mail_status='".$res['status']."',created_date=NOW() where req_id='".$res_seller[0]->req_id."' and project_id='".$res_seller[0]->project_id."'");
              }
          }
         // Seller Mail Ends here     
        //Buyer Mail Starts here
        //Buyer SMS
          if($buyer_no!='null' && !empty($buyer_no) && $rec_name!='null' && $rec_no!='null'){
          $content="Dear $buyer_name
Please call $rec_name, $rec_no, $project for your property needs.
They will help you find the right deal.
Thanks, QuikrHomes";
//echo $content;

        $buyer_no=$buyer_no;
        $result=$this->apiModel->SMSAPI($buyer_no,$content);
        $result1=$result['response'];
        $result2=json_decode($result1);
        }
        if($buyer_mail!='null' && !empty($buyer_mail) && $rec_name!='null' && $rec_no!='null'){
         $buyer_email=$buyer_mail;
         $name=$buyer_name;
         $dataVal=array('builder'=>$build,'email'=>$buyer_email,'buyer_name'=>$buyer_name,'project'=>$project,'qkr_pid'=>$qkr_pid,'city'=>$city,'loc'=>$loc,'lead_rec_name'=>$rec_name,'lead_rec_mail'=>$rec_mail,'lead_rec_no'=>$rec_no);
          Mail::send('buyerMail',$dataVal,function( $message ) use ($dataVal){
            $message->to($dataVal['email'], $dataVal['buyer_name'])->subject('Match Making Details');
          });
          $resp['status'] = 'success'; 
          $resp['message'] = 'Email Send Sucessfully. Check your Mail';   
          $res_buyer=DB::connection('mysql_master')->Select("select req_id,project_id,project,builder from re2_agent_matchmaking_email_status where req_id='".$req_id."' and project_id='".$project_id."'");
          if(count($res_buyer)==0){
            $buyer=DB::connection('mysql_master')->Insert("insert into re2_agent_matchmaking_email_status (req_id,agent_id,project_id,project,builder,seller_name,seller_email_id,seller_phn_no,seeker_name,seeker_email_id,seeker_phn_no,buyer_mail_status,created_date) values('".$req_id."','".$_SESSION['userid']."','".$project_id."','".$project."','".$build."','".$rec_name."','".$rec_mail."','".$rec_no."','".$buyer_name."','".$buyer_mail."','".$buyer_no."','".$resp['status']."',NOW())");
          }
          else{
            $buyer=DB::connection('mysql_master')->Update("update re2_agent_matchmaking_email_status set buyer_mail_status='".$resp['status']."' where req_id='".$res_buyer[0]->req_id."' and project_id='".$res_buyer[0]->project_id."'");
          }
          //Buyer Mail Ends here  
            $res=DB::connection('mysql_master')->Select("select req_id,project_id,project,builder,count(buyer_mail_status) as buyer_count,count(seller_mail_status) as receiver_count from re2_agent_matchmaking_email_status where req_id='".$req_id."' and (buyer_mail_status='sucsess' or seller_mail_status='success') group by project_id");
            foreach ($res as $key => $resVal) {
              $resultD=DB::connection('mysql_master')->Select("select * from re2_agent_disposition where req_id='".$resVal->req_id."' and project_id='".$resVal->project_id."'");
              if(count($resultD)==0){
                $strNew=DB::connection('mysql_master')->Insert("INSERT INTO `re2_agent_disposition` ( `req_id` , `builder` ,project_id, `project` , `buyer_mail_count` , `seller_mail_count` , `created_date` ) VALUES ('".$resVal->req_id."','".$resVal->builder."','".$resVal->project_id."','".$resVal->project."','".$resVal->buyer_count."','".$resVal->receiver_count."',NOW())");
              }
              else{
                  $strNew=DB::connection('mysql_master')->Update("Update re2_agent_disposition set buyer_mail_count='".$resVal->buyer_count."', seller_mail_count='".$resVal->receiver_count."' where req_id='".$resVal->req_id."' ");
              }
            }
            if($resp['status']=='success'){
              header('Content-type: application/json');
              echo json_encode($resp);
            }
            else{
              $resp['status']='Failed';
              header('Content-type: application/json');
              echo json_encode($resp);
            }
        }
      }
      else{
        $resp['status'] = 'error'; 
            $resp['message'] = '*Please Check Email ID';   
            header('Content-type: application/json');
            echo json_encode($resp);
      }
    }
    public function lackofProperties(){
      
      $_id=Request::all();
      $req_id=$_id['req_id'];
      $val=DB::connection('mysql_master')->Select("Select * from re2_agent_disposition where req_id='".$req_id."' and builder is NULL and project is NULL");
      if(count($val)==0){
      $result=DB::connection('mysql_master')->Insert("INSERT INTO `re2_agent_disposition` ( `req_id` , `buyer_mail_count` , `seller_mail_count` , `created_date` ) VALUES ('".$req_id."','0','0',NOW())");
      $res['status']="success";
      }
      else{
        $result=DB::connection('mysql_master')->Update("Update re2_agent_disposition set req_id='".$req_id."', created_date=NOW() where req_id='".$req_id."'");
        $res['status']="success";
      }
      header('Content-type: application/json');
      echo json_encode($res);       
    }
    public function dropcall_connect(){
      
      $_id=Request::all();
      $req_id=$_id['req_id'];
      $agent_id=$_id['agent_id'];
      $seeker_no=$_id['seeker_no'];
      if(!empty($agent_id)){
          $result_sip=DB::connection('mysql_master')->Select("Select s.sip_id,sa.sip_number,s.agent_id from re2_agent_active s, re2_agent_sip_allotment sa where s.sip_id=sa.id and s.agent_id='$agent_id'");
          $sip_number=$result_sip[0]->sip_number;
          if($_SESSION['server_id']==0){
          $result= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_number&xpora_req_id=$req_id&telecaller_id=$agent_id");  
          }elseif($_SESSION['server_id']==1){
          $result= file_get_contents(config('constants.TELEPHONY_TELESALES_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_number&xpora_req_id=$req_id&telecaller_id=$agent_id");  
          
          }elseif($_SESSION['server_id']==2){
          $result= file_get_contents(config('constants.TELEPHONY_DELHI_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_number&xpora_req_id=$req_id&telecaller_id=$agent_id");  
          
          }elseif($_SESSION['server_id']==3){
          $result= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_number&xpora_req_id=$req_id&telecaller_id=$agent_id");  
          }else{
            $result= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_number&xpora_req_id=$req_id&telecaller_id=$agent_id");
          }
      }
    }
    public function projectSearch(){
      
        $_id=Request::all();
        $selcityval="select id,name from re2_cities where name='{$_id['cityname']}'";
        $res_city=DB::connection('mysql_master')->Select($selcityval); 
        $selproject="select id,name,city_id from re2_projects where name like'{$_id['projectname']}%' and city_id='{$res_city[0]->id}'";
        $result1=DB::connection('mysql_master')->Select($selproject);
        if(count($result1)>=1){
        foreach($result1 as $res) {
            $selcity="select name from re2_cities where id='{$res->city_id}'";
            $result2=DB::connection('mysql_master')->Select($selcity); 
            $selLeadreciver="select id,project_id,leadreceiver_name,leadreceiver_email,leadreceiver_phone,leads_sent,vl_status from re2_project_campaign where project_id='{$res->id}'";
            $result3=DB::connection('mysql_master')->Select($selLeadreciver); 
            $_prj['lead_rec_name']="";
            $_prj['lead_rec_email']="";
            $_prj['lead_rec_mobile']="";
            $_prj['vl_type']=0;
            if(count($result3)>=1){
                $_prj['lead_rec_name']=$result3[0]->leadreceiver_name;
                $_prj['lead_rec_email']=$result3[0]->leadreceiver_email;
                $_prj['lead_rec_mobile']=$result3[0]->leadreceiver_phone;
                $_prj['vl_type']=$result3[0]->vl_status;
            }
            $_prj['id']=$res->id;
            $_prj['name']=$res->name;
            $_prj['city']=$result2[0]->name;
            $projectarray[]=$_prj;
        }
        header('Content-type: application/json');
        echo json_encode($projectarray);
        }
        else{
            $_prj['lead_rec_name']="";
            $_prj['lead_rec_email']="";
            $_prj['lead_rec_mobile']="";
            $_prj['vl_type']=0;
            $_prj['id']="";
            $_prj['name']="";
            $_prj['city']="{$_id['cityname']}";
            $projectarray[]=$_prj;
            header('Content-type: application/json');
            echo json_encode($projectarray);
        }
    }
    public function sendMailproject(){
      
        session_start();
        $id=Request::all();
        //Seller
        $projectname=$id['s_projectname'];
        $rec_mail=$id['s_leadrecemail'];
        $rec_name=$id['s_leadrecname'];	
        $rec_no=$id['s_leadrecphone'];	
        $qkr_pid=$id['s_projectid'];	
        $project=$id['s_projectname'];	
        //Buyer
        $req_id=$id['s_seeker_reqid'];
        $buyer_mail=$id['s_seekeremail'];	
        $buyer_name=$id['s_seekername'];	
        $buyer_no=$id['s_seekerphone'];	
        
        $pro_result=$this->apiModel->getProjectdetails($qkr_pid);
        $pro_result1=$pro_result['response'];
        $finalres=json_decode($pro_result1);
        if($finalres->statusCode==200){
            $_projectId=$finalres->data->projectSnippet->id;
            $_projectname=$finalres->data->projectSnippet->name;
            $_buildername=$finalres->data->projectSnippet->builder->name;
            $_budget=$finalres->data->projectSnippet->priceRange->low." - ".$finalres->data->projectSnippet->priceRange->high;
            $_location=$finalres->data->projectSnippet->address->locality;
            $_city=$finalres->data->projectSnippet->address->city;
            
            //Seller Mail Starts here 
            //Seller SMS
            if($rec_no!='null' && !empty($rec_no) && $rec_name!='' && !empty($buyer_name) && !empty($buyer_no)){
                $seller_content="Dear $rec_name, 
                $buyer_name,$buyer_no for investing in $project, $_location, $_city. 
                Call now! Or check E-Mail for details, Quikr Homes";
                $rec_no=$rec_no;
                $seller_res=$this->apiModel->SMSAPI($rec_no,$seller_content);
                $s_res1=$seller_res['response'];
                $s_res2=json_decode($s_res1);
            }
            if($rec_mail!='' && !empty($rec_mail)){
              $rec_email=$rec_mail;
              $rec_name=$rec_name;
              $rec_date=date('Y-m-d');
              $received_date=date("l jS \of F Y ",strtotime($rec_date));
              $recei_date=date('Y-m-d', strtotime($rec_date. ' + 3 days'));
              $report_date=date("l jS \of F Y",strtotime($recei_date));
              $data_val=array('lead_receiver'=>$rec_name, 'lead_receiver_email'=>$rec_email,'rece_mail'=>$buyer_mail,'receiver_name'=>$buyer_name,'rec_no'=>$buyer_no,'city'=>"$_city",'loc'=>"$_location",'r_price'=>"$_budget",'r_bhk'=>"",'rec_date'=>$received_date,'report_date'=>$report_date,'agent_name'=>$_SESSION['username']);
              Mail::send('sellerMail',$data_val,function( $message ) use ($data_val)
              {
                $message->bcc('venkatesh.madhu@quikr.co.in','Venkatesh')->subject('New Lead, Quikr Homes');
                $message->to($data_val['lead_receiver_email'], $data_val['lead_receiver'])->subject('New Lead, Quikr Homes');
              });
              $res['status'] = 'success'; 
              $res['message'] = 'Email Send Sucessfully. Check your Mail';   
              $res_seller=DB::connection('mysql_master')->Select("select req_id,project_id,project,builder from re2_agent_matchmaking_email_status where req_id='".$req_id."' and project_id='".$_projectId."'");
                if(count($res_seller)==0){
                  $seller=DB::connection('mysql_master')->Insert("insert into re2_agent_matchmaking_email_status (req_id,agent_id,project_id,project,builder,seller_name,seller_email_id,seller_phn_no,seeker_name,seeker_email_id,seeker_phn_no,seller_mail_status,created_date) values('".$req_id."','".$_SESSION['userid']."','".$_projectId."','".$_projectname."','".$_buildername."','".$rec_name."','".$rec_mail."','".$rec_no."','".$buyer_name."','".$buyer_mail."','".$buyer_no."','".$res['status']."',NOW())");
                }
                else{
                    $seller=DB::connection('mysql_master')->Update("update re2_agent_matchmaking_email_status set seller_mail_status='".$res['status']."',created_date=NOW() where req_id='".$res_seller[0]->req_id."' and project_id='".$res_seller[0]->project_id."'");
                }
            }
            
            //Buyer Mail Starts here
            //Buyer SMS
            if($buyer_no!='null' && !empty($buyer_no) && $rec_name!='null' && $rec_no!='null' && $rec_name!='' && $rec_no!=''){
                $content="Dear $buyer_name, 
                Please call $rec_name, $rec_no, $project for your property needs. 
                They will help you find the right deal. 
                Thanks, QuikrHomes";
                //echo $content;
                $buyer_no=$buyer_no;
                $result=$this->apiModel->SMSAPI($buyer_no,$content);
                $result1=$result['response'];
                $result2=json_decode($result1);
            }
            if($buyer_mail!='null' && !empty($buyer_mail) && $rec_name!='null' && $rec_no!='null' && $rec_name!='' && $rec_no!=''){
                 $buyer_email=$buyer_mail;
                 $name=$buyer_name;
                 $dataVal=array('builder'=>$_buildername,'email'=>$buyer_email,'buyer_name'=>$buyer_name,'project'=>$_projectname,'qkr_pid'=>$qkr_pid,'city'=>$_city,'loc'=>$_location,'lead_rec_name'=>$rec_name,'lead_rec_mail'=>$rec_mail,'lead_rec_no'=>$rec_no);
                  Mail::send('buyerMail',$dataVal,function( $message ) use ($dataVal){
                    $message->to($dataVal['email'], $dataVal['buyer_name'])->subject('Match Making Details');
                  });
                  $resp['status'] = 'success'; 
                  $resp['message'] = 'Email Send Sucessfully. Check your Mail';   
                  $res_buyer=DB::connection('mysql_master')->Select("select req_id,project_id,project,builder from re2_agent_matchmaking_email_status where req_id='".$req_id."' and project_id='".$_projectId."'");
                  if(count($res_buyer)==0){
                    $buyer=DB::connection('mysql_master')->Insert("insert into re2_agent_matchmaking_email_status (req_id,agent_id,project_id,project,builder,seller_name,seller_email_id,seller_phn_no,seeker_name,seeker_email_id,seeker_phn_no,buyer_mail_status,created_date) values('".$req_id."','".$_SESSION['userid']."','".$_projectId."','".$_projectname."','".$_buildername."','".$rec_name."','".$rec_mail."','".$rec_no."','".$buyer_name."','".$buyer_mail."','".$buyer_no."','".$resp['status']."',NOW())");
                  }
                  else{
                    $buyer=DB::connection('mysql_master')->Update("update re2_agent_matchmaking_email_status set buyer_mail_status='".$resp['status']."' where req_id='".$res_buyer[0]->req_id."' and project_id='".$res_buyer[0]->project_id."'");
                  }
                    //Buyer Mail Ends here  
                    $res=DB::connection('mysql_master')->Select("select req_id,project_id,project,builder,count(buyer_mail_status) as buyer_count,count(seller_mail_status) as receiver_count from re2_agent_matchmaking_email_status where req_id='".$req_id."' and (buyer_mail_status='sucsess' or seller_mail_status='success') group by project_id");
                    foreach ($res as $key => $resVal) {
                      $resultD=DB::connection('mysql_master')->Select("select * from re2_agent_disposition where req_id='".$resVal->req_id."' and project='".$resVal->project_id."'");
                      if(count($resultD)==0){
                        $strNew=DB::connection('mysql_master')->Insert("INSERT INTO `re2_agent_disposition` ( `req_id` , `builder` ,project_id, `project` , `buyer_mail_count` , `seller_mail_count` , `created_date` ) VALUES ('".$resVal->req_id."','".$resVal->builder."','".$resVal->project_id."','".$resVal->project."','".$resVal->buyer_count."','".$resVal->receiver_count."',NOW())");
                      }
                      else{
                          $strNew=DB::connection('mysql_master')->Update("Update re2_agent_disposition set buyer_mail_count='".$resVal->buyer_count."', seller_mail_count='".$resVal->receiver_count."' where req_id='".$resVal->req_id."' ");
                      }
                    }
              }
              else{
                    $resp['status'] = 'error'; 
                    $resp['message'] = '*Please Check Email ID';   
                    header('Content-type: application/json');
                    echo json_encode($resp);
              }
            
        }
        if($resp['status']=='success'){
              header('Content-type: application/json');
              echo json_encode($resp);
            }
            else{
              $resp['status']='Failed';
              header('Content-type: application/json');
              echo json_encode($resp);
            }
    }
    public function updateEmail(){
      
       session_start();
       $data=json_encode($_POST);
       $result=$this->apiModel->updateEmailRequirement($data);
       $resp['status'] = $result['status'];
       $resp['version'] = $_POST['version']+1;
       header('Content-type: application/json');
       echo json_encode($resp);
    }
    public function historyEmail(){
      
       $id=Request::all();
       $req_id=$id['req_id']; 
       $result=$this->apiModel->emailHistory($req_id);
       $result1=$result['response'];
       $finalres=json_decode($result1);
       header('Content-type: application/json');
       echo json_encode($finalres);
    }
    public function historyMobile(){
      
       $id=Request::all();
       $req_id=$id['req_id']; 
       $result=$this->apiModel->mobileHistory($req_id);
       $result1=$result['response'];
       $finalres=json_decode($result1);
       header('Content-type: application/json');
       echo json_encode($finalres);
    }
    public function updateMobile(){
      
       session_start();
       $data=json_encode($_POST);
       $result=$this->apiModel->updateMobileRequirement($data);
       $resp['status'] = $result['status'];
       $resp['version'] = $_POST['version']+1;
       header('Content-type: application/json');
       echo json_encode($resp);
    }
    public function callcaseCheckaftrCall($reqid){
        /**
         * @ta total attempts till to Date
         * @ad attempts in a Day(Today)
         * @minattempt from call_cases table
         */
        $_queuecontroller = new QueueController;
        
        //GET PHONE CITY STATUS from Requirements..
        $userDisposition=DB::connection('mysql_slave')->select("select city_id,phone_1_id,status from re2_requirements where id='".$reqid."'");
        $city_id=$userDisposition[0]->city_id;
        $cityQry=DB::connection('mysql_slave')->Select("Select id,name from re2_cities where id='$city_id'");
        $city=$cityQry[0]->name;
        $phone_id=$userDisposition[0]->phone_1_id;
        $phneQry=DB::connection('mysql_slave')->Select("Select type,value from re2_user_contacts where id='$phone_id'");
        $phoneno=$phneQry[0]->value;
        $source="wanted";//Text
        
        $select_ta=DB::connection('mysql_slave')->Select("select count(id) as ta from re2_agent_call_cdr where xpora_req_id='$reqid' AND caller_no='$phoneno'");
        $_ta=$select_ta[0]->ta;
        $select_ad=DB::connection('mysql_slave')->Select("select count(id) as ad from re2_agent_call_cdr where xpora_req_id='$reqid' AND caller_no='$phoneno' and DATE(timestamp)=DATE(NOW())");
        $_ad=$select_ad[0]->ad;
        
        if($_ta>10){
            //2Moths After Call
            return 0;
        }
        else if($_ad>5){
            //Push it to future Queue
            $result =$_queuecontroller->xporaPublisherFuture($reqid,$city,$phoneno,$source);
            //$result = file_get_contents(config('constants.XPORA_ENDPOINT')."xpora-reloaded/public/XporaPublisherFuture/$reqid/$city/$phoneno/$source");
            return 0;
        }
        else{
            if($userDisposition[0]->status!='NEW'){
                $udheck=DB::connection('mysql_slave')->select("SELECT * FROM `re2_agent_call_cases` where user_disposition='".$userDisposition[0]->status."'");
                if(count($udheck)>=1){
                    if($udheck[0]->min_attempt==0 && $udheck[0]->action!=0){
                        //Take Action : Re-attempt back based on action
                        $no_of_days=$udheck[0]->action;
                        date_default_timezone_set('Asia/Kolkata');
                        $reattemptTime=date('Y-m-d H:i:s', strtotime("+$no_of_days days"));
                        $reattempt_qry=DB::connection('mysql_master')->insert("INSERT INTO re2_agent_re_attempt(req_id,phone_no,re_attempt_time,added_datetime) values('".$reqid."','".$phoneno."','".$reattemptTime."',NOW())");
                        $updateaddetail=DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='".$reqid."'");
                        return 0;
                    }
                    else if($udheck[0]->min_attempt!=0 && $_ad>=$udheck[0]->min_attempt && $udheck[0]->action==0){
                        //Move It to Future Queue
                        $result =$_queuecontroller->xporaPublisherFuture($reqid,$city,$phoneno,$source);
                        $updateaddetail=DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='".$reqid."'");
                        return 0;
                    }
                    else if($udheck[0]->min_attempt!=0 && $_ad>=$udheck[0]->min_attempt && $udheck[0]->action!=0){
                        //Take Action : Re-attempt back based on action
                        $no_of_days=$udheck[0]->action;
                        date_default_timezone_set('Asia/Kolkata');
                        $reattemptTime=date('Y-m-d H:i:s', strtotime("+$no_of_days days"));
                        $reattempt_qry=DB::connection('mysql_master')->insert("INSERT INTO re2_agent_re_attempt(req_id,phone_no,re_attempt_time,added_datetime) values('".$reqid."','".$phoneno."','".$reattemptTime."',NOW())");
                        $updateaddetail=DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='".$reqid."'");
                        return 0;
                    }
                    else{
                        //Move It to Future Queue
                        $result =$_queuecontroller->xporaPublisherFuture($reqid,$city,$phoneno,$source);
                        $updateaddetail=DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='".$reqid."'");
                        return 0;
                    }
                }
                else{
                    return 1;
                }
            }
        }
    }
}
