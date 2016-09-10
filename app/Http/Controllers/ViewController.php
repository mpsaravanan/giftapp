<?php
namespace App\Http\Controllers;
use Hamcrest\Arrays\MatchingOnce;
use Request;
//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;
class ViewController extends Controller
{
    public function __construct(){
        $this->apiModel = new Api();
    }
    public function userView(){
        //
        session_start();
        if(!isset($_SESSION['userlevel'])){
          return view('login');  
        }
        else if($_SESSION['userlevel']==3){
        $checkStatus=DB::connection('mysql_master')->select("Select aa.login_status from re2_agent_active aa, re2_agent_login al where al.id=aa.agent_id and al.level=3 and aa.agent_id='".$_SESSION['userid']."' and aa.login_status='1' and al.is_deleted=0");
            if(count($checkStatus)==0){
                return view('login');
            }
        }
        else if(!isset($_SESSION['userid'])){
            return view('login');
        }
        $dashboard=array();
        $data=array();
        //Super user Level 0
        if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['userlevel']==0){
            $result= DB::connection('mysql_master')->select("select * from re2_agent_login where level in(1,2,3) and is_deleted=0");
        }
        //Manager Level 1
        else if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['userlevel']==1){
            $result2= DB::connection('mysql_master')->select("select * from re2_agent_login where level in(2,3) and reporting_to='".$_SESSION['userid']."' and is_deleted=0");
            $reportingIds=array();
            foreach ($result2 as $res2) {
                $reportingIds[]=$res2->id;
            }
            $rep_ids=implode(",",$reportingIds);
            if($rep_ids!=''){
            $result= DB::connection('mysql_master')->select("select * from re2_agent_login where level in(2,3) and reporting_to in({$_SESSION['userid']},{$rep_ids}) and is_deleted=0");    
            }
            else{
            $result= DB::connection('mysql_master')->select("select * from re2_agent_login where level in(2,3) and reporting_to in({$_SESSION['userid']}) and is_deleted=0");        
            }
        }
        //Team Leader Level 2
        else if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['userlevel']==2){
            $result= DB::connection('mysql_master')->select("select * from re2_agent_login where level in(3) and reporting_to='".$_SESSION['userid']."' and is_deleted=0");    
        }
        //Telecaller Level 1
        else if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['userlevel']==3){
            $result= DB::connection('mysql_master')->select("select * from re2_agent_login where level in(3) and is_deleted=0");    
        }
        foreach($result as $res){
            $reprotingto= DB::connection('mysql_master')->select("select id,name,level from re2_agent_login where id='".$res->reporting_to."' and is_deleted=0");
            $data['reporting_id']=$reprotingto[0]->id;
            $data['reporting_name']=$reprotingto[0]->name;
            if($reprotingto[0]->level==0){ $data['reporting_level']="Super User";}
            else if($reprotingto[0]->level==1){ $data['reporting_level']="Manager";}
            else if($reprotingto[0]->level==2){ $data['reporting_level']="Team Leader";}
            else if($reprotingto[0]->level==3){ $data['reporting_level']="Telecaller";}
            else{ $data['reporting_level']="-";}
            $data['id']=$res->id;
            $data['name']=$res->name;
            $data['emp_id']=$res->emp_id;
            $data['email']=$res->email;
            $data['mobile']=$res->mobile;
            $data['reporting_to']=$res->reporting_to;
            $data['level']=$res->level;
            $data['created_time']=$res->created_time;
            $data['updated_time']=$res->updated_time;
            $dashboard[]=$data;
        }
        if($_SESSION['userlevel']==0){
            return view('superuser', array('dashboard' =>$dashboard));
        }
        else if($_SESSION['userlevel']==1){
            return view('manager', array('dashboard' =>$dashboard));
        }
        else if($_SESSION['userlevel']==2){
            return view('teamleader', array('dashboard' =>$dashboard));
        }
        else if($_SESSION['userlevel']==3){
            return view('telecaller');
        }
        else{
        return redirect('Login');
        }
    }
    public function searchDashboard(){
        
        $dashboard=array();
        $_getvalues = Request::all();
        $_name=$_getvalues['name'];
        $_empid=$_getvalues['empid'];
        $_level=$_getvalues['level'];
        $queryMain="select * from re2_agent_login where id!='' and level!=0 and is_deleted=0";
        if($_level!="N"){
            $queryMain.=" and level=$_level";
        }
        if($_name!="N"){
            $queryMain.=" and name like ('%$_name%')";
        }
        if($_empid!="N"){
            $queryMain.=" and emp_id='$_empid'";
        }
        $result= DB::connection('mysql_master')->select($queryMain);
        foreach($result as $res){
            $reprotingto= DB::connection('mysql_master')->select("select id,name,level from re2_agent_login where id='".$res->reporting_to."' and is_deleted=0");
            $data['reporting_id']=$reprotingto[0]->id;
            $data['reporting_name']=$reprotingto[0]->name;
            if($reprotingto[0]->level==0){ $data['reporting_level']="Super User";}
            else if($reprotingto[0]->level==1){ $data['reporting_level']="Manager";}
            else if($reprotingto[0]->level==2){ $data['reporting_level']="Team Leader";}
            else if($reprotingto[0]->level==3){ $data['reporting_level']="Telecaller";}
            else{ $data['reporting_level']="-";}
            $data['id']=$res->id;
            $data['name']=$res->name;
            $data['emp_id']=$res->emp_id;
            $data['email']=$res->email;
            $data['mobile']=$res->mobile;
            $data['reporting_to']=$res->reporting_to;
            $data['level']=$res->level;
            $data['created_time']=$res->created_time;
            $data['updated_time']=$res->updated_time;
            $dashboard[]=$data;
        }
        header('Content-type: application/json');
        echo json_encode($dashboard);
    }
    public function orgChart(){
        
        $_idlevel = Request::all();
        $id=$_idlevel['id'];
        $level=$_idlevel['level'];
        $chartarray=array();
        $result= DB::connection('mysql_master')->select("select id,name,email,emp_id,`level`,reporting_to from re2_agent_login where id=$id and is_deleted=0");
            foreach($result as $res){
                    $response1['id']=$res->id;
                    $response1['name']=$res->name;
                    $response1['level']=$res->level;
                    $response1['reportingto']=$res->reporting_to;
                    if($res->level==1){
                        $response1['position']="Manager";
                    }
                    else if($res->level==2){
                        $response1['position']="Team Leader";
                    }
                    else if($res->level==3){
                        $response1['position']="TeleCaller";
                    }
                    $chartarray[]=$response1;
                    //Higher Info
                    for($j=1;$j<=$res->reporting_to;$j++){
                        $result2= DB::connection('mysql_master')->select("select id,name,email,emp_id,`level`,reporting_to from re2_agent_login where id='".$j."' and is_deleted=0");
                        $response2['id']=$result2[0]->id;
                        $response2['name']=$result2[0]->name;
                        $response2['level']=$result2[0]->level;
                        $response2['reportingto']=$result2[0]->reporting_to;
                        if($result2[0]->level==0){
                            $response2['position']="Super Admin";      
                        }
                        else if($result2[0]->level==1){
                            $response2['position']="Manager";
                        }
                        else if($result2[0]->level==2){
                            $response2['position']="Team Leader";
                        }
                        else if($result2[0]->level==3){
                            $response2['position']="TeleCaller";
                        }
                        $chartarray[]=$response2;
                    }
                    $levQuery="";
                    //Lower Info
                    if($res->level==2){
                        $levQuery="select id,name,email,emp_id,`level`,reporting_to from re2_agent_login where level=3 and reporting_to='".$res->id."' and is_deleted=0";
                    }
                    if($res->level==1){
                        $reportLevel=DB::connection('mysql_master')->select("select GROUP_CONCAT(id) as ids from re2_agent_login where reporting_to=$res->id and is_deleted=0");
                        if(count($reportLevel)>=1 && !empty($reportLevel[0]->ids)){
                            $levQuery="select id,name,email,emp_id,`level`,reporting_to from re2_agent_login where (reporting_to='".$res->id."' or reporting_to in ({$reportLevel[0]->ids})) and is_deleted=0";
                        }
                        else{
                            $levQuery="select id,name,email,emp_id,`level`,reporting_to from re2_agent_login where (reporting_to='".$res->id."' and is_deleted=0)";
                        }
                    }
                    //echo $levQuery;
                    if($levQuery!=""){
                        $result3= DB::connection('mysql_master')->select($levQuery);
                        foreach($result3 as $res3){
                            $response3['id']=$res3->id;
                            $response3['name']=$res3->name;
                            $response3['level']=$res3->level;
                            if($res3->level==1){
                                $response3['position']="Manager";
                            }
                            else if($res3->level==2){
                                $response3['position']="Team Leader";
                            }
                            else if($res3->level==3){
                                $response3['position']="TeleCaller";
                            }
                            $response3['reportingto']=$res3->reporting_to;
                            $chartarray[]=$response3;
                        }
                    }
                }
                header('Content-type: application/json');
                echo json_encode($chartarray);
    }
    public function reportingTo(){
        
        $_level = Request::all();
        if($_level['level']!=0){
            $level=$_level['level']-1;
        }else{
            $level=0;
        }
        $reportingarray=array();
        $result= DB::connection('mysql_master')->select("select id,name,email,emp_id,level from re2_agent_login where level='".$level."' and is_deleted=0");
        foreach($result as $res){
            if($res->level==0){ $data['level']="Super User";}
            else if($res->level==1){ $data['level']="Manager";}
            else if($res->level==2){ $data['level']="Team Leader";}
            else if($res->level==3){ $data['level']="Telecaller";}
            else{ $data['level']="-";}
            $data['id']=$res->id;
            $data['name']=$res->name;
            $data['emp_id']=$res->emp_id;
            $data['email']=$res->email;
            $reportingarray[]=$data;
        }
        echo json_encode($reportingarray);
    }
    public function userDelete(){
        
        $_id = Request::all();
        $id=$_id['id'];
        $res= DB::connection('mysql_master')->select("select id from re2_agent_login where reporting_to='".$id."' and is_deleted=0");
        if(count($res)>=1){ 
            $resp['status'] = "Can't Delete";
            $resp['message'] = "You can't Delete,Someone Reporting to this Person";
            header('Content-type: application/json');
            echo json_encode($resp);
        }
        else{
            $result=DB::connection('mysql_master')->update("update re2_agent_login set is_deleted=1 where id='".$id."'");
           // $result1=DB::connection('mysql_master')->delete("delete from re2_agent_competency_profile where agent_id='".$id."'");
            //$result2=DB::connection('mysql_master')->delete("delete from re2_agent_login_logs where agent_id='".$id."'");
            $result3= DB::connection('mysql_master')->select("select id,agent_id,sip_id from re2_agent_active where agent_id='".$id."'");
            if(count($result3)>=1){
                foreach($result3 as $res){
                $result4=DB::connection('mysql_master')->update("update re2_agent_sip_allotment set status=0 where id='".$res->sip_id."'");
                }
            }
            $result4=DB::connection('mysql_master')->delete("delete from re2_agent_active where agent_id='".$id."'");
            if($result){ 
                $resp['status'] = 'Success'; 
                $resp['message'] = 'Deleted Sucessfull ';
                header('Content-type: application/json');
                echo json_encode($resp);
            }
        }
    }
    public function userEdit(){
        
        $uname=$_POST['inputuName'];
        $id=$_POST['inputId'];
        $emp_id=$_POST['inputuEmpid'];
        $email=$_POST['inputuEmail'];
        if(!empty($id) && !empty($emp_id)){
            $result= DB::connection('mysql_master')->select("select id,emp_id from re2_agent_login where id='".$id."' and emp_id='".$emp_id."' and is_deleted=0");
            if(count($result)==1){
                $resultupdate= DB::connection('mysql_master')->update("update re2_agent_login set name='".$uname."',email='".$email."' where id='".$id."'");
                $updateMongo=new MongoController();
                $mongoupdate=$updateMongo->updateAgentUserDetail($id);
                $resp['status'] = 'success';
                $resp['message'] = 'Profile Updated';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
            else{
                $resp['status'] = 'error'; 
                $resp['message'] = 'Error: Please try Again';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
        }
        else{
            $resp['status'] = 'error'; 
            $resp['message'] = 'Error: Please try Again';   
            header('Content-type: application/json');
            echo json_encode($resp);
        }
    }
    public function getCity(){
        
        $result= DB::connection('mysql_master')->select("select id,name from re2_cities ");
        header('Content-type: application/json');
        $result2=json_encode($result);
       echo $result2;
    }
    public function getSingleCity(){
        
        $result= DB::connection('mysql_master')->select("select id,name from re2_cities ");
        header('Content-type: application/json');
        $result2=json_encode($result);
       echo $result2;
    }
    public function citySearch(){
        
        $_cityquery = Request::all();
        $result=$this->apiModel->getCity();
        $response=$result['response'];
        $result_city=json_decode($response);
        $topCity=$result_city->topCities;
        $allCity=$result_city->allCities;
        $cities=array_merge($topCity,$allCity);
        foreach($cities as $key=>$val){
            $newarray[$val->id]=$val->name;
        }
        $matching  = preg_grep ("/^(.*){$_cityquery['cityidsearch']}(.*)$/i", $newarray);
        echo json_encode($matching);
    }
    public function getLoc(){
        
        $result= DB::connection('mysql_master')->select("select id,name from re2_locations ");
        header('Content-type: application/json');
        $result2=json_encode($result);
       echo $result2;
    }
    public function getProject(){
        
        $result= DB::connection('mysql_master')->select("select id,name from re2_projects ");
        header('Content-type: application/json');
        $result2=json_encode($result);
        echo $result2;
    }
    public function agentDetails(){
        $reportingarray=array();
        $_id = Request::all();
        session_start();
        if(isset($_SESSION['userlevel'])){        
        if($_SESSION['userlevel']==0){
            $query= "select a.id,name,emp_id,level,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3) and a.is_deleted=0";
        }
        else if($_SESSION['userlevel']==1){
            $result2= DB::connection('mysql_slave')->select("select id from re2_agent_login where level in(2,3) and reporting_to='".$_SESSION['userid']."' and is_deleted=0");
            $reportingIds=array();
            foreach ($result2 as $res2) {
                $reportingIds[]=$res2->id;
            }
            $rep_ids=implode(",",$reportingIds);
            if($rep_ids!=''){
                $query= "select a.id,name,emp_id,level,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3) and reporting_to in({$rep_ids}) and a.is_deleted=0";    
            }
            else{
                $query='';
            }
        }
        else if($_SESSION['userlevel']==2){
            $query="select a.id,name,emp_id,level,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3) and reporting_to='".$_SESSION['userid']."' and a.is_deleted=0";
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
        if($query!=''){
           //echo $query;
            //exit();
            $execute=DB::connection('mysql_slave')->Select($query);
            $reportingarray=array();
            foreach($execute as $_agentrep){
                $_ad=array();
                $_ad['agent_id']=$_agentrep->id;
                $_ad['agent_name']=$_agentrep->name;
                $_ad['agent_emp_id']=$_agentrep->emp_id;
                $_ad['manual_mode']=0;
                $_ad['auto_mode']=0;
                $_ad['calls_answered']=0;
                $_ad['actual_talktime']="00:00:00";
                $_ad['talktime']="00:00:00";
                $_ad['avg_actual_talktime']="00:00:00";
                $_ad['avg_talktime']="00:00:00";
                $_ad['hold_time']="00:00:00";
                $_city=$_agentrep->city_id;
                $cityQry=DB::connection('mysql_slave')->Select("select name from re2_cities where id='$_city'");
                foreach ($cityQry as $value) {
                    $city_name=$value->name;
                    $_ad['city']=$city_name;
                }
                
                $_source=$_agentrep->source_1;
                if($_agentrep->property_for_1!='' && $_agentrep->property_for_2==""){
                    $_propfor=$_agentrep->property_for_1;
                }elseif($_agentrep->property_for_1=='' && $_agentrep->property_for_2!=""){
                    $_propfor=$_agentrep->property_for_2;
                }else{
                    $_propfor=$_agentrep->property_for_1." ".$_agentrep->property_for_2;
                }
                $_category=$_agentrep->category;
                
                $_ad['source']=$_source;
                $_ad['pri_intent']=$_propfor;
                $_ad['sec_intent']=$_category;
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
                }
                elseif($_id['end_date']!='N' && $_id['start_date']=='N'){
                    $_callextraqry=" and timestamp<='".$_id['end_date']." 23:59:59'";
                }
                elseif($_id['end_date']!='N' && $_id['start_date']!='N'){
                    $_callextraqry=" and timestamp BETWEEN ('".$_id['start_date']." 00:00:00') AND ('".$_id['end_date']." 23:59:59')";
                }
                else{
                    $_callextraqry=" and timestamp>='".$today." 00:00:00'";
                }
                $_callmodeqry="select count(call_mode) as count,call_mode,r.created_date from re2_agent_call_cdr,re2_requirements r where r.id=xpora_req_id and telecaller_id='$_agentrep->id' and (legA_hcause='NORMAL_CLEARING' OR legA_hcause='SUCCESS') and (legB_hcause='SUCCESS')";
                $_callmodeqry.=" $_callextraqry group by call_mode";
                $count_callmode=DB::connection('mysql_slave')->Select($_callmodeqry);
                if(count($count_callmode)>=1){
                    foreach($count_callmode as $_callmode){
                        if($_callmode->call_mode=='1'){
                            $_ad['manual_mode']=$_callmode->count;
                        }
                        else{
                            $_ad['auto_mode']=$_callmode->count;    
                        }
                    }
                }
                $countqry="select count(*) as calls_answered,r.created_date from re2_agent_call_cdr,re2_requirements r where r.id=xpora_req_id and telecaller_id='$_agentrep->id' and (legA_hcause='NORMAL_CLEARING' OR legA_hcause='SUCCESS') and (legB_hcause='SUCCESS')";
                $countqry.=" $_callextraqry";
                $count_callans=DB::connection('mysql_slave')->Select($countqry);
                if(count($count_callans)>=1){
                    foreach($count_callans as $_callans){
                        $_ad['calls_answered']=$_callans->calls_answered;
                     }
                }
                $talktimeqry="select r.id,r.created_date,start_datetime_legA,start_datetime_legB,ring_datetime_legB,answer_datetime_legB,end_datetime_legB from re2_agent_call_cdr, re2_requirements r where r.id=xpora_req_id and telecaller_id='$_agentrep->id' and (legA_hcause='NORMAL_CLEARING' OR legA_hcause='SUCCESS') and (legB_hcause='SUCCESS')";
                $talktimeqry.=" $_callextraqry";
                //echo $talktimeqry;
                $talktimedetail=DB::connection('mysql_slave')->Select($talktimeqry);
                $ans02=1;
                $ans35=1;
                $ans5=1;
                $_ad['ans_02']="";
                $_ad['ans_35']="";
                $_ad['ans_5']="";
                if(count($talktimedetail)>=1){
                    foreach($talktimedetail as $_talktimedetail){
                        $connect_time=$_talktimedetail->start_datetime_legA;
                        $starttime=$_talktimedetail->start_datetime_legB;
                        $ringtime=$_talktimedetail->ring_datetime_legB;
                        $anstime=$_talktimedetail->answer_datetime_legB;
                        $endtime=$_talktimedetail->end_datetime_legB;
                        $enq_time=$_talktimedetail->created_date;
                        
                        $start = new \DateTime("$starttime");
                        $end = new \DateTime("$endtime");
                        $diff = $start->diff($end);
                        $_talktime[]=$diff->format('%H').":".$diff->format('%I').":".$diff->format('%S');
                        
                        $ans = new \DateTime("$anstime");
                        $diff2 = $ans->diff($end);
                        $_actalktime[]=$diff2->format('%H').":".$diff2->format('%I').":".$diff2->format('%S');
                        
                        $enq = new \DateTime("$enq_time");
                        $diff3 = $enq->diff($ans);
                        $ans_time=$diff3->format('%H').":".$diff3->format('%I').":".$diff3->format('%S');
                        //echo $ans_time."----<br>";
                        if($ans_time>='00:00:00' && $ans_time<='00:02:00')
                        {
                            //echo $ans_time."---".$ans02++."---------<br>";
                            $_ad['ans_02']=$ans02;
                            $ans02++; 
                        }
                        if($ans_time>'00:02:00' && $ans_time<='00:05:00')
                        {
                            $_ad['ans_35']=$ans35;
                            $ans35++;
                        }
                        if($ans_time>'00:05:00')
                        {
                            //echo $ans_time."----".$ans5."--------<br>";
                            $_ad['ans_5']=$ans5;
                            $ans5++;
                        }                     
                    }
                    $sumtk = strtotime('00:00:00');
                    $sum2=0;  
                    foreach ($_talktime as $ac){
                            $sum1=strtotime($ac)-$sumtk;
                            $sum2 = $sum2+$sum1;
                        }
                    $sum3=$sumtk+$sum2;
                    $_ad['talktime'] = date("H:i:s",$sum3);
                    $_ad['avg_talktime']= date('H:i:s', array_sum(array_map('strtotime', $_talktime)) / count($_talktime));
                    $sum = strtotime('00:00:00');
                    $sum22=0;  
                    foreach ($_actalktime as $ac){
                        $sum11=strtotime($ac)-$sum;
                            $sum22 = $sum22+$sum11;
                        }
                    $sum33=$sum+$sum22;
                    $_ad['actual_talktime'] = date("H:i:s",$sum33);
                    $_ad['avg_actual_talktime'] =  date('H:i:s', array_sum(array_map('strtotime', $_actalktime)) / count($_actalktime));
                }
                $reportingarray[]=$_ad;
            }
            header('Content-type: application/json');
            echo json_encode($reportingarray);
        }
        else{
            header('Content-type: application/json');
            echo json_encode($reportingarray);
        }
        }
        else{
            $reportingarray=array();
            header('Content-type: application/json');
            echo json_encode($reportingarray);
        }
    }
    public function campaignReport(){
        
        $_id = Request::all();
        session_start();
        //Get agent ids based on User Level...
        $agent_ids=array();
        $agent_result= DB::connection('mysql_slave')->select("select id from re2_agent_login where level=3 and is_deleted=0");
        foreach($agent_result as $ag){
            $agent_ids[]=$ag->id;
        }
        $agent_idval=implode(",",$agent_ids);
        $campaign_array=array();
        $_campaignreport['campaign_details']=array();
        $_campaignredata=array();
        //Select Campaigns Based Req_ids...
        $_callextraqry="";
        if($_id['city_name']!='N'){
            if(count($_id['city_name'])>=1){
                $_callextraqry.=" AND (";
                foreach($_id['city_name'] as $city_val){
                    $cityQry=DB::connection('mysql_slave')->Select("Select id,name from re2_cities where id='".$city_val."'");
                    $citynewname=$cityQry[0]->name;
                    $_callextraqry.=" a.city='$citynewname' OR";
                }
                $_callextraqry=substr($_callextraqry, 0, -2);
                $_callextraqry.=")"; 
            } 
        }
        if($_id['source_type']!='N'){
            $source_type="'". implode("', '", $_id['source_type']) ."'";
            $_callextraqry.=" and b.source_1 in($source_type)";
        }
        if($_id['primary_intent']!='N'){
            $primary_intent="'". implode("', '", $_id['primary_intent']) ."'";
            $_callextraqry.=" and b.property_for_1 in($primary_intent)";
        }
        if($_id['start_date']!='N' && $_id['end_date']=='N'){
            $_callextraqry.=" and a.inserted_time>='".$_id['start_date']." 00:00:00'";
        }
        elseif($_id['end_date']!='N' && $_id['start_date']=='N'){
            $_callextraqry.=" and a.inserted_time<='".$_id['end_date']." 23:59:59'";
        }
        elseif($_id['end_date']!='N' && $_id['start_date']!='N'){
            $_callextraqry.=" and a.inserted_time BETWEEN ('".$_id['start_date']." 00:00:00') AND ('".$_id['end_date']." 23:59:59')";
        }
        else{
            $today_date=date('Y-m-d');
            $_callextraqry.=" and a.inserted_time BETWEEN ('".$today_date." 00:00:00') AND ('".$today_date." 23:59:59')";
        }
        $campaign_qry="SELECT a.req_id,a.city,b.source_1,b.property_for_1,a.inserted_time FROM re2_agent_ad_detail as a,re2_requirements as b WHERE a.req_id=b.id $_callextraqry";
        $details_campaign=DB::connection('mysql_slave')->select($campaign_qry);
        if(count($details_campaign)>=1){
            $check_array=array();
            foreach($details_campaign as $detail){
                $_campaign=$detail->city."/".$detail->source_1."/".$detail->property_for_1;
                $campaign_array["$_campaign"][]=$detail->req_id;
            }
        }
        if(count($campaign_array)>=1){
            foreach($campaign_array as $key_campaign=>$val){
                $campValue=explode('/',$key_campaign);
                $_campaignredata['city']=$campValue[0];
                $_campaignredata['source']=$campValue[1];
                $_campaignredata['primary_intent']=$campValue[2];
                $_campaignredata['actual_talktime']="00:00:00";
                $_campaignredata['talktime']="00:00:00";
                $_campaignredata['avg_actual_talktime']="00:00:00";
                $_campaignredata['avg_talktime']="00:00:00";
                $xpora_req_ids=implode(",",$val);
                    $talktimeqry="select start_datetime_legB,ring_datetime_legB,answer_datetime_legB,end_datetime_legB from re2_agent_call_cdr where xpora_req_id in ($xpora_req_ids) and telecaller_id in ($agent_idval) and (legA_hcause='NORMAL_CLEARING' OR legA_hcause='SUCCESS') and (legA_hcause='NORMAL_CLEARING' OR legB_hcause='SUCCESS')";
                    //echo $talktimeqry;
                    $talktimedetail=DB::connection('mysql_slave')->Select($talktimeqry);
                    if(count($talktimedetail)>=1){
                        foreach($talktimedetail as $_talktimedetail){
                            $starttime=$_talktimedetail->start_datetime_legB;
                            $ringtime=$_talktimedetail->ring_datetime_legB;
                            $anstime=$_talktimedetail->answer_datetime_legB;
                            $endtime=$_talktimedetail->end_datetime_legB;
                            
                            $start = new \DateTime("$starttime");
                            $end = new \DateTime("$endtime");
                            $diff = $start->diff($end);
                            $_talktime[]=$diff->format('%H').":".$diff->format('%I').":".$diff->format('%S');
                            
                            $ans = new \DateTime("$anstime");
                            $diff2 = $ans->diff($end);
                            $_actalktime[]=$diff2->format('%H').":".$diff2->format('%I').":".$diff2->format('%S');
                        }
                        $sumtk = strtotime('00:00:00');
                        $sum2=0;  
                        foreach ($_talktime as $ac){
                                $sum1=strtotime($ac)-$sumtk;
                                $sum2 = $sum2+$sum1;
                            }
                        $sum3=$sumtk+$sum2;
                        $_campaignredata['talktime'] = date("H:i:s",$sum3);
                        $_campaignredata['avg_talktime']= date('H:i:s', array_sum(array_map('strtotime', $_talktime)) / count($_talktime));
                        $sum = strtotime('00:00:00');
                        $sum22=0;  
                        foreach ($_actalktime as $ac){
                            $sum11=strtotime($ac)-$sum;
                                $sum22 = $sum22+$sum11;
                            }
                        $sum33=$sum+$sum22;
                        $_campaignredata['actual_talktime'] = date("H:i:s",$sum33);
                        $_campaignredata['avg_actual_talktime'] =  date('H:i:s', array_sum(array_map('strtotime', $_actalktime)) / count($_actalktime));
                    }
                
                //$_campaignredata['talk_time']="23:03:76";
                $_campaignreport['campaign_details'][]=$_campaignredata;
            }
        }
        header('Content-type: application/json');
        echo json_encode($_campaignreport);
    }

    /**
     * Detail Call Report - Full Call History details
     */
    public function callDetailReport(){
        //Call Detail Report -- Jun 10 2016
        $_id = Request::all();
        session_start();
        $reportingarray=array();
        $limit = 30;
        if($_id['page']!='N'){
            $page=$_id['page'];
        }
        else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;

        $query= "SELECT b.user_name,a.telecaller_id,a.caller_no, a.xpora_req_id, recording_url, start_datetime_legA, start_datetime_legB, ring_datetime_legA, 
        ring_datetime_legB, answer_datetime_legB, end_datetime_legB, legB_hcause, a.timestamp, a.call_mode,b.source_1 as source,b.city_id,b.category as sintent,
        b.property_for_1 as pintent,b.status,b.remarks,c.name,c.emp_id
        FROM re2_agent_call_cdr AS a, re2_requirements AS b,re2_agent_login as c WHERE a.xpora_req_id = b.id AND a.telecaller_id=c.id";
        if($_id['dc_city']!='N' && !empty($_id['dc_city'])){
            if(count($_id['dc_city'])>=1){
                $query.=" AND (";
                foreach($_id['dc_city'] as $city_val){
                    $query.=" b.city_id='$city_val' OR";
                }
                $query=substr($query, 0, -2);
                $query.=")"; 
            } 
         }
         if($_id['dc_sourceType']!='N' && !empty($_id['dc_sourceType'])){
            if(count($_id['dc_sourceType'])>=1){
                $query.=" AND (";
                foreach($_id['dc_sourceType'] as $sourceval){
                    $query.=" b.source_1='$sourceval' OR";
                }
                $query=substr($query, 0, -2);
                $query.=")"; 
            } 
         }
         if(!empty($_id['dc_pIntent']) && $_id['dc_pIntent']!='N'){
            if(count($_id['dc_pIntent'])>=1){
                $query.=" AND (";
                foreach($_id['dc_pIntent'] as $primaryintentval){
                    $query.=" b.property_for_1='$primaryintentval' OR b.property_for_2='$primaryintentval' OR";
                }
                $query=substr($query, 0, -2);
                $query.=")"; 
            } 
         }
         if(!empty($_id['dc_sIntent']) && $_id['dc_sIntent']!='N'){
            if(count($_id['dc_sIntent'])>=1){
                $query.=" AND (";
                foreach($_id['dc_sIntent'] as $secintentval){
                    $query.=" b.category='$secintentval' OR b.category='$secintentval' OR";
                }
                $query=substr($query, 0, -2);
                $query.=")"; 
            } 
        }
        if($_id['phoneno']!='N' && !empty($_id['phoneno'])){
            $query.=" AND a.caller_no='".$_id['phoneno']."'";
        }
        if($_id['start_date']!='N' && $_id['end_date']=='N'){
            $queryTotal=$query." AND a.timestamp>='".$_id['start_date']."' order by timestamp desc";
            $query.=" AND a.timestamp>='".$_id['start_date']."' order by timestamp desc LIMIT $start_from, $limit";
        }
        elseif($_id['end_date']!='N' && $_id['start_date']=='N'){
            $queryTotal=$query." AND a.timestamp<='".$_id['end_date']."' order by timestamp desc";
            $query.=" AND a.timestamp<='".$_id['end_date']."' order by timestamp desc LIMIT $start_from, $limit";
        }
        elseif($_id['end_date']!='N' && $_id['start_date']!='N'){
            $queryTotal=$query." AND a.timestamp BETWEEN ('".$_id['start_date']."') AND ('".$_id['end_date']."') order by timestamp desc";
            $query.=" AND a.timestamp BETWEEN ('".$_id['start_date']."') AND ('".$_id['end_date']."') order by timestamp desc LIMIT $start_from, $limit";
        }
        else{
            $queryTotal=$query." order by timestamp desc";
            $query.=" order by timestamp desc LIMIT $start_from, $limit";
        }
        $result=DB::connection('mysql_slave')->Select($query);
        $resulttotal=DB::connection('mysql_slave')->Select($queryTotal);
        $_ad['date']="00:00:00";
        $_ad['duration']="00:00:00";
        $_ad['actual_talktime']="00:00:00";
        $_ad['talktime']="00:00:00";
        $_ad['ring_start_time']="00:00:00";
        $_ad['ring_end_time']="00:00:00";
        $_ad['ring_duration']="00:00:00";
        //$_ad['avg_talktime']="00:00:00";
        $_ad['call_status']="-";
        $_ad['orientation_type']="-";
        $_ad['competency_profile']="";
        $_ad['call_type']="-";
        $_ad['cust_name']="-";
        $_ad['cust_disposition']="-";
        $_ad['cust_number']="-";
        $_ad['lead_sent']="-";
        $_ad['dispos_count']="-";
        $_ad['next_calltime']="";
        foreach ($result as $_talktimedetail) {
            $_ad['agent_id']=$_talktimedetail->telecaller_id;
            $_ad['agent_name']=$_talktimedetail->name;
            $_ad['agent_emp_id']=$_talktimedetail->emp_id;

            $starttime=$_talktimedetail->start_datetime_legB;
            $ring_start_time=$_talktimedetail->ring_datetime_legA;
            $ring_end_time=$_talktimedetail->ring_datetime_legB;
            $anstime=$_talktimedetail->answer_datetime_legB;
            $endtime=$_talktimedetail->end_datetime_legB;

            $created_time=$_talktimedetail->timestamp;
            $con_time=$_talktimedetail->start_datetime_legA;
            $qs_time = new \DateTime("$created_time");
            $qe_time = new \DateTime("$con_time");
            $q_diff = $qs_time->diff($qe_time);
            $_queue_time=$q_diff->format('%S');
            //echo $_queue_time."+++".$created_time."-----".$con_time."-------".$_talktimedetail->telecaller_id;
            $_ad['source']=$_talktimedetail->source;
            $_ad['pri_intent']=$_talktimedetail->pintent;
            $_ad['sec_intent']=$_talktimedetail->sintent;

            $_ad['queue_time']=$_queue_time;
            $_ad['ring_start_time'] = $_talktimedetail->ring_datetime_legA;
            $_ad['ring_end_time'] = $_talktimedetail->ring_datetime_legB;
            $causecode=$_talktimedetail->legB_hcause;
            $_ad['call_status']=$this->getHangupCause($causecode);
            $_ad['date']=$_talktimedetail->timestamp;
            $_ad['req_id']=$_talktimedetail->xpora_req_id;
            $cityres=$_talktimedetail->city_id;
            $cityQry=DB::connection('mysql_master')->Select("select name from re2_cities where id='$cityres'");
            $_ad['city']=$cityQry[0]->name;
            $_ad['orientation_type']="OUTBOUND";
            $_ad['recording_url']=$_talktimedetail->recording_url;
            $_ad['actual_talktime']="00:00:00";
            $_ad['talktime']="00:00:00";
            if($_talktimedetail->call_mode==0){
                $_ad['call_type']="PROGRESSIVE";
            }
            if($_talktimedetail->call_mode==1){
                $_ad['call_type']="PREVIEW";
            }
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            $_talktime=$diff->format('%H').":".$diff->format('%I').":".$diff->format('%S');
            $sumtk = strtotime('00:00:00');
            $sum2=0;
            $sum1=strtotime($_talktime)-$sumtk;
            $sum2 = $sum2+$sum1;
            $sum3=$sumtk+$sum2;
            $_ad['talktime'] = date("H:i:s",$sum3);
            $_ad['duration']=$diff->format('%H').":".$diff->format('%I').":".$diff->format('%S');

            $ans = new \DateTime("$anstime");
            $diff2 = $ans->diff($end);
            $_actalktime=$diff2->format('%H').":".$diff2->format('%I').":".$diff2->format('%S');

            $sum = strtotime('00:00:00');
            $sum22=0;
            $sum11=strtotime($_actalktime)-$sum;
            $sum22 = $sum22+$sum11;
            $sum33=$sum+$sum22;
            $_ad['actual_talktime'] = date("H:i:s",$sum33);

            $ring_start = new \DateTime("$ring_start_time");
            $ring_end = new \DateTime("$ring_end_time");
            $diff3 = $ring_start->diff($ring_end);
            $_ringtime[]=$diff3->format('%H').":".$diff3->format('%I').":".$diff3->format('%S');
            $_ad['ring_duration']=$diff3->format('%H').":".$diff3->format('%I').":".$diff3->format('%S');
            $_ad['cust_name']=$_talktimedetail->user_name;
            $_ad['cust_disposition']=$_talktimedetail->status;
            $telecaller_id=$_talktimedetail->telecaller_id;
            if($_talktimedetail->status=='RINGING_NO_RESPONSE_CALLBACK_AT' || $_talktimedetail->status=='NON_CONT_RINGING_NO_RESPONSE' || $_talktimedetail->status=='NON_CONT_BUSY_OR_WAITING' || $_talktimedetail->status=='CALL_BACK_AT' || $_talktimedetail->status=='NON_CONT_CUSTOMER_DISCONNECT' || $_talktimedetail->status=='NON_CONT_NOT_REACHABLE' || $_talktimedetail->status=='CALL_BACK_LATER' || $_talktimedetail->status=='NON_CONT_SWITCHED_OFF' || $_talktimedetail->status=='CONT_CALL_BK_DETAILSENT_EMAIL'){
                $next_qry=DB::connection('mysql_slave')->Select("select call_back_datetime from re2_requirement_call_dispositions  where req_id='{$_talktimedetail->xpora_req_id}' and message='{$_talktimedetail->status}' and tele_caller_id='$telecaller_id' ");
                foreach ($next_qry as $value) {
                    $_ad['next_calltime']=$value->call_back_datetime;
                }
            }
            else{
                $_ad['next_calltime']="";
            }
            $_ad['remarks']=$_talktimedetail->remarks;
            $_ad['cust_number']=$_talktimedetail->caller_no;

            $dispos=DB::connection('mysql_slave')->Select("Select req_id from re2_agent_matchmaking_email_status where req_id='$_talktimedetail->xpora_req_id' and agent_id='$_talktimedetail->telecaller_id'");
            if(count($dispos)==1){
                $_ad['lead_sent']="Yes";
            }
            else{
                $_ad['lead_sent']="No";
            }
            $reportingarray[]=$_ad;
        }
        $total_records = count($resulttotal);
        $total_pages = ceil($total_records / $limit);
        $_result['total_records']=$total_records;
        $_result['pages']=$total_pages;
        $_result['details']=$reportingarray;
        header('Content-type: application/json');
        $result2=json_encode($_result);
        echo $result2;
    }
    public function callDetailReportDownload(){
        //Call Detail Report -- Jun 10 2016
        $_id = Request::all();
        session_start();
        $reportingarray=array();
        $time=time();
        $filename="$time"."xpora-detailcall-report.csv";
        $file=fopen("./".$filename,'w');
        $th=array("Agent ID","Agent Name","Req ID","City","Source","Primary Intent","Property Type","Call Status",
            "Customer Name","Customer No","Call Duration","Talk Time","Call Type","Orientation Type","Created Time","Disposition",
            "Ring StartTime","Ring EndTime","Ring Duration","Actual Talktime","Lead Sent","Recording URL","Next Call Time","Remarks");
        $thdetail='"'. join('","', $th). '"'."\n";
        fputcsv($file, $th);
        $query= "SELECT b.user_name,a.telecaller_id,a.caller_no, a.xpora_req_id, recording_url, start_datetime_legA, start_datetime_legB, ring_datetime_legA, 
        ring_datetime_legB, answer_datetime_legB, end_datetime_legB, legB_hcause, a.timestamp, a.call_mode,b.source_1 as source,b.city_id,b.category as sintent,
        b.property_for_1 as pintent,b.status,b.remarks,c.name,c.emp_id
        FROM re2_agent_call_cdr AS a, re2_requirements AS b,re2_agent_login as c WHERE a.xpora_req_id = b.id AND a.telecaller_id=c.id";
        if($_id['dc_city']!='N' && !empty($_id['dc_city'])){
            if(count($_id['dc_city'])>=1){
                $query.=" AND (";
                foreach($_id['dc_city'] as $city_val){
                    $query.=" b.city_id='$city_val' OR";
                }
                $query=substr($query, 0, -2);
                $query.=")";
            }
        }
        if($_id['dc_sourceType']!='N' && !empty($_id['dc_sourceType'])){
            if(count($_id['dc_sourceType'])>=1){
                $query.=" AND (";
                foreach($_id['dc_sourceType'] as $sourceval){
                    $query.=" b.source_1='$sourceval' OR";
                }
                $query=substr($query, 0, -2);
                $query.=")";
            }
        }
        if(!empty($_id['dc_pIntent']) && $_id['dc_pIntent']!='N'){
            if(count($_id['dc_pIntent'])>=1){
                $query.=" AND (";
                foreach($_id['dc_pIntent'] as $primaryintentval){
                    $query.=" b.property_for_1='$primaryintentval' OR b.property_for_2='$primaryintentval' OR";
                }
                $query=substr($query, 0, -2);
                $query.=")";
            }
        }
        if(!empty($_id['dc_sIntent']) && $_id['dc_sIntent']!='N'){
            if(count($_id['dc_sIntent'])>=1){
                $query.=" AND (";
                foreach($_id['dc_sIntent'] as $secintentval){
                    $query.=" b.category='$secintentval' OR b.category='$secintentval' OR";
                }
                $query=substr($query, 0, -2);
                $query.=")";
            }
        }
        if($_id['phoneno']!='N' && !empty($_id['phoneno'])){
            $query.=" AND a.caller_no='".$_id['phoneno']."'";
        }
        if($_id['start_date']!='N' && $_id['end_date']=='N'){
            $query.=" AND a.timestamp>='".$_id['start_date']."' order by timestamp desc";
        }
        elseif($_id['end_date']!='N' && $_id['start_date']=='N'){
            $query.=" AND a.timestamp<='".$_id['end_date']."' order by timestamp desc";
        }
        elseif($_id['end_date']!='N' && $_id['start_date']!='N'){
            $query.=" AND a.timestamp BETWEEN ('".$_id['start_date']."') AND ('".$_id['end_date']."') order by timestamp desc";
        }
        else{
            $query.=" order by timestamp desc";
        }
        $result=DB::connection('mysql_slave')->Select($query);
        $_ad['date']="00:00:00";
        $_ad['duration']="00:00:00";
        $_ad['actual_talktime']="00:00:00";
        $_ad['talktime']="00:00:00";
        $_ad['ring_start_time']="00:00:00";
        $_ad['ring_end_time']="00:00:00";
        $_ad['ring_duration']="00:00:00";
        //$_ad['avg_talktime']="00:00:00";
        $_ad['call_status']="-";
        $_ad['orientation_type']="-";
        $_ad['competency_profile']="";
        $_ad['call_type']="-";
        $_ad['cust_name']="-";
        $_ad['cust_disposition']="-";
        $_ad['cust_number']="-";
        $_ad['lead_sent']="-";
        $_ad['dispos_count']="-";
        $_ad['next_calltime']="";
        foreach ($result as $_talktimedetail) {
            $_ad['agent_id']=$_talktimedetail->telecaller_id;
            $_ad['agent_name']=$_talktimedetail->name;
            $_ad['agent_emp_id']=$_talktimedetail->emp_id;

            $starttime=$_talktimedetail->start_datetime_legB;
            $ring_start_time=$_talktimedetail->ring_datetime_legA;
            $ring_end_time=$_talktimedetail->ring_datetime_legB;
            $anstime=$_talktimedetail->answer_datetime_legB;
            $endtime=$_talktimedetail->end_datetime_legB;

            $created_time=$_talktimedetail->timestamp;
            $con_time=$_talktimedetail->start_datetime_legA;
            $qs_time = new \DateTime("$created_time");
            $qe_time = new \DateTime("$con_time");
            $q_diff = $qs_time->diff($qe_time);
            $_queue_time=$q_diff->format('%S');
            //echo $_queue_time."+++".$created_time."-----".$con_time."-------".$_talktimedetail->telecaller_id;
            $_ad['source']=$_talktimedetail->source;
            $_ad['pri_intent']=$_talktimedetail->pintent;
            $_ad['sec_intent']=$_talktimedetail->sintent;

            $_ad['queue_time']=$_queue_time;
            $_ad['ring_start_time'] = $_talktimedetail->ring_datetime_legA;
            $_ad['ring_end_time'] = $_talktimedetail->ring_datetime_legB;
            $causecode=$_talktimedetail->legB_hcause;
            $_ad['call_status']=$this->getHangupCause($causecode);
            $_ad['date']=$_talktimedetail->timestamp;
            $_ad['req_id']=$_talktimedetail->xpora_req_id;
            $cityres=$_talktimedetail->city_id;
            $cityQry=DB::connection('mysql_slave')->Select("select name from re2_cities where id='$cityres'");
            $_ad['city']=$cityQry[0]->name;
            $_ad['orientation_type']="OUTBOUND";
            $_ad['recording_url']=$_talktimedetail->recording_url;
            $_ad['actual_talktime']="00:00:00";
            $_ad['talktime']="00:00:00";
            if($_talktimedetail->call_mode==0){
                $_ad['call_type']="PROGRESSIVE";
            }
            if($_talktimedetail->call_mode==1){
                $_ad['call_type']="PREVIEW";
            }
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            $_talktime=$diff->format('%H').":".$diff->format('%I').":".$diff->format('%S');
            $sumtk = strtotime('00:00:00');
            $sum2=0;
            $sum1=strtotime($_talktime)-$sumtk;
            $sum2 = $sum2+$sum1;
            $sum3=$sumtk+$sum2;
            $_ad['talktime'] = date("H:i:s",$sum3);
            $_ad['duration']=$diff->format('%H').":".$diff->format('%I').":".$diff->format('%S');

            $ans = new \DateTime("$anstime");
            $diff2 = $ans->diff($end);
            $_actalktime=$diff2->format('%H').":".$diff2->format('%I').":".$diff2->format('%S');

            $sum = strtotime('00:00:00');
            $sum22=0;
            $sum11=strtotime($_actalktime)-$sum;
            $sum22 = $sum22+$sum11;
            $sum33=$sum+$sum22;
            $_ad['actual_talktime'] = date("H:i:s",$sum33);

            $ring_start = new \DateTime("$ring_start_time");
            $ring_end = new \DateTime("$ring_end_time");
            $diff3 = $ring_start->diff($ring_end);
            $_ringtime[]=$diff3->format('%H').":".$diff3->format('%I').":".$diff3->format('%S');
            $_ad['ring_duration']=$diff3->format('%H').":".$diff3->format('%I').":".$diff3->format('%S');
            $_ad['cust_name']=$_talktimedetail->user_name;
            $_ad['cust_disposition']=$_talktimedetail->status;
            $telecaller_id=$_talktimedetail->telecaller_id;
            if($_talktimedetail->status=='RINGING_NO_RESPONSE_CALLBACK_AT' || $_talktimedetail->status=='NON_CONT_RINGING_NO_RESPONSE' || $_talktimedetail->status=='NON_CONT_BUSY_OR_WAITING' || $_talktimedetail->status=='CALL_BACK_AT' || $_talktimedetail->status=='NON_CONT_CUSTOMER_DISCONNECT' || $_talktimedetail->status=='NON_CONT_NOT_REACHABLE' || $_talktimedetail->status=='CALL_BACK_LATER' || $_talktimedetail->status=='NON_CONT_SWITCHED_OFF' || $_talktimedetail->status=='CONT_CALL_BK_DETAILSENT_EMAIL'){
                $next_qry=DB::connection('mysql_slave')->Select("select call_back_datetime from re2_requirement_call_dispositions  where req_id='{$_talktimedetail->xpora_req_id}' and message='{$_talktimedetail->status}' and tele_caller_id='$telecaller_id' ");
                foreach ($next_qry as $value) {
                    $_ad['next_calltime']=$value->call_back_datetime;
                }
            }
            else{
                $_ad['next_calltime']="";
            }
            $_ad['remarks']=$_talktimedetail->remarks;
            $_ad['cust_number']=$_talktimedetail->caller_no;

            $dispos=DB::connection('mysql_slave')->Select("Select req_id from re2_agent_matchmaking_email_status where req_id='$_talktimedetail->xpora_req_id' and agent_id='$_talktimedetail->telecaller_id'");
            if(count($dispos)==1){
                $_ad['lead_sent']="Yes";
            }
            else{
                $_ad['lead_sent']="No";
            }
            $contentarray=array($_ad['agent_id'],$_ad['agent_name'],$_ad['req_id'],$_ad['city'],$_ad['source'],$_ad['pri_intent'],$_ad['sec_intent'],$_ad['call_status'],$_ad['cust_name'],$_ad['cust_number'],$_ad['duration'],$_ad['talktime'],$_ad['call_type'],$_ad['orientation_type'],$_ad['date'],$_ad['cust_disposition'],$_ad['ring_start_time'],$_ad['ring_end_time'],$_ad['ring_duration'],$_ad['actual_talktime'],$_ad['lead_sent'],$_ad['recording_url'],$_ad['next_calltime'],$_ad['remarks']);
            $str10 = '"'. join('","', $contentarray). '"'."\n";
            fputcsv($file, $contentarray);
        }
        fclose($file);
        echo $filename;
    }

    /**
     * @param $causecode HangupB Cause Code
     */
    public function getHangupCause($causecode){
        $_callstatus="";
        if($causecode=="NORMAL_UNSPECIFIED"){
            $_callstatus='Abandon';
        }elseif($causecode=="SUCCESS"){
            $_callstatus='Answered_01';
        }elseif($causecode=="NORMAL_CLEARING"){
            $_callstatus='Answered_02';
        }elseif($causecode=="NO_ANSWER" || $causecode=="MEDIA_TIMEOUT" || $causecode=="NORMAL_TEMPORARY_FAILURE"){
            $_callstatus='noans';
        }elseif($causecode=="USER_BUSY"){
            $_callstatus='Busy';
        }elseif($causecode=="DESTINATION_OUT_OF_ORDER" || $causecode=="SERVICE_UNAVAILABLE" || $causecode=="UNALLOCATED_NUMBER" || $causecode=="NORMAL_CIRCUIT_CONGESTION" || $causecode=="SWITCH_CONGESTION"){
            $_callstatus='Not Reachable';
        }elseif($causecode=="NO_USER_RESPONSE"){
            $_callstatus='RNR';
        }elseif($causecode=="ORIGINATOR_CANCEL"){
            $_callstatus='Agent disconnect';
        }elseif($causecode=="nil"){
            $_callstatus='Telecaller Not register';
        }elseif($causecode=="NO_ROUTE_DESTINATION"){
            $_callstatus='Network Issue';
        }elseif($causecode=="INTERWORKING"){
            $_callstatus='Network_issue02';
        }elseif($causecode=="INVALID_NUMBER_FORMAT" || $causecode=="USER_NOT_REGISTERED" || $causecode=="NETWORK_OUT_OF_ORDER"){
            $_callstatus='Invalid No';
        }elseif($causecode=="CALL_REJECTED"){
            $_callstatus='Seeker Disconnect';
        }elseif($causecode=="SUBSCRIBER_ABSENT"){
            $_callstatus="No doesn't exit_01";
        }else{
            $_callstatus=$causecode;
        }
        return $_callstatus;
    }

    public function totalLoginReport(){
        
        $_id = Request::all();
        $reportingarray=array();
        $str="Select a.name,a.id,al.login_time,al.logout_time,sa.login_status from re2_agent_login a,re2_agent_login_logs al,re2_agent_active sa where a.id=al.agent_id and a.id=sa.agent_id and a.is_deleted=0";
        if($_id['agent_name']!='N'){
            $str.=" and a.name='".$_id['agent_name']."' ";
        }
        if($_id['start_date']!='N' && $_id['end_date']=='N'){
            $str.=" and al.created_time>=('".$_id['start_date']." 00:00:00')";
        }
        elseif($_id['end_date']!='N' && $_id['start_date']=='N'){
            $str.=" and al.created_time<=('".$_id['end_date']." 23:59:59')";
        }
        elseif($_id['end_date']!='N' && $_id['start_date']!='N'){
            $str.=" and al.created_time BETWEEN ('".$_id['start_date']." 00:00:00') AND ('".$_id['end_date']." 23:59:59')";
        }
        else{
            $str.= " order by al.created_time desc limit 0,50";
        }
        
        $data['report']=$str; 
        $result=DB::connection('mysql_slave')->Select($str);
        foreach ($result as $res) {
           $data['agent_name']=$res->name;
           $data['agent_id']=$res->id;
           $data['login_time']=$res->login_time;
           $data['logout_time']=$res->logout_time;
           $end=date_create($res->logout_time);
           $start=date_create($res->login_time);
           if($res->logout_time!='0000-00-00 00:00:00'){
               $diff=date_diff($end,$start);
               $val= $diff->h.":".$diff->i.":".$diff->s;
           }
           else{
            $val="00:00:00";
           }
           $data['total_login_time']=$val;
           if($res->login_status=='0'){$data['agent_status']="Logout";}
           if($res->login_status=='1'){$data['agent_status']="Login";}
           $reportingarray[]=$data;
        }
        header('Content-type: application/json');
        $result2=json_encode($reportingarray);
        echo $result2;
    }
    
    public function agentLoggedinReport(){
        
        $_id = Request::all();
        session_start();
        if($_SESSION['userlevel']==0){
            $query= "select a.id,name,emp_id,level,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3) and a.is_deleted=0";
        }
        else if($_SESSION['userlevel']==1){
            $result2= DB::connection('mysql_master')->select("select id from re2_agent_login where level in(2,3) and reporting_to='".$_SESSION['userid']."' and is_deleted=0");
            $reportingIds=array();
            foreach ($result2 as $res2) {
                $reportingIds[]=$res2->id;
            }
            $rep_ids=implode(",",$reportingIds);
            if($rep_ids!=''){
                $query= "select a.id,name,emp_id,level,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3) and reporting_to in({$rep_ids}) and a.is_deleted=0";    
            }
            else{
                $query='';
            }
        }
        else if($_SESSION['userlevel']==2){
            $query="select a.id,name,emp_id,level,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3) and reporting_to='".$_SESSION['userid']."' and a.is_deleted=0";    
        }
        if($_id['city']!='N' && !empty($_id['city'])){
            $city="'". implode("', '", $_id['city']) ."'";
            $query.=" and city_id in($city)";
        }
        if(!empty($_id['source']) && $_id['source']!='N'){
            $source=implode(",", $_id['source']);
           $query.=" and b.source_1 like '%{$source}%'";
        }
        if(!empty($_id['p_intent']) && $_id['p_intent']!='N'){
            $p_intent=implode(",", $_id['p_intent']);
           $query.=" and (b.property_for_1 like '%{$p_intent}%' OR b.property_for_2 like '%{$p_intent}%')";
        }
        if(!empty($_id['s_intent']) && $_id['s_intent']!='N'){
            $s_intent=implode(",", $_id['s_intent']);
           $query.=" and b.category like '%{$s_intent}%'";
        }
        $_ad=array();
        if($query!=''){
            $execute=DB::connection('mysql_slave')->Select($query);
            $reportingarray=array();
            $agent=array();
            foreach ($execute as $_agentLogrep) {
                $agent_id=$_agentLogrep->id;
                $_ad['agent_name']=$_agentLogrep->name;
                $_ad['agent_id']=$_agentLogrep->id;
                $_city=$_agentLogrep->city_id;
                $cityQry=DB::connection('mysql_slave')->Select("select name from re2_cities where id='$_city'");
                foreach ($cityQry as $value) {
                    $city_name=$value->name;
                    $_ad['city']=$city_name;
                }
                $_source=$_agentLogrep->source_1;
                if($_agentLogrep->property_for_1!='' && $_agentLogrep->property_for_2==""){
                    $_propfor=$_agentLogrep->property_for_1;
                }elseif($_agentLogrep->property_for_1=='' && $_agentLogrep->property_for_2!=""){
                    $_propfor=$_agentLogrep->property_for_2;
                }else{
                    $_propfor=$_agentLogrep->property_for_1." ".$_agentLogrep->property_for_2;
                }
                $_category=$_agentLogrep->category;
                $_ad['source']=$_source;
                $_ad['pri_intent']=$_propfor;
                $_ad['sec_intent']=$_category;
                $str="Select c.xpora_req_id,c.start_datetime_legA as start_time,c.end_datetime_legA as end_time,c.timestamp,s.sip_id,sa.sip_number,sa.status from re2_agent_call_cdr c,re2_agent_active s,re2_agent_sip_allotment sa where c.telecaller_id='$agent_id' and c.telecaller_id=s.agent_id and s.sip_id=sa.id";
                if($_id['start_date']!='N' && $_id['end_date']=='N'){
                    $str.=" and c.start_datetime_legA>=('".$_id['start_date']." 00:00:00')";
                }
                elseif($_id['end_date']!='N' && $_id['start_date']=='N'){
                    $str.=" and c.start_datetime_legA<=('".$_id['end_date']." 23:59:59')";
                }
                elseif($_id['end_date']!='N' && $_id['start_date']!='N'){
                    $str.=" and c.start_datetime_legA BETWEEN ('".$_id['start_date']." 00:00:00') AND ('".$_id['end_date']." 23:59:59')";
                }
                $str.=" order by c.timestamp desc limit 0,50";
                $result=DB::connection('mysql_slave')->Select($str);
                foreach ($result as $res) {
                    
                    $_ad['sip_number']=$res->sip_number;
                    $_ad['call_date']=$res->timestamp;
                    $_ad['day']=date("l",strtotime($res->timestamp));
                    $_ad['week']="";
                    $reportingarray[]=$_ad;   
                }
            }
        }
        header('Content-type: application/json');
        $result2=json_encode($reportingarray);
        echo $result2;   
    }
    public function pendingReport(){
        
        $agent = Request::all();
        if(isset($agent['tc_name'])){
            $tc_name=$agent['tc_name'];
        }
        else{
            $tc_name="";
        }
        if(isset($agent['source'])){
            $source=$agent['source'];
        }
        else{
            $source="";
        }
        if(isset($agent['category'])){
            $category=$agent['category'];
        }
        else{
            $category="";
        }
        session_start();
        if(isset($_SESSION['userid'])){
        $updatesip= DB::connection('mysql_master')->update("update re2_agent_active set manual_call_status=1 where agent_id='".$_SESSION['userid']."'");
        $reportingarray=array();
        $result=DB::connection('mysql_slave')->Select("Select id,status,user_name from re2_requirements where status!='RIGHT_PARTY_INT_RD'  limit 0,50");
        foreach ($result as $res) {
            $str="Select cp.agent_id,cp.agent_name,cp.city_id,cp.source_1,cp.category,cp.property_types,rc.legA_hcause,rc.timestamp,rc.caller_no from re2_agent_call_cdr rc,re2_agent_competency_profile cp where cp.agent_id=rc.telecaller_id and rc.xpora_req_id='$res->id' and rc.legA_hcause!='NORMAL_CLEARING' and rc.legA_hcause!='SUCCESS'";
            if(!empty($tc_name)){
                $str.=" and cp.agent_name='$tc_name'";
              }
            if(!empty($source)){ 
                $str.=" and cp.source_1 like '%$source%'";
            }
            if(!empty($category)){ 
                $str.=" and cp.category like '%$tc_name%'";
            }
            $str.=" order by rc.timestamp desc limit 0,50";
           // echo $str."<br>";
            $result2=DB::connection('mysql_slave')->Select($str);
            foreach ($result2 as $res2) {
                $city=DB::connection('mysql_master')->Select("select id,name from re2_cities where id in($res2->city_id)");
                $city_v=array();
                foreach ($city as $city) {
                  $city_v[]=$city->name;  
                }
                $data['datetime']=$res2->timestamp;
                $data['agent_name']=$res2->agent_name;
                $data['agent_id']=$res2->agent_id;
                $data['city']=$city_v;
                $data['dis_status']=$res->status;
                $data['source']=$res2->source_1;
                $data['category']=$res2->category;
                $data['property_types']=$res2->property_types;
                $data['req_id']=$res->id;
                $data['seeker_no']=$res2->caller_no;
                $data['req_username']=$res->user_name;
                $data['call_status']=$res2->legA_hcause;
                $reportingarray[]=$data; 
            }
        }
        header('Content-type: application/json');
        $result3=json_encode($reportingarray);
        echo $result3;
        }
        else{
            $reportingarray=array();
            header('Content-type: application/json');
            echo json_encode($reportingarray);
        }
    }
    
    public function getTelecaller(){
        
        session_start();
        $_id = Request::all();
        $cityname=$_id['getCity'];
        $reportagent=array();
        $result_city=DB::connection('mysql_slave')->Select("SELECT id FROM `re2_cities` where name = '".$cityname."'");
        $city_id = $result_city[0]->id;
        $result_agent=DB::connection('mysql_slave')->Select("SELECT id, agent_id, agent_name FROM `re2_agent_competency_profile` where  FIND_IN_SET($city_id, city_id)");
                 foreach ($result_agent as $res_agent) {
                    $agent_data['id']=$res_agent->id;
                    $agent_data['agent_id']=$res_agent->agent_id;
                    $agent_data['agent_name']=$res_agent->agent_name;
                    $reportagent[]=$agent_data;
                    $agent_data = null;
        }    header('Content-type: application/json');
            $result3=json_encode($reportagent);
            echo $result3;
    }

     public function getSingleSearchLocality(){
        
        session_start();
        $_id = Request::all();
        $city_id =$_id['getCity'];
        $reportingarray=array();
        $data=array();        
        //$result_city=DB::connection('mysql_master')->Select("SELECT id FROM `re2_cities` where name = '".$cityname."'");
        //$city_id = $result_city[0]->id;
        $result_locality=DB::connection('mysql_slave')->Select("SELECT id, name FROM  re2_locations WHERE city_id =".$city_id."");
        foreach ($result_locality as $res_locality) {
                    $data['id']=$res_locality->id;
                    $data['name']=$res_locality->name;
                    $reportingarray[]=$data;
       } 
       
        header('Content-type: application/json');
        $result3=json_encode($reportingarray);
        echo $result3; 



      }


        public function getUserSearchMakeCall(){
            
        session_start();
        $_id = Request::all();
        $reportingarray=array();
        $uscity  =  $_id['uscity'];
        $usstart_date  =  $_id['ustart_date'];
        $usend_date  =  $_id['usend_date'];
        //$uslast_assigned_tl  =  $_id['uslast_assigned_tl'];
        $usemail  =  $_id['usemail'];
        $usemail =  explode(',',$usemail);
        //$usseeker  =  $_id['usseeker'];
        $usreqid = $_id['usreqid']; 
        $uslocality  =  $_id['uslocality'];
        //$uslead_dropped_to_project_name  =  $_id['uslead_dropped_to_project_name'];

        //echo "<br>uslocality ".$uslocality[0];

        $uslast_call_dispotion  =  $_id['uslast_call_dispotion'];
    
        //$query= "SELECT DISTINCT (caller_no) AS caller_no, user_name, xpora_req_id, racc.timestamp as telephony_timestamp, legA_hcause, legB_hcause, called_no, agent_name, racp.city_id AS city_id, racp.category AS category, racp.property_types AS property_types, rr.source_1 AS source_1, rr.status AS status , recording_url FROM re2_agent_call_cdr racc, re2_requirements rr, re2_agent_competency_profile racp WHERE racc.xpora_req_id = rr.id AND racp.agent_id = racc.telecaller_id ";
        $query= "SELECT DISTINCT (caller_no) AS caller_no, user_name, xpora_req_id, racc.timestamp as telephony_timestamp, called_no, agent_name, racp.city_id AS city_id, racp.category AS category, racp.property_types AS property_types, rr.source_1 AS source_1, rr.status AS status FROM re2_agent_call_cdr racc, re2_requirements rr, re2_agent_competency_profile racp, re2_user_contacts ruc WHERE rr.email_1_id = ruc.id and racc.xpora_req_id = rr.id AND racp.agent_id = racc.telecaller_id ";   
        if($uscity !="" ){ 
            if(count($uscity)>=1){
                $query.=" AND (";
                foreach($uscity as $cityvaln){
                    $query.=" FIND_IN_SET('$cityvaln',racp.city_id) OR";
                }
                $query=substr($query, 0, -2);
                $query.=")"; 
            } 
        }
        
        if($usstart_date !="" && $usend_date !="" ){ $query.= " and ( DATE(racc.timestamp) between '".$usstart_date."' and '".$usend_date."') "; }
        
        if($usreqid !="" ){ $query.= "  and racc.xpora_req_id in (".$usreqid.")" ; }

        // if($uslocality !="" ){
        //$uslocality_data  = "'".'text'."'";

        $uslocality_data  = '1';
        $uslast_call_dispotion_data = "'".'text'."'";
        $usemail_data = "'".'text'."'";

        if(!empty($_id['uslocality'])){
          $uslocality_data = implode(",",$_id['uslocality']);
          $query.= "  and racp.locality_ids in (".$uslocality_data.")" ;
        }

        if(!empty($_id['uslast_call_dispotion'])){


                for($i=0; $i < count($uslast_call_dispotion); $i++)
                {

                    if($uslast_call_dispotion[$i] !="")
                        { $uslast_call_dispotion_data = $uslast_call_dispotion_data." ,'".$uslast_call_dispotion[$i]."'"; }
                }
              
              $query.= "  and rr.status in (".$uslast_call_dispotion_data.")" ;
             
        }

        if(!empty($_id['usemail'])){

                for($i=0; $i < count($usemail); $i++)
                {

                    if($usemail[$i] !="")
                        { $usemail_data = $usemail_data." ,'".$usemail[$i]."'"; }
                }
              
              $query.= "  and ruc.value in (".$usemail_data.") " ;
             
        }
         //if($uslast_call_dispotion !="" ){ $query.= "  and racp.status in ('".$uslast_call_dispotion."')" ; }

       // if($uslead_dropped_to_project_name !="" ){ $query.= "  and racp.city_id in (".$uslead_dropped_to_project_name.")" ; }
      
        $query.=" and rr.id not in (SELECT req_id FROM `re2_agent_requeing` where re_qued = 0)  GROUP BY racc.xpora_req_id ORDER BY racc.timestamp DESC limit 400";
        $result=DB::connection('mysql_slave')->Select($query);
        foreach ($result as $res) {
               // $data['id']=$res->id;
                $data['caller_no']=$res->caller_no;
                $data['called_no']=$res->called_no;
                $data['user_name']=$res->user_name;
                $data['xpora_req_id']=$res->xpora_req_id;
                $data['agent_name']=$res->agent_name;
                $data['city_id']=$res->city_id;
                $data['start_datetime_legA']=$res->telephony_timestamp;
                $data['category']=$res->category;
                $data['property_types']=$res->property_types;
                $data['status']=$res->status;
                $data['source']=$res->source_1;
                $reportingarray[]=$data;
            }

            header('Content-type: application/json');
            $result3=json_encode($reportingarray);
            echo $result3;
    }


public function getAssignUserSearchMakeCall(){
    
        session_start();
        $scheduled_date=$_POST['scheduled_date'];
        $user_search_call=$_POST['user_search_call'];

        //echo "Date ".$scheduled_date;
        //exit();
        for ($i=0; $i<count($user_search_call); $i++){
                $insertoactive= DB::connection('mysql_master')->insert("INSERT INTO `re2_agent_requeing`(`req_id`,`re_qued`,`Disposition`,`created_date`,`user_identifier`) VALUES(".$user_search_call[$i].",'Yes','Break','".$scheduled_date."','re_qued')");
                
                //INSERT INTO `re2_agent_requeing`(`id`, `req_id`, `re_qued`, `Disposition`, `created_date`, `user_identifier`, `timestamp`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])
                //$updatesip= DB::connection('mysql_master')->insert("UPDATE re2_agent_ad_detail SET assign_status=1 WHERE  req_id = ".$pending_call[$i]."");
        } 
        if($insertoactive){
            $resp['status'] = 'success'; 
            $resp['message'] = 'Sucessfully Re-queued Total '.count($user_search_call).' calls !';   
            header('Content-type: application/json');
            echo json_encode($resp);
        }
    }
    public function mannualCallAssignment(){
        
        session_start();
        $_id = Request::all();
        $reportingarray=array();
        $str="SELECT id, req_id, city, phone_no, source, req_status, inserted_time, updated_time FROM `re2_agent_ad_detail` where req_status = 0 and assign_status = 0";
        if($_id['city']!='N'){
            $str.=" and city = '".$_id['city']."'" ;
        }
        if($_id['start_date']!='N'){
            $str.=" and inserted_time>='".$_id['start_date']." 00:00:00'" ;
        }
        if($_id['end_date']!='N'){
            $str.=" and inserted_time<='".$_id['end_date']." 23:59:59'" ;
        }
        $str.=" order by inserted_time desc limit 0,50";
        //echo $str;
        $result=DB::connection('mysql_master')->Select($str);
        foreach ($result as $res) {
                $req_id=$res->req_id;
                $data['id']=$res->id;
                $data['req_id']=$req_id;
                $data['city']=$res->city;
                $data['phone_no']=$res->phone_no;
                $data['req_status']=$res->req_status;
                $data['inserted_time']=$res->inserted_time;
                $reportingarray[]=$data;
            }

            header('Content-type: application/json');
            $result3=json_encode($reportingarray);
            echo $result3;
    }
 public function pendingCallpost(){
    
        session_start();
        $mcacity=$_POST['mcacity'];
        $mcastart_date=$_POST['mcastart_date'];
        $mcaend_date=$_POST['mcaend_date'];
        $agent_id=$_POST['mcatelecaller'];
        $pending_call=$_POST['pending_call'];
        for ($i=0; $i<count($pending_call); $i++){
                $insertoactive= DB::connection('mysql_master')->insert("INSERT INTO `re2_agent_outbound_list`(`req_id`, `agent_id`, `assigned_by` ) VALUES (".$pending_call[$i].", ".$agent_id.",".$_SESSION['userid'].")");
                $updatesip= DB::connection('mysql_master')->insert("UPDATE re2_agent_ad_detail SET assign_status=1 WHERE  req_id = ".$pending_call[$i]."");
        } 
        if($insertoactive){
            $resp['status'] = 'success'; 
            $resp['message'] = 'Sucessfully Sent!';   
            header('Content-type: application/json');
            echo json_encode($resp);
        }
    }
 public function dashboardCounts(){
    
    session_start();
    if(isset($_SESSION['userlevel'])){
    $level=$_SESSION['userlevel'];
    if($level==1){
        $tlres= DB::connection('mysql_master')->select("select id from re2_agent_login where level in(2) and reporting_to='".$_SESSION['userid']."' and is_deleted=0");
        $reportingIds=array();
        foreach ($tlres as $tls) {
            $reportingIds[]=$tls->id;
        }
        $agentid=implode(",",$reportingIds);
        if($agentid==''){
            $agentid=$_SESSION['userid'];
        }
    }
    else{
        $agentid=$_SESSION['userid'];
    }
    //Assigned Calls
    if($level==0){
        $qryassign="SELECT count(id) as assigned from re2_agent_outbound_list where timestamp >= NOW() - INTERVAL 7 DAY";
    }
    else{
        $qryassign="SELECT count(id) as assigned from re2_agent_outbound_list where assigned_by in ($agentid) and timestamp >= NOW() - INTERVAL 7 DAY";
    }
    $assignedquery=DB::connection('mysql_master')->select($qryassign);
    
    //Completed Calls..
    if($level==0){
        $qrycompleted="SELECT count(id) as completed from re2_agent_outbound_list where completed=1 and timestamp >= NOW() - INTERVAL 7 DAY";
    }
    else{
        $qrycompleted="SELECT count(id) as completed from re2_agent_outbound_list where completed=1 and assigned_by in ($agentid) and timestamp >= NOW() - INTERVAL 7 DAY";
    }
    $completedquery=DB::connection('mysql_master')->select($qrycompleted);
    
    //Pending Calls..
    if($level==0){
        $qrypending="SELECT count(id) as pending from re2_agent_outbound_list where completed=0 and timestamp >= NOW() - INTERVAL 7 DAY";
    }
    else{
        $qrypending="SELECT count(id) as pending from re2_agent_outbound_list where completed=0 and assigned_by in ($agentid) and timestamp >= NOW() - INTERVAL 7 DAY";
    }
    $pendingquery=DB::connection('mysql_master')->select($qrypending);
    
    //No Of Enqs Calls..
    $qryenqs="SELECT count(id) as noofenqs from re2_agent_ad_detail where inserted_time >= NOW() - INTERVAL 7 DAY";
    $enqsquery=DB::connection('mysql_slave')->select($qryenqs);
    
    $resp['assignedcalls']=$assignedquery[0]->assigned;
    $resp['completedcalls']=$completedquery[0]->completed;
    $resp['pendingcalls']=$pendingquery[0]->pending;
    $resp['noofenqs']=$enqsquery[0]->noofenqs;
    header('Content-type: application/json');
    echo json_encode($resp);
    }
    else{
        $resp['assignedcalls']="";
        $resp['completedcalls']="";
        $resp['pendingcalls']="";
        $resp['noofenqs']="";
        header('Content-type: application/json');
        echo json_encode($resp);    
    }
 }
  public function countsNotification(){
    
    session_start();
    $_id = Request::all();
    $cityid=$_id['cityidsearch'];
    $cityname=$_id['citysearch'];
    $fromdate=$_id['fromdatesearch'];
    $todate=$_id['todatesearch'];
    $resp=array();
    $response['details']=array();
    $extraQuery="";
    $extraQuery1="";
    if($cityname!=''){
        $extraQuery.=" city_id='{$cityid}'";
        $extraQuery1.=" city_id='{$cityid}'";
    }
    else{
        $extraQuery.=" id!=''";
        $extraQuery1.=" id!=''";
    }
    if($fromdate!='' && $todate==''){
        $extraQuery.=" and (property_for_1 like '%buy%' OR property_for_2 like '%buy%') AND created_date>=('".$fromdate." 00:00:00')";
        $extraQuery1.=" and (property_for_1 like '%buy%' OR property_for_2 like '%buy%') AND created_date<=('".$todate." 23:59:59')";
    }
    elseif($fromdate=='' && $todate!=''){
        $extraQuery.=" and (property_for_1 like '%buy%' OR property_for_2 like '%buy%') AND created_date<=('".$todate." 23:59:59')";
        $extraQuery1.=" and (property_for_1 like '%buy%' OR property_for_2 like '%buy%') AND created_date<=('".$todate." 23:59:59')";
    }
    elseif($fromdate!='' && $todate!=''){
        $extraQuery.=" and (property_for_1 like '%buy%' OR property_for_2 like '%buy%') AND created_date BETWEEN ('".$fromdate." 00:00:00') AND ('".$todate." 23:59:59')";
        $extraQuery1.=" and (property_for_1 like '%buy%' OR property_for_2 like '%buy%') AND created_date BETWEEN ('".$fromdate." 00:00:00') AND ('".$todate." 23:59:59')";
    }
    else{
       $extraQuery.= " and (property_for_1 like '%buy%' OR property_for_2 like '%buy%') AND DATE(created_date)=DATE(NOW())";
       $extraQuery1.= " and (property_for_1 like '%buy%' OR property_for_2 like '%buy%') AND DATE(created_date)=DATE(NOW())";
    }
    //Group By City Condition
    $qryenqs_city="SELECT count(id) as count,city_id FROM `re2_requirements` where $extraQuery GROUP by city_id ORDER by 1 DESC";
    $enqsquery_city=DB::connection('mysql_slave')->select($qryenqs_city);
    foreach($enqsquery_city as $enq_city){
        $resp['city_details']['primaryintent']=array();
        $resp['city_details']['source']=array();
        //$resp['city_details']['cityname']=$enq_city->city;
        $resp['city_details']['city_count']=$enq_city->count;
        $result_city=DB::connection('mysql_slave')->Select("SELECT id,name FROM `re2_cities` where id = '".$enq_city->city_id."'");
        $city_id = $result_city[0]->id;  
        $resp['city_details']['cityname']=$result_city[0]->name;    
        //Group By Source Condition..
        $qryenqs_source="SELECT count(id) as count,source_1 as source FROM re2_requirements  where city_id='$city_id' and $extraQuery1 GROUP by source_1 ORDER by 1 DESC";
        $enqsquery_source=DB::connection('mysql_slave')->select($qryenqs_source);  
        foreach($enqsquery_source as $enq_source){
            $res_source['sourcename']=$enq_source->source;
            $res_source['source_count']=$enq_source->count;
            $resp['city_details']['source'][]=$res_source;
        }
        
        //Group By Primary Intent 1 Condition..
        $qryenqs_pi1="SELECT count(id) as count,property_for_1 as primary_intent FROM re2_requirements where city_id='$city_id' and $extraQuery1 GROUP by property_for_1 ORDER by 1 DESC";
        $enqsquery_pi1=DB::connection('mysql_slave')->select($qryenqs_pi1);
        foreach($enqsquery_pi1 as $enq_pi1){
            $res_pi['primaryintent']=$enq_pi1->primary_intent;
            $res_pi['pi_count']=$enq_pi1->count;
            $resp['city_details']['primaryintent'][]=$res_pi;
        }
        $response['details'][]=$resp;
    }
    header('Content-type: application/json');
    echo json_encode($response);
 }
 public function countsNotificationDetails(){
    
        session_start();
        $_id = Request::all();
        $cityid=$_id['cityidsearch'];
        $cityname=$_id['citysearch'];
        $fromdate=$_id['fromdatesearch'];
        $todate=$_id['todatesearch'];
        $extraQuery="";
        $extraQuery1="";
        if($cityname!=''){
            $extraQuery.=" and b.city_id='{$cityid}'";
        }
        if($fromdate!='' && $todate==''){
            $extraQuery.=" and (b.property_for_1 like '%buy%' OR b.property_for_2 like '%buy%') AND b.created_date>=('".$fromdate." 00:00:00')";
        }
        elseif($fromdate=='' && $todate!=''){
            $extraQuery.=" and (b.property_for_1 like '%buy%' OR b.property_for_2 like '%buy%') AND b.created_date<=('".$todate." 23:59:59')";
        }
        elseif($fromdate!='' && $todate!=''){
            $extraQuery.=" and (b.property_for_1 like '%buy%' OR b.property_for_2 like '%buy%') AND b.created_date BETWEEN ('".$fromdate." 00:00:00') AND ('".$todate." 23:59:59')";
        }
        else{
           $extraQuery.= " and (b.property_for_1 like '%buy%' OR b.property_for_2 like '%buy%') AND DATE(b.created_date)=DATE(NOW())";
        }
        //Group By City Condition
        //echo "SELECT b.id,b.source_1,b.status,b.created_date as updated_time FROM re2_requirements as b WHERE b.id!='' $extraQuery";
        $qryenqs_city="SELECT b.id,b.source_1,b.phone_1_id,b.city_id,b.status,b.created_date as updated_time FROM re2_requirements as b WHERE b.id!='' $extraQuery";
        $enqsquery_city=DB::connection('mysql_slave')->select($qryenqs_city);
        $data=array();
        $reportingarray=array();
        foreach ($enqsquery_city as $enqcity) {
            
            $data['status']=$enqcity->status;
            $data['source_1']=$enqcity->source_1;
            $data['req_id']=$enqcity->id;
            $data['updated_time']=$enqcity->updated_time;
            $result_city=DB::connection('mysql_slave')->Select("SELECT id,name FROM `re2_cities` where id = '".$enqcity->city_id."'");
            $city_id = $result_city[0]->id;  
            $data['city']=$result_city[0]->name;
            $result_phne=DB::connection('mysql_slave')->Select("SELECT id,value FROM re2_user_contacts where id= '".$enqcity->phone_1_id."'");
            if(count($result_phne)>=1){
                $data['phone_no']=$result_phne[0]->value; 
            }
            else{
                $data['phone_no']="-"; 
            }
            $qry_agentdetail="SELECT a.req_id,a.city,a.phone_no,a.inserted_time FROM re2_agent_ad_detail as a WHERE a.req_id='".$enqcity->id."'";
            $enqs_agent=DB::connection('mysql_slave')->select($qry_agentdetail);
            if(count($enqs_agent)>=1){
                $data['inserted_time']=$enqs_agent[0]->inserted_time;   
            }
            else{
                $data['inserted_time']=$enqcity->updated_time;
            }
            $reportingarray[]=$data;
        }
        //var_dump($reportingarray);
            header('Content-type: application/json');
            $result2=json_encode($reportingarray);
            echo $result2;
        /*
        $qryenqs_city="SELECT a.req_id,a.city,a.phone_no,b.source_1,b.status,b.created_date as updated_time,a.inserted_time FROM re2_agent_ad_detail as a,re2_requirements as b WHERE a.req_id=b.id $extraQuery";
        $enqsquery_city=DB::connection('mysql_master')->select($qryenqs_city);
        header('Content-type: application/json');
        $result2=json_encode($enqsquery_city);
        echo $result2; */
 }
 public function brkDetails(){
    
    $_id = Request::all();
        session_start();
        if($_SESSION['userlevel']==0){
            $query= "select a.id,name,emp_id,level,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3) and a.is_deleted=0";
        }
        else if($_SESSION['userlevel']==1){
            $result2= DB::connection('mysql_master')->select("select id from re2_agent_login where level in(2,3) and reporting_to='".$_SESSION['userid']."' and is_deleted=0");
            $reportingIds=array();
            foreach ($result2 as $res2) {
                $reportingIds[]=$res2->id;
            }
            $rep_ids=implode(",",$reportingIds);
            if($rep_ids!=''){
                $query= "select a.id,name,emp_id,level,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3) and reporting_to in({$rep_ids}) and a.is_deleted=0";    
            }
            else{
                $query='';
            }
        }
        else if($_SESSION['userlevel']==2){
            $query="select a.id,name,emp_id,level,city_id, source_1,property_for_1,property_for_2,category from re2_agent_login as a,re2_agent_competency_profile as b where a.id=b.agent_id and level in(3) and reporting_to='".$_SESSION['userid']."' and a.is_deleted=0";    
        }
        if($_id['city']!='N' && !empty($_id['city'])){
            $city="'". implode("', '", $_id['city']) ."'";
            $query.=" and city_id in($city)";
        }
        if($_id['agent_name']!='N'){
            $query.=" and a.name like '%{$_id['agent_name']}%'";
        }
        if(!empty($_id['brk_source']) && $_id['brk_source']!='N'){
            $brk_source=implode(",", $_id['brk_source']);
           $query.=" and b.source_1 like '%{$brk_source}%'";
        }
        if(!empty($_id['brk_pintent']) && $_id['brk_pintent']!='N'){
            $brk_pintent=implode(",", $_id['brk_pintent']);
           $query.=" and (b.property_for_1 like '%{$brk_pintent}%' OR b.property_for_2 like '%{$brk_pintent}%')";
        }
        if(!empty($_id['brk_sintent']) && $_id['brk_sintent']!='N'){
            $brk_sintent=implode(",", $_id['brk_sintent']);
           $query.=" and b.category like '%{$brk_sintent}%'";
        }
        $data=array();
        if($query!=''){
            $execute=DB::connection('mysql_master')->Select($query);
            $reportingarray=array();
            $agent=array();
            foreach ($execute as $_brkrep) {
               $agent[]=$_brkrep->id;
               $data['agent_name']=$_brkrep->name;
                $data['agent_id']=$_brkrep->id;
                $_city=$_brkrep->city_id;
                $cityQry=DB::connection('mysql_master')->Select("select name from re2_cities where id='$_city'");
                foreach ($cityQry as $value) {
                    $city_name=$value->name;
                    $data['city']=$city_name;
                }
                $_source=$_brkrep->source_1;
                if($_brkrep->property_for_1!='' && $_brkrep->property_for_2==""){
                    $_propfor=$_brkrep->property_for_1;
                }elseif($_brkrep->property_for_1=='' && $_brkrep->property_for_2!=""){
                    $_propfor=$_brkrep->property_for_2;
                }else{
                    $_propfor=$_brkrep->property_for_1." ".$_brkrep->property_for_2;
                }
                $_category=$_brkrep->category;
                $data['source']=$_source;
                $data['pri_intent']=$_propfor;
                $data['sec_intent']=$_category;
                
                }
            }
     
        $id=implode(',',$agent);
        $brkQry="select al.login_time,al.login_dialer_time,al.logout_time,al.break_reason,al.break_time,aa.login_status,aa.pick_call_status,aa.manual_call_status from re2_agent_login_logs al,re2_agent_active aa where al.agent_id=aa.agent_id and al.agent_id in($id)";
        if($_id['start_date']!='N'){
            $brkQry.=" and al.created_time>='".$_id['start_date']." 00:00:00'";
        }
        if($_id['end_date']!='N'){
            $brkQry.=" and al.created_time<='".$_id['end_date']." 23:59:59'";
        }
        if($_id['break_reason']!='N'){
            $break_reason="'". implode("', '", $_id['break_reason']) ."'";
            $brkQry.=" and al.break_reason in($break_reason)";
        }
        else{
            $brkQry.=" order by al.created_time desc limit 0,50";
        }
        $brkreport= DB::connection('mysql_slave')->select($brkQry);
            foreach ($brkreport as $val) {
                if($val->break_reason==null){
                   $data['break_reason']='N/A'; 
                }
                else{
                $data['break_reason']=$val->break_reason;
                }
                $start=date_create($val->login_time);
                $end=date_create($val->logout_time);
                $break=date_create($val->break_time);
                $data['login_date']=date_format($start,"Y/m/d");
                $data['login_time']=date_format($start,"H:i:s");
                $dial_time=date_create($val->login_dialer_time);
                if($val->login_dialer_time==null){
                    $data['login_dialer_time']='N/A';
                    $data['idle_time']='N/A';

                }
                else{
                    $data['login_dialer_time']=$val->login_dialer_time;
                        $idle=date_diff($dial_time,$start);
                        $data['idle_time']=$idle->h.":".$idle->i.":".$idle->s;
                }
              if($val->break_time==null){
                    $data['break_time']='N/A';
                    $data['loggedin_dialer_duration']='N/A';
                }
                else{
                $data['break_time']=date_format($break,"Y/m/d H:i:s");
                    
                    $dialer_time=date_diff($break,$dial_time);
                    $data['loggedin_dialer_duration']=$dialer_time->h.":".$dialer_time->i.":".$dialer_time->s;
                    
                }
                if($val->pick_call_status==1){
                $data['dialing_mode']="Automatic";   
                }
                elseif($val->manual_call_status==1){
                $data['dialing_mode']="Manual";      
                }
                else{
                $data['dialing_mode']="";    
                }
                if($val->pick_call_status==1 || $val->manual_call_status==1){
                  $data['status']="Ready";  
                }
                else if($val->pick_call_status==0 && $val->manual_call_status==0){
                  $data['status']="Left";  
                }
                if(date_format($end,"Y/m/d")=='-0001/11/30'){
                   $data['logout_date']='N/A'; 
                }
                else{
                   $data['logout_date']=date_format($end,"Y/m/d"); 
                }
                if(date_format($end,"H:i:s")=='00:00:00'){
                    $data['logout_time']='N/A';
                    $data['loggedin_account_duration']='N/A';
                    $data['login_status']="Login";
                }
                else{
                   $data['logout_time']=date_format($end,"H:i:s");
                   $data['login_status']="Logout";  
                   $acc_login=date_diff($end,$start);
                   $data['loggedin_account_duration']=$acc_login->h.":".$acc_login->i.":".$acc_login->s;
                }
                $diff=date_diff($end,$start);
                $total_val= $diff->h.":".$diff->i.":".$diff->s;
                $data['total_time']=$total_val;
                $data['campaign_name']="Competency Mapped";
                 
                $reportingarray[]=$data; 
            }          
        header('Content-type: application/json');
        $result2=json_encode($reportingarray);
        echo $result2;   
    }
    public function viewVlProjects(){
        
        $_id=Request::all();
        $req_id=$_id['id'];
        $reportingarray=array();
        $res=DB::connection('mysql_master')->Select("Select req_id,project,builder from re2_agent_matchmaking_email_status where req_id='$req_id'");
        foreach ($res as $value) {
            $_data['project']=$value->project;
            $_data['builder']=$value->builder;
            $_data['req_id']=$value->req_id;
            $reportingarray[]=$_data; 
        }
        header('Content-type: application/json');
        $result2=json_encode($reportingarray);
        echo $result2; 
    }
    public function currentStatus(){
        
        session_start();
        $query= "select id,name,emp_id,level,reporting_to from re2_agent_login where level in(3) and is_deleted=0";
        $result=DB::connection('mysql_master')->Select($query);
        $_currentstatus=array();
        $_logincount= DB::connection('mysql_master')->select("SELECT count(*) as logincount from re2_agent_active where login_status=1");
        $_incallcount= DB::connection('mysql_master')->select("SELECT count(*) as incallcount from re2_agent_active where login_status=1 and pick_call_status=1 and status=1 and incall=1");
        $_freecount= DB::connection('mysql_master')->select("SELECT count(*) as freecount from re2_agent_active where login_status=1 and  pick_call_status=1 and (status=0 or status=1) and incall=0");
        $_dialcount= DB::connection('mysql_master')->select("SELECT count(*) as dialcount from re2_agent_active where login_status=1 and  pick_call_status=1 and status=1 and incall=2");
        $_ringcount= DB::connection('mysql_master')->select("SELECT count(*) as ringcount from re2_agent_active where login_status=1 and  pick_call_status=1 and status=1 and incall=3");
        $_notready= DB::connection('mysql_master')->select("SELECT count(*) as notreadycount from re2_agent_active where login_status=1 and  pick_call_status=0 and status=0 and incall=0");
        $_currentstatus['loggedin']=$_logincount[0]->logincount;
        $total=count($result);
        $loggedout_count=($total-$_logincount[0]->logincount);
        $_currentstatus['loggedout']=$loggedout_count;
        $_currentstatus['incall']=$_incallcount[0]->incallcount;
        $_currentstatus['dialing']=$_dialcount[0]->dialcount;
        $_currentstatus['ringing']=$_ringcount[0]->ringcount;
        $_currentstatus['notready']=$_notready[0]->notreadycount;
        $_currentstatus['free']=$_freecount[0]->freecount;
        date_default_timezone_set('Asia/Kolkata');
        foreach ($result as $agentval) {
            $_currentSt= DB::connection('mysql_master')->select("SELECT a.id,agent_id,sip_id,login_status,pick_call_status,a.status,a.incall,manual_call_status,sip_number FROM re2_agent_active as a,re2_agent_sip_allotment as b WHERE a.sip_id=b.id and a.agent_id=$agentval->id");
            if(count($_currentSt)>=1){
            //if($_currentSt[0]->login_status==1){
                //$sipNumber=DB::connection('mysql_master')->select("SELECT ");
                $_logindate= DB::connection('mysql_slave')->select("SELECT 
                (SELECT login_time FROM re2_agent_login_logs WHERE agent_id = '$agentval->id' AND DATE(created_time) = DATE(NOW()) ORDER BY created_time LIMIT 1) as 'firstlogin',
                (SELECT login_time FROM re2_agent_login_logs WHERE agent_id = '$agentval->id' AND DATE(created_time) = DATE(NOW()) ORDER BY created_time DESC LIMIT 1) as 'lastlogin'");
                $_closure_time= DB::connection('mysql_slave')->select("SELECT closure_time FROM `re2_agent_call_hadling_detail` WHERE agent_id = '$agentval->id' AND DATE(inserted_date) = DATE(NOW()) order by inserted_date desc");
                //echo "SELECT break_time from re2_agent_login_logs where agent_id='$agentval->id' and break_time>='".$_logindate[0]->lastlogin."' order by break_time desc";
                $break_time=DB::connection('mysql_slave')->select("SELECT break_time from re2_agent_login_logs where agent_id='$agentval->id' and break_reason is NOT NULL and break_time is NOT NULL and break_time>='".$_logindate[0]->lastlogin."' order by break_time desc");
                $_data['agent_id']=$agentval->id;
                $_data['agent_name']=$agentval->name;
                $report=DB::connection('mysql_master')->Select("select name from re2_agent_login where id='".$agentval->reporting_to."' and is_deleted=0");
                $_data['teamleader']=$report[0]->name;
                $_data['call_status']="";
                $_data['login_time']="-";
                $_data['free_time']="";
                $_data['curent_mode']='NA';
                $_data['sip_number']=$_currentSt[0]->sip_number;
                if($_currentSt[0]->login_status==1){
                $_data['call_status']=$_currentSt[0]->status;
                $_data['incall']=$_currentSt[0]->incall;
                $_data['sip_number']=$_currentSt[0]->sip_number;
                $_data['free_time']="00:00:00";
                if(count($_logindate)>=1){
                    $_data['login_time']=$_logindate[0]->firstlogin;
                }
                else{
                    $_data['login_time']="-";
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
          }$_currentstatus['data'][]=$_data;
        }
        header('Content-type: application/json');
        $result2=json_encode($_currentstatus);
        echo $result2; 
    }
    
}
