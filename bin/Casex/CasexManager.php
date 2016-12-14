<?php
/**
 * Description of CasexManager
 *
 * @author wlcd
 */
class CasexManager {
    
    private $registry;
    private $db; // SQL instance

    public function __construct($registry)
    {
        $this->registry = $registry;
        $this->setDb($this->registry->db);
    }
    
    public function add(array $case)
    {
        
        $query_add = "INSERT INTO cases(name, EAN, SN, owner) 
            VALUES('".$case['name']."','".$case['ean']."','".$case['sn']."', 1)";
        $this->db->query($query_add);
        if ($query_add) {$this->registry->console->message('Utilisateur ajouté avec succès !');}
    }

    public function count()
    {
        // Exécute une requête COUNT() et retourne le nombre de résultats retourné
        $query_count = "SELECT COUNT( * ) FROM cases";
        $case = $this->db->query($query_count);
        
        // comme le résultat est une ressource, on récupère jusqte le résultat
        // sous forme d'integer, en sélectionnant la Row "0"
        $case_nb = mysqli_data_seek($case, 0);
        
        if ($query_count) {
            $this->registry->console->message('La base contient '.$case_nb.' produit(s)');
            return $case_nb;
            }
        
        else
        {
            $this->registry->console->message('Count Error !');
        }
    }
    

    public function delete(Casex $case)
    {
        // Exécute une requête de type DELETE
        $query_delete = "DELETE FROM 'cases' WHERE id =".$case->id();
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
            $query_getCaseInfo = "SELECT * FROM cases WHERE id=$info";
            $result = $this->db->query($query_getCaseInfo);
            if ($result)
            {
                $this->registry->console->message('Case with id: '.$info.' exists !<br />');
                return TRUE;
            }
            
            else
            {
                $this->registry->console->message("Le produit n'existe pas !<br />");
                return FALSE;
            }
        }

        // Sinon, c'est qu'on a passé un nom
        // Exécution d'une requête SELECT avec une clause WHERE, et retourne un boolean
        else
        {
            $query_getCaseInfo = "SELECT * FROM cases WHERE name='$info'";
            $result = $this->db->query($query_getCaseInfo);
            if ($result)
            {
                $this->registry->console->message('Case with name "'.$info.'" exists !<br />');
                return TRUE;
            }
            
            else
            {
                $this->registry->console->message("Le produit n'existe pas !<br />");
                return FALSE;
            }
        }
    }

    public function get($info)
    {
        // Si le paramètre est un entier, on veut récupérer le Case avec son identifiant
        // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Case
        $query_getCaseInfo = "SELECT * FROM cases WHERE id=$info";
        $result = $this->db->query($query_getCaseInfo);
        if ($result) {$this->registry->console->message('Case : get by id !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        $data = mysqli_fetch_array($result);

        return new Casex($data);  
    }

    public function getList()
    {
        // Exécute une requête de type SELECT, et retourne un tableau d'objets Case
        $query_getCaseList = "SELECT * FROM cases WHERE 1";
        $result = $this->db->query($query_getCaseList);
        if ($result) {$this->registry->console->message('List Case : ok !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        while($data = mysqli_fetch_assoc($result))
        {
            foreach($data as $case)
            {
                $case = new Casex($data);
            }
            $list[] = $case;
        }        
             
        return $list;
    }
    
    public function getFormattedDate($id)
    {
        $query_getCaseDate = "SELECT date FROM cases WHERE id=$id";
        $result = $this->db->query($query_getCaseDate);
        if ($result) {$this->registry->console->message('Case : get date by id !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        $date = mysqli_fetch_assoc($result);

        $formatted_date = explode("-", $date['date']);
        
        return $formatted_date[2].$formatted_date[1].substr($formatted_date[0], -2);
    }
    
    public function update($case)
    {
        // Prépare une requête de type UPDATE
        // Assignation des valeurs à la requête
        // Exécution de la requête

        $query_update = "UPDATE cases SET
            idcustomer = ".$case['idcustomer'].",
            sn = '".$case['sn']."',
            info = '".$case['info']."',
            ref = '".$case['ref']."',
            collect = ".$case['collect'].",
            case_closed = '".$case['case_closed']."'
            WHERE id = ".$case['id'];
        
        $result = $this->db->query($query_update);
        
        if($result)
        {
            $this->registry->console->message("Dossier ".$this->getFileNumber($case['id'])." mis à jour !");
        }
        
        else
        {
            $this->registry->console->message("Impossible de mettre ".$this->getFileNumber($case['id'])." à jour !");
        }
    }
    
    public function getFileType($id)
    {
        $case = $this->get($id);
        
        $type = $case->type();
        
        return $type;
    }
    
    public function getFileNumber($id)
    {
        $filenumber = $this->getFileType($id).$this->getFormattedDate($id);
        return $filenumber;
    }
    
    public function setDb($db)
    {
        $this->db = $db;
    }
}

?>
