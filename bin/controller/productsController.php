<?php
/**
 * Description of productsController
 *
 * @author wlcd
 */
class productsController extends baseController {
    public function index() {
        $this->registry->template->page_title = 'Products Management';
        
        $last_sent = $this->registry->product->get((int) $this->registry->product->getLastSent());
        $last_sender = $this->registry->people->get((int) $this->registry->people->getLastSender());
        $last_client = $this->registry->company->get($this->registry->company->getLastClient());
        
        $content[] = "<div id=\"products\"><!-- Start of products DIV -->
            <h1>Products Management - Home</h1><br />
            <a href='?rt=add&type=product'>Add a new product</a>
            <table id=\"products_summary\">
                <tr id='summary_header'>    
                    <th colspan=\"2\">Summary</th>
                </tr>
                <tr>
                    <td>Available Products</td><td>".$this->registry->product->countInside()."</td>
                </tr>
                <tr>
                    <td>Sent Products</td><td>".$this->registry->product->countOutside()."</td>
                </tr>
                <tr>
                    <td>Last Product Sent</td><td><a href=\"product/=".$last_sent->id()."\">".$last_sent->name()."</a></td>
                </tr>
                <tr>
                    <td>Last Sender</td><td><a href=\"?rt=people&id=".$last_sender->id()."\">".$last_sender->name()."</td>
                </tr>
                <tr>
                    <td>Last Client</td><td><a href=\"?rt=company&id=".$last_client->id()."\">".$last_client->name()."</td>
                </tr>
            </table>\n";
        
        $content[] = "\t\t<table id='products_sent'>
                    <tr id='sent_header'>
                        <th>Sent Products</th>
                    </tr>\n";
        
        $sent_list = $this->registry->product->getSentList();
        
        if(!empty($sent_list))
        {
            foreach($sent_list as $product)
            {
                foreach($product as $item)
                {
                    $content[] = "\t\t\t<tr>
                                <td><a href='?rt=product&id=".$item['id']."'>".$item['name']."</a></td>
                            </tr>\n";
                }

            }
        }
        
        else
        {
            $content[] = "\t\t\t<tr>
                                <td>All products are returned</td>
                            </tr>\n";
        }
        
        $content[] = "\t</table>\n";
        
        $content[] = "<table id='products_available'>
            <tr id='available_header'>
                <th>Available Products</th>
            </tr>";
        
        $available_list = $this->registry->product->getAvailableList();
        
        if(is_array($available_list))
        {
            foreach($available_list as $available)
            {
                foreach($available as $prod)
                {
                    $content[] = "<tr><td><a href='?rt=product&id=".$prod['id']."'>".$prod['name']."</a></td></tr>";
                }

            }
        }
              
        else
        {
            $content[] = "<tr><td>$available_list</td></tr>";
        }
        
        $content[] = "</table>";
        
        $content[] = "</div>  <!-- End of products DIV -->";
        
        $this->registry->template->page_content = implode($content);
               
        /*** load the index template ***/
        $this->registry->template->show('user');
    }
}

?>
