<?php
/**
 * Description of customersController
 *
 * @author wlcd
 */
class customersController extends baseController {
    public function index() {
        $this->registry->template->page_title = 'Customers Management';
        
        $clients_list = $this->registry->customer->getList();
        
        $content[] = "<div id=\"customers\"><!-- Start of clients DIV -->
            <h1>Customers Management</h1><br />
            <a href=\"?rt=add&type=customer\">Ajouter un nouveau client</a>
            <table id=\"customers_summary\">
            <tr id='summary_header'>
                <th>Customer's Name</th><th>E</th>
            </tr>";
        
        $trcolor = 'light';
        foreach($clients_list as $client)
        {
            $content[] = "<tr class='".$trcolor."'>
                        <td><a href='?rt=customer&id=".$client->id()."'>".$client->name()."</a></td>
                        <td><a href='?rt=edit&type=customer&id=".$client->id()."'><img src='bin/style/default/css/img/edit.png' alt='' /></a></td>
                    </tr>";
            ($trcolor == 'dark') ? $trcolor = 'light' : $trcolor = 'dark';
        }
        
        $content[] = "</table>\n";
        
        $content[] = "<a href=\"?rt=add&type=customer\">Ajouter un nouveau client</a>
            </div>  <!-- End of clients DIV -->";
        
        $this->registry->template->page_content = implode($content);
               
        /*** load the index template ***/
        $this->registry->template->show('admin');
    }
}

?>
