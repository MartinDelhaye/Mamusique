<?php
    include ("scripts/balise.php");
    include ("scripts/requete.php");
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);
    

    $artiste = obtenirInfoPrecis($bdd,"artiste","id_artiste",$_GET["id_artiste"],"fetch");
    $tableauMusique = obtenirInfoPrecis($bdd,"musique","id_artiste",$_GET["id_artiste"],"fetchALL");
    $tableauAlbum = obtenirInfoPrecis($bdd,"album","id_artiste",$_GET["id_artiste"],"fetchALL");
    
    //récupère le(s) Groupe(s) de l'artiste
    $tableauGroupe = RequeteSousRequete($bdd,"*","groupe",'id_groupe IN',"id_groupe","membre","id_artiste =".$_GET["id_artiste"]);
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <title><?php echo $artiste["prenom"]." ". $artiste["nom"];?></title>
</head>
<body>
    <?php
    afficherHeader();
    ?>
    <main>
        <div class="bloc-principale">
            <?php echo afficherImage($artiste["url_photo"], ($artiste["prenom"]."_". $artiste["nom"]), "illustration"); ?>
            <h1><?php echo $artiste["prenom"]." ". $artiste["nom"];?></h1>
            <h3><?php echo "Date de naissance : ". $artiste["date_naissance"];?></h3>
            <h3><?php if($artiste["date_mort"]){ echo "Date décès : ". $artiste["date_naissance"]; }?></h3>
            <p> Role : <?php echo $artiste["role"];?></p>

            <?php   
                if(!empty($tableauGroupe)):
                    echo '<h2>Groupes : </h2>';
                    afficherListe($tableauGroupe,"groupe","id_groupe","url_image","nom","date_creation");
                
                endif;
                // if ((!empty($tableauMusique)) && (!empty($tableauAlbum))):  
                //     echo "<h2>Carrière Solo : </h2>"     
                    if(!empty($tableauAlbum)):
                        echo '<h2>Albums : </h2>';
                        afficherListe($tableauAlbum,"album","id_album","url_cover_alb","titre","date_sortie_alb");
                    endif;
                    if(!empty($tableauMusique)):
                        echo '<h2>Musiques : </h2>';
                        afficherListe($tableauMusique,"musique","id_musique","url_cover_mus","titre","date_sortie_mus");
                    endif;
                // endif; 
            ?>
        </div>
    </main>
    <?php
        afficherFooter();
    ?>
</body>
</html>