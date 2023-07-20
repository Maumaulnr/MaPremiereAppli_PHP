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
            if(!isset($_SESSION['products']) || empty($_SESSION['products'])) {
                echo "<p>Aucun produit en session</p>";
            } else {
                echo "<p>Nombre de produits en session : </p>". count($_SESSION['products']);
            }

            // Faire en sorte que le fichier traitement.php, lorsqu'il retourne au formulaire, créé un message (d'erreur ou de succès, selon le cas de figure) et permettre à index.php de l'afficher.
            // Vérifier si un message est stocké dans la session
            // Nous rajoutons une condition qui vérifie : 
            // Soit la clé "succes" du tableau de session $_SESSION n'existe pas : !isset()
            // Soit cette clé existe mais ne contient aucune donnée : empty()
            // Dans  ces  deux  cas,  nous  afficherons à l'utilisateur  un  message  le  prévenant  qu'aucun produit n'est présent. Il ne nous reste plus qu'à afficher le message de $_SESSION['succes'] dans la partie else de notre condition.
            if(!isset($_SESSION['succes']) || empty($_SESSION['succes'])) {
                $_SESSION['succes'] = "<p> Ajouter un produit </p>";
            }
            // sinon afficher les produits
            else {
                echo $_SESSION['succes'];
            }
        ?>
        
    </body>
 </html>