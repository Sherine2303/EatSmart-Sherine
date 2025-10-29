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
}

//$commandeController = new CommandeController();
//$commandeController->getAllCommandes();
?>