<?php
/**
 * Description of wToolController_base
 *
 * @author wlcd
 */
Abstract Class baseController {

    /*
     * @registry object
     */
    protected $registry;

    function __construct($registry) {
        $this->registry = $registry;
        $this->siteParams();
    }
    
    /**
     * @all controllers must contain an index method
     */
    abstract function index();
    
    public function siteParams()
    {
        session_start();
        $this->registry->template->doctype = $this->registry->settings->html_doctype;
        $this->registry->template->lang = $this->registry->settings->language;
        $this->registry->template->js_libs = $this->registry->settings->js_libs;
        $this->registry->template->js_path = $this->registry->settings->js_path;        
        $this->registry->template->style = $this->registry->style->genStyleSheets();        
        $this->registry->template->title = $this->registry->settings->title;
        $this->registry->template->menu = $this->registry->menu->genMenu($this->registry->settings->menu);
        $this->registry->template->login = $this->registry->login->getLogin();
    }
    
}

?>
