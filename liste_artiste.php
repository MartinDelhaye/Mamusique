<?php
    include ("scripts/balise.php");
    include ("scripts/requete.php");
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);
    

    $tabArtiste = obtenirListeComplete($bdd,"artiste","prenom, nom");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <title>Liste des Artistes</title>
</head>
<body>
    <input type="hidden" name="Where" value="nav_artiste" id="where">
    <?php
        afficherHeader();
    ?>
    <main>
        <div class="blocFiltre">
            <h3> Filtre : </h3>
            <form action="liste_artiste.php" method="POST">
                <span> Etat vie  : <input type="checkbox" value="Etat vie" name="filtreType" id="filtreType"></span>
                <span> Carrière solo : <input type="checkbox" value="Carrière solo" name="filtreType" id="filtreType"></span> <br>
                <select name="filtre" size=1 required="required">
                    <option value="id_artiste IS NOT NULL">Aucun filtre </option>
                </select><br/><br/>
                <h3 class="border_top"> Ordre : </h3>
                <span>Prénom : <input type="checkbox" value="Prénom" name="orderType" id="orderType"></span>
                <span>Nom : <input type="checkbox" value="Nom" name="orderType" id="orderType"></span>
                <span>Date  : <input type="checkbox" value="Date" name="orderType" id="orderType"></span> <br>
                <select name="ordre" size=1 required="required">
                    <option value="id_musique ASC">Indiférents  </option>
                </select><br/><br/>
        </div>
            <input type="submit" value="Valider" class="ValiderFiltre"/>
        </form>
        <div class="bloc-principale">
            <?php   
                if (isset($_POST["filtre"])){
                    if($_POST["filtre"] == "NOT IN" || $_POST["filtre"] == "IN"){
                        $tabArtiste = RequeteSousRequeteORDER($bdd,"*","artiste","id_artiste ".$_POST["filtre"],"id_artiste","musique","id_artiste IS NOT NULL",$_POST["ordre"]);
                    }
                    else{
                        $tabArtiste = listeFiltreOrder($bdd,"artiste",$_POST["filtre"],$_POST["ordre"]);
                    }
                    
                } 
                if(!empty($tabArtiste)):
                    echo '<h2>Artistes : </h2>';
                    afficherListe($tabArtiste,"artiste","id_artiste","url_photo","prenom","date_naissance");
                endif;
            ?>
        </div>
    </main>
    <?php
        afficherFooter();
    ?>



</body>
</html>