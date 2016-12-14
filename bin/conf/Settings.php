<?php

class Settings
{
    private static $_instance = Null;

    public static function get()
    {
        if (Null == self::$_instance)
        {
            self::$_instance = new Settings();
        }

        return self::$_instance;
    }

    private function __construct()
    {
    }

    // Console configuration
    public $consoleActive = True;

    // header de toutes les pages
    public $html_doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
    public $language = 'fr';
    public $title = 'SAVToolBox';

    //configuration du style

    public $style_path = 'style';
    public $style_name = 'default';

    //configuration SQL
    public $sql_host = 'localhost';
    public $sql_user = 'sav_db';
    public $sql_pass = 'canari';
    public $sql_dbname = 'savdb';

    //inclusion JS

    public $js_path = 'js/';
    public $js_libs = array (
                            'jquery.js',
                            'mktoolbox.js',
                            'geturlparam.js',
                            'highcharts.js'
                            );

    //répertoire d'upload pour les fichiers
    public $up_path = 'uploads/';
    
    //éléments du menu de navigation
    public $menu = array('Index', 'Cases', 'Customers', 'Clients');

    public $sessionDataClassName    = "SavSession";

    //twitter oauth credentials
    public $consumerkey = 'DPTKVMIQMoVMPUnnrEpCKQ';
    public $consumersecret = 'qzsdkjJnCBOCYAKXAsuM0GBYYAEjYIPRfD9164PPw';

    //facebook oauth credentials
    public $fbappid = '131771796909812';
    public $fbsecretkey = 'e23b74656e72e42f43fe78c60050bd59';
    public $fbcallbackurl = 'fb.aerialseed.com/callback.php';
}

?>
