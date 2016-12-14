<?php
/**
 * Description of Console
 *
 * @author wlcd
 */
class Console {
    
    private $_active;
    private $_messages = array();

    private static $_instance = Null;

    public static function get($active)
    {
        if (Null == self::$_instance)
        {
            self::$_instance = new Console($active);
        }

        return self::$_instance;
    }

    private function __construct($active)
    {
        $this->_active = $active;
    }

    //destructeur
    public function __destruct()
    {
        $this->display();
    }

    //message
    public function message($text)
    {
        if($this->_active)
        //push messages into the array
        array_unshift($this->_messages, $text);
    }

    //display
    public function display()
    {
        if($this->_active)
        {
            echo '<div id="console">
                <span style="font-weight:bold;">Console:</span><hr/><div style="overflow: auto; height : 210px; font-size : 14px; font-weight: bold;">';
            echo '$_SESSION = ';
            print_r($_SESSION);
            
            echo "<br />";
            
            echo '$_SERVER[\'REQUEST_URI\'] = ';
            print_r($_SERVER['REQUEST_URI']);
            
            echo "<br />";
            
            foreach($this->_messages as $message)
            {
                echo $message.'<br />';
            }
            
            echo '</div></div>';
        }
    }
}
?>
