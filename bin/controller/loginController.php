<?php

Class loginController Extends baseController {
    
    protected $registry;
    private $db; // SQL instance
    
    public function __construct($registry)
    {
        $this->registry = $registry;
        $this->setDb($this->registry->db);
    }
            
    public function index() {
        $this->registry->template->page_title = 'Login';
                
        if($this->registry->users->exists($_POST['username']))
        {
            $user = $this->registry->users->get($_POST['username']);
            
            if($user->password() == $_POST['userpassword'])
            {
                $_SESSION['connect'] = 1;
                $_SESSION['userid'] = $user->id();
                $_SESSION['username'] = $user->name();
                $_SESSION['permissions'] = $user->permissions();
                $_SESSION['theme'] = $user->theme();
                header("refresh: 2; ?rt=index");
                $content[] = "Thanks ".$user->name().", you just logged in !";
            }    
        }
        
        else
        {
            $content[] = "Mauvais nom d'utilisateur ou mot de passe";
        }
        //choper l'url de la page appellante pour rediriger vers celle-ci ( probablement dans $_POST['callurl'] )
        //header("refresh: 5; ?rt=index");
                
        $this->registry->template->page_content = implode($content);
        
        /*** load the index template ***/
        $this->registry->template->show('index');
    }
    
    public function setDb($db)
    {
        $this->db = $db;
    }
}

?>
