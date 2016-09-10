<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/error', function () {
    return view('error');
});
//Leadform Routes Starts Here..
//Route::get('/Leadform/{id}', array('as'=>"Leadform",'uses'=> 'LeadformController@show'));
Route::get('/Leadform/{id}', array('as'=>"Leadform",'uses'=> 'LeadformController@show'));
Route::get('/LeadformReq/{id}', array('as'=>"LeadformReq",'uses'=> 'LeadformController@leadformReq'));
Route::get('/Leadformdetails/city/', array('as'=>"Leadformcity",'uses'=> 'LeadformController@getcityval'));
Route::post('/Leadformupdate/', array('as'=>"Leadformupdate",'uses'=> 'LeadformController@update'));
Route::get('/Leadformdetails/locnames/', array('as'=>"Leadformcityloc",'uses'=> 'LeadformController@cityBaselocations'));
Route::get('/Leadformdetails/projectnames/', array('as'=>"Leadformcityproject",'uses'=> 'LeadformController@cityBaseprojects'));
Route::get('/Leadformdetails/', array('as'=>"leadFormMatchmaking",'uses'=>'LeadformController@matchMakingdetails'));
Route::post('/Leadformdetails/sendAll', array('as'=>"sendAllMatchmaking",'uses'=>'LeadformController@sendAll'));
Route::post('/Leadformdetails/send', array('as'=>"sendMatchmaking",'uses'=>'LeadformController@sendMail'));
Route::get('/Leadformdetails/projectdetail', array('as'=>"projectDetail",'uses'=>'LeadformController@projectDetails'));
Route::get('/Leadformdetails/leadFormMatchmaking', array('as'=>"leadFormMatchmaking",'uses'=>'LeadformController@matchMakingdetails'));
Route::get('/Leadformdetails/Lackproperties', array('as'=>"lackProperties",'uses'=>'LeadformController@lackofProperties'));
Route::get('/Leadformdetails/ChangeStatusAfterupdate', array('as'=>"ChangeStatusAfterupdate",'uses'=>'LeadformController@changeStatusAfterupdate'));
Route::get('/Leadformdetails/callDropConnect', array('as'=>"callDropConnect",'uses'=>'LeadformController@dropcall_connect'));
Route::get('/Leadformdetails/ProjectSearch', array('as'=>"ProjectSearch",'uses'=>'LeadformController@projectSearch'));
Route::get('/Leadformdetails/SendMailproject', array('as'=>"SendMailproject",'uses'=>'LeadformController@sendMailproject'));
Route::post('/UpdateEmail', array('as'=>"UpdateEmail",'uses'=>'LeadformController@updateEmail'));
Route::post('/HistoryEmail', array('as'=>"HistoryEmail",'uses'=>'LeadformController@historyEmail'));
Route::post('/HistoryMobile', array('as'=>"HistoryMobile",'uses'=>'LeadformController@historyMobile'));
Route::post('/UpdateMobile', array('as'=>"UpdateMobile",'uses'=>'LeadformController@updateMobile'));
//Leadform Routes Ends Here..

//Login Logout Routes Starts here.
Route::get('/Login', array('as'=>"Viewlogin",'uses'=> 'LoginController@viewLogin'));
Route::get('/Logout', array('as'=>"Logout",'uses'=> 'LoginController@logOut'));
Route::post('/Login/Check', array('as'=>"Checklogin",'uses'=> 'LoginController@checkLogin'));
Route::post('/Login/Forgotpassword', array('as'=>"Forgotpassword",'uses'=> 'LoginController@forgotPassword'));
Route::get('/Login/Resetpassword/{token}', array('as'=>"Resetpassword",'uses'=> 'LoginController@resetPassword'));
Route::post('/Login/Updatepassword', array('as'=>"Updatepassword",'uses'=> 'LoginController@updatePassword'));
Route::get('/Login/CheckagentMode/', array('as'=>"CheckagentMode",'uses'=> 'LoginController@checkagentMode'));
Route::get('/ForceToLogout', array('as'=>"ForceToLogout",'uses'=> 'LoginController@forceToLogout'));

//Login Logout Routes Ends here..

//User View Routes Starts Here..
Route::get('/Userview', array('as'=>"Userview",'uses'=> 'ViewController@userView'));
Route::get('/filterDashboard', array('as'=>"filterDashboard",'uses'=> 'ViewController@searchDashboard'));
Route::get('/Reportingto', array('as'=>"Reportingto",'uses'=> 'ViewController@reportingTo'));
Route::get('/Deleteuser', array('as'=>"Deleteuser",'uses'=> 'ViewController@userDelete'));
Route::post('/Edituser', array('as'=>"Edituser",'uses'=> 'ViewController@userEdit'));
Route::get('/city', array('as'=>"Getcity",'uses'=> 'ViewController@getCity'));
Route::get('/CitySearch', array('as'=>"CitySearch",'uses'=> 'ViewController@citySearch'));
Route::get('/location', array('as'=>"Getlocation",'uses'=> 'ViewController@getLoc'));
Route::get('/project', array('as'=>"Getproject",'uses'=> 'ViewController@getProject'));
Route::get('/Agentdetails', array('as'=>"Agentdetails",'uses'=> 'ViewController@agentDetails'));
Route::get('/CallDetailReport', array('as'=>"CallDetailReport",'uses'=> 'ViewController@callDetailReport'));
Route::get('/TotalLoginReport', array('as'=>"TotalLoginReport",'uses'=> 'ViewController@totalLoginReport'));
Route::get('/CampaignReport', array('as'=>"CampaignReport",'uses'=> 'ViewController@campaignReport'));
Route::get('/AgentLoggedin', array('as'=>"AgentLoggedinReport",'uses'=> 'ViewController@agentLoggedinReport'));
Route::get('/PendingReport', array('as'=>"PendingReport",'uses'=> 'ViewController@pendingReport'));
Route::get('/MannualCallAssignment', array('as'=>"MannualCallAssignment",'uses'=> 'ViewController@mannualCallAssignment'));
Route::get('/GetSinglecity', array('as'=>"GetSinglecity",'uses'=> 'ViewController@getSingleCity'));
Route::get('/GetTelecaller', array('as'=>"GetTelecaller",'uses'=> 'ViewController@getTelecaller'));
Route::post('/PendingCallpost', array('as'=>"PendingCallpost",'uses'=> 'ViewController@pendingCallpost'));
Route::get('/DashboardCounts', array('as'=>"DashboardCounts",'uses'=> 'ViewController@dashboardCounts'));
Route::get('/CountsNotification', array('as'=>"CountsNotification",'uses'=> 'ViewController@countsNotification'));
Route::get('/CountsNotificationDetails', array('as'=>"CountsNotificationDetails",'uses'=> 'ViewController@countsNotificationDetails'));
Route::get('/Orgchart', array('as'=>"Orgchart",'uses'=> 'ViewController@orgChart'));
Route::get('/BrkDetails', array('as'=>"BrkDetails",'uses'=> 'ViewController@brkDetails'));
Route::get('/ViewVLProjects', array('as'=>"ViewVLProjects",'uses'=> 'ViewController@viewVlProjects'));
Route::get('/CurrentStatus', array('as'=>"CurrentStatus",'uses'=> 'ViewController@currentStatus'));

//Reports View Separate
Route::get('/Reports', array('as'=>"Reports",'uses'=> 'ReportController@reportView'));


Route::get('/GetUserSearchMakeCall', array('as'=>"GetUserSearchMakeCall",'uses'=> 'ViewController@getUserSearchMakeCall'));
Route::get('/GetSingleSearchLocality', array('as'=>"GetSingleSearchLocality",'uses'=> 'ViewController@getSingleSearchLocality'));
Route::post('/AssignUserSearchMakeCall', array('as'=>"AssignUserSearchMakeCall",'uses'=> 'ViewController@getAssignUserSearchMakeCall'));

Route::get('/CallDetailReportDownload', array('as'=>"CallDetailReportDownload",'uses'=> 'ViewController@callDetailReportDownload'));
//User View Routes Ends Here..

//Create Agent/User Routes Starts Here..
Route::get('/Createagent', array('as'=>"Createagent",'uses'=> 'CreateAgentController@createUser'));
Route::post('/Createagentpost', array('as'=>"Createagentpost",'uses'=> 'CreateAgentController@addUser'));
Route::get('/Createagent', array('as'=>"Getavailsipnumber",'uses'=> 'CreateAgentController@getAvailSipnumber'));
Route::get('/Showmanagerlist', array('as'=>"Showmanagerlist",'uses'=> 'CreateAgentController@showManagerList'));
Route::get('/Agentsummary', array('as'=>"Agentsummary",'uses'=> 'CreateAgentController@agentSummary'));
//Create Agent/User Routes End Here...

//Matching Projects
Route::get('/MatchmakingAPI/{id}/{city}/{no}/{source}',array('as'=>"MatchmakingAPI",'uses'=>'MatchMakingController@matchingProjects'));


//Competency Profile  Routes starts Here
Route::post('/CompetencyProfile', array('as'=>"createCompetency",'uses'=> 'CompetencyController@addCompetency'));
Route::get('/Getusernew', array('as'=>"Getusernew",'uses'=> 'CompetencyController@getNewuser'));
Route::get('/Getuserexist', array('as'=>"Getuserexist",'uses'=> 'CompetencyController@getExistuser'));
Route::get('/ViewCompetency', array('as'=>"ViewCompetency",'uses'=> 'CompetencyController@viewCompetency'));
Route::post('/UpdateCompetency', array('as'=>"updateCompetency",'uses'=> 'CompetencyController@competencyUpdate'));
Route::get('/GetLocationbaseCity', array('as'=>"GetLocationbaseCity",'uses'=> 'CompetencyController@getLocationbaseCity'));
Route::get('/GetProjectbaseLocation', array('as'=>"GetProjectbaseLocation",'uses'=> 'CompetencyController@getProjectbaseLocation'));

Route::get('/GetAgentNames', array('as'=>"GetAgentNames",'uses'=> 'CompetencyController@getAgentNames'));
Route::get('/GetTlNames', array('as'=>"GetTlNames",'uses'=> 'CompetencyController@getTlNames'));
Route::get('/GetManagerNames', array('as'=>"GetManagerNames",'uses'=> 'CompetencyController@getManagerNames'));
//Competency Profile  Routes Ends Here

//Create CDR Routes Starts Here..
Route::get('/CdrInsert', array('as'=>"CdrInsert",'uses'=> 'CdrDataController@addCdr'));
//Create CDR Routes End Here..

//Create Pusher Routes Starts Here..
Route::get('/Pusher/{agentid}/{sipnumber}/{reqid}/{callernumber}/{lagA_uuid}/{lagB_uuid}/{call_mode}', array('as'=>"Pusher",'uses'=> 'PusherController@triggerPusher'));
Route::get('/Pusherfailed/{agentid}/{sipnumber}/{reqid}/{callernumber}/{lagA_uuid}/{lagB_uuid}', array('as'=>"Pusherfailed",'uses'=> 'PusherController@triggerPusherfailed'));
Route::get('/ManualCallProcessing/{agent_id}/{staus}/{lagAuuid}', array('as'=>"ManualCallProcessing",'uses'=> 'PusherController@manualCallProcessing'));

//Create Pusher Routes End Here..

//Competency Profile Mapping..
Route::get('/MappingCompetency', array('as'=>"MappingCompetency",'uses'=> 'MappingController@mappingCompetency'));
Route::get('/RmqAgentAvailability/{reqid}/{custno}', array('as'=>"RmqAgentAvailability",'uses'=> 'MappingController@rmqAgentAvailability'));

//Auto Call getting from telephony 
Route::get('/ReadyTogetCall', array('as'=>"ReadyTogetCall",'uses'=> 'ReadytocallController@readytogetCall'));
Route::get('/ReadyToLeaveCall', array('as'=>"ReadyToLeaveCall",'uses'=> 'ReadytocallController@readytoleaveCall'));
Route::get('/CallstatusOn/{agent_id}', array('as'=>"CallstatusOn",'uses'=> 'ReadytocallController@callStatuson'));
Route::get('/CallstatusOff/{agent_id}', array('as'=>"CallstatusOff",'uses'=> 'ReadytocallController@callStatusoff'));
Route::get('/CallstatusOnPusher', array('as'=>"CallstatusOnPusher",'uses'=> 'ReadytocallController@callstatusOnPusher'));
Route::get('/ManualMode', array('as'=>"Manualmode",'uses'=> 'ReadytocallController@ManualMode'));
Route::get('/ManualCall', array('as'=>"ManualCall",'uses'=> 'ReadytocallController@manualCall'));
Route::get('/Assignedcall', array('as'=>"Assignedcall",'uses'=> 'ReadytocallController@assignedCall'));
Route::get('/AssignCall', array('as'=>"AssignCall",'uses'=> 'ReadytocallController@assignCall'));
Route::get('/HoldCall', array('as'=>"HoldCall",'uses'=> 'ReadytocallController@holdCall'));
Route::get('/UnholdCall', array('as'=>"UnholdCall",'uses'=> 'ReadytocallController@unHoldCall'));
Route::get('/DisconnectCall', array('as'=>"DisconnectCall",'uses'=> 'ReadytocallController@disconnectCall'));
Route::get('/InitNextAutoCall', array('as'=>"InitNextAutoCall",'uses'=> 'ReadytocallController@initNextAutoCall'));
Route::get('/BrkReason', array('as'=>"BrkReason",'uses'=> 'ReadytocallController@breakReason'));
Route::get('/BrkReasonfromLeadform', array('as'=>"BrkReasonfromLeadform",'uses'=> 'ReadytocallController@brkReasonfromLeadform'));
Route::get('/inCallstatusOnPusher', array('as'=>"inCallstatusOnPusher",'uses'=> 'ReadytocallController@incallstatusOnPusher'));


//Call Queue - PRESENT FUTURE
Route::get('/XporaPublisher/{id}/{city}/{no}/{source}', array('as'=>"XporaPublisher",'uses'=> 'QueueController@xporaPublisher'));
Route::get('/XporaPublisherFuture/{id}/{city}/{no}/{source}', array('as'=>"XporaPublisherFuture",'uses'=> 'QueueController@xporaPublisherFuture'));
//Present Queue Listener
Route::get('/XporaListenerPresentQueue', array('as'=>"XporaListenerPresentQueue",'uses'=> 'QueueController@xporaListenerPresentQueue'));
Route::get('/XporaListenerPanindiaPresent', array('as'=>"XporaListenerPanindiaPresent",'uses'=> 'QueueController@xporaListenerPanindiaPresent'));
Route::get('/XporaListenerTiertwoPresent', array('as'=>"XporaListenerTiertwoPresent",'uses'=> 'QueueController@xporaListenerTiertwoPresent'));

//Future Queue Listener
Route::get('/XporaListenerPanindiaFuture', array('as'=>"XporaListenerPanindiaFuture",'uses'=> 'QueueController@xporaListenerPanindiaFuture'));
Route::get('/XporaListenerTiertwoFuture', array('as'=>"XporaListenerTiertwoFuture",'uses'=> 'QueueController@xporaListenerTiertwoFuture'));

Route::get('/XporaListenerFutureQueue', array('as'=>"XporaListenerFutureQueue",'uses'=> 'QueueController@xporaListenerFutureQueue'));
//Move Present to Future If Its Not a Same Date..
Route::get('/MovePresentToFuturePanindia', array('as'=>"MovePresentToFuturePanindia",'uses'=> 'QueueController@movePresentToFuturePanindia'));
Route::get('/MovePresentToFutureTiertwo', array('as'=>"MovePresentToFutureTiertwo",'uses'=> 'QueueController@movePresentToFutureTiertwo'));
//New Cron Logic
Route::get('/CronQueuePanindia', array('as'=>"CronQueuePanindia",'uses'=> 'QueueController@cronQueuePanindia'));
Route::get('/CronQueueTiertwo', array('as'=>"CronQueueTiertwo",'uses'=> 'QueueController@cronQueueTiertwo'));

Route::get('/QueueCall/{customerno}/{sipnumber}/{req_id}/{agent_id}/{queue}', array('as'=>"QueueCall",'uses'=> 'QueueController@queueCall'));
Route::get('/CheckQueueEmpty/{exchangename}/{queuename}', array('as'=>"CheckQueueEmpty",'uses'=> 'QueueController@checkQueueEmpty'));
Route::get('/StopConsumeQueue/{exchangename}/{queuename}', array('as'=>"StopConsumeQueue",'uses'=> 'QueueController@stopConsumeQueue'));

//Back Button Click 
Route::get('/CronBackbuttonClick', array('as'=>"CronBackbuttonClick",'uses'=> 'LoginController@cronBackbuttonClick'));

//Execute Queries....
Route::get('/CronjobEmail', array('as'=>"CronjobEmail",'uses'=> 'ExecuteController@cronjobEmail'));
Route::get('/CronjobEmailLeaddetail', array('as'=>"CronjobEmailLeaddetail",'uses'=> 'ExecuteController@cronjobEmailLeaddetail'));
Route::get('/CronjobCallBackAt', array('as'=>"CronjobCallBackAt",'uses'=> 'ExecuteController@cronCallBackAt'));
Route::get('/CronReattempt', array('as'=>"CronReattempt",'uses'=> 'ExecuteController@cronReattempt'));
Route::get('/CronjobCallBackAtNew', array('as'=>"CronjobCallBackAtNew",'uses'=> 'ExecuteController@cronCallBackAtnew'));
Route::get('/CronjobReQueue', array('as'=>"CronjobReQueue",'uses'=> 'ExecuteController@cronjobReQueue'));
Route::get('/CallReporttoTL', array('as'=>"CallReporttoTL",'uses'=> 'ExecuteController@callReporttoTL'));
Route::get('/LeadHourlyReport', array('as'=>"LeadHourlyReport",'uses'=> 'ExecuteController@leadHourlyReport'));
Route::get('/PostCallCaseListener', array('as'=>"PostCallCaseListener",'uses'=> 'QueueController@postCallQueueListener'));
Route::get('/Inflowdetails', array('as'=>"Inflowdetails",'uses'=> 'ExecuteController@dailyFlowReport'));

//Manual Assignment Queue//Extra Updates..
Route::get('/CreateS', array('as'=>"CreateS",'uses'=> 'ExecuteController@creates'));

//MONGO Controller..
//Route::get('/CallDetailReport', array('as'=>"CallDetailReport",'uses'=> 'MongoController@callDetailReportMongo'));

Route::get('/Mongoadd', array('as'=>"Mongoadd",'uses'=> 'MongoController@addAgentUserDetail'));
Route::get('/Mongocheck', array('as'=>"Mongocheck",'uses'=> 'MongoController@check'));
Route::get('/ShowMongo', array('as'=>"ShowMongo",'uses'=> 'MongoController@callDetailReportMongo'));
Route::get('/agentDetailreportMongo', array('as'=>"agentDetailreportMongo",'uses'=> 'MongoController@agentdetailsMongo'));
Route::get('/ReqDetailsMongo', array('as'=>"ReqDetailsMongo",'uses'=> 'MongoController@callDetailReport'));
Route::get('/ScriptToInsert', array('as'=>"ScriptToInsert",'uses'=> 'MongoController@scriptToInsertCallDetail'));
Route::get('/CreateIndexes', array('as'=>"CreateIndexes",'uses'=> 'MongoController@createIndexes'));
Route::get('/DetailCallRepDownload', array('as'=>"DetailCallRepDownload",'uses'=> 'MongoController@callDetailReportDownload'));
Route::get('/TcHistory', array('as'=>"TcHistory",'uses'=> 'MongoController@getTcHistory'));


