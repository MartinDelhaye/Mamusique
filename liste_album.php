<?php
    include ("scripts/balise.php");
    include ("scripts/requete.php");
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    $tabAlbum = obtenirListeComplete($bdd,"album","titre");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <title>Liste des Albums</title>
</head>
<body>
    <input type="hidden" name="Where" value="nav_album" id="where">
    <?php
        afficherHeader();
    ?>
    <main>
        <div class="blocFiltre">
            <h3> Filtre : </h3>
            <form action="liste_album.php" method="POST">
                <span> Auteur : <input type="checkbox" value="Auteur" name="filtreType" id="filtreType"></span><br>
                <select name="filtre" size=1 required="required">
                    <option value="id_album IS NOT NULL">Aucun filtre </option>
                </select><br/><br/>
                <h3 class="border_top"> Ordre : </h3>
                <span>Nom Titre : <input type="checkbox" value="Nom Titre" name="orderType" id="orderType"></span>
                <span>Date  : <input type="checkbox" value="Date" name="orderType" id="orderType"></span> <br>
                <select name="ordre" size=1 required="required">
                    <option value="id_album ASC">Indiférents  </option>
                </select><br/><br/>
        </div>
            <input type="submit" value="Valider" class="ValiderFiltre"/>
        </form>
        <div class="bloc-principale">
            <?php   
                if (isset($_POST["filtre"])){
                    $tabAlbum = listeFiltreOrder($bdd,"album",$_POST["filtre"],$_POST["ordre"]);
                }
                if(!empty($tabAlbum)):
                    echo '<h2>Albums : </h2>';
                    afficherListe($tabAlbum,"album","id_album","url_cover_alb","titre","date_sortie_alb");
                endif;
            ?>
        </div>
    </main>
    <?php
        afficherFooter();
    ?>


</body>
</html>