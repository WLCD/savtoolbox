<?php

class db_silent {

    /*** Declare instance ***/
    private static $instance = NULL;
    private $conf;
    private $sql_handler;
    private $sql_dbhandler;

    //constructor
    private function __construct($config)
    {
        $this->setConfig($config);
        $this->setHandlers();
    }

    public function  __destruct()
    {
        if ($this->sql_handler) mysql_close($this->sql_handler);
    }
    
    /**
    *
    * Return DB instance or create intitial connection
    *
    * @return object (PDO)
    *
    * @access public
    *
    */
    public static function get($config) {

    if (!self::$instance)
        {
            self::$instance = new db_silent($config);
        }
    return self::$instance;
    }
    
    public function setHandlers()
    {
        $this->sql_handler = mysql_connect($this->conf->sql_host, $this->conf->sql_user, $this->conf->sql_pass);
        if (!$this->sql_handler) die('Could not connect: ' . mysql_error());

        return $this->sql_dbhandler = mysql_select_db($this->conf->sql_dbname);
    }
    
    /* sqlQuery()
     * SQL Query handler
     *
     * $sql_query = the preformated query from the proper function
     */
    public function query($sql_query)
    {
        $query = mysql_query($sql_query, $this->sql_handler);
        if(!$query)
            {
                $error = mysql_errno();
                
                exit();
            }
            
        return $query;
    }
    
    public function setConfig($config)
    {
        $this->conf = $config;
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
