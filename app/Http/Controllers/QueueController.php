<?php
namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use Mookofe\Tail\Facades\Tail;
use DB;
use Mail;
class QueueController extends Controller
{
    public function __construct(){
        $this->apiModel = new Api();
    }
    public function postCallCaseQueue($req_id){
        date_default_timezone_set('Asia/Kolkata');
        $reqArray=array('req_id'=>$req_id,'datetime'=>date('Y-m-d H:i:s'));
        $msg_body = json_encode($reqArray);
        $exchange="RE_Xpora_Post_Call";
        $queue="Xpora_Post_Call_Case";
        $type="fanout";
        Tail::add($queue, $msg_body, array('exchange' => $exchange,'type' =>$type));
    }
    public function xporaPublisher($id,$city,$cust_no,$source){
        $reportingarray=array();
        $data=array();
        $req_id=$id;
        
        //Check City Exist and Routing to Particular Queue
        $result_req=DB::connection('mysql_master')->Select("select id,city_id,source_1 from re2_requirements where id='".$req_id."'");
        if(count($result_req)>=1){
            if(!empty($result_req[0]->city_id)){
                $type="fanout";
                $city_type=$this->checkCity($result_req[0]->city_id);
                //Tiertwo Panindia Others
                if($city_type=='Panindia'){
                    $exchange="RE_Xpora_Panindia_Present_X";
                    $queue="Xpora_Panindia_Present";
                }
                else if($city_type=='Tiertwo'){
                    $exchange="RE_Xpora_Tiertwo_Present_X";
                    $queue="Xpora_Tiertwo_Present";
                }
                else{
                    exit();
                }
                $msg_body = $req_id."_".$city."_".$cust_no."_".$source;
                Tail::add($queue, $msg_body, array('exchange' => $exchange,'type' =>$type));
                $result=DB::connection('mysql_master')->Select("select req_id from re2_agent_ad_detail where req_id='".$req_id."'");
                if(count($result)==0){
                    $res=DB::connection('mysql_master')->Insert("Insert into re2_agent_ad_detail(req_id,city,phone_no,source,req_status,inserted_time) values('".$req_id."','".$city."','".$cust_no."','".$source."','0',NOW())");
                }
                $data['requirement_id']=$id;
                $data['city']=$city;
                $data['customer_no']=$cust_no;
                $data['source']=$source;
                $data['status']="Success";
                $reportingarray[]=$data;
            }
            else{
                $data['status']="Failed! City not Exist";
                $reportingarray[]=$data;
            }
        }
        else{
            $data['status']="Failed! Requirment ID not Exist";
            $reportingarray[]=$data;
        }
        header('Content-type: application/json');
        $result2=json_encode($reportingarray);
        echo $result2;
    }
    public function xporaPublisherFuture($id,$city,$cust_no,$source){
        $reportingarray=array();
        $data=array();
        $req_id=$id;
        $result_req=DB::connection('mysql_master')->Select("select id,city_id,source_1 from re2_requirements where id='".$req_id."'");
        if(count($result_req)>=1){
            if(!empty($result_req[0]->city_id)){
                $type="fanout";
                $city_type=$this->checkCity($result_req[0]->city_id);
                //Tiertwo Panindia Others
                if($city_type=='Panindia'){
                    $exchange="RE_Xpora_Panindia_Future_X";
                    $queue="Xpora_Panindia_Future";
                }
                else if($city_type=='Tiertwo'){
                    $exchange="RE_Xpora_Tiertwo_Future_X";
                    $queue="Xpora_Tiertwo_Future";
                }
                else{
                    exit();
                }
                $msg_body = $req_id."_".$city."_".$cust_no."_".$source;
                Tail::add($queue, $msg_body, array('exchange' => $exchange,'type' =>$type));
                $result=DB::connection('mysql_master')->Select("select req_id from re2_agent_ad_detail where req_id='".$req_id."'");
                if(count($result)==0){
                    $res=DB::connection('mysql_master')->Insert("Insert into re2_agent_ad_detail(req_id,city,phone_no,source,req_status,inserted_time) values('".$req_id."','".$city."','".$cust_no."','".$source."','0',NOW())");
                }
                $data['requirement_id']=$id;
                $data['city']=$city;
                $data['customer_no']=$cust_no;
                $data['source']=$source;
                $data['status']="Success";
            }
            else{
                $data['status']="Failed! City not Exist";
            }
        }
        else{
            $data['status']="Failed! Requirment ID not Exist";
        }
    }
    public function xporaListenerPanindiaPresent(){
        //LIFO Logic
        if(file_exists('lock2')){
            date_default_timezone_set('Asia/Kolkata');
            $date= date_create();
            date_timestamp_set($date,filemtime('lock2'));
            $starttime=(date_format($date,'Y-m-d H:i:s'));
            $endtime=(Date('Y-m-d H:i:s'));
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            if((int)$diff->format('%I')>=5 && (int)$diff->format('%S')>0){
                shell_exec('rm -r lock2');
                $data=array();
                Mail::send('cronReport',$data,function( $message ) use ($data)
                {
                    $emails = array('aman.sinha@quikr.com','saravanan.m@quikr.com');
                    $message->to($emails, "Aman")->subject("XPORA:Cron xporaListenerPanindiaPresent -->".date('d-M-Y')."");
                });
            }

        }
        if(!file_exists('lock2')){
            shell_exec('mkdir lock2');
            $exchange="RE_Xpora_Panindia_Present_X";
            $queue="Xpora_Panindia_Present";
            $options = array(
                'message_limit' => 0,
                'time' => 0,
                'empty_queue_timeout' => 30,
                'empty_check' => 0,
                'stop_queue' => 0,
                'exchange' => $exchange,
                'type' => 'fanout'
            );
            Tail::listenWithOptions($queue, $options, function ($message) {
                $details=explode("_",$message);
                $reqid=$details[0];
                $city=$details[1];
                $phoneno=$details[2];
                $txt=$details[3];
                $_qcheck=DB::connection('mysql_slave')->select("select req_id,call_flag from re2_agent_lifo_queue where req_id='$reqid' and call_flag=0");
                if(count($_qcheck)>=1){
                    $update_lifo=DB::connection('mysql_master')->update("UPDATE re2_agent_lifo_queue set inserted_at=NOW() where req_id='$reqid' and call_flag=0");
                }
                else{
                    $insert_lifo=DB::connection('mysql_master')->insert("INSERT INTO re2_agent_lifo_queue(req_id,queue_msg,inserted_at,call_flag,city_flag) values('".$reqid."','".$message."',NOW(),0,1) ");
                }
            });
            shell_exec('rm -r lock2');
        }
        else{
            shell_exec('exit 1');
        }
    }
    public function xporaListenerTiertwoPresent(){
        //LIFO Logic
        if(file_exists('lock3')){
            date_default_timezone_set('Asia/Kolkata');
            $date= date_create();
            date_timestamp_set($date,filemtime('lock3'));
            $starttime=(date_format($date,'Y-m-d H:i:s'));
            $endtime=(Date('Y-m-d H:i:s'));
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            if((int)$diff->format('%I')>=5 && (int)$diff->format('%S')>0){
                shell_exec('rm -r lock3');
                $data=array();
                Mail::send('cronReport',$data,function( $message ) use ($data)
                {
                    $emails = array('aman.sinha@quikr.com','saravanan.m@quikr.com');
                    $message->to($emails, "Aman")->subject("XPORA:Cron xporaListenerTiertwoPresent--> ".date('d-M-Y')."");
                });
            }

        }
        if(!file_exists('lock3')){
            shell_exec('mkdir lock3');     
            $exchange="RE_Xpora_Tiertwo_Present_X";
            $queue="Xpora_Tiertwo_Present";
            $options = array(
                'message_limit' => 0,
                'time' => 0,
                'empty_queue_timeout' => 30,
                'empty_check' => 0,
                'stop_queue' => 0,
                'exchange' => $exchange,
                'type' => 'fanout'
            );
            Tail::listenWithOptions($queue, $options, function ($message) {
                $details=explode("_",$message);
                $reqid=$details[0];
                $city=$details[1];
                $phoneno=$details[2];
                $txt=$details[3];
                $_qcheck=DB::connection('mysql_slave')->select("select req_id,call_flag from re2_agent_lifo_queue where req_id='$reqid' and call_flag=0");
                if(count($_qcheck)>=1){
                    $update_lifo=DB::connection('mysql_master')->update("UPDATE re2_agent_lifo_queue set inserted_at=NOW() where req_id='$reqid' and call_flag=0");
                }
                else {
                    $insert_lifo = DB::connection('mysql_master')->Insert("INSERT INTO re2_agent_lifo_queue(req_id,queue_msg,inserted_at,call_flag,city_flag) values('" . $reqid . "','" . $message . "',NOW(),0,2) ");
                }
           });
            shell_exec('rm -r lock3');
        }
        else{
            shell_exec('exit 1');
        }
    }
    public function xporaListenerPanindiaFuture(){
        //FIFO Logic
        $exchange="RE_Xpora_Panindia_Future_X";
        $queue="Xpora_Panindia_Future";
        $options = array(
            'message_limit' => 0,
            'time' => 0,
            'empty_queue_timeout' => 30,
            'empty_check' => 0,
            'stop_queue' => 0,
            'exchange' => $exchange,
            'type' => 'fanout'
        );
        Tail::listenWithOptions($queue, $options, function ($message) {
            $details=explode("_",$message);
            $reqid=$details[0];
            $city=$details[1];
            $phoneno=$details[2];
            $txt=$details[3];
            $result_req=DB::connection('mysql_slave')->Select("select id from re2_requirements where id='".$reqid."' AND status='NEW'");
            if(count($result_req)>=1){
                $exchange="RE_Xpora_Panindia_Present_X";
                $type="fanout";
                $queue="Xpora_Panindia_Present";        
                $msg_body = $message;
                Tail::add($queue, $msg_body, array('exchange' => $exchange,'type' =>$type));
            }
            else{
                $result_req=DB::connection('mysql_slave')->Select("select req_id from re2_agent_ad_detail where req_id='".$reqid."' and req_status='1' and assign_status='1'");
                if(count($result_req)==0){
                    //$checkstatus=file_get_contents(config('constants.XPORA_ENDPOINT')."xpora-reloaded/public/RmqAgentAvailability?req_id=$reqid&phone_no=$phoneno");
                    $rmqavailability=new MappingController;
                    $checkstatus=$rmqavailability->rmqAgentAvailability($reqid,$phoneno);
                    if($checkstatus!=0){
                        $call_to_this=explode("_",$checkstatus);
                        $seekerno=$call_to_this[0];
                        $sipnumber=$call_to_this[1];
                        $req_id=$call_to_this[2];
                        $agent_id=$call_to_this[3];
                        $requeueQry=DB::connection('mysql_master')->Select("SELECT id FROM `re2_agent_requeing` where req_id='$req_id' and re_qued='0'");
                        if(count($requeueQry)>=1){
                           $status=$this->queueCall($seekerno,$sipnumber,$req_id,$agent_id,"R");
                        }
                        else{
                           $status=$this->queueCall($seekerno,$sipnumber,$req_id,$agent_id,"F");
                        }
                    }else{
                        $exchange="RE_Xpora_Panindia_Future_X";
                        $type="fanout";
                        $queue="Xpora_Panindia_Future";        
                        $msg_body = $message;
                        Tail::add($queue, $msg_body, array('exchange' => $exchange,'type' =>$type));
                    }
                }
            }
        });
    }
    public function xporaListenerTiertwoFuture(){
        //FIFO Logic
        $exchange="RE_Xpora_Tiertwo_Future_X";
        $queue="Xpora_Tiertwo_Future";
        $options = array(
            'message_limit' => 0,
            'time' => 0,
            'empty_queue_timeout' => 30,
            'empty_check' => 0,
            'stop_queue' => 0,
            'exchange' => $exchange,
            'type' => 'fanout'
        );
        Tail::listenWithOptions($queue, $options, function ($message) {
            $details=explode("_",$message);
            $reqid=$details[0];
            $city=$details[1];
            $phoneno=$details[2];
            $txt=$details[3];
            $result_req=DB::connection('mysql_slave')->Select("select id from re2_requirements where id='".$reqid."' AND status='NEW'");
            if(count($result_req)>=1){
                $exchange="RE_Xpora_Tiertwo_Present_X";
                $type="fanout";
                $queue="Xpora_Tiertwo_Present";        
                $msg_body = $message;
                Tail::add($queue, $msg_body, array('exchange' => $exchange,'type' =>$type));
            }
            else{
                $result_req=DB::connection('mysql_slave')->Select("select req_id from re2_agent_ad_detail where req_id='".$reqid."' and req_status='1' and assign_status='1'");
                if(count($result_req)==0){
                    //$checkstatus=file_get_contents(config('constants.XPORA_ENDPOINT')."xpora-reloaded/public/RmqAgentAvailability?req_id=$reqid&phone_no=$phoneno");
                    $rmqavailability=new MappingController;
                    $checkstatus=$rmqavailability->rmqAgentAvailability($reqid,$phoneno);
                    if($checkstatus!=0){
                        $call_to_this=explode("_",$checkstatus);
                        $seekerno=$call_to_this[0];
                        $sipnumber=$call_to_this[1];
                        $req_id=$call_to_this[2];
                        $agent_id=$call_to_this[3];
                        $requeueQry=DB::connection('mysql_master')->Select("SELECT id FROM `re2_agent_requeing` where req_id='$req_id' and re_qued='0'");
                        if(count($requeueQry)>=1){
                            $status=$this->queueCall($seekerno,$sipnumber,$req_id,$agent_id,"R");
                        }
                        else{
                            $status=$this->queueCall($seekerno,$sipnumber,$req_id,$agent_id,"F");
                        }
                    }else{
                        $exchange="RE_Xpora_Tiertwo_Future_X";
                        $type="fanout";
                        $queue="Xpora_Tiertwo_Future";        
                        $msg_body = $message;
                        Tail::add($queue, $msg_body, array('exchange' => $exchange,'type' =>$type));
                    }
                }
            }
        });
    }
    public function movePresentToFuturePanindia(){
        if(file_exists('lock6')){
            date_default_timezone_set('Asia/Kolkata');
            $date= date_create();
            date_timestamp_set($date,filemtime('lock6'));
            $starttime=(date_format($date,'Y-m-d H:i:s'));
            $endtime=(Date('Y-m-d H:i:s'));
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            if((int)$diff->format('%I')>=5 && (int)$diff->format('%S')>0){
                shell_exec('rm -r lock6');
                $data=array();
                Mail::send('cronReport',$data,function( $message ) use ($data)
                {
                    $emails = array('aman.sinha@quikr.com','saravana.m@quikr.com');
                    $message->to($emails, "Aman")->subject("XPORA:Cron movePresentToFuturePanindia--> ".date('d-M-Y')."");
                });
            }

        }
        ///Move Present To Future Logic..
        if(!file_exists('lock6')){
            shell_exec('mkdir lock6'); 
            $exchange="RE_Xpora_Panindia_Future_X";
            $queue="Xpora_Panindia_Future";
            $options = array(
                'message_limit' => 0,
                'time' => 0,
                'empty_queue_timeout' => 30,
                'empty_check' => 0,
                'stop_queue' => 0,
                'exchange' => $exchange,
                'type' => 'fanout'
            );
            Tail::listenWithOptions($queue, $options, function ($message) {
                $details=explode("_",$message);
                $reqid=$details[0];
                $city=$details[1];
                $phoneno=$details[2];
                $txt=$details[3];
                $result_req=DB::connection('mysql_master')->Select("select id,status from re2_requirements as a,re2_agent_lifo_queue as b where a.id=b.req_id AND b.call_flag=0 AND a.id='$reqid' AND a.status!='NEW'");
                if(count($result_req)>=1){
                    $updateLifo=DB::connection('mysql_master')->update("update re2_agent_lifo_queue set call_flag=2 where req_id='$reqid'");
                    $exchange="RE_Xpora_Panindia_Future_X";
                    $queue="Xpora_Panindia_Future";
                    Tail::add($queue, $message, array('exchange' => $exchange,'type' =>"fanout"));
                }
            });
            shell_exec('rm -r lock6');
        }
        else{
            shell_exec('exit 1');
        }
    }
    public function movePresentToFutureTiertwo(){
        ///Move Present To Future Logic..
        if(file_exists('lock7')){
            date_default_timezone_set('Asia/Kolkata');
            $date= date_create();
            date_timestamp_set($date,filemtime('lock7'));
            $starttime=(date_format($date,'Y-m-d H:i:s'));
            $endtime=(Date('Y-m-d H:i:s'));
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            if((int)$diff->format('%I')>=5 && (int)$diff->format('%S')>0){
                shell_exec('rm -r lock7');
                $data=array();
                Mail::send('cronReport',$data,function( $message ) use ($data)
                {
                    $emails = array('aman.sinha@quikr.com','saravana.m@quikr.com');
                    $message->to($emails, "Aman")->subject("XPORA:Cron movePresentToFutureTiertwo--> ".date('d-M-Y')."");
                });
            }

        }
        if(!file_exists('lock7')){
            shell_exec('mkdir lock7');
            $exchange="RE_Xpora_Tiertwo_Present_X";
            $queue="Xpora_Tiertwo_Present";

            $options = array(
                'message_limit' => 0,
                'time' => 0,
                'empty_queue_timeout' => 30,
                'empty_check' => 0,
                'stop_queue' => 0,
                'exchange' => $exchange,
                'type' => 'fanout'
            );
            Tail::listenWithOptions($queue, $options, function ($message) {
                $details=explode("_",$message);
                $reqid=$details[0];
                $city=$details[1];
                $phoneno=$details[2];
                $txt=$details[3];
                $result_req=DB::connection('mysql_master')->Select("select id,status from re2_requirements as a,re2_agent_lifo_queue as b where a.id=b.req_id AND b.call_flag=0 AND a.id='$reqid' AND a.status!='NEW'");
                if(count($result_req)>=1){
                    $updateLifo=DB::connection('mysql_master')->update("update re2_agent_lifo_queue set call_flag=2 where req_id='$reqid'");
                    $exchange="RE_Xpora_Tiertwo_Future_X";
                    $queue="Xpora_Tiertwo_Future";
                    Tail::add($queue, $message, array('exchange' => $exchange,'type' =>"fanout"));
                }
            });
            shell_exec('rm -r lock7');
        }
        else{
            shell_exec('exit 1');
        }
    }
    public function xporaListenerPresentQueue(){
        $exchange="Real_Estate_Xpora_Present";
        $queue="Xpora_Present_Queue";
        $options = array(
            'message_limit' => 0,
            'time' => 0,
            'empty_queue_timeout' => 30,
            'empty_check' => 0,
            'stop_queue' => 0,
            'exchange' => $exchange,
            'type' => 'fanout'
        );
        Tail::listenWithOptions($queue, $options, function ($message) {
            $details=explode("_",$message);
            $req_id=$details[0];
            $city=$details[1];
            $cust_no=$details[2];
            $source=$details[3];
                //Check City Exist and Routing to Particular Queue
            $result_req=DB::connection('mysql_master')->Select("select id,city_id,source_1 from re2_requirements where id='".$req_id."'");
            if(count($result_req)>=1){
                if(!empty($result_req[0]->city_id)){
                    $type="fanout";
                    $city_type=$this->checkCity($result_req[0]->city_id);
                    //Tiertwo Panindia Others
                    if($city_type=='Panindia'){
                        $exchange="RE_Xpora_Panindia_Present_X";
                        $queue="Xpora_Panindia_Present";
                    }
                    else if($city_type=='Tiertwo'){
                        $exchange="RE_Xpora_Tiertwo_Present_X";
                        $queue="Xpora_Tiertwo_Present";
                    }
                    else{
                        exit();
                    }
                    $msg_body = $req_id."_".$city."_".$cust_no."_".$source;
                    Tail::add($queue, $msg_body, array('exchange' => $exchange,'type' =>$type));
                    $result=DB::connection('mysql_master')->Select("select req_id from re2_agent_ad_detail where req_id='".$req_id."'");
                    if(count($result)==0){
                        $res=DB::connection('mysql_master')->Insert("Insert into re2_agent_ad_detail(req_id,city,phone_no,source,req_status,inserted_time) values('".$req_id."','".$city."','".$cust_no."','".$source."','0',NOW())");
                    }
                }
                else{
                    $data['status']="Failed! City not Exist";
                }
            }
            else{
                $data['status']="Failed! Requirment ID not Exist";
            }
        });
    }
    public function xporaListenerFutureQueue(){
        $exchange="Real_Estate_Xpora_Future";
        $queue="Xpora_Future_Queue";
        $options = array(
            'message_limit' => 0,
            'time' => 0,
            'empty_queue_timeout' => 30,
            'empty_check' => 0,
            'stop_queue' => 0,
            'exchange' => $exchange,
            'type' => 'fanout'
        );
        Tail::listenWithOptions($queue, $options, function ($message) {
            $details=explode("_",$message);
            $req_id=$details[0];
            $city=$details[1];
            $cust_no=$details[2];
            $source=$details[3];
            $result_req=DB::connection('mysql_master')->Select("select id,city_id,source_1 from re2_requirements where id='".$req_id."'");
            if(count($result_req)>=1){
                if(!empty($result_req[0]->city_id)){
                    $type="fanout";
                    $city_type=$this->checkCity($result_req[0]->city_id);
                    //Tiertwo Panindia Others
                    if($city_type=='Panindia'){
                        $exchange="RE_Xpora_Panindia_Future_X";
                        $queue="Xpora_Panindia_Future";
                        $msg_body = $req_id."_".$city."_".$cust_no."_".$source;
                        Tail::add($queue, $msg_body, array('exchange' => $exchange,'type' =>$type));
                        $result=DB::connection('mysql_master')->Select("select req_id from re2_agent_ad_detail where req_id='".$req_id."'");
                        if(count($result)==0){
                            $res=DB::connection('mysql_master')->Insert("Insert into re2_agent_ad_detail(req_id,city,phone_no,source,req_status,inserted_time) values('".$req_id."','".$city."','".$cust_no."','".$source."','0',NOW())");
                        }
                    }
                    else if($city_type=='Tiertwo'){
                        $exchange="RE_Xpora_Tiertwo_Future_X";
                        $queue="Xpora_Tiertwo_Future";
                        $msg_body = $req_id."_".$city."_".$cust_no."_".$source;
                        Tail::add($queue, $msg_body, array('exchange' => $exchange,'type' =>$type));
                        $result=DB::connection('mysql_master')->Select("select req_id from re2_agent_ad_detail where req_id='".$req_id."'");
                        if(count($result)==0){
                            $res=DB::connection('mysql_master')->Insert("Insert into re2_agent_ad_detail(req_id,city,phone_no,source,req_status,inserted_time) values('".$req_id."','".$city."','".$cust_no."','".$source."','0',NOW())");
                        }
                    }
                    else{
                        $exchange="Real_Estate_Xpora_Future";
                        $type="fanout";
                        $queue="Xpora_Future_Queue";        
                        $msg_body = $message;
                        Tail::add($queue, $msg_body, array('exchange' => $exchange,'type' =>$type));
                    }
                    
                }
                else{
                    $data['status']="Failed! City not Exist";
                }
            }
            else{
                $data['status']="Failed! Requirment ID not Exist";
            }
            
        });
    }

    public function printserverd($agent_id){
        $_sipnumber= DB::connection('mysql_slave')->select("SELECT sip_id,sip_number,server_id FROM `re2_agent_active` as a,re2_agent_sip_allotment as b where a.sip_id=b.id and a.agent_id='".$agent_id."'");
        if(count($_sipnumber)==1){
          return $_sipnumber[0]->server_id;
        }
        else{
          return 0;
        }
   }
    /**
     * @param $_customerno
     * @param $sipnumber
     * @param $req_id
     * @param $agent_id
     * @param $queue
     */
    public function queueCall($_customerno, $sipnumber, $req_id, $agent_id, $queue){
        if($_customerno!='') {
            $_customernoold = str_ireplace("_", "", $_customerno);
            if (stripos($_customernoold, '-') !== false) {
                $_customernonew = explode("-", $_customernoold);
                $_customerno = $_customernonew[1];
            } else {
                $_customerno = $_customernoold;
            }
            if (!empty($req_id)) {
                $options = array(
                    'encrypted' => true
                );
                $pusher = new \Pusher(
                    config('constants.PUSHER_API_KEY'),
                    config('constants.PUSHER_API_SECRET'),
                    config('constants.PUSHER_APP_ID'),
                    $options
                );
                $data['message'] = 'Open Lead Form';
                $data['req_id'] = $req_id;
                $agentidnew = $agent_id . "012345_Leadform";
                $pusher->trigger($agentidnew, "my_event_open_leadform", $data);
            }
        $serverid=$this->printserverd($agent_id);

        if($serverid==0){
         $result = file_get_contents(config('constants.TELEPHONY_ENDPOINT') . "voice_api/clicktocall_manual.php?caller_number=$_customerno&called_number=$sipnumber&xpora_req_id=$req_id&telecaller_id=$agent_id&call_queue=$queue");
          }elseif($serverid==1){
          $result = file_get_contents(config('constants.TELEPHONY_TELESALES_ENDPOINT') . "voice_api/clicktocall_manual.php?caller_number=$_customerno&called_number=$sipnumber&xpora_req_id=$req_id&telecaller_id=$agent_id&call_queue=$queue"); 
          }elseif($serverid==2){
          $result = file_get_contents(config('constants.TELEPHONY_DELHI_ENDPOINT') . "voice_api/clicktocall_manual.php?caller_number=$_customerno&called_number=$sipnumber&xpora_req_id=$req_id&telecaller_id=$agent_id&call_queue=$queue");

          }elseif($serverid==3){
         $result = file_get_contents(config('constants.TELEPHONY_ENDPOINT') . "voice_api/clicktocall_manual.php?caller_number=$_customerno&called_number=$sipnumber&xpora_req_id=$req_id&telecaller_id=$agent_id&call_queue=$queue");
         }else{
            $result = file_get_contents(config('constants.TELEPHONY_ENDPOINT') . "voice_api/clicktocall_manual.php?caller_number=$_customerno&called_number=$sipnumber&xpora_req_id=$req_id&telecaller_id=$agent_id&call_queue=$queue");
        }
     }
    }
    public function checkQueueEmpty($exchangename,$queuename){
        $exchange=$exchangename;//$exchange="Real_Estate_Xpora_Present";
        $queue=$queuename;//$queue="Xpora_Present_Queue";
        $options = array(
            'message_limit' => 0,
            'time' => 0,
            'empty_queue_timeout' => 30,
            'empty_check' => 1,
            'stop_queue' => 0,
            'exchange' => $exchange,
            'type' => 'fanout'
        );
       Tail::listenWithOptions($queue, $options, function ($message) {
       });
    }
    
    public function stopConsumeQueue($exchangename,$queuename){
        $exchange=$exchangename;//$exchange="Real_Estate_Xpora_Present";
        $queue=$queuename;//$queue="Xpora_Present_Queue";
        $options = array(
            'message_limit' => 0,
            'time' => 0,
            'empty_queue_timeout' => 30,
            'empty_check' => 0,
            'stop_queue' => 1,
            'exchange' => $exchange,
            'type' => 'fanout'
        );
       Tail::listenWithOptions($queue, $options, function ($message) {
        });
    }
    public function cronQueuePanindia(){
        //First Condition Login , Pick Call and Not in Call
        if(file_exists('lock4')){
            date_default_timezone_set('Asia/Kolkata');
            $date= date_create();
            date_timestamp_set($date,filemtime('lock4'));
            $starttime=(date_format($date,'Y-m-d H:i:s'));
            $endtime=(Date('Y-m-d H:i:s'));
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            if((int)$diff->format('%I')>=5 && (int)$diff->format('%S')>0){
                shell_exec('rm -r lock4');
                file_put_contents('./croncheck.txt','CronQueuePanindia morethan 5min'.date("Y-M-d h:i:s")."\n",FILE_APPEND);
            }
        }
        if(!file_exists('lock4')){
            shell_exec('mkdir lock4');
            $checkquery=DB::connection('mysql_slave')->Select("select id,agent_id from re2_agent_active where login_status=1 and pick_call_status=1 and status=0 ORDER BY RAND( )");
            if(count($checkquery)>=1){
                $_tccitys="";
                foreach($checkquery as $valtc){
                    $cityidsqry=DB::connection('mysql_slave')->Select("select id,agent_id,city_id from re2_agent_competency_profile where agent_id='".$valtc->agent_id."'");
                    if(count($cityidsqry)>=1){
                        $chkarray=explode(",",$_tccitys);
                        if(count($chkarray)<=10){
                            $_tccitys.=$cityidsqry[0]->city_id;
                        }
                    }
                }
                if(!empty($_tccitys)){
                    $tccityarray=explode(",",$_tccitys);
                    $tccityarrayunique=array_unique($tccityarray);
                    $city_names=array();
                    foreach($tccityarrayunique as $cityids){
                        $city_result= DB::connection('mysql_slave')->select("select id,name from re2_cities where id='".$cityids."'");
                        if(count($city_result)>=1){
                            $city_names[]=$city_result[0]->name;
                        }
                    }
                    $_callextraqrynew="";
                    if(count($city_names)>=1){
                        foreach($city_names as $city_val){
                        $_callextraqrynew.="(select req_id,queue_msg from re2_agent_lifo_queue where `queue_msg` like '%".$city_val."%' and call_flag=0 and city_flag=1 order by inserted_at desc LIMIT 4)";
                        $_callextraqrynew.=" UNION ALL ";
                        }
                        $_callextraqrynew=substr($_callextraqrynew, 0, -11);
                    }
                    //file_put_contents('./checknew.txt', "$_callextraqrynew", FILE_APPEND);

                    $_callextraqry="";
                    if(count($city_names)>=1){
                        $_callextraqry.=" AND (";
                        foreach($city_names as $city_val){
                            $_callextraqry.=" queue_msg like '%".$city_val."%' OR";
                        }
                        $_callextraqry=substr($_callextraqry, 0, -2);
                        $_callextraqry.=")";
                    }

                    if(!empty($_callextraqrynew)){
                        $checkLifo = DB::connection('mysql_slave')->Select($_callextraqrynew);
                    }
                    else {
                        $checkLifo=DB::connection('mysql_slave')->Select("select req_id,queue_msg from re2_agent_lifo_queue where call_flag=0 and city_flag=1 order by inserted_at desc limit 0,120");
                    }
                    //Check Present Queue(Lifo) Table Call Flag is 0
                    //file_put_contents('./checkquery1.txt', "select req_id,queue_msg from re2_agent_lifo_queue where call_flag=0 and city_flag=1 $_callextraqry order by inserted_at desc limit 0,120", FILE_APPEND);
                    //$checkLifo=DB::connection('mysql_master')->Select("select req_id,queue_msg from re2_agent_lifo_queue where call_flag=0 and city_flag=1 $_callextraqry order by inserted_at desc limit 0,120");
                }
                else{
                    $checkLifo=DB::connection('mysql_master')->Select("select req_id,queue_msg from re2_agent_lifo_queue where call_flag=0 and city_flag=1 order by inserted_at desc limit 0,120");    
                }
                if(count($checkLifo)>=1){
                    //Competency Profile Matching...
                    foreach($checkLifo as $lifo){
                        $details=explode("_",$lifo->queue_msg);
                        $cityname=$details[1];
                        $cityname=str_ireplace("_","",$cityname);
                        $phoneno=$details[2];
                        $phoneno=str_ireplace("_","",$phoneno);
                        $reqid=$lifo->req_id;
                        $q="PQ"; //Present QUEUE
                        $call_case_pre_call = $this->preCallCaseCheck($reqid);
                        if ($call_case_pre_call == 1) {
                            $call_case = $this->callCasecheck($reqid, $cityname, $phoneno, $q);
                            if ($call_case == 1) {
                                $rmqavailability = new MappingController();
                                $checkstatus = $rmqavailability->rmqAgentAvailability($reqid, $phoneno);
                                if ($checkstatus != 0) {
                                    $call_to_this = explode("_", $checkstatus);
                                    $seekerno = $call_to_this[0];
                                    $sipnumber = $call_to_this[1];
                                    $req_id = $call_to_this[2];
                                    $agent_id = $call_to_this[3];
                                    $updateLifo = DB::connection('mysql_master')->update("update re2_agent_lifo_queue set call_flag=1 where req_id='$req_id'");
                                    $status = $this->queueCall($seekerno, $sipnumber, $req_id, $agent_id, "P");
                                }
                            } else {
                                $updateLifo = DB::connection('mysql_master')->update("update re2_agent_lifo_queue set call_flag=1 where req_id='$req_id'");
                                $updateaddetail = DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='" . $req_id . "'");
                            }
                        }
                        else{
                            $updateLifo = DB::connection('mysql_master')->update("update re2_agent_lifo_queue set call_flag=1 where req_id='$reqid'");
                            $updateLifo = DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='" . $reqid . "'");
                        }
                    }
                }
                else{
                    //Run Future Queue
                    $_future_q_status1=$this->xporaListenerPanindiaFuture();
                }
            }
            shell_exec('rm -r lock4');
        }
        else{
            shell_exec('exit 1');
        }
    }
    public function cronQueueTiertwo(){
        //First Condition Login , Pick Call and Not in Call
        if(file_exists('lock5')){
            date_default_timezone_set('Asia/Kolkata');
            $date= date_create();
            date_timestamp_set($date,filemtime('lock5'));
            $starttime=(date_format($date,'Y-m-d H:i:s'));
            $endtime=(Date('Y-m-d H:i:s'));
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            if((int)$diff->format('%I')>=5 && (int)$diff->format('%S')>0){
                shell_exec('rm -r lock5');
                file_put_contents('./croncheck.txt','CronQueueTier2 morethan 5min'.date("Y-M-d h:i:s")."\n",FILE_APPEND);
            }

        }
        if(!file_exists('lock5')){
            shell_exec('mkdir lock5');
            $checkquery=DB::connection('mysql_slave')->Select("select id,agent_id from re2_agent_active where login_status=1 and pick_call_status=1 and status=0 ORDER BY RAND()");
            if(count($checkquery)>=1){
                $_tccitys="";
                foreach($checkquery as $valtc){
                    $cityidsqry=DB::connection('mysql_slave')->Select("select id,agent_id,city_id from re2_agent_competency_profile where agent_id='".$valtc->agent_id."'");
                    if(count($cityidsqry)>=1){
                        $chkarray=explode(",",$_tccitys);
                        if(count($chkarray)<=15){
                            $_tccitys.=$cityidsqry[0]->city_id;
                        }
                    }
                }
                if(!empty($_tccitys)){
                    $tccityarray=explode(",",$_tccitys);
                    $tccityarrayunique=array_unique($tccityarray);
                    $city_names=array();
                    foreach($tccityarrayunique as $cityids){
                        $city_result= DB::connection('mysql_slave')->select("select id,name from re2_cities where id='".$cityids."'");
                        if(count($city_result)>=1){
                            $city_names[]=$city_result[0]->name;
                        }
                    }
                    $_callextraqrynew="";
                    if(count($city_names)>=1){
                        foreach($city_names as $city_val){
                            $_callextraqrynew.="(select req_id,queue_msg from re2_agent_lifo_queue where `queue_msg` like '%".$city_val."%' and call_flag=0 and city_flag=2 order by inserted_at desc LIMIT 4)";
                            $_callextraqrynew.=" UNION ALL ";
                        }
                        $_callextraqrynew=substr($_callextraqrynew, 0, -11);
                    }
                    //file_put_contents('./checknew.txt', "$_callextraqrynew", FILE_APPEND);

                    $_callextraqry="";
                    if(count($city_names)>=1){
                        $_callextraqry.=" AND (";
                        foreach($city_names as $city_val){
                            $_callextraqry.=" queue_msg like '%".$city_val."%' OR";
                        }
                        $_callextraqry=substr($_callextraqry, 0, -2);
                        $_callextraqry.=")";
                    }

                    if(!empty($_callextraqrynew)){
                        $checkLifo = DB::connection('mysql_slave')->Select($_callextraqrynew);
                    }
                    else {
                        $checkLifo=DB::connection('mysql_slave')->Select("select req_id,queue_msg from re2_agent_lifo_queue where call_flag=0 and city_flag=2 $_callextraqry order by inserted_at desc limit 0,120");
                    }
                    //Check Present Queue(Lifo) Table Call Flag is 0
                    //file_put_contents('./checkquery1.txt', "select req_id,queue_msg from re2_agent_lifo_queue where call_flag=0 and city_flag=1 $_callextraqry order by inserted_at desc limit 0,120", FILE_APPEND);
                    //$checkLifo=DB::connection('mysql_slave')->Select("select req_id,queue_msg from re2_agent_lifo_queue where call_flag=0 and city_flag=2 $_callextraqry order by inserted_at desc limit 0,120");
                }
                else{
                    $checkLifo=DB::connection('mysql_slave')->Select("select req_id,queue_msg from re2_agent_lifo_queue where call_flag=0 and city_flag=2 order by inserted_at desc limit 0,120");
                }
                if(count($checkLifo)>=1){
                    //Competency Profile Matching...
                    foreach($checkLifo as $lifo) {
                        $details = explode("_", $lifo->queue_msg);
                        $cityname = $details[1];
                        $cityname = str_ireplace("_", "", $cityname);
                        $phoneno = $details[2];
                        $phoneno = str_ireplace("_", "", $phoneno);
                        $reqid = $lifo->req_id;
                        $q = "PQ"; //Present QUEUE
                        $call_case_pre_call = $this->preCallCaseCheck($reqid);
                        if ($call_case_pre_call == 1) {
                            $call_case = $this->callCasecheck($reqid, $cityname, $phoneno, $q);
                            if ($call_case == 1) {
                                $rmqavailability = new MappingController();
                                $checkstatus = $rmqavailability->rmqAgentAvailability($reqid, $phoneno);

                                if ($checkstatus != 0) {
                                    $call_to_this = explode("_", $checkstatus);
                                    $seekerno = $call_to_this[0];
                                    $sipnumber = $call_to_this[1];
                                    $req_id = $call_to_this[2];
                                    $agent_id = $call_to_this[3];
                                    $updateLifo = DB::connection('mysql_master')->update("update re2_agent_lifo_queue set call_flag=1 where req_id='$req_id'");
                                    $status = $this->queueCall($seekerno, $sipnumber, $req_id, $agent_id, "P");
                                }
                            } else {
                                $updateLifo = DB::connection('mysql_master')->update("update re2_agent_lifo_queue set call_flag=1 where req_id='$req_id'");
                                $updateLifo = DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='" . $req_id . "'");
                            }
                        }
                        else{
                            $updateLifo = DB::connection('mysql_master')->update("update re2_agent_lifo_queue set call_flag=1 where req_id='$reqid'");
                            $updateLifo = DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='" . $reqid . "'");
                        }
                    }
                }
                else{
                    //Run Future Queue
                    $_future_q_status1=$this->xporaListenerTiertwoFuture();
                }
            }
            shell_exec('rm -r lock5');
        }
        else{
            shell_exec('exit 1');
        }

    }
    public function checkCity($cityid){
        $tiertwocityarray = array(22,24,31,33,121001,123106,124103,125001,125055,132222,134102,136118,140110,141001,142222,143104,
        144001,152222,162222,171206,172222,173215,175101,176036,176316,180001,182222,190001,194101,201002,201301,201310,
        208001,211001,221002,225402,243001,244302,248003,248179,250002,263001,263601,281001,282002,301019,305001,313001,334001,342001,
        360001,361001,382010,390001,393110,400601,400701,402305,403108,413001,415002,416001,422001,431001,444001,462001,474003,482004,483775,495001,
        721301,751001,753001,781001,793001,796001,797001,800001,826001,831001,834002,1015661,1015841,1016021,1016561,1016741,1017101,1018001,1018181,1018721,
        1019081,1019261,1019621,1020161,1020341,1020881,1021061,1021241,1021421,1021601,1021781,1022321,1022501,1022681,1023041,1023221,1023401,1023761,1023941,1024481,1025201,1025381,1025741,1025921,1026101,1026281,
        1026641,1027541,1027721,1028441,1029881,1031861,1033301,1033661,1034021,1034561,1034921,1035641,1035821,1036361,1036541,1037621,1037981,
        1038161,1038341,1038881,1039061,1039241,1039961,1040142,1040322,1040502,1040682,1041222,1041402,1041762,1042122,
        1042842,1043742,1043922,1044102,1046982,1058322,1058502,1058682,1058862,1059222,1059402,1059582,1059942,1060122,1060302,1060662,
        1060842,1061022,1061202,1061743,1061923,1062103,1062283,1062643,1063003,1063363,1063903,1064083,1064263,1064623,1064803,1064983,1065163,1065343,
        1065523,1065703,1065883,1066063,1066243,1066423,1066783,1067503,1068763,1069123,1069483,1069843,1070383,1070923,1071283,1071463,1072723,1072903,1073803,1073983,1074343,1075063,1075423,1075603,1075963,1076323,1077763,1077943,
        1078123,1078303,1078663,1079383,1079743,1080463,1081003,1081183,1081543,1081723,1082083,1082983,1083343,1083523,1083883,1084243,1084423,1084783,1085863,1086043,1086403,1086583,1087123,1088023,1088383,1088563,1088923,1089103,1089283,1089463,1089643,
        1089823,1090183,1090363,1090543,1090723,1091083,1091443,1091623,1091803,1092163,1092883,1093423,1093603,1093783,1094323,1094503,1095043,
        1095223,1108363,1108723,1108903,1109263,1109443,1109623,1109803,1110163,1110883,1111243,1111423,1112503,1112683,1112863,1113043,1113403,1113583,
        1113763,1114303,1114663,1114843,1115023,1115203,1115563,1115923,1116103,1116463,1117723,1117903,1118263,1118443,1118623,1119163,1120063,1121143,
        1121503,1121683,1122223,1122583,1122943,1123843,1124023,1124923,1125463,1126003,1126183,1126723,1127803,1128523,1130143,1131763,1132483,1133563,1135723,1136263,1138783,1141123,1141483,1142923,1144903
        );
        $panindiacityarray = array(23,25,26,27,28,29,30,32,506002,520001,524101,531001,575001,580020,590001,605001,620015,625001,629161,632001,636001,
        680001,695001,1000001,1000721,1002341,1003961,1005401,1005761,1006301,1006841,1007921,1008821,1010441,1012061,1012781,1014221,1014941,1046082,
        1046442,1046802,1047702,1048062,1048422,1048782,1049322,1049682,1049862,1050582,1050762,1051122,1051302,1051842,1052742,1053642,1053822,1054182,
        1055262,1055442,1055802,1055982,1056162,1056882,1097743,1098283,1098463,1098643,1099183,1099723,1100083,
        1100623,1101703,1102063,1102423,1103683,1104223,1105123,1105303,1105663,1106383,1106743,1106923,1108003);
        if(in_array($cityid, $tiertwocityarray)){
            return "Tiertwo";
        }
        else if(in_array($cityid, $panindiacityarray)){
            return "Panindia";
        }
        else{
            return "Others";
        }
    }
    public function callCasecheck($reqid,$city,$phoneno,$q){
        /**
         * @ta total attempts till to Date
         * @ad attempts in a Day(Today)
         * @minattempt from call_cases table
         */
        $select_ta=DB::connection('mysql_slave')->Select("select count(id) as ta from re2_agent_call_cdr where xpora_req_id='$reqid' AND caller_no='$phoneno'");
        $_ta=$select_ta[0]->ta;
        $select_ad=DB::connection('mysql_slave')->Select("select count(id) as ad from re2_agent_call_cdr where xpora_req_id='$reqid' AND caller_no='$phoneno' and DATE(timestamp)=DATE(NOW())");
        $_ad=$select_ad[0]->ad;
        $source="wanted";//Text
        if($_ta>10){
            //2Moths After Call
            return 0;
        }
        else if($_ad>5 && $q=='PQ'){
            //Push it to future Queue
            $push_to_future_q=$this->xporaPublisherFuture($reqid,$city,$phoneno,$source);
            return 0;
        }
        else{
            // CALL
            $userDisposition=DB::connection('mysql_slave')->select("select status from re2_requirements where id='".$reqid."'");
            if($userDisposition[0]->status=='NEW'){
                //DIALER DISPOSITION CHECK
                $select_dd=DB::connection('mysql_slave')->Select("select legA_hcause,legB_hcause from re2_agent_call_cdr where xpora_req_id='$reqid' AND caller_no='$phoneno' order by id desc limit 0,1");
                if(count($select_dd)==1){
                    $ddheck=DB::connection('mysql_slave')->select("SELECT * FROM `re2_agent_call_cases` where dialer_disposition ='".$select_dd[0]->legB_hcause."'");
                    if(count($ddheck)>=1){
                        if($ddheck[0]->min_attempt!=0 && $_ad>=$ddheck[0]->min_attempt && $ddheck[0]->action==0){
                            //Move It to Future Queue
                            $push_to_future_q=$this->xporaPublisherFuture($reqid,$city,$phoneno,$source);
                            return 0;
                        }
                        else{
                            return 1;
                        }
                    }
                    else{
                        return 1;
                    }
                }
                else{
                    return 1;
                }
            }
            else{
                return 1;
            }
        }
    }
    public function preCallCaseCheck($req_id){
        /**
         * @js Just Spoken
         * @tdnc Temporarily DNC
         */
        $tempdnc_array=array();
        $js_array=array();
        $mongoQuery = array();
        $resp=array();
        $mongoQuery['req_detail.id'] = (int)$req_id;
        $mongocon=new MongoController();
        $connection = $mongocon->mongoConnection();
        $db = $connection->real_estate;
        $collection = new \MongoCollection($db, 're2_agent_call_detail_report');
        $result = $collection->find($mongoQuery,array('req_detail.phone1' => 1,'req_detail.status' => 1, 'call_datetime' => 1))->sort(array('call_datetime' => -1))->limit(1);
        $resultcount = $collection->find($mongoQuery)->count();
        if($resultcount>=1) {
            foreach ($result as $res) {
                $resp_disposition = $res['req_detail']['status'];
                $resp_phone = $res['req_detail']['phone1'];
                $call_date = $res['call_datetime'];
            }
            $ddheck1 = DB::connection('mysql_slave')->select("SELECT action_before_call FROM `re2_agent_call_cases` where user_disposition='$resp_disposition'");
                if (count($ddheck1) >= 1) {
                    $ddheck = DB::connection('mysql_slave')->select("SELECT * FROM `re2_agent_call_cases` where user_disposition is NOT NULL");
                    foreach ($ddheck as $rs) {
                        if ($rs->just_spoken == '1') {
                            $js_array[] = $rs->user_disposition;
                        } else {
                            if ($rs->temp_dnc == '1') {
                                $tempdnc_array[] = $rs->user_disposition;
                            }
                        }
                    }

                    date_default_timezone_set('Asia/Kolkata');
                    $endtimec = date("Y-m-d H:i:s");
                    $startc = new \DateTime("$call_date");
                    $endc = new \DateTime("$endtimec");
                    $diffc = $startc->diff($endc);
                    $noofdays = $diffc->format("%a");
                    if (in_array($resp_disposition, $js_array) && $noofdays < 2) {
                        return 0;
                    } else {
                        if (in_array($resp_disposition, $tempdnc_array) && $noofdays < $ddheck1[0]->action_before_call) {
                            return 0;
                        } else {
                            return 1;
                        }
                    }
                } else {
                    return 1;
                }
            }
        else {
            return 1;
        }
    }
    public function postCallQueueListener(){
        //$reqArray=array('req_id'=>$req_id,'datetime'=>date('Y-m-d H:i:s'));
        //$msg_body = json_encode($reqArray);
        $exchange="RE_Xpora_Post_Call";
        $queue="Xpora_Post_Call_Case";
        $options = array(
            'message_limit' => 0,
            'time' => 0,
            'empty_queue_timeout' => 30,
            'empty_check' => 0,
            'stop_queue' => 0,
            'exchange' => $exchange,
            'type' => 'fanout'
        );
        Tail::listenWithOptions($queue, $options, function ($message) {
            $msg=json_decode($message);
            if(!empty($msg->req_id)){
                $callcaselogic=$this->checkPostCallCase($msg->req_id,$msg->datetime);
            }
        });
    }
    public function checkPostCallCase($reqid,$datetime){
        $_queuecontroller = new QueueController;
        //GET PHONE CITY STATUS from Requirements..
        $userDisposition=DB::connection('mysql_slave')->select("select city_id,phone_1_id,status from re2_requirements where id='".$reqid."'");
        $city_id=$userDisposition[0]->city_id;
        $cityQry=DB::connection('mysql_slave')->Select("Select id,name from re2_cities where id='$city_id'");
        $city=$cityQry[0]->name;
        $phone_id=$userDisposition[0]->phone_1_id;
        $phneQry=DB::connection('mysql_slave')->Select("Select type,value from re2_user_contacts where id='$phone_id'");
        if(count($phneQry)==1) {
            $phoneno = $phneQry[0]->value;
            $source = "wanted";//Text

            $select_ta = DB::connection('mysql_slave')->Select("select count(id) as ta from re2_agent_call_cdr where xpora_req_id='$reqid' AND caller_no='$phoneno'");
            $_ta = $select_ta[0]->ta;
            $select_ad = DB::connection('mysql_slave')->Select("select count(id) as ad from re2_agent_call_cdr where xpora_req_id='$reqid' AND caller_no='$phoneno' and DATE(timestamp)=DATE(NOW())");
            $_ad = $select_ad[0]->ad;

            if ($_ta > 10) {
                //2Moths After Call
                return 0;
            } else if ($_ad > 5) {
                //Push it to future Queue
                $result = $_queuecontroller->xporaPublisherFuture($reqid, $city, $phoneno, $source);
                return 0;
            } else {
                if ($userDisposition[0]->status != 'NEW') {
                    $udheck = DB::connection('mysql_slave')->select("SELECT * FROM `re2_agent_call_cases` where user_disposition='" . $userDisposition[0]->status . "'");
                    if (count($udheck) >= 1) {
                        if ($udheck[0]->min_attempt == 0 && $udheck[0]->action != 0) {
                            //Take Action : Re-attempt back based on action
                            $no_of_days = $udheck[0]->action;
                            date_default_timezone_set('Asia/Kolkata');
                            $reattemptTime = date('Y-m-d H:i:s', strtotime($datetime . "+$no_of_days days"));
                            $reattempt_qry = DB::connection('mysql_master')->insert("INSERT INTO re2_agent_re_attempt(req_id,phone_no,re_attempt_time,added_datetime) values('" . $reqid . "','" . $phoneno . "','" . $reattemptTime . "',NOW())");
                            $updateaddetail = DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='" . $reqid . "'");
                            return 0;
                        } else if ($udheck[0]->min_attempt != 0 && $_ad >= $udheck[0]->min_attempt && $udheck[0]->action == 0) {
                            //Move It to Future Queue
                            $result = $_queuecontroller->xporaPublisherFuture($reqid, $city, $phoneno, $source);
                            $updateaddetail = DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='" . $reqid . "'");
                            return 0;
                        } else if ($udheck[0]->min_attempt != 0 && $_ad >= $udheck[0]->min_attempt && $udheck[0]->action != 0) {
                            //Take Action : Re-attempt back based on action
                            $no_of_days = $udheck[0]->action;
                            date_default_timezone_set('Asia/Kolkata');
                            $reattemptTime = date('Y-m-d H:i:s', strtotime($datetime . "+$no_of_days days"));
                            $reattempt_qry = DB::connection('mysql_master')->insert("INSERT INTO re2_agent_re_attempt(req_id,phone_no,re_attempt_time,added_datetime) values('" . $reqid . "','" . $phoneno . "','" . $reattemptTime . "',NOW())");
                            $updateaddetail = DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='" . $reqid . "'");
                            return 0;
                        } else {
                            //Move It to Future Queue
                            $result = $_queuecontroller->xporaPublisherFuture($reqid, $city, $phoneno, $source);
                            $updateaddetail = DB::connection('mysql_master')->delete("delete from re2_agent_ad_detail where req_id='" . $reqid . "'");
                            return 0;
                        }
                    } else {
                        return 1;
                    }
                }
            }
        }
    }
}

?>