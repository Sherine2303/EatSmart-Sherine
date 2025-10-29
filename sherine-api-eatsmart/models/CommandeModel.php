<?php
    class CommandeModel //ici
    {
        private $pdo;

        public function __construct()
        {
            try {
                $this->pdo = new PDO("mysql:host=localhost;dbname=eatsmart_bdd_bruno;charset=utf8", "root", "");
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        public function getDBAllCommandes() //ici
        {
            $stmt = $this->pdo->query("SELECT * FROM commande");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getDBCommandesByID($idCommandes)
        {
            $req = "
                SELECT * FROM commande
                WHERE id_commande = :idCommande
            ";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(":idCommande", $idCommandes, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // ou fetchAll si tu veux un tableau
        }
        public function getCommandesByArticleID($id)
        {
            $sql = "SELECT commande.* FROM commande
                    INNER JOIN assoc_article_commande ON commande.id_commande = assoc_article_commande.id_commande
                    WHERE assoc_article_commande.id_article = :id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getArticlesByCommandeID($id)
        {
            $sql = "SELECT article.id_article, article.nom, article.prix, article.description, article.id_categorie,
                        assoc_article_commande.quantite_article
                    FROM article
                    INNER JOIN assoc_article_commande ON article.id_article = assoc_article_commande.id_article
                    WHERE assoc_article_commande.id_commande = :id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function createDBCommande($data){
            $req = "INSERT INTO commande (id_commande,date_commande,prix_total,etat)
                VALUES (:id_commande,:date_commande,:prix_total,:etat)";
            $stmt =$this->pdo->prepare($req);
            $stmt->bindParam(":id_commande",$data['id_commande'], PDO::PARAM_INT);
            $stmt->bindParam(":date_commande",$data['date_commande'], PDO::PARAM_STR);
            $stmt->bindParam(":prix_total",$data['prix_total'], PDO::PARAM_STR);
            $stmt->bindParam(":etat",$data['etat'], PDO::PARAM_STR);
            $stmt->execute();
            $commande = $this-> getDBCommandesByID($data['id_commande']);
            return $commande;
        }
        public function createAssocArticleCommande($idCommande, $idArticle, $quantite)
        {
            $req = "INSERT INTO assoc_article_commande (id_article, id_commande, quantite_article)
                    VALUES (:id_article, :id_commande, :quantite_article)";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindParam(":id_article", $idArticle, PDO::PARAM_INT);
            $stmt->bindParam(":id_commande", $idCommande, PDO::PARAM_INT);
            $stmt->bindParam(":quantite_article", $quantite, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    //$commandeModel = new CommandeModel(); 
    //print_r($commandeModel->getDBAllCommandes());
?>
