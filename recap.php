<!-- Affichera tous les produits en session (et en détail) et présentera le total général de tous les produits ajoutés. -->

<?php

// recap.phpdevra nous permettre d'afficher de manière organisée et exhaustive la liste des produits présents ensession. Elle doit également présenter le total de l'ensemble de ceux-ci.

// A la différence d'index.php, nous aurons besoin ici de parcourir le tableau de session, il est donc nécessaire d'appeler la fonction session_start()en début de fichier afin de récupérer, comme dit plus haut, la session correspondante à l'utilisateur.

session_start();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Récapitulatif des produits</title>

        <link rel="stylesheet" href="./CSS/main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>

    <!-- Permettre à l'utilisateur d'aller sur la page recap.php ou index.php à tout moment, dans un menu. -->

        <!-- Menu de navigation -->
        <nav class="navbar">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a href="recap.php">Récapitulatif</a>
                </li>
            </ul>
        </nav>

    <!-- 
        Ajouter trois fonctionnalités utiles dans recap.php :
             Supprimer un produit en session (selon le choix de l'utilisateur).
             Supprimer tous les produits en session en une seule fois.
             Modifier les quantités de chaque produit grâce à deux boutons "+" et "-" positionnés de part et d'autre du nombre dans la cellule. 
    -->

        <?php 

            // On vérifie si le formulaire de suppression a été soumis.
            // Cette partie doit être en haut du code sinon il faut cliquer deux fois pour supprimer un article.
            // Permet de s'assurer que l'utilisateur a bien cliqué sur le bouton supprimé pour supprimer un produit précis.
            // Grâce à $_POST on peut récupérer la valeur $_POST['index'] qui correspond à la clé du produit que l'utilisateur souhaite supprimer.
            // if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
            //     $index = $_POST['index'];
            //     // var_dump($index);

            //     // Supprimer l'article
            //     // isset : Détermine si une variable est déclarée
            //     // On vérifie que le produit existe
            //     if(isset($_SESSION['products'][$index])) {
            //         // unset : détruit la ou les variables dont le nom a été passé en argument donc ici on veut "détruire" la clé $index ce qui supprimera le reste des informations
            //         // si le produit existe, on utilise la fonction unset() pour supprimer le produit du tableau
            //         unset($_SESSION['products'][$index]);
            //     }
            // }

            // supprimer un article
            // empty : Détermine si une variable est vide
            if(isset($_POST['delete_product']) && !empty($_POST['delete_product'])){
                if(isset($_SESSION['products'][$index])) {
                    unset($_SESSION['products'][$index]);
                }
            }

            // Supprimer tous les produits en session
            if(isset($_POST['delete_all_products']) && !empty($_POST['delete_all_products'])){ 
                foreach($_SESSION['products'] as $index => $product) {
                    unset($_SESSION['products'][$index]);
                }
            }

            // Nous rajoutons une condition qui vérifie : 
            // Soit la clé "products" du tableau de session $_SESSION n'existe pas : !isset()
            // Soit cette clé existe mais ne contient aucune donnée : empty()
            // Dans  ces  deux  cas,  nous  afficherons  à  l'utilisateur  un  message  le  prévenant  qu'aucun produit   n'existe   en session.   Il   ne   nous   reste   plus   qu'à afficher   le   contenu   de $_SESSION['products'] dans la partie else de notre condition.
            if(!isset($_SESSION['products']) || empty($_SESSION['products'])) {
                echo "<p>Aucun produit en session ...</p>";
            }
            // sinon afficher le tableau des produits
            else {
                echo "<table>",
                        "<thead>",
                            "<tr>",
                                "<th>#</th>",
                                "<th>Nom</th>",
                                "<th>Prix</th>",
                                "<th>Quantité</th>",
                                "<th>Total</th>",
                            "</tr>",
                        "</thead>",
                        "<tbody>";
                $totalGeneral = 0;

                //   boucle  itérative foreach() de  PHP,  particulièrement  efficace pour exécuter, produit par produit, les mêmes instructions qui vont permettre l'affichage uniforme  de  chacun  d'entre  eux.  Pour  chaque  donnée  dans $_SESSION['products'],  nous disposerons au sein de la boucle de deux variables :
                // $index:  aura  pour  valeur  l'index  du  tableau $_SESSION['products']parcouru.  Nous pourrons numéroter ainsi chaque produit avec ce numéro dans le tableau HTML (en première colonne).
                // $product: cette variable contiendra le produit, sous forme de tableau, tel que l'a créé et stocké en session le fichier traitement.php.
                foreach($_SESSION['products'] as $index => $product) {
                    // La boucle créera alors une ligne <tr> et toutes les cellules <td> nécessaires à chaque partie du produit à afficher, et ce pour chaque produit présent en session.
                    echo "<tr>",
                            "<td>".$index ."</td>",
                            "<td>".$product['name'] ."</td>",
                            // Pour que les prix s'affichent sous un format monétaire plus lisible
                            "<td>".number_format($product['price'], 2, ",", "&nbsp")."&nbsp;€</td>",
                            "<td>".$product['qtt'] ."</td>",
                            // Pour que les prix s'affichent sous un format monétaire plus lisible
                            "<td>".number_format($product['total'], 2, ",", "&nbsp")."&nbsp;€</td>",
                            // créer un bouton - pour retirer un article ou + pour ajouter avec une méthode GET pour récupérer les données lorsque l'on clique sur un des boutons
                            "<td>",
                                "<form class='qtt-form' method='get' action='traitement-modify.php'>",
                                    "<input type='hidden' name='index' value'". $index. "'>",
                                    "<button class='decrease-btn' type='submit' name='change_number' value='-'> - </button>",
                                    "<span>". $index. "</span>",
                                    "<button class='increase-btn' type='submit' name='change_number' value='+'> + </button>",
                                "</form>",
                            "</td>",
                            // Créer un input permettant de supprimer un article
                            "<td>",
                                "<form method='post' action='recap.php'>",
                                    "<input type='hidden' name='products' value='" . $index. "'>",
                                    "<button class='delete' type='submit' name='delete_product'>",
                                        "<i class='fa-solid fa-trash-can'></i>",
                                    "</button>",
                                "</form>",
                            "</td>",
                        "</tr>";
                    // À l'intérieur de la boucle, grâce à l'opérateur combiné +=, on ajoute le total du produit parcouru à la valeur de $totalGeneral, qui augmente d'autant pour chaque produit.
                    $totalGeneral += $product['total'];
                }
                
                echo "<tr>",
                        "<td colspan=4>Total général</td>",
                        "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp"). "&nbsp;€</strong></td>",
                        // Créer un input permettant de supprimer tous les articles
                        // Supprimer tous les index en une fois
                        "<td>",
                            "<form method='post' action='recap.php'>",
                                "<input type='hidden' name='products' value='" . $index. "'>",
                                "<button class='delete' type='submit' name='delete_all_products'>",
                                    "<i class='fa-solid fa-trash-can'></i>",
                                "</button>",
                            "</form>",
                        "</td>",
                    "</tr>",
                        "</tbody>",
                    "</table>";

                // Afficher le nombre de produits présents en session
                // Chaque fois qu'un produit est entré dans le formulaire, on affiche le nombre de produits présent
                $numberOfProducts = count($_SESSION['products']);
                // Le message ne s'affichera que si le nombre de produits est supérieur à 0
                if($numberOfProducts > 0) {
                    echo "Nombre de produits en session : " . $numberOfProducts;
                }
            }
        ?>
    </body>
</html>