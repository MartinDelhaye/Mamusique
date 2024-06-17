<?php
    include ("scripts/balise.php");
    include ("scripts/requete.php");
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    $groupe = obtenirInfoPrecis($bdd,"groupe","id_groupe",$_GET["id_groupe"],"fetch");
    $tableauMusique = obtenirInfoPrecis($bdd,"musique","id_groupe",$_GET["id_groupe"],"fetchALL");
    $tableauAlbum = obtenirInfoPrecis($bdd,"album","id_groupe",$_GET["id_groupe"],"fetchALL");
    $tableauMembres = RequeteJOIN($bdd,"artiste","membre","id_artiste","membre.id_groupe",$_GET["id_groupe"],"fetchALL","*, membre.date_rejoint");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <title><?php echo $groupe["nom"];?></title>
</head>
<body>
    <?php
    afficherHeader();
    ?>
    <main>
        <div class="bloc-principale">
            <?php echo afficherImage($groupe["url_image"], $groupe["nom"], "illustration"); ?>
            <h1><?php echo $groupe["nom"];?></h1>
            <h3><?php echo "Date de création : ". $groupe["date_creation"];?></h3>


            <?php   
                if(!empty($tableauMembres)):
                    echo '<h2>Membres : </h2>';
                    afficherListe($tableauMembres,"artiste","id_artiste","url_photo","prenom","date_rejoint");
                endif;  
                if(!empty($tableauAlbum)):
                    echo '<h2>Albums : </h2>';
                    afficherListe($tableauAlbum,"album","id_album","url_cover_alb","titre","date_sortie_alb");
                endif;
                if(!empty($tableauMusique)):
                    echo '<h2>Musiques : </h2>';
                    afficherListe($tableauMusique,"musique","id_musique","url_cover_mus","titre","date_sortie_mus");
                endif; 
            ?>
        </div>
        <?php
            afficherFooter();
        ?>
    </main>



</body>
</html>