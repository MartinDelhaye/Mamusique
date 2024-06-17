<?php
    include("config/config.php");
    include ("scripts/requete.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);
    // suppression selon ce que contient $_POST
    if(!empty($_POST["id_artiste"])){
        $requete='DELETE FROM artiste WHERE id_artiste='.$_POST["id_artiste"];
        $artiste = obtenirInfoPrecis($bdd,"artiste","id_artiste",$_POST["id_artiste"],"fetch");
        // Vérifier si le fichier existe avant de le supprimer
        if (file_exists($artiste["url_photo"])) {
            // Supprimer le fichier d'image
            unlink($artiste["url_photo"]);
        }
    }
    elseif(!empty($_POST["id_groupe"])){
        $requete='DELETE FROM groupe WHERE id_groupe='.$_POST["id_groupe"];
        $groupe = obtenirInfoPrecis($bdd,"groupe","id_groupe",$_POST["id_groupe"],"fetch");
        // Vérifier si le fichier existe avant de le supprimer
        if (file_exists($groupe["url_image"])) {
            // Supprimer le fichier d'image
            unlink($groupe["url_image"]);
        }
    }
    elseif(!empty($_POST["id_musique"])){
        $requete='DELETE FROM musique WHERE id_musique='.$_POST["id_musique"];
        $musique = obtenirInfoPrecis($bdd,"musique","id_musique",$_POST["id_musique"],"fetch");
        // on ne supprime que l'image si la musique n'est pas dans un album
        if(!isset($musique["id_album"])){
            // Vérifier si le fichier existe avant de le supprimer
            if (file_exists($album["url_cover_mus"])) {
                // Supprimer le fichier d'image
                unlink($album["url_cover_mus"]);
            }
        }
    }
    elseif(!empty($_POST["id_album"])){
        $requete='DELETE FROM album WHERE id_album='.$_POST["id_album"];
        $album = obtenirInfoPrecis($bdd,"album","id_album",$_POST["id_album"],"fetch");
        // Vérifier si le fichier existe avant de le supprimer
        if (file_exists($album["url_cover_alb"])) {
            // Supprimer le fichier d'image
            unlink($album["url_cover_alb"]);
        }
    }
    elseif(!empty($_POST["id_artiste_ajoutMembre"])){
        $requete='DELETE FROM membre WHERE id_artiste='.$_POST["id_artiste_ajoutMembre"];
        ;
    }
    elseif(!empty($_POST["type_feat"])){
        print_r($_POST);
        $requete='DELETE FROM feat WHERE id_'.$_POST["type_feat"].'='.$_POST["id_".$_POST["type_feat"]."_feat"].' AND id_'.$_POST["personne_feat"].'='.$_POST["id_personne_feat"];
    }


    $nbsuppression=$bdd->exec($requete);
    
    header('Location: admin.php');
    exit();

?>