<?php

Class indexController Extends baseController {
  
    public function index() {
        $this->registry->template->page_title = 'Homepage';
        
        $content[] = 'Default content';
        
        $this->registry->template->page_content = implode($content);        
        
        /*** load the index template ***/
        $this->registry->template->show('index');
    }
}

?>
