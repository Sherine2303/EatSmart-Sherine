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
    public function createCategorie($data)
    {
        $categorie = $this ->model->createDBCategorie($data);
        http_response_code(201);
        echo json_encode($categorie);
    }
    public function updateCategorie($id,$data){
        $success=$this->model->updateDBCategorie($id,$data);
        if ($success){
            http_response_code(204);
        }else{
            http_response_code(404);
            echo json_encode(["message" => "Categorie non trouvé non modifiée"]);
        }
    }
}

//$categorieController = new CategorieController();
//$categorieController->getAllCategories();
?>