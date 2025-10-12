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
    
    // Affiche le contenu du tableau pour vérifier comment l’URL est interprétée
    //print_r($url);

    // On teste le premier segment pour déterminer la ressource demandée
    switch($url[0]) {
        case "articles":
            if (isset($url[1]) && isset($url[2]) && $url[2] === "commandes") {
                $commandeController->getCommandesByArticleID($url[1]);
            } elseif (isset($url[1])) {
                $articleController->getDBArticlesByID($url[1]);
            } else {
                echo $articleController->getAllArticles();
            }
            break;
        case "categories":
            if (isset($url[1]) && isset($url[2]) && $url[2] === "articles") {
                // Appel correct : /categories/3/articles
                $articleController->getArticlesByCategorieID($url[1]);
            } elseif (isset($url[1])) {
                // Appel classique : /categories/3
                $categorieController->getDBCategoriesByID($url[1]);
            } else {
                // Appel général : /categories
                echo $categorieController->getAllCategories();
            }
            break;
        case "commandes" : 
            // Si un second segment est présent (ex: un ID), on l’utilise
            if (isset($url[1])) {
                // Exemple : /commande/3 → affiche les infos de la commande 3
                echo "Afficher les informations de la commande : ". $url[1];
            } else {
                // Sinon, on affiche tous les commandes
                echo $commandeController->getAllCommandes();
            }
            break;
        // Si la ressource n'existe pas, on renvoie un message d’erreur
        default :
            echo "La page n'existe pas";
    }
}
?>