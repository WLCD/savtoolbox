<?php
/**
 * Description of menu
 *
 * @author wlcd
 */
class menu {
    private $registry;
    
    public function __construct($registry) {
        $this->registry = $registry;
    }
    
    public function genMenu($menu_items)
    {
        $menu[] = "\n\t\t<ul> <!-- Start of Main Menu -->\n";
        
        foreach($menu_items as $item)
        {
            $menu[] = "\t\t\t".'<li id="'.strtolower($item).'"><a href="?rt='.strtolower($item).'">'.$item.'</a></li>'."\n";
        }
        
        $menu[] = "\t\t</ul> <!-- End of Main Menu -->\n";
        
        return implode($menu);
    }
}

?>
