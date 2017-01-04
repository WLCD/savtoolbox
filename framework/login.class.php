<?php
/**
 * Description of menu
 *
 * @author wlcd
 */
class login {
    private $registry;
    
    public function __construct($registry) {
        $this->registry = $registry;
    }
    
    public function getLogin()
    {
        if (isset($_SESSION['connect']))//On vérifie que le variable existe.
        {
                $connect=$_SESSION['connect'];//On récupère la valeur de la variable de session.
        }
        
        else
        {
                $connect= NULL;//Si $_SESSION['connect'] n'existe pas, on donne la valeur "0".
        }
        
        if($connect != NULL)
        {
            $login[] = "<a href='?rt=profile&name=".$_SESSION['username']."'>".$_SESSION['username']."</a><a href='?rt=logout'><img src='bin/style/default/css/img/logout.png' alt='Déconnexion' />Logout</a>";
        }
        
        else
        {       
            //$_POST['callurl'] = $_SERVER['REQUEST_URI'];
            
            $login[] = "\n\t\t<form action='?rt=login' method='post'> <!-- Start of Main Menu -->\n
            <input type='text' name='username' value='Login'/>
            <input type='password' name='userpassword' value='Password'/>
            <input type='submit' value='login'/>";               
            $login[] = "\t\t</form> <!-- End of Main Menu -->\n";
        }
        return implode($login);
    }
}

?>
