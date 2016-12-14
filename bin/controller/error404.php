<?php

Class error404Controller Extends baseController {

public function index() 
{
        $this->registry->template->page_title = '404';
        
        //on écrase la valeur de $menu pour que le menu soit vide et donc, pas affiché
        $this->registry->template->menu = $this->registry->menu->genMenu(array(''));
        $this->registry->template->show('error404');
}


}
?>
