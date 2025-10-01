<?php
    class CategorieModel //ici
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

        public function getDBAllCategories() //ici
        {
            $stmt = $this->pdo->query("SELECT * FROM categorie");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    //$categorieModel = new CategorieModel(); 
    //print_r($categorieModel->getDBAllCategories());
?>
