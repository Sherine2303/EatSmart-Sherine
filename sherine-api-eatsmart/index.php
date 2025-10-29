<?php
require_once "./controllers/ArticleController.php";
$articleController = new ArticleController();
require_once "./controllers/CategorieController.php";
$categorieController = new CategorieController();
require_once "./controllers/CommandeController.php";
$commandeController = new CommandeController();
// Vérifie si le paramètre "page" est vide ou non présent dans l'URL
if (empty($_GET["page"])) {
    // Si le paramètre est vide, on affiche un message d'erreur
    echo "La page n'existe pas";
} else {
    // Sinon, on récupère la valeur du paramètre "page"
    // Par exemple, si l’URL est : index.php?page=chauffeurs/3
    // Alors $_GET["page"] vaut "chauffeurs/3"
    
    // On découpe cette chaîne en segments, en séparant sur le caractère "/"
    // Cela donne un tableau, ex : ["chauffeurs", "3"]
    $url = explode("/", $_GET['page']); //exploser l'url et mettre dans la
    $method = $_SERVER["REQUEST_METHOD"]; 
    
    // Affiche le contenu du tableau pour vérifier comment l’URL est interprétée
    //print_r($url);

    // On teste le premier segment pour déterminer la ressource demandée
    switch($url[0]) {
        case "articles":
            switch($method){
                case "GET":
                    if (isset($url[1]) && isset($url[2]) && $url[2] === "commandes") {
                        $commandeController->getCommandesByArticleID($url[1]);
                    } elseif (isset($url[1])) {
                        $articleController->getDBArticlesByID($url[1]);
                    } else {
                        echo $articleController->getAllArticles();
                    }
                    break;
                case "POST":
                    $data = json_decode(file_get_contents("php://input"),true);
                    $articleController->createArticle($data);
                break;
            }
            break;
        case "categories":
            switch($method){
                case "GET":
                    if (isset($url[1]) && isset($url[2]) && $url[2] === "articles") {
                        // Appel correct : /categories/3/articles
                        $categorieController->getArticlesByCategorieID($url[1]);
                    } elseif (isset($url[1])) {
                        // Appel classique : /categories/3
                        $categorieController->getDBCategoriesByID($url[1]);
                    } else {
                        // Appel général : /categories
                        echo $categorieController->getAllCategories();
                    }
                    break;
                }
            break;
        case "commandes":
            switch($method){
                case "GET":
                    if (isset($url[1]) && isset($url[2]) && $url[2] === "articles") {
                    $commandeController->getArticlesByCommandeID($url[1]);
                    } elseif (isset($url[1])) {
                        $commandeController->getDBCommandesByID($url[1]);
                    } else {
                        echo $commandeController->getAllCommandes();
                    }
                    break;
                }
            break;    
        // Si la ressource n'existe pas, on renvoie un message d’erreur
        default :
            echo "La page n'existe pas";
    }
}
?>