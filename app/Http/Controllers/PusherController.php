<?php
namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;

class PusherController extends Controller
{
    public function __construct(){
        $this->apiModel = new Api();
    }
    public function triggerPusher($agentid,$sipnumber,$req_id,$callerno,$lagA_uuid,$lagB_uuid,$call_mode){
        //echo "$agentid,$sipnumber,$req_id,$callerno";
        session_start();
        if(!empty($agentid) && !empty($sipnumber) && !empty($req_id)){
            $options = array(
                  'encrypted' => true
                );
                $pusher = new \Pusher(
                  config('constants.PUSHER_API_KEY'),
                  config('constants.PUSHER_API_SECRET'),
                  config('constants.PUSHER_APP_ID'),
                  $options
                );
                
                $data['message'] = 'Are you ready to Connect to this Call';
                $data['req_id'] = $req_id;
                $data['lagAuuid'] = $lagA_uuid;
                $data['lagBuuid'] = $lagB_uuid;
                $data['agentid'] = $agentid;
                //0 -  automatic call , 1 - Manual Call...
                $data['call_modenew'] = $call_mode;
                $pusher->trigger($agentid, "my_event", $data);
                echo 1;
        }
    }
    public function triggerPusherfailed($agentid,$sipnumber,$req_id,$callerno,$lagA_uuid,$lagB_uuid){
        //echo "$agentid,$sipnumber,$req_id,$callerno";
        if(!empty($agentid) && !empty($sipnumber) && !empty($req_id)){
            $options = array(
                  'encrypted' => true
                );
                $pusher = new \Pusher(
                  config('constants.PUSHER_API_KEY'),
                  config('constants.PUSHER_API_SECRET'),
                  config('constants.PUSHER_APP_ID'),
                  $options
                );
                
                $data['message'] = 'Are you ready to Connect to this Call';
                $data['req_id'] = $req_id;
                $agentidnew=$agentid."012345";
                $pusher->trigger($agentidnew, "my_eventfailed", $data);
                echo 0;
        }
    }
    public function manualCallProcessing($agentid,$staus,$lagAuuid){
        if(!empty($agentid) ){
                    $options = array(
                          'encrypted' => true
                        );
                        $pusher = new \Pusher(
                            config('constants.PUSHER_API_KEY'),
                            config('constants.PUSHER_API_SECRET'),
                            config('constants.PUSHER_APP_ID'),
                            $options
                        );
                        
                        $data['message'] = 'Manual_call_processing';
                        $data['lagAuiid_id']=$lagAuuid;
                        if($staus==0){
                            $data['status'] = "Dialing";
                        }else if($staus==1){
                            $data['status'] = "Ringing";
                        }else if($staus==2){
                            $data['status'] = "Answered";
                        }else if($staus==3){
                            $data['status'] = "Disconnected";
                        }
                        else{
                            $data['status'] = "Error";
                        }
                        $agentidnew=$agentid."012345_call";
                        $pusher->trigger($agentidnew, "my_event_callprocessing", $data);
                }
        }
}
