<?php

Class returnController Extends baseController {
  
    public function index() {
        
        $product = $this->registry->product->get($_GET['id']);
        
        $product->setOwner(1);
        $product->setReturnDate(date('Y-m-d H:i:s'));
        
        $this->registry->product->update($product);
        
        $content[] = "<h1>Return a product</h1>
            <p>Product ".$product->name()." has been returned</p>
                <a href='?rt=products'>Get back to products</a> ";
        
        $this->registry->template->page_title = 'Return Product';
        
        $this->registry->template->page_content = implode($content);
        
        /*** load the index template ***/
        $this->registry->template->show('user');
    }
}

?>
