<?php
/*** error reporting on ***/
error_reporting(E_ALL);

/*** define the site path constant ***/
$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path);

/*** include the init file ***/
include 'framework/init/Init.php';

/*** session handling ***/
//ini_set('session.save_handler', 'user');//on définit l'utilisation des sessions en personnel

//$registry->session = session::get($registry->settings,$registry->db);
//
//session_set_save_handler(array('session', 'open'),
//                         array('session', 'close'),
//                         array('session', 'read'),
//                         array('session', 'write'),
//                         array('session', 'destroy'),
//                         array('session', 'gc'));//on précise les méthodes à employer pour les sessions

/*** load the router ***/
$registry->router = new router($registry);

/*** set the controller path ***/
$registry->router->setPath (__SITE_PATH . '/bin/controller');

/*** load up the style ***/
$registry->style = new style($registry);

/*** load up the menu ***/
$registry->menu = new menu($registry);

/*** load up the login ***/
$registry->login = new login($registry);

/*** load up the template ***/
$registry->template = new template($registry);

/*** load the controller ***/
$registry->router->loader();

/* Start session and load library. */
//session_start();

?>
