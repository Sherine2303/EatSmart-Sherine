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
    }
    //$commandeModel = new CommandeModel(); 
    //print_r($commandeModel->getDBAllCommandes());
?>
