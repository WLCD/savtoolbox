<?php

Class addController Extends baseController {
  
    public function index() {
        
        switch($_GET['type'])
        {
            case 'company':
                $content[] = $this->addCompany();
                break;
            case 'product':
                $content[] = $this->addProduct();
                break;
            case 'customer':
                $content[] = $this->addCustomer();
                break;
            case 'case':
                $content[] = $this->addCase();
                break;
            case 'invoice':
                $content[] = $this->addInvoice();
                break;
           
            default:
                $content[] = "You must enter a type in the url !";
                break;
        }
        
        $this->registry->template->page_title = 'Add '.ucfirst($_GET['type']);
        
        
        $this->registry->template->page_content = implode($content);
        
        /*** load the index template ***/
        $this->registry->template->show('admin');
    }
    
    public function addCompany()
    {
        if(!isset($_POST['name']))
        {
            $company_content[] = '
                <h1>Add a Company</h1>
                <form action="?rt=add&type=company" method="post" id="company_add">        
                    
                    <div id="add_company_left">
                        <label>Name</label>
                        <input name="name" type="text" class="required" title="Name. This is a required field" /><br />

                        <label>Mail</label>
                        <input name="mail" type="text" class="required" title="Mail. This is a required field" /><br />

                        <label>Phone</label>
                        <input name="phone" type="text" class="required" title="Phone. This is a required field" /><br />

                        <label>Type</label>
                            <select name="type" class="required" title="Type. This is a required field">
                                    <option value="Retailer">Retailer</option>
                                    <option value="Reseller">Reseller</option>
                            </select>
                    </div>
                    
                    <div id="add_company_right">
                        <label>Address</label>
                        <input name="address" type="text" class="required" title="Address. This is a required field" /><br />

                        <label>Zipcode</label>
                        <input name="zipcode" type="text" class="required" title="Zipcode. This is a required field" /><br />

                        <label>City</label>
                        <input name="city" type="text" class="required" title="City. This is a required field" /><br />
                    </div>
                <br />    
                <input type="submit" value="Submit" id="submit" />
            </form>
            ';
        }        
        
        else
        {
            $company = array(
                'name' => $_POST['name'],
                'mail' => $_POST['mail'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'type' => $_POST['type'],
                'city' => $_POST['city'],
                'zipcode' => $_POST['zipcode']
            );
            
            $this->registry->company->add($company);
            
            $companyObj = $this->registry->company->getLast();
            
            $company_content[] = "Company has been added !<br />
                <a href='?rt=add&type=company'>Add</a> a new one ?<br />
                or maybe you want to <a href='?rt=company&id=".$companyObj->id()."'>add some Employees to it ?</a>";
            $_POST = NULL;
        }
        
        return implode($company_content);
    }
    
    public function addCustomer()
    {
        if(!isset ($_POST['name']))
        {
            $people_content[] = '<h1>Add a Customer</h1>
                <form action="?rt=add&type=customer" method="post" id="people_add">        
                    
                    <div id="add_company_left">
                        <label>Name</label>
                        <input name="name" type="text" class="required" title="Name. This is a required field" /><br />

                        <label>Mail</label>
                        <input name="mail" type="text" class="required" title="Mail. This is a required field" /><br />

                        <label>Phone</label>
                        <input name="phone" type="text" class="required" title="Phone. This is a required field" /><br />
                    </div>
                    
                    <div id="add_company_right">
                        <label>Address</label>
                        <input name="address" type="text" class="required" title="Address. This is a required field" /><br />

                        <label>Zipcode</label>
                        <input name="zipcode" type="text" class="required" title="Zipcode. This is a required field" /><br />

                        <label>City</label>
                        <input name="city" type="text" class="required" title="City. This is a required field" /><br />
                        <input type="hidden" name="company" value="'.$_GET['companyid'].'" />
                    </div>
                <br />    
                <input type="submit" value="Submit" id="submit" />
            </form>
            ';
        }
        
        else
        {
            $people = array(
                'name' => $_POST['name'],
                'mail' => $_POST['mail'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'company' => $_POST['company'],
                'city' => $_POST['city'],
                'zipcode' => $_POST['zipcode']
            );
            
            $this->registry->customer->add($people);

            $people_content[] = "Person has been added !<br />
            Maybe you want to get back <a href='?rt=company&id=".$_POST['company']."'>to the company</a> where you came from ?";
        
            $_POST = NULL;
        }
        
        return implode($people_content);
    }
    
    public function addProduct()
    { 
        if(!isset ($_POST['name']))
        {
            $product_content[] = '<h1>Add a Product</h1>
                <form action="?rt=add&type=product" method="post" id="product_add">        
                    
                    <div id="add_product_left">
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
            
            $this->registry->product->add($product);

            $product_content[] = "Product has been added !<br />
            Maybe you want to get back <a href='?rt=products'>to products</a> or <a href='?rt=add&type=product'>add some more</a> products ?";
        
            $_POST = NULL;
        }
        
        return implode($product_content);
    }
    
    public function addCase()
    {
        if(!isset ($_POST['case']))
        {
            //this variable must = $_SESSION
            $user = array('id' => 1);
            
            $case_content[] = '<h1>Create a case</h1>
                <form action="?rt=add&type=case" method="post" id="case_add">        
                    
                    <div id="add_case_left">
                        <select name="customer" id="customer">
                        <option value="#">-select-</option>';
            
            $customer_list = $this->registry->customer->getList();
            
            foreach($customer_list as $customer)
            {
                $case_content[] = "<option value='".$customer->id()."'>".$customer->name()."</option>\n";
            }
            
            $case_content[] = '
                        </select>
                        <select name="recipient" id="recipient">';
            
            $case_content[] = '
                        </select><span id="result">&nbsp;</span><br />
                        <input type="hidden" name="sender" value="'.$user['id'].'" />';

            $case_content[] = '                
                        
                    </div>
                <input type="submit" value="Submit" id="submit" />
            </form>
            ';
        }
        
        else
        {
            $products_list = $this->registry->product->setProductList($_POST['products']);

            $duration = $_POST['duration_number'].' '.$_POST['duration_type'];
            
            $delivery = array(
                'company' => $_POST['company'],
                'recipient' => $_POST['recipient'],
                'sender' => $_POST['sender'],
                'product_list' => $products_list,
                'duration' => $duration
            );
            
            $this->registry->delivery->add($delivery);

            $case_content[] = "Delivery has been created !<br />
            Maybe you want to get back <a href='?rt=deliveries'>to deliveries</a> or go to <a href='?rt=add&type=delivery'>the delivery</a> you just created ?";
            
            $this->registry->product->setProductListDeliveryId($this->registry->delivery->getLastDelivery());
            
            $products = $this->registry->product->getProductsListFromDeliveryId($this->registry->delivery->getLastDelivery());
            
            $products_delivery = array();
            
            foreach($products as $product_item)
            {
                $products_delivery[] = $this->registry->product->get($product_item);
            }
            
            if($products_delivery)
            {
                foreach($products_delivery as $product)
                {
                    $product->setOwner($_POST['company']);
                    $product->setDelivery($this->registry->delivery->getLastDelivery());
                    $this->registry->product->update($product);
                }
            }
            
            $_POST = NULL;
        }
        
        return implode($case_content);
    }
    
    public function addInvoice()
    {
        if(!isset ($_POST['services_list']))
        {
            
            $invoice_content[] = '<h1>Create an Invoice</h1>
                <form action="?rt=add&type=invoice" method="post" id="invoice_add">        
                    
                    <div id="add_invoice_left">
                        <select name="company" id="company">
                        <option value="#">-select-</option>';
            
            $company_list = $this->registry->company->getList();
            
            foreach($company_list as $company)
            {
                $invoice_content[] = "<option value='".$company->id()."'>".$company->name()."</option>\n";
            }
            
            $invoice_content[] = '</select>
                        <span id="result">&nbsp;</span><br />
                    </div>
                    <div id="add_invoice_right">
                        <span>Utilisez Ctrl+Clic pour sélectionner plusieurs services.</span><br />
                        <select name="services[]" multiple="multiple">';
            
            $services_list = $this->registry->service->getList();
            
            foreach($services_list as $service)
            {
                $invoice_content[] = "<option value='".$service->id()."'>".$service->content()."</option>\n";
            }
            
            $invoice_content[] = '                
                        </select>
                    </div>
                <input type="submit" value="Submit" id="submit" />
            </form>
            ';
        }
        
        else
        {
            $services_list = $this->registry->service->setServiceList($_POST['services']);
            
            $invoice = array(
                'company' => $_POST['company'],
                'services_list' => $services_list,
            );
            
            $this->registry->invoice->add($invoice);

            $invoice_content[] = "Invoice has been created !<br />
            Maybe you want to get back <a href='?rt=invoices'>to invoices</a> or create <a href='?rt=add&type=invoice'>another one</a>";
            
            $this->registry->service->setServiceListInvoiceId($this->registry->invoice->getLastInvoice());
            
            $services = $this->registry->service->getServicesListFromInvoiceId($this->registry->invoice->getLastInvoice());
            
            $services_invoice = array();
            
            foreach($services as $service_item)
            {
                $services_invoice[] = $this->registry->service->get($service_item);
            }
            
            if($services_invoice)
            {
                foreach($services_invoice as $service)
                {
                    $service->setCompany($_POST['company']);
                    $service->setInvoice($this->registry->invoice->getLastInvoice());
                    $this->registry->service->update($service);
                }
            }
            
            $_POST = NULL;
        }
        
        return implode($invoice_content);
    }
}

?>
