<?php
    
    include('../framework/registry.class.php');
    include('Customer/CustomerManager.php');
    include('Customer/Customer.php');
    include('../model/db_silent.class.php');
    include('conf/Settings.php');
        
    /*** a new registry object ***/
    $registry = new registry;
    
    /*** create the settings registry object ***/
    $registry->settings = Settings::get();
    
    /*** create the database registry object ***/
    $registry->db = db_silent::get($registry->settings);
    
    /*** a new SQL object for the website ***/ 
    $registry->people = new CustomerManager($registry);
    
    $employees_list = $registry->people->getEmployeesList($_POST['id']);

    foreach($employees_list as $employee)
    {
        
            echo "<option value='".$employee->id()."'>".$employee->name()."</option>\n";
        
    }
?>
