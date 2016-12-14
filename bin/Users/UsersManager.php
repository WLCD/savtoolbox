<?php
/**
 * Description of UsersManager
 *
 * @author wlcd
 */
class UsersManager {
    
    private $registry;
    private $db; // SQL instance

    public function __construct($registry)
    {
        $this->registry = $registry;
        $this->db = $this->registry->db;
    }
    
    public function add(Users $Users)
    {
        
        $query_add = "INSERT INTO users (name, password, permissions) 
            VALUES('".$Users->name()."','"
                .$Users->password()."','"
                .$Users->permissions()."','"
                .$Users->theme().")";
        
        $this->db->query($query_add);
        if ($query_add) {$this->registry->console->message('Utilisateur ajouté avec succès !');}
    }

    public function count()
    {
        // Exécute une requête COUNT() et retourne le nombre de résultats retourné
        $query_count = "SELECT COUNT( * ) FROM users";
        $Users = $this->db->query($query_count);
        
        // comme le résultat est une ressource, on récupère jusqte le résultat
        // sous forme d'integer, en sélectionnant la Row "0"
        $Users_nb = mysql_result($Users, 0);
        
        if ($query_count) {
            $this->registry->console->message('La base contient '.$Users_nb.' utilisateur(s)');
            return $Users_nb;
            }
        
        else
        {
            $this->registry->console->message('Count Error !');
        }
    }

    public function delete(Users $Users)
    {
        // Exécute une requête de type DELETE
        $query_delete = "DELETE FROM 'users' WHERE id =".$Users->id();
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
            $query_getUsersInfo = "SELECT * FROM users WHERE id=$info";
            $result = $this->db->query($query_getUsersInfo);
            if ($result)
            {
                $this->registry->console->message('Users with id: '.$info.' exists !<br />');
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
            $query_getUsersInfo = "SELECT * FROM users WHERE name='$info'";
            $result = $this->db->query($query_getUsersInfo);
            if ($result)
            {
                $this->registry->console->message('Users with name "'.$info.'" exists !<br />');
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
        // Si le paramètre est un entier, on veut récupérer le Users avec son identifiant
        // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Users
        if (is_int($info))
        {
            $query_getUsersInfo = "SELECT * FROM users WHERE id=$info";
            $result = $this->db->query($query_getUsersInfo);
            if ($result) {$this->registry->console->message('Users : get by id !<br />');}
            else {echo "Erreur Requete ".$result." <==== <br />";}
            
            $data = mysqli_fetch_assoc($result);
                                 
            return new Users($data);
        }
        
        // Sinon, on veut récupérer l'Users avec son nom
        // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Users
        else
        {
            $query_getUsersInfo = "SELECT * FROM users WHERE name='$info'";
            $result = $this->db->query($query_getUsersInfo);
            if ($result) {$this->registry->console->message('Users : get by name !<br />');}
            else {echo "Erreur Requete ".$result." <==== <br />";}
            
            $data = mysqli_fetch_assoc($result);
                                 
            return new Users($data);
        }  
    }

    public function getList()
    {
        // Exécute une requête de type SELECT, et retourne un tableau d'objets Users
        $query_getUsersList = "SELECT * FROM users WHERE 1";
        $result = $this->db->query($query_getUsersList);
        if ($result) {$this->registry->console->message('List Users : ok !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        while($data = mysqli_fetch_assoc($result))
        {
            foreach($data as $Users)
            {
                $Users = new Users($data);
            }
            $list[] = $Users;
        }        
             
        return $list;
    }
    
    public function update(Users $Users)
    {
        // Prépare une requête de type UPDATE
        // Assignation des valeurs à la requête
        // Exécution de la requête

        $query_update = "UPDATE users SET
            name='".$Users->name()."',
            password='".$Users->password()."',
            permissions='".$Users->permissions()."'
            WHERE id =".$Users->id();
        
        $result = $this->db->query($query_update);
        
        if($result)
        {
            $this->registry->console->message("Utilisateur ".$Users->name()." mis à jour !");
        }
        
        else
        {
            $this->registry->console->message("Impossible de mettre ".$Users->name()." à jour !");
        }
    }
    
    public function facebookConnect(Users $Users)
    {
        
    }
}

?>
