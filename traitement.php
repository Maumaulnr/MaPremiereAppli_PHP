<!-- Traitera   la   requête   provenant   de   la   page   index.php   (après   soumission   du formulaire), ajoutera le produit avec son nom, son prix, sa quantité et le total calculé (prix × quantité) en session. 

sessions : https://www.php.net/manual/fr/intro.session.php
filtres : https://www.php.net/manual/fr/filter.filters.php
-->

<?php

// session_start() crée une session ou restaure celle trouvée sur le serveur, via l'identifiant de session passé dans une requête GET, POST ou par un cookie.
session_start();

// Un utilisateur mal intentionné (ou trop curieux) pourrait atteindre le fichier traitement.php en saisissant directement l'URL de celui-ci dans la barre d'adresse, et ainsi provoquer des erreurs  sur  la  page  qui  lui  présenterait  des  informations  que  nous  ne  souhaitons  pas dévoiler.  
// Il  faut  donc  limiter  l'accès  à traitement.phppar  les  seules  requêtes  HTTP provenant de la soumission de notreformulaire.

if(isset($_POST['submit'])) {

    // FILTER_SANITIZE_STRING(champ   "name")   :   ce   filtre   supprime   unechaîne   de caractères  de  toute  présence  de  caractères  spéciaux  et  de  toute  balise  HTML potentielle ou les encode. Pas d'injection de code HTML possible !
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);

    // FILTER_VALIDATE_FLOAT(champ  "price")  :  validera  le  prix  que  s'il  est  un  nombre  à virgule  (pas  de  texte ou autre...), le drapeau FILTER_FLAG_ALLOW_FRACTIONest ajouté pour permettre l'utilisation du caractère "," ou "." pour la décimale.
    $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // FILTER_VALIDATE_INT(champ  "qtt")  :  ne  validera  la  quantité  que  si  celle-ci  est  un nombre entier, au moins égal à 1.
    $qtt = filter_input(INPUT_POST, "qtt", FILTER_SANITIZE_INT);

    if($name && $price && $qtt) {

        // Il  nous  faut  désormais  stocker  nos  données  en  session,  en  ajoutant  celles-ci  au  tableau $_SESSION que  PHP  nous  fournit.  Comme  il  est  demandé  de  conserver  chaque  produit renseigné, nous devons au préalable décider de l'organisation de ces données au sein de la session.
        $product = [
            "name" => $name,
            "price" => $price,
            "qtt" => $qtt,
            "total" => $price*$qtt
        ];

        // Il ne nous reste plus qu'à enregistrer ce produit nouvellement créé en session :
        // On indique la clé "products" de ce tableau. Si cette clé n'existait pas auparavant (ex: l'utilisateur ajoute son tout premier produit), PHP la créera au sein de $_SESSION.
        // Les deux crochets "[]"2sont un raccourci pour indiquer à cet emplacement que nous ajoutons  une  nouvelle  entrée  au  futur  tableau  "products"  associé  à  cette  clé. $_SESSION["products"] doit être lui aussi un tableau afin d'y stocker de nouveaux produits par la suite.
        $_SESSION['products'][] = $product;
    }

}

// redirection grâce à la fonction header(). Il n'y a pas de  "else"  à  la  condition  puisque  dans  tous  les  cas  (formulaire  soumis  ou  non),  nous souhaitons revenir au formulaire après traitement. 

header("Location:index.php");

?>