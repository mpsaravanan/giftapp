<?php
//API ENDPOINTS
$devEndpoint = "http://192.168.124.53:9000/";
$prodEndpoint = "http://172.16.40.54:9001/";
//$prodEndpoint = "http://127.0.0.1:9001/";

//TELEPHONY ENDPOINTS
$prodTelephony = "http://192.168.141.30/";
$devTelephony = "http://192.168.141.10/";

//TELEPHONY BANGALORE ENDPOINTS
$prodBangaloreTelephony = "http://192.168.141.10/";
$devdBangaloreTelephony = "http://192.168.141.10/";

//TELEPHONY DELHI ENDPOINTS
$prodDelhiTelephony = "http://192.168.141.10/";
$devDelhiTelephony = "http://192.168.141.10/";

//TELEPHONY MUMBAI ENDPOINTS
$prodMumbaiTelephony = "http://192.168.141.10/";
$devMumbaiTelephony = "http://192.168.141.10/";

//XPORA ENDPOINTS
$prodXpora = "http://172.16.31.128/";
$devXpora = "http://192.168.124.107/";

//MONGO ENDPOINTS
$devMongo = "192.168.124.33:27019";
$prodMongo = "172.16.36.56:27017";
$devMongoReplica = "rs0";
$prodMongoReplica = "prodReplica";


if ($app->environment('local', 'staging')) {
	$getRequirementId 			= $devEndpoint;
	$getMatchmakingId           = $devEndpoint;
    $getTelephony               = $devTelephony;
    $getBangaloreTelephony      = $devdBangaloreTelephony;
    $getDelhiTelephony          = $devDelhiTelephony;
    $getMumbaiTelephony         = $devMumbaiTelephony;    
    $getXpora                   = $devXpora;
    $getMongo                   = $devMongo;
    $mongoreplica               = $devMongoReplica;

    //PUSHER DEV DETAILS
    $app_id                     = "184571";
    $api_key                    = "4fa9e83244b0df66a057";
    $api_secret                 = "2ef260c75fde277dec6c";

    //SSO Detail
    $sso_enable                 = 0;
    $sso_client_code            = "quikrrealestatexpora";
    $sso_client_auth_key        = "pqNdWbvzUh6Zr9eT";
    $sso_client_enc_auth        = "fmOn3t2s0YX2irS695QVCA2ZbAw0GZTCi0sOc4cVWK8=";
    $sso_auth_api_url           = "http://192.168.124.123:13000/identity/v1/auth";
    $sso_token_api_url          = "http://192.168.124.123:13000/identity/v1/token";
}
if ($app->environment('production')) {
	$getRequirementId 			= $prodEndpoint;
	$getMatchmakingId           = $prodEndpoint;
    $getTelephony               = $prodTelephony;
    $getBangaloreTelephony      = $prodBangaloreTelephony;
    $getDelhiTelephony          = $prodDelhiTelephony;
    $getMumbaiTelephony         = $prodMumbaiTelephony;
    $getXpora                   = $prodXpora;
    $getMongo                   = $prodMongo;
    $mongoreplica               = $prodMongoReplica;

    //PUSHER PROD DETAILS
    $app_id                     = "184572";
    $api_key                    = "efbb477895cc9a43c152";
    $api_secret                 = "65e9e0aa56ed0161b4fa";

    //SSO Detail
    $sso_enable                 = 0;
    $sso_client_code            = "quikrrealestatexpora";
    $sso_client_auth_key        = "pqNdWbvzUh6Zr9eT";
    $sso_client_enc_auth        = "fmOn3t2s0YX2irS695QVCA2ZbAw0GZTCi0sOc4cVWK8=";
    $sso_auth_api_url           = "http://192.168.124.123:13000/identity/v1/auth";
    $sso_token_api_url          = "http://192.168.124.123:13000/identity/v1/token";
}
return [
	'GET_REQUIREMENT_ID' => $getRequirementId,
	'GET_MATCHMAKING_ID' => $getMatchmakingId,
    'TELEPHONY_ENDPOINT' => $getTelephony,
    'TELEPHONY_TELESALES_ENDPOINT' => $getBangaloreTelephony,
    'TELEPHONY_DELHI_ENDPOINT' => $getDelhiTelephony,    
    'TELEPHONY_MUMBAI_ENDPOINT' => $getMumbaiTelephony,
    'XPORA_ENDPOINT' => $getXpora,
    'PUSHER_APP_ID' => $app_id,
    'PUSHER_API_KEY' => $api_key,
    'PUSHER_API_SECRET' => $api_secret,
    'MONGO_ENDPOINT' => $getMongo,
    'MONGO_REPLICA'  => $mongoreplica,
    
    'SSO_INTEGRAION_ENABLE'=>$sso_enable,
    'SSO_SCSR_CLIENT_CODE'=>$sso_client_code,
    'SSO_SCSR_CLIENT_AUTH_KEY'=> $sso_client_auth_key,
    'SSO_SCSR_CLIENT_ENC_AUTH' => $sso_client_enc_auth,
    'SSO_AUTH_API_URL' => $sso_auth_api_url,
    'SSO_TOKEN_API_URL' => $sso_token_api_url,
  ];