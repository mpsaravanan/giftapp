<?php
namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;

class CompetencyController extends Controller
{
    public function __construct(){
        $this->apiModel = new Api();
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
               $result=DB::connection('mysql_master')->Update("update re2_agent_competency_profile set channel='$channel', role='$role',state_id='$stateIds',city_id='$cityIds',gender='$gender',total_follow_ups='$followups',source_1='$source',profession='$profession',category='$category',
                property_types='$propertyTypes',property_for_1='$propertyfor1',property_for_2='$propertyfor2',construction_phases='$cons_phase',price_min='$price_min',price_max='$price_max',area_min='$area_min',area_max='$area_max',bhks='$bhk',loan_requirement='$loan_req',purpose='$purpose',urgency='$urgency' where agent_id='$userid'"); 
                if($result){
                    $updateMongo=new MongoController();
                    $mongoupdate=$updateMongo->updateAgentUserDetail($userid);
                    $resp['status'] = 'success';
                    $resp['message'] = 'Sucessfully Updated!';   
                    header('Content-type: application/json');
                    echo json_encode($resp);
                }
            }
            else{
            $result= DB::connection('mysql_master')->insert("insert into re2_agent_competency_profile(agent_id,agent_name,channel,role,state_id,city_id,gender,total_follow_ups,source_1,profession,category,property_types,property_for_1,property_for_2,construction_phases,price_min,price_max,area_min,area_max,bhks,loan_requirement,purpose,urgency) 
            values('$userid','$uname','$channel','$role','$stateIds','$cityIds','$gender','$followups','$source','$profession','$category','$propertyTypes','$propertyfor1','$propertyfor2','$cons_phase','$price_min','$price_max','$area_min','$area_max','$bhk','$loan_req','$purpose','$urgency')");
                if($result){
                    $updateMongo=new MongoController();
                    $mongoupdate=$updateMongo->addAgentUserDetail();
                    $resp['status'] = 'success'; 
                    $resp['message'] = 'Sucessfully Added!';   
                    header('Content-type: application/json');
                    echo json_encode($resp);
                }
            }
    }
    public function getNewuser(){
        $res=DB::connection('mysql_master')->Select("SELECT id,name,email,level FROM re2_agent_login t1 WHERE NOT EXISTS (SELECT agent_id FROM re2_agent_competency_profile t2 WHERE t1.id = t2.agent_id and t1.is_deleted=0)");
        echo json_encode($res);
    }
    public function getExistuser(){
        $res=DB::connection('mysql_master')->Select("SELECT t1.id,t1.name,t1.email,t1.level FROM re2_agent_login t1, re2_agent_competency_profile t2 where t1.id = t2.agent_id and t1.is_deleted=0");
        echo json_encode($res);
    }
    public function viewCompetency(){
        $_id = Request::all();
        $id=$_id['id'];
        $data_resp=array();
        $citynames=array();
        $locnames=array();
        $pronames=array();
        $result=DB::connection('mysql_slave')->Select("SELECT * from re2_agent_competency_profile where agent_id='".$id."'");
        foreach ($result as $res) {
            $data['agent_id']=$res->agent_id;
            $data['agent_name']=$res->agent_name;
            $data['source_1']=$res->source_1;
            $data['cityid']=$res->city_id;
            $resultcity= DB::connection('mysql_slave')->select("select id,name from re2_cities where id in ($res->city_id)");
            foreach ($resultcity as $city) {
            $citynames[]=$city->name;
            }
            $cityname=implode(",",$citynames);
            $data['city_name']=$cityname;
            $loc=$res->locality_ids;
            $data['locid']=$res->locality_ids;
            if($loc!=''){
              $resultloc= DB::connection('mysql_slave')->select("select id,name from re2_locations where id in ($loc)");
              foreach ($resultloc as $locs) {
              $locnames[]=$locs->name;
              }
              $locname=implode(",",$locnames);
              $data['loc_name']=$locname;
            }
            else{
              $data['loc_name']="";
            }
            $pro=$res->project_ids;
            $data['proid']=$res->project_ids;
            if($pro!=''){
              $resultpro= DB::connection('mysql_slave')->select("select id,name from re2_projects where id in ($pro)");
              foreach ($resultpro as $pros) {
              $pronames[]=$pros->name;
              }
              $proname=implode(",",$pronames);
              $data['project_name']=$proname;
            }
            else{
              $data['project_name']="";
            }
            $data['property_for_1']=$res->property_for_1;
            $data['property_for_2']=$res->property_for_2;
            $data['category']=$res->category;
            $data['property_types']=$res->property_types;
            $data_resp[]=$data;
        }
        echo json_encode($data_resp);
    }
    public function competencyUpdate(){
      $source=$_POST['source'];
      $propertyfor1=$_POST['propertyfor1'];
      $propertyfor2=$_POST['propertyfor2'];
      $cityIds=$_POST['cityIds'];
      $propertyTypes=$_POST['propertyTypes'];
      $category=$_POST['category'];
      $agent_id=$_POST['agent_id'];
      $query=DB::connection('mysql_master')->Update("UPDATE re2_agent_competency_profile set city_id='$cityIds',source_1='$source',category='$category',property_types='$propertyTypes',property_for_1='$propertyfor1',property_for_2='$propertyfor2' where agent_id='$agent_id'");
      if($query){
          $updateMongo=new MongoController();
          $mongoupdate=$updateMongo->updateAgentUserDetail($agent_id);
          $resp['status'] = 'success'; 
          $resp['message'] = 'Sucessfully Updated!';   
          header('Content-type: application/json');
          echo json_encode($resp);
      }
    }

    public function getLocationbaseCity(){
       $_id = Request::all();
       $cityid=$_id['cityid'];
       $result=$this->apiModel->getLocationCompetency($cityid);
       $result1=$result['response'];
       $result2=json_decode($result1);
       echo json_encode($result2->data);
    }
    
    public function getProjectbaseLocation(){
       $_id = Request::all();
       $localityId=$_id['localityId'];
       $result=$this->apiModel->getProjectCompetency($localityId);
       $result1=$result['response'];
       $result2=json_decode($result1);
       echo json_encode($result2->data);
    }

    public function getAgentNames(){
        $result=DB::connection('mysql_slave')->Select("SELECT id,name from re2_agent_login where level='3' and is_deleted='0'");
        header('Content-type: application/json');
        echo json_encode($result);
    }
    public function getTlNames(){
        $result=DB::connection('mysql_slave')->Select("SELECT id,name from re2_agent_login where level='2' and is_deleted='0'");
        header('Content-type: application/json');
        echo json_encode($result);
    }
    public function getManagerNames(){
        $result=DB::connection('mysql_slave')->Select("SELECT id,name from re2_agent_login where level='1' and is_deleted='0'");
        header('Content-type: application/json');
        echo json_encode($result);
    }


}
