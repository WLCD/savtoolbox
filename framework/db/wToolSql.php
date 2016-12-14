<?php
class wToolSql
{
    public $sql_handler;
    public $sql_dbhandler;
    private $registry;
    
    //constructor
    public function __construct($registry)
    {
        $this->registry = $registry;
        
        $this->sql_handler = mysql_connect($this->registry->settings->sql_host, $this->registry->settings->sql_user, $this->registry->settings->sql_pass);
        if (!$this->sql_handler) die('Could not connect to server: ' . mysql_error());

        $this->sql_dbhandler = mysql_select_db($this->registry->settings->sql_dbname);
        if (!$this->sql_handler) die('Could not connect to db : ' . mysql_error());
    }

    public function  __destruct()
    {
        if ($this->sql_handler) mysql_close($this->sql_handler);
    }

    /* sqlQuery()
     * SQL Query handler
     *
     * $sql_query = the preformated query from the proper function
     */
    public function sqlQuery($sql_query)
    {
        $this->registry->console->message($sql_query.'<br />');

        $query = mysql_query($sql_query, $this->sql_handler);
        if(!$query)
            {
                $error = mysql_errno();
                $this->registry->console->message('<h2 style="color: red; font-weight : bold;">Query FAILED</h2>errno :'.$error.'<br />');
                exit();
            }
        else
            {
                $this->registry->console->message('<h2 style="color: green; font-weight : bold;">Query SUCCESSFUL</h2><br />');
            }

        return $query;
    }
}
?>
