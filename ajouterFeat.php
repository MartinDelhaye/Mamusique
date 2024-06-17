<?php
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    print_r($_POST);

    $requete_preparee= $bdd->prepare('INSERT INTO feat(id_'.$_POST["modif_type_feat"].', id_'.$_POST["modif_personne_feat"].') VALUES (:id_type, :id_personne)');

    // Liens entre les valeurs et les paramètres de la requête préparée
    $requete_preparee->bindValue(':id_type', $_POST["modif_id_".$_POST["modif_type_feat"]."_feat"], PDO::PARAM_INT);
    $requete_preparee->bindValue(':id_personne', $_POST["modif_id_personne_feat"], PDO::PARAM_INT);

    $res = $requete_preparee->execute();

    header('Location: admin.php');
    exit();

?>
