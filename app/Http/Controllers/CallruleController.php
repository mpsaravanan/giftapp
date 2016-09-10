<?php
namespace App\Http\Controllers;
use Request;
//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;
class CallruleController extends Controller
{
	public function discardRule(){
		//Auto Mode
		$autoQry=DB::connection('mysql_master')->Select("SELECT id,xpora_req_id,telecaller_id,legA_hcause,legB_hcause ,caller_no,timestamp,call_mode FROM `re2_agent_call_cdr` where (legA_hcause='SERVICE_UNAVAILABLE' or legA_hcause='UNALLOCATED_NUMBER' or legA_hcause='INVALID_NUMBER_FORMAT' or legA_hcause='DESTINATION_OUT_OF_ORDER') and timestamp > DATE_SUB(curdate(), INTERVAL 7 day) and call_mode=0");
		foreach ($autoQry as $value) {
			$req_id=$value->xpora_req_id;
			$telecaller_id=$value->telecaller_id;
			$phone_no=$value->caller_no;
			/*$req_qry=DB::connection('mysql_master')->Select("Select phone_1_id from re2_requirements where id='$req_id'");
			$contact_id=$req_qry[0]->phone_1_id;
			$call_dis=DB::connection('mysql_master')->Select("Select * from re2_requirement_call_dispositions where req_id='$req_id' order by id desc");
			if(count($call_dis)!=0){
				$update_rule=DB::connection('mysql_master')->Update("Update re2_requirement_call_dispositions set call_rule='discard', phases='completed' where req_id='$req_id' ");
			}
			else{
				$insert_qry=DB::connection('mysql_master')->Insert("Insert into re2_requirement_call_dispositions (req_id,user_contact_id,callback_datetime,message,telecaller_id,call_rule,phases) values ('$req_id','$contact_id',NULL,NULL,'$telecaller_id','discard','completed')");
			}*/
			$agent_ad=DB::connection('mysql_master')->Update("Update re2_agent_ad_detail set req_status='2', assign_status='2' where req_id='$req_id' and phone_no='$phone_no'");
		}
		//Manual mode
		$manualQry=DB::connection('mysql_master')->Select("SELECT id,xpora_req_id,telecaller_id,legA_hcause,legB_hcause ,caller_no,timestamp,call_mode FROM `re2_agent_call_cdr` where (legB_hcause='SERVICE_UNAVAILABLE' or legB_hcause='UNALLOCATED_NUMBER' or legB_hcause='INVALID_NUMBER_FORMAT' or legB_hcause='DESTINATION_OUT_OF_ORDER') and timestamp > DATE_SUB(curdate(), INTERVAL 7 day) and call_mode=1");
		foreach ($manualQry as $val) {
			$req_id=$val->xpora_req_id;
			$telecaller_id=$val->telecaller_id;
			$phone_no=$val->caller_no;
			/*$req_qry=DB::connection('mysql_master')->Select("Select phone_1_id from re2_requirements where id='$req_id'");
			$contact_id=$req_qry[0]->phone_1_id;
			$call_dis=DB::connection('mysql_master')->Select("Select * from re2_requirement_call_dispositions where req_id='$req_id' order by id desc");
			if(count($call_dis)!=0){
				$update_rule=DB::connection('mysql_master')->Update("Update re2_requirement_call_dispositions set call_rule='discard', phases='completed' where req_id='$req_id' ");
			}
			else{
				$insert_qry=DB::connection('mysql_master')->Insert("Insert into re2_requirement_call_dispositions (req_id,user_contact_id,callback_datetime,message,telecaller_id,call_rule,phases) values ('$req_id','$contact_id',NULL,NULL,'$telecaller_id','discard','completed')");
			}*/
			$agent_ad=DB::connection('mysql_master')->Update("Update re2_agent_ad_detail set req_status='2', assign_status='2' where req_id='$req_id' and phone_no='$phone_no'");
		}
	}
}
?>