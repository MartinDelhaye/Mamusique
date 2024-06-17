<?php
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    

    $requete_preparee= $bdd->prepare('INSERT INTO membre(date_rejoint, id_groupe, id_artiste) VALUES (:date_rejoint, :id_groupe, :id_artiste)');

    // Liens entre les valeurs et les paramètres de la requête préparée
    $requete_preparee->bindValue(':date_rejoint', $_POST["date_rejoint"], PDO::PARAM_STR);
    $requete_preparee->bindValue(':id_groupe', $_POST["id_groupe_ajoutMembre"], PDO::PARAM_INT);
    $requete_preparee->bindValue(':id_artiste', $_POST["id_artiste_ajoutMembre"], PDO::PARAM_INT);

    $res = $requete_preparee->execute();

    header('Location: admin.php');
    exit();

?>
