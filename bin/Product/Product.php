<?php
/**
 * Description of Product
 *
 * @author wlcd
 */
class Product {
    
    private $id,
            $name,
            $ean,
            $sn,
            $delivery,
            $owner,
            $return;
    
    function __construct(array $data) {
        $this->buildProduct($data);
    }
    
    public function buildProduct(array $data)
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
    
    public function name()
    {
        return $this->name;
    }
    
    public function ean()
    {
        return $this->ean;
    }
    
    public function sn()
    {
        return $this->sn;
    }
    
    public function delivery()
    {
        return $this->delivery;
    }
    
    public function owner()
    {
        return $this->owner;
    }
    
    public function returnDate()
    {
        return $this->return;
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

    public function setName($name)
    {
        if (is_string($name))
        {
            $this->name = $name;
        }
    }

    public function setEan($ean)
    {      
        if (is_string($ean))
        {
            $this->ean = $ean;
        }
    }
    
    public function setSn($sn)
    {      
        if (is_string($sn))
        {
            $this->sn = $sn;
        }
    }
    
    public function setDelivery($delivery)
    {
        $delivery = (int) $delivery;
        
        if ($delivery > 0)
        {
            $this->delivery = $delivery;
        }
    }
    
    public function setOwner($owner)
    {
        $owner = (int) $owner;
        
        if ($owner > 0)
        {
            $this->owner = $owner;
        }
    }
    
    public function setReturnDate($return)
    {      
        if (is_string($return))
        {
            $this->return = $return;
        }
    }
}
?>
