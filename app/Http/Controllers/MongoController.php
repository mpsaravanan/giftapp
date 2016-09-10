<?php
namespace App\Http\Controllers;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;
class MongoController extends Controller
{
    public function __construct(){
        $this->apiModel = new Api();
    }

    /**
     * Mongo DB Connection
     */
    public function mongoConnection(){
        $connection = new \MongoClient("mongodb://".config('constants.MONGO_ENDPOINT'),array("replicaSet" => config('constants.MONGO_REPLICA')));
        return $connection;
    }

    /**
     * set Agent details and Competency Profile changes
     * @MongoCollection: re2_agent_call_report
     */
    public function addAgentUserDetail(){
        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection = $connection->real_estate->re2_agent_detail_report;
        $condition=array();
        $result=$collection->find($condition);
        $exist_array=array();
        foreach ($result as $_agent){
            $exist_array[] = $_agent['agent_id'];
        }
        $selqry=DB::connection('mysql_slave')->Select("select id,emp_id,name,reporting_to,is_deleted from re2_agent_login where level=3");
        if(count($selqry)>=1){
            foreach ($selqry as $ag) {
                if (!in_array($ag->id, $exist_array)) {
                    $tl_detail = DB::connection('mysql_slave')->select("select id,emp_id,name,reporting_to from re2_agent_login where id='" . $ag->reporting_to . "'");
                    $mgr_detail = DB::connection('mysql_slave')->select("select id,emp_id,name,reporting_to from re2_agent_login where id='" . $tl_detail[0]->reporting_to . "'");
                    if ($selqry[0]->is_deleted == 1) {
                        $agent_status = "Deleted";
                    } else {
                        $agent_status = "Active";
                    }
                    $competency_detail = DB::connection('mysql_slave')->select("select id,city_id,locality_ids,project_ids,source_1,category,property_for_1 from re2_agent_competency_profile where agent_id='" . $ag->id . "'");
                    if (count($competency_detail) >= 1) {
                        $cityIds=$competency_detail[0]->city_id;
                        $sel_city=DB::connection('mysql_slave')->select("select id,name from re2_cities where id in($cityIds)");
                        $_comp_cityidarray=array();
                        $_comp_citynamearray=array();
                        if(count($sel_city)>=1){
                            foreach($sel_city as $citydetail){
                                $_comp_cityidarray[]= $citydetail->id;
                                $_comp_citynamearray[]= $citydetail->name;
                            }
                        }
                        $_comp_source_array=explode(",",$competency_detail[0]->source_1);
                        $_comp_locations_array=explode(",",$competency_detail[0]->locality_ids);
                        $_comp_project_array=explode(",",$competency_detail[0]->project_ids);
                        $_comp_pri_int_array=explode(",",$competency_detail[0]->property_for_1);
                        $_comp_sec_int_array=explode(",",$competency_detail[0]->category);

                        $agent_doc = array(
                            "agent_id" => (int)$ag->id,
                            "agent_name" => (string)$ag->name,
                            "agent_emp_id" => (int)$ag->emp_id,
                            "agent_tl" => (string)$tl_detail[0]->name,
                            "agent_manager" => (string)$mgr_detail[0]->name,
                            "agent_status" => (string)$agent_status,
                            "agent_competency" => array(
                                "city_ids" => $_comp_cityidarray,
                                "city_names" => $_comp_citynamearray,
                                "sources" => $_comp_source_array,
                                "locations" => $_comp_locations_array,
                                "projects" => $_comp_project_array,
                                "primary_intent" => $_comp_pri_int_array,
                                "seocndary_intent" => $_comp_sec_int_array,
                            ),
                            "current_status" => array()
                        );
                        $result = $collection->insert($agent_doc);
                    }
                }
            }
        }
    }

    /**
     * Update Agent details and Competency Profile changes
     * @MongoCollection: re2_agent_call_report
     */
    public function updateAgentUserDetail($agent_id){
        $selqry=DB::connection('mysql_slave')->Select("select id,emp_id,name,reporting_to,is_deleted from re2_agent_login where id='$agent_id'");
        if(count($selqry)==1){
            $tl_detail=DB::connection('mysql_slave')->select("select id,emp_id,name,reporting_to from re2_agent_login where id='".$selqry[0]->reporting_to."'");
            $mgr_detail=DB::connection('mysql_slave')->select("select id,emp_id,name,reporting_to from re2_agent_login where id='".$tl_detail[0]->reporting_to."'");
            if($selqry[0]->is_deleted==1){
                $agent_status="Deleted";
            }else{
                $agent_status="Active";
            }
            $competency_detail = DB::connection('mysql_slave')->select("select id,city_id,locality_ids,project_ids,source_1,category,property_for_1 from re2_agent_competency_profile where agent_id='" . $selqry[0]->id . "'");
            if (count($competency_detail) >= 1) {
                $cityIds = $competency_detail[0]->city_id;
                $sel_city = DB::connection('mysql_slave')->select("select id,name from re2_cities where id in($cityIds)");
                $_comp_cityidarray=array();
                $_comp_citynamearray=array();
                if(count($sel_city)>=1){
                    foreach($sel_city as $citydetail){
                        $_comp_cityidarray[]= $citydetail->id;
                        $_comp_citynamearray[]= $citydetail->name;
                    }
                }
                $_comp_source_array = explode(",", $competency_detail[0]->source_1);
                $_comp_locations_array = explode(",", $competency_detail[0]->locality_ids);
                $_comp_project_array = explode(",", $competency_detail[0]->project_ids);
                $_comp_pri_int_array = explode(",", $competency_detail[0]->property_for_1);
                $_comp_sec_int_array = explode(",", $competency_detail[0]->category);
                //Mongo Connection..
                $connection = $this->mongoConnection();
                $db = $connection->real_estate;
                $collection = $connection->real_estate->re2_agent_detail_report;
                $result = $collection->update(array("agent_id" => (int)$agent_id),
                    array('$set'=>array(
                        "agent_name" => (string)$selqry[0]->name,
                        "agent_emp_id" => (int)$selqry[0]->emp_id,
                        "agent_tl" => (string)$tl_detail[0]->name,
                        "agent_manager" => (string)$mgr_detail[0]->name,
                        "agent_status" => (string)$agent_status,
                        "agent_competency" => array(
                            "city_ids" => $_comp_cityidarray,
                            "city_names" => $_comp_citynamearray,
                            "sources" => $_comp_source_array,
                            "locations" => $_comp_locations_array,
                            "projects" => $_comp_project_array,
                            "primary_intent" => $_comp_pri_int_array,
                            "seocndary_intent" => $_comp_sec_int_array
                        )
                    )
                ));
            }
        }
    }

    /**
     * set CDR Call Detail, Req Detail and VL Detail
     * @MongoCollection: re2_agent_call_report
     */
    public function setAgentCallReqDetail($_uuid,$_legA_uuid,$_legB_uuid,$_start_datetime_legA,$_ring_datetime_legA,$_answer_datetime_legA,$_end_datetime_legA,$_start_datetime_legB,$_ring_datetime_legB,$_answer_datetime_legB,$_end_datetime_legB,$_recording_url,$_xpora_req_id,$_telecaller_id,$_legA_hcause,$_legB_hcause,$_caller_no,$_called_no,$_call_queue)
    {
        $_start_datetime_legA = str_ireplace("_", " ", $_start_datetime_legA);
        $_ring_datetime_legA = str_ireplace("_", " ", $_ring_datetime_legA);
        $_answer_datetime_legA = str_ireplace("_", " ", $_answer_datetime_legA);
        $_end_datetime_legA = str_ireplace("_", " ", $_end_datetime_legA);
        $_start_datetime_legB = str_ireplace("_", " ", $_start_datetime_legB);
        $_ring_datetime_legB = str_ireplace("_", " ", $_ring_datetime_legB);
        $_answer_datetime_legB = str_ireplace("_", " ", $_answer_datetime_legB);
        $_end_datetime_legB = str_ireplace("_", " ", $_end_datetime_legB);

        //GET Requirement Id  Details...
        $result=$this->apiModel->getRequirement($_xpora_req_id);
        $result1=$result['response'];
        $status=$result['status'];
        if($status=="200") {
            $result2 = json_decode($result1);
            if($result2->statusCode=='200'){
                date_default_timezone_set('Asia/Kolkata');
                if(!empty($result2->data)) {
                    $result2->data->createdDate = date('Y-m-d H:i:s', $result2->data->createdDate/1000);
                }
                $req_detail=$result2->data;
            }
            else{
                $req_detail=array();
            }
        }
        else{
            $req_detail=array();
        }
        $qry_city=DB::connection('mysql_slave')->select("SELECT city_id  FROM re2_requirements where id='".$_xpora_req_id."'");
        if(count($qry_city)==1){
            $cityId=$qry_city[0]->city_id;
        }
        else{
            $cityId="";
        }
        //GET CALL Duration and Ring Duration
        $_call_duration="00:00:00";
        $_talk_time="00:00:00";
        $_actual_talk_time="00:00:00";
        $_ring_duration="00:00:00";
        if(!empty($_start_datetime_legA) && $_start_datetime_legA!='nil' && $_start_datetime_legA!='0000-00-00 00:00:00' && $_end_datetime_legB!='0000-00-00 00:00:00' && $_end_datetime_legB!='nil'  && !empty($_end_datetime_legB)){
            $starttimec= $_start_datetime_legA;
            $endtimec= $_end_datetime_legB;
            $startc = new \DateTime("$starttimec");
            $endc = new \DateTime("$endtimec");
            $diffc = $startc->diff($endc);
            $_call_duration=$diffc->format('%H').":".$diffc->format('%I').":".$diffc->format('%S');
        }
        if(!empty($_answer_datetime_legA) && $_answer_datetime_legA!='nil' && $_answer_datetime_legA!='0000-00-00 00:00:00' && $_end_datetime_legB!='0000-00-00 00:00:00' && $_end_datetime_legB!='nil'  && !empty($_end_datetime_legB)){
            $starttimet= $_answer_datetime_legA;
            $endtimet= $_end_datetime_legB;
            $startt = new \DateTime("$starttimet");
            $endt = new \DateTime("$endtimet");
            $difft = $startc->diff($endt);
            $_talk_time=$difft->format('%H').":".$difft->format('%I').":".$difft->format('%S');
        }
        if(!empty($_answer_datetime_legB) && $_answer_datetime_legB!='nil' && $_answer_datetime_legB!='0000-00-00 00:00:00' && $_end_datetime_legB!='0000-00-00 00:00:00' && $_end_datetime_legB!='nil' && !empty($_end_datetime_legB)){
            $starttime= $_answer_datetime_legB;
            $endtime= $_end_datetime_legB;
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            $_actual_talk_time=$diff->format('%H').":".$diff->format('%I').":".$diff->format('%S');
        }
        if(!empty($_answer_datetime_legB) && $_answer_datetime_legB!='nil' && $_answer_datetime_legB!='0000-00-00 00:00:00' && $_ring_datetime_legB!='0000-00-00 00:00:00' && $_ring_datetime_legB!='nil'  && !empty($_ring_datetime_legB)){
            $starttime1= $_ring_datetime_legB;
            $endtime1= $_answer_datetime_legB;
            $start1 = new \DateTime("$starttime1");
            $end1 = new \DateTime("$endtime1");
            $diff1 = $start1->diff($end1);
            $_ring_duration=$diff1->format('%H').":".$diff1->format('%I').":".$diff1->format('%S');
        }
        date_default_timezone_set('Asia/Kolkata');
        $_call_time=date("Y-m-d h:i:s");

        $adagentDetails=DB::connection('mysql_master')->Select("Select a.id,a.end_datetime_legB,b.closure_time from re2_agent_call_cdr as a,re2_agent_call_hadling_detail as b where a.call_uuid=b.call_leg_id_A and a.call_uuid='".$_uuid."'");
        if(count($adagentDetails)>=1) {
            $_call_disposition=$adagentDetails[0]->call_disposition;
        }
        else{
            $_call_disposition="NULL";
        }
        $getcausecode=new ViewController();
        $_hangupcause=$getcausecode->getHangupCause($_legB_hcause);
        $holdtime=$this->setHoldtime($_uuid);
        //Agent Detail.
        $_agent_detail=$this->getAgentdetailforCall($_telecaller_id);
        $call_doc = array(
            "call_uuid" => "{$_uuid}",
            "legA_uuid"=>"{$_legA_uuid}",
            "legB_uuid"=>"{$_legB_uuid}",
            "legAstart_time"=>"{$_start_datetime_legA}",
            "legAring_time"=>"{$_ring_datetime_legA}",
            "legAanswer_time"=>"{$_answer_datetime_legA}",
            "legAend_time"=>"{$_end_datetime_legA}",
            "legBstart_time"=>"{$_start_datetime_legB}",
            "legBring_time"=>"{$_ring_datetime_legB}",
            "legBanswer_time"=>"{$_answer_datetime_legB}",
            "legBend_time"=>"{$_end_datetime_legB}",
            "ring_duration"=>"{$_ring_duration}",
            "call_duration"=>"{$_call_duration}",
            "talk_time"=>"{$_talk_time}",
            "actual_talk_time"=>"{$_actual_talk_time}",
            "recording_url"=>"{$_recording_url}",
            "lead_sent"=>"NULL",
            "call_disposition"=>"{$_call_disposition}",
            "customer_no"=>"{$_caller_no}",
            "sip_no" =>"{$_called_no}",
            "call_datetime"=>"{$_call_time}",
            "call_queue"=>"{$_call_queue}",
            "legA_hcause"=>"{$_hangupcause}",
            "acw_time" => "00:00:00",
            "hold_time" => "{$holdtime}",
            "city_id"=>(int)$cityId,
            "req_detail" => $req_detail,
            "agent_detail" => $_agent_detail,
            "lead_detail" => array()
        );

        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection = $connection->real_estate->re2_agent_call_detail_report;
        $result = $collection->insert($call_doc);

    }
    public function getAgentdetailforCall($agent_id){
        $selqry=DB::connection('mysql_slave')->Select("select id,emp_id,name,reporting_to,is_deleted from re2_agent_login where id='$agent_id'");
        if(count($selqry)==1) {
            $tl_detail = DB::connection('mysql_slave')->select("select id,emp_id,name,reporting_to from re2_agent_login where id='" . $selqry[0]->reporting_to . "'");
            $mgr_detail = DB::connection('mysql_slave')->select("select id,emp_id,name,reporting_to from re2_agent_login where id='" . $tl_detail[0]->reporting_to . "'");
            if ($selqry[0]->is_deleted == 1) {
                $agent_status = "Deleted";
            } else {
                $agent_status = "Active";
            }
            $agent_detail=array(
                "agent_id"=>(int)$selqry[0]->id,
                "agent_name" => (string)$selqry[0]->name,
                "agent_emp_id" => (int)$selqry[0]->emp_id,
                "agent_tl" => (string)$tl_detail[0]->name,
                "agent_manager" => (string)$mgr_detail[0]->name,
                "agent_status" => (string)$agent_status
            );
            return $agent_detail;
        }
        else{
            return array();
        }
    }

    /**
     * Update Call UUID Based Req Detail
     * @MongoCollection: re2_agent_call_report
     */
    public function updateCallReqDetail($uuid,$req_id)
    {
        $result=$this->apiModel->getRequirement($req_id);
        $result1=$result['response'];
        $status=$result['status'];
        if($status=="200") {
            $result2 = json_decode($result1);
            if($result2->statusCode=='200'){
                date_default_timezone_set('Asia/Kolkata');
                if(!empty($result2->data)) {
                    $result2->data->createdDate = date('Y-m-d H:i:s', $result2->data->createdDate/1000);
                }
                $req_detail=$result2->data;
            }
            else{
                $req_detail=array();
            }
        }
        else{
            $req_detail=array();
        }
        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection = $connection->real_estate->re2_agent_call_detail_report;
        $result = $collection->update(array("call_uuid" => "$uuid"),
            array('$set'=>array('req_detail'=>$req_detail)));
    }

    /**
     * Update Agent Current Status(Login ,Logout, Pick call and Incall Status)
     * @MongoCollection: re2_agent_call_report
     */
    public function updateCurrentStatus($agent_id,$login_status,$pick_call_status,$call_status)
    {
        $current_doc=array(
            "login_status"=>$login_status,
            "pick_call_status"=>$pick_call_status,
            "call_status"=>$call_status,
        );
        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection = $connection->real_estate->re2_agent_detail_report;
        $result = $collection->update(array("agent_id" => (int)$agent_id),
            array('$set'=>array('current_status'=>$current_doc)));
    }

    /**
     * set ACW(After Call Work..) Time Calculation
     * @MongoCollection: re2_agent_call_report
     */
    public function setAfterCallWorktime($uuid='N')
    {
        if($uuid!='N'){
            $sel_qry=DB::connection('mysql_slave')->Select("SELECT a.end_datetime_legB,b.call_leg_id_A,b.closure_time from re2_agent_call_cdr as a,re2_agent_call_hadling_detail as b where a.call_uuid=b.call_leg_id_A and a.call_uuid='".$uuid."'");
            if(count($sel_qry)==1){
                if(!empty($sel_qry[0]->end_datetime_legB) && $sel_qry[0]->end_datetime_legB!='0000-00-00 00:00:00' && $sel_qry[0]->closure_time!='0000-00-00 00:00:00'  && !empty($sel_qry[0]->closure_time)){
                    $starttime1= $sel_qry[0]->end_datetime_legB;
                    $endtime1= $sel_qry[0]->closure_time;
                    $start1 = new \DateTime("$starttime1");
                    $end1 = new \DateTime("$endtime1");
                    $diff1 = $start1->diff($end1);
                    $acw_time=$diff1->format('%H').":".$diff1->format('%I').":".$diff1->format('%S');

                    $connection=$this->mongoConnection();
                    $db = $connection->real_estate;
                    $collection = $connection->real_estate->re2_agent_call_detail_report;
                    $result = $collection->update(array("call_uuid" => "{$uuid}"),
                        array('$set'=>array('acw_time'=>"{$acw_time}")));
                }
            }
            else{
                $acw_time="00:00:00";
                $sel_qry=DB::connection('mysql_slave')->Select("SELECT end_datetime_legB from re2_agent_call_cdr where call_uuid='".$uuid."'");
                if(count($sel_qry)==1) {
                    $sel_qry2 = DB::connection('mysql_slave')->Select("SELECT logout_time,break_time from re2_agent_login_logs where agent_id='" . $_SESSION['userid'] . "' order by id desc limit 0,1");
                    if (count($sel_qry2) >= 1) {
                        $d1 = new \DateTime($sel_qry[0]->end_datetime_legB);
                        $d2 = new \DateTime($sel_qry2[0]->break_time);
                        if (!empty($sel_qry[0]->end_datetime_legB) && $sel_qry[0]->end_datetime_legB != '0000-00-00 00:00:00' && $sel_qry2[0]->break_time != '0000-00-00 00:00:00' && !empty($sel_qry2[0]->break_time) && ($d1 < $d2)) {
                            $starttime1 = $sel_qry[0]->end_datetime_legB;
                            $endtime1 = $sel_qry2[0]->break_time;
                            $start1 = new \DateTime("$starttime1");
                            $end1 = new \DateTime("$endtime1");
                            $diff1 = $start1->diff($end1);
                            $acw_time = $diff1->format('%H') . ":" . $diff1->format('%I') . ":" . $diff1->format('%S');
                        }
                        else{
                            $d1 = new \DateTime($sel_qry[0]->end_datetime_legB);
                            $d3 = new \DateTime($sel_qry2[0]->logout_time);
                            if (!empty($sel_qry[0]->end_datetime_legB) && $sel_qry[0]->end_datetime_legB != '0000-00-00 00:00:00' && $sel_qry2[0]->logout_time != '0000-00-00 00:00:00' && !empty($sel_qry2[0]->logout_time) && ($d1 < $d3)) {
                                $starttime1 = $sel_qry[0]->end_datetime_legB;
                                $endtime1 = $sel_qry2[0]->logout_time;
                                $start1 = new \DateTime("$starttime1");
                                $end1 = new \DateTime("$endtime1");
                                $diff1 = $start1->diff($end1);
                                $acw_time = $diff1->format('%H') . ":" . $diff1->format('%I') . ":" . $diff1->format('%S');
                            }
                        }
                        $connection = $this->mongoConnection();
                        $db = $connection->real_estate;
                        $collection = $connection->real_estate->re2_agent_call_detail_report;
                        $result = $collection->update(array("call_uuid" => "{$uuid}"),
                            array('$set' => array('acw_time' => "{$acw_time}")));
                    }
                }
            }
        }
    }

    /**
     * set Hold Time
     * @MongoCollection: re2_agent_call_report
     * @return string
     */
    public function setHoldtime($uuid='N')
    {
        $final_hold_time="00:00:00";
        if($uuid!='N') {
            $sel_qry = DB::connection('mysql_slave')->Select("SELECT hold_status,hold_time from re2_agent_hold_call where legA_uuid='" . $uuid . "'");
            if (count($sel_qry) >= 1) {
                $shold=array();
                $ehold=array();
                $shold_total='';
                $ehold_total='';
                foreach($sel_qry as $hold){
                    if($hold->hold_status==1 && !empty($hold->hold_time)){
                        $stime = date("H:i:s",strtotime($hold->hold_time));
                        $shold[]=$stime;
                    }
                    if($hold->hold_status==0 && !empty($hold->hold_time)){
                        $etime = date("H:i:s",strtotime($hold->hold_time));
                        $ehold[]=$etime;
                    }
                }
                if(!empty($shold) && !empty($ehold)){
                    $shold_total=$this->sum_the_time($shold);
                    $ehold_total=$this->sum_the_time($ehold);
                }
                if(!empty($shold_total) && $shold_total!='00:00:00:' && !empty($ehold_total) && $ehold_total!='00:00:00:') {
                    $time1 = new \DateTime($shold_total);
                    $time2 = new \DateTime($ehold_total);
                    $interval = $time1->diff($time2);
                    $final_hold_time=$interval->format("%H:%I:%S");
                }
            }
        }
        return $final_hold_time;
    }

    /**
     * Sum of times
     * @param array
     * @return string
     */
    public function sum_the_time($times) {
        $seconds = 0;
        if(!empty($times)){
            foreach ($times as $time)
            {
                
                list($hour,$minute,$second) = explode(':', $time);
                $seconds += $hour*3600;
                $seconds += $minute*60;
                $seconds += $second;
            }
            $hours = floor($seconds/3600);
            $seconds -= $hours*3600;
            $minutes  = floor($seconds/60);
            $seconds -= $minutes*60;
            // return "{$hours}:{$minutes}:{$seconds}";
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Thanks to Patrick
        }
        else{
            return "00:00:00";
        }
    }

    /**
     * Update Login DateTime Details In Log Report
     * @MongoCollection: re2_agent_log_report
     */
    public function updateLoginDetail($agent_id)
    {
        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection = $connection->real_estate->re2_agent_log_detail_report;

        date_default_timezone_set('Asia/Kolkata');
        $_todaydate=date("Y-m-d");
        $logintime =date("Y-m-d H:i:s");
        //Agent Detail.
        $_agent_detail=$this->getAgentdetailforCall($agent_id);
        $sel_qry = DB::connection('mysql_slave')->Select("SELECT agent_id,login_time from re2_agent_login_logs where agent_id='".$agent_id."' and created_time>=CURDATE() order by id desc");
        if (count($sel_qry)== 1) {
               $newdata = array("datetime"=>date("Y-m-d", strtotime($_todaydate)),
                    "login_time"=>array($logintime),
                    "agent_detail" => $_agent_detail
                );
                $result=$collection->insert($newdata);
        }
        else{
                $newdata = array(
                    '$push' =>
                        array("login_time" => "{$logintime}")
                );
                $result=$collection->update(array("agent_detail.agent_id" => (int)$agent_id,"datetime"=>"{$_todaydate}"), $newdata);
        }
    }

    /**
     * Update Logout DateTime Details In Log Report
     * @MongoCollection: re2_agent_log_report
     */
    public function updateLogoutDetail($agent_id)
    {
        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection = $connection->real_estate->re2_agent_log_detail_report;

        date_default_timezone_set('Asia/Kolkata');
        $_todaydate=date("Y-m-d");
        $logouttime =date("Y-m-d H:i:s");
        $newdata = array(
            '$push' =>
                array("logout_time" => "{$logouttime}","end_break_time" => "{$logouttime}")
        );

        $result=$collection->update(array("agent_detail.agent_id" => (int)$agent_id,"datetime"=>"{$_todaydate}"), $newdata);
    }

    /**
     * Update Pick Call DateTime Details In Log Report
     * @MongoCollection: re2_agent_log_report
     */
    public function updatePickCallDetail($agent_id)
    {
        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection = $connection->real_estate->re2_agent_log_detail_report;
        date_default_timezone_set('Asia/Kolkata');
        $_todaydate=date("Y-m-d");
        $pick_call_time =date("Y-m-d H:i:s");
        $newdata = array(
            '$push' =>
                array("pick_call_time" => "{$pick_call_time}","end_break_time" => "{$pick_call_time}")
        );
        $result=$collection->update(array("agent_detail.agent_id" => (int)$agent_id,"datetime"=>"{$_todaydate}"), $newdata);
    }

    /**
     * Update Break Datetime and Reason Details In Log Report
     * @MongoCollection: re2_agent_log_report
     */
    public function updateBreakDetail($agent_id,$break_reason)
    {
        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection = $connection->real_estate->re2_agent_log_detail_report;
        date_default_timezone_set('Asia/Kolkata');
        $_todaydate=date("Y-m-d");
        $break_time =date("Y-m-d H:i:s");
        $breakarray =array('break_time'=>"{$break_time}",'break_reason'=>"{$break_reason}");
        $newdata = array(
            '$push' =>
                array("break" => $breakarray)
        );
        $result=$collection->update(array("agent_detail.agent_id" => (int)$agent_id,"datetime"=>"{$_todaydate}"), $newdata);
    }

    public function check(){
        $_uuid="e5f87d64-53c7-11e6-9045-9fda9a798fe3";
        $_legA_uuid="e5f87d64-53c7-11e6-9045-9fda9a798fe3";
        $_legB_uuid="e5f87d64-53c7-11e6-9045-9fda9a798fe3";
        $_start_datetime_legA="2016-07-28 12:31:10";
        $_ring_datetime_legA="2016-07-28 12:31:10";
        $_answer_datetime_legA="2016-08-27 12:31:10";
        $_end_datetime_legA="2016-07-28 12:31:10";
        $_start_datetime_legB="2016-07-28 12:31:10";
        $_ring_datetime_legB="2016-07-28 12:31:10";
        $_answer_datetime_legB="2016-07-28 12:31:10";
        $_end_datetime_legB="2016-07-28 12:31:10";
        $_recording_url="http://192.168.141.10/recording/db6f6162-53c9-11e6-90da-9fda9a798fe4.mp3";
        $_xpora_req_id="836680";
        $_telecaller_id="175";
        $_legA_hcause="NORMAL_CLEARING";
        $_legB_hcause="NORMAL_CLEARING";
        $_caller_no="9980133521";
        $_called_no="10099";
        $_call_queue="P";
        $c=$this->setAgentCallReqDetail($_uuid,$_legA_uuid,$_legB_uuid,$_start_datetime_legA,$_ring_datetime_legA,$_answer_datetime_legA,$_end_datetime_legA,$_start_datetime_legB,$_ring_datetime_legB,$_answer_datetime_legB,$_end_datetime_legB,$_recording_url,$_xpora_req_id,$_telecaller_id,$_legA_hcause,$_legB_hcause,$_caller_no,$_called_no,$_call_queue);
    }

    /**
     * Agent Summery Report (Agent Login details and Call Detail)
     */
    public function firstValue($arr,$val){
        date_default_timezone_set('Asia/Kolkata');
        if(!empty($arr) && !empty($val)) {
            $flag=0;
            foreach ($arr as $a) {
                $b = new \DateTime($a);
                $newtime = $b->format("H:i:s");
                if (strtotime($newtime) > strtotime($val)) {
                    $flag=0;
                    $v = $newtime;
                    break;
                }
                else{
                    $flag=1;
                }

            }
            if($flag==1){
                $c = new \DateTime();
                $newtime = $c->format("H:i:s");
                $v=$newtime;
            }
        }
        else{
            $v="00:00:00";
        }
        return $v;
    }

    public function agentdetailsMongo(){
        $_id = Request::all();
        $reportingarray=array();
        $mainArray=array();
        $mongoQuery=array();
        $mongoQueryLog=array();
        $mongoQueryCall=array();
        $resp=array();
        //Select All Agent Details..
        $mongoQuery['agent_status']="Active";
        if(isset($_id['agent_name'])){
            if($_id['agent_name']!='N' && !empty($_id['agent_name'])){
                $convert=$_id['agent_name'];
                $in=array('$in'=> $convert);
                $mongoQuery['agent_name']=$in;
            }
        }
        if(isset($_id['tl_name'])){
            if($_id['tl_name']!='N' && !empty($_id['tl_name'])){
                $convert=$_id['tl_name'];
                $in=array('$in'=> $convert);
                $mongoQuery['agent_tl']=$in;
            }
        }
        if(isset($_id['manager_name'])){
            if($_id['manager_name']!='N' && !empty($_id['manager_name'])){
                $convert=$_id['manager_name'];
                $in=array('$in'=> $convert);
                $mongoQuery['agent_manager']=$in;
            }
        }
        if(isset($_id['cityVal'])){
            if($_id['cityVal']!='N' && !empty($_id['cityVal'])){
                $convert=array_map('intval',  $_id['cityVal']);
                $in=array('$in'=> $convert);
                $mongoQuery['agent_competency.city_ids']=$in;
            }
        }
        if($_id['start_date']!='N' && !empty($_id['start_date'])){
            if($_id['end_date']!='N' && !empty($_id['end_date'])){
                $mongoQueryCall['call_datetime']= array('$gte'=>$_id['start_date'],'$lte'=>$_id['end_date']);
                $mongoQueryLog['datetime']= array('$gte'=>$_id['start_date'],'$lte'=>$_id['end_date']);
            }
            else{
                $mongoQueryCall['call_datetime']=array('$gte'=>$_id['start_date']);
                $mongoQueryLog['datetime']=array('$gte'=>$_id['start_date']);
            }
        }
        else{
            if($_id['end_date']!='N' && !empty($_id['end_date'])){
                $mongoQueryCall['call_datetime']=array('$lte'=>$_id['end_date']);
                $mongoQueryLog['datetime']=array('$lte'=>$_id['end_date']);
            }
            else{
                $todaydate=date("Y-m-d");
                $mongoQueryCall['call_datetime']= array('$gte'=>$todaydate." 00:00:00",'$lte'=>$todaydate." 23:59:59");
                $mongoQueryLog= array('datetime'=>$todaydate);
            }
        }

        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection_agent = $connection->real_estate->re2_agent_detail_report;
        $collection_call = $connection->real_estate->re2_agent_call_detail_report;
        $collection_log=$connection->real_estate->re2_agent_log_detail_report;
        $result=$collection_agent->find($mongoQuery);
        $resp['total_a_talk_time']="00:00:00";
        $resp['ring_time']="00:00:00";
        $resp['dial_time']="00:00:00";
        $resp['total_awc_time']="00:00:00";
        $resp['total_avg_talk_time']="00:00:00";
        $resp['hold_time']="00:00:00";
        $resp['calls_kept_on_hold']="0";
        $resp['average_hold_time']="00:00:00";
        $resp['acw_time']="NULL";
        $resp['average_wait_time']="00:00:00";
        $resp['total_call_waiting_time']="00:00:00";
        $resp['average_talktime']="00:00:00";
        $resp['itime_total']="00:00:00";
        $resp['disposition_set']=0;
        $resp['disposition_set_num']=0;
        $resp['call_duration']="00:00:00";
        foreach ($result as $result1) {

            /* Agent Details Start Here */
            $competencydoc=$result1['agent_competency'];
            $resp['agent_name']=$result1['agent_name'];
            $resp['agent_id']=$result1['agent_id'];
            if(isset($result1['current_status']['login_status'])) {
                $resp['status'] = $this->getAgentCurrentStatus($result1['current_status']['login_status'], $result1['current_status']['pick_call_status'], $result1['current_status']['call_status']);
            }
            else{
                $resp['status']="NULL";
            }
            $resp['pri_intent']=$competencydoc['primary_intent'];
            $resp['cities']=$competencydoc['city_names'];
            $resp['team_leader']=$result1['agent_tl'];
            /* Agent Details End here */

            /* Login Log Details Start Here */
            $mongoQueryLog['agent_detail.agent_id']=$result1['agent_id'];
            $result2=$collection_log->find($mongoQueryLog);
            $resp['btime_day'] = "00:00:00";
            $resp['btime_tea'] = "00:00:00";
            $resp['btime_tl'] = "00:00:00";
            $resp['btime_it'] = "00:00:00";
            $resp['btime_qa'] = "00:00:00";
            $resp['btime_training'] = "00:00:00";
            $resp['btime_others'] = "00:00:00";
            $resp['btime_lunch']= "00:00:00";
            $resp['first_login_time']="NULL";
            $resp['last_login_time']="NULL";
            $resp['last_logout_time']="NULL";
            $resp['total_login_duration']="NULL";
                $totalItime=array();
                $totalBreak = array();
                $totalTea = array();
                $totalLunch = array();
                $totalTraining = array();
                $totalQA = array();
                $totalIT = array();
                $totalTL = array();
                $totalOthers = array();
                $totalBreakArray = array();
                $loginTimeArray=array();
                $logoutTimeArray=array();
                $pickTimeArray=array();
                $loginTimeA=array();
                $pickTimeA=array();
                $logoutTimeA=array();

                foreach ($result2 as $log) {
                    $loginTimeArray=array();
                    $logoutTimeArray=array();
                    $pickTimeArray=array();
                    $loginTimeA=array();
                    $pickTimeA=array();
                    $logoutTimeA=array();
                    if (!isset($log['logout_time'])) {
                        $log['logout_time'] = array("00:00:00");
                    }
                    $loginTimeArray = array_merge($loginTimeArray,$log['login_time']);
                    foreach($loginTimeArray as $login){
                        $r=(new \DateTime($login))->format("H:i:s");
                        array_push($loginTimeA,$r);
                    }
                    $logoutTimeArray = array_merge($logoutTimeArray, $log['logout_time']);
                    foreach($logoutTimeArray as $logout){
                        $s=(new \DateTime($logout))->format("H:i:s");
                        array_push($logoutTimeA,$s);
                    }
                    if (!isset($log['pick_call_time'])) {
                        $log['pick_call_time'] = array("00:00:00");
                    }
                    $pickTimeArray = array_merge($pickTimeArray, $log['pick_call_time']);
                    foreach($pickTimeArray as $pick){
                        $p=(new \DateTime($pick))->format("H:i:s");
                        array_push($pickTimeA,$p);
                    }
                    $time3=$this->addArrayDiff($logoutTimeA,$loginTimeA);
                    $logDuration=$this->sum_the_time($time3);
                    //$logDuration = $logDuration->format("%H:%I:%S");
                    $resp['total_login_duration']=$logDuration;
                    $diff1=$this->addArrayDiff($pickTimeA,$loginTimeA);
                    $totalIdletime=$this->sum_the_time($diff1);
//var_dump($totalIdletime);
                    $breaktea = (new \DateTime("00:00:00"))->format("H:i:s");
                    $breaklunch = (new \DateTime("00:00:00"))->format("H:i:s");
                    $breakqa = (new \DateTime("00:00:00"))->format("H:i:s");
                    $breaktraining = (new \DateTime("00:00:00"))->format("H:i:s");
                    $breakIT = (new \DateTime("00:00:00"))->format("H:i:s");
                    $breakothers = (new \DateTime("00:00:00"))->format("H:i:s");
                    $breaktl = (new \DateTime("00:00:00"))->format("H:i:s");

                    $resp['btime_day'] = "00:00:00";
                    $resp['btime_tea'] = "00:00:00";
                    $resp['btime_it'] = "00:00:00";
                    $resp['btime_tl'] = "00:00:00";
                    $resp['btime_qa'] = "00:00:00";
                    $resp['btime_lunch'] = "00:00:00";
                    $resp['btime_training'] = "00:00:00";
                    $resp['btime_others'] = "00:00:00";
                    $totalBreakTimeDay = "00:00:00";
                    if (isset($log['break'])) {
                        $totalBreak = array();
                        foreach ($log['break'] as $break1) {
                            if (!isset($log['end_break_time'])) {
                                $log['end_break_time'] = array();
                            }
                            $breakTea = "00:00:00";
                            $breakLunch = "00:00:00";
                            $breakQa = "00:00:00";
                            $breakTraining = "00:00:00";
                            $breakIt = "00:00:00";
                            $breakTl = "00:00:00";
                            $breakOthers = "00:00:00";
                            if ($break1['break_reason'] == "Tea") {
                                $breakTimeTea = (new \DateTime($break1['break_time']))->format("H:i:s");
                                $next = $this->firstValue($log['end_break_time'], $breakTimeTea);
                                $nextTime = (new \DateTime($next))->format("H:i:s");
                                $time1 = new \DateTime($breakTimeTea);
                                $time2 = new \DateTime($next);
                                $breaktimetea = $time1->diff($time2);
                                $breaktimetea = $breaktimetea->format("%H:%I:%S");
                                $sum1 = array();
                                array_push($sum1, $breaktimetea);
                                array_push($sum1, $breaktea);
                                $breakTea = $this->sum_the_time($sum1);
                            }
                            if ($break1['break_reason'] == "TL Briefing") {
                                $breakTimeTl = (new \DateTime($break1['break_time']))->format("H:i:s");
                                $next = $this->firstValue($log['end_break_time'], $breakTimeTl);
                                $nextTime = (new \DateTime($next))->format("H:i:s");
                                $time1 = new \DateTime($breakTimeTl);
                                $time2 = new \DateTime($next);
                                $breakTimeTl = $time1->diff($time2);
                                $breaktimeTl = $breakTimeTl->format("%H:%I:%S");
                                $sum1 = array();
                                array_push($sum1, $breaktimeTl);
                                array_push($sum1, $breaktl);
                                $breakTl = $this->sum_the_time($sum1);
                            }
                            if ($break1['break_reason'] == "Lunch") {
                                $breakTimeLunch = (new \DateTime($break1['break_time']))->format("H:i:s");
                                $next = $this->firstValue($log['end_break_time'], $breakTimeLunch);
                                $nextTime = (new \DateTime($next))->format("H:i:s");
                                $time1 = new \DateTime($breakTimeLunch);
                                $time2 = new \DateTime($next);
                                $breaktimeLunch = $time1->diff($time2);
                                $breaktimeLunch = $breaktimeLunch->format("%H:%I:%S");
                                $sum1 = array();
                                array_push($sum1, $breaktimeLunch);
                                array_push($sum1, $breaklunch);
                                $breakLunch = $this->sum_the_time($sum1);
                            }
                            if ($break1['break_reason'] == "Training") {
                                $breakTimeTraining = (new \DateTime($break1['break_time']))->format("H:i:s");
                                $next = $this->firstValue($log['end_break_time'], $breakTimeTraining);
                                $nextTime = (new \DateTime($next))->format("H:i:s");
                                $time1 = new \DateTime($breakTimeTraining);
                                $time2 = new \DateTime($next);
                                $breaktimeTraining = $time1->diff($time2);
                                $breaktimeTraining = $breaktimeTraining->format("%H:%I:%S");
                                $sum1 = array();
                                array_push($sum1, $breaktimeTraining);
                                array_push($sum1, $breaktraining);
                                $breakTraining = $this->sum_the_time($sum1);
                            }
                            if ($break1['break_reason'] == "QA Feedback") {
                                $breakTimeQa = (new \DateTime($break1['break_time']))->format("H:i:s");
                                $next = $this->firstValue($log['end_break_time'], $breakTimeQa);
                                $nextTime = (new \DateTime($next))->format("H:i:s");
                                $time1 = new \DateTime($breakTimeQa);
                                $time2 = new \DateTime($next);
                                $breaktimeQa = $time1->diff($time2);
                                $breaktimeQa = $breaktimeQa->format("%H:%I:%S");
                                $sum1 = array();
                                array_push($sum1, $breaktimeQa);
                                array_push($sum1, $breakqa);
                                $breakQa = $this->sum_the_time($sum1);
                            }
                            if ($break1['break_reason'] == "IT Downtime") {
                                $breakTimeIt = (new \DateTime($break1['break_time']))->format("H:i:s");
                                $next = $this->firstValue($log['end_break_time'], $breakTimeIt);
                                $nextTime = (new \DateTime($next))->format("H:i:s");
                                $time1 = new \DateTime($breakTimeIt);
                                $time2 = new \DateTime($next);
                                $breakTimeIt = $time1->diff($time2);
                                $breaktimeIt = $breakTimeIt->format("%H:%I:%S");
                                $sum1 = array();
                                array_push($sum1, $breaktimeIt);
                                array_push($sum1, $breakIT);
                                $breakIt = $this->sum_the_time($sum1);
                            }
                            if ($break1['break_reason'] == "Others") {
                                $breakTimeOthers = (new \DateTime($break1['break_time']))->format("H:i:s");
                                $next = $this->firstValue($log['end_break_time'], $breakTimeOthers);
                                $nextTime = (new \DateTime($next))->format("H:i:s");
                                $time1 = new \DateTime($breakTimeOthers);
                                $time2 = new \DateTime($next);
                                $breakTimeOthers = $time1->diff($time2);
                                $breaktimeOthers = $breakTimeOthers->format("%H:%I:%S");
                                $sum1 = array();
                                array_push($sum1, $breaktimeOthers);
                                array_push($sum1, $breakothers);
                                $breakOthers = $this->sum_the_time($sum1);
                            }
                            array_push($totalBreak, $breakTea);
                            array_push($totalBreak, $breakLunch);
                            array_push($totalBreak, $breakQa);
                            array_push($totalBreak, $breakTraining);
                            array_push($totalBreak, $breakIt);
                            array_push($totalBreak, $breakTl);
                            array_push($totalBreak, $breakOthers);
                            array_push($totalTea, $breakTea);
                            array_push($totalLunch, $breakLunch);
                            array_push($totalTraining, $breakTraining);
                            array_push($totalQA, $breakQa);
                            array_push($totalIT, $breakIt);
                            array_push($totalTL, $breakTl);
                            array_push($totalOthers, $breakOthers);
                            array_push($totalItime, $totalIdletime);
                        }
                        //var_dump($totalItime);
                        $totalIdleTime = $this->sum_the_time($totalItime);
                       // var_dump($totalIdleTime);
                        $totalBreakTimeDay = $this->sum_the_time($totalBreak);
                        array_push($totalBreakArray, $totalBreakTimeDay);
                        $resp['btime_day'] = $this->sum_the_time($totalBreakArray);
                        $resp['btime_tea'] = $this->sum_the_time($totalTea);
                        $resp['btime_tl'] = $this->sum_the_time($totalTL);
                        $resp['btime_lunch'] = $this->sum_the_time($totalLunch);
                        $resp['btime_qa'] = $this->sum_the_time($totalQA);
                        $resp['btime_training'] = $this->sum_the_time($totalTraining);
                        $resp['btime_others'] = $this->sum_the_time($totalOthers);
                        $resp['btime_it'] = $this->sum_the_time($totalIT);

                        $resp['itime_total'] = $totalIdleTime;
                    }

                    $getFirstLoginarray=$loginTimeArray[0];
                    $resp['first_login_time']=$getFirstLoginarray;
                    $resp['last_logout_time']=end($logoutTimeArray);
                }
            /* Login Log Details End Here */

            /* Call Details Start Here */
            $mongoQueryCall['agent_detail.agent_id']=$result1['agent_id'];
            $result_call=$collection_call->find($mongoQueryCall);
            $resp['bl_count']="NULL";
            $resp['non_bl_count']="NULL";
            $resp['total_requirement_captured']="NULL";
            $resp['unique_seekers_BL']="NULL";
            $resp['overall_crate']="NULL";
            $resp['unique_crate']="NULL";

            $resp['lead_multiplier']="NULL";
            $resp['bl_talktime']="NULL";
            $resp['nonbl_talktime']="NULL";
            $resp['actual_talk_time']="NULL";
            $resp['nonbl_average_talktime']="NULL";
            $resp['called_party_number']="NULL";
            $resp['call_from_queue']="NULL";
            //$resp['status']="NULL";
            $resp['total_calls_recieved']="NULL";
            $resp['total_connects']="NULL";
            $resp['calls_answered']="NULL";
            $resp['re_schedule']="NULL";
            $resp['average_call_waiting_time']="NULL";
            $resp['call_handling_time']="00:00:00";
            $resp['call_handling_time_a']="00:00:00";
            $resp['average_acw_time']="00:00:00";
            $resp['total_calls_dialled']=0;
            $resp['average_talk_time']="00:00:00";
            $countTotalAnsweredCalls=0;
            $countValidDisp=0;
            $countTotalConnectCalls=0;
            $count=0;
            $count=$collection_call->find($mongoQueryCall)->count();
            $resp['total_calls_dialled']=$count;
            $callduration=array();
            $awctime=array();
            $talktime=array();
            $atalktime=array();
            $ringtime=array();
            $dialtime=array();
            $holdtime=array();
            $countHoldCalls=0;
            foreach($result_call as $resultcall) {
                $calldoc1=$resultcall;

                if (!empty($calldoc1['recording_url']) && $calldoc1['recording_url']!='nil') {
                    $countTotalAnsweredCalls++;
                }
                if ($calldoc1['legA_hcause'] == 'Answered_02' || $calldoc1['legA_hcause'] == 'Answered_01') {
                    $countTotalConnectCalls++;
                }
                if (!empty($calldoc1['req_detail']['status']) || $calldoc1['req_detail']['status'] != 'NEW') {
                    $countValidDisp++;
                }
                array_push($callduration, $calldoc1['call_duration']);
                array_push($awctime, $calldoc1['acw_time']);
                array_push($talktime, $calldoc1['talk_time']);
                array_push($atalktime, $calldoc1['actual_talk_time']);
                array_push($ringtime, $calldoc1['ring_duration']);
                $legB = new \DateTime($calldoc1['legBstart_time']);
                $r = new \DateTime($calldoc1['legBring_time']);
                $d = $legB->diff($r);
                $final_d = $d->format("%H:%I:%S");
                array_push($dialtime, $final_d);
                array_push($holdtime, $calldoc1['hold_time']);
                if ($calldoc1['hold_time'] != "00:00:00") {
                    $countHoldCalls++;
                }
            }
                $resp['total_connects'] = $countTotalConnectCalls;
                $resp['calls_answered'] = $countTotalAnsweredCalls;
                if (!empty($ringtime)) {
                    $resp['ring_time'] = $this->sum_the_time($ringtime);
                } else {
                    $resp['ring_time'] = "00:00:00";
                }
                if (!empty($atalktime)) {
                    $resp['total_a_talk_time'] = $this->sum_the_time($atalktime);
                } else {
                    $resp['total_a_talk_time'] = "00:00:00";
                }
                if (!empty($awctime)) {
                    $resp['total_awc_time'] = $this->sum_the_time($awctime);
                } else {
                    $resp['total_awc_time'] = "00:00:00";
                }
                if (!empty($dialtime)) {
                    $resp['dial_time'] = $this->sum_the_time($dialtime);
                } else {
                    $resp['dial_time'] = "00:00:00";
                }
                if (!empty($holdtime)) {
                    $resp['hold_time'] = $this->sum_the_time($holdtime);
                } else {
                    $resp['hold_time'] = "00:00:00";
                }
                if (!empty($callduration)) {
                    $resp['call_duration'] = $this->sum_the_time($callduration);
                } else {
                    $resp['call_duration'] = "00:00:00";
                }
                if (!empty($talktime)) {
                    $talk_time = $this->sum_the_time($talktime);
                } else {
                    $talk_time = "00:00:00";
                }
                $test = array();
                array_push($test, $resp['total_awc_time']);
                array_push($test, $talk_time);
                if (!empty($test)) {
                    $resp['call_handling_time'] = (string)$this->sum_the_time($test);
                }
                //$resp['itime_total'] = "NULL";
                $resp['total_call_waiting_time'] = "NULL";
                $resp['disposition_set'] = $countValidDisp;
                $nonDisp = $count - $countValidDisp;
                $resp['disposition_set_num'] = $nonDisp;
                $resp['calls_kept_on_hold'] = $countHoldCalls;
                if (!empty($count)) {
                    $resp['average_hold_time'] = date('H:i:s', array_sum(array_map('strtotime', $holdtime)) / $count);
                    $resp['average_talk_time'] = date('H:i:s', array_sum(array_map('strtotime', $talktime)) / $count);
                    $resp['call_handling_time_a'] = date('H:i:s', array_sum(array_map('strtotime', $test)) / $count);
                    $resp['average_acw_time'] = date('H:i:s', array_sum(array_map('strtotime', $awctime)) / $count);
                } else {
                    $resp['average_hold_time'] = "00:00:00";
                    $resp['average_talk_time'] = "00:00:00";
                }
                $resp['average_wait_time'] = "NULL";
            /* Call Details End Here */
            $mainArray[]=$resp;
        }
        header('Content-type: application/json');
        echo json_encode($mainArray);
    }

    /**
     * Call Detail Report (Call Timing Details and Requirement Id Based Details)
     */
    public function callDetailReport(){
        $resp=array();
        $mainArray=array();
        $_id = Request::all();
        session_start();
        $mongoQuery=array();
        $mongoQuery['agent_detail.agent_status']="Active";
        if(isset($_id['agent_name'])){
            if($_id['agent_name']!='N' && !empty($_id['agent_name'])){
                $convert=$_id['agent_name'];
                $in=array('$in'=> $convert);
                $mongoQuery['agent_detail.agent_name']=$in;
            }
        }
        if(isset($_id['p_intent'])){
            if($_id['p_intent']!='N' && !empty($_id['p_intent'])){
                $convert=$this->convertRegex($_id['p_intent']);
                $in=array('$in'=> $convert);
                $mongoQuery['req_detail.transactionType']=$in;
            }
        }
        if(isset($_id['p_type'])){
            if($_id['p_type']!='N' && !empty($_id['p_type'])){
                $convert=$this->convertRegex($_id['p_type']);
                $in=array('$in'=> $convert);
                $mongoQuery['req_detail.propertyType']=$in;
            }
        }
        if(isset($_id['p_category'])){
            if($_id['p_category']!='N' && !empty($_id['p_category'])){
                $convert=$this->convertRegex($_id['p_category']);
                $in=array('$in'=> $convert);
                $mongoQuery['req_detail.category']=$in;
            }
        }
        if(isset($_id['source'])){
            if($_id['source']!='N' && !empty($_id['source'])){
                $convert=$this->convertRegex($_id['source']);
                $in=array('$in'=> $convert);
                $mongoQuery['req_detail.source1']=$in;
            }
        }
        if(isset($_id['cityVal'])){
            if($_id['cityVal']!='N' && !empty($_id['cityVal'])){
                $convert=array_map('intval',  $_id['cityVal']);
                $in=array('$in'=> $convert);
                $mongoQuery['city_id']=$in;
            }
        }
        if(isset($_id['phone_no'])){
            if($_id['phone_no']!='N' && !empty($_id['phone_no'])){
                $mongoQuery['req_detail.phone1']=$_id['phone_no'];
            }
        }
        if(isset($_id['tl_name'])){
            if($_id['tl_name']!='N' && !empty($_id['tl_name'])){
                $convert=$_id['tl_name'];
                $in=array('$in'=> $convert);
                $mongoQuery['agent_detail.agent_tl']=$in;
            }
        }
        if($_id['start_date']!='N' && !empty($_id['start_date'])){
            if($_id['end_date']!='N' && !empty($_id['end_date'])){
                $mongoQuery['call_datetime']= array('$gte'=>$_id['start_date'],'$lte'=>$_id['end_date']);
            }
            else{
                $mongoQuery['call_datetime']=array('$gte'=>$_id['start_date']);
            }
        }
        else{
            if($_id['end_date']!='N' && !empty($_id['end_date'])){
                $mongoQuery['call_datetime']=array('$lte'=>$_id['end_date']);
            }
            else {
                if($_id['phone_no']=='N' || empty($_id['phone_no'])){
                    $todaydate = date("Y-m-d");
                    $mongoQuery['call_datetime'] = array('$gte' => $todaydate . " 00:00:00", '$lte' => $todaydate . " 23:59:59");
                }
            }
        }
        $resp['raw_req_id']="NULL";
        $resp['merged_req_id']="NULL";   
        $resp['date_form_fill']="NULL";
        $resp['time_form_fill']="NULL";  
        $resp['source_raw_requirement']="NULL";  
        $resp['p_intent']="NULL";
        $resp['call_start_date']="NULL"; 
        $resp['call_start_time']="NULL";
        $resp['call_end_date']="NULL";
        $resp['call_end_time']="NULL";
        $resp['total_call_time']="NULL"; 
        $resp['total_acw_time'] ="NULL"; 
        $resp['dialer_hangup_cause']="NULL"; 
        $resp['manager_name'] ="NULL"; 
        $resp['tl_name']="NULL"; 
        $resp['seeker_name']="NULL"; 
        $resp['seeker_email']="NULL"; 
        $resp['seeker_number']="NULL";   
        $resp['bhk_info']="NULL";
        $res['locality_name'] ="NULL";  
        $resp['regions']="NULL"; 
        $resp['city'] ="NULL";   
        $resp['property']="NULL"; 
        $resp['category'] ="NULL";   
        $resp['prop_type']="NULL";   
        $resp['min_budget']="NULL";  
        $resp['max_budget'] ="NULL"; 
        $resp['plead_exact_match'] ="NULL"; 
        $resp['plead_locality_match'] ="NULL";  
        $resp['plead_project_match'] ="NULL";
        $resp['ram_zam'] ="NULL";
        $resp['seeker_country'] ="NULL";
        $resp['city_zone']="NULL";   
        $resp['week_no']="NULL"; 
        $resp['telecaller_id'] ="NULL";  
        $resp['telecaller_name'] ="NULL";    
        $resp['call_status'] ="NULL";
        $resp['total_promoted_leads']="NULL"; 
        $resp['total_revenue']="NULL";   
        $resp['promoted_project_leads']="NULL";   
        $resp['name_projected_projects']="NULL"; 
        $resp['povp_id_promoted_project']="NULL";    
        $resp['name_promoted_project']="NULL";   
        $resp['povp_id_promoted_project'] ="NULL";   
        $resp['call_follow_up_date'] ="NULL";    
        $resp['call_follow_up_time'] ="NULL";
        $resp['Remarks'] ="NULL";
        $resp['name_of_seeker_final'] ="NULL";   
        $resp['contact_number_final']="NULL";    
        $resp['email_id_final'] ="NULL"; 
        $resp['area_name_final'] ="NULL";
        $resp['city_final'] ="NULL"; 
        $resp['property_type'] ="NULL";  
        $resp['bhk_info_final']="NULL";
        $resp['min_budget_final']="NULL";
        $resp['max_budget_final'] ="NULL";   
        $resp['possession_category']="NULL";

        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection = new \MongoCollection($db, 're2_agent_call_detail_report');
        $total=$collection->find($mongoQuery)->count();
        $result = $collection->find($mongoQuery)->sort(array('call_datetime' => -1))->limit(50);
        $mainArray['total_call']=$total;
         foreach ($result as $result1) {
            $agentdoc=$result1['agent_detail'];
             $reqdoc1 = $result1['req_detail'];
                $raw_req_id = $reqdoc1['mergedRawRequirementIds'];
             if(!empty($raw_req_id) && $raw_req_id!='null') {
                 $resp['merged_req_id'] = $reqdoc1['id'];
                 $resp['raw_req_id'] = $raw_req_id;
                 $raw_req_id = explode(',', $raw_req_id);
                 $lastNumber = end($raw_req_id);
                 $sql = DB::connection('mysql_slave')->select("SELECT created_date,source_1 from re2_raw_requirements where id = '" . $lastNumber . "'");
                 if (count($sql) >= 1) {
                     $datetimeform = $sql[0]->created_date;
                     $source1 = $sql[0]->source_1;
                 }
                 $datetime = new \DateTime($datetimeform);
                 $resp['date_form_fill'] = $datetime->format('d-m-Y');
                 $resp['time_form_fill'] = $datetime->format('H:i:s');
                 $resp['source_raw_requirement'] = $source1;
             }
             else{
                 $datetimeform = $reqdoc1['createdDate'];
                 $datetime = new \DateTime($datetimeform);
                 $resp['date_form_fill'] = $datetime->format('d-m-Y');
                 $resp['time_form_fill'] = $datetime->format('H:i:s');
             }
                $resp['rec_url']= $result1['recording_url'];
                $resp['p_intent'] = $reqdoc1['transactionType'];
                $resp['seeker_name'] = $reqdoc1['userName'];
                $resp['seeker_email'] = $reqdoc1['emailId1'];
                $resp['seeker_number'] = $reqdoc1['phone1'];
                $resp['bhk_info'] = $reqdoc1['bhks'];
                $resp['locality_name'] = $reqdoc1['localities'];
                $resp['city'] = $reqdoc1['cityName'];
                $resp['property'] = $reqdoc1['projects'];
                $resp['category'] = $reqdoc1['category'];
                $resp['prop_type'] = $reqdoc1['propertyTypes'];
                $resp['min_budget'] = $reqdoc1['priceMin'];
                $resp['max_budget'] = $reqdoc1['priceMax'];
                $resp['Remarks'] = $reqdoc1['remarks'];
                $resp['name_of_seeker_final'] = $reqdoc1['userName'];
                $resp['contact_number_final'] = $reqdoc1['phone1'];
                $resp['email_id_final'] = $reqdoc1['emailId1'];
                $resp['city_final'] = $reqdoc1['cityName'];
                $resp['property_type'] = $reqdoc1['propertyTypes'];
                $resp['bhk_info_final'] = $reqdoc1['bhks'];
                $resp['min_budget_final'] = $reqdoc1['priceMin'];
                $resp['max_budget_final'] = $reqdoc1['priceMax'];
                $resp['call_start_date'] = $result1['legBstart_time'];
                $resp['call_start_time'] = $result1['legBstart_time'];
                $resp['call_end_date'] = $result1['legBend_time'];
                $resp['call_end_time'] = $result1['legBend_time'];
                $resp['total_call_time'] = $result1['call_duration'];
                $resp['total_acw_time'] = $result1['acw_time'];
                $resp['dialer_hangup_cause'] = $result1['legA_hcause'];
                $resp['call_status'] = $reqdoc1['status'];
                $datetime = $result1['call_datetime'];
                $datetime = new \DateTime($datetime);
                $resp['week_no'] = $datetime->format("W");
                $resp['call_datetime'] = $result1['call_datetime'];
                $resp['manager_name'] = $agentdoc['agent_manager'];
                $resp['tl_name'] = $agentdoc['agent_tl'];
                $resp['telecaller_id'] = $agentdoc['agent_emp_id'];
                $resp['telecaller_name'] = $agentdoc['agent_name'];
                $mainArray['call_details'][] = $resp;
        }
        header('Content-type: application/json');
        echo json_encode($mainArray);
    }

    public function callDetailReportDownload(){
        $resp=array();
        $mainArray=array();
        $_id = Request::all();
        session_start();
        $mongoQuery=array();
        $mongoQuery['agent_detail.agent_status']="Active";
        if(isset($_id['agent_name'])){
            if($_id['agent_name']!='N' && !empty($_id['agent_name'])){
                $convert=$_id['agent_name'];
                $in=array('$in'=> $convert);
                $mongoQuery['agent_detail.agent_name']=$in;
            }
        }
        if(isset($_id['p_intent'])){
            if($_id['p_intent']!='N' && !empty($_id['p_intent'])){
                $convert=$this->convertRegex($_id['p_intent']);
                $in=array('$in'=> $convert);
                $mongoQuery['req_detail.transactionType']=$in;
            }
        }
        if(isset($_id['p_type'])){
            if($_id['p_type']!='N' && !empty($_id['p_type'])){
                $convert=$this->convertRegex($_id['p_type']);
                $in=array('$in'=> $convert);
                $mongoQuery['req_detail.propertyType']=$in;
            }
        }
        if(isset($_id['p_category'])){
            if($_id['p_category']!='N' && !empty($_id['p_category'])){
                $convert=$this->convertRegex($_id['p_category']);
                $in=array('$in'=> $convert);
                $mongoQuery['req_detail.category']=$in;
            }
        }
        if(isset($_id['source'])){
            if($_id['source']!='N' && !empty($_id['source'])){
                $convert=$this->convertRegex($_id['source']);
                $in=array('$in'=> $convert);
                $mongoQuery['req_detail.source1']=$in;
            }
        }
        if(isset($_id['cityVal'])){
            if($_id['cityVal']!='N' && !empty($_id['cityVal'])){
                $convert=array_map('intval',  $_id['cityVal']);
                $in=array('$in'=> $convert);
                $mongoQuery['city_id']=$in;
            }
        }
        if(isset($_id['phone_no'])){
            if($_id['phone_no']!='N' && !empty($_id['phone_no'])){
                $mongoQuery['req_detail.phone1']=$_id['phone_no'];
            }
        }
        if(isset($_id['tl_name'])){
            if($_id['tl_name']!='N' && !empty($_id['tl_name'])){
                $convert=$_id['tl_name'];
                $in=array('$in'=> $convert);
                $mongoQuery['agent_detail.agent_tl']=$in;
            }
        }
        if($_id['start_date']!='N' && !empty($_id['start_date'])){
            if($_id['end_date']!='N' && !empty($_id['end_date'])){
                $mongoQuery['call_datetime']= array('$gte'=>$_id['start_date'],'$lte'=>$_id['end_date']);
            }
            else{
                $mongoQuery['call_datetime']=array('$gte'=>$_id['start_date']);
            }
        }
        else{
            if($_id['end_date']!='N' && !empty($_id['end_date'])){
                $mongoQuery['call_datetime']=array('$lte'=>$_id['end_date']);
            }
            else{
                if($_id['phone_no']=='N' || empty($_id['phone_no'])){
                    $todaydate = date("Y-m-d");
                    $mongoQuery['call_datetime'] = array('$gte' => $todaydate . " 00:00:00", '$lte' => $todaydate . " 23:59:59");
                }
            }
        }
        $filenameval="xpora-detailcall-report".time().".csv";
        $file=fopen('./'.$filenameval,'w');
        $th=array("Raw req id","merged req id","date and time of form fill at the front end","Source name from raw requirement","Primary intent etc.","Call Datetime","Call start date stamp","Call end date stamp","Recording URL","Total time on the call","Total after call work time","Dialer hang up cause","Managers name","TL name","Name of the Seeker","Email ID of seeker","Contact Number of the seeker","BHK Info","Locality Name","Regions","City","Property","category","Property Type","Min Budget","Max Budget","Week No","Telecaller Employee id","Telecaller Name","Call Status (Disposition)","Remarks","Name of the Seeker - Final","Contact Number - Final","Email ID - Final","Area Name - Final","City - Final","Property Type - Final","BHK Info - Final","Min Budget - Final","Max Budget - Final","Possession Category - status","Projects leads sent in the past","Suggested Projects","Suggested Projects(lead generated for) - P2(locality matching)","Suggested Projects - (similar projects)","Region/zone area mapping","Seekers Country","City Zone(ZAM=Zone Area Mapping)","Total Promoted Project Leads","total revenue(as sold to the seller) of the leads sent","No. Promoted Project Leads- CF (PLs)","Name of the Promoted Projects -CF PLs (Separate with comma)","povp IDs of the Promoted Projects -CF PLs (Separate with comma)  No. Promoted Project Leads- QH (PLs)","Name of the Promoted Projects -QH PLs (Separate with comma)","povp IDs of the Promoted Projects -QH PLs (Separate with comma)","Call follow up date","Call follow up time");
        $thdetail='"'. join('","', $th). '"'."\n";
        fputcsv($file, $th);
        $resp['rec_url']= "NULL";
        $resp['raw_req_id']="NULL";
        $resp['merged_req_id']="NULL";
        $resp['date_form_fill']="NULL";
        $resp['time_form_fill']="NULL";
        $resp['source_raw_requirement']="NULL";
        $resp['p_intent']="NULL";
        $resp['call_start_date']="NULL";
        $resp['call_start_time']="NULL";
        $resp['call_end_date']="NULL";
        $resp['call_end_time']="NULL";
        $resp['total_call_time']="NULL";
        $resp['total_acw_time'] ="NULL";
        $resp['dialer_hangup_cause']="NULL";
        $resp['manager_name'] ="NULL";
        $resp['tl_name']="NULL";
        $resp['seeker_name']="NULL";
        $resp['seeker_email']="NULL";
        $resp['seeker_number']="NULL";
        $resp['bhk_info']="NULL";
        $res['locality_name'] ="NULL";
        $resp['regions']="NULL";
        $resp['city'] ="NULL";
        $resp['property']="NULL";
        $resp['category'] ="NULL";
        $resp['prop_type']="NULL";
        $resp['min_budget']="NULL";
        $resp['max_budget'] ="NULL";
        $resp['plead_exact_match'] ="NULL";
        $resp['plead_locality_match'] ="NULL";
        $resp['plead_project_match'] ="NULL";
        $resp['ram_zam'] ="NULL";
        $resp['seeker_country'] ="NULL";
        $resp['city_zone']="NULL";
        $resp['week_no']="NULL";
        $resp['telecaller_id'] ="NULL";
        $resp['telecaller_name'] ="NULL";
        $resp['call_status'] ="NULL";
        $resp['total_promoted_leads']="NULL";
        $resp['total_revenue']="NULL";
        $resp['promoted_project_leads']="NULL";
        $resp['name_projected_projects']="NULL";
        $resp['povp_id_promoted_project']="NULL";
        $resp['name_promoted_project']="NULL";
        $resp['povp_id_promoted_project'] ="NULL";
        $resp['call_follow_up_date'] ="NULL";
        $resp['call_follow_up_time'] ="NULL";
        $resp['Remarks'] ="NULL";
        $resp['name_of_seeker_final'] ="NULL";
        $resp['contact_number_final']="NULL";
        $resp['email_id_final'] ="NULL";
        $resp['area_name_final'] ="NULL";
        $resp['city_final'] ="NULL";
        $resp['property_type'] ="NULL";
        $resp['bhk_info_final']="NULL";
        $resp['min_budget_final']="NULL";
        $resp['max_budget_final'] ="NULL";
        $resp['possession_category']="NULL";

        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection = new \MongoCollection($db, 're2_agent_call_detail_report');
        $result = $collection->find($mongoQuery)->sort(array('call_datetime' => -1));

        foreach ($result as $result1) {
            $agentdoc=$result1['agent_detail'];
            $reqdoc1 = $result1['req_detail'];
            $raw_req_id = $reqdoc1['mergedRawRequirementIds'];
            $raw_req_id=str_ireplace(",","_",$raw_req_id);
            $resp['merged_req_id'] = $reqdoc1['id'];
            $resp['raw_req_id'] = $raw_req_id;
            $raw_req_id = explode(',', $raw_req_id);
            $lastNumber = end($raw_req_id);
            $sql = DB::connection('mysql_slave')->select("SELECT created_date,source_1 from re2_raw_requirements where id = '" . $lastNumber . "'");
            if (count($sql) >= 1) {
                $datetimeform = $sql[0]->created_date;
                $source1 = $sql[0]->source_1;
            }
            $datetime = new \DateTime($datetimeform);
            $resp['date_form_fill'] = $datetime->format('d-m-Y');
            $resp['time_form_fill'] = $datetime->format('H:i:s');;
            $resp['source_raw_requirement'] = $source1;
            $resp['rec_url']= $result1['recording_url'];
            $resp['p_intent'] = $reqdoc1['transactionType'];
            $resp['seeker_name'] = $reqdoc1['userName'];
            $resp['seeker_email'] = $reqdoc1['emailId1'];
            $resp['seeker_number'] = $reqdoc1['phone1'];
            $resp['bhk_info'] = $reqdoc1['bhks'];
            $resp['locality_name'] = $reqdoc1['localities'];
            $resp['city'] = $reqdoc1['cityName'];
            $resp['property'] = $reqdoc1['projects'];
            $resp['category'] = $reqdoc1['category'];
            $resp['prop_type'] = $reqdoc1['propertyTypes'];
            $resp['min_budget'] = $reqdoc1['priceMin'];
            $resp['max_budget'] = $reqdoc1['priceMax'];
            $resp['Remarks'] = $reqdoc1['remarks'];
            $resp['name_of_seeker_final'] = $reqdoc1['userName'];
            $resp['contact_number_final'] = $reqdoc1['phone1'];
            $resp['email_id_final'] = $reqdoc1['emailId1'];
            $resp['city_final'] = $reqdoc1['cityName'];
            $resp['property_type'] = $reqdoc1['propertyTypes'];
            $resp['bhk_info_final'] = $reqdoc1['bhks'];
            $resp['min_budget_final'] = $reqdoc1['priceMin'];
            $resp['max_budget_final'] = $reqdoc1['priceMax'];
            $resp['call_start_date'] = $result1['legBstart_time'];
            $resp['call_start_time'] = $result1['legBstart_time'];
            $resp['call_end_date'] = $result1['legBend_time'];
            $resp['call_end_time'] = $result1['legBend_time'];
            $resp['total_call_time'] = $result1['call_duration'];
            $resp['total_acw_time'] = $result1['acw_time'];
            $resp['dialer_hangup_cause'] = $result1['legA_hcause'];
            $resp['call_status'] = $reqdoc1['status'];
            $datetime = $result1['call_datetime'];
            $datetime = new \DateTime($datetime);
            $resp['week_no'] = $datetime->format("W");
            $resp['call_datetime'] = $result1['call_datetime'];
            $resp['manager_name'] = $agentdoc['agent_manager'];
            $resp['tl_name'] = $agentdoc['agent_tl'];
            $resp['telecaller_id'] = $agentdoc['agent_emp_id'];
            $resp['telecaller_name'] = $agentdoc['agent_name'];

            $contentarray = array($resp['raw_req_id'],$resp['merged_req_id'],
            $resp['date_form_fill']." ".$resp['time_form_fill'],
            $resp['source_raw_requirement'],  $resp['p_intent'],$resp['call_datetime'],
            $resp['call_start_date'],
             $resp['call_end_date'],  $resp['rec_url'],  $resp['total_call_time'], $resp['total_acw_time'],  $resp['dialer_hangup_cause'], $resp['manager_name'],
                $resp['tl_name'],$resp['seeker_name'],$resp['seeker_email'],$resp['seeker_number'],   $resp['bhk_info'],$resp['locality_name'],   $resp['regions'], $resp['city'],    $resp['property'],
            $resp['category'],    $resp['prop_type'],   $resp['min_budget'],  $resp['max_budget'],$resp['week_no'], $resp['telecaller_id'],   $resp['telecaller_name'],     $resp['call_status'],$resp['Remarks'],$resp['name_of_seeker_final'],$resp['contact_number_final'],
            $resp['email_id_final'],  $resp['area_name_final'], $resp['city_final'],  $resp['property_type'],   $resp['bhk_info_final'],$resp['min_budget_final'],$resp['max_budget_final'],
            $resp['possession_category'],"null","null",$resp['plead_locality_match'],$resp['plead_project_match'],$resp['ram_zam'],
            $resp['seeker_country'],$resp['city_zone'],$resp['total_promoted_leads'],
            $resp['total_revenue'],$resp['promoted_project_leads'],
            $resp['name_projected_projects'],$resp['povp_id_promoted_project'],$resp['name_promoted_project'],
            $resp['povp_id_promoted_project'],$resp['call_follow_up_date'],$resp['call_follow_up_time']);
            $str10 = '"'. join('","', $contentarray). '"'."\n";
            fputcsv($file, $contentarray);
        }
        header('Content-type: application/json');
        echo json_encode($filenameval);
    }

    public function getAgentCurrentStatus($loginstatus,$pickcallstatus,$callstatus){
        if($loginstatus==0 && $pickcallstatus==0 && $callstatus==0){
            return "LOGOUT";
        }
        else if($loginstatus==1 && $pickcallstatus==0 && $callstatus==0){
            return "IDLE";
        }
        else if($loginstatus==1 && $pickcallstatus==1 && $callstatus==0){
            return "FREE";
        }
        else if($loginstatus==1 && $pickcallstatus==1 && $callstatus==1){
            return "INCALL";
        }
        else if($loginstatus==1 && $pickcallstatus==1 && $callstatus==2){
            return "DIALING";
        }
        else if($loginstatus==1 && $pickcallstatus==1 && $callstatus==3){
            return "RINGING";
        }
        else{
            return "LOGOUT";
        }
    }
    public function scriptToInsertCallDetail()
    {
        $qry_cdr=DB::connection('mysql_slave')->select("select * from re2_agent_call_cdr order by id desc limit 0,40");
        foreach($qry_cdr as $cdr) {
            $_uuid = $cdr->call_uuid;
            $_legA_uuid = $cdr->legA_uuid;
            $_legB_uuid = $cdr->legB_uuid;
            $_start_datetime_legA = $cdr->start_datetime_legA;
            $_ring_datetime_legA = $cdr->ring_datetime_legA;
            $_answer_datetime_legA = $cdr->answer_datetime_legA;
            $_end_datetime_legA = $cdr->end_datetime_legA;
            $_start_datetime_legB = $cdr->start_datetime_legB;
            $_ring_datetime_legB = $cdr->ring_datetime_legB;
            $_answer_datetime_legB = $cdr->answer_datetime_legB;
            $_end_datetime_legB = $cdr->end_datetime_legB;
            $_recording_url = $cdr->recording_url;
            $_xpora_req_id = $cdr->xpora_req_id;
            $_telecaller_id = $cdr->telecaller_id;
            $_legA_hcause = $cdr->legA_hcause;
            $_legB_hcause = $cdr->legB_hcause;
            $_caller_no = $cdr->caller_no;
            $_called_no = $cdr->called_no;
            $_call_queue = $cdr->call_queue;
            $_call_datetime = $cdr->timestamp;


            $_start_datetime_legA = str_ireplace("_", " ", $_start_datetime_legA);
            $_ring_datetime_legA = str_ireplace("_", " ", $_ring_datetime_legA);
            $_answer_datetime_legA = str_ireplace("_", " ", $_answer_datetime_legA);
            $_end_datetime_legA = str_ireplace("_", " ", $_end_datetime_legA);
            $_start_datetime_legB = str_ireplace("_", " ", $_start_datetime_legB);
            $_ring_datetime_legB = str_ireplace("_", " ", $_ring_datetime_legB);
            $_answer_datetime_legB = str_ireplace("_", " ", $_answer_datetime_legB);
            $_end_datetime_legB = str_ireplace("_", " ", $_end_datetime_legB);

            //GET Requirement Id  Details...
            $result = $this->apiModel->getRequirement($_xpora_req_id);
            $result1 = $result['response'];
            $status = $result['status'];
            if ($status == "200") {
                $result2 = json_decode($result1);
                if ($result2->statusCode == '200') {
                    date_default_timezone_set('Asia/Kolkata');
                    if(!empty($result2->data)) {
                        $result2->data->createdDate = date('Y-m-d H:i:s', $result2->data->createdDate/1000);
                    }
                    $req_detail = $result2->data;
                } else {
                    $req_detail = array();
                }
            } else {
                $req_detail = array();
            }
            $qry_city = DB::connection('mysql_slave')->select("SELECT city_id  FROM re2_requirements where id='" . $_xpora_req_id . "'");
            if (count($qry_city) == 1) {
                $cityId = $qry_city[0]->city_id;
            } else {
                $cityId = "";
            }
            //GET CALL Duration and Ring Duration
            $_call_duration = "00:00:00";
            $_talk_time = "00:00:00";
            $_actual_talk_time = "00:00:00";
            $_ring_duration = "00:00:00";
            if (!empty($_start_datetime_legA) && $_start_datetime_legA != '0000-00-00 00:00:00' && $_end_datetime_legB != '0000-00-00 00:00:00' && !empty($_end_datetime_legB)) {
                $starttimec = $_start_datetime_legA;
                $endtimec = $_end_datetime_legB;
                $startc = new \DateTime("$starttimec");
                $endc = new \DateTime("$endtimec");
                $diffc = $startc->diff($endc);
                $_call_duration = $diffc->format('%H') . ":" . $diffc->format('%I') . ":" . $diffc->format('%S');
            }
            if (!empty($_answer_datetime_legA) && $_answer_datetime_legA != '0000-00-00 00:00:00' && $_end_datetime_legB != '0000-00-00 00:00:00' && !empty($_end_datetime_legB)) {
                $starttimet = $_answer_datetime_legA;
                $endtimet = $_end_datetime_legB;
                $startt = new \DateTime("$starttimet");
                $endt = new \DateTime("$endtimet");
                $difft = $startc->diff($endt);
                $_talk_time = $difft->format('%H') . ":" . $difft->format('%I') . ":" . $difft->format('%S');
            }
            if (!empty($_answer_datetime_legB) && $_answer_datetime_legB != '0000-00-00 00:00:00' && $_end_datetime_legB != '0000-00-00 00:00:00' && !empty($_end_datetime_legB)) {
                $starttime = $_answer_datetime_legB;
                $endtime = $_end_datetime_legB;
                $start = new \DateTime("$starttime");
                $end = new \DateTime("$endtime");
                $diff = $start->diff($end);
                $_actual_talk_time = $diff->format('%H') . ":" . $diff->format('%I') . ":" . $diff->format('%S');
            }
            if (!empty($_answer_datetime_legB) && $_answer_datetime_legB != '0000-00-00 00:00:00' && $_ring_datetime_legB != '0000-00-00 00:00:00' && !empty($_ring_datetime_legB)) {
                $starttime1 = $_ring_datetime_legB;
                $endtime1 = $_answer_datetime_legB;
                $start1 = new \DateTime("$starttime1");
                $end1 = new \DateTime("$endtime1");
                $diff1 = $start1->diff($end1);
                $_ring_duration = $diff1->format('%H') . ":" . $diff1->format('%I') . ":" . $diff1->format('%S');
            }
            date_default_timezone_set('Asia/Kolkata');
            $_call_time = $_call_datetime;
            $_call_disposition = "NULL";
            $getcausecode = new ViewController();
            $_hangupcause = $getcausecode->getHangupCause($_legB_hcause);
            $holdtime = "00:00:00";
            //Agent Detail.
            $_agent_detail=$this->getAgentdetailforCall($_telecaller_id);

            $call_doc = array(
                "call_uuid" => "{$_uuid}",
                "legA_uuid" => "{$_legA_uuid}",
                "legB_uuid" => "{$_legB_uuid}",
                "legAstart_time" => "{$_start_datetime_legA}",
                "legAring_time" => "{$_ring_datetime_legA}",
                "legAanswer_time" => "{$_answer_datetime_legA}",
                "legAend_time" => "{$_end_datetime_legA}",
                "legBstart_time" => "{$_start_datetime_legB}",
                "legBring_time" => "{$_ring_datetime_legB}",
                "legBanswer_time" => "{$_answer_datetime_legB}",
                "legBend_time" => "{$_end_datetime_legB}",
                "ring_duration" => "{$_ring_duration}",
                "call_duration" => "{$_call_duration}",
                "talk_time" => "{$_talk_time}",
                "actual_talk_time" => "{$_actual_talk_time}",
                "recording_url" => "{$_recording_url}",
                "lead_sent" => "NULL",
                "call_disposition" => "{$_call_disposition}",
                "customer_no" => "{$_caller_no}",
                "sip_no" => "{$_called_no}",
                "call_datetime" => "{$_call_time}",
                "call_queue" => "{$_call_queue}",
                "legA_hcause" => "{$_hangupcause}",
                "acw_time" => "00:00:00",
                "hold_time" => "{$holdtime}",
                "city_id" => (int)$cityId,
                "req_detail" => $req_detail,
                "agent_detail" => $_agent_detail,
                "lead_detail" => array()
            );

            $connection = $this->mongoConnection();
            $db = $connection->real_estate;
            $collection = $connection->real_estate->re2_agent_call_detail_report;
            $result = $collection->insert( $call_doc);
        }
    }
    public function createIndexes(){
        $connection=$this->mongoConnection();
        $db = $connection->real_estate;
        $collection = $connection->real_estate->re2_agent_call_report;
        $collection2=$connection->real_estate->re2_agent_log_report;
        $collection->ensureIndex(array(
                                    "call_datetime"=>1
                                )
                    );
        $collection2->ensureIndex(array(
                                    "log_detail.datetime"=>1
                                    )
                    );
    }
    public function convertRegex($arrayI){
        $con=array();
        foreach($arrayI as $smallI){
            $s= new \MongoRegex("/".$smallI."/i");
            array_push($con,$s);
        }
        return $con;
    }
    public function addArrayDiff($array1,$array2){
        $l1=count($array1);
        $l2=count($array2);
        $diff1=array();
        if($l1<$l2){
            $length=$l1;
        }
        else{
            $length=$l2;
        }
        for($i=0;$i<$length;$i++){
            $a=new \DateTime($array1[$i]);
            $b=new \DateTime($array2[$i]);
            $c=$a->diff($b);
            $diff1[]=$c->format("%H:%I:%S");
        }
        return $diff1;
    }
    public function getTcHistory(){
        $_id = Request::all();
        $req_id=$_id['req_id'];
        $resp=array();
        if(!empty($req_id)) {
            $mongoQuery = array();
            $mongoQuery['req_detail.id'] = (int)$req_id;
            $connection = $this->mongoConnection();
            $db = $connection->real_estate;
            $collection = new \MongoCollection($db, 're2_agent_call_detail_report');
            $result = $collection->find($mongoQuery,array('agent_detail.agent_name' => 1,'agent_detail.agent_emp_id' => 1,'agent_detail.agent_id' => 1, 'req_detail.phone1' => 1,'req_detail.status' => 1, 'call_datetime' => 1))->sort(array('call_datetime' => -1));
            foreach($result as $res){
                $resp[]=$res;
            }
        }
            header('Content-type: application/json');
            echo json_encode($resp);
    }
}