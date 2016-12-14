<?php

class db {

    /*** Declare instance ***/
    private static $instance = NULL;
    private $conf;
    private $console;
    private $sql_handler;
    private $sql_dbhandler;

    //constructor
    private function __construct($config, $console)
    {
        $this->conf = $config;
        $this->console = $console;
        $this->setHandlers();
    }

    public function  __destruct()
    {
        if ($this->sql_handler) mysqli_close($this->sql_handler);
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
    public static function get($config, $console) {

    if (!self::$instance)
        {
            self::$instance = new db($config, $console);
        }
    return self::$instance;
    }
    
    public function setHandlers()
    {
        $this->sql_handler = mysqli_connect($this->conf->sql_host, $this->conf->sql_user, $this->conf->sql_pass, $this->conf->sql_dbname );
        if (!$this->sql_handler) die('Could not connect: ' . mysqli_error());

        return $this->sql_handler;
    }
    
    /* sqlQuery()
     * SQL Query handler
     *
     * $sql_query = the preformated query from the proper function
     */
    public function query($sql_query)
    {
        $this->console->message($sql_query.'<br />');

        $query = mysqli_query($this->sql_handler, $sql_query);
        if(!$query)
            {
                $error = mysqli_errno($this->sql_handler);
                $this->console->message('<h2 style="color: red; font-weight : bold;">Query FAILED</h2>errno :'.$error.'<br />');
                exit();
            }
        else
            {
                $this->console->message('<h2 style="color: green; font-weight : bold;">Query SUCCESSFUL</h2><br />');
            }
            
        return $query;
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
