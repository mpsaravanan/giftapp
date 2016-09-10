<?php
namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;

class CreateAgentController extends Controller
{
    public function __construct(){
        $this->apiModel = new Api();
    }
    public function addUser(){
      
        if(!empty($_POST['inputEmpidnew'])){
            $result= DB::connection('mysql_master')->select("select id,emp_id from re2_agent_login where emp_id='".$_POST['inputEmpidnew']."'");
            if(count($result)>=1){
                $resp['status'] = 'exist'; 
                $resp['message'] = 'Employee Id Already Exist!';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
            else{
                $result= DB::connection('mysql_master')->insert("INSERT INTO re2_agent_login(name,emp_id,email,password,mobile,level,reporting_to,created_time) values('".$_POST['inputName']."','".$_POST['inputEmpidnew']."','".$_POST['inputEmail']."','".md5($_POST['inputPasswordnew'])."','".$_POST['inputMobile']."','".$_POST['inputLevel']."','".$_POST['inputReportingto']."',NOW())");
                $lastinsertId=DB::connection('mysql_master')->getPdo()->lastInsertId();
                $insertoactive= DB::connection('mysql_master')->insert("INSERT INTO re2_agent_active(agent_id,sip_id,login_status,pick_call_status,status) values('$lastinsertId','".$_POST['sipNumber']."','0','0','0')");
                $updatesip= DB::connection('mysql_master')->insert("update re2_agent_sip_allotment set status='1' where id='".$_POST['sipNumber']."'");
                if($result){
                $resp['status'] = 'success'; 
                $resp['message'] = 'Sucessfully Sent!';   
                header('Content-type: application/json');
                echo json_encode($resp);
                }
            }
        }
        else{
            $resp['status'] = 'error'; 
            $resp['message'] = 'Employee Id is empty';   
            header('Content-type: application/json');
            echo json_encode($resp);
        }
    }
    public function getAvailSipnumber(){
      
            $result= DB::connection('mysql_master')->select("select id,sip_number,status from re2_agent_sip_allotment where status='0'");
            if(count($result)>=1){
                header('Content-type: application/json');
                echo json_encode($result);
            }
            else{
                $data=array();
                header('Content-type: application/json');
                echo json_encode($data);
            }
    }
    public function addCompetency(){
      
       $channel=$_POST['channel'];
       $userid=$_POST['userid'];
       $uname=$_POST['username'];
       $role=$_POST['role'];
       $gender=$_POST['gender'];
       $followups=$_POST['followups'];
       $source=$_POST['source'];
       $profession=$_POST['profession'];
       $propertyfor1=$_POST['propertyfor1'];
       $propertyfor2=$_POST['propertyfor2'];
       $stateIds=$_POST['stateIds'];
       $cityIds=$_POST['cityIds'];
       $localityIds=$_POST['localityIds'];
       $projectIds=$_POST['projectIds'];
       $category=$_POST['category'];
       $propertyTypes=$_POST['propertyTypes'];
       $cons_phase=$_POST['cons_phase'];
       $price_min=$_POST['price_min'];
       $price_max=$_POST['price_max'];
       $area_min=$_POST['area_min'];
       $area_max=$_POST['area_max'];
       $bhk=$_POST['bhk'];
       $loan_req=$_POST['loan_req'];
       $purpose=$_POST['purpose'];
       $urgency=$_POST['urgency'];
            $res=DB::connection('mysql_master')->Select("select agent_id from re2_agent_competency_profile where agent_id='$userid'");
            if(count($res)>=1){
               $result=DB::connection('mysql_master')->Update("update re2_agent_competency_profile set channel='$channel', role='$role',state_id='$stateIds',city_id='$cityIds',locality_ids='$localityIds',project_ids='$projectIds',gender='$gender',total_follow_ups='$followups',source_1='$source',profession='$profession',category='$category',
                property_types='$propertyTypes',property_for_1='$propertyfor1',property_for_2='$propertyfor2',construction_phases='$cons_phase',price_min='$price_min',price_max='$price_max',area_min='$area_min',area_max='$area_max',bhks='$bhk',loan_requirement='$loan_req',purpose='$purpose',urgency='$urgency' where agent_id='$userid'");
                $updateMongo=new MongoController();
                $mongoupdate=$updateMongo->updateAgentUserDetail($userid);
                if($result){
                    $resp['status'] = 'success'; 
                    $resp['message'] = 'Sucessfully Updated!';   
                    header('Content-type: application/json');
                    echo json_encode($resp);
                }
            }
            else{
            $result= DB::connection('mysql_master')->insert("insert into re2_agent_competency_profile(agent_id,agent_name,channel,role,state_id,city_id,locality_ids,project_ids,gender,total_follow_ups,source_1,profession,category,property_types,property_for_1,property_for_2,construction_phases,price_min,price_max,area_min,area_max,bhks,loan_requirement,purpose,urgency) 
            values('$userid','$uname','$channel','$role','$stateIds','$cityIds','$localityIds','$projectIds','$gender','$followups','$source','$profession','$category','$propertyTypes','$propertyfor1','$propertyfor2','$cons_phase','$price_min','$price_max','$area_min','$area_max','$bhk','$loan_req','$purpose','$urgency')");
                $updateMongo=new MongoController();
                $mongoupdate=$updateMongo->addAgentUserDetail();
                if($result){
                    $resp['status'] = 'success'; 
                    $resp['message'] = 'Sucessfully Added!';   
                    header('Content-type: application/json');
                    echo json_encode($resp);
                }
            }
    }
    public function showManagerList(){
      header("X-Frame-Options: SAMEORIGIN"); header("X-XSS-Protection: 1; mode=block"); header("X-Content-Type-Options: nosniff");
        $_id = Request::all();
        session_start();
        $level=$_id['level'];
        $reportingarray=array();
        $result= DB::connection('mysql_master')->Select("Select id,name,reporting_to,level from re2_agent_login where level='$level'");
        foreach ($result as $res) {
          $data['name']=$res->name;
          $reportingarray[]=$data;
        }
        header('Content-type: application/json');
        $result3=json_encode($reportingarray);
        echo $result3;
    }

    public function agentSummary(){
        header("X-Frame-Options: SAMEORIGIN"); header("X-XSS-Protection: 1; mode=block"); header("X-Content-Type-Options: nosniff");
        $_id = Request::all();
        $_data=array();
        session_start();
        if(isset($_SESSION['userlevel'])){        
        if($_SESSION['userlevel']==0){
            $query= "select a.id,name,emp_id,level,reporting_to,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3)";
        }
        else if($_SESSION['userlevel']==1){
            $result2= DB::connection('mysql_master')->select("select id from re2_agent_login where level in(2,3) and reporting_to='".$_SESSION['userid']."'");
            $reportingIds=array();
            foreach ($result2 as $res2) {
                $reportingIds[]=$res2->id;
            }
            $rep_ids=implode(",",$reportingIds);
            if($rep_ids!=''){
                $query= "select a.id,name,emp_id,level,reporting_to,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3) and reporting_to in({$rep_ids})";    
            }
            else{
                $query='';
            }
        }
        else if($_SESSION['userlevel']==2){
            $query="select a.id,name,emp_id,level,reporting_to,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3) and reporting_to='".$_SESSION['userid']."'";
        }
        if(isset($_id['agent_name'])){
            if($_id['agent_name']!='N' && !empty($_id['agent_name'])){
                if(strlen($_id['agent_name'])<=30){
                $query.=" and a.name like '%{$_id['agent_name']}%'";
                }
            }
        }
        if(isset($_id['cityVal'])){
            if($_id['cityVal']!='N' && !empty($_id['cityVal'])){
                $cityVal="'". implode("', '", $_id['cityVal']) ."'";
                if(strlen($cityVal)<=500){
                $query.=" and city_id in ($cityVal)";
                } 
            }
        }
        
        $f1=0;
        $f2=0;
        $f3=0;
        if(isset($_id['sourceType'])){
            if(!empty($_id['sourceType']) && $_id['sourceType']!='N'){
                $sourceType=implode(",", $_id['sourceType']);
                if(strlen($sourceType)<=500){
                   $query.=" and b.source_1 like '%%%s%%'";
                   $f1=1;
                }
            }
        }
        if(isset($_id['pIntent'])){
            if(!empty($_id['pIntent']) && $_id['pIntent']!='N' && isset($_id['pIntent'])){
                $pIntent=implode(",", $_id['pIntent']);
                if(strlen($pIntent)<=30){
                   $query.=" and (b.property_for_1 like '%%%s%%' OR b.property_for_2 like '%%%s%%')";
                   $f2=1;
               }
            }
        }
        if(isset($_id['sIntent'])){
            if(!empty($_id['sIntent']) && $_id['sIntent']!='N' && isset($_id['sIntent'])){
                $sIntent=implode(",", $_id['sIntent']);
                if(strlen($sIntent)<=30){
                    $query.=" and b.category like '%%%s%%'";
                    $f3=1;
                }
            }
        }
        $today=date("Y-m-d");
        if(isset($_id['start_date'])){
            $_id['start_date']=$_id['start_date'];
        }
        else{
            $_id['start_date']="N";
        }
        if(isset($_id['end_date'])){
            $_id['end_date']=$_id['end_date'];
        }
        else{
            $_id['end_date']="N";
        }
        
        if($f1==1 && $f2==1 && $f3==1){
            $query=sprintf($query,$sourceType,$pIntent,$pIntent,$sIntent);
        }
        else if($f1==0 && $f2==1 && $f3==1){
            $query=sprintf($query,$pIntent,$pIntent,$sIntent);
        }
        else if($f1==1 && $f2==0 && $f3==1){
            $query=sprintf($query,$sourceType,$sIntent);
        }
        else if($f1==1 && $f2==1 && $f3==0){
            $query=sprintf($query,$sourceType,$pIntent,$pIntent);
        }
        else if($f1==0 && $f2==0 && $f3==1){
            $query=sprintf($query,$sIntent);
        }
        else if($f1==1 && $f2==0 && $f3==0){
            $query=sprintf($query,$sourceType);
        }
        else if($f1==0 && $f2==1 && $f3==0){
            $query=sprintf($query,$pIntent,$pIntent);
        }
        else{
            //
        }
        //$query= "select id,name,emp_id,level,reporting_to from re2_agent_login where level in(3)";
        //$result=DB::connection('mysql_master')->Select($query);
        //echo $query;
        if($query!=''){
          $execute=DB::connection('mysql_master')->Select($query);
          $_currentstatus=array();
          $_logincount= DB::connection('mysql_master')->select("SELECT count(*) as logincount from re2_agent_active where login_status=1");
          $_incallcount= DB::connection('mysql_master')->select("SELECT count(*) as incallcount from re2_agent_active where login_status=1 and pick_call_status=1 and status=1 and incall=1");
          $_freecount= DB::connection('mysql_master')->select("SELECT count(*) as freecount from re2_agent_active where login_status=1 and  pick_call_status=1 and (status=0 or status=1) and incall=0");
          $_dialcount= DB::connection('mysql_master')->select("SELECT count(*) as dialcount from re2_agent_active where login_status=1 and  pick_call_status=1 and status=1 and incall=2");
          $_ringcount= DB::connection('mysql_master')->select("SELECT count(*) as ringcount from re2_agent_active where login_status=1 and  pick_call_status=1 and status=1 and incall=3");
          $_notready= DB::connection('mysql_master')->select("SELECT count(*) as notreadycount from re2_agent_active where login_status=1 and  pick_call_status=0 and status=0 and incall=0");
          $_currentstatus['loggedin']=$_logincount[0]->logincount;
          $total=count($execute);
          $loggedout_count=($total-$_logincount[0]->logincount);
          $_currentstatus['loggedout']=$loggedout_count;
          $_currentstatus['incall']=$_incallcount[0]->incallcount;
          $_currentstatus['dialing']=$_dialcount[0]->dialcount;
          $_currentstatus['ringing']=$_ringcount[0]->ringcount;
          $_currentstatus['notready']=$_notready[0]->notreadycount;
          $_currentstatus['free']=$_freecount[0]->freecount;
          date_default_timezone_set('Asia/Kolkata');
        
          $reportingarray=array();
          foreach ($execute as $agentval) {
            //echo "SELECT a.id,agent_id,sip_id,login_status,pick_call_status,a.status,a.incall,manual_call_status,sip_number FROM re2_agent_active as a,re2_agent_sip_allotment as b WHERE a.sip_id=b.id and a.agent_id=$agentval->id";
            $_currentSt= DB::connection('mysql_master')->select("SELECT a.id,agent_id,sip_id,login_status,pick_call_status,a.status,a.incall,manual_call_status,sip_number FROM re2_agent_active as a,re2_agent_sip_allotment as b WHERE a.sip_id=b.id and a.agent_id=$agentval->id");
            if(count($_currentSt)>=1){
            //if($_currentSt[0]->login_status==1){
                $_logindate= DB::connection('mysql_slave')->select("SELECT 
                (SELECT login_time FROM re2_agent_login_logs WHERE agent_id = '$agentval->id' AND DATE(created_time) = DATE(NOW()) ORDER BY created_time LIMIT 1) as 'firstlogin',
                (SELECT login_time FROM re2_agent_login_logs WHERE agent_id = '$agentval->id' AND DATE(created_time) = DATE(NOW()) ORDER BY created_time DESC LIMIT 1) as 'lastlogin'");
                $_closure_time= DB::connection('mysql_slave')->select("SELECT closure_time FROM `re2_agent_call_hadling_detail` WHERE agent_id = '$agentval->id' AND DATE(inserted_date) = DATE(NOW()) order by inserted_date desc");
                //echo "SELECT break_time from re2_agent_login_logs where agent_id='$agentval->id' and break_time>='".$_logindate[0]->lastlogin."' order by break_time desc";
                $break_time=DB::connection('mysql_slave')->select("SELECT break_time from re2_agent_login_logs where agent_id='$agentval->id' and break_reason is NOT NULL and break_time is NOT NULL and break_time>='".$_logindate[0]->lastlogin."' order by break_time desc");
                $_data['agent_id']=$agentval->id;
                $_data['agent_name']=$agentval->name;
                $report=DB::connection('mysql_master')->Select("select name from re2_agent_login where id='".$agentval->reporting_to."'");
                $_data['teamleader']=$report[0]->name;
                $_city=$agentval->city_id;
                $cityQry=DB::connection('mysql_master')->Select("select name from re2_cities where id='$_city'");
                foreach ($cityQry as $value) {
                    $city_name=$value->name;
                    $_data['city']=$city_name;
                }
                
                $_source=$agentval->source_1;
                if($agentval->property_for_1!='' && $agentval->property_for_2==""){
                    $_propfor=$agentval->property_for_1;
                }elseif($agentval->property_for_1=='' && $agentval->property_for_2!=""){
                    $_propfor=$agentval->property_for_2;
                }else{
                    $_propfor=$agentval->property_for_1." ".$agentval->property_for_2;
                }
                $_category=$agentval->category;
                
                $_data['source']=$_source;
                $_data['pri_intent']=$_propfor;
                $_data['sec_intent']=$_category;
                
                $_data['call_status']="";
                $_data['login_time']="-";
                $_data['free_time']="";
                $_data['curent_mode']='NA';
                $_data['duration']="-";
                $_data['talktime']="-";
                $_data['actual_talktime']="-";
                $_data['avg_talktime']="-";
                $_data['avg_actual_talktime']="-";
                $_data['call_handling_time']="-";
                $_data['avg_call_handling_time']="-";
                $_data['ring_duration']="-";
                $_data['brkfortea']="";
                $_data['sip_number']=$_currentSt[0]->sip_number;
                if($_currentSt[0]->login_status==1){
                $_data['call_status']=$_currentSt[0]->status;
                $_data['incall']=$_currentSt[0]->incall;
                $_data['sip_number']=$_currentSt[0]->sip_number;
                $_data['free_time']="00:00:00";
                
                if(count($_logindate)>=1){
                    $_data['login_time']=$_logindate[0]->firstlogin;
                    //$_data['logout_time']=$_logindate[0]->lastlogout;
                }
                else{
                    $_data['login_time']="-";
                    //$_data['logout_time']="-";
                }
                if(count($_closure_time)>=1){
                    $cur_date=date('Y-m-d H:i:s');
                    $datetime1 = new \DateTime("{$_closure_time[0]->closure_time}");
                    $datetime2 = new \DateTime("{$cur_date}");
                    $interval = $datetime1->diff($datetime2);
                    $_data['free_time']=$interval->format("%H:%I:%S");
                }
                else{
                if($_currentSt[0]->login_status==1){
                    if(count($break_time)>=1){
                        $cur_date=date('Y-m-d H:i:s');
                        $datetime1 = new \DateTime("{$break_time[0]->break_time}");
                        $datetime2 = new \DateTime("{$cur_date}");
                        $interval = $datetime1->diff($datetime2);
                        $_data['free_time']=$interval->format("%H:%I:%S");   
                    }
                    elseif(count($_logindate)>=1){
                        $cur_date=date('Y-m-d H:i:s');
                        $datetime1 = new \DateTime("{$_logindate[0]->lastlogin}");
                        $datetime2 = new \DateTime("{$cur_date}");
                        $interval = $datetime1->diff($datetime2);
                        $_data['free_time']=$interval->format("%H:%I:%S");
                    }
                    else{
                        $_data['free_time']="00:00:00";
                    }
                  }
                  else{
                        $_data['free_time']="00:00:00";
                  }
                }
                if($_currentSt[0]->pick_call_status==1 && $_currentSt[0]->manual_call_status==0){
                    $_data['curent_mode']='Auto Mode';
                }else if($_currentSt[0]->manual_call_status==1 && $_currentSt[0]->pick_call_status==0){
                    $_data['curent_mode']='Manual Mode';
                }
                else{
                    $_currentMode= DB::connection('mysql_slave')->select("SELECT agent_id,break_reason FROM `re2_agent_login_logs` where agent_id=$agentval->id and break_reason!='' and break_time>='".$_logindate[0]->lastlogin."' order by break_time desc");
                    if(count($_currentMode)>=1){
                         $_data['curent_mode']=$_currentMode[0]->break_reason;
                    }
                    else{
                        $_data['curent_mode']='NA';
                    }
                }
                if($_currentSt[0]->login_status==1){
                    $_data['login_status']='yes';
                }else{
                    $_data['login_status']='no';
                }
                if($_currentSt[0]->pick_call_status==1){
                    $_data['pick_call_status']='yes';
                }else{
                    $_data['pick_call_status']='no';
                }
              }
              $today=date("Y-m-d");
                if(isset($_id['start_date'])){
                    $_id['start_date']=$_id['start_date'];
                }
                else{
                    $_id['start_date']="N";
                }
                if(isset($_id['end_date'])){
                    $_id['end_date']=$_id['end_date'];
                }
                else{
                    $_id['end_date']="N";
                }
                if($_id['start_date']!='N' && $_id['end_date']=='N'){
                    $_callextraqry=" and timestamp>='".$_id['start_date']." 00:00:00'";
                    $brkQry=" and al.created_time>='".$_id['start_date']." 00:00:00'";
                    $captureQry=" and inserted_time>='".$_id['start_date']." 00:00:00'";
                    $captureBHQry=" and inserted_time>='".$_id['start_date']." 09:30:00'";
                }
                elseif($_id['end_date']!='N' && $_id['start_date']=='N'){
                    $_callextraqry=" and timestamp<='".$_id['end_date']." 23:59:59'";
                    $brkQry=" and al.created_time<='".$_id['end_date']." 23:59:59'";
                    $captureQry=" and inserted_time<='".$_id['end_date']." 23:59:59'";
                    $captureBHQry=" and inserted_time<='".$_id['end_date']." 18:30:00'";
                }
                elseif($_id['end_date']!='N' && $_id['start_date']!='N'){
                    $_callextraqry=" and timestamp BETWEEN ('".$_id['start_date']." 00:00:00') AND ('".$_id['end_date']." 23:59:59')";
                    $brkQry=" and al.created_time BETWEEN ('".$_id['start_date']." 00:00:00') AND ('".$_id['end_date']." 23:59:59')";
                    $captureQry=" and inserted_time BETWEEN ('".$_id['start_date']." 00:00:00') AND ('".$_id['end_date']." 23:59:59')";
                    $captureBHQry=" and inserted_time BETWEEN ('".$_id['start_date']." 09:30:00') AND ('".$_id['end_date']." 18:30:00')";
                }
                else{
                    $_callextraqry="";
                    $brkQry="";
                    $captureQry="";
                    $captureBHQry=" and inserted_time BETWEEN ('".$today." 09:30:00') AND ('".$today." 18:30:00')";
                }

                $holdQry="Select count(*) as holdCount,h.hold_status,h.hold_time from re2_agent_hold_call h,re2_agent_call_cdr c where h.req_id=c.xpora_req_id and h.legA_uuid=c.legA_uuid and h.agent_id='$agentval->id' and h.hold_status='1' $_callextraqry";
                //echo $holdQry;
                $holdcount=DB::connection('mysql_slave')->Select($holdQry);
                $_data['holdcount']=$holdcount[0]->holdCount;
                $reqCapture="select count(*) as req_capture,r.id,r.created_date from re2_agent_ad_detail, re2_requirements r where r.id=req_id and r.updated_by='$agentval->id'";
                $reqCapture.=" $captureQry";
                $req_capture=DB::connection('mysql_slave')->Select($reqCapture);
                $total=$req_capture[0]->req_capture;
                $_data['req_capture']=$req_capture[0]->req_capture;
                $reqBHCapture="select count(*) as req_bhcapture,r.id,r.created_date from re2_agent_ad_detail, re2_requirements r where r.id=req_id and r.updated_by='$agentval->id'";
                $reqBHCapture.=" $captureBHQry";
                $req_bhcapture=DB::connection('mysql_slave')->Select($reqBHCapture);
                $blLeads=$req_bhcapture[0]->req_bhcapture;
                $_data['req_bhcapture']=$req_bhcapture[0]->req_bhcapture;
                $nblLeads=$total - $blLeads;
                $_data['req_nbhcapture']= $nblLeads;
                $talktimeqry="select r.id,r.created_date,caller_no,call_queue,start_datetime_legA,start_datetime_legB,ring_datetime_legA,ring_datetime_legB,answer_datetime_legB,end_datetime_legB,ch.closure_time from re2_agent_call_cdr, re2_requirements r,re2_agent_call_hadling_detail ch where r.id=xpora_req_id and telecaller_id='$agentval->id' and legA_uuid=ch.call_leg_id_A and (legA_hcause='NORMAL_CLEARING' OR legA_hcause='SUCCESS') and (legB_hcause='SUCCESS')";
                $talktimeqry.=" $_callextraqry";
                //echo $talktimeqry;
                $talktimedetail=DB::connection('mysql_slave')->Select($talktimeqry);

                if(count($talktimedetail)>=1){
                    foreach($talktimedetail as $_talktimedetail){
                        $closure_time=$_talktimedetail->closure_time;
                        $connect_time=$_talktimedetail->start_datetime_legA;
                        $starttime=$_talktimedetail->start_datetime_legB;
                        $ring_start_time=$_talktimedetail->ring_datetime_legA;
                        $ring_end_time=$_talktimedetail->ring_datetime_legB;
                        $anstime=$_talktimedetail->answer_datetime_legB;
                        $endtime=$_talktimedetail->end_datetime_legB;
                        $enq_time=$_talktimedetail->created_date;
                        $_data['caller_no']=$_talktimedetail->caller_no;
                        if($_talktimedetail->call_queue=='F'){
                          $_data['call_queue']='Future Queue'; 
                        }
                        else if($_talktimedetail->call_queue=='P'){
                          $_data['call_queue']='Present Queue';
                        }
                        else if($_talktimedetail->call_queue=='R'){
                          $_data['call_queue']='Re Queue';
                        }
                        else{
                          $_data['call_queue']="N/A";
                        }

                        $start = new \DateTime("$starttime");
                        $end = new \DateTime("$endtime");
                        $diff = $start->diff($end);
                        $_talktime[]=$diff->format('%H').":".$diff->format('%I').":".$diff->format('%S');
                        
                        $ans = new \DateTime("$anstime");
                        $diff2 = $ans->diff($end);
                        $_actalktime[]=$diff2->format('%H').":".$diff2->format('%I').":".$diff2->format('%S');
                        
                        $_data['duration']=$diff->format('%H').":".$diff->format('%I').":".$diff->format('%S');
                        
                        $ring_start = new \DateTime("$ring_start_time");
                        $ring_end = new \DateTime("$ring_end_time");
                        $diff3 = $ring_start->diff($ring_end);
                        $_ringtime[]=$diff3->format('%H').":".$diff3->format('%I').":".$diff3->format('%S');
                        $_data['ring_duration']=$diff3->format('%H').":".$diff3->format('%I').":".$diff3->format('%S');
                        
                        $call_handle = new \DateTime("$closure_time");
                        $call[]=$call_handle->format('%H').":".$call_handle->format('%I').":".$call_handle->format('%S');
                    
                    }
                    $sumtk = strtotime('00:00:00');
                    $sum2=0;  
                    foreach ($_talktime as $ac){
                            $sum1=strtotime($ac)-$sumtk;
                            $sum2 = $sum2+$sum1;
                        }
                    $sum3=$sumtk+$sum2;
                    $sumch = strtotime('00:00:00');
                    $sumch2=0;  
                    foreach ($call as $ch){
                            $sumch1=strtotime($ch)-$sumch;
                            $sumch2 = $sumch2+$sumch1;
                        }
                    $sumch3=$sumch+$sumch2;
                    $_data['talktime'] = date("H:i:s",$sum3);
                    $_data['call_handling_time']=date("H:i:s",$sum3)+date("H:i:s", $sumch3);
                    $_data['avg_talktime']= date('H:i:s', array_sum(array_map('strtotime', $_talktime)) / count($_talktime));
                    $_data['avg_call_handling_time']= date('H:i:s', array_sum(array_map('strtotime', $call)) / count($call));
                    $sum = strtotime('00:00:00');
                    $sum22=0;  
                    foreach ($_actalktime as $ac){
                        $sum11=strtotime($ac)-$sum;
                            $sum22 = $sum22+$sum11;
                        }
                    $sum33=$sum+$sum22;
                    $_data['actual_talktime'] = date("H:i:s",$sum33);
                    $_data['avg_actual_talktime'] =  date('H:i:s', array_sum(array_map('strtotime', $_actalktime)) / count($_actalktime));
                
                }
                else{
                  $_data['caller_no']="N/A";
                  $_data['call_queue']="N/A";
                }
                $holdtimeQry="Select h.hold_status,h.hold_time from re2_agent_hold_call h,re2_agent_call_cdr c where h.req_id=c.xpora_req_id and h.legA_uuid=c.legA_uuid and h.agent_id='$agentval->id' and h.hold_status='1' $_callextraqry";
                //echo $holdtimeQry;
                $holdtime=DB::connection('mysql_slave')->Select($holdtimeQry);
                if(count($holdtime)>=1){
                  foreach ($holdtime as $holdtime) {

                    $hold_time=$holdtime->hold_time;
                    $holding_time=new \DateTime("$hold_time");
                    //echo "jjgjhg".$holding_time->format('%H').":".$holding_time->format('%I').":".$holding_time->format('%S');
                  
                    $hold[]=$holding_time->format('%H').":".$holding_time->format('%I').":".$holding_time->format('%S');
                  }

                $sumh = strtotime('00:00:00');
                $sumhld=0;  
                //echo count($hold);
                    foreach ($hold as $holdtme){
                        $sumhold=strtotime($holdtme)-$sumh;
                            $sumhld = $sumhld+$sumhold;
                        }
                    $total_hold=$sumh+$sumhld;
                  $_data['hold_time'] = date('H:i:s',$total_hold);
                  $_data['avg_hold_time'] =  date('H:i:s', array_sum(array_map('strtotime', $hold)) / count($hold));
                }
                else{
                  $_data['hold_time'] = "-";
                  $_data['avg_hold_time'] = "-";
                }
                $countqry="select count(*) as calls_answered,r.created_date from re2_agent_call_cdr,re2_requirements r where r.id=xpora_req_id and telecaller_id='$agentval->id' and (legA_hcause='NORMAL_CLEARING' OR legA_hcause='SUCCESS') and (legB_hcause='SUCCESS')";
                $countqry.=" $_callextraqry";
                //echo $countqry;
                $count_callans=DB::connection('mysql_slave')->Select($countqry);
                if(count($count_callans)>=1){
                    foreach($count_callans as $_callans){
                        $_data['calls_answered']=$_callans->calls_answered;
                     }
                }
                $receiveqry="select count(*) as calls_received,r.created_date from re2_agent_call_cdr,re2_requirements r where r.id=xpora_req_id and telecaller_id='$agentval->id'";
                $receiveqry.=" $_callextraqry";
                $count_callrec=DB::connection('mysql_slave')->Select($receiveqry);
                if(count($count_callrec)>=1){
                    foreach($count_callrec as $_callrec){
                        $_data['calls_received']=$_callrec->calls_received;
                     }
                }
                $disposqry="select count(*) as dispos_set from re2_agent_call_cdr,re2_requirements r where r.id=xpora_req_id and telecaller_id='$agentval->id' and (r.status != 'NEW' or r.status != '') ";
                $disposqry.=" $_callextraqry";
                $count_dispos=DB::connection('mysql_slave')->Select($disposqry);
                if(count($count_dispos)>=1){
                    foreach($count_dispos as $_dispos){
                        $_data['dispos_set']=$_dispos->dispos_set;
                     }
                }
                $nodisposqry="select count(*) as nodispos_set from re2_agent_call_cdr,re2_requirements r where r.id=xpora_req_id and telecaller_id='$agentval->id' and (r.status = 'NEW' or r.status = '') ";
                $nodisposqry.=" $_callextraqry";
                $count_nodispos=DB::connection('mysql_slave')->Select($nodisposqry);
                if(count($count_nodispos)>=1){
                    foreach($count_nodispos as $_nodispos){
                        $_data['nodispos_set']=$_nodispos->nodispos_set;
                     }
                }
                $rescheduleqry="select count(*) as reschedule from re2_agent_call_cdr,re2_requirements r where r.id=xpora_req_id and telecaller_id='$agentval->id' and (r.status='CALL_BACK_AT' or r.status='RINGING_NO_RESPONSE_CALLBACK_AT' or r.status='call me later' or r.status='CALL_BACK_LATER' or r.status='Call_Later_Post_Presentation' or r.status='  Call_Later_Pre_Presentation' or r.status='Contact_Call_Back' ) ";
                $rescheduleqry.=" $_callextraqry";
                $count_reschedule=DB::connection('mysql_slave')->Select($rescheduleqry);
                if(count($count_reschedule)>=1){
                    foreach($count_reschedule as $_reschedule){
                        $_data['reschedule']=$_reschedule->reschedule;
                     }
                }
                $brkLog="select count(*) as breakcount,al.break_reason,al.break_time,aa.login_status,aa.pick_call_status,aa.manual_call_status from re2_agent_login_logs al,re2_agent_active aa where al.agent_id=aa.agent_id and al.agent_id =$agentval->id and break_reason!=''";
                $brkLog.=" $brkQry";
                $brklogs= DB::connection('mysql_slave')->select($brkLog);
                foreach ($brklogs as $brklogs) {
                  $_data['brkcount']=$brklogs->breakcount;
                }
                $brkTea="select count(*) as brkfortea,al.break_reason,al.break_time,aa.login_status,aa.pick_call_status,aa.manual_call_status from re2_agent_login_logs al,re2_agent_active aa where al.agent_id=aa.agent_id and al.agent_id =$agentval->id and break_reason='Tea'";
                $brkTea.=" $brkQry";
                $brktea= DB::connection('mysql_slave')->select($brkTea);
                if(count($brktea)>=1){
                  foreach ($brktea as $brktea) {
                    $_data['brkfortea']=$brktea->brkfortea;
                  }
                }
                $brkLunch="select count(*) as brklunch,al.break_reason,al.break_time,aa.login_status,aa.pick_call_status,aa.manual_call_status from re2_agent_login_logs al,re2_agent_active aa where al.agent_id=aa.agent_id and al.agent_id =$agentval->id and break_reason='Lunch'";
                $brkLunch.=" $brkQry";
                $brklunch= DB::connection('mysql_slave')->select($brkLunch);
                if(count($brklunch)>=1){
                  foreach ($brklunch as $brklunch) {
                    $_data['brkforlunch']=$brklunch->brklunch;
                  }
                }
                $brkTL="select count(*) as brkfortl,al.break_reason,al.break_time,aa.login_status,aa.pick_call_status,aa.manual_call_status from re2_agent_login_logs al,re2_agent_active aa where al.agent_id=aa.agent_id and al.agent_id =$agentval->id and break_reason='TL Breifing'";
                $brkTL.=" $brkQry";
                $brktl= DB::connection('mysql_slave')->select($brkTL);
                if(count($brktl)>=1){
                  foreach ($brktl as $brktl) {
                    $_data['brkfortl']=$brktl->brkfortl;
                  }
                }
                $brkTraining="select count(*) as brkfortraining,al.break_reason,al.break_time,aa.login_status,aa.pick_call_status,aa.manual_call_status from re2_agent_login_logs al,re2_agent_active aa where al.agent_id=aa.agent_id and al.agent_id =$agentval->id and break_reason='Training'";
                $brkTraining.=" $brkQry";
                $brktraining= DB::connection('mysql_slave')->select($brkTraining);
                if(count($brktraining)>=1){
                  foreach ($brktraining as $brktraining) {
                    $_data['brkfortraining']=$brktraining->brkfortraining;
                  }
                }
                $brkQA="select count(*) as brkforqa,al.break_reason,al.break_time,aa.login_status,aa.pick_call_status,aa.manual_call_status from re2_agent_login_logs al,re2_agent_active aa where al.agent_id=aa.agent_id and al.agent_id =$agentval->id and break_reason='QA Feedback'";
                $brkQA.=" $brkQry";
                $brkqa= DB::connection('mysql_slave')->select($brkQA);
                if(count($brkqa)>=1){
                  foreach ($brkqa as $brkqa) {
                    $_data['brkforqa']=$brkqa->brkforqa;
                  }
                }
                $brkOthers="select count(*) as brkforothers,al.break_reason,al.break_time,aa.login_status,aa.pick_call_status,aa.manual_call_status from re2_agent_login_logs al,re2_agent_active aa where al.agent_id=aa.agent_id and al.agent_id =$agentval->id and break_reason='Others'";
                $brkOthers.=" $brkQry";
                $brkothers= DB::connection('mysql_slave')->select($brkOthers);
                if(count($brkothers)>=1){
                  foreach ($brkothers as $brkothers) {
                    $_data['brkforothers']=$brkothers->brkforothers;
                  }
                }
                
                $brkquery="select al.login_time,al.login_dialer_time,al.logout_time,al.break_reason,al.break_time,aa.login_status,aa.pick_call_status,aa.manual_call_status from re2_agent_login_logs al,re2_agent_active aa where al.agent_id=aa.agent_id and al.agent_id =$agentval->id";
                $brkquery.=" $brkQry";
                $brkreport= DB::connection('mysql_slave')->select($brkquery);
                foreach ($brkreport as $val) {
                  $start=date_create($val->login_time);
                  $end=date_create($val->logout_time);
                  $break=date_create($val->break_time);
                  $dial_time=date_create($val->login_dialer_time);
                  $_data['break_reason']=$val->break_reason;
                  $_data['login_time']=$val->login_time;
                  if($val->login_dialer_time==null){
                    $data['idle_time']='N/A';
                  }
                  else{
                    $idle=date_diff($dial_time,$start);
                    $data['idle_time']=$idle->h.":".$idle->i.":".$idle->s;
                  }
                  if($val->break_time==null){
                    $_data['break_time']='N/A';
                    //$_data['loggedin_dialer_duration']='N/A';
                  }
                  else{
                      $_data['break_time']=date_format($break,"Y/m/d H:i:s");
                      $dialer_time=date_diff($break,$dial_time);
                      //$_data['loggedin_dialer_duration']=$dialer_time->h.":".$dialer_time->i.":".$dialer_time->s;
                  } 
                  if(date_format($end,"Y/m/d H:i:s")=='-0001/11/30 00:00:00'){
                     $_data['logout_date']='N/A'; 
                     $_data['loggedin_account_duration']='N/A';
                  }
                  else{
                     $_data['logout_date']=date_format($end,"Y/m/d H:i:s"); 
                     $acc_login=date_diff($end,$start);
                     $_data['loggedin_account_duration']=$acc_login->h.":".$acc_login->i.":".$acc_login->s;
                  }

                }
            }
          $_currentstatus['data'][]=$_data;
          }
          header('Content-type: application/json');
          $result2=json_encode($_currentstatus);
          echo $result2;
        }
        else{
          $_currentstatus['data'][]=$_data;
          header('Content-type: application/json');
          $result2=json_encode($_currentstatus);
          echo $result2;
        } 
        
    }
     else{
          $_currentstatus['data'][]=$_data;
          header('Content-type: application/json');
          $result2=json_encode($_currentstatus);
          echo $result2;
        }   
       
}
}
