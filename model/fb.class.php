<?php

class fb {

    /*** Declare instance ***/
    private static $instance = NULL;
    private $conf;
    private $console;
    private $fb;

    //constructor
    private function __construct($config, $console)
    {
        $this->conf = $config;
        $this->console = $console;
        $this->fb = $this->getFb($config, $console);
    }

    public function  __destruct()
    {
        
    }
    
    /**
    *
    * Return FB URL for connection
    *
    *
    * @access public
    *
    */
    public static function get($config, $console) {

    if (!self::$instance)
        {
            self::$instance = new fb($config, $console);
        }
    return self::$instance;
    }
    
    public function getFb($conf, $console) {
        $facebook = new Facebook(array(
        'appId'  => $conf->fbappid,
        'secret' => $conf->fbsecretkey,
        'cookie' => true
        ));
        
        $console->message("FB Success!");
        
        return $facebook;
    }
    
    public function setGraphUrl($conf, $console)
    {
        $graph_url = 'https://www.facebook.com/dialog/oauth?client_id='.$conf->fbappid.'&redirect_uri='.$conf->fbcallbackurl.'&scope=email,user_likes,publish_stream';
        
        $console->message("Construction de l'URL graph");
        
        return $graph_url;
    }
    
    public function getGraphUrl()
    {
        return $this->setGraphUrl($this->conf, $this->console);
    }
    /**
    *
    * Like the constructor, we make __clone private
    * so nobody can clone the instance
    *
    */
    private function __clone(){
    }
    
} /*** end of class ***/

?>
