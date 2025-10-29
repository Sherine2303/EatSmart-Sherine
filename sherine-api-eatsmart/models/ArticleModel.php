<?php
    class ArticleModel //ici
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

        public function getDBAllArticles() //ici
        {
            $stmt = $this->pdo->query("SELECT * FROM article");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getDBArticlesByID($idArticles)
        {
            $req = "
                SELECT * FROM article
                WHERE id_article = :idArticle
            ";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(":idArticle", $idArticles, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // ou fetchAll si tu veux un tableau
        }

        public function getDBArticlesByCategorieID($categorieId)
        {
            $req = "SELECT * FROM article WHERE id_categorie = :categorieId";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(":categorieId", $categorieId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function createDBArticle($data){
            $req = "INSERT INTO article (id_article,nom,prix,description,id_categorie)
                VALUES (:id_article,:nom,:prix,:description,:id_categorie)";
            $stmt =$this->pdo->prepare($req);
            $stmt->bindParam(":id_article",$data['id_article'], PDO::PARAM_INT);
            $stmt->bindParam(":nom",$data['nom'], PDO::PARAM_STR);
            $stmt->bindParam(":prix",$data['prix'], PDO::PARAM_STR);
            $stmt->bindParam(":description",$data['description'], PDO::PARAM_STR);
            $stmt->bindParam(":id_categorie",$data['id_categorie'], PDO::PARAM_INT);
            $stmt->execute();
            $article = $this-> getDBArticlesByID($data['id_article']);
            return $article;
        }
        public function deleteDBArticle ($id){
            $req = "DELETE FROM article 
                    WHERE id_article = :id";
            $stmt = $this->pdo->prepare($req);

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            //verifie si une ligne a été modifiée 
            return $stmt->rowCount()>0;
        }
    }
    //$articleModel = new ArticleModel(); 
    //print_r($articleModel->getDBAllArticles());
?>
