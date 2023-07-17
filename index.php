<!-- Présentera un formulaire permettant de renseigner :
- le nom du produit
- son prix unitaire
- la quantité désirée
 -->

 <!DOCTYPE html>
 <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Ajout produit</title>
    </head>
    <body>

        <h1>Ajouter un produit</h1>
        <!-- balise form comporte deux attributs : 
        - action : qui indique  la  cible  du  formulaire,  le  fichier  à  atteindre  lorsque  l'utilisateur soumettra le formulaire.
        - method : qui  précise  par  quelle  méthode  HTTP  les  données  du  formulaire  seront transmises au serveur.
        -->
        <form action="traitement.php" method="post">
            <p>
                <label for="">
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
                <input type="submit" name="submit" value="Ajouter le produit">
            </p>
        </form>
        
    </body>
 </html>