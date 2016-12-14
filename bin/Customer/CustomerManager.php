<?php
/**
 * Description of CustomerManager
 *
 * @author wlcd
 */
class CustomerManager {
    
    private $registry;
    private $db; // SQL instance

    public function __construct($registry)
    {
        $this->registry = $registry;
        $this->setDb($this->registry->db);
    }
    
    public function add(array $company)
    {
        
        $query_add = "INSERT INTO customer (name, address, zipcode, city, mail, phone, type) 
            VALUES('".$company['name']."','"
                .$company['address']."','"
                .$company['zipcode']."','"
                .$company['city']."','"
                .$company['mail']."','"
                .$company['phone']."','"
                .$company['type']."')";
        
        $this->db->query($query_add);
        if ($query_add) {$this->registry->console->message('Compagnie ajoutée avec succès !');}
    }

    public function count()
    {
        // Exécute une requête COUNT() et retourne le nombre de résultats retourné
        $query_count = "SELECT COUNT( * ) FROM customer";
        $company = $this->db->query($query_count);
        
        // comme le résultat est une ressource, on récupère jusqte le résultat
        // sous forme d'integer, en sélectionnant la Row "0"
        $company_nb = mysqli_result($company, 0);
        
        if ($query_count) {
            $this->registry->console->message('La base contient '.$company_nb.' compagnie(s)');
            return $company_nb;
            }
        
        else
        {
            $this->registry->console->message('Count Error !');
        }
    }

    public function delete(Customer $company)
    {
        // Exécute une requête de type DELETE
        $query_delete = "DELETE FROM 'customer' WHERE id =".$company->id();
        $result = $this->db->query($query_delete);
        
        if($result)
        {
            $this->registry->console->message('Compagnie Supprimée !');
        }
        
        else
        {
            $this->registry->console->message('Impossible de supprimer la compagnie');
        }
    }

    public function exists($info)
    {
        // Si le paramètre est un entier, c'est qu'on a fourni un identifiant
        // On exécute alors une requête SELECT avec une clause WHERE, et on retourne un boolean
        if (is_int($info))
        {
            $query_getCustomerInfo = "SELECT * FROM customer WHERE id=$info";
            $result = $this->db->query($query_getCustomerInfo);
            if ($result)
            {
                $this->registry->console->message('compagnie with id: '.$info.' exists !<br />');
                return TRUE;
            }
            
            else
            {
                $this->registry->console->message("La compagnie n'existe pas !<br />");
                return FALSE;
            }
        }

        // Sinon, c'est qu'on a passé un nom
        // Exécution d'une requête SELECT avec une clause WHERE, et retourne un boolean
        else
        {
            $query_getCustomerInfo = "SELECT * FROM customer WHERE name='$info'";
            $result = $this->db->query($query_getCustomerInfo);
            if ($result)
            {
                $this->registry->console->message('customer with name "'.$info.'" exists !<br />');
                return TRUE;
            }
            
            else
            {
                $this->registry->console->message("Le client n'existe pas !<br />");
                return FALSE;
            }
        }
    }

    public function get($info)
    {
        $query_getCustomerInfo = "SELECT * FROM customer WHERE id=$info";
        $result = $this->db->query($query_getCustomerInfo);
        if ($result) {$this->registry->console->message('customer : get by id !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        $data = mysqli_fetch_assoc($result);
        
        return new Customer($data);
    }
    
    public function getLast()
    {
        $query_getCustomerInfo = "SELECT * FROM customer WHERE 1 ORDER BY id DESC LIMIT 0,1";
        $result = $this->db->query($query_getCustomerInfo);
        if ($result) {$this->registry->console->message('customer : get by id !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        $data = mysqli_fetch_assoc($result);
        
        return new Customer($data);
    }

    public function getList()
    {
        // Exécute une requête de type SELECT, et retourne un tableau d'objets Customer
        $query_getCustomerList = "SELECT * FROM customer WHERE 1 ORDER BY name";
        $result = $this->db->query($query_getCustomerList);
        if ($result) {$this->registry->console->message('List Customer : ok !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        while($data = mysqli_fetch_assoc($result))
        {
            foreach($data as $company)
            {
                $company = new Customer($data);
            }
            $list[] = $company;
        }        
        
        return $list;
    }
    
    public function getLastClient()
    {
        $query = 'SELECT C.id
                FROM delivery_note D
                INNER JOIN customer C ON (
                D.customer = C.id
                )
                WHERE 1
                ORDER BY D.id DESC
                LIMIT 0,1';
        
        $result = $this->db->query($query);
        
        $client = mysqli_fetch_array($result);
        
        return $client[0];
    }
    
    public function update(Customer $customer)
    {
        // Prépare une requête de type UPDATE
        // Assignation des valeurs à la requête
        // Exécution de la requête

        $query_update = "UPDATE customer SET
            name='".$company->name()."',
            mail='".$company->mail()."',
            phone='".$company->phone()."',
            address='".$company->address()."',
            type='".$company->type()."',
            city='".$company->city()."',
            zipcode='".$company->zipcode()."'
            WHERE id =".$company->id();
        
        $result = $this->db->query($query_update);
        
        if($result)
        {
            $this->registry->console->message("Compagnie ".$company->name()." mise à jour !");
        }
        
        else
        {
            $this->registry->console->message("Impossible de mettre ".$company->name()." à jour !");
        }
    }  
    
    public function setDb($db)
    {
        $this->db = $db;
    }
}

?>
