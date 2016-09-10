<?php
namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;

class CdrDataController extends Controller
{
    public function __construct(){
        $this->apiModel = new Api();
    }
    public function addCdr(){
        $_cdr = Request::all();
        $result= DB::connection('mysql_master')->insert("INSERT INTO `re2_agent_call_cdr`(`call_uuid`, `legA_uuid`, `legB_uuid`, `start_datetime_legA`, `ring_datetime_legA`, `answer_datetime_legA`, `end_datetime_legA`, `start_datetime_legB`, `ring_datetime_legB`, `answer_datetime_legB`, `end_datetime_legB`, `recording_url`, `xpora_req_id`, `telecaller_id`, `legA_hcause`, `legB_hcause`, `caller_no`, `called_no`, `fs_caller_number`, `fs_called_number`,`call_mode`, `call_queue`) VALUES ('".$_cdr['call_uuid']."','".$_cdr['legA_uuid']."','".$_cdr['legB_uuid']."','".$_cdr['start_datetime_legA']."','".$_cdr['ring_datetime_legA']."','".$_cdr['answer_datetime_legA']."','".$_cdr['end_datetime_legA']."','".$_cdr['start_datetime_legB']."','".$_cdr['ring_datetime_legB']."','".$_cdr['answer_datetime_legB']."','".$_cdr['end_datetime_legB']."','".$_cdr['recording_url']."','".$_cdr['xpora_req_id']."','".$_cdr['telecaller_id']."','".$_cdr['legA_hcause']."','".$_cdr['legB_hcause']."','".$_cdr['caller_no']."','".$_cdr['called_no']."','".$_cdr['fs_caller_number']."','".$_cdr['fs_called_number']."','".$_cdr['call_mode']."','".$_cdr['call_queue']."')");
        $_mongo=new MongoController();
        $insert_into_mongo=$_mongo->setAgentCallReqDetail($_cdr['call_uuid'],$_cdr['legA_uuid'],$_cdr['legB_uuid'],$_cdr['start_datetime_legA'],$_cdr['ring_datetime_legA'],$_cdr['answer_datetime_legA'],$_cdr['end_datetime_legA'],$_cdr['start_datetime_legB'],$_cdr['ring_datetime_legB'],$_cdr['answer_datetime_legB'],$_cdr['end_datetime_legB'],$_cdr['recording_url'],$_cdr['xpora_req_id'],$_cdr['telecaller_id'],$_cdr['legA_hcause'],$_cdr['legB_hcause'],$_cdr['caller_no'],$_cdr['called_no'],$_cdr['call_queue']);
        if($result){
            $agent_id=$_cdr['telecaller_id'];
            $incall_status=DB::connection('mysql_master')->Update("Update re2_agent_active set incall='0' where agent_id='$agent_id'");
            $_mongo2=new MongoController();
            $_insert=$_mongo2->updateCurrentStatus($agent_id,1,1,1);
            $req_id=$_cdr['xpora_req_id'];
            $phone_no=$_cdr['caller_no'];
            $cause_codeA=$_cdr['legA_hcause'];
            $cause_codeB=$_cdr['legB_hcause'];
            if($cause_codeA=='SERVICE_UNAVAILABLE' || $cause_codeA=='UNALLOCATED_NUMBER' || $cause_codeA=='INVALID_NUMBER_FORMAT' || $cause_codeA=='DESTINATION_OUT_OF_ORDER' || $cause_codeB=='SERVICE_UNAVAILABLE' || $cause_codeB=='UNALLOCATED_NUMBER' || $cause_codeB=='INVALID_NUMBER_FORMAT' || $cause_codeB=='DESTINATION_OUT_OF_ORDER'){
                $agent_ad=DB::connection('mysql_master')->Update("Update re2_agent_ad_detail set req_status='2', assign_status='2' where req_id='$req_id' and phone_no='$phone_no'");
            }
            echo 1;
        }
        else{
            echo 0;
        }
    }
}
