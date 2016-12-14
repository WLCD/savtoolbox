<?php
/**
 * Description of Service
 *
 * @author wlcd
 */
class Service {
    
    private $id,
            $content;
    
    function __construct(array $data) {
        $this->buildService($data);
    }
    
    public function buildService(array $data)
    {
        //appeler chaque setter automatiquement grace au nom du champs
        //de la table qui est identique au nom de la méthode
        //(moins le préfixe "set")
        foreach ($data as $key => $value)
        {
            $method = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }
    
    /* GETTERS */

    public function id()
    {
        return $this->id;
    }
    
    public function content()
    {
        return $this->content;
    }
    
    /* SETTERS */
    
    public function setId($id)
    {
        $id = (int) $id;

        if ($id > 0)
        {
            $this->id = $id;
        }
    }

    public function setContent($content)
    {
        if (is_string($content))
        {
            $this->content = $content;
        }
    }
}
?>
