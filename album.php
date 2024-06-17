<?php
    include ("scripts/balise.php");
    include ("scripts/requete.php");
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    $album = obtenirInfoPrecis($bdd,"album","id_album",$_GET["id_album"],"fetch");
    $tableauMusique = obtenirInfoPrecis($bdd,"musique","id_album",$_GET["id_album"],"fetchALL");
    $artiste = RequeteJOIN($bdd,"artiste","album","id_artiste","id_album",$_GET["id_album"],"fetch","*");
    $groupe = RequeteJOIN($bdd,"groupe","album","id_groupe","id_album",$_GET["id_album"],"fetch","*");

    //feat
    $feat = RequeteJOIN($bdd,"feat","album","id_album","feat.id_album",$_GET["id_album"],"fetchALL","feat.*");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <title><?php echo $album["titre"];?></title>
</head>
<body>
    <?php
    afficherHeader();
    ?>
    <main>
        <div class="bloc-principale">
            <?php echo afficherImage($album["url_cover_alb"], $album["titre"], "illustration"); ?>
            
            <h1><?php echo $album["titre"];?></h1>
            <h3><?php echo "Durée : ". $album["duree_alb"];?></h3>
            <h3><?php echo "Date de sortie : ". $album["date_sortie_alb"];?></h3>

            <?php 
                echo '<h2>Auteur : </h2>';
                if($album["id_artiste"] != NULL){
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
                if(!empty($tableauMusique)):
                    echo '<h2>Musiques : </h2>';
                    afficherListe($tableauMusique,"musique","id_musique","url_cover_mus","titre","duree_mus");
                endif;
            ?>
        </div>
    </main>
    <?php
        afficherFooter();
    ?>
</body>
</html>