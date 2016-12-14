<?php

Class profileController Extends baseController {
  
    public function index() {
        $this->registry->template->page_title = 'Profil';
        $fb = $this->registry->fb;
        
        $user = $this->registry->users->get($_GET['name']);
        
        if($_SESSION['username'] != $user->name() )
        {
            //affichage public du profile utilisateur
            $content[] = "Vous consultez le profil de ".$user->name();
        }
        
        else
        {
            //affichage du profil privé de l'utilisateur, pour procéder à des modifs par exemple
            $content[] = $user->name();
            
            if($user->fb_connect() == 1)
            {
                $content[] = "<br />Voici votre token facebook:".$user->fb_token();
            }
            
            else
            {
                $content[] = '<br />Se connecter avec FB';
            }
            
        }
        
        $this->registry->template->page_content = implode($content);
        
        /*** load the index template ***/
        $this->registry->template->show('index');
    }
}

?>
