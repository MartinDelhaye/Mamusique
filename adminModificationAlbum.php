<?php
    include("config/config.php");
    include ("scripts/requete.php");
    include("scripts/balise.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    $album = obtenirInfoPrecis($bdd,"album","id_album",$_POST["id_album"],"fetch");

    // liste complete 
    $tabArtiste = obtenirListeComplete($bdd,"artiste","prenom, nom");
    $tabGroupe = obtenirListeComplete($bdd,"groupe","nom");
    $tabAlbum = obtenirListeComplete($bdd,"album","titre");

    //auteur
    $artiste = RequeteJOIN($bdd,"artiste","album","id_artiste","id_album",$_POST["id_album"],"fetch","*");
    $groupe = RequeteJOIN($bdd,"groupe","album","id_groupe","id_album",$_POST["id_album"],"fetch","*");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Récupère les cases à cocher "groupe", "artiste" et "album"
            var groupeCheckbox = document.getElementById('groupe');
            var artisteCheckbox = document.getElementById('artiste');

            // Sélectionne les divs à afficher ou à masquer en fonction de la sélection
            var groupeDiv = document.getElementById('GROUPE');
            var artisteDiv = document.getElementById('ARTISTE');

            // Ajoute un écouteur d'événement à chaque case à cocher pour mettre à jour la visibilité
            groupeCheckbox.addEventListener('change', updateVisibility);
            artisteCheckbox.addEventListener('change', updateVisibility);

            // Récupère les select associés grace au ID
            var groupeSelect = document.getElementById('nv_id_groupe');
            var artisteSelect = document.getElementById('nv_id_artiste');

            // Définit la fonction pour mettre à jour la visibilité des divs
            function updateVisibility() {
                // Affiche ou masque le div "GROUPE" en fonction de l'état de la case à cocher "groupe"
                if (groupeCheckbox.checked) {
                    groupeDiv.style.display = 'block';         
                    groupeSelect.required = true;               
                } 
                else {
                    groupeDiv.style.display = 'none';
                    groupeSelect.required = false;
                }
                // Affiche ou masque le div "ARTISTE" en fonction de l'état de la case à cocher "artiste"
                if (artisteCheckbox.checked) {
                    artisteDiv.style.display = 'block';        
                    artisteSelect.required = true;               
                } 
                else {
                    artisteDiv.style.display = 'none';
                    artisteSelect.required = false;
                }
            }
        });
    </script>
    <title>Page de Modification de album</title>
</head>

<body>
    <?php
        afficherHeaderAdmin();
    ?>
    <main>
        <div class="bloc-principale">
            <h1>Modification de l' album : <?php echo $album["titre"];  ?></h1> 

            <form action="modifieralbum.php" method="POST" enctype="multipart/form-data">   
                <input type="reset" value="Reset vos modifiaction" />  <br/>
                <input type="hidden" name="id_album" value="<?php echo $_POST["id_album"];?>">
                TItre : <input type="text" name="titre" required="required" value="<?php echo $album["titre"];?>"/><br/>
                Date de sortie : <input type="date" name="date_sortie_alb" required="required" value='<?php echo $album["date_sortie_alb"]?>'><br/>   
                Duree : <input type="time" name="duree_alb" require="required" step="1" value="<?php echo $album["duree_alb"];?>"><br/>
                Cover actuelle : <br>
                <?php echo afficherImage($album["url_cover_alb"],$album["titre"], "illustration"); ?><br>
                <input type="hidden" name="anc_url" value="<?php echo $album["url_cover_alb"];?>">

                <!-- Changement Cover -->
                Nouvelle Cover : <input type="file" name="nouvelle_photo"><br>
                Auteur actuelle : 
                <?php 
                    if($album["id_artiste"] != NULL){
                        echo $artiste["prenom"]."  ".$artiste["nom"]. "<br>";
                    }
                    else{
                        echo $groupe["nom"];
                    }
                ?>
                Vous pouvez changer l'auteur  :
                <input type="radio" name="nv_auteur" value="groupe" id="groupe"> Groupe
                <input type="radio" name="nv_auteur" value="artiste" id="artiste"> Artiste  <br/><br/>
                <div id="GROUPE">
                    Veuillez choisir le groupe : <select name="nv_id_groupe" id="nv_id_groupe" size=10 >
                    <?php
                        foreach($tabGroupe as $groupe):
                            echo afficheoption($groupe["id_groupe"], $groupe["nom"]);
                        endforeach;
                    ?>                    
                    </select><br/><br/>   
                </div>                    
                <div id="ARTISTE">     
                    Veuillez choisir l'artiste : <select name="nv_id_artiste"  id="nv_id_artiste" size=10>
                    <?php
                        foreach($tabArtiste as $artiste):
                            echo afficheoption($artiste["id_artiste"], ($artiste["prenom"]."  ". $artiste["nom"]));
                        endforeach;
                    ?>                    
                    </select><br/><br/>  
                </div> 

            
                <input type="submit" value="Modifier la album "/>
            </form>
        </div>    
    </main>
</body>
</html>

