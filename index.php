<?php
// Vérification de la présence du paramètre GET 'page'
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    // Déterminer le fichier à inclure en fonction du paramètre 'page'
    switch ($page) {
        case "home":
            include 'home.php'; 
            break;
        case "hobbie":
            include 'hobbie.php';
            break;
        case "contact":
            include 'contact.php';
            break;
        default:
            include '404.php';
            exit();
    }
} else {
    // Si le paramètre 'page' n'est pas défini, inclure par défaut 'home.php'
    include 'home.php';
}
?>
