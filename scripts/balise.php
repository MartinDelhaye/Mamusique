<?php
    // ------------------ Généré les infos du head commun ------------------
    function infometa(){
        echo '
            <meta charset="UTF-8">
            <meta name="author" content="Delhaye Martin" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="apple-touch-icon" sizes="180x180" href="Image/favicon/apple-touch-icon.png">
            <link rel="icon" type="image/png" sizes="32x32" href="Image/favicon/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="16x16" href="Image/favicon/favicon-16x16.png">
            <link rel="manifest" href="Image/favicon/site.webmanifest">
            <!-- Link CSS -->
            <link href="CSS/Style_mamusique.css" rel="stylesheet" type="text/css"> 
            <!-- Link JS -->
            <script src="scripts/script.js"></script>
            ';
    }
    // <link rel="stylesheet" href="https://unpkg.com/chota@latest">
    // ------------------ Header ------------------
    function afficherHeader(){
        echo '<header>
                <a href="index.php" title="retour accueil">'. afficherImage("Image/Logo_Mamusique.png","Logo_Mamusique","logo").'</a>
                <nav>
                    <ul>
                        <li>
                            <a href="liste_artiste.php" id="nav_artiste">Artistes</a>
                        </li>
                        <li>
                            <a href="liste_groupe.php" id="nav_groupe">Groupes</a>
                        </li>
                        <li>
                            <a href="liste_album.php" id="nav_album">Albums</a>
                        </li>
                        <li>
                            <a href="liste_musique.php" id="nav_musique">Musiques</a>
                        </li>
                    </ul>
                </nav>
            </header>'; 
    }
    function afficherHeaderAdmin(){
        echo '<header>
                <a href="index.php" title="retour accueil">'. afficherImage("Image/Logo_Mamusique.png","Logo_Mamusique","logo").'</a>
                <a href="admin.php" id="nav_admin">Admin</a> <br>
                <a href="index.php">Acceuil site</a>
            </header>'; 
    }
    // ------------------ Footer ------------------
    function afficherFooter(){
        echo '<footer class="border_top">
                <a href="index.php" title="retour accueil">'. afficherImage("Image/Logo_Mamusique.png","Logo_Mamusique","logo").'</a>
                
                <button id="theme">Changer thème <span id="iconTheme">N</span></button>
                <div id="jeu" class="border_complet">
                    <h2> Devine mon préféré :  </h2>
                    Choisissez un thème :
                    <select name="Theme" id="choixTheme">
                        <option value="mon artiste">Artiste</option>
                        <option value="mon groupe">Groupe</option>
                        <option value="mon album">Album</option>
                        <option value="ma musique">Musique</option>
                    </select><br>
                    <input type="button" value="Valider" id="ouvrirPopoup">
                    <div id="Resultat"></div>
                </div>
                <a id="retour_top" class="bordure_interaction" href="#" title="Retour haut de la page">'.
                    afficherImage("Image/retourTopBlanc.png","fleche retour Top","retourTopIMG").'
                    Haut de la page
                </a>
                <p id="signature"> &copy; 2024 /Delhaye </p>
            </footer>'; 
    }
    function afficherFooterAdmin(){
        echo '<footer class="border_top">
                <a href="index.php" title="retour accueil">'. afficherImage("Image/Logo_Mamusique.png","Logo_Mamusique","logo").'</a>
                <button id="theme">Changer thème <span id="iconTheme">N</span></button>
                <a id="retour_top" class="bordure_interaction" href="#" title="Retour haut de la page">'.
                    afficherImage("Image/retourTopBlanc.png","fleche retour Top","retourTopIMG").'
                    Haut de la page
                </a>
            </footer>'; 
    }


    // ------------------ Généré une image ------------------
    function afficherImage($url_image,$title_alt, $class){
        return '<img src="'.$url_image.'" class="'.$class.'" alt="Image de '.$title_alt.'" title="Image de '.$title_alt.'" />';
    }
    
        
    // ------------------ Affichage des éléments ------------------
    function afficherListe($tab,$type,$key_id,$key_url_image,$key_who,$key_date){
        echo '<div class="container">';
        foreach($tab as $focus):
            if ($key_id == "id_artiste"){
                $texte_sup = $focus["nom"];
            }
            else{
                $texte_sup = "";
            }
            echo '<a href="'.$type.'.php?id_'.$type.'='.$focus[$key_id].'" class="bloc_info">';
            echo afficherImage($focus[$key_url_image],($focus[$key_who]." ".$texte_sup), "Liste_img");
            
            echo "<div class='info'>";

            echo "<h2>".$focus[$key_who]." ".$texte_sup."</h2> <p>(".$focus[$key_date].")</p>";
            echo '</div>'; 
            echo '</a>'; 
        endforeach;
        echo '</div>'; 
    }


    function afficheSimple($type_auteur,$id_auteur,$url_image_auteur,$who,$date){
        echo '<div class="container">';
        echo '<a href="'.$type_auteur.'.php?id_'.$type_auteur.'='.$id_auteur.'" class="bloc_info">';
        echo afficherImage($url_image_auteur,$who, "Liste_img");
        echo "<div class='info'>";
        echo "<h2>".$who."</h2> <p>(".$date.")</p>";
        echo '</div>'; 
        echo '</a>'; 
        echo '</div>'; 
    }

    // ------------------ Pour ADMIN ------------------

    function afficheoption($id,$text){
        return '<option value="'.$id.'">'.$text.'</option>';
    }

    function afficheFormSelect($What,$id,$tab,$key_nom,$action, $but){
        echo '<div>';
        echo '<h3>'.$but.' '.$What.' : </h3>';
        echo '<form action="'.$action.'" method="POST">'; 
        echo '<select name="'.$id.'" size=10 required="required">';
        foreach($tab as $focus):
            if ($id == "id_artiste"){
                echo afficheoption($focus[$id], ($focus[$key_nom]." ". $focus["nom"]));
            }
            else {
                echo afficheoption($focus[$id], $focus[$key_nom]);
            }
        endforeach;
        echo '</select><br/><br/>';
        echo '<input type="submit" value="'.$but.' '.$What.' "/>';
        echo '</form>';
        echo '</div>';
    }
   
            
                
           
        
?>
