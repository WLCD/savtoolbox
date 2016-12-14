<?php
/**
 * Description of customerController
 *
 * @author wlcd
 */
class customerController extends baseController {
    public function index() {
        $this->registry->template->page_title = 'people';
        
        if(isset ($_GET['id']))
        {
            $person = $this->registry->customer->get((int) $_GET['id']);
            $company = $this->registry->company->get($person->company());
            
            /*$have_delivery = $this->registry->delivery->getLastDeliveryByRecipient($person->id());
            
            if($have_delivery != 0)
            {
                $delivery = $this->registry->delivery->get($have_delivery);
                $products = $this->registry->product->getProductsListFromDeliveryId($delivery->id());
            
                foreach($products as $product_item)
                {
                    $products_list[] = $this->registry->product->get((int)$product_item);
                }
            }
            
            $last_prod = $this->registry->delivery->getLastProductByOwner($company->id());*/
            $product = $this->registry->product->get((int)$last_prod);

            $content[] = "<div id=\"product\"><!-- Start of products DIV -->
                <h1>".$person->name()."</h1>
                <table id=\"product_info\">
                    <tr class='light'>
                        <td>Employee Of</td><td><a href=\"?rt=company&id=".$company->id()."\">".$company->name()."</a></td>
                    </tr>
                    <tr class='dark'>
                        <td>Address</td><td>".$person->address()."</td>
                    </tr>
                    <tr class='light'>
                        <td>City</td><td>".$person->city()."</a></td>
                    </tr>
                    <tr class='dark'>
                        <td>Zipcode</td><td>".$person->zipcode()."</td>
                    </tr>
                    <tr class='light'>
                        <td>Email</td><td><a href='mailto:".$person->mail()."'>".$person->mail()."</a></td>
                    </tr>
                    <tr class='dark'>
                        <td>Phone</td><td>".$person->phone()."</td>
                    </tr>
                    <tr class='light'>
                        <td>Last Product(s) Received</td><td>";
            if(!empty($products_list))
            {
                foreach($products_list as $product)
                {
                    $content[] = "<a href=\"?rt=product&id=".$product->id()."\">".$product->name()."</a><br />";
                }
            }
            
            $content[] = "</td>
                    </tr>
                </table>
                <a href='?rt=edit&type=customer&id=".$_GET['id']."'>Edit Contact</a><br />
            </div>  <!-- End of products DIV -->";
        }
        
        else
        {
            $content[] = "Vous devez formater votre URL en fournissant un ID !";
        }
        
        $this->registry->template->page_content = implode($content);
               
        /*** load the index template ***/
        $this->registry->template->show('user');
    }
}

?>
