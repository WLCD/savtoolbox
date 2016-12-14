<?php
/**
 * Description of ClientsController
 *
 * @author wlcd
 */
class clientsController extends baseController {
    public function index() {
        $this->registry->template->page_title = 'Clients Management';
        
        $clients_list = $this->registry->company->getList();
        
        $content[] = "<div id=\"clients\"><!-- Start of clients DIV -->
            <h1>Clients Management - Home</h1><br />
            <a href=\"?rt=add&type=company\">Ajouter un nouveau client</a>
            <table id=\"clients_summary\">
            <tr id='summary_header'>
                <th>Client Name</th><th>E</th>
            </tr>";
        
        $trcolor = 'light';
        foreach($clients_list as $client)
        {
            $content[] = "<tr class='".$trcolor."'>
                        <td><a href='?rt=company&id=".$client->id()."'>".$client->name()."</a></td>
                        <td><a href='?rt=edit&type=company&id=".$client->id()."'><img src='bin/style/default/css/img/edit.png' alt='' /></a></td>
                    </tr>";
            ($trcolor == 'dark') ? $trcolor = 'light' : $trcolor = 'dark';
        }
        
        $content[] = "</table>\n";
        
        $content[] = "<a href=\"?rt=add&type=company\">Ajouter un nouveau client</a>
            </div>  <!-- End of clients DIV -->";
        
        $this->registry->template->page_content = implode($content);
               
        /*** load the index template ***/
        $this->registry->template->show('admin');
    }
}

?>
