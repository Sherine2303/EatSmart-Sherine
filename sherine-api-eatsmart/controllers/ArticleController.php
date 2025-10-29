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
    public function getDBArticlesByID($idArticles)
    {
        $article = $this -> model -> getDBArticlesByID($idArticles);
        echo json_encode($article);
    }
    public function getArticlesByCategorieID($categorieId)
    {
        $articles = $this->model->getDBArticlesByCategorieID($categorieId);
        echo json_encode($articles);
    }
    public function createArticle($data)
    {
        $article = $this ->model->createDBArticle($data);
        http_response_code(201);
        echo json_encode($article);
    }
    public function deleteArticle($id){
        $success=$this->model->deleteDBArticle($id);
        if ($success){
            http_response_code(204);
        }else{
            http_response_code(404);
            echo json_encode(["message" => "Article introuvable"]);
        }
    }
}

//$articleController = new ArticleController();
//$articleController->getAllArticles();
?>