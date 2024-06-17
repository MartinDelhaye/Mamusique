<?php
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    $requete_preparee= $bdd->prepare('UPDATE groupe SET nom=:nom, date_creation=:date_creation, url_image=:url_image WHERE id_groupe=:id_groupe;');
      
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
    $requete_preparee->bindValue(':nom', $_POST["nom"], PDO::PARAM_STR);
    $requete_preparee->bindValue(':date_creation', $_POST["date_creation"], PDO::PARAM_STR);
    $requete_preparee->bindValue(':url_image', $url_photo, PDO::PARAM_STR); 
    $requete_preparee->bindValue(':id_groupe', $_POST["id_groupe"], PDO::PARAM_INT); 

    $res = $requete_preparee->execute();

    header('Location: admin.php');
    exit();
?>