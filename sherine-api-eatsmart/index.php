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
        case "articles" : 
            // Si un second segment est présent (ex: un ID), on l’utilise
            if (isset($url[1])) {
                // Exemple : /Article/3 → affiche les infos du Article 3
                echo "Afficher les informations de l'article: ". $url[1];
            } else {
                // Sinon, on affiche tous les Articles
                echo $articleController->getAllArticles();
            }
            break;
        case "categories" : 
            // Si un second segment est présent (ex: un ID), on l’utilise
            if (isset($url[1])) {
                // Exemple : /catégorie/3 → affiche les infos du catégorie 3
                echo "Afficher les informations de la catégorie : ". $url[1];
            } else {
                // Sinon, on affiche tous les catégories
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