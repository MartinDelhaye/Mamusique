<?php
    include ("scripts/balise.php");
    include ("scripts/requete.php");
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    $tabMusique = obtenirListeComplete($bdd,"musique","titre");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <title>Liste des Musiques</title>
</head>
<body>
    <input type="hidden" name="Where" value="nav_musique" id="where">
    <?php
    afficherHeader();
    ?>
    <main>
        <div class="blocFiltre">
            <h3> Filtre : </h3>
            <form action="liste_musique.php" method="POST">
                <span>Auteur : <input type="checkbox" value="Auteur" name="filtreType" id="filtreType"></span>
                <span>Provenance : <input type="checkbox" value="Provenance" name="filtreType" id="filtreType"></span><br>
                <select name="filtre" size=1 required="required" >
                    <option value="id_musique IS NOT NULL">Aucun filtre </option>
                </select><br>
                <h3 class="border_top"> Ordre : </h3>
                <span>Nom Titre : <input type="checkbox" value="Nom Titre" name="orderType" id="orderType"></span>
                <span>Date  : <input type="checkbox" value="Date" name="orderType" id="orderType"></span> <br>
                <span>Durée  : <input type="checkbox" value="Duree" name="orderType" id="orderType"></span> <br>
                <select name="ordre" size=1 required="required">
                    <option value="id_musique ASC">Indiférents  </option>
                </select><br/><br/>
        </div>
                <input type="submit" value="Valider" class="ValiderFiltre"/>
            </form>
       
        <div class="bloc-principale">
            <?php   
                if (isset($_POST["filtre"])){
                    $tabMusique = listeFiltreOrder($bdd,"musique",$_POST["filtre"],$_POST["ordre"]);
                }
                if(!empty($tabMusique)):
                    echo '<h2>Musiques : </h2>';
                    afficherListe($tabMusique,"musique","id_musique","url_cover_mus","titre","date_sortie_mus");
                endif;
            ?>
        </div>
    </main>
    <?php
        afficherFooter();
    ?>



</body>
</html>