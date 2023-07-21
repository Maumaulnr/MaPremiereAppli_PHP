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
            case 'delete_product': 
                if (isset($_SESSION['products'][$index])) {
                    unset($_SESSION['products'][$index]);
                }
                break;
        }
    }

    // Supprimer tous les produits en session
    if(isset($_GET['delete']) && !empty($_GET['delete'])){ 
        foreach($_SESSION['products'] as $index => $product) {
            unset($_SESSION['products'][$index]);
        }
    }

    // On ajoute ou on retire une quantité
    // On vérifie si la méthode de requête (HTTP method) utilisée pour accéder au fichier est "GET" ($_SERVER['REQUEST_METHOD'] === 'GET') et si le paramètre change_number est présent dans l'URL (isset($_GET['change_number'])).
    // $_SERVER : Superglobale qui contient des infos sur le serveur web et la requête HTTP enc cours.
    // REQUEST_METHOD : Clé de $_SERVER
    // $_GET : Superglobale qui contient les données passées dans l'URL en tant que paramètres de requête.
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['change_number'])) {
        $index = $_GET['index'];
    
        // On utilise switch pour vérifier la valeur de $_GET['change_number]
        // on veut changer la qtt du produit
        switch($_GET['change_number']) {
            case 'change_quantity': 
                if (isset($_SESSION['products'][$index])) {
                    // On récupère le produit correspondant à l'index spécifié ($index) depuis la session ($_SESSION['products'][$index]). Permet d'accéder aux informations du produit.
                    $product = $_SESSION['products'][$index];
                    // On récupère la valeur de $_GET['change_number'], qui indique si l'utilisateur a cliqué sur le bouton "+" ou "-".
                    $change = $_GET['change_number'];
    
                    // Si on clique sur - alors la qtt sera diminué
                    if ($change === '-') {
                        $product['qtt']--;
                    // sinon si on clique sur + alors on ajoute une qtt
                    } elseif ($change === '+') {
                        $product['qtt']++;
                    }
    
                    // Si la qtt est inférieur ou égale à 0 alors on considère que le produit est supprimé
                    if ($product['qtt'] <= 0) {
                        unset($_SESSION['products'][$index]);
                    // sinon on met à jour la qtt total
                    } else {
                        $product['total'] = $product['price'] * $product['qtt'];
                        $_SESSION['products'][$index] = $product;
                    }
                }
                break;
        }
    }

    header("location: recap.php");
    exit();

    // supprimer un article
    // empty : Détermine si une variable est vide
    // if(isset($_POST['delete_product']) && !empty($_POST['delete_product'])){
    //     if(isset($_SESSION['products'][$index])) {
    //         unset($_SESSION['products'][$index]);
    //     }
    // }



    ////////////////////////////////////////////////////////////////////////////////
// On vérifie si une action à modifier la quantité (Requête soumise?)
// On identifie d'abord le produit que l'utilisateur souhaite modifier (ici la qtt)
// On indique le type de modification de qtt souhaité par l'utilisateur (augmenter ou diminué)
// if (isset($_GET['index']) && isset($_GET['change_number'])) {
//     $index = $_GET['index'];
//     $change = $_GET['change_number'];

//     // On vérifie si le produit existe dans la session
//     if (isset($_SESSION['products'][$index])) {
//         $product = $_SESSION['products'][$index];

//         // On fait en sorte de pouvoir modifier la quantité en fonction du bouton sur lequel on appuie à savoir - ou + suivant si l'on veut diminuer la qtt ou ajouter une qtt
//         // Donc si on change en appuyant sur -
//         if ($change === '-') {
//             // On diminue
//             $product['qtt']--;
//         // Sinon si on appuie sur +
//         } elseif ($change === '+') {
//             // alors on ajoute
//             $product['qtt']++;
//         }

//         // On vérifie si la qtt est <= 0
//         if($product['qtt'] <= 0) {
//             // alors on supprime le produit s'il n'y a plus de qtt
//             unset($_SESSION['products'][$index]);
//         } else {
//             // On met à jour le prix et le total pour que tout s'ajuste correctement en fonction de la qtt
//             $product['total'] = $product['price'] * $product['qtt'];
//             // l'ID index est la partie que l'on met à jour et le tableau $product est le tableau qui contient les infos du produit avec la nouvelle qtt, nouveau prix et nouveau total
//             $_SESSION['products'][$index] = $product;
//         }
//     }
// }


// On redirige vers la page recap.php pour permettre le bon affichage
// header("location:recap.php");
// exit();

?>