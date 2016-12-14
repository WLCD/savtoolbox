<?php
/**
 * Description of Employee
 *
 * @author wlcd
 */
class Employee {
    
    private $id,
            $name,
            $address,
            $city,
            $zipcode,
            $mail,
            $phone,
            $company;
    
    function __construct(array $data) {
        $this->buildEmployee($data);
    }
    
    public function buildEmployee(array $data)
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
    
    public function address()
    {
        return $this->address;
    }

    public function city()
    {
        return $this->city;
    }

    public function zipcode()
    {
        return $this->zipcode;
    }
    
    public function mail()
    {
        return $this->mail;
    }
    
    public function phone()
    {
        return $this->phone;
    }
    
    public function company()
    {
        return $this->company;
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

    public function setAddress($address)
    {
        if (is_string($address))
        {
            $this->address = $address;
        }
    }

    public function setCity($city)
    {
        if (is_string($city))
        {
            $this->city = $city;
        }
    }
    
    public function setZipcode($zipcode)
    {
        if (is_string($zipcode))
        {
            $this->zipcode = $zipcode;
        }
    }
    
    public function setMail($mail)
    {
        if (is_string($mail))
        {
            $this->mail = $mail;
        }
    }
    
    public function setPhone($phone)
    {
        if (is_string($phone))
        {
            $this->phone = $phone;
        }
    }
    
    public function setCompany($company)
    {
        if (is_string($company))
        {
            $this->company = $company;
        }
    }
}
?>
