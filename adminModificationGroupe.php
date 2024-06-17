<?php
    include("config/config.php");
    include ("scripts/requete.php");
    include("scripts/balise.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);


    $groupe = obtenirInfoPrecis($bdd,"groupe","id_groupe",$_POST["id_groupe"],"fetch");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <title>Page de Modification d'Artiste</title>
</head>
<body>
    <?php
        afficherHeaderAdmin();
    ?>
    <main>
        <div class="bloc-principale">
            <h1>Modification du Groupe : <?php echo $groupe["nom"];  ?></h1> 

            <form action="modifierGroupe.php" method="POST" enctype="multipart/form-data">
                <input type="reset" value="Reset vos modifiaction" />  <br/>
                Nom : <input type="text" name="nom" required="required" value="<?php echo $groupe["nom"];?>"/><br/>
                Année de création : <input type="text" name="date_creation" pattern="\d{4}" title="Veuillez entrer une année (format : AAAA)" required="required" value='<?php echo $groupe["nom"]?>'><br/>              
                Photo actuelle : <br>
                <?php echo afficherImage($groupe["url_image"],$groupe["nom"], "illustration"); ?><br>
                <input type="hidden" name="anc_url" value="<?php echo $groupe["url_image"];?>">
                <input type="hidden" name="id_groupe" value="<?php echo $_POST["id_groupe"];?>">
                Nouvelle photo : <input type="file" name="nouvelle_photo"><br>
                <input type="submit" value="Modifier l'artiste"/>
            </form>
        </div>
    </main>

</body>
</html>

