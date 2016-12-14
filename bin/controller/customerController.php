<?php
/**
 * Description of companyController
 *
 * @author wlcd
 */
class customerController extends baseController {
    public function index() {
        
        if(isset ($_GET['id']))
        {
            $customer = $this->registry->customer->get((int) $_GET['id']);
            //$employees_list = $this->registry->customer->getEmployeesList($customer->id());
            
            $content[] = "<div id=\"customer\"><!-- Start of customer DIV -->
                <h1>".$customer->name()."</h1>
                <table id=\"customer_info\">
                    <tr class='light'>
                        <td>Address</td><td>".$customer->address()."</td>
                    </tr>
                    <tr class='dark'>
                        <td>City</td><td>".$customer->city()."</a></td>
                    </tr>
                    <tr class='light'>
                        <td>Zipcode</td><td>".$customer->zipcode()."</td>
                    </tr>
                    <tr class='dark'>
                        <td>Email</td><td><a href='mailto:".$customer->mail()."'>".$customer->mail()."</a></td>
                    </tr>
                    <tr class='light'>
                        <td>Phone</td><td>".$customer->phone()."</td>
                    </tr>
                </table>
            </div>  <!-- End of company DIV -->";
        }
        
        else
        {
            $content[] = "Vous devez formater votre URL en fournissant un ID !";
        }
        $this->registry->template->page_title = 'Customer: '.$customer->name();
        
        
        $this->registry->template->page_content = implode($content);
               
        /*** load the index template ***/
        $this->registry->template->show('admin');
    }
}

?>
