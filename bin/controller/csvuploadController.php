<?php

Class csvuploadController Extends baseController {
  
    public function index() {
        $this->registry->template->page_title = 'Upload';
        
        $files = array($_FILES['twitter'], $_FILES['facebook'], $_FILES['googleplus']);
        
        $this->process($files,$this->registry->settings->up_path);
        
        $content[] = 'content';
        
        $this->registry->template->page_content = implode($content);        
        
        /*** load the index template ***/
        $this->registry->template->show('index');
    }
    
    public function process($files, $up_path)
    {
        foreach($files as $file)
        {
            move_uploaded_file($file['name']['tmp_name'], $up_path);
        }
    }
}

?>
