<?php
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);
    print_r($_POST);

    $requete_SET = "";
    if (isset($_POST["album_single"])){
        $requete_SET = ', id_album=:id_album ';
        if($_POST["album_single"] == "single"){
            $album = NULL;
        }
        else{
            $album = $_POST["nv_id_album"];
        }
    }
    

    // Défini le nouveau auteur si il existe 
    if (isset($_POST["nv_auteur"])){
        $requete_SET = ',id_groupe=:id_groupe, id_artiste=:id_artiste ';
        if($_POST["nv_auteur"] == "groupe"){
            $groupe = $_POST["nv_id_groupe"];
            $artiste = NULL;
        }
        else{
            $artiste = $_POST["nv_id_artiste"];
            $groupe = NULL;
            
        }
    }

    $requete_preparee= $bdd->prepare('UPDATE musique SET titre=:titre, date_sortie_mus=:date_sortie_mus, parole=:parole, duree_mus=:duree_mus, url_cover_mus=:url_cover_mus'.$requete_SET.' WHERE id_musique=:id_musique;');
    
    
    // Vérifier si un fichier a été téléversé
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["nouvelle_photo"])) {
        // Vérifier s'il n'y a pas eu d'erreur lors du téléversement
        if ($_FILES["nouvelle_photo"]["error"] === UPLOAD_ERR_OK) {
            $url_photo = "Image/BDD/" . basename($_FILES["nouvelle_photo"]["name"]);
            
            // Déplacer le fichier téléversé vers le répertoire de destination
            move_uploaded_file($_FILES["nouvelle_photo"]["tmp_name"], $url_photo);
        }
        else{
            $url_photo = $_POST["anc_url"];
        }
    }
    else{
        $url_photo = $_POST["anc_url"];
    }

    
    // Liens entre les valeurs et les paramètres de la requête préparée
    $requete_preparee->bindValue(':id_musique', $_POST["id_musique"], PDO::PARAM_INT); 
    $requete_preparee->bindValue(':titre', $_POST["titre"], PDO::PARAM_STR);
    $requete_preparee->bindValue(':date_sortie_mus', $_POST["date_sortie_mus"], PDO::PARAM_STR);
    $requete_preparee->bindValue(':parole', $_POST["parole"], PDO::PARAM_STR);
    $requete_preparee->bindValue(':duree_mus', $_POST["duree_mus"], PDO::PARAM_STR);
    $requete_preparee->bindValue(':url_cover_mus', $url_photo, PDO::PARAM_STR);

    if (isset($_POST["nv_auteur"])){
        $requete_preparee->bindValue(':id_artiste', $artiste, PDO::PARAM_INT);
        $requete_preparee->bindValue(':id_groupe', $groupe, PDO::PARAM_INT);

    }
    if (isset($_POST["album_single"])){
        $requete_preparee->bindValue(':id_album', $album, PDO::PARAM_INT);
    }

    $res = $requete_preparee->execute();

    header('Location: admin.php');
    exit();
?>