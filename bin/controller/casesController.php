<?php
/**
 * Description of casesController
 *
 * @author wlcd
 */
class casesController extends baseController {
    public function index() {
        $this->registry->template->page_title = 'Cases Management';
        
        $casexs_list = $this->registry->casex->getList();
        
        $content[] = "<div id=\"cases\"><!-- Start of cases DIV -->
            <h1>Cases Management - Home</h1><br />
            <a href=\"?rt=add&type=case\">Add a new case</a>
            <table id=\"cases_summary\">
            <tr id='summary_header'>
                <th>Case's Ref</th><th>E</th>
            </tr>";
        
        $trcolor = 'light';
        foreach($casexs_list as $casex)
        {
            
            
            $content[] = "<tr class='".$trcolor."'>
                        <td><a href='?rt=case&id=".$casex->id()."'>".$casex->type().$this->registry->casex->getFormattedDate($casex->id())."-".$casex->ref()."</a></td>
                        <td><a href='?rt=edit&type=case&id=".$casex->id()."'><img src='bin/style/default/css/img/edit.png' alt='' /></a></td>
                    </tr>";
            ($trcolor == 'dark') ? $trcolor = 'light' : $trcolor = 'dark';
        }
        
        $content[] = "</table>\n";
        
        $content[] = "<a href=\"?rt=add&type=case\">Add a new Case</a>
            </div>  <!-- End of files DIV -->";
        
        
        $this->registry->template->page_content = implode($content);
               
        /*** load the index template ***/
        $this->registry->template->show('user');
    }
}

?>
