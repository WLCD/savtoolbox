<?php
/**
 * Description of caseController
 *
 * @author wlcd
 */
class caseController extends baseController {
    public function index() {
        $this->registry->template->page_title = 'case';
        
        if(isset ($_GET['id']))
        {
            $case = $this->registry->casex->get((int) $_GET['id']);
            $client = $this->registry->company->get($case->idcustomer());
            
            print_r($case->collect());

            $content[] = "<div id=\"case\"><!-- Start of cases DIV -->
                <h1>".$case->type().$this->registry->casex->getFormattedDate($case->id())."-".$case->ref()."</h1>
                <table id=\"case_info\">
                    <tr class='light'>
                        <td>Client Name</td><td><a href=\"?rt=company&id=".$client->id()."\">".$client->name()."</a></td>
                    </tr>
                    <tr class='dark'>
                        <td>Return Address</td><td>".$client->address()."</td>
                    </tr>
                    <tr class='light'>
                        <td>SN</td><td>".$case->sn()."</a></td>
                    </tr>
                    <tr class='dark'>
                        <td>Description</td><td>".$case->info()."</td>
                    </tr>
                    <tr class='light'>
                        <td>Email</td><td><a href='mailto:".NULL."'>".NULL."</a></td>
                    </tr>
                    <tr class='dark'>
                        <td>Collect</td><td>".$case->collect()."</td>
                    </tr>
                    <tr class='dark'>
                        <td>Date Closed</td><td>".$case->case_closed()."</td>
                    ";
            
            $content[] = "</td>
                    </tr>
                </table>
                <a href='?rt=edit&type=case&id=".$_GET['id']."'>Edit Case</a><br />
            </div>  <!-- End of cases DIV -->";
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
