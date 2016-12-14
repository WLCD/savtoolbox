<?php
/**
 * Description of EmployeeManager
 *
 * @author wlcd
 */
class EmployeeManager {
    
    private $registry;
    private $db; // SQL instance

    public function __construct($registry)
    {
        $this->registry = $registry;
        $this->setDb($this->registry->db);
    }
    
    public function add(array $customer)
    {
        
        $query_add = "INSERT INTO people (name, address, zipcode, city, mail, phone, company) 
            VALUES('".$customer['name']."','"
                .$customer['address']."','"
                .$customer['zipcode']."','"
                .$customer['city']."','"
                .$customer['mail']."','"
                .$customer['phone']."','"
                .$customer['company']."')";
        
        $this->db->query($query_add);
        if ($query_add) {$this->registry->console->message('Utilisateur ajouté avec succès !');}
    }

    public function count()
    {
        // Exécute une requête COUNT() et retourne le nombre de résultats retourné
        $query_count = "SELECT COUNT( * ) FROM customer";
        $customer = $this->db->query($query_count);
        
        // comme le résultat est une ressource, on récupère jusqte le résultat
        // sous forme d'integer, en sélectionnant la Row "0"
        $customer_nb = mysqli_data_seek($customer, 0);
        
        if ($query_count) {
            $this->registry->console->message('La base contient '.$customer_nb.' client(s)');
            return $customer_nb;
            }
        
        else
        {
            $this->registry->console->message('Count Error !');
        }
    }

    public function delete(Employee $customer)
    {
        // Exécute une requête de type DELETE
        $query_delete = "DELETE FROM 'customer' WHERE id =".$customer->id();
        $result = $this->db->query($query_delete);
        
        if($result)
        {
            $this->registry->console->message('Utilisateur Supprimé !');
        }
        
        else
        {
            $this->registry->console->message('Impossible de supprimer l\'utilisateur');
        }
    }

    public function exists($info)
    {
        // Si le paramètre est un entier, c'est qu'on a fourni un identifiant
        // On exécute alors une requête SELECT avec une clause WHERE, et on retourne un boolean
        if (is_int($info))
        {
            $query_getpeopleInfo = "SELECT * FROM customer WHERE id=$info";
            $result = $this->db->query($query_getpeopleInfo);
            if ($result)
            {
                $this->registry->console->message('people with id: '.$info.' exists !<br />');
                return TRUE;
            }
            
            else
            {
                $this->registry->console->message("L'utilisateur n'existe pas !<br />");
                return FALSE;
            }
        }

        // Sinon, c'est qu'on a passé un nom
        // Exécution d'une requête SELECT avec une clause WHERE, et retourne un boolean
        else
        {
            $query_getpeopleInfo = "SELECT * FROM customer WHERE name='$info'";
            $result = $this->db->query($query_getpeopleInfo);
            if ($result)
            {
                $this->registry->console->message('customer with name "'.$info.'" exists !<br />');
                return TRUE;
            }
            
            else
            {
                $this->registry->console->message("L'utilisateur n'existe pas !<br />");
                return FALSE;
            }
        }
    }

    public function get($info)
    {
        // Si le paramètre est un entier, on veut récupérer le people avec son identifiant
        // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet people
        if (is_int($info))
        {
            $query_getpeopleInfo = "SELECT * FROM customer WHERE id=$info";
            $result = $this->db->query($query_getpeopleInfo);
            if ($result) {$this->registry->console->message('people : get by id !<br />');}
            else {echo "Erreur Requete ".$result." <==== <br />";}
            
            $data = mysqli_fetch_assoc($result);
                                 
            return new Employee($data);
        }
        
        // Sinon, on veut récupérer l'people avec son nom
        // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet people
        else
        {
            $query_getpeopleInfo = "SELECT * FROM customer WHERE name='$info'";
            $result = $this->db->query($query_getpeopleInfo);
            if ($result) {$this->registry->console->message('people : get by name !<br />');}
            else {echo "Erreur Requete ".$result." <==== <br />";}
            
            $data = mysqli_fetch_assoc($result);
                                 
            return new Employee($data);
        }  
    }

    public function getList()
    {
        // Exécute une requête de type SELECT, et retourne un tableau d'objets people
        $query_getpeopleList = "SELECT * FROM customer WHERE 1";
        $result = $this->db->query($query_getpeopleList);
        if ($result) {$this->registry->console->message('List people : ok !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        while($data = mysqli_fetch_assoc($result))
        {
            foreach($data as $customer)
            {
                $customer = new Employee($data);
            }
            $list[] = $customer;
        }        
             
        return $list;
    }
    
    public function getEmployeesList($id)
    {
        // Exécute une requête de type SELECT, et retourne un tableau d'objets people
        $query_getpeopleList = "SELECT * FROM customer WHERE company = $id";
        $result = $this->db->query($query_getpeopleList);
        
        while($data = mysqli_fetch_assoc($result))
        {
            foreach($data as $customer)
            {
                $customer = new Employee($data);
            }
            $list[] = $customer;
        }        
        
        if(isset ($list))
        {
            return $list;
        }        
    }
    
    public function update(Employee $customer)
    {
        // Prépare une requête de type UPDATE
        // Assignation des valeurs à la requête
        // Exécution de la requête

        $query_update = "UPDATE customer SET
            name='".$customer->name()."',
            mail='".$customer->mail()."',
            phone='".$customer->phone()."',
            address='".$customer->address()."',
            company=".$customer->company().",
            zipcode=".$customer->zipcode().",
            city='".$customer->city()."'
            WHERE id =".$customer->id();
        
        $result = $this->db->query($query_update);
        
        if($result)
        {
            $this->registry->console->message("Utilisateur ".$customer->name()." mis à jour !");
        }
        
        else
        {
            $this->registry->console->message("Impossible de mettre ".$customer->name()." à jour !");
        }
    }  
    
    public function setDb($db)
    {
        $this->db = $db;
    }
}

?>
