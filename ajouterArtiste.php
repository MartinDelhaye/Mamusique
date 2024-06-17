<?php
include("config/config.php");
$bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

// Vérifier si un fichier a été téléversé
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["url_photo"])) {
    // Vérifier s'il n'y a pas eu d'erreur lors du téléversement
    if ($_FILES["url_photo"]["error"] === UPLOAD_ERR_OK) {
        
        $url_cover = "Image/BDD/" . basename($_FILES["url_photo"]["name"]);
        
        // Déplacer le fichier téléversé vers le répertoire de destination
        move_uploaded_file($_FILES["url_photo"]["tmp_name"], $url_cover);
    }
}
        

// Vérifie si on ajoute aussi une date de décès 
if(!empty($_POST["date_mort"])){
    $requete_preparee= $bdd->prepare('INSERT INTO artiste(date_mort, nom, prenom, date_naissance, role, url_photo) VALUES (:date_mort, :nom, :prenom, :date_naissance, :role, :url_photo)');
    $requete_preparee->bindValue(':date_mort', $_POST["date_mort"], PDO::PARAM_STR);
}
else{
    $requete_preparee= $bdd->prepare('INSERT INTO artiste(nom, prenom, date_naissance, role, url_photo) VALUES (:nom, :prenom, :date_naissance, :role, :url_photo)');
}

// Liens entre les valeurs et les paramètres de la requête préparée
$requete_preparee->bindValue(':nom', $_POST["nom"], PDO::PARAM_STR);
$requete_preparee->bindValue(':prenom', $_POST["prenom"], PDO::PARAM_STR);
$requete_preparee->bindValue(':date_naissance', $_POST["date_naissance"], PDO::PARAM_STR);
$requete_preparee->bindValue(':role', $_POST["role"], PDO::PARAM_STR);
$requete_preparee->bindValue(':url_photo', $url_cover, PDO::PARAM_STR); 

$res = $requete_preparee->execute();

header('Location: admin.php');
exit();

?>
