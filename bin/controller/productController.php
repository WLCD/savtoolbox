<?php
/**
 * Description of ProductController
 *
 * @author wlcd
 */
class productController extends baseController {
    public function index() {
        $this->registry->template->page_title = 'Products Management';
        
        
        //forcer la conversion en int ou ProductManger->get() part sur le else
        $product = $this->registry->product->get((int) $_GET['id']);
        $owner = $this->registry->company->get($product->owner());
        $delivery_note = $this->registry->delivery->get((int) $product->delivery());
        $notes_list = $this->registry->delivery->getFromIdArray($this->registry->product->getDeliveryNotes((int) $product->id()));
        $shippings = $this->registry->product->getShippings($product->id());
        
        $content[] = "<div id=\"product\"><!-- Start of products DIV -->
            <h1>".$product->name()."</h1>
            <table id=\"product_info\">
                <tr class='light'>
                    <td>SN</td><td>".$product->SN()."</td>
                </tr>
                <tr class='dark'>
                    <td>Current Owner</td><td><a href=\"?rt=company&id=".$owner->id()."\">".$owner->name()."</a></td>
                </tr>
                <tr class='light'>
                    <td>Last Delivery Note</td><td><a href=\"?rt=delivery&id=".$delivery_note->id()."\">".$delivery_note->ref()."</td>
                </tr>
                <tr class='dark'>
                    <td>Last Shipping Date</td><td>".$delivery_note->date()."</td>
                </tr>
                <tr class='light'>
                    <td>Last Return Date</td><td>".$product->returnDate()."</td>
                </tr>
                <tr class='dark'>
                    <td>Number of Shippings</td><td>".$shippings."</td>
                </tr>
                <tr class='light'>
                    <td>Delivery Notes</td><td>";
                
        foreach($notes_list as $note)
        {
            $content[] = "<a href='?rt=delivery&id=".$note->id()."'>".$note->ref()."</a><br />";
        }
        
        $content[] = "</td>
                </tr>
            </table>";
        
        if($owner->id() != 1)
        {
            $content[] = "<a href='?rt=return&id=".$product->id()."'>Return Product</a>";
        }
        
        $content[] = "</div>  <!-- End of products DIV -->";
        
        $this->registry->template->page_content = implode($content);
               
        /*** load the index template ***/
        $this->registry->template->show('user');
    }    
}

?>
