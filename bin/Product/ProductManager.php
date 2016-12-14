<?php
/**
 * Description of ProductManager
 *
 * @author wlcd
 */
class ProductManager {
    
    private $registry;
    private $db; // SQL instance

    public function __construct($registry)
    {
        $this->registry = $registry;
        $this->setDb($this->registry->db);
    }
    
    public function add(array $product)
    {
        
        $query_add = "INSERT INTO products(name, EAN, SN, owner) 
            VALUES('".$product['name']."','".$product['ean']."','".$product['sn']."', 1)";
        $this->db->query($query_add);
        if ($query_add) {$this->registry->console->message('Utilisateur ajouté avec succès !');}
    }

    public function count()
    {
        // Exécute une requête COUNT() et retourne le nombre de résultats retourné
        $query_count = "SELECT COUNT( * ) FROM products";
        $product = $this->db->query($query_count);
        
        // comme le résultat est une ressource, on récupère jusqte le résultat
        // sous forme d'integer, en sélectionnant la Row "0"
        $product_nb = mysqli_data_seek($product, 0);
        
        if ($query_count) {
            $this->registry->console->message('La base contient '.$product_nb.' produit(s)');
            return $product_nb;
            }
        
        else
        {
            $this->registry->console->message('Count Error !');
        }
    }
    
    public function countInside()
    {
        // Exécute une requête COUNT() et retourne le nombre de résultats retourné
        $query_count = "SELECT COUNT( * ) FROM products WHERE owner = 1";
        $product = $this->db->query($query_count);
        
        // comme le résultat est une ressource, on récupère juste le résultat
        // sous forme d'integer, en sélectionnant la Row "0"
        $product_nb = mysqli_data_seek($product, 0);
        
        if ($query_count) {
            $this->registry->console->message($product_nb.' produit(s) disponible(s)');
            return $product_nb;
            }
        
        else
        {
            $this->registry->console->message('Count Error !');
        }
    }
    
    public function countOutside()
    {
        // Exécute une requête COUNT() et retourne le nombre de résultats retourné
        $query_count = "SELECT COUNT( * ) FROM products WHERE owner != 1";
        $product = $this->db->query($query_count);
        
        // comme le résultat est une ressource, on récupère jusqte le résultat
        // sous forme d'integer, en sélectionnant la Row "0"
        $product_nb = mysqli_data_seek($product, 0);
        
        if ($query_count) {
            $this->registry->console->message($product_nb.' produit(s) sont dehors');
            return $product_nb;
            }
        
        else
        {
            $this->registry->console->message('Count Error !');
        }
    }
    
    public function getLastSent()
    {
        //Execute une requete pour déterminer quel est le dernier produit envoyé
        $query = 'SELECT id
                FROM products
                WHERE owner != 1 ORDER BY id DESC LIMIT 0,1';
        
        $result = $this->db->query($query);
        
        $product = mysqli_fetch_array($result);
        
        return $product[0];
    }

    public function delete(Product $product)
    {
        // Exécute une requête de type DELETE
        $query_delete = "DELETE FROM 'products' WHERE id =".$product->id();
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
            $query_getProductInfo = "SELECT * FROM products WHERE id=$info";
            $result = $this->db->query($query_getProductInfo);
            if ($result)
            {
                $this->registry->console->message('Product with id: '.$info.' exists !<br />');
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
            $query_getProductInfo = "SELECT * FROM products WHERE name='$info'";
            $result = $this->db->query($query_getProductInfo);
            if ($result)
            {
                $this->registry->console->message('Product with name "'.$info.'" exists !<br />');
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
        // Si le paramètre est un entier, on veut récupérer le Product avec son identifiant
        // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Product
        $query_getProductInfo = "SELECT * FROM products WHERE id=$info";
        $result = $this->db->query($query_getProductInfo);
        if ($result) {$this->registry->console->message('Product : get by id !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        $data = mysqli_fetch_assoc($result);

        return new Product($data);  
    }

    public function getList()
    {
        // Exécute une requête de type SELECT, et retourne un tableau d'objets Product
        $query_getProductList = "SELECT * FROM products WHERE 1";
        $result = $this->db->query($query_getProductList);
        if ($result) {$this->registry->console->message('List Product : ok !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        while($data = mysqli_fetch_assoc($result))
        {
            foreach($data as $product)
            {
                $product = new Product($data);
            }
            $list[] = $product;
        }        
             
        return $list;
    }
    
    public function getProductsListFromDeliveryId($id)
    {
        // Exécute une requête de type SELECT, et retourne un tableau d'objets Product
        $query_getProductList = "SELECT * FROM product_list WHERE id_delivery = $id";
        $result = $this->db->query($query_getProductList);
        if ($result) {$this->registry->console->message('List Product from delivery id : ok !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}

        while($data = mysqli_fetch_assoc($result))
        {
            for($i = 1; $i <= 10; $i++)
            {
                $index = "id_product$i";
                
                if($data[$index] != 0)
                {
                    $list[] = $data[$index];
                }
            }
        }
        
        return $list;
    }  
    
    public function getSentList()
    {
        //Execute une requete pour déterminer quel est le dernier produit envoyé
        $query = 'SELECT * from products WHERE owner != 1';
        
        $result = $this->db->query($query);
        
        while($data = mysqli_fetch_assoc($result))
        {
            foreach($data as $product)
            {
                $product = array($data);
            }
            
            $data_table[] = $product;
        }
        
        return $data_table;
    }
    
    public function getAvailableList()
    {
        //Execute une requete pour déterminer quel est le dernier produit envoyé
        $query = 'SELECT * from products WHERE owner = 1';
        
        $result = $this->db->query($query);
        
        while($data = mysqli_fetch_assoc($result))
        {
            foreach($data as $product)
            {
                $product = array($data);
            }
            
            $data_table[] = $product;
        }
        
        if(isset ($data_table))
        {
            return $data_table;
        }
        
        else
        {
            return $data_table = "No Available Products";
        }
    }
    
    public function getDeliveryNotes($productid)
    {
        //Execute une requete pour déterminer quel est le dernier produit envoyé
        $query = "SELECT id_delivery
                FROM product_list
                WHERE id_product1 = $productid
                OR id_product2 = $productid
                OR id_product3 = $productid
                OR id_product4 = $productid
                OR id_product5 = $productid
                OR id_product6 = $productid
                OR id_product7 = $productid
                OR id_product8 = $productid
                OR id_product9 = $productid
                OR id_product10 = $productid";
        
        
        
        $result = $this->db->query($query);
        
        while($data = mysqli_fetch_array($result))
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
    
    public function getShippings($productid)
    {
        //Execute une requete pour déterminer quel est le dernier produit envoyé
        $query = "SELECT COUNT(*)
                FROM product_list
                WHERE id_product1 = $productid
                OR id_product2 = $productid
                OR id_product3 = $productid
                OR id_product4 = $productid
                OR id_product5 = $productid
                OR id_product6 = $productid
                OR id_product7 = $productid
                OR id_product8 = $productid
                OR id_product9 = $productid
                OR id_product10 = $productid";
        
        $result = $this->db->query($query);
        
        $data = mysqli_fetch_array($result);
        
        return $data[0];
        
    }
    
    public function update(Product $product)
    {
        // Prépare une requête de type UPDATE
        // Assignation des valeurs à la requête
        // Exécution de la requête

        $query_update = "UPDATE products SET
            name ='".$product->name()."',
            EAN ='".$product->ean()."',
            SN ='".$product->sn()."',
            owner = ".$product->owner().",
            delivery =".$product->delivery().",
            return_date ='".$product->returnDate()."'
            WHERE id = ".$product->id();
        
        $result = $this->db->query($query_update);
        
        if($result)
        {
            $this->registry->console->message("Produit ".$product->name()." mis à jour !");
        }
        
        else
        {
            $this->registry->console->message("Impossible de mettre ".$product->name()." à jour !");
        }
    }
    
    public function getLastProductsList()
    {
        $query_getProductList = "SELECT id FROM product_list WHERE 1 ORDER BY id DESC LIMIT 0,1";
        $result = $this->db->query($query_getProductList);
        if ($result) {$this->registry->console->message('Get Last list : ok !<br />');}
        else {echo "Erreur Requete ".$result." <==== <br />";}
        
        $list_id = mysqli_fetch_array($result);
        
        return $list_id[0];
    }
    
    public function setProductList(array $products)
    {
        $i = 1;
        $products_list = array();
        
        foreach($products as $key => $value)
        {
            $index = 'id_product'.$i;
            
            $products_list[$index] = $value;
            
            $i++;
        }
        
        foreach($products_list as $key => $value)
        {
            $fields[] = $key;
            $values[] = $value;
        }
              
        $query_fields = implode(',', $fields);
        $query_values = implode(',', $values);
        
        $query_add = "INSERT INTO product_list($query_fields) 
            VALUES($query_values)";
        $this->db->query($query_add);
        if ($query_add) {$this->registry->console->message('Liste ajoutée avec succès !');}
        
        return $this->getLastProductsList();        
    }
    
    public function setProductListDeliveryId($id_delivery)
    {
        $products_list = $this->getLastProductsList();
        
        $query_update = "UPDATE product_list SET id_delivery = ".$id_delivery." WHERE id = ".$products_list;
        
        $result = $this->db->query($query_update);
    }
    
    public function setDb($db)
    {
        $this->db = $db;
    }
}

?>
