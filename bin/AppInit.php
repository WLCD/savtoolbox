<?php

/*
 * Cette classe est destinée à charger les divers composants de l'application en elle même,
 * elle est appelée par l'init de la partie display du core, de cette manière,
 * le core et la partie dédiée de l'application sont totalement indépendants, ce
 * qui permet d'executer l'application à la fois en mode graphique et via une
 * tâche CRON en ne chargeant que les classes nécessaires.
 */

/**
 * Description of AppInit
 *
 * @author wlcd
 */

    include('conf/Settings.php');
   
    function __autoload($name)
    {
        if(preg_match('/(Manager)\z/', $name))
        {
            include(preg_replace('/(Manager)\z/', '', $name).'/'.$name.'.php');
        }
        
        else
        {
            include($name.'/'.$name.'.php');
        }
    }
    

    //Here we create the instances of the objects that we will need for the app

    /*** a new registry object ***/
    $registry = new registry;
    
    /*** create the settings registry object ***/
    $registry->settings = Settings::get();
       
    /*** create the console registry object ***/
    $registry->console = Console::get($registry->settings->consoleActive);
    
    /*** create the errors objects ***/
    $registry->errors = Errors::get($registry->console);
    
    /*** create the database registry object ***/
    $registry->db = db::get($registry->settings, $registry->console);
    
    /*** create the session object ***/
    $registry->session = session::get($registry->settings, $registry->db);
    
    /*** create the facebook registry object ***/
    //$registry->fb = fb::get($registry->settings, $registry->console);
    
    /*** create the pagination registry object ***/
    $registry->paginate = new Pagination();
    
    /*** a new SQL object for the website ***/ 
    $registry->customer = new CustomerManager($registry);
    
    /*** a new SQL object for the website ***/ 
    $registry->product = new ProductManager($registry);
    
    /*** a new SQL object for the website ***/ 
    $registry->casex = new CasexManager($registry);
    
    /*** service Instance ***/
    $registry->service = new ServiceManager($registry);
    
    /*** Users Instance ***/
    $registry->users = new UsersManager($registry);

?>
