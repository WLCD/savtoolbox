<?php
    
    include('../framework/registry.class.php');
    include('../framework/Console.php');
    include('News/NewsManager.php');
    include('News/News.php');
    include('../model/db.class.php');
    include('conf/Settings.php');
    include('../framework/rss/wToolRSS.php');
    
    $site_path = realpath(dirname(__FILE__));
    define ('__SITE_PATH', $site_path);
    
    /*** a new registry object ***/
    $registry = new registry;
    
    /*** create the settings registry object ***/
    $registry->settings = Settings::get();
    
    $registry->console = Console::get($registry->settings);
    
    /*** create the database registry object ***/
    $registry->db = db::get($registry->settings, $registry->console);
    
    /*** a new SQL object for the website ***/ 
    $registry->news = new NewsManager($registry);
    
    $registry->rss = new wToolRSS($registry);
    
    $urls = array('http://feeds.feedburner.com/phoenixjp/rxqg?format=xml',
            'http://feeds.feedburner.com/Overclocking-tv?format=xml',
            'http://www.ginjfo.com/rss-actualites',
            'http://www.info-mods.com/services/flux-rss/flux-actu.xml',
            'http://www.generation-gpu.fr/actualite/rss/cat',
            'http://www.syndrome-oc.net/index.php/itemlist.html?format=feed&lang=fr&moduleID=98&type=rss',
            'http://www.overclocking-pc.fr/index.php?format=feed&type=rss');
    
    $items = $registry->rss->getFeeds($urls, true, 'cache/', 900, 0);
    
//    echo count($items);
    
    foreach ($items as $item)
    {              
        if($registry->news->matchItem($item->get_date('Y-m-d H:i:s'), mysql_escape_string($item->get_title())) == 0)
        {
            $build_news = array(
            'title' => mysql_escape_string($item->get_title()),
            'link' => $item->get_permalink(),
            'guid' => $item->get_id(),
            'date' => $item->get_date('Y-m-d H:i:s'));

            $registry->news->add(new News($build_news));      
        }
        
//        else
//        {
//            echo " objet(s) existant(s)<br />";
//        }
    }
?>
