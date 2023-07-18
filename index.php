<!-- Présentera un formulaire permettant de renseigner :
- le nom du produit
- son prix unitaire
- la quantité désirée
 -->

 <?php

// session_start permet d'accéder aux données de session
 session_start();

 ?>

 <!DOCTYPE html>
 <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Ajout produit</title>

        <link rel="stylesheet" href="./CSS/main.css">
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

        <h1>Ajouter un produit</h1>
        <!-- balise form comporte deux attributs : 
        - action : qui indique  la  cible  du  formulaire,  le  fichier  à  atteindre  lorsque  l'utilisateur soumettra le formulaire.
        - method : qui  précise  par  quelle  méthode  HTTP  les  données  du  formulaire  seront transmises au serveur.
        -->
        <form action="traitement.php" method="post">
            <p>
                <label>
                    Nom du produit :
                    <input type="text" name="name"> <!-- chaque input : attribut "name", ce qui va permettre à la requête de classer le contenu de la saisie dans des clés portant le nom choisi -->
                </label>
            </p>
            <p>
                <label for="">
                    Prix du produit :
                    <input type="number" step="any" name="price">
                </label>
            </p>
            <p>
                <label for="">
                    Quantité désirée :
                    <input type="number" name="qtt" value="1">
                </label>
            </p>
            <p>
                <!-- Le  champ  <input  type="submit">,  représentant  le  bouton  de  soumission  du  formulaire, contient  lui  aussi  un  attribut  "name".   -->
                <input class="submit-btn" type="submit" name="submit" value="Ajouter le produit">
            </p>
        </form>

        <!-- Afficher le nombre de produits présents en session à tout moment, quelle que soit la page affichée. -->

        <?php
            // Afficher le nombre de produits présents en session
            // Chaque fois qu'un produit est entré dans le formulaire, on affiche le nombre de produits présent
            $numberOfProducts = count($_SESSION['products']);
            echo "Nombre de produits en session : " . $numberOfProducts;

            // Faire en sorte que le fichier traitement.php, lorsqu'il retourne au formulaire, créé un message (d'erreur ou de succès, selon le cas de figure) et permettre à index.php de l'afficher.
            // Vérifier si un message est stocké dans la session
            if (isset($_SESSION['message'])) {
                // Afficher le message
                echo $_SESSION['message'];
                
                // Effacer le message de la session
                unset($_SESSION['message']);
            }
        ?>
        
    </body>
 </html>