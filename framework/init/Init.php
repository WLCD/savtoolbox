<?php
/**
* Description of Init
*
* @author wlcd
*/
    /*** include the controller class ***/
    include __SITE_PATH . '/framework/' . 'session.class.php';
    
    /*** include the controller class ***/
    include __SITE_PATH . '/framework/' . 'controller_base.class.php';

    /*** include the registry class ***/
    include __SITE_PATH . '/framework/' . 'registry.class.php';

    /*** include the router class ***/
    include __SITE_PATH . '/framework/' . 'router.class.php';

    /*** include the template class ***/
    include __SITE_PATH . '/framework/' . 'template.class.php';
    
    /*** include the style class ***/
    include __SITE_PATH . '/framework/' . 'style.class.php';
    
    /*** include the menu class ***/
    include __SITE_PATH . '/framework/' . 'menu.class.php';
    
    /*** include the login class ***/
    include __SITE_PATH . '/framework/' . 'login.class.php';
    
    /*** include the Error class ***/
    include __SITE_PATH . '/framework/Errors/' . 'Errors.php';
    
    /*** include the Console class ***/
    include __SITE_PATH . '/framework/' . 'Console.php';
    
    /*** include the RSS class ***/
    //include __SITE_PATH . '/framework/rss/' . 'wToolRSS.php';
    
    /*** include the twitter class ***/
    include __SITE_PATH . '/framework/sns/' . 'wToolTwitter.php';  
       
    /*** include the libraries ***/
    include __SITE_PATH . '/lib/' . 'includes.php';
    
    /*** include models ***/
    include __SITE_PATH . '/model/' . 'db.class.php';
    
    include __SITE_PATH . '/model/' . 'fb.class.php';
    
    include __SITE_PATH . '/model/' . 'pagination.class.php';
    
    /*** include the app class ***/
    include __SITE_PATH . '/bin/' . 'AppInit.php';
?>
