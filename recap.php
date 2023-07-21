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
                            // ici on souhaite formater le prix
                            // 2 : Nombre de décimales que nous souhaitons afficher après la virgule
                            // "&nbsp;" :  C'est le caractère que nous souhaitons utiliser comme séparateur de décimales. Dans ce cas, nous utilisons un espace insécable (&nbsp;) comme séparateur de décimales. En résumé, l'utilisation de l'espace insécable dans cet exemple est une astuce pour maintenir la mise en page et l'alignement, garantissant une meilleure expérience utilisateur.
                            // Par exemple, si $product['price'] est égal à 12345.67, la fonction number_format() retournera "12 345,67".
                            "<td>".number_format($product['price'], 2, ",", "&nbsp")."&nbsp;€</td>",
                            "<td>".$product['qtt'] ."</td>",
                            // Pour que les prix s'affichent sous un format monétaire plus lisible
                            "<td>".number_format($product['total'], 2, ",", "&nbsp")."&nbsp;€</td>",

                            // créer un bouton - pour retirer un article ou + pour ajouter avec une méthode GET pour récupérer les données lorsque l'on clique sur un des boutons
                            "<td>",
                                "<form class='qtt-form' method='get' action='traitement-modify.php'>",
                                    "<input type='hidden' name='index' value='". $index. "'>",
                                    // on retire une qtt
                                    "<button class='decrease-btn' type='submit' name='change-number' value='change-quantity-substract'> - </button>",
                                    "<span>". $product['qtt']. "</span>",
                                    // On ajoute une qtt
                                    "<button class='increase-btn' type='submit' name='change-number' value='change-quantity-add'> + </button>",
                                "</form>",
                            "</td>",

                            // Créer un bouton permettant de supprimer un article
                            "<td>",
                                "<form method='get' action='traitement-modify.php'>",
                                    "<input type='hidden' name='index' value='" . $index. "'>",
                                    "<button class='delete' type='submit' name='delete' value='delete-product'>",
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

                        // Créer un bouton permettant de supprimer tous les articles
                        // Supprimer tous les index en une fois
                        "<td>",
                            "<form method='get' action='traitement-modify.php'>",
                                "<input type='hidden' name='index' value='" . $index. "'>",
                                "<button class='delete' type='submit' name='delete' value='delete-all-products'>",
                                    "<i class='fa-solid fa-trash-can'></i>",
                                "</button>",
                            "</form>",
                        "</td>",
                    "</tr>",
                        "</tbody>",
                    "</table>";

                // Afficher le nombre de produits présents en session
                // Chaque fois qu'un produit est entré dans le formulaire, on affiche le nombre de produits présent
                if(!isset($_SESSION['products']) || empty($_SESSION['products'])) {
                    echo "<p>Nombre de produits en session : 0 </p>";
                } else {
                    echo "<p>Nombre de produits en session : </p>". count($_SESSION['products']);
                }
            }
        ?>
    </body>
</html>