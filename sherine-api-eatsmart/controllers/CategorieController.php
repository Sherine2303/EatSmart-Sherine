<?php
require_once "models/CategorieModel.php";

class CategorieController
{
    private $model;

    public function __construct()
    {
        $this->model = new CategorieModel();
    }

    public function getAllCategories()
    {
        $categories = $this->model->getDBAllCategories();
        echo json_encode($categories);
    }
    public function getDBCategoriesByID($idCategories)
    {
        $categorie = $this -> model -> getDBCategoriesByID($idCategories);
        echo json_encode($categorie);
    }
    public function getArticlesByCategorieID($id)
    {
        $categorieModel = new CategorieModel();
        $articles = $categorieModel->getArticlesByCategorieID($id);
        echo json_encode($articles);
    }
}

//$categorieController = new CategorieController();
//$categorieController->getAllCategories();
?>