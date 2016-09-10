<?php
namespace App\Http\Controllers;

use Request;
//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;

use DB;
use Mail;
class LoginController extends Controller
{
    public function viewLogin(){
        session_start();
        if(isset($_SESSION['userid']) && !empty($_SESSION['userid']) && $_SESSION['userlevel']==0){
            return redirect('Userview');
        }
        else{
            return view('login');
        }        
    }
    public function checkLogin(){
        
        if(!empty($_POST['inputEmpid']) && !empty($_POST['inputPassword'])){
            $password=md5($_POST['inputPassword']);
            $result= DB::connection('mysql_master')->select("select id,name,emp_id,password,email,mobile,level from re2_agent_login where emp_id='".$_POST['inputEmpid']."' and password='".$password."' and is_deleted=0");
            if(count($result)==1){
                session_start();
                $updatesip= DB::connection('mysql_master')->insert("update re2_agent_active set login_status='1' where agent_id='".$result[0]->id."'");
                $_mongo2=new MongoController();
                $_insert=$_mongo2->updateCurrentStatus($result[0]->id,1,0,0);
                $insert_login= DB::connection('mysql_master')->insert("INSERT INTO re2_agent_login_logs(`agent_id`, `login_time`, `login_temp`) VALUES ('".$result[0]->id."', now(), now())");
                if($result[0]->level=='3'){
                    $_sipnumber= DB::connection('mysql_master')->select("SELECT sip_id,sip_number,server_id FROM `re2_agent_active` as a,re2_agent_sip_allotment as b where a.sip_id=b.id and a.agent_id= '".$result[0]->id."'");
                    $_SESSION['sipnumber']=$_sipnumber[0]->sip_number;
                    $_SESSION['server_id']=$_sipnumber[0]->server_id;
                    $_SESSION['sip_id']=$_sipnumber[0]->sip_id;
                    $mongo=new MongoController();
                    $insert_log_mongo=$mongo->updateLoginDetail($result[0]->id);
                }else{
                    $_SESSION['sipnumber']="-";
                }
                $_SESSION['userid']=$result[0]->id;
                $_SESSION['username']=$result[0]->name;
                $_SESSION['useremp_id']=$result[0]->emp_id;
                $_SESSION['email']=$result[0]->email;
                $_SESSION['mobile']=$result[0]->mobile;
                $_SESSION['userlevel']=$result[0]->level;
                $resp['status'] = 'success'; 
                $resp['message'] = '*Login Sucessfull ';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
            else{
                $resp['status'] = 'error'; 
                $resp['message'] = '*Employee Id or Passowrd is Incorrect';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
        }
        else{
            $resp['status'] = 'error'; 
            $resp['message'] = '*Employee Id or Passowrd is empty';   
            header('Content-type: application/json');
            echo json_encode($resp);
        }
    }
    public function logOut(){
        
        session_start();
        $qry=DB::connection('mysql_slave')->select("SELECT * FROM `re2_agent_login_logs` where agent_id='".$_SESSION['userid']."' order by id desc");
        $login_time=$qry[0]->login_time;
        $login_temp=$qry[0]->login_temp;
        if($_SESSION['userlevel']=='3'){
            $updatesip= DB::connection('mysql_master')->insert("update re2_agent_active set login_status='0',pick_call_status=0,status=0,manual_call_status=0 where agent_id='".$_SESSION['userid']."'");
            $_mongo2=new MongoController();
            $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],0,0,0);
            $updatesip= DB::connection('mysql_master')->insert("update re2_agent_login_logs set logout_time=now() where agent_id='".$_SESSION['userid']."' and logout_time='0000-00-00 00:00:00' and login_time='$login_time' and login_temp='$login_temp'");
            $mongo=new MongoController();
            $insert_log_mongo=$mongo->updateLogoutDetail($_SESSION['userid']);
            session_destroy();
            echo "Logout";
        }
        else{
            $updatesip= DB::connection('mysql_master')->insert("update re2_agent_login_logs set logout_time=now() where agent_id='".$_SESSION['userid']."' and logout_time='0000-00-00 00:00:00' and login_time='$login_time' and login_temp='$login_temp'");
            session_destroy();
            return redirect('Login');
        }
    }
    public function forgotPassword(){
        
        if(!empty($_POST['inputEmail'])){
            $result= DB::connection('mysql_master')->select("select id,emp_id,password from re2_agent_login where email='".$_POST['inputEmail']."' and is_deleted=0");
            if(count($result)==1){
                //EMAIL Funtion ...
                //$link="<a href='".$result[0]->emp_id."_".$result[0]->password."_".$result[0]->id."'>Click Here to Reset Password</a>";
                //sendNotificationMail($link);
                Mail::send(array(), array(), function($message){
                  $email="saravanan.m@gmail.com";
                  $name="Saravanan";
                  $message->to($email, $name)->subject('Reset Passowrd : Quikr homes Xpora!');
                  $message->setBody('Hi, welcome user!');
                });
                
                $resp['status'] = 'success'; 
                $resp['message'] = 'Email Send Sucessfully. Check your Mail and Reset Password';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
            else{
                $resp['status'] = 'error'; 
                $resp['message'] = '*Email ID not Exist';   
                header('Content-type: application/json');
                echo json_encode($resp);
            }
        }
        else{
            $resp['status'] = 'error'; 
            $resp['message'] = '*Please Check Email ID';   
            header('Content-type: application/json');
            echo json_encode($resp);
        }
    }
    public function resetPassword($token){
        
        if(isset($token)){
        $_token=explode("_",$token);
        $empid=$_token[0];
        $pass=$_token[1];
        $id=$_token[2];
        $result= DB::connection('mysql_master')->select("select id,emp_id,password from re2_agent_login where emp_id='".$empid."' and password='".$pass."' and id='".$id."' and is_deleted=0");
            if(count($result)==1){
                return view('resetpassword', array('data' => $result[0]));
            }
            else{
                return view('error');
            }
        }
        else{
            return view('error');
        }
    }
    public function updatePassword(){
        
        if(!empty($_POST['inputEmpid']) && !empty($_POST['inputId']) && !empty($_POST['inputPassword'])){
            $result= DB::connection('mysql_master')->select("select id,emp_id,password from re2_agent_login where id='".$_POST['inputId']."' and emp_id='".$_POST['inputEmpid']."' and is_deleted=0");
            if(count($result)==1){
                $newpassword=md5($_POST['inputPassword']);
                $resultupdate= DB::connection('mysql_master')->update("update re2_agent_login set password='".$newpassword."' where id='".$_POST['inputId']."'");
                $resp['status'] = 'success'; 
                $resp['message'] = 'Password Updated! Login with New Password..';   
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
    public function checkagentMode(){
        
        $id=Request::all();
        $_type=$id['type'];
        $_reqid=$id['req_id'];
        session_start();
        if(!isset($_SESSION['userid'])){
           $data['mode']='Login'; 
        }
        else{
            if($_type=='page'){
                if(isset($_reqid) && !empty($_reqid)){
                    $data['mode']="cookie_{$_reqid}";
                }
                else{
                    date_default_timezone_set('Asia/Kolkata');
                    $_mongo2=new MongoController();

                    $updatesip= DB::connection('mysql_master')->update("update re2_agent_active set status='0' where agent_id='".$_SESSION['userid']."'");
                    $_call_handlingdetail= DB::connection('mysql_master')->select("SELECT id,xpora_req_id,telecaller_id,legA_uuid,legB_uuid FROM re2_agent_call_cdr WHERE xpora_req_id='$_reqid' and telecaller_id='{$_SESSION['userid']}' order by id desc limit 0,1");
                    if(count($_call_handlingdetail)>=1){
                        $colsure_qry= DB::connection('mysql_master')->insert("insert into re2_agent_call_hadling_detail(req_id,agent_id,call_leg_id_A,call_leg_id_B,closure_time) values('$_reqid','{$_SESSION['userid']}','{$_call_handlingdetail[0]->legA_uuid}','{$_call_handlingdetail[0]->legB_uuid}',NOW())");
                        $add_acw=$_mongo2->setAfterCallWorktime($_call_handlingdetail[0]->legA_uuid);
                    }
                    $_currentSt= DB::connection('mysql_master')->select("SELECT id,agent_id,login_status,pick_call_status,status,manual_call_status FROM re2_agent_active WHERE agent_id={$_SESSION['userid']}");
                    if($_currentSt[0]->pick_call_status==1 && $_currentSt[0]->manual_call_status==0){
                        $data['mode']='auto';
                        $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,1,0);
                    }
                    else if($_currentSt[0]->manual_call_status==1 && $_currentSt[0]->pick_call_status==0){
                        $data['mode']='manual';
                        $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,0,0);
                    }
                    else{
                         $data['mode']='other';
                        $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,0,0);
                    }
                }
            }
            else{
                    date_default_timezone_set('Asia/Kolkata');
                    $_mongo2=new MongoController();
                    $_call_handlingdetail= DB::connection('mysql_master')->select("SELECT id,xpora_req_id,telecaller_id,legA_uuid,legB_uuid FROM re2_agent_call_cdr WHERE xpora_req_id='$_reqid' and telecaller_id='{$_SESSION['userid']}' order by id desc limit 0,1");
                    if(count($_call_handlingdetail)>=1){
                        $colsure_qry= DB::connection('mysql_master')->insert("insert into re2_agent_call_hadling_detail(req_id,agent_id,call_leg_id_A,call_leg_id_B,closure_time) values('$_reqid','{$_SESSION['userid']}','{$_call_handlingdetail[0]->legA_uuid}','{$_call_handlingdetail[0]->legB_uuid}',NOW())");
                        $add_acw=$_mongo2->setAfterCallWorktime($_call_handlingdetail[0]->legA_uuid);
                    }
                    $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,1,0);
                    $updatesip= DB::connection('mysql_master')->update("update re2_agent_active set status='0' where agent_id='".$_SESSION['userid']."'");
                    $_currentSt= DB::connection('mysql_master')->select("SELECT id,agent_id,login_status,pick_call_status,status,manual_call_status FROM re2_agent_active WHERE agent_id={$_SESSION['userid']}");
                    if($_currentSt[0]->pick_call_status==1 && $_currentSt[0]->manual_call_status==0){
                         $data['mode']='auto';
                        $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,1,0);
                    }
                    else if($_currentSt[0]->manual_call_status==1 && $_currentSt[0]->pick_call_status==0){
                        $data['mode']='manual';
                        $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,0,0);
                    }
                    else{
                         $data['mode']='other';
                        $_insert=$_mongo2->updateCurrentStatus($_SESSION['userid'],1,0,0);
                    }
            }
            echo json_encode($data);
        }
    }
    public function forceToLogout(){
        
        session_start();
        $_id = Request::all();
        $user_id=$_id['id'];
        $qry=DB::connection('mysql_slave')->select("SELECT * FROM `re2_agent_login_logs` where agent_id='".$user_id."' order by id desc");
        $login_time=$qry[0]->login_time;
        $login_temp=$qry[0]->login_temp;
        
            $updatesip= DB::connection('mysql_master')->insert("update re2_agent_active set login_status='0',pick_call_status=0,status=0,incall=0,manual_call_status=0 where agent_id='".$user_id."'");
            $_mongo2=new MongoController();
            $_insert=$_mongo2->updateCurrentStatus($user_id,0,0,0);
            $updatesip= DB::connection('mysql_master')->insert("update re2_agent_login_logs set logout_time=now() where agent_id='".$user_id."' and logout_time='0000-00-00 00:00:00' and login_time='$login_time' and login_temp='$login_temp'");
            $resp['status'] = 'success'; 
            header('Content-type: application/json');
            echo json_encode($resp);
    }
    public function checkCityUserlevel(array $cityid){
        
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
        $checkcityconpanindia=array_intersect($cityid, $panindiacityarray);
        $checkcitycontiertwo=array_intersect($cityid, $tiertwocityarray);
        if(count($checkcityconpanindia)>=1){
            return 1;
        }
        else if(count($checkcitycontiertwo)>=1){
            return 2;
        }
        else{
            return "Others";
        }
    }
    public function cronBackbuttonClick(){
        session_start();

        $_selectCity= DB::connection('mysql_master')->select("SELECT city_id  from re2_agent_competency_profile where agent_id={$_SESSION['userid']}");
        if(count($_selectCity)>=1){
            $cityarray=$_selectCity[0]->city_id;
            $newcityarray=explode(",",$cityarray);
            $citytype=$this->checkCityUserlevel($newcityarray);
            if($citytype==1){
                $ququecontroller=new QueueController;
                $runcron=$ququecontroller->cronQueuePanindia();
            }
            elseif($citytype==2){
                $ququecontroller=new QueueController;
                $runcron=$ququecontroller->cronQueueTiertwo();
            }
            else{
                echo "Others";
            }
        }
    }
}
