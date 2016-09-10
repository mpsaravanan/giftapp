<?php
namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;

class MappingController extends Controller
{
    public function __construct(){
        $this->apiModel = new Api();
    }
    public function mappingCompetency(){
        session_start();
        $_selectqry=DB::connection('mysql_master')->select("select id,req_id,phone_no from re2_agent_ad_detail where req_status='0' order by updated_time desc limit 0,1"); 
        foreach($_selectqry as $_addetails){
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
                //if($_sourceval=="WANT_AD" || $_sourceval=="REQUIREMENT_POPUP"){
                    $_source=ucwords(strtolower(str_ireplace("_"," ",$_sourceval)));
                //}else{
                //    $_source=ucwords(strtolower($_sourceval));
                //}
                if(stripos($_primaryintentval,"_")!==false){
                    $_primaryintent=ucwords(strtolower(str_ireplace("_"," ",$_primaryintentval)));
                }else{
                    $_primaryintent=ucwords(strtolower($_primaryintentval));
                }
                
                $_cityqry=DB::connection('mysql_master')->select("select id from re2_cities where name='{$_cityName}'"); 
                $_city = $_cityqry[0]->id;
                $queryFilter="select id,agent_id,city_id,source_1,category,property_types,property_for_1,property_for_2 from re2_agent_competency_profile where source_1 like '%$_source%' and city_id like '%$_city%' and category like '%$_category%' and (property_for_1 like '%$_primaryintent%' or property_for_2 like '%$_primaryintent%')";
                $log=$queryFilter." CALL LOG Started  \n";
                file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
                $agaentDetails= DB::connection('mysql_master')->select($queryFilter);
                $activeagentarray=array();
                if(count($agaentDetails)>=1){
                    foreach($agaentDetails as $agent){
                        //$log=$agent->agent_id."CALL LOG AGENT Matched \n";
                        //file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
                        $_agentid=$agent->agent_id;
                        $selectagent="select id,agent_id,sip_id,login_status,pick_call_status,status from re2_agent_active where login_status='1' and pick_call_status='1' and status='0' and agent_id='$_agentid'";
                        $_activeagents=DB::connection('mysql_master')->select($selectagent); 
                        if(count($_activeagents)>=1){
                            $activeagentarray['agentid']=$_activeagents[0]->agent_id;
                            $activeagentarray['sipid']=$_activeagents[0]->sip_id;
                            $update_status= DB::connection('mysql_master')->update("update re2_agent_active set status=1 where agent_id='".$_activeagents[0]->agent_id."'");
                            $_mongo2=new MongoController();
                            $_insert=$_mongo2->updateCurrentStatus($_activeagents[0]->agent_id);
                            //$update_reqstatus= DB::connection('mysql_master')->update("update re2_agent_ad_detail set status_call='1' where req_id='".$_getreqid."'");
                            $_selectsipnumber=DB::connection('mysql_master')->select("SELECT sip_number FROM `re2_agent_sip_allotment` where id='".$_activeagents[0]->sip_id."'");
                            $log=$_customerno." - ".$_selectsipnumber[0]->sip_number." - "." - ".$_getreqid." - ".$_activeagents[0]->agent_id."  CALL LOG \n";
                            file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
                            // echo "http://192.168.141.30/voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}";
                            if($_SESSION['server_id']==0){
                              $callurl=config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}";
                             }elseif($_SESSION['server_id']==1){
                             $callurl=config('constants.TELEPHONY_TELESALES_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}";
                             
                              }elseif($_SESSION['server_id']==2){
                             $callurl=config('constants.TELEPHONY_DELHI_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}";
                             
                              }elseif($_SESSION['server_id']==3){
                              $callurl=config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}";
                             }else{
                             $callurl=config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}";
                              }
                             //file_put_contents('./log_'.date("j.n.Y").'.txt', $callurl, FILE_APPEND);
                            //$receive_call=file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}");
                        }
                    }
                }
            }
        }
    }
    public function rmqAgentAvailability($_getreqid,$_customerno){
        //$_id = Request::all();
        //$_getreqid = $_id['req_id'];
        //$_customerno = $_id['phone_no'];
        //Get Requirement Id Details..
        $result=$this->apiModel->getRequirement($_getreqid);
        $result1=$result['response'];
        $result2=json_decode($result1);
        if($result2->statusCode=="200" && $result2->message=="success" && $result2->data!="NULL" && !empty($result2->data)){
            $_reqid = $result2->data->id;
            $_sourceval = $result2->data->source1;
            $_category = $result2->data->category;
            $_proptype = $result2->data->propertyTypes;
            $_cityName = $result2->data->cityName;
            $_primaryintentval = $result2->data->transactionType;
            $_source=ucwords(strtolower(str_ireplace("_"," ",$_sourceval)));
            if(stripos($_primaryintentval,"_")!==false){
                $_primaryintent=ucwords(strtolower(str_ireplace("_"," ",$_primaryintentval)));
            }else{
                $_primaryintent=ucwords(strtolower($_primaryintentval));
            }
            
            $_cityqry=DB::connection('mysql_master')->select("select id from re2_cities where name='{$_cityName}'"); 
            $_city = $_cityqry[0]->id;
            $queryFilter="select id,agent_id,city_id,source_1,category,property_types,property_for_1,property_for_2 from re2_agent_competency_profile where source_1 like '%$_source%' and FIND_IN_SET('$_city',city_id) and category like '%$_category%' and (property_for_1 like '%$_primaryintent%' or property_for_2 like '%$_primaryintent%')";
            $agaentDetails= DB::connection('mysql_master')->select($queryFilter);
            $activeagentarray=array();

            if(count($agaentDetails)>=1){
                $_agentidsarray=array();
                foreach($agaentDetails as $agent){
                    $_agentidsarray[]=$agent->agent_id;
                }
                $agentids=implode(",",$_agentidsarray);
                $selectagent="select id,agent_id,sip_id,login_status,pick_call_status,status from re2_agent_active where login_status='1' and pick_call_status='1' and status='0' and agent_id in ($agentids)";
                $_activeagents=DB::connection('mysql_master')->select($selectagent); 
                if(count($_activeagents)>=1){
                    $activeagentarray['agentid']=$_activeagents[0]->agent_id;
                    $activeagentarray['sipid']=$_activeagents[0]->sip_id;
                    $update_status= DB::connection('mysql_master')->update("update re2_agent_active set status=1 where agent_id='".$_activeagents[0]->agent_id."'");
                    $_mongo2=new MongoController();
                    $_insert=$_mongo2->updateCurrentStatus($_activeagents[0]->agent_id,1,1,1);
                    $_selectsipnumber=DB::connection('mysql_master')->select("SELECT sip_number FROM `re2_agent_sip_allotment` where id='".$_activeagents[0]->sip_id."'");
                    return $_customerno."_".$_selectsipnumber[0]->sip_number."_".$_getreqid."_".$_activeagents[0]->agent_id;
                    //$receive_call=file_get_contents(config('constants.TELEPHONY_ENDPOINT')."voice_api/clicktocall.php?caller_number={$_customerno}&called_number={$_selectsipnumber[0]->sip_number}&xpora_req_id={$_getreqid}&telecaller_id={$_activeagents[0]->agent_id}");
                }
                else{
                    return 0;
                }
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }
    }
}
