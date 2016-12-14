<?php
/**
 * Description of ServiceManager
 *
 * @author wlcd
 */
class ServiceManager {
    
    private $registry;
    private $db; // SQL instance

    public function __construct($registry)
    {
        $this->registry = $registry;
        $this->setDb($this->registry->db);
    }
    
    public function add(array $service)
    {
        
        $query_add = "INSERT INTO services(content) 
            VALUES('".$service['content']."')";
        $this->db->query($query_add);
        if ($query_add) {$this->registry->console->message('Service ajouté avec succès !');}
    }

    public function count()
    {
        // Exécute une requête COUNT() et retourne le nombre de résultats retourné
        $query_count = "SELECT COUNT( * ) FROM services";
        $service = $this->db->query($query_count);
        
        // comme le résultat est une ressource, on récupère jusqte le résultat
        // sous forme d'integer, en sélectionnant la Row "0"
        $service_nb = mysql_result($service, 0);
        
        if ($query_count) {
            $this->registry->console->message('La base contient '.$service_nb.' service(s)');
            return $service_nb;
            }
        
        else
        {
            $this->registry->console->message('Count Error !');
        }
    }
    

    public function delete(Service $service)
    {
        // Exécute une requête de type DELETE
        $query_delete = "DELETE FROM 'products' WHERE id =".$service->id();
        $result = $this->db->query($query_delete);
        
        if($result)
        {
            $this->registry->console->message('Produit Supprimé !');
        }
        
        else
        {
            $this->registry->console->message('Impossible de supprimer le produit');
        }
    }

    public function exists($info)
    {
        // Si le paramètre est un entier, c'est qu'on a fourni un identifiant
        // On exécute alors une requête SELECT avec une clause WHERE, et on retourne un boolean
        if (is_int($info))
        {
            $query_getServiceInfo = "SELECT * FROM services WHERE id=$info";
            $result = $this->db->query($query_getServiceInfo);
            if ($result)
            {
                $this->registry->console->message('Service with id: '.$info.' exists !<br />');
                return TRUE;
            }
            
            else
            {
                $this->registry->console->message("Le Service n'existe pas !<br />");
                return FALSE;
            }
        }

        // Sinon, c'est qu'on a passé un nom
        // Exécution d'une requête SELECT avec une clause WHERE, et retourne un boolean
        else
        {
            $query_getServiceInfo = "SELECT * FROM services WHERE name='$info'";
            $result = $this->db->query($query_getServiceInfo);
            if ($result)
            {
                $this->registry->console->message('Service with content "'.$info.'" exists !<br />');
                return TRUE;
            }
            
            else
            {
                $this->registry->console->message("Le service n'existe pas !<br />");
                return FALSE;
            }
        }
    }

    public function get($info)
    {
        // Si le paramètre est un entier, on veut récupérer le Service avec son identifiant
        // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Service
        $query_getServiceInfo = "SELECT * FROM services WHERE id=$info";
        $result = $this->db->query($query_getServiceInfo);
        if ($result) {$this->registry->console->message('Service : get by id !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        $data = mysql_fetch_assoc($result);

        return new Service($data);  
    }

    public function getList()
    {
        // Exécute une requête de type SELECT, et retourne un tableau d'objets Service
        $query_getServiceList = "SELECT * FROM services WHERE 1";
        $result = $this->db->query($query_getServiceList);
        if ($result) {$this->registry->console->message('List Service : ok !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        while($data = mysql_fetch_assoc($result))
        {
            foreach($data as $service)
            {
                $service = new Service($data);
            }
            $list[] = $service;
        }        
             
        return $list;
    }
    
    public function getServicesListFromInvoiceId($id)
    {
        // Exécute une requête de type SELECT, et retourne un tableau d'objets Service
        $query_getServiceList = "SELECT * FROM product_list WHERE id_delivery = $id";
        $result = $this->db->query($query_getServiceList);
        if ($result) {$this->registry->console->message('List Service from delivery id : ok !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        while($data = mysql_fetch_assoc($result))
        {
            for($i = 1; $i <= 10; $i++)
            {
                $index = "id_service$i";
                
                if($data[$index] != 0)
                {
                    $list[] = $data[$index];
                }
            }
        }
        
        return $list;
    }  
    
    public function getInvoices($serviceid)
    {
        //Execute une requete pour déterminer quel est le dernier produit envoyé
        $query = "SELECT id_delivery
                FROM service_list
                WHERE id_service1 = $serviceid
                OR id_service2 = $serviceid
                OR id_service3 = $serviceid
                OR id_service4 = $serviceid
                OR id_service5 = $serviceid
                OR id_service6 = $serviceid
                OR id_service7 = $serviceid
                OR id_service8 = $serviceid
                OR id_service9 = $serviceid
                OR id_service10 = $serviceid";
        
        
        
        $result = $this->db->query($query);
        
        while($data = mysql_fetch_array($result))
        {
            
            foreach($data as $note_id)
            {
                $note_id = $data[0];
            }
            
            $data_table[] = $note_id;
        }
               
        if(isset ($data_table))
        {
            return $data_table;
        }
        
        else
        {
            $data_table = array("Not sent yet");
            return $data_table;
        }
    }
    
    public function update(Service $service)
    {
        // Prépare une requête de type UPDATE
        // Assignation des valeurs à la requête
        // Exécution de la requête

        $query_update = "UPDATE products SET
            name ='".$service->name()."',
            EAN ='".$service->ean()."',
            SN ='".$service->sn()."',
            owner = ".$service->owner().",
            delivery =".$service->delivery().",
            return_date ='".$service->returnDate()."'
            WHERE id = ".$service->id();
        
        $result = $this->db->query($query_update);
        
        if($result)
        {
            $this->registry->console->message("Produit ".$service->name()." mis à jour !");
        }
        
        else
        {
            $this->registry->console->message("Impossible de mettre ".$service->name()." à jour !");
        }
    }
    
    public function setServiceList(array $services)
    {
        $i = 1;
        $services_list = array();
        
        foreach($services as $key => $value)
        {
            $index = 'id_service'.$i;
            
            $services_list[$index] = $value;
            
            $i++;
        }
        
        foreach($services_list as $key => $value)
        {
            $fields[] = $key;
            $values[] = $value;
        }
              
        $query_fields = implode(',', $fields);
        $query_values = implode(',', $values);
        
        $query_add = "INSERT INTO service_list($query_fields) 
            VALUES($query_values)";
        $this->db->query($query_add);
        if ($query_add) {$this->registry->console->message('Liste ajoutée avec succès !');}
        
        return $this->getLastServicesList();        
    }
    
    public function setServiceListInvoiceId($id_invoice)
    {
        $services_list = $this->getLastServicesList();
        
        $query_update = "UPDATE service_list SET id_invoice = ".$id_invoice." WHERE id = ".$services_list;
        
        $result = $this->db->query($query_update);
    }
    
    public function setDb($db)
    {
        $this->db = $db;
    }
}

?>
