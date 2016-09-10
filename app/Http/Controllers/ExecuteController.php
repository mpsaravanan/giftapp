<?php
namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;
use Mail;
class ExecuteController extends Controller
{
    public function __construct(){
        $this->apiModel = new Api();
    }
    public function cronjobEmail(){
        $_todaydate=date('Y-m-d');
        $_dispositions= DB::connection('mysql_master')->Select("SELECT count( * ) AS leads_sent, `project_id` , `project` , `builder` , `created_date` , `buyer_mail_status` , `seller_mail_status`
        FROM `re2_agent_matchmaking_email_status` WHERE `project_id` != '0' AND `agent_id` IS NOT NULL AND (buyer_mail_status='sucsess' OR seller_mail_status='success') AND (created_date BETWEEN '$_todaydate 00:00:00' AND '$_todaydate 23:59:59')GROUP BY project_id");
        $data['data']=array();
        if(count($_dispositions)>=1){
            foreach($_dispositions as $_detail){
                $_projects= DB::connection('mysql_master')->Select("select id,project_id,leadreceiver_name,leadreceiver_email,leadreceiver_phone,leads_sent,vl_status from re2_project_campaign where project_id='{$_detail->project_id}'");
                $data_cron['project_name']=$_detail->project;
                $data_cron['builder_name']=$_detail->builder;
                $data_cron['project_id']=$_detail->project_id;
                $data_cron['leadreceiver_name']=$_projects[0]->leadreceiver_name;
                $data_cron['leadreceiver_email']=$_projects[0]->leadreceiver_email;
                $data_cron['leadreceiver_phone']=$_projects[0]->leadreceiver_phone;
                if($_projects[0]->vl_status=='1'){
                    $data_cron['vl_status']="VL";
                }
                else{
                    $data_cron['vl_status']="Not a VL";
                }
                $data_cron['count_lead']=$_detail->leads_sent;
                $data['data'][]=$data_cron;
             }
            $date=date('d-M-Y');
            Mail::send('cronLeadMail',$data,function( $message ) use ($data)
            {
              $message->to('saravanan.m@quikr.com', "Saravanan")->subject("XPORA:Leads Sent Details - QuikrHomes ".date('d-M-Y')."");
            });
            $resp['status'] = 'success'; 
            $resp['message'] = 'Email Send Sucessfully. Check your Mail'; 
        }
    }
    public function cronjobEmailLeaddetailOld(){
        $_todaydate=date('Y-m-d');
        $_dispositions= DB::connection('mysql_master')->Select("SELECT `id`,`req_id`,`agent_id`, `project_id` , `project` , `builder` , `created_date` , `buyer_mail_status` , `seller_mail_status` FROM `re2_agent_matchmaking_email_status` WHERE `project_id` != '0' AND `agent_id` IS NOT NULL AND (buyer_mail_status='sucsess' OR seller_mail_status='success') AND (created_date BETWEEN '$_todaydate 00:00:00' AND '$_todaydate 23:59:59') order by created_date DESC ");
        $data['data']=array();
        if(count($_dispositions)>=1){
            foreach($_dispositions as $_detail){
                $_projects= DB::connection('mysql_master')->Select("select id,project_id,leadreceiver_name,leadreceiver_email,leadreceiver_phone,leads_sent,vl_status from re2_project_campaign where project_id='{$_detail->project_id}'");
                $_agent= DB::connection('mysql_master')->Select("select id,name,emp_id from re2_agent_login where id='{$_detail->agent_id}'");
                $_reqdetail= DB::connection('mysql_master')->Select("select id,status,property_for_1,property_for_2,posted_by from re2_requirements where id='{$_detail->req_id}'");
                $data_cron['agent_name']=$_agent[0]->name;
                $data_cron['req_id']=$_detail->req_id;
                $data_cron['project_id']=$_detail->project_id;
                $data_cron['project_name']=$_detail->project;
                $data_cron['builder_name']=$_detail->builder;
                $data_cron['call_disposition']=$_reqdetail[0]->status;
                $data_cron['posted_by']=$_reqdetail[0]->posted_by;
                if($_projects[0]->vl_status=='1'){
                    $data_cron['vl_status']="VL";
                }
                else{
                    $data_cron['vl_status']="Not a VL";
                }
                if($_reqdetail[0]->property_for_1!="" && !empty($_reqdetail[0]->property_for_1)){
                    $data_cron['primary_intent']=ucwords($_reqdetail[0]->property_for_1);
                }else{
                    $data_cron['primary_intent']=ucwords($_reqdetail[0]->property_for_2);
                }
                $data_cron['email_sent']="yes";
                $data_cron['sms_sent']="yes";
                $data['data'][]=$data_cron;
            }
        }
        Mail::send('cronagentLeadMail',$data,function( $message ) use ($data)
        {
           $emails = array('releads@quikr.com', 'uday.kumar@quikr.com', 'ashish@quikr.com', 'mukesh.ghatiya@quikr.com', 'gaurav.rajan@quikr.com','vikram.cr@quikr.com','venkatesh.madhu@quikr.co.in','saravanan.m@quikr.com', 'sanish@quikr.com');
           $message->to($emails, "Anish")->subject("XPORA:Leads Sent Details - QuikrHomes ".date('d-M-Y')."");
        });
        $resp['status'] = 'success'; 
        $resp['message'] = 'Email Send Sucessfully. Check your Mail'; 
    }
    public function cronCallBackAt(){
        $calbackQry=DB::connection('mysql_master')->Select("Select * from re2_requirements where status='CALL_BACK_AT' ");
        $_data=array();
        foreach ($calbackQry as $value) {
            $req_id=$value->id;
            $status=$value->status;
            $city_id=$value->city_id;
            $cityQry=DB::connection('mysql_master')->Select("Select id,name from re2_cities where id='$city_id'");
            $city=$cityQry[0]->name;
            $phone_id=$value->phone_1_id;
            $phneQry=DB::connection('mysql_master')->Select("Select type,value from re2_user_contacts where id='$phone_id'");
            $phone_no=$phneQry[0]->value;
            $callbackDateQry=DB::connection('mysql_master')->Select("Select * from re2_requirement_call_dispositions where req_id='$req_id' and message='$status' order by id DESC");
            $callback_date=$callbackDateQry[0]->call_back_datetime;
            $telecaller_id=$callbackDateQry[0]->tele_caller_id;
            date_default_timezone_set('Asia/Kolkata');
            $current_datetime=date('Y-m-d H:i:s');
            $approx_callback_date=substr($callback_date, 0, -3);
            $approx_current_datetime=substr($current_datetime, 0, -3);
            if($approx_callback_date==$approx_current_datetime){
                //$result = file_get_contents(config('constants.XPORA_ENDPOINT')."xpora-reloaded/public/XporaPublisher/$req_id/$city/$phone_no/wanted");
                $queuecontroller=new QueueController;
                $result=$queuecontroller->xporaPublisher($req_id,$city,$phone_no,"wanted");
            }
        }
    }
    public function cronReattempt(){
        if(file_exists('lock8')){
            date_default_timezone_set('Asia/Kolkata');
            $date= date_create();
            date_timestamp_set($date,filemtime('lock8'));
            $starttime=(date_format($date,'Y-m-d H:i:s'));
            $endtime=(Date('Y-m-d H:i:s'));
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            if((int)$diff->format('%I')>=5 && (int)$diff->format('%S')>0){
                shell_exec('rm -r lock8');
                $data=array();
                Mail::send('cronReport',$data,function( $message ) use ($data)
                {
                    $emails = array('aman.sinha@quikr.com','saravana.m@quikr.com');
                    $message->to($emails, "Aman")->subject("XPORA:Cron cronReattempt--> ".date('d-M-Y')."");
                });
            }

        }
        if(!file_exists('lock8')){
            shell_exec('mkdir lock8');
            $reattemptqry=DB::connection('mysql_master')->Select("Select * from re2_agent_re_attempt where DATE(re_attempt_time)=DATE(NOW()) order by id DESC ");
            $_data=array();
            foreach ($reattemptqry as $value) {
                $req_id=$value->req_id;
                    $userDisposition=DB::connection('mysql_slave')->select("select city_id,phone_1_id,status from re2_requirements where id='".$req_id."'");
                    $city_id=$userDisposition[0]->city_id;
                    $cityQry=DB::connection('mysql_slave')->Select("Select id,name from re2_cities where id='$city_id'");
                    $city=$cityQry[0]->name;
                    $phone_id=$userDisposition[0]->phone_1_id;
                    $phneQry=DB::connection('mysql_slave')->Select("Select type,value from re2_user_contacts where id='$phone_id'");
                    $phone_no=$phneQry[0]->value;
                    $reattemptTime=$value->re_attempt_time;
                $callback_date=$reattemptTime;
                date_default_timezone_set('Asia/Kolkata');
                $current_datetime=date('Y-m-d H:i:s');
                $approx_callback_date=substr($callback_date, 0, -3);
                $approx_current_datetime=substr($current_datetime, 0, -3);
                if($approx_callback_date==$approx_current_datetime){
                    //$result = file_get_contents(config('constants.XPORA_ENDPOINT')."xpora-reloaded/public/XporaPublisher/$req_id/$city/$phone_no/wanted");
                    $queuecontroller=new QueueController;
                    $result=$queuecontroller->xporaPublisher($req_id,$city,$phone_no,"wanted");
                }
            }
            shell_exec('rm -r lock8');
        }
        else{
            shell_exec('exit 1');
        }
    }
    public function cronCallBackAtnew(){
       if(file_exists('lock1')){
            date_default_timezone_set('Asia/Kolkata');
            $date= date_create();
            date_timestamp_set($date,filemtime('lock1'));
            $starttime=(date_format($date,'Y-m-d H:i:s'));
            $endtime=(Date('Y-m-d H:i:s'));
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            if((int)$diff->format('%I')>=5 && (int)$diff->format('%S')>0){
                shell_exec('rm -r lock1');
                $data=array();
                Mail::send('cronReport',$data,function( $message ) use ($data)
                {
                    $emails = array('aman.sinha@quikr.com','saravana.m@quikr.com');
                    $message->to($emails, "Aman")->subject("XPORA:Cron cronCallBackAtnew--> ".date('d-M-Y')."");
                });
            }

        }
        if(!file_exists('lock1')){
            shell_exec('mkdir lock1');            
            $tdydate=date('Y-m-d');
            $callbackDateQry=DB::connection('mysql_slave')->Select("Select * from re2_requirement_call_dispositions where call_back_datetime between '$tdydate 00:00:00' AND '$tdydate 23:59:59'");
            if(count($callbackDateQry)>=1){
                foreach ($callbackDateQry as $calbackQry) {
                    $req_id=$calbackQry->req_id;
                    $reqdetails=DB::connection('mysql_master')->Select("Select id,city_id,phone_1_id from re2_requirements where id='$req_id'");
                    $city_id=$reqdetails[0]->city_id;
                    $cityQry=DB::connection('mysql_master')->Select("Select id,name from re2_cities where id='$city_id'");
                    $city=$cityQry[0]->name;
                    $phone_id=$reqdetails[0]->phone_1_id;
                    $phneQry=DB::connection('mysql_master')->Select("Select type,value from re2_user_contacts where id='$phone_id'");
                    $phone_no=$phneQry[0]->value;
                    $callback_date=$calbackQry->call_back_datetime;
                    date_default_timezone_set('Asia/Kolkata');
                    $current_datetime=date('Y-m-d H:i:s');
                    $approx_callback_date=substr($callback_date, 0, -3);
                    $approx_current_datetime=substr($current_datetime, 0, -3);
                    if($approx_callback_date==$approx_current_datetime){
                        $result = file_get_contents(config('constants.XPORA_ENDPOINT')."xpora-reloaded/public/XporaPublisher/$req_id/$city/$phone_no/wanted");
                    }
                }
            }
            else{
                echo "";
            }
           shell_exec('rm -r lock1');
        }
        else{
            shell_exec('exit 1');
        }

    }
    public function cronjobReQueue(){
        if(file_exists('lock9')){
            date_default_timezone_set('Asia/Kolkata');
            $date= date_create();
            date_timestamp_set($date,filemtime('lock9'));
            $starttime=(date_format($date,'Y-m-d H:i:s'));
            $endtime=(Date('Y-m-d H:i:s'));
            $start = new \DateTime("$starttime");
            $end = new \DateTime("$endtime");
            $diff = $start->diff($end);
            if((int)$diff->format('%I')>=5 && (int)$diff->format('%S')>0){
                shell_exec('rm -r lock9');
                $data=array();
                Mail::send('cronReport',$data,function( $message ) use ($data)
                {
                    $emails = array('aman.sinha@quikr.com','saravana.m@quikr.com');
                    $message->to($emails, "Aman")->subject("XPORA:Cron cronjobReQueue--> ".date('d-M-Y')."");
                });
            }

        }
        if(!file_exists('lock9')){
            shell_exec('mkdir lock9');
            $tdydate=date('Y-m-d');
            $requeueDateQry=DB::connection('mysql_master')->Select("SELECT * FROM `re2_agent_requeing` where created_date between '$tdydate 00:00:00' AND '$tdydate 23:59:59'");
            if(count($requeueDateQry)>=1){
                foreach ($requeueDateQry as $requeueQry) {
                    $req_id=$requeueQry->req_id;
                    $reqdetails=DB::connection('mysql_master')->Select("Select id,city_id,phone_1_id from re2_requirements where id='$req_id'");
                    $city_id=$reqdetails[0]->city_id;
                    $cityQry=DB::connection('mysql_master')->Select("Select id,name from re2_cities where id='$city_id'");
                    $city=$cityQry[0]->name;
                    $phone_id=$reqdetails[0]->phone_1_id;
                    $phneQry=DB::connection('mysql_master')->Select("Select type,value from re2_user_contacts where id='$phone_id'");
                    $phone_no=$phneQry[0]->value;
                    $callback_date=$requeueQry->created_date;
                    date_default_timezone_set('Asia/Kolkata');
                    $current_datetime=date('Y-m-d H:i:s');
                    $approx_callback_date=substr($callback_date, 0, -3);
                    $approx_current_datetime=substr($current_datetime, 0, -3);
                    if($approx_callback_date==$approx_current_datetime){
                        //$result = file_get_contents(config('constants.XPORA_ENDPOINT')."xpora-reloaded/public/XporaPublisherFuture/$req_id/$city/$phone_no/wanted");
                        $queuecontroller=new QueueController;
                        $result=$queuecontroller->xporaPublisherFuture($req_id,$city,$phone_no,"wanted");
                    }
                }
            }
            else{
                echo "";
            }
            shell_exec('rm -r lock9');
        }
        else{
            shell_exec('exit 1');
        }
    }
    public function callReporttoTL(){
        $_todaydate=date('Y-m-d');
        $_report= DB::connection('mysql_master')->Select("SELECT a.req_id, a.city, b.user_name,a.phone_no, b.source_1, b.status, a.inserted_time
        FROM `re2_agent_ad_detail` AS a, re2_requirements AS b WHERE a.req_id = b.id AND (a.inserted_time BETWEEN '$_todaydate 00:00:00' AND '$_todaydate  23:59:59')");
        $data['data']=array();
        if(count($_report)>=1){
            foreach($_report as $_detail){
                $data_cron['req_id']=$_detail->req_id;
                $data_cron['city']=$_detail->city;
                $data_cron['user_name']=$_detail->user_name;
                $data_cron['phone_no']=$_detail->phone_no;
                $data_cron['source']=$_detail->source_1;
                $data_cron['status']=$_detail->status;
                $data_cron['inserted_time']=$_detail->inserted_time;
                $data['data'][]=$data_cron;
             }
        }
        Mail::send('cronReporttoTLMail',$data,function( $message ) use ($data)
        {
          $emails = array('releads@quikr.com', 'uday.kumar@quikr.com', 'ashish@quikr.com', 'gaurav.rajan@quikr.com','vikram.cr@quikr.com', 'saravanan.m@quikr.com', 'sanish@quikr.com');
          $message->to($emails, "Saravanan")->subject("XPORA:Call Details Report - QuikrHomes ".date('d-M-Y')."");
        });
        $resp['status'] = 'success'; 
        $resp['message'] = 'Email Send Sucessfully. Check your Mail'; 
    }
    public function cronjobEmailLeaddetail(){
        $_todaydate=date('Y-m-d');
        $_dispositions= DB::connection('mysql_master')->Select("SELECT `id`,`req_id`,`agent_id`, `project_id` , `project` , `builder` , `created_date` , `buyer_mail_status` , `seller_mail_status`,seeker_name,seeker_email_id,seeker_phn_no FROM `re2_agent_matchmaking_email_status` WHERE `project_id` != '0' AND `agent_id` IS NOT NULL AND (buyer_mail_status='sucsess' OR seller_mail_status='success') AND (created_date BETWEEN '$_todaydate 00:00:00' AND '$_todaydate 23:59:59') order by created_date DESC ");
        $data['data']=array();
        if(count($_dispositions)>=1){
                $file=fopen('./xpora-dailylead-report.csv','w');
                $th=array("Seeker Name", "Seeker Email", "Seeker Phoneno", "City", "Price", "Req Id", "Project Id", "Posted By", "Project Name", "Builder Name", "Call Disposition", "Campaign Type", "Primary Intent", "Email Sent", "SMS Sent", "Agent Name", "Agent Id","TeamLeader","Created Date","Pack Id");
                $thdetail='"'. join('","', $th). '"'."\n";
                fputcsv($file, $th);
                foreach($_dispositions as $_detail){
                $_projects= DB::connection('mysql_master')->Select("select id,project_id,leadreceiver_name,leadreceiver_email,leadreceiver_phone,leads_sent,vl_status from re2_project_campaign where project_id='{$_detail->project_id}'");
                $_agent= DB::connection('mysql_master')->Select("select id,name,emp_id,reporting_to from re2_agent_login where id='{$_detail->agent_id}'");
                $_reqdetail= DB::connection('mysql_master')->Select("select id,city_id,locality_ids,status,property_for_1,property_for_2,posted_by,price_min,price_max from re2_requirements where id='{$_detail->req_id}'");
                $data_cron['agent_name']=$_agent[0]->name;
                $data_cron['agent_id']=$_agent[0]->id;
                $data_cron['req_id']=$_detail->req_id;
                $data_cron['project_id']=$_detail->project_id;
                $company=DB::connection('mysql_master')->select("select rp.company_id,rc.scsr_packid from re2_projects rp,re2_inventory_contract rc where rp.id='{$_detail->project_id}' and rp.company_id=rc.builder_id");
                if(count($company)>=1){
                    $pack_id=$company[0]->scsr_packid;
                    if($pack_id!=''){
                      $data_cron['pack_id']=$pack_id;
                    }
                    else{
                       $data_cron['pack_id']="N/A"; 
                    }
                }
                else{
                    $data_cron['pack_id']="N/A";
                }
                $data_cron['project_name']=$_detail->project;
                $data_cron['created_date']=$_detail->created_date;
                $report=DB::connection('mysql_master')->select("select name from re2_agent_login where id='".$_agent[0]->reporting_to."'");
                $data_cron['teamleader']=$report[0]->name;
                $cityQry=DB::connection('mysql_master')->Select("Select id,name from re2_cities where id='".$_reqdetail[0]->city_id."'");
                $city=$cityQry[0]->name;
                $data_cron['city_name']=$city;
                if(!empty($_reqdetail[0]->price_min) && !empty($_reqdetail[0]->price_max)){
                    $price=$_reqdetail[0]->price_min." - ".$_reqdetail[0]->price_max;
                }
                else if(empty($_reqdetail[0]->price_min) && !empty($_reqdetail[0]->price_max)){
                    $price=$_reqdetail[0]->price_max;
                }
                else if(!empty($_reqdetail[0]->price_min) && empty($_reqdetail[0]->price_max)){
                    $price=$_reqdetail[0]->price_min;
                }
                else{
                    $price="-";
                }
                $data_cron['price']=$price;

                $data_cron['seeker_name']=$_detail->seeker_name;
                $data_cron['seeker_email']=$_detail->seeker_email_id;
                $data_cron['seeker_phone']=$_detail->seeker_phn_no;

                $data_cron['builder_name']=$_detail->builder;
                $data_cron['call_disposition']=$_reqdetail[0]->status;
                $data_cron['posted_by']=$_reqdetail[0]->posted_by;
                if($_projects[0]->vl_status=='1'){
                    $data_cron['vl_status']="VL";
                }
                else{
                    $data_cron['vl_status']="Not a VL";
                }
                if($_reqdetail[0]->property_for_1!="" && !empty($_reqdetail[0]->property_for_1)){
                    $data_cron['primary_intent']=ucwords($_reqdetail[0]->property_for_1);
                }else{
                    $data_cron['primary_intent']=ucwords($_reqdetail[0]->property_for_2);
                }
                $data_cron['email_sent']="yes";
                $data_cron['sms_sent']="yes";

                $contentarray = array($data_cron['seeker_name'], $data_cron['seeker_email'], $data_cron['seeker_phone'], $data_cron['city_name'], $data_cron['price'], $data_cron['req_id'], $data_cron['project_id'], $data_cron['posted_by'], $data_cron['project_name'], $data_cron['builder_name'], $data_cron['call_disposition'], $data_cron['vl_status'], $data_cron['primary_intent'], $data_cron['email_sent'], $data_cron['sms_sent'], $data_cron['agent_name'], $data_cron['agent_id'],$data_cron['teamleader'],$data_cron['created_date'],$data_cron['pack_id']);
                $str10 = '"'. join('","', $contentarray). '"'."\n";
                fputcsv($file, $contentarray);
                $data['data'][]=$data_cron;

            }
            fclose($file);
            $countdata['count']= count($data['data']);
            Mail::send('leadEmailHourly',$countdata,function( $message ) use ($countdata)
            {
               $emails = array('releads@quikr.com','reops-qa@quikr.com', 'uday.kumar@quikr.com', 'ashish@quikr.com','nimesh.bhandari@quikr.com', 'mukesh.ghatiya@quikr.com', 'gaurav.rajan@quikr.com','vikram.cr@quikr.com','venkatesh.madhu@quikr.co.in','saravanan.m@quikr.com', 'sanish@quikr.com');
               //$emails = array('saravanan.m@quikr.com');
               $message->to($emails, "Anish")->subject("XPORA:Daily Leads Sent Details - QuikrHomes ".date('d-M-Y')."");
               $message->attach('./xpora-dailylead-report.csv');
            });
            unlink('./xpora-dailylead-report.csv');
            $resp['status'] = 'success';
            $resp['message'] = 'Email Send Sucessfully. Check your Mail';

        }
        else{
            echo "Empty Result";
            $countdata['count']='0';   
            Mail::send('leadEmailHourly',$countdata,function( $message ) use ($countdata)
            {
               $emails = array('releads@quikr.com','reops-qa@quikr.com', 'uday.kumar@quikr.com', 'ashish@quikr.com','nimesh.bhandari@quikr.com', 'mukesh.ghatiya@quikr.com', 'gaurav.rajan@quikr.com','vikram.cr@quikr.com','venkatesh.madhu@quikr.co.in','saravanan.m@quikr.com', 'sanish@quikr.com');
               //$emails = array('saravanan.m@quikr.com');
               $message->to($emails, "Anish")->subject("XPORA:Daily Leads Sent Details - QuikrHomes ".date('d-M-Y')."");
            });
        }

    }
     public function leadHourlyReport(){
        $_todaydate=date('Y-m-d');
        $_dispositions= DB::connection('mysql_master')->Select("SELECT `id`,`req_id`,`agent_id`, `project_id` , `project` , `builder` , `created_date` , `buyer_mail_status` , `seller_mail_status`,seeker_name,seeker_email_id,seeker_phn_no FROM `re2_agent_matchmaking_email_status` WHERE `project_id` != '0' AND `agent_id` IS NOT NULL AND (buyer_mail_status='sucsess' OR seller_mail_status='success') AND created_date>=DATE_SUB(NOW(), INTERVAL 1 HOUR) order by created_date DESC ");
        $data['data']=array();
        if(count($_dispositions)>=1){
                $file=fopen('./xpora-hourlylead-report.csv','w');
                $th=array("Seeker Name", "Seeker Email", "Seeker Phoneno", "City", "Price", "Req Id", "Project Id", "Posted By", "Project Name", "Builder Name", "Call Disposition", "Campaign Type", "Primary Intent", "Email Sent", "SMS Sent", "Agent Name", "Agent Id","TeamLeader","Created Date","Pack Id");
                $thdetail='"'. join('","', $th). '"'."\n";
                fputcsv($file, $th);
                foreach($_dispositions as $_detail){
                $_projects= DB::connection('mysql_master')->Select("select id,project_id,leadreceiver_name,leadreceiver_email,leadreceiver_phone,leads_sent,vl_status from re2_project_campaign where project_id='{$_detail->project_id}'");
                $_agent= DB::connection('mysql_master')->Select("select id,name,emp_id from re2_agent_login where id='{$_detail->agent_id}'");
                $_reqdetail= DB::connection('mysql_master')->Select("select id,city_id,locality_ids,status,property_for_1,property_for_2,posted_by,price_min,price_max from re2_requirements where id='{$_detail->req_id}'");
                $data_cron['agent_name']=$_agent[0]->name;
                $data_cron['agent_id']=$_agent[0]->id;
                $data_cron['req_id']=$_detail->req_id;
                $data_cron['project_id']=$_detail->project_id;
                $company=DB::connection('mysql_master')->select("select rp.company_id,rc.scsr_packid from re2_projects rp,re2_inventory_contract rc where rp.id='{$_detail->project_id}' and rp.company_id=rc.builder_id");
                if(count($company)>=1){
                    $pack_id=$company[0]->scsr_packid;
                    if($pack_id!=''){
                      $data_cron['pack_id']=$pack_id;
                    }
                    else{
                       $data_cron['pack_id']="N/A"; 
                    }
                }
                else{
                    $data_cron['pack_id']="N/A";
                }
                $data_cron['project_name']=$_detail->project;
                $data_cron['created_date']=$_detail->created_date;
                $report=DB::connection('mysql_master')->select("select name from re2_agent_login where id='".$_agent[0]->reporting_to."'");
                $data_cron['teamleader']=$report[0]->name;
                $cityQry=DB::connection('mysql_master')->Select("Select id,name from re2_cities where id='".$_reqdetail[0]->city_id."'");
                $city=$cityQry[0]->name;
                $data_cron['city_name']=$city;
                if(!empty($_reqdetail[0]->price_min) && !empty($_reqdetail[0]->price_max)){
                    $price=$_reqdetail[0]->price_min." - ".$_reqdetail[0]->price_max;
                }
                else if(empty($_reqdetail[0]->price_min) && !empty($_reqdetail[0]->price_max)){
                    $price=$_reqdetail[0]->price_max;
                }
                else if(!empty($_reqdetail[0]->price_min) && empty($_reqdetail[0]->price_max)){
                    $price=$_reqdetail[0]->price_min;
                }
                else{
                    $price="-";
                }
                $data_cron['price']=$price;

                $data_cron['seeker_name']=$_detail->seeker_name;
                $data_cron['seeker_email']=$_detail->seeker_email_id;
                $data_cron['seeker_phone']=$_detail->seeker_phn_no;

                $data_cron['builder_name']=$_detail->builder;
                $data_cron['call_disposition']=$_reqdetail[0]->status;
                $data_cron['posted_by']=$_reqdetail[0]->posted_by;
                if($_projects[0]->vl_status=='1'){
                    $data_cron['vl_status']="VL";
                }
                else{
                    $data_cron['vl_status']="Not a VL";
                }
                if($_reqdetail[0]->property_for_1!="" && !empty($_reqdetail[0]->property_for_1)){
                    $data_cron['primary_intent']=ucwords($_reqdetail[0]->property_for_1);
                }else{
                    $data_cron['primary_intent']=ucwords($_reqdetail[0]->property_for_2);
                }
                $data_cron['email_sent']="yes";
                $data_cron['sms_sent']="yes";

                $contentarray = array($data_cron['seeker_name'], $data_cron['seeker_email'], $data_cron['seeker_phone'], $data_cron['city_name'], $data_cron['price'], $data_cron['req_id'], $data_cron['project_id'], $data_cron['posted_by'], $data_cron['project_name'], $data_cron['builder_name'], $data_cron['call_disposition'], $data_cron['vl_status'], $data_cron['primary_intent'], $data_cron['email_sent'], $data_cron['sms_sent'], $data_cron['agent_name'], $data_cron['agent_id'],$data_cron['teamleader'],$data_cron['created_date'],$data_cron['pack_id']);
                $str10 = '"'. join('","', $contentarray). '"'."\n";
                fputcsv($file, $contentarray);
                $data['data'][]=$data_cron;

            }
            fclose($file);
            $countdata['count']= count($data['data']);
            Mail::send('leadEmailHourly',$countdata,function( $message ) use ($countdata)
            {
               $emails = array('releads@quikr.com','reops-qa@quikr.com', 'uday.kumar@quikr.com', 'ashish@quikr.com','nimesh.bhandari@quikr.com', 'mukesh.ghatiya@quikr.com', 'gaurav.rajan@quikr.com','vikram.cr@quikr.com','venkatesh.madhu@quikr.co.in','saravanan.m@quikr.com', 'sanish@quikr.com');
               //$emails = array('saravanan.m@quikr.com');
               $message->to($emails, "Anish")->subject("XPORA:Hourly Leads Sent Details - QuikrHomes ".date('d-M-Y')."");
               $message->attach('./xpora-hourlylead-report.csv');
            });
            unlink('./xpora-hourlylead-report.csv');
            $resp['status'] = 'success';
            $resp['message'] = 'Email Send Sucessfully. Check your Mail';

        }
        else{
            echo "Empty Result";
            $countdata['count']='0';   
            Mail::send('leadEmailHourly',$countdata,function( $message ) use ($countdata)
            {
               $emails = array('releads@quikr.com','reops-qa@quikr.com', 'uday.kumar@quikr.com', 'ashish@quikr.com', 'mukesh.ghatiya@quikr.com', 'nimesh.bhandari@quikr.com','gaurav.rajan@quikr.com','vikram.cr@quikr.com','venkatesh.madhu@quikr.co.in','saravanan.m@quikr.com', 'sanish@quikr.com');
               //$emails = array('saravanan.m@quikr.com');
               $message->to($emails, "Anish")->subject("XPORA:Hourly Leads Sent Details - QuikrHomes ".date('d-M-Y')."");
            });
        }
    }
    public function dailyFlowReport(){
        $_startdate="2016-07-10 00:00:00";
        $_enddate="2016-07-10 23:59:59";
        $_flow=array();
        $data=array();
        $select_qry=DB::connection('mysql_slave')->select("SELECT a.id,a.source_1 as source,a.phone_1_id,a.city_id,a.status,a.created_date,b.caller_no,b.telecaller_id,b.timestamp,
        b.answer_datetime_legB,b.end_datetime_legB FROM re2_requirements as a 
        LEFT JOIN re2_agent_call_cdr as b ON a.id = b.xpora_req_id WHERE (
        a.created_date
         BETWEEN CURDATE() - INTERVAL 1 DAY AND CURDATE()
        ) AND property_for_1 like '%buy%'");
        if(count($select_qry)>=1){
            $file=fopen('./xpora-inflow-report.csv','w');
            $th=array("Req_id", "Phone Number","Source", "City", "Latest Dispostion", "Latest Dispostion Datetime", "Inflow Datetime", "Dialled Datetime", "Call Duration" ,"Agent Name", "TL Name");
            $thdetail='"'. join('","', $th). '"'."\n";
            fputcsv($file, $th);
            foreach($select_qry as $inflow){
                $_flow['req_id']=$inflow->id;
                $_flow['source']=$inflow->source;
                $_flow['status']=$inflow->status;
                $_flow['updated_date'] = $inflow->created_date;
                if(!empty($inflow->caller_no)) {
                    $_flow['phone'] = $inflow->caller_no;
                }
                else{
                    $phone_id=$inflow->phone_1_id;
                    $phneQry=DB::connection('mysql_master')->Select("Select type,value from re2_user_contacts where id='$phone_id'");
                    if(count($phneQry)==1) {
                        $_flow['phone'] = $phneQry[0]->value;
                    }
                    else{
                        $_flow['phone'] = "-";
                    }
                }
                if(!empty($inflow->telecaller_id)) {
                    $_agent = DB::connection('mysql_slave')->Select("select id,name,emp_id,reporting_to from re2_agent_login where id='" . $inflow->telecaller_id . "'");
                    if(count($_agent)>=1){
                        $report = DB::connection('mysql_slave')->select("select name from re2_agent_login where id='" . $_agent[0]->reporting_to . "'");
                        $_flow['agent_name'] = $_agent[0]->name;
                        $_flow['teamleader'] = $report[0]->name;
                    }
                    else{
                        $_flow['agent_name']="-";
                        $_flow['teamleader']="-";
                    }
                }
                else{
                    $_flow['agent_name']="-";
                    $_flow['teamleader']="-";
                }
                $cityQry=DB::connection('mysql_slave')->Select("Select id,name from re2_cities where id='".$inflow->city_id."'");
                $city=$cityQry[0]->name;
                $_flow['city']=$city;
                $_flow['call_duration']="00:00:00";
                if(!empty($inflow->answer_datetime_legB) && $inflow->answer_datetime_legB!='0000-00-00 00:00:00' && $inflow->end_datetime_legB!='0000-00-00 00:00:00'  && !empty($inflow->end_datetime_legB)){
                    $starttime= $inflow->answer_datetime_legB;
                    $endtime= $inflow->end_datetime_legB;
                    $start = new \DateTime("$starttime");
                    $end = new \DateTime("$endtime");
                    $diff = $start->diff($end);
                    $_flow['call_duration']=$diff->format('%H').":".$diff->format('%I').":".$diff->format('%S');
                }
                if(!empty($inflow->timestamp)){
                    $_flow['dialed_date']=$inflow->timestamp;
                }
                else{
                    $_flow['dialed_date']="-";
                }
                if($inflow->status!='NEW'){
                    $select_qry2=DB::connection('mysql_slave')->select("SELECT created_date from re2_requirements_history where req_id='".$inflow->id."' and status='NEW' order by id limit 0,1");
                    if(count($select_qry2)==1) {
                        $_flow['inflow_date'] = $select_qry2[0]->created_date;
                    }
                    else{
                        $_flow['inflow_date']=$inflow->created_date;
                    }
                }
                else{
                    $_flow['inflow_date']=$inflow->created_date;
                }
                $contentarray = array($_flow['req_id'],$_flow['phone'],$_flow['source'],$_flow['city'],$_flow['status'],$_flow['updated_date'],$_flow['inflow_date'],$_flow['dialed_date'],$_flow['call_duration'],$_flow['agent_name'],$_flow['teamleader']);
                $str10 = '"'. join('","', $contentarray). '"'."\n";
                fputcsv($file, $contentarray);
                $data['data'][]=$_flow;
            }
            fclose($file);
            $countdata['count']= count($data['data']);
            Mail::send('leadEmailHourly',$countdata,function( $message ) use ($countdata)
            {
                $emails = array('releads@quikr.com','reops-qa@quikr.com', 'uday.kumar@quikr.com', 'ashish@quikr.com','nimesh.bhandari@quikr.com', 'gaurav.rajan@quikr.com','vikram.cr@quikr.com','venkatesh.madhu@quikr.co.in','saravanan.m@quikr.com', 'aman.sinha@quikr.com', 'virendra.singh@quikr.com','sitakanta.rath@quikr.com');
                //$emails = array('saravanan.m@quikr.com');
                $message->to($emails, "Anish")->subject("XPORA:Inflow Details - QuikrHomes ".date('d-M-Y')."");
                $message->attach('./xpora-inflow-report.csv');
            });
            unlink('./xpora-inflow-report.csv');
            $resp['status'] = 'success';
            $resp['message'] = 'Email Send Sucessfully. Check your Mail';
        }
        else{
            echo "Empty Result";
            $countdata['count']='0';
            Mail::send('leadEmailHourly',$countdata,function( $message ) use ($countdata)
            {
                //$emails = array('releads@quikr.com','reops-qa@quikr.com', 'uday.kumar@quikr.com', 'ashish@quikr.com', 'mukesh.ghatiya@quikr.com', 'nimesh.bhandari@quikr.com','gaurav.rajan@quikr.com','vikram.cr@quikr.com','venkatesh.madhu@quikr.co.in','saravanan.m@quikr.com', 'sanish@quikr.com');
                $emails = array('saravanan.m@quikr.com');
                $message->to($emails, "Anish")->subject("XPORA:Inflow Details - QuikrHomes");
            });
        }
    }
    public function creates(){
        /*
                $_report= DB::connection('mysql_master')->insert("insert into re2_agent_login(name,emp_id,password,email,mobile,level,reporting_to,created_time) 
                values('Prathap Rao','1205','827ccb0eea8a706c4c34a16891f84e7b','prathap.rao@quikr.co.in','9611730045','0','',NOW()),
                ('Thausif Rehaman','1174','827ccb0eea8a706c4c34a16891f84e7b','thausif.rehaman@quikr.co.in','9611730045','0','',NOW()),
                ('Gousia Durani','1059','827ccb0eea8a706c4c34a16891f84e7b','gousia.durani@quikr.co.in','9611730045','0','',NOW())
                "); */
        /*        $_report= DB::connection('mysql_master')->update("update re2_agent_login set reporting_to='105' where id='105'");
                $_report= DB::connection('mysql_master')->update("update re2_agent_login set reporting_to='106' where id='106'");
               $_report= DB::connection('mysql_master')->update("update re2_agent_login set reporting_to='104' where id='104'");
          */      //      $_report= DB::connection('mysql_master')->update("update re2_agent_active set  sip_id='64' where agent_id='89'");
                //      $_report= DB::connection('mysql_master')->update("update re2_agent_sip_allotment set  status='1' where id='64'");
        //$query=DB::connection('mysql_master')->update("update re2_agent_competency_profile set city_id='24,781001,1075963,152222,1027721,142222,1133563,1144903,22,390001,248003,1115023,250002,244302,1126183,162222,172222,281001,140110,1138783,462001,1086583,1019081,431001,1088023,1126723,1059582,382010,751001,403108,1040682,422001,1025381,175101,831001,482004,1113763,141001,1125283,263001,211001' where agent_id in (94,95,96,98,99)");
        
    }
}
