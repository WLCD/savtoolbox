<?php
/**
 * Description of wToolTwitter
 *
 * @author wlcd
 */

class wToolTwitter {

    private $registry;
    
    function __construct($registry) {
        $this->registry = $registry;
    }

    public function twitterRedirect() {
        

        /* Build TwitterOAuth object with client credentials. */
        $connection = new TwitterOAuth($this->registry->settings->consumerkey, $this->registry->settings->consumersecret);
        $urlRedi = "http://twitter.aerialseed.com/callback.php";

        /* Get temporary credentials. */
        $request_token = $connection->getRequestToken($urlRedi);

        /* Save temporary credentials to session. */
        $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

        /* If last connection failed don't display authorization link. */
        switch ($connection->http_code) {
          case 200:
            /* Build authorize URL and redirect user to Twitter. */
            $url = $connection->getAuthorizeURL($token);
            header('Location: ' . $url);
            break;
          default:
            /* Show notification if something went wrong. */
            echo 'Could not connect to Twitter. Refresh the page or try again later.';
        }
    }

    public function twitterCallback()
    {
        
        /* Start session and load lib */
       // session_start();

//        /* If the oauth_token is old redirect to the connect page. */
//        if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
//          $_SESSION['oauth_status'] = 'oldtoken';
//          header('Location: ./clearsessions.php');
//        }

        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $connection = new TwitterOAuth($this->registry->settings->consumerkey, $this->registry->settings->consumersecret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

        /* Request access tokens from twitter */
        $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

        /* Save the access tokens. Normally these would be saved in a database for future use. */
        $_SESSION['access_token'] = $access_token;
        // save access token to DB
        $token_oauth = $access_token['oauth_token'];
        $token_oauth_secret = $access_token['oauth_token_secret'];

        dc_dump($token_oauth, $token_oauth);
        dc_dump($token_oauth_secret, $token_oauth_secret);
        
        //!\\
        $monfichier = fopen('credentials.txt', 'r+');

        fputs($monfichier, "token oauth : $token_oauth \n"); // On écrit le nouveau nombre de pages vues
        fputs($monfichier, "token oauth secret : $token_oauth_secret \n"); // On écrit le nouveau nombre de pages vues

        fclose($monfichier);
        // $users->saveTwitterTokens($user, $token_oauth, $token_oauth_secret);

        /* Remove no longer needed request tokens */
        unset($_SESSION['oauth_token']);
        unset($_SESSION['oauth_token_secret']);

        /* If HTTP response is 200 continue otherwise send to connect page to retry */
        if (200 == $connection->http_code)
        {
          /* The user has been verified and the access tokens can be saved for future use */
          $_SESSION['status'] = 'verified';
          header('Location: ./index.php');
        }

        else
        {
          /* Save HTTP status for error dialog on connnect page.*/
          header('Location: ./clearsessions.php');
        }
    }

    public function instanciateTwitterConnection($access_token)
    {
        /* Create a TwitterOauth object with consumer/user tokens. */
        $connection = new TwitterOAuth($this->registry->settings->consumerkey, $this->registry->settings->consumersecret, $access_token['tw_oauth_token'], $access_token['tw_oauth_secret']);

        return $connection;
    }

    public function getUserName($access_token)
    {
        $username = $this->getUserInfo($access_token);
        return $username->screen_name;
    }

    /*get user info in a table */
    public function getUserInfo($access_token)
    {
        return $user_info = $this->instanciateTwitterConnection($access_token)->get('account/verify_credentials');
    }

    public function postStatus($access_token, $message)
    {
        $this->instanciateTwitterConnection($access_token)->post('statuses/update', array('status' => $message));
    }
}
?>
