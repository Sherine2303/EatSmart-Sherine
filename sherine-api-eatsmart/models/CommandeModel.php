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
    }
    //$commandeModel = new CommandeModel(); 
    //print_r($commandeModel->getDBAllCommandes());
?>
