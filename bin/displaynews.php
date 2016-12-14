<?php
    
    include('../framework/registry.class.php');
    include('../framework/Console.php');
    include('News/NewsManager.php');
    include('News/News.php');
    include('../model/db.class.php');
    include('conf/Settings.php');
    include('../framework/rss/wToolRSS.php');
    include('../model/pagination.class.php');
    
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
    
    /*** create the pagination registry object ***/
    $registry->paginate = new Pagination();
    
    $news_nb = $registry->news->count();
    
    // Numero de page (1 par défaut)
        if( isset($_GET['page']) && is_numeric($_GET['page']) )
                $page = $_GET['page'];
        else
                $page = 1;
    
    echo "<br />Il y a $news_nb new(s) dans la base. 
            <form action='?rt=news&page=".$page."' method='get' id='paginate'>
                Nombre d'objets à afficher : 
                <select name='items_nb' id='items_nb'>
                    <option value='10'>10</option>
                    <option value='30'>30</option>
                    <option value='40'>40</option>
                </select>
            </form>\n";    
    
    // Nombre d'infos par page
        if (isset($_GET['items_nb']))
        {
            $pagination = $_GET['items_nb'];
        }
        
        else
        {
            $pagination = 10;
        }
        
        // Numéro du 1er enregistrement à lire
        $limit_start = ($page - 1) * $pagination;

        // Préparation de la requête        
        $newslist = $registry->news->getList("DESC", $limit_start, $pagination);
        
        if($newslist != 0)
        {
            foreach ($newslist as $news)
            {                          
//                if(preg_match("/gigabyte|asus|intel/i", $news->title()) && preg_match("/gigabyte|asus|intel/i", $news->guid()))
//                {
                    echo "[".$news->date()."] ".'<a href="'.$news->link().'">'.$news->title().'</a><br/>'."\n";
//                    $items_nb++;
//                }
            }
        }
        
        // Pagination
        $nb_pages = ceil($news_nb / $pagination);

        echo '<p class="pagination">' .$registry->paginate->get($page, $nb_pages) . '</p>';
?>
