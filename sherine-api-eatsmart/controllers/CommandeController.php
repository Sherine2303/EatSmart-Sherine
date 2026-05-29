<?php
require_once "models/CommandeModel.php";

class CommandeController
{
    private $model;

    public function __construct()
    {
        $this->model = new CommandeModel();
    }

    public function getAllCommandes()
    {
        $commandes = $this->model->getDBAllCommandes();
        echo json_encode($commandes);
    }
    public function getDBCommandesByID($idCommandes)
    {
        $commande = $this -> model -> getDBCommandesByID($idCommandes);
        echo json_encode($commande);
    }
    public function getCommandesByArticleID($articleId)
    {
        $commandeModel = new CommandeModel();
        $commandes = $commandeModel->getCommandesByArticleID($articleId);
        echo json_encode($commandes);
    }
    public function getArticlesByCommandeID($id)
    {
        $commandeModel = new CommandeModel();
        $articles = $commandeModel->getArticlesByCommandeID($id);
        echo json_encode($articles);
    }
    public function createCommande($data)
    {
        // 1. Appel du modèle pour insérer la commande principale
        $commande = $this->model->createDBCommande($data);
        if (!$commande) {
            http_response_code(500);
            echo json_encode(["message" => "Erreur lors de la création de la commande"]);
            return;
        }
        
        // CORRECTION 1 : Sécurité indispensable pour éviter le "Warning: Undefined array key"
        // On vérifie si TypeScript a envoyé des articles dans la commande avant de faire la boucle
        if (isset($data['articles']) && is_array($data['articles'])) {
            foreach ($data['articles'] as $article) {
                $this->model->createAssocArticleCommande(
                    $commande['id_commande'], // CORRECTION 2 : On utilise le vrai ID généré par la BDD et non pas la valeur NULL de $data
                    $article['id_article'],
                    $article['quantite']
                );
            }
        }

        // CORRECTION 3 : Formatage de la réponse selon la PAGE 3 du cours (Un tableau contenant l'objet de confirmation)
        $reponse = [
            [
                "id_commande" => $commande['id_commande'],
                "date_commande" => $commande['date_commande'],
                "prix_total" => (float)$commande['prix_total'],
                "etat" => $commande['etat'],
                "message" => "Insertion réussie"
            ]
        ];

        http_response_code(201);
        echo json_encode($reponse);
        exit; // On coupe proprement l'exécution pour envoyer un JSON 100% pur
    }
}

//$commandeController = new CommandeController();
//$commandeController->getAllCommandes();
?>