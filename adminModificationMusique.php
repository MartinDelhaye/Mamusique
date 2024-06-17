<?php
    include("config/config.php");
    include ("scripts/requete.php");
    include("scripts/balise.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    $musique = obtenirInfoPrecis($bdd,"musique","id_musique",$_POST["id_musique"],"fetch");
    $album = RequeteJOIN($bdd,"album","musique","id_album","id_musique",$_POST["id_musique"],"fetch","album.*");

    // liste complete 
    $tabArtiste = obtenirListeComplete($bdd,"artiste","prenom, nom");
    $tabGroupe = obtenirListeComplete($bdd,"groupe","nom");
    $tabAlbum = obtenirListeComplete($bdd,"album","titre");

    //auteur
    $artiste = RequeteJOIN($bdd,"artiste","musique","id_artiste","id_musique",$_POST["id_musique"],"fetch","*");
    $groupe = RequeteJOIN($bdd,"groupe","musique","id_groupe","id_musique",$_POST["id_musique"],"fetch","*");

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
            var albumCheckbox = document.getElementById('nv_album');
            var singleCheckbox = document.getElementById('single');

            // Sélectionne les divs à afficher ou à masquer en fonction de la sélection
            var groupeDiv = document.getElementById('GROUPE');
            var artisteDiv = document.getElementById('ARTISTE');
            var albumDiv = document.getElementById('ALBUM');

            // Récupère les select associés grace au ID
            var groupeSelect = document.getElementById('nv_id_groupe');
            var artisteSelect = document.getElementById('nv_id_artiste');
            var albumSelect = document.getElementById('nv_id_album');

            // Ajoute un écouteur d'événement à chaque case à cocher pour mettre à jour la visibilité
            groupeCheckbox.addEventListener('change', updateVisibility);
            artisteCheckbox.addEventListener('change', updateVisibility);
            albumCheckbox.addEventListener('change', updateVisibility);
            singleCheckbox.addEventListener('change', updateVisibility);

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
                // Affiche ou masque le div "ALBUM" en fonction de l'état de la case à cocher "nv_album"
                if (albumCheckbox.checked) {
                    albumDiv.style.display = 'block';        
                    albumSelect.required = true;               
                } 
                else {
                    albumDiv.style.display = 'none';
                    albumSelect.required = false;
                }
            }
        });
    </script>
    <title>Page de Modification de Musique</title>
</head>

<body>
    <?php
        afficherHeaderAdmin();
    ?>
    <main>
        <div class="bloc-principale">
            <h1>Modification de la Musique : <?php echo $musique["titre"];  ?></h1> 

            <form action="modifierMusique.php" method="POST" enctype="multipart/form-data">   
                <input type="reset" value="Reset vos modifiaction" />  <br/>
                <input type="hidden" name="id_musique" value="<?php echo $_POST["id_musique"];?>">
                TItre : <input type="text" name="titre" required="required" value="<?php echo $musique["titre"];?>"/><br/>
                Date de sortie : <input type="date" name="date_sortie_mus" required="required" value='<?php echo $musique["date_sortie_mus"]?>'><br/>          
                Parole :<textarea name="parole" rows="20" cols="50" required="required"><?php echo $musique["parole"];?></textarea><br/>
                Duree : <input type="time" name="duree_mus" require="required" step="1" value="<?php echo $musique["duree_mus"];?>"><br/>
                Cover actuelle : <br>
                <?php echo afficherImage($musique["url_cover_mus"],$musique["titre"], "illustration"); ?><br>
                <input type="hidden" name="anc_url" value="<?php echo $musique["url_cover_mus"];?>">

                <!-- Changement Cover -->
                Nouvelle Cover : <input type="file" name="nouvelle_photo"><br>
                Auteur actuelle : 
                <?php 
                    if($musique["id_artiste"] != NULL){
                        echo $artiste["prenom"]."  ".$artiste["nom"];
                    }
                    elseif($musique["id_groupe"] != NULL){
                        echo $groupe["nom"];  
                    }            
                    echo"<br>";
                ?>
                Vous pouvez changer l'auteur  :
                <input type="radio" name="nv_auteur" value="groupe" id="groupe"> Groupe
                <input type="radio" name="nv_auteur" value="artiste" id="artiste" > Artiste  <br/><br/>
                <div id="GROUPE">
                    Veuillez choisir le groupe : <select name="nv_id_groupe" id="nv_id_groupe"  size=10 >
                    <?php
                        foreach($tabGroupe as $groupe):
                            echo afficheoption($groupe["id_groupe"], $groupe["nom"]);
                        endforeach;
                    ?>                    
                    </select><br/><br/>   
                </div>                    
                <div id="ARTISTE">     
                    Veuillez choisir l'artiste : <select name="nv_id_artiste" id="nv_id_artiste" size=10>
                    <?php
                        foreach($tabArtiste as $artiste):
                            echo afficheoption($artiste["id_artiste"], ($artiste["prenom"]."  ". $artiste["nom"]));
                        endforeach;
                    ?>                    
                    </select><br/><br/>  
                </div> 

                <!-- Changement album  -->
                <?php 
                    if($musique["id_album"] != NULL){
                        echo "Cette musique est dans l'album : ".$album["titre"]. "<br>";
                    }
                    else{
                        echo "Cette musique est un Single <br>";
                    }
                ?>
                Vous voulez que la musique soit/reste dans un album ou un single   :
                <input type="radio" name="album_single" value="nv_album" id="nv_album"> Album
                <input type="radio" name="album_single" value="single" id="single"> Single  <br/><br/>
                <div id="ALBUM">
                    Veuillez choisir l'album : <select name="nv_id_album" id="nv_id_album" size=10 >
                    <?php
                        foreach($tabAlbum as $album_focus):
                            echo afficheoption($album_focus["id_album"], $album_focus["titre"]);
                        endforeach;
                    ?>                    
                    </select><br/><br/>   
                </div>                   
                <input type="submit" value="Modifier la musique "/>
            </form>
        </div>
    </main>
</body>
</html>

