<?php

Class editController Extends baseController {
  
    public function index() {
        
        switch($_GET['type'])
        {
            case 'company':
                $content[] = $this->editCompany();
                break;
            case 'product':
                $content[] = $this->editProduct();
                break;
            case 'customer':
                $content[] = $this->editCustomer();
                break;
            case 'case':
                $content[] = $this->editCase();
                break;
            case 'invoice':
                $content[] = $this->editInvoice();
                break;
            default:
                $content[] = "You must enter a type in the url or the type you inputted is wrong !";
                break;
        }
        
        $this->registry->template->page_title = 'Edit '.ucfirst($_GET['type']);
        
        $this->registry->template->page_content = implode($content);
        
        /*** load the index template ***/
        $this->registry->template->show('user');
    }
    
    public function editCustomer()
    {       
        if(!isset($_POST['edit']))
        {
            $company = $this->registry->customer->get($_GET['id']);
                       
            $company_content[] = '
                <h1>Edit a Customer</h1>
                <form action="?rt=edit&type=company" method="post" id="company_edit">        
                    
                    <div id="edit_company_left">
                        <label>Name</label>
                        <input name="name" type="text" class="required" title="Name. This is a required field" value="'.$company->name().'" /><br />

                        <label>Mail</label>
                        <input name="mail" type="text" class="required" title="Mail. This is a required field" value="'.$company->mail().'" /><br />

                        <label>Phone</label>
                        <input name="phone" type="text" class="required" title="Phone. This is a required field" value="'.$company->phone().'" /><br />
                    </div>
                    
                    <div id="edit_company_right">
                        <label>Address</label>
                        <input name="address" type="text" class="required" title="Address. This is a required field" value="'.$company->address().'" /><br />

                        <label>Zipcode</label>
                        <input name="zipcode" type="text" class="required" title="Zipcode. This is a required field" value="'.$company->zipcode().'" /><br />

                        <label>City</label>
                        <input name="city" type="text" class="required" title="City. This is a required field" value="'.$company->city().'" /><br />
                        <input name="edit" type="hidden" value="'.$company->id().'" />
                        <label>Type</label>
                        <select name="type" class="required" title="Type. This is a required field">
                        <option value="end-user" selected>End-user</option>
                                <option value="vendor">Vendor</option>
                                <option value="retailer">Retailer</option>
                                <option value="reseller">Reseller</option>';
            
            
            $company_content[] ='</select>
                    </div>
                <br />    
                <input type="submit" value="Submit" id="submit" />
            </form>
            ';
        }        
        
        else
        {           
            $companyObj = $this->registry->customer->get($_POST['edit']);
            $companyObj->setName($_POST['name']);
            $companyObj->setMail($_POST['mail']);
            $companyObj->setPhone($_POST['phone']);
            $companyObj->setAddress($_POST['address']);
            $companyObj->setCity($_POST['city']);
            $companyObj->setZipcode($_POST['zipcode']);
            
            $this->registry->customer->update($companyObj);
            
            $company_content[] = "Company has been edited !<br />
                <a href='?rt=clients'>Get Back</a> to companies ?";
            $_POST = NULL;
        }
        
        return implode($company_content);
    }
    
    public function editProduct()
    { 
        if(!isset ($_POST['name']))
        {
            $product_content[] = '<h1>Edit a Product</h1>
                <form action="?rt=edit&type=product" method="post" id="product_edit">        
                    
                    <div id="edit_product_left">
                        <label>Name</label>
                        <input name="name" type="text" class="required" title="Name. This is a required field" /><br />

                        <label>EAN</label>
                        <input name="ean" type="text" class="required" title="EAN. This is a required field" /><br />

                        <label>SN</label>
                        <input name="sn" type="text" class="required" title="SN. This is a required field" /><br />
                    </div>    
                <input type="submit" value="Submit" id="submit" />
            </form>
            ';
        }
        
        else
        {
            $product = array(
                'name' => $_POST['name'],
                'ean' => $_POST['ean'],
                'sn' => $_POST['sn']
            );
            
            $this->registry->product->update($product);

            $product_content[] = "Product has been edited !<br />
            Maybe you want to get back <a href='?rt=products'>to products</a> or <a href='?rt=edit&type=product'>edit some more</a> products ?";
        
            $_POST = NULL;
        }
        
        return implode($product_content);
    }
    
    public function editCase()
    {

        $case = $this->registry->casex->get(filter_input(INPUT_GET, 'id'));
            
        /* Vérification de la valeur de l'enlèvement */
            
            //print_r($case);
            if($case->collect() == 1)
            {
                $is_checked = " checked";
            }
            
            else
            {
                $is_checked = "";
            }
        
        if(!isset($_GET['update']))
        {
            // début du formulaire
            $case_content[] = '<h1>Edit '.$case->type().$this->registry->casex->getFormattedDate($case->id())."-".$case->ref().'</h1>
                <form action="?rt=edit&type=case&id='.$case->id().'&update=yes" method="post" id="case_edit">        

                    <div id="edit_case_left">
                        <select name="type" id="casetype">
                            <option value="RMA">RMA</option>
                            <option value="DOA">DOA</option>
                        </select>
                        <input type="text" name="casedate" value="'.$case->date().'"/><br />
                        <label for="customer">Customer</label>
                        <select name="customer" id="customer">
                            <option value="#">-select-</option>';

            $company_list = $this->registry->customer->getList();

            foreach($company_list as $company)
            {
                $case_content[] = "<option value='".$company->id()."'>".$company->name()."</option>\n";
            }

            $case_content[] = '
                        </select>
                        <select name="recipient" id="recipient">';

            $case_content[] = '
                        </select><span id="result">&nbsp;</span><br />
                        <input type="hidden" name="typer" value="'.$case->type().'" />
                        <label for="SN">S/N</label>
                        <input type="text" name="sn" value="'.$case->sn().'"/><br />
                        <label for="desc">Description</label>
                        <input type="textarea" name="desc" value="'.$case->info().'"/><br />
                        <input type="text" name="ref" value="'.$case->ref().'"/><br />
                        <label for="collect">Collect ?</label>
                        <input type="checkbox" name="collect" value="1"'.$is_checked.'><br />
                        <label for="case_closed">Closed Date : </label>
                        <input type="text" name="case_closed" value="'.$case->case_closed().'">
                    '."\n";

            $case_content[] = '
                    </div>
                <input type="submit" value="Submit" id="submit" />
            </form>
            ';
        }
        
        else {
            
            if(null !== filter_input(INPUT_POST,'collect'))
            {
                $collect = 1;
            }
                
            else 
            {
                $collect = 0;
            }           
            
            $casex = array(
                'id' => $case->id(),
                'idcustomer' => filter_input(INPUT_POST,'customer'),
                'type' => filter_input(INPUT_POST,'type'),
                'sn' => filter_input(INPUT_POST,'sn'),
                'info' => filter_input(INPUT_POST,'desc'),
                'ref' => filter_input(INPUT_POST,'ref'),
                'collect' => $collect,
                'case_closed' => filter_input(INPUT_POST,'case_closed')
            );
            
            $this->registry->casex->update($casex);

            $case_content[] = "Case has been updated !<br />
            Maybe you want to get back <a href='?rt=cases'>to cases</a> or go to <a href='?rt=edit&type=case&id=".$case->id()."'>the case</a> you just created ?";
        }

        //$_POST = NULL;
        
        return implode($case_content);
    }
    
    public function editInvoice()
    {
        if(!isset($_POST['edit']))
        {
            $invoice = $this->registry->invoice->get($_GET['id']);
            
            $company = $this->registry->customer->get($invoice->company());
                       
            $invoice_content[] = '
                <h1>Edit Invoice : '.$invoice->ref().'</h1>
                <form action="?rt=edit&type=invoice" method="post" id="invoice_edit">        
                    
                    <div id="edit_invoice_left">
                        <label>Date</label>
                        <input name="date" type="text" class="required" title="Date. This is a required field" value="'.$invoice->date().'" /><br />
                        <label>Client</label>
                        <select name="company" class="required" title="Company. This is a required field">';
            
            $company_list = $this->registry->customer->getList();
        
            foreach($company_list as $company_item)
            {
                if($company_item->id() == $invoice->company())
                {
                    $invoice_content[] = "<option value='".$company_item->id()."' selected>".$company_item->name()."</option>\n";
                }
                
                else
                {
                    $invoice_content[] = "<option value='".$company_item->id()."'>".$company_item->name()."</option>\n";
                }
            }
            
            $invoice_content[] ='</select>
                    </div>
                <br />    
                <input type="submit" value="Submit" id="submit" />
            </form><br />
            ';
        }
        
        else
        {
            $services_list = $this->registry->service->setServiceList($_POST['services']);

            $invoice = array(
                'company' => $_POST['company'],
                'date' => $_POST['date'],
                'services_list' => $services_list
            );
            
            $this->registry->invoice->update($invoice);

            $invoice_content[] = "Invoice has been edited !<br />
            Maybe you want to get back <a href='?rt=invoices'>to deliveries</a> or go to <a href='?rt=edit&type=invoice'>the invoice</a> you just created ?";
            
            $this->registry->service->setServiceListInvoiceId($this->registry->invoice->getLastInvoice());
            
            $services = $this->registry->service->getServicesListFromInvoiceId($this->registry->invoice->getLastInvoice());
            
            $services_invoice = array();
            
            foreach($services as $service)
            {
                $service_invoice[] = $this->registry->service->get($service);
            }
            
            if($service_invoice)
            {
                foreach($service_invoice as $service_item)
                {
                    $service_item->setOwner($_POST['company']);
                    $service_item->setDelivery($this->registry->Invoice->getLastInvoice());
                    $this->registry->product->update($service_item);
                }
            }
            
            $_POST = NULL;
        }
        
        return implode($invoice_content);
    }
}

?>
