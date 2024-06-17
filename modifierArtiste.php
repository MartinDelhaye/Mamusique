<?php
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    // Vérifie si on ajoute aussi une date de décès 
    if(!empty($_POST["date_mort"])){
        $requete_preparee= $bdd->prepare('UPDATE artiste SET nom=:nom, prenom=:prenom, date_naissance=:date_naissance, date_mort=:date_mort, role=:role, url_photo=:url_photo WHERE id_artiste=:id_artiste;');
        $requete_preparee->bindValue(':date_mort', $_POST["date_mort"], PDO::PARAM_STR);
    }
    else{
        $requete_preparee= $bdd->prepare('UPDATE artiste SET nom=:nom, prenom=:prenom, date_naissance=:date_naissance, role=:role, url_photo=:url_photo WHERE id_artiste=:id_artiste;');
    }
      
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
    $requete_preparee->bindValue(':prenom', $_POST["prenom"], PDO::PARAM_STR);
    $requete_preparee->bindValue(':date_naissance', $_POST["date_naissance"], PDO::PARAM_STR);
    $requete_preparee->bindValue(':role', $_POST["role"], PDO::PARAM_STR);
    $requete_preparee->bindValue(':url_photo', $url_photo, PDO::PARAM_STR); 
    $requete_preparee->bindValue(':id_artiste', $_POST["id_artiste"], PDO::PARAM_INT); 

    $res = $requete_preparee->execute();

    header('Location: admin.php');
    exit();
?>