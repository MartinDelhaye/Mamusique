<?php
include("config/config.php");
$bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

// Vérifier si un fichier a été téléversé
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["url_image"])) {
    // Vérifier s'il n'y a pas eu d'erreur lors du téléversement
    if ($_FILES["url_image"]["error"] === UPLOAD_ERR_OK) {        
        
        $url_cover = "Image/BDD/" . basename($_FILES["url_image"]["name"]);
        
        // Déplacer le fichier téléversé vers le répertoire de destination
        move_uploaded_file($_FILES["url_image"]["tmp_name"], $url_cover);
    }
}

// Vérifie si on ajoute aussi une date de décès 
$requete_preparee= $bdd->prepare('INSERT INTO groupe(nom, date_creation, url_image) VALUES (:nom,:date_creation,:url_image)');


// Liens entre les valeurs et les paramètres de la requête préparée
$requete_preparee->bindValue(':nom', $_POST["nom"], PDO::PARAM_STR);
$requete_preparee->bindValue(':date_creation', $_POST["date_creation"], PDO::PARAM_STR);
$requete_preparee->bindValue(':url_image', $url_cover, PDO::PARAM_STR); 

$res = $requete_preparee->execute();

header('Location: admin.php');
exit();

?>
