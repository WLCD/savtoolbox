<?php
/* simple feed parser */

//get the simplepie library
require_once '../lib/simplepie/simplepie.inc';

class wToolRSS {
    
    /*
     * @the registry
     */
     private $registry;
     
    function __construct($registry) {
        $this->registry = $registry;
    }
    
    function getFeeds($urls, $enable_cache, $cache_location, $cache_duration, $items_number)
    {
        $feed = new SimplePie();

        //URLs of the feeds
        //http://pipes.yahoo.com/pipes/pipe.run?_id=alwrDOh13hGUuxdRBNV6qA&_render=rss
        $feed->set_feed_url($urls);
        
        $feed->set_useragent('made_up_user_agent (Feed Parser; http://www.mycompany.org; Allow like Gecko) Build/20090114');
        
        $feed->handle_content_type();
        // let's start the feed
        $feed->init();

        /* We'll use favicon caching here (Optional)
        $feed->set_favicon_handler('inc/handler_image.php');*/

        //enable caching
        $feed->enable_cache($enable_cache);

        //provide the caching folder
        $feed->set_cache_location($cache_location);

        //set the amount of seconds you want to cache the feed
        $feed->set_cache_duration($cache_duration);

        return $this->setItems($feed, $items_number);
    }

    function setItems($feed, $items_number) {
        
        //show error code if feeds cannot be retrieved
	if ($feed->error)
	{
            //send error code to console
            //$this->registry->console->message($feed->error);
            
            echo "erreur de flux rss: ".$feed->error;
	}
	
        return $feed->get_items(0, $items_number);
    }
}



       
	
?>
