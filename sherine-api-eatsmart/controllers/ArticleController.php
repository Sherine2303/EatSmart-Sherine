<?php
require_once "models/ArticleModel.php";

class ArticleController
{
    private $model;

    public function __construct()
    {
        $this->model = new ArticleModel();
    }

    public function getAllArticles()
    {
        $articles = $this->model->getDBAllArticles();
        echo json_encode($articles);
    }
    public function getArticlesByCategorieID($categorieId)
    {
        $articles = $this->model->getDBArticlesByCategorieID($categorieId);
        echo json_encode($articles);
    }
}

//$articleController = new ArticleController();
//$articleController->getAllArticles();
?>