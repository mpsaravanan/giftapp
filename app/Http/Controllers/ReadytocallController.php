<?php
namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;

class ReadytocallController extends Controller
{
    public function __construct(){
        $this->apiModel = new Api();
    }
    public function readytogetCall(){
        session_start();
        $qry=DB::connection('mysql_slave')->select("SELECT * FROM `re2_agent_login_logs` where agent_id='".$_SESSION['userid']."' order by id desc");
        $login_time=$qry[0]->login_time;
        $login_temp=$qry[0]->login_temp;
        $checkStatus=DB::connection('mysql_slave')->select("Select * from re2_agent_active where agent_id='".$_SESSION['userid']."'");
        $login_status=$checkStatus[0]->login_status;
        if($login_status==1){
            $update_dialler_time=DB::connection('mysql_master')->update("update re2_agent_login_logs set login_dialer_time=NOW() where agent_id='".$_SESSION['userid']."' and login_time='$login_time' and login_temp='$login_temp'");
            $updatesip= DB::connection('mysql_master')->update("update re2_agent_active set pick_call_status=1 where agent_id='".$_SESSION['userid']."'");
            $_mongo2=new MongoController();
            $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,1,0);
            $_update_log=$_mongo2->updatePickCallDetail($_SESSION['userid']);
            if($updatesip){
                $resp['status'] = 'success'; 
                $resp['message'] = 'Sucessfully Updated!';   
                
            }
        }
        else{
            $resp['status'] = 'logout';
        }
            header('Content-type: application/json');
            echo json_encode($resp);
    }
    public function readytoleaveCall(){
        session_start();
        $status = Request::all();
        $pick_call_status=$status['pick_call_status'];
        $manual_call_status=$status['manual_call_status'];
        $checkStatus=DB::connection('mysql_slave')->select("Select * from re2_agent_active where agent_id='".$_SESSION['userid']."'");
        $login_status=$checkStatus[0]->login_status;
        if($login_status==1){

        if($pick_call_status=='I want to Leave'){
            $updatesip= DB::connection('mysql_master')->update("update re2_agent_active set pick_call_status=0 where agent_id='".$_SESSION['userid']."'");
            $_mongo2=new MongoController();
            $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,0,0);
            if($updatesip){
                $resp['status'] = 'Auto-success'; 
                $resp['message'] = 'Sucessfully Updated!';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
        }
        if($manual_call_status=='I want to Leave Manual Mode'){
            $updatesip= DB::connection('mysql_master')->update("update re2_agent_active set manual_call_status=0 where agent_id='".$_SESSION['userid']."'");
            $_mongo2=new MongoController();
            $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,0,0);
            if($updatesip){
                $resp['status'] = 'Manual-success'; 
                $resp['message'] = 'Sucessfully Updated!';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }   
        }
        }
        else{
            $resp['status'] = 'logout'; 
            header('Content-type: application/json');
            echo json_encode($resp);
        }
    }
    public function callStatuson($agent_id){
        if(!empty($agent_id)){
            $update_status= DB::connection('mysql_master')->update("update re2_agent_active set status=1 where agent_id='".$agent_id."'");
            $_mongo2=new MongoController();
            $_insert=$_mongo2->updateCurrentStatus($agent_id,1,1,1);
            if($update_status){
                $resp['status'] = 'success'; 
                $resp['message'] = 'Sucessfully Updated!';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
        }
    }
    public function callStatusoff($agent_id){
        if(!empty($agent_id)){
            $update_status= DB::connection('mysql_master')->update("update re2_agent_active set status=0 where agent_id='".$agent_id."'");
            $_mongo2=new MongoController();
            $_insert=$_mongo2->updateCurrentStatus($agent_id,1,1,0);
            if($update_status){
                $resp['status'] = 'success'; 
                $resp['message'] = 'Sucessfully Updated!';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
        }
    }
    public function callstatusOnPusher(){
        session_start();
        $agentid = Request::all();
        $agent_id=$agentid['agentid'];
        if(!empty($agent_id)){
            $update_status= DB::connection('mysql_master')->update("update re2_agent_active set status=1 where agent_id='".$agent_id."'");
            $_mongo2=new MongoController();
            $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,1,1);
            if($update_status){
                $resp['status'] = 'success'; 
                $resp['message'] = 'Sucessfully Updated!';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
        }
    }
    public function incallstatusOnPusher(){
        session_start();
        $agentid = Request::all();
        $agent_id=$agentid['agentid'];
        if(!empty($agent_id)){
            if($agentid['status']=='connected'){
                $incall=1;
            }
            elseif($agentid['status']=='dialing'){
                $incall=2;
            }
            else if($agentid['status']=='ringing'){
                $incall=3;
            }
            else{
                $incall=0;
            }
            $update_incallstatus= DB::connection('mysql_master')->update("update re2_agent_active set incall='".$incall."' where agent_id='".$agent_id."'");
            $_mongo2=new MongoController();
            $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,1,$incall);
            if($update_incallstatus){
                $resp['status'] = 'success'; 
                $resp['message'] = 'Sucessfully Updated!';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
        }
    }
    public function ManualMode(){
        $agent = Request::all();
        session_start();
        $agent_id=$_SESSION['userid'];
        $source=$agent['source'];
        $category=$agent['category'];
        $disposition=$agent['disposition'];
        $prop_type=$agent['prop_type'];
        $date=$agent['date'];
        $qry=DB::connection('mysql_slave')->select("SELECT * FROM `re2_agent_login_logs` where agent_id='".$_SESSION['userid']."' order by id desc");
        $login_time=$qry[0]->login_time;
        $login_temp=$qry[0]->login_temp;
        $update_dialler_time=DB::connection('mysql_master')->update("update re2_agent_login_logs set login_dialer_time=NOW() where agent_id='".$_SESSION['userid']."' and login_time='$login_time' and login_temp='$login_temp'");
        $updatesip= DB::connection('mysql_master')->update("update re2_agent_active set manual_call_status=1 where agent_id='".$_SESSION['userid']."'");
        $_mongo2=new MongoController();
        $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,1,1);
        if(!empty($agent_id)){
        $reportingarray=array();
            $str="Select cp.agent_id,cp.agent_name,cp.city_id,cp.source_1,cp.category,cp.property_types,rc.legA_hcause,rc.timestamp,rc.caller_no,rc.xpora_req_id from re2_agent_call_cdr rc,re2_agent_competency_profile cp where cp.agent_id=rc.telecaller_id and cp.agent_id='$agent_id' and rc.legA_hcause!='NORMAL_CLEARING' and rc.legA_hcause!='SUCCESS'";
            if(!empty($source)){ 
                $str.=" and cp.source_1 like '%$source%'";
            }
            if(!empty($category)){ 
                $str.=" and cp.category like '%$tc_name%'";
            }
            if(!empty($prop_type)){ 
                $str.=" and cp.property_types like '%$prop_type%'";
            }
            if(!empty($date)){ 
                $str.=" and rc.timestamp between ('$date 00:00:00') and ('$date 23:59:59')";
            }
            $str.=" order by rc.timestamp desc limit 0,50";
            $result2=DB::connection('mysql_master')->Select($str);
            foreach ($result2 as $res2) {
                //echo "select s.sip_number,al.sip_id,al.agent_id from re2_agent_active al,re2_agent_sip_allotment s where s.id=al.sip_id and al.agent_id='$res2->agent_id'";
                $sip=DB::connection('mysql_slave')->Select("select s.sip_number,al.sip_id,al.agent_id from re2_agent_active al,re2_agent_sip_allotment s where s.id=al.sip_id and al.agent_id='$res2->agent_id'");
                $city=DB::connection('mysql_slave')->Select("select id,name from re2_cities where id in($res2->city_id)");
                $city_v=array();
                foreach ($city as $city) {
                  $city_v[]=$city->name;  
                }
                $data['datetime']=$res2->timestamp;
                $data['agent_name']=$res2->agent_name;
                $data['agent_id']=$res2->agent_id;
                $data['city']=$city_v;
                //$data['dis_status']=$res->status;
                $data['source']=$res2->source_1;
                $data['category']=$res2->category;
                $data['property_types']=$res2->property_types;
                $data['req_id']=$res2->xpora_req_id;
                $data['sip_no']=$sip[0]->sip_number;
                $data['seeker_no']=$res2->caller_no;
                //$data['req_username']=$res->user_name;
                $data['call_status']=$res2->legA_hcause;
                $reportingarray[]=$data; 
            }
        }
        header('Content-type: application/json');
        $result3=json_encode($reportingarray);
        echo $result3;
    }
    public function manualCall(){
        $val = Request::all();
        $req_id=$val['req_id'];
        $tc_id=$val['tc_id'];
        $sip_no=$val['sip_no'];
        $seeker_no=$val['seeker_no'];
        
        if($_SESSION['server_id']==0){
         $result= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_no&xpora_req_id=$req_id&telecaller_id=$tc_id");
        }elseif($_SESSION['server_id']==1){
          $result= file_get_contents(config('constants.TELEPHONY_TELESALES_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_no&xpora_req_id=$req_id&telecaller_id=$tc_id");
        }elseif($_SESSION['server_id']==2){
          $result= file_get_contents(config('constants.TELEPHONY_DELHI_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_no&xpora_req_id=$req_id&telecaller_id=$tc_id");
        }elseif($_SESSION['server_id']==3){
         $result= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_no&xpora_req_id=$req_id&telecaller_id=$tc_id");
         }else{
           $result= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_no&xpora_req_id=$req_id&telecaller_id=$tc_id");
         }
    }
    public function assignedCall(){
      $agent = Request::all();
        $tc_id=$agent['tc_id'];
        //$tc_name=$agent['tc_name'];
        $date=$agent['date'];
        $source=$agent['source'];
        $city=$agent['city'];
        session_start();
        if(!empty($tc_id)){
        $reportingarray=array();
        $qry="Select * from re2_agent_outbound_list where agent_id='$tc_id' and completed='0' ";
        if(!empty($date)){
            $qry.=" and timestamp between ('$date 00:00:00') and ('$date 23:59:59')";
        }
        $qry.=" order by timestamp desc";
        $result=DB::connection('mysql_master')->Select($qry);
        $checkStatus=DB::connection('mysql_master')->select("Select * from re2_agent_active where agent_id='".$_SESSION['userid']."'");
        $login_status=$checkStatus[0]->login_status;
        if($login_status==1){
        foreach ($result as $res) {
            $str="Select city,source,phone_no from re2_agent_ad_detail where req_id='$res->req_id'";
            if(!empty($source)){ 
                $str.=" and source like '%$source%'";
            }
            if(!empty($city)){ 
                $str.=" and city like '%$city%'";
            }
            $str.=" limit 0,50";
           // echo $str."<br>";
            $result2=DB::connection('mysql_master')->Select($str);
            foreach ($result2 as $res2) {
                $sip=DB::connection('mysql_master')->Select("Select sa.sip_number,sa.id from re2_agent_sip_allotment sa, re2_agent_active aa where aa.sip_id=sa.id and aa.agent_id='$res->agent_id'");
                $assign=DB::connection('mysql_master')->Select("Select name from re2_agent_login where id='$res->assigned_by'");
                $agent=DB::connection('mysql_master')->Select("Select name from re2_agent_login where id='$res->agent_id'");
                $data['datetime']=$res->timestamp;
                $data['agent_name']=$agent[0]->name;
                $data['agent_id']=$res->agent_id;
                $data['city']=$res2->city;
                $data['source']=$res2->source;
                $data['seeker_no']=$res2->phone_no;
                $data['req_id']=$res->req_id;
                $data['outbound_id']=$res->id;
                $data['sip_no']=$sip[0]->sip_number;
                $data['assigned_by']=$assign[0]->name;
                $data['status']="success";
                $reportingarray[]=$data; 
            }
        }
        }
        else{
            $data['status']="logout";
            $reportingarray[]=$data; 
        }
        header('Content-type: application/json');
        $result3=json_encode($reportingarray);
        echo $result3;
        }
    }
    public function assignCall(){
        $val = Request::all();
        $outbound_id=$val['outbound_id'];
        $req_id=$val['r_id'];
        $tc_id=$val['tc_id'];
        $sip_no=$val['s_no'];
        $seeker_no=$val['sk_no'];
        $update_status= DB::connection('mysql_master')->update("update re2_agent_outbound_list set completed=1 where id='".$outbound_id."'");
        if($_SESSION['server_id']==0){
         $result= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_no&xpora_req_id=$req_id&telecaller_id=$tc_id");
        }if($_SESSION['server_id']==1){
          $result= file_get_contents(config('constants.TELEPHONY_TELESALES_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_no&xpora_req_id=$req_id&telecaller_id=$tc_id");
        }if($_SESSION['server_id']==2){
          $result= file_get_contents(config('constants.TELEPHONY_DELHI_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_no&xpora_req_id=$req_id&telecaller_id=$tc_id");
        }if($_SESSION['server_id']==3){
         $result= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_no&xpora_req_id=$req_id&telecaller_id=$tc_id");
         }else{
           $result= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall_manual.php?caller_number=$seeker_no&called_number=$sip_no&xpora_req_id=$req_id&telecaller_id=$tc_id");
         }
        $resp['status'] = 'success'; 
        $resp['message'] = 'Called Successfully';   
        header('Content-type: application/json');
        echo json_encode($resp);
    } 
    public function holdCall(){
        $val = Request::all();
        $req_id=$val['req_id'];
        $agent_id=$val['agent_id'];
        $lagAuuid=$val['lagAuuid'];
        $lagBuuid=$val['lagBuuid'];
        $holdCallmode=$val['holdCallmode'];
        $insertHoldstatus= DB::connection('mysql_master')->insert("insert into re2_agent_hold_call(req_id,agent_id,legA_uuid,legB_uuid,hold_status,hold_time) values('{$req_id}','{$agent_id}','{$lagAuuid}','{$lagBuuid}','1',NOW())");
        if($holdCallmode=='1'){
            $unholdCall= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/hold_on.php?lega_uuid={$lagAuuid}");
        }
        else{
            $unholdCall= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/hold_on_auto.php?legb_uuid={$lagBuuid}");
        }
        $resp['status'] = 'success'; 
        $resp['message'] = 'Call Hold Done';   
        header('Content-type: application/json');
        echo json_encode($resp);
    }
    public function unHoldCall(){
        $val = Request::all();
        $req_id=$val['req_id'];
        $agent_id=$val['agent_id'];
        $lagAuuid=$val['lagAuuid'];
        $lagBuuid=$val['lagBuuid'];
        $holdCallmode=$val['holdCallmode'];
        $insertunHoldstatus= DB::connection('mysql_master')->insert("insert into `re2_agent_hold_call`(req_id,agent_id,legA_uuid,legB_uuid,hold_status,hold_time) values('{$req_id}','{$agent_id}','{$lagAuuid}','{$lagBuuid}','0',NOW())");
        if($holdCallmode=='1'){
            $unholdCall= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/hold_off.php?lega_uuid={$lagAuuid}");
        }
        else{
            $unholdCall= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/hold_off_auto.php?legb_uuid={$lagBuuid}");
        }
        $resp['status'] = 'success'; 
        $resp['message'] = 'Call Unhold Done';   
        header('Content-type: application/json');
        echo json_encode($resp);
    }
    public function disconnectCall(){
        session_start();
        $val = Request::all();
        $lagaUiid=$val['lagaUiid'];
        $agent_id=$val['agent_id'];

        if(!empty($lagaUiid)){
            $disconnectCall= file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/hangup_call.php?lega_uuid={$lagaUiid}");
            $resp['status'] = 'success'; 
            /*$_selectAgentMode= DB::connection('mysql_master')->Select("SELECT agent_id,pick_call_status,manual_call_status FROM `re2_agent_active` where agent_id='{$agent_id}'");
            $resp['call_mode']="";
            if($_selectAgentMode[0]->pick_call_status==1){
                $resp['call_mode']="Auto";
            }
            if($_selectAgentMode[0]->manual_call_status==1){
                $resp['call_mode']="Manual";
            }*/
            $resp['message'] = 'Call Disconnect Sucessfully!';   
            header('Content-type: application/json');
            echo json_encode($resp);
        }
        else{
            $resp['status'] = 'failed'; 
            $resp['message'] = 'Error! Call Disconnect';   
            header('Content-type: application/json');
            echo json_encode($resp);
        }
    }
    public function initNextAutoCall(){
        session_start();
        $update= DB::connection('mysql_master')->update("update re2_agent_active set status='0' where agent_id='".$_SESSION['userid']."'");
        $_mongo2=new MongoController();
        $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,1,0);
        $_selectNxtCall= DB::connection('mysql_master')->Select("SELECT req_id,city,phone_no FROM `re2_agent_ad_detail` where req_status='0' AND assign_status='0' AND status_call='0' ORDER BY inserted_time DESC ");
        foreach($_selectNxtCall as $_addetails){
            $_getreqid = $_addetails->req_id;
            $_customerno = $_addetails->phone_no;
            //Get Requirement Id Details..
            $result=$this->apiModel->getRequirement($_getreqid);
            $result1=$result['response'];
            $result2=json_decode($result1);
            if($result2->statusCode=="200" && $result2->message=="success" && $result2->data!="NULL" && !empty($result2->data)){
                //var_dump($result2);
                $_reqid = $result2->data->id;
                $_sourceval = $result2->data->source1;
                $_category = $result2->data->category;
                $_proptype = $result2->data->propertyTypes;
                $_cityName = $result2->data->cityName;
                $_primaryintentval = $result2->data->transactionType;
                if($_sourceval=="WANT_AD" || $_sourceval=="REQUIREMENT_POPUP"){
                    $_source=ucwords(strtolower(str_ireplace("_"," ",$_sourceval)));
                }
                else{
                    $_source=ucwords(strtolower($_sourceval));
                }
                if(stripos($_primaryintentval,"_")!==false){
                    $_primaryintent=ucwords(strtolower(str_ireplace("_"," ",$_primaryintentval)));
                }
                else{
                    $_primaryintent=ucwords(strtolower($_primaryintentval));
                }
                $_cityqry=DB::connection('mysql_master')->select("select id from re2_cities where name='{$_cityName}'"); 
                $_city = $_cityqry[0]->id;
                //Select Agent Based on Competency Profile...
                $queryFilter="select id,agent_id,city_id,source_1,category,property_types,property_for_1,property_for_2 from re2_agent_competency_profile where source_1 like '%$_source%' and city_id like '%$_city%' and category like '%$_category%' and agent_id='".$_SESSION['userid']."' and (property_for_1 like '%$_primaryintent%' or property_for_2 like '%$_primaryintent%')";
                $agaentDetails= DB::connection('mysql_master')->select($queryFilter);
                $activeagentarray=array();
                if(count($agaentDetails)>=1){
                    foreach($agaentDetails as $agent){
                        $_agentid=$agent->agent_id;
                        $selectagent="select id,agent_id,sip_id,login_status,pick_call_status,status from re2_agent_active where login_status='1' and pick_call_status='1' and status='0' and agent_id='$_agentid'";
                        $_activeagents=DB::connection('mysql_master')->select($selectagent); 
                        if(count($_activeagents)>=1){
                            $activeagentarray['agentid']=$_activeagents[0]->agent_id;
                            $activeagentarray['sipid']=$_activeagents[0]->sip_id;
                            $update_status= DB::connection('mysql_master')->update("update re2_agent_active set status=1 where agent_id='".$_activeagents[0]->agent_id."'");
                            $_mongo2=new MongoController();
                            $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,1,1);
                            $update_reqstatus= DB::connection('mysql_master')->update("update re2_agent_ad_detail set status_call='1' where req_id='".$_getreqid."'");
                            $_selectsipnumber=DB::connection('mysql_master')->select("SELECT sip_number FROM `re2_agent_sip_allotment` where id='".$_activeagents[0]->sip_id."'");
                       
                            if($_SESSION['server_id']==0){
                             $callurl=config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}";
                             $receive_call=file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}");
                              }elseif($_SESSION['server_id']==1){
                               $callurl=config('constants.TELEPHONY_TELESALES_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}";
                                $receive_call=file_get_contents(config('constants.TELEPHONY_TELESALES_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}");
                             }elseif($_SESSION['server_id']==2){
                                $callurl=config('constants.TELEPHONY_DELHI_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}";
                                $receive_call=file_get_contents(config('constants.TELEPHONY_DELHI_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}");
                            }elseif($_SESSION['server_id']==3){
                                $callurl=config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}";
                                $receive_call=file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}");
                             }else{
                                $callurl=config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}";
                                $receive_call=file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}");
                            }

                        }
                    }
                }
            }
        }
     }
    public function breakReason(){
        session_start();
        $val = Request::all();
        $brk_reason=$val['break_reason'];
        $qry=DB::connection('mysql_slave')->select("SELECT * FROM `re2_agent_login_logs` where agent_id='".$_SESSION['userid']."' order by id desc");
        $login_time=$qry[0]->login_time;
        $brk_reason=$val['break_reason'];
        $checkStatus=DB::connection('mysql_slave')->select("Select * from re2_agent_active where agent_id='".$_SESSION['userid']."'");
        $login_status=$checkStatus[0]->login_status;
        if($login_status==1){
            $query=DB::connection('mysql_master')->update("update re2_agent_login_logs set break_reason='$brk_reason',break_time=now() where agent_id='".$_SESSION['userid']."' and logout_time='0000-00-00 00:00:00' and login_time='$login_time'");
             $updatesip= DB::connection('mysql_master')->update("update re2_agent_active set pick_call_status='0',status='0' where agent_id='".$_SESSION['userid']."'");
            $_mongo2=new MongoController();
            $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,0,0);
            $loginlogs= DB::connection('mysql_slave')->select("select * from re2_agent_login_logs where agent_id='".$_SESSION['userid']."' order by id desc");
            $login_time=$loginlogs[0]->login_time;
            $break_time=$loginlogs[0]->break_time;
            $update_log=$_mongo2->updateBreakDetail($_SESSION['userid'],$brk_reason);
            $insertLogs= DB::connection('mysql_master')->insert("INSERT INTO re2_agent_login_logs(`agent_id`, `login_time`,`login_temp`, `created_time`) VALUES ('".$_SESSION['userid']."','$login_time','$break_time',now())");
            $resp['status'] = 'success'; 
        }
        else{
            $resp['status']='logout';
        }
        header('Content-type: application/json');
        echo json_encode($resp);
    }
    public function brkReasonfromLeadform(){
        session_start();
        $val = Request::all();
        $_reqid=$val['req_id'];
        date_default_timezone_set('Asia/Kolkata');
        $updatesip= DB::connection('mysql_master')->update("update re2_agent_active set pick_call_status='0',status='0' where agent_id='".$_SESSION['userid']."'");
        $_mongo2=new MongoController();
        $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,0,0);
        $_call_handlingdetail= DB::connection('mysql_slave')->select("SELECT id,xpora_req_id,telecaller_id,legA_uuid,legB_uuid FROM re2_agent_call_cdr WHERE xpora_req_id='$_reqid' and telecaller_id='{$_SESSION['userid']}' order by id desc limit 0,1");
        if(count($_call_handlingdetail)>=1){
            $colsure_qry= DB::connection('mysql_master')->insert("insert into re2_agent_call_hadling_detail(req_id,agent_id,call_leg_id_A,call_leg_id_B,closure_time) values('$_reqid','{$_SESSION['userid']}','{$_call_handlingdetail[0]->legA_uuid}','{$_call_handlingdetail[0]->legB_uuid}',NOW())");
            $add_acw=$_mongo2->setAfterCallWorktime($_call_handlingdetail[0]->legA_uuid);
        }

        $brk_reason=$val['break_reason'];
        $checkStatus=DB::connection('mysql_slave')->select("Select * from re2_agent_active where agent_id='".$_SESSION['userid']."'");
        $login_status=$checkStatus[0]->login_status;
        if($login_status==1){
            $qry=DB::connection('mysql_slave')->select("SELECT * FROM `re2_agent_login_logs` where agent_id='".$_SESSION['userid']."' order by id desc");
            $login_time=$qry[0]->login_time;
            $query=DB::connection('mysql_master')->update("update re2_agent_login_logs set break_reason='$brk_reason',break_time=now() where agent_id='".$_SESSION['userid']."' and logout_time='0000-00-00 00:00:00' and login_time='$login_time'");
            $loginlogs= DB::connection('mysql_slave')->select("select * from re2_agent_login_logs where agent_id='".$_SESSION['userid']."' order by id desc");
            $login_time=$loginlogs[0]->login_time;
            $break_time=$loginlogs[0]->break_time;
            $update_log=$_mongo2->updateBreakDetail($_SESSION['userid'],$brk_reason);
            $insertLogs= DB::connection('mysql_master')->insert("INSERT INTO re2_agent_login_logs(`agent_id`, `login_time`,`login_temp`, `created_time`) VALUES ('".$_SESSION['userid']."','$login_time','$break_time',now())");
            $resp['status'] = 'success';
        }
        else{
            $resp['status']='logout';
        }
         
        header('Content-type: application/json');
        echo json_encode($resp);
    }
}
