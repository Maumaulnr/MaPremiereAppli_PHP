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
    </head>
    <body>
        <?php 
            // Nous rajoutons une condition qui vérifie : 
            // Soit la clé "products" du tableau de session $_SESSIONn'existe pas : !isset()
            // Soit cette clé existe mais ne contient aucune donnée : empty()
            // Dans  ces  deux  cas,  nous  afficherons  à  l'utilisateur  un  message  le  prévenant  qu'aucun produit   n'existe   en session.   Il   ne   nous   reste   plus   qu'àafficher   le   contenu   de $_SESSION['products'] dans la partie elsede notre condition.
            if(!isset($_SESSION['products']) || empty($_SESSION['products'])) {
                echo "<p>Aucun produit en session ...</p>";
            }
            else {
                echo "<table>",
                        "<thead>",
                            "<tr>,"
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
                    // La bouclecréera alors une ligne <tr>et toutes les cellules <td> nécessaires à chaque partie du produit à afficher, et ce pour chaque produit présent en session.
                    echo "<tr>",
                            "<td>".$index ."</td>",
                            "<td>".$product['name'] ."</td>",
                            // Pour que les prix s'affichent sous un format monétaire plus lisible
                            "<td>".number_format($product['price'], 2, ",", "&nbsp")."&nbsp;€</td>",
                            "<td>".$product['qtt'] ."</td>",
                            // Pour que les prix s'affichent sous un format monétaire plus lisible
                            "<td>".number_format($product['total'], 2, ",", "&nbsp")."&nbsp</td>",
                        "</tr>";
                    $totalGeneral += $product['total'];
                }
                echo "<tr>",
                        "<td colspan=4>Total général</td>",
                        "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp"). "&nbsp;€</strong></td>",
                    "</tr>",
                        "</tbody>",
                    "</table>";
            }
        ?>
    </body>
</html>