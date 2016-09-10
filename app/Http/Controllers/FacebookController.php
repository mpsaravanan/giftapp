<?php
namespace App\Http\Controllers;
use Request;
//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;
class FacebookController extends Controller
{
    public function facebooklogin(){
        if (!session_id()) {
            session_start();
        }
        $app_id = "1734158036851945";
        $app_secret = "96c92ef7f319ddc0190b8aa412d760da";
        $my_url ="http://local.seqhack.com/FacebookUser";
        $code = '';
        /*if(!isset($_REQUEST["code"])) {
            $_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
            $dialog_url =
                "https://www.facebook.com/dialog/oauth?client_id=".$app_id
                ."&redirect_uri=".urlencode($my_url)
                ."&state=".$_SESSION['state'];

            echo $my_url.'<br/>';
            echo $dialog_url.'<br/>';
            echo("<script> top.location.href='" . $dialog_url . "'</script>");
        }*/

        $fb = new \Facebook\Facebook([
            'app_id' => '1734158036851945', // Replace {app-id} with your app id
            'app_secret' => '96c92ef7f319ddc0190b8aa412d760da',
            'default_graph_version' => 'v2.7',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('http://local.seqhack.com/FacebookUser', $permissions);

        echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
    }

    public function facebookuser(){
        if (!session_id()) {
            session_start();
        }
        // echo "Hello";
        $fb = new \Facebook\Facebook([
            'app_id' => '1734158036851945', // Replace {app-id} with your app id
            'app_secret' => '96c92ef7f319ddc0190b8aa412d760da',
            'default_graph_version' => 'v2.7',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $_SESSION['FBRLH_state']=$_GET['state'];
        try {
            $accessToken = $helper->getAccessToken();
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId('1734158036851945'); // Replace {app-id} with your app id
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
            }
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name', $accessToken->getValue());
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $user = $response->getGraphUser();

        // get list of friends' names
        try {
            $requestFriends = $fb->get('/me/taggable_friends?fields=name&limit=100', $accessToken->getValue());
            $friends = $requestFriends->getGraphEdge();
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        // if have more friends than 100 as we defined the limit above on line no. 68
        if ($fb->next($friends)) {
            $allFriends = array();
            $friendsArray = $friends->asArray();
            $allFriends = array_merge($friendsArray, $allFriends);
            while ($friends = $fb->next($friends)) {
                $friendsArray = $friends->asArray();
                $allFriends = array_merge($friendsArray, $allFriends);
            }
            foreach ($allFriends as $key) {
                echo $key['name'] . "<br>";
            }
            echo count($allFriends);
        } else {
            $allFriends = $friends->asArray();
            $totalFriends = count($allFriends);
            foreach ($allFriends as $key) {
                echo $key['name'] . "<br>";
            }
        }
    }
}