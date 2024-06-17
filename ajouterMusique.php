<?php
include("config/config.php");
include ("scripts/requete.php");
$bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

if (isset($_POST["id_album"])){
    
    //cover et date de sortie de l'album de la musique
    $infoAlbum = obtenirInfoPrecis($bdd,"album","id_album",$_POST["id_album"],"fetch");
    
    //on récupère directement l'auteur depuis l'album   
    $date= $infoAlbum["date_sortie_alb"];
    $url_cover=$infoAlbum["url_cover_alb"];
    if (isset($infoAlbum["id_artiste"])){
        $requete_preparee= $bdd->prepare('INSERT INTO musique(id_album, id_artiste, titre, duree_mus, parole, url_cover_mus, date_sortie_mus) VALUES (:id_album, :id_artiste, :titre,:duree_mus,:parole,:url_cover_mus,:date_sortie_mus)');
        $requete_preparee->bindValue(':id_album', $_POST["id_album"], PDO::PARAM_STR);
        $requete_preparee->bindValue(':id_artiste', $infoAlbum["id_artiste"], PDO::PARAM_STR);
    }
    elseif (isset($infoAlbum["id_groupe"])){
        $requete_preparee= $bdd->prepare('INSERT INTO musique(id_album, id_groupe, titre, duree_mus, parole, url_cover_mus, date_sortie_mus) VALUES (:id_album, :id_groupe, :titre,:duree_mus,:parole,:url_cover_mus,:date_sortie_mus)');
        $requete_preparee->bindValue(':id_album', $_POST["id_album"], PDO::PARAM_STR);
        $requete_preparee->bindValue(':id_groupe', $infoAlbum["id_groupe"], PDO::PARAM_STR);
    }
}
else{
    
    if (isset($_POST["id_artiste"])){
        $requete_preparee= $bdd->prepare('INSERT INTO musique(id_artiste, titre, duree_mus, parole, url_cover_mus, date_sortie_mus) VALUES (:id_artiste, :titre,:duree_mus,:parole,:url_cover_mus,:date_sortie_mus)');
        $requete_preparee->bindValue(':id_artiste', $_POST["id_artiste"], PDO::PARAM_STR);
    }
    elseif (isset($_POST["id_groupe"])){
        $requete_preparee= $bdd->prepare('INSERT INTO musique(id_groupe, titre, duree_mus, parole, url_cover_mus, date_sortie_mus) VALUES (:id_groupe, :titre,:duree_mus,:parole,:url_cover_mus,:date_sortie_mus)');
        $requete_preparee->bindValue(':id_groupe', $_POST["id_groupe"], PDO::PARAM_STR);
    }    
}

if(isset($_POST["date_sortie_mus"])){
    $date= $_POST["date_sortie_mus"];
}

// Choisir l'url
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["url_cover_mus"])) {
    // Vérifier s'il n'y a pas eu d'erreur lors du téléversement
    if ($_FILES["url_cover_mus"]["error"] === UPLOAD_ERR_OK) {        
        $url_cover = "Image/BDD/" . basename($_FILES["url_cover_mus"]["name"]);
        // Déplacer le fichier téléversé vers le répertoire de destination
        move_uploaded_file($_FILES["url_cover_mus"]["tmp_name"], $url_cover);
    }
}


// Liens entre les valeurs et les paramètres de la requête préparée
$requete_preparee->bindValue(':titre', $_POST["titre"], PDO::PARAM_STR);
$requete_preparee->bindValue(':duree_mus', $_POST["duree_mus"], PDO::PARAM_STR);
$requete_preparee->bindValue(':parole', $_POST["parole"], PDO::PARAM_STR); 
$requete_preparee->bindValue(':url_cover_mus', $url_cover, PDO::PARAM_STR); 
$requete_preparee->bindValue(':date_sortie_mus', $date, PDO::PARAM_STR);

$res = $requete_preparee->execute();

header('Location: admin.php');
exit();

?>
