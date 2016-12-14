<?php

Class logoutController Extends baseController {
  
    public function index() {
        $this->registry->template->page_title = 'Logout';
        
        $_SESSION = array();
        if (isset($_COOKIE[session_name()]))
        {setcookie(session_name(),'',time()-4200,'/');}

        session_destroy();
        
        header("refresh: 2; ?rt=index");
        
        $this->registry->template->page_content = 'You just logged out, you are redirected to Index !';
                
        //$this->registry->template->page_content = implode($content);
        
        /*** load the index template ***/
        $this->registry->template->show('index');
    }
}

?>
