<?php
namespace App\Http\Controllers;
use Request;
//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;
class MatchMakingController extends Controller
{
    public function matchingProjects($id,$city,$cust_no,$source){
            $reportingarray=array();
            $data=array();
            $result=DB::connection('mysql_master')->Select("select req_id from re2_agent_ad_detail where req_id='".$id."'");
            if(count($result)==0){
                $res=DB::connection('mysql_master')->Insert("Insert into re2_agent_ad_detail(req_id,city,phone_no,source,req_status,inserted_time) values('".$id."','".$city."','".$cust_no."','".$source."','0',NOW())");
                $mappingapi=file_get_contents(config('constants.XPORA_ENDPOINT')."xpora-reloaded/public/MappingCompetency");
                $data['requirement_id']=$id;
                $data['city']=$city;
                $data['customer_no']=$cust_no;
                $data['source']=$source;
                $data['status']="Success";
            }
            else{
                $mappingapi=file_get_contents(config('constants.XPORA_ENDPOINT')."xpora-reloaded/public/MappingCompetency");
                $data['requirement_id']=$id;
                $data['city']=$city;
                $data['customer_no']=$cust_no;
                $data['source']=$source;
                $data['status']="Already Exist";
            }
            $reportingarray[]=$data;
    		header('Content-type: application/json');
        	$result2=json_encode($reportingarray);
       		echo $result2;
    }
}