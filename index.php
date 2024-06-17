<?php
    include ("scripts/balise.php");
    include ("scripts/requete.php");
    include("config/config.php");  
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    $tabArtiste = obtenirListeAleatoire($bdd, "artiste");
    $tabGroupe = obtenirListeAleatoire($bdd, "groupe");
    $tabMusique = obtenirListeAleatoire($bdd, "musique");
    $tabAlbum = obtenirListeAleatoire($bdd, "album");
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <title>Acceuil</title>
</head>
<body>
    <?php
        afficherHeader();
    ?>
    <main>
        <div id="diapo">
            <img class="arrow left-arrow" alt="Une image" src="Image/Diapo/fleche_gauche.png"  id="Precedent"> 
            <h1 id="titre-diapo_MD"> Titre </h1>
            <p id="texte-diapo_MD"> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui eveniet, quos, illo dolorum laboriosam eos consectetur atque architecto rerum culpa corrupti hic, nihil optio alias sed laudantium voluptatibus ab tempore.</p>
            <img class="arrow right-arrow" alt="Une image" src="Image/Diapo/fleche_droite.png"  id="Suivant"> 

            <div id="filtre"></div>
        </div>

        <input type="button" value="Pause" id="Pause"><br>

        <div class="bloc-principale">
            <?php
                if(!empty($tabArtiste)):
                    echo '<h2>Artistes : </h2>';
                    afficherListe($tabArtiste,"artiste","id_artiste","url_photo","prenom","date_naissance");
                endif;
                if(!empty($tabGroupe)):
                    echo '<h2>Groupes : </h2>';
                    afficherListe($tabGroupe,"groupe","id_groupe","url_image","nom","date_creation");
                endif;
                if(!empty($tabAlbum)):
                    echo '<h2>Albums : </h2>';
                    afficherListe($tabAlbum,"album","id_album","url_cover_alb","titre","date_sortie_alb");
                endif;
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