<?php
    include ("scripts/balise.php");
    include ("scripts/requete.php");
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);
    

    $tabGroupe = obtenirListeComplete($bdd,"groupe","nom");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <title>Liste des Groupes</title>
</head>
<body>
    <input type="hidden" value="nav_groupe" id="where">
    <?php
    afficherHeader();
    ?>
    <main>
        <div class="blocFiltre">
            <h3> Ordre : </h3>
            <form action="liste_groupe.php" method="POST">
                <span>Nom : <input type="checkbox" value="Nom" name="orderType" id="orderType"></span>
                <span>Date  : <input type="checkbox" value="Date" name="orderType" id="orderType"></span> <br>
                <select name="ordre" size=1 required="required">
                    <option value="id_groupe ASC">Indiférents  </option>
                </select><br/><br/>
        </div>
            <input type="submit" value="Valider" class="ValiderFiltre"/>
        </form>
        <div class="bloc-principale">
            <?php   
                if (isset($_POST["ordre"])){
                    $tabGroupe = listeFiltreOrder($bdd,"groupe","id_groupe IS NOT NULL",$_POST["ordre"]);
                }   
            if(!empty($tabGroupe)):
                echo '<h2>Groupes : </h2>';
                afficherListe($tabGroupe,"groupe","id_groupe","url_image","nom","date_creation");
                
            endif;
            ?>
        </div>
    </main>
    <?php
        afficherFooter();
    ?>



</body>
</html>