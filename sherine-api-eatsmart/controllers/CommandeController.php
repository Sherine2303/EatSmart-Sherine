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
        $commande = $this->model->createDBCommande($data);
        if (!$commande) {
            http_response_code(500);
            echo json_encode(["message" => "Erreur lors de la création de la commande"]);
            return;
        }
        foreach ($data['articles'] as $article) {
            $this->model->createAssocArticleCommande(
                $data['id_commande'],
                $article['id_article'],
                $article['quantite']
            );
        }
        http_response_code(201);
        echo json_encode($commande);
    }
}

//$commandeController = new CommandeController();
//$commandeController->getAllCommandes();
?>