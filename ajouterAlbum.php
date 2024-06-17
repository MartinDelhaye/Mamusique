<?php
include("config/config.php");
$bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);


if (isset($_POST["id_artiste"])){
    $requete_preparee= $bdd->prepare('INSERT INTO album(id_artiste, titre, duree_alb, url_cover_alb, date_sortie_alb) VALUES (:id_artiste, :titre,:duree_alb,:url_cover_alb,:date_sortie_alb)');
    $requete_preparee->bindValue(':id_artiste', $_POST["id_artiste"], PDO::PARAM_STR);
}
elseif (isset($_POST["id_groupe"])){
    $requete_preparee= $bdd->prepare('INSERT INTO album(id_groupe, titre, duree_alb, url_cover_alb, date_sortie_alb) VALUES (:id_groupe, :titre,:duree_alb,:url_cover_alb,:date_sortie_alb)');
    $requete_preparee->bindValue(':id_groupe', $_POST["id_groupe"], PDO::PARAM_STR);
}    

//enregistre l'image dans le dossier BDD qui est dans le dossier Image
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["url_cover_alb"])) {
    // Vérifier s'il n'y a pas eu d'erreur lors du téléversement
    if ($_FILES["url_cover_alb"]["error"] === UPLOAD_ERR_OK) {        
        $url_cover = "Image/BDD/" . basename($_FILES["url_cover_alb"]["name"]);
        // Déplacer le fichier téléversé vers le répertoire de destination
        move_uploaded_file($_FILES["url_cover_alb"]["tmp_name"], $url_cover);
    }
}


// Liens entre les valeurs et les paramètres de la requête préparée
$requete_preparee->bindValue(':titre', $_POST["titre"], PDO::PARAM_STR);
$requete_preparee->bindValue(':duree_alb', $_POST["duree_alb"], PDO::PARAM_STR);
$requete_preparee->bindValue(':url_cover_alb', $url_cover, PDO::PARAM_STR); 
$requete_preparee->bindValue(':date_sortie_alb', $_POST["date_sortie_alb"], PDO::PARAM_STR);

$res = $requete_preparee->execute();

header('Location: admin.php');
exit();

?>
