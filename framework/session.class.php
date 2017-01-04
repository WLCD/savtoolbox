<?php
/* 
 * Session class
 * Handles all the Sessionwise vars ($_SESSION['$var'])
 */

Class session
{
    private static $_instance = Null;
    private static $_db; // SQL instance
    private $_conf;
    public static $session_time = 7200;//2 heures
    public $session = array();

    public static function get($conf, $db)
    {
        if (Null == self::$_instance)
        {
            self::$_instance = new session($conf, $db);
        }

        return self::$_instance;
    }

    private function __construct($conf, $db)
    {
        $this->_conf = $conf;
        self::$_db = $db; 
    }
    
    public static function open ()//pour l'ouverture
    {
        self::gc();//on appelle la fonction gc
    }

    public static function read ($sid)//lecture
    {
        $sid = mysql_real_escape_string($sid);
        $sql = "SELECT * FROM session
                        WHERE sess_id = '$sid' ";

        $query = self::$_db->query($sql) or die('Erreur de lecture ! : '.mysql_error());	
        $data = mysql_fetch_array($query);

        if(empty($data)) return FALSE;
        else return $data['sess_datas'];//on retourne la valeur de sess_datas
    }

    public static function write ($sid, $data)//écriture
    {
        $expire = intval(time() + self::$session_time);//calcul de l'expiration de la session
        $sess_data = serialize(mysqli_real_escape_string($data));//si on veut stocker du code sql 

        $sql = "SELECT COUNT(sess_id) AS total
                FROM session
                WHERE sess_id = '$sid' ";

        $query = self::$_db->query($sql) or exit(mysql_error());
        $return = mysqli_fetch_array($query);
        if($return['total'] == 0)//si la session n'existe pas encore
        {
                $sql = "INSERT INTO session
                        SET sess_datas = '$sess_data',
                            sess_expire ='$expire'"; //alors on la crée

        }
        else//sinon
        {
                $sql = "UPDATE session 
                        SET sess_datas = '$sess_data',
                        sess_expire = '$expire'
                        WHERE sess_id = '$sid' ";//on la modifie
        }		
        $query = self::$_db->query($sql) or exit(mysql_error());

        return $query;
    }
    
    public static function getSessionByUserId($id)
    {
        $sql = "SELECT sess_id
                FROM session
                WHERE userid = '$sid' ";

        $query = self::$_db->query($sql) or exit(mysql_error());
        return mysqli_fetch_assoc($query);
    }

    public static function close()//fermeture
    {
        mysql_close(self::$_db);//on ferme la bdd
    }

    public static function destroy ($sid)//destruction
    {
        $sql = "DELETE FROM session
                WHERE sess_id = '$sid' ";//on supprime la session de la bdd
        $query = self::$_db->query($sql) or exit(mysql_error());
        return $query;
    }

    public static function gc ()//nettoyage
    {
        $sql = "DELETE FROM session 
                        WHERE sess_expire < ".time(); //on supprime les vieilles sessions 

        $query = self::$_db->query($sql) or die('Erreur de lecture ! : '.mysql_error());

        return $query;
    }
}
?>
