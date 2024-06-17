<?php
    include ("scripts/balise.php");
    include ("scripts/requete.php");
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    $musique = obtenirInfoPrecis($bdd,"musique","id_musique",$_GET["id_musique"],"fetch");
    $album = RequeteJOIN($bdd,"album","musique","id_album","id_musique",$_GET["id_musique"],"fetch","album.*");
    //auteur
    $artiste = RequeteJOIN($bdd,"artiste","musique","id_artiste","id_musique",$_GET["id_musique"],"fetch","*");
    $groupe = RequeteJOIN($bdd,"groupe","musique","id_groupe","id_musique",$_GET["id_musique"],"fetch","*");
    //feat
    $feat = RequeteJOIN($bdd,"feat","musique","id_musique","feat.id_musique",$_GET["id_musique"],"fetchALL","feat.*");    
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <title><?php echo $musique["titre"];?></title>
</head>
<body>
    <?php
    afficherHeader();
    ?>
    <main>
        <div class="bloc-principale">
            <?php echo afficherImage($musique["url_cover_mus"], $musique["titre"], "illustration"); ?>
            
            <h1><?php echo $musique["titre"];?></h1>
            <h3><?php echo "Durée : ". $musique["duree_mus"];?></h3>
            <h3><?php echo "Date de sortie : ". $musique["date_sortie_mus"];?></h3>

            <?php 
                echo '<h2> Auteurs : </h2>';
                if($musique["id_artiste"] != NULL){
                    afficheSimple("artiste",$artiste["id_artiste"],$artiste["url_photo"],($artiste["prenom"]."   ". $artiste["nom"]),$artiste["date_naissance"]);
                }
                else{
                    afficheSimple("groupe",$groupe["id_groupe"],$groupe["url_image"],$groupe["nom"],$groupe["date_creation"]);
                }

                //feat ici  
                if (!empty($feat)){
                    echo "<h3> Feat : </h3>";
                    foreach($feat as $focus){
                        if ($focus["id_artiste"] != NULL){
                            $feat_focus = RequeteJOIN($bdd,"artiste","feat","id_artiste","artiste.id_artiste",$focus["id_artiste"],"fetch","artiste.*");
                            afficheSimple("artiste",$feat_focus["id_artiste"],$feat_focus["url_photo"],($feat_focus["prenom"]."   ". $feat_focus["nom"]),$feat_focus["date_naissance"]);
                        }
                        if ($focus["id_groupe"] != NULL){
                            $feat_focus = RequeteJOIN($bdd,"groupe","feat","id_groupe","groupe.id_groupe",$focus["id_groupe"],"fetch","groupe.*");
                            afficheSimple("groupe",$focus["id_groupe"],$focus["url_image"],$focus["nom"],$focus["date_creation"]);
                        }
                    }
                }

                if($musique["id_album"] != NULL){
                    echo "<h3> Tirée de l'album : </h3>";
                    // echo '<a href="album.php?id_album='.$album["id_album"].'">'. $album["titre"].'</a></h3>';
                    afficheSimple("album",$album["id_album"],$album["url_cover_alb"],$album["titre"],$album["date_sortie_alb"]);
                }
                if(!empty($musique["parole"])):
            ?>
                <p> Paroles :<br><?php echo nl2br($musique["parole"]);?></p>
            <?php
                endif;
            ?> 
        </div> 
    </main>
    <?php
        afficherFooter();
    ?>
</body>
</html>