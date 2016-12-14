<?php

Class csvController Extends baseController {
  
    public function index() {
        $this->registry->template->page_title = 'Upload CSV';
        
        $content[] = ''
                . '<form method="POST" action="?rt=csvupload" enctype="multipart/form-data">     
     TW : <input type="file" name="twitter"> <br />
     FB: <input type="file" name="facebook"> <br />
     G+ : <input type="file" name="googleplus"> <br />
     <input type="submit" name="envoyer" value="Envoyer les fichier"> <br />
</form>';
        
        $this->registry->template->page_content = implode($content);        
        
        /*** load the index template ***/
        $this->registry->template->show('index');
    }
}

?>
