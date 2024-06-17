<?php
    include("config/config.php");
    include ("scripts/requete.php");
    include("scripts/balise.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    $artiste = obtenirInfoPrecis($bdd,"artiste","id_artiste",$_POST["id_artiste"],"fetch");
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
            <h1>Modification de l'artiste : <?php echo $artiste["nom"]." ".$artiste["prenom"];  ?></h1> 

            <form action="modifierArtiste.php" method="POST" enctype="multipart/form-data">
                <input type="reset" value="Reset vos modifiaction" />  <br/>
                Nom : <input type="text" name="nom" required="required" value="<?php echo $artiste["nom"];?>"/><br/>
                Prénom : <input type="text" name="prenom" required="required" value="<?php echo $artiste["prenom"];?>"><br/>
                Date de naissance : <input type="date" name="date_naissance" required="required" value="<?php echo $artiste["date_naissance"];?>"/><br/>
                Date décès(ne pas remplir si vivant) : <input type="date" name="date_mort" value="<?php echo $artiste["date_mort"];?>"/><br/>
                Role :<textarea name="role" rows="2" cols="30" required="required"><?php echo $artiste["role"];?></textarea><br/>
                Photo actuelle : <br>
                <?php echo afficherImage($artiste["url_photo"],($artiste["nom"]." ".$artiste["prenom"]), "illustration"); ?><br>
                <input type="hidden" name="anc_url" value="<?php echo $artiste["url_photo"];?>">
                <input type="hidden" name="id_artiste" value="<?php echo $_POST["id_artiste"];?>">
                Nouvelle photo : <input type="file" name="nouvelle_photo"><br>
                <input type="submit" value="Modifier l'artiste"/>
            </form>
        </div>
    </main>
</body>
</html>

