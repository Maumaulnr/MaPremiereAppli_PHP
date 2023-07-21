<!-- $_GET : Tableau associatif qui contient des données envoyées par les paramètres d'URL (query string). 
Par exemple, dans l'URL example.com/page.php?nom=John&age=30, les valeurs de nom et age peuvent être récupérées avec $_GET['nom'] et $_GET['age'].
$_POST : tableau associatif qui contient les données envoyées par un formulaire HTML avec la méthode POST (<form method="post">).
Par exemple, si vous avez un formulaire avec un champ <input type="text" name="username">, vous pouvez récupérer la valeur saisie par l'utilisateur avec $_POST['username'].
-->

<?php

// session_start() crée une session ou restaure celle trouvée sur le serveur, via l'identifiant de session passé dans une requête GET, POST ou par un cookie.
session_start();

    // On vérifie si le formulaire de suppression a été soumis.
    // Cette partie doit être en haut du code sinon il faut cliquer deux fois pour supprimer un article.
    // Permet de s'assurer que l'utilisateur a bien cliqué sur le bouton supprimé pour supprimer un produit précis.
    // Grâce à $_POST on peut récupérer la valeur $_POST['index'] qui correspond à la clé du produit que l'utilisateur souhaite supprimer.
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
        $index = $_GET['index'];

        switch ($_GET['delete']) {
            // On supprime un produit à la fois
            case 'delete-product': 
                if (isset($_SESSION['products'][$index])) {
                    unset($_SESSION['products'][$index]);
                }
                break;
            // on supprime tous les produits
            case 'delete-all-products':
                foreach($_SESSION['products'] as $index => $product) {
                    unset($_SESSION['products'][$index]);
                }
                break;
        }
    }

    // On ajoute ou on retire une quantité
    // On vérifie si la méthode de requête (HTTP method) utilisée pour accéder au fichier est "GET" ($_SERVER['REQUEST_METHOD'] === 'GET') et si le paramètre change_number est présent dans l'URL (isset($_GET['change_number'])).
    // $_SERVER : Superglobale qui contient des infos sur le serveur web et la requête HTTP enc cours.
    // REQUEST_METHOD : Clé de $_SERVER
    // $_GET : Superglobale qui contient les données passées dans l'URL en tant que paramètres de requête.

    ////////////////////////////////////////////////////////////////////////////////
// On vérifie si une action à modifier la quantité (Requête soumise?)
// On identifie d'abord le produit que l'utilisateur souhaite modifier (ici la qtt)
// On indique le type de modification de qtt souhaité par l'utilisateur (augmenter ou diminué)
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['index']) && isset($_GET['change-number'])) {
    $index = $_GET['index'];
    $change = $_GET['change-number'];

    // On vérifie si le produit existe dans la session
    if (isset($_SESSION['products'][$index])) {
        $product = $_SESSION['products'][$index];

        // On fait en sorte de pouvoir modifier la quantité en fonction du bouton sur lequel on appuie à savoir - ou + suivant si l'on veut diminuer la qtt ou ajouter une qtt
        // Donc si on change en appuyant sur -
        if ($change === 'change-quantity-substract') {
            // On diminue
            $product['qtt']--;
        // Sinon si on appuie sur +
        } elseif ($change === 'change-quantity-add') {
            // alors on ajoute
            $product['qtt']++;
        }

        // On vérifie si la qtt est <= 0
        if($product['qtt'] <= 0) {
            // alors on supprime le produit s'il n'y a plus de qtt
            unset($_SESSION['products'][$index]);
        } else {
            // On met à jour le prix et le total pour que tout s'ajuste correctement en fonction de la qtt
            $product['total'] = $product['price'] * $product['qtt'];
            // l'ID index est la partie que l'on met à jour et le tableau $product est le tableau qui contient les infos du produit avec la nouvelle qtt, nouveau prix et nouveau total
            $_SESSION['products'][$index] = $product;
        }
    } 
}


// On redirige vers la page recap.php pour permettre le bon affichage
header("location:recap.php");
exit();

?>