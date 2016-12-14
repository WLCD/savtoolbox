<?php
/**
 * Description of Users
 *
 * @author wlcd
 */
class Users {
    
    private $id,
            $name,
            $password,
            $permissions,
            $theme,
            $fb_connect,
            $fb_token;
    
    function __construct(array $data) {
        $this->buildUsers($data);
    }
    
    public function buildUsers(array $data)
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
    
    public function password()
    {
        return $this->password;
    }

    public function permissions()
    {
        return $this->permissions;
    }

    public function theme()
    {
        return $this->theme;
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
    
    public function fb_connect()
    {
        return $this->fb_connect;
    }
    
    public function fb_token()
    {
        return $this->fb_token;
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

    public function setpassword($password)
    {
        if (is_string($password))
        {
            $this->password = $password;
        }
    }

    public function setpermissions($permissions)
    {
        $this->permissions = $permissions;
    }
    
    public function settheme($theme)
    {
        if (is_string($theme))
        {
            $this->theme = $theme;
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
    
    public function setFbConnect($fb_connect)
    {
        if (is_bool($fb_connect))
        {
            $this->fb_connect = $fb_connect;
        }
    }
    
    public function setFbToken($fb_token)
    {
        if (is_string($fb_token))
        {
            $this->fb_token = $fb_token;
        }
    }
}
?>
