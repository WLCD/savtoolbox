<?php
/**
 * Description of Case
 *
 * @author wlcd
 */
class Casex {
    
    private $id,
            $ref,
            $type,
            $sn,
            $date,
            $idcustomer,
            $collect,
            $info,
            $case_closed;
    
    function __construct(array $data) {
        $this->buildCase($data);
    }
    
    public function buildCase(array $data)
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
    
    public function ref()
    {
        return $this->ref;
    }
    
    public function type()
    {
        return $this->type;
    }
    
    public function sn()
    {
        return $this->sn;
    }
    
    public function date()
    {
        return $this->date;
    }
    
    public function idcustomer()
    {
        return $this->idcustomer;
    }
    
    public function collect()
    {
        return $this->collect;
    }
    
    public function info()
    {
        return $this->info;
    }
    
    public function status()
    {
        return $this->status;
    }
    
    public function case_closed()
    {
        return $this->case_closed;
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

    public function setRef($ref)
    {
        if (is_string($ref))
        {
            $this->ref = $ref;
        }
    }

    public function setType($type)
    {      
        if (is_string($type))
        {
            $this->type = $type;
        }
    }
    
    public function setSn($sn)
    {      
        if (is_string($sn))
        {
            $this->sn = $sn;
        }
    }
    
    public function setDate($date)
    {    
        $this->date = $date;   
    }
    
    public function setIdCustomer($idcustomer)
    {   
        if ($idcustomer > 0)
        {
            $this->idcustomer = $idcustomer;
        }
    }
    
    public function setCollect($collect)
    {      
            $this->collect = $collect;
    }
    
    public function setInfo($info)
    {      
        if (is_string($info))
        {
            $this->info = $info;
        }
    }
    
    public function setCaseClosed($case_closed)
    {      
        if (is_string($case_closed))
        {
            $this->case_closed = $case_closed;
        }
    }
}
?>
