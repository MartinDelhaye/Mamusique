<?php
    include ("scripts/balise.php");
    include ("scripts/requete.php");
    include("config/config.php");
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);

    $tabArtiste = obtenirListeComplete($bdd,"artiste","prenom, nom");
    $tabGroupe = obtenirListeComplete($bdd,"groupe","nom");
    $tabMusique = obtenirListeComplete($bdd,"musique","titre");
    $tabAlbum = obtenirListeComplete($bdd,"album","titre");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infometa(); ?>
    <title>ADMIN</title>
</head>
<body>
    <input type="hidden" name="Where" value="nav_admin" id="where">
    <?php
        afficherHeaderAdmin();
    ?>
    <main>
        <div class="bloc-principale">
            <h1>Mamusique : Page d'administration</h1>
            <!-- ---------------- Suppression ---------------- -->
            <div class="border_top">
                <h2>Supression :</h2>
                <section>
                    <?php
                        // ---------------- Supprime un Artiste ----------------
                        afficheFormSelect("Artiste","id_artiste",$tabArtiste,"prenom","supprimer.php", "Supprimier");
                        // ---------------- Supprime un Groupe ----------------
                        afficheFormSelect("Groupe","id_groupe",$tabGroupe,"nom","supprimer.php", "Supprimier");
                        // ---------------- Supprime une Musique ----------------
                        afficheFormSelect("Musique","id_musique",$tabMusique,"titre","supprimer.php", "Supprimier");
                        // ---------------- Supprime un Album ----------------
                        afficheFormSelect("Album","id_album",$tabAlbum,"titre","supprimer.php", "Supprimier");
                    ?>
                    <!-- ---------------- Supprime un Membre ---------------- -->
                    <div>
                        <h3>Supprimer un Membre d'un groupe</h3>
                            <form action="admin.php" method="POST">
                                Choissisez le groupe : <br>
                                <select name="id_groupe_supprMembre" size=5>
                                <?php
                                    foreach($tabGroupe as $groupe):
                                        echo afficheoption($groupe["id_groupe"], $groupe["nom"]);
                                    endforeach;
                                ?>
                                </select><br/><br/>
                                <input type="submit" value="Valider le groupe"/>
                            </form>
                            <?php
                                if (isset($_POST["id_groupe_supprMembre"])) : 
                                    $tabArtiste_Membre = RequeteSousRequete($bdd,"*","artiste","id_artiste IN","id_artiste","membre",'id_groupe ='.$_POST["id_groupe_supprMembre"]);
                            ?>
                                    <form action="supprimer.php" method="POST">
                                        <input type="hidden" name="id_groupe_supprMembre" value=<?php echo $_POST["id_groupe_supprMembre"]; ?>>
                                        <select name="id_artiste_ajoutMembre" size=10 required="required">
                                        <?php
                                            foreach($tabArtiste_Membre as $artiste):
                                                echo afficheoption($artiste["id_artiste"], ($artiste["prenom"]."  ". $artiste["nom"]));
                                            endforeach;
                                        ?> 
                                        </select><br/><br/>
                                    
                                        <input type="submit" value="Supprimer le membre"/>
                                    </form>
                                <?php endif; ?>
                    
                            </div>
                    <!-- ---------------- Supprime un Feat ---------------- -->
                    <div>
                        <h3>Supprimer un feat </h3>           
                        <!-- On demande si l'album est fait par un artiste ou par un groupe -->
                        <?php if(!isset($_POST["id_musique_feat"]) && !isset($_POST["id_album_feat"])) :?>
                            <form action="admin.php" method="POST">
                                Vous voulez supprimer un feat sur une musique ou un album :
                                <input type="radio" name="type_feat" value="album" required="required"> Album
                                <input type="radio" name="type_feat" value="musique"> Musique <br/>
                                <input type="submit" value="Valider "/>
                            </form>
                        <?php endif; ?>
                        <?php if(isset($_POST["type_feat"]) && (!isset($_POST["id_musique_feat"]) && !isset($_POST["id_album_feat"]))) :?>
                                <form action="admin.php" method="POST" >
                                <?php if($_POST["type_feat"]=="album") :?>
                                        Veuillez choisir l'album : <select name="id_album_feat" size=10 required="required">
                                        <?php
                                            foreach($tabAlbum as $album):
                                                echo afficheoption($album["id_album"], $album["titre"]);
                                            endforeach;
                                        ?>                    
                                        </select><br/><br/>                       
                                <?php endif;
                                if($_POST["type_feat"]=="musique") :?>
                                        Veuillez choisir la musique : <select name="id_musique_feat" size=10 required="required">
                                        <?php
                                            foreach($tabMusique as $musique):
                                                echo afficheoption($musique["id_musique"], $musique["titre"]);
                                            endforeach;
                                        ?>                    
                                        </select><br/><br/>                       
                                <?php endif; ?>
                            <input type="hidden" name="type_feat" value=<?php echo $_POST["type_feat"]; ?>>
                            <input type="submit" value="Valider"/>
                            </form>
                        <?php endif; ?>
                        <?php
                            if (isset($_POST["id_musique_feat"]) || isset($_POST["id_album_feat"]) ) : 
                        ?>
                                <form action="admin.php" method="POST">
                                    Vous voulez supprimer un feat d'un artiste ou un groupe :
                                    <input type="radio" name="personne_feat" value="artiste" required="required"> Artiste
                                    <input type="radio" name="personne_feat" value="groupe"> Groupe <br/>
                                    <?php
                                        if (isset($_POST["id_musique_feat"])) : 
                                    ?>
                                            <input type="hidden" name="id_musique_feat" value=<?php echo $_POST["id_musique_feat"]; ?>>
                                    <?php 
                                        endif; 
                                    ?>
                                    <?php
                                        if (isset($_POST["id_album_feat"])) : 
                                    ?>
                                            <input type="hidden" name="id_album_feat" value=<?php echo $_POST["id_album_feat"]; ?>>
                                    <?php 
                                        endif; 
                                    ?>
                                    <input type="hidden" name="type_feat" value=<?php echo $_POST["type_feat"]; ?>>
                                    <input type="submit" value="Valider "/>
                                </form>
                        <?php 
                            endif; 
                        ?>
                        <?php
                            if (isset($_POST["personne_feat"])) : 
                                $tabPersonne_feat = RequeteSousRequete($bdd,'*',$_POST["personne_feat"],'id_'.$_POST["personne_feat"].' IN','id_'.$_POST["personne_feat"],'feat','id_'.$_POST["type_feat"].' ='.$_POST["id_".$_POST["type_feat"]."_feat"]);             
                        ?>  
                                <form action="supprimer.php" method="POST">
                                    <select name="id_personne_feat" size=10 required="required">
                                    <?php
                                        foreach($tabPersonne_feat as $personne):
                                            if($_POST["personne_feat"]=="artiste"){
                                                $texte = $personne["prenom"]."  ". $personne["nom"];
                                            }
                                            else{
                                                $texte = $personne["nom"];
                                            }  
                                            print_r($personne);
                                            echo afficheoption($personne["id_".$_POST["personne_feat"]], $texte);
                                        endforeach;
                                    ?> 
                                    </select><br/><br/>

                                    <input type="hidden" name="<?php echo "id_".$_POST["type_feat"]."_feat"; ?>" value=<?php echo $_POST["id_".$_POST["type_feat"]."_feat"]; ?>>
                                    <input type="hidden" name="type_feat" value=<?php echo $_POST["type_feat"]; ?>>
                                    <input type="hidden" name="personne_feat" value=<?php echo $_POST["personne_feat"]; ?>>
                                    <input type="submit" value="Supprimer le feat"/>
                                </form>
                        <?php 
                            endif; 
                        ?>
                        
                        
                        
                    </div> 
                </section>
            </div>
            <!-- ---------------- Ajout ---------------- -->
            <div class="border_top">
                <h2>Ajout :  </h2>
                <section>
                    <!-- Ajout Artiste -->
                    <div>
                        <h3>Ajout d'un artiste</h3>
                        <form action="ajouterArtiste.php" method="POST" enctype="multipart/form-data">
                            Nom : <input type="text" name="nom" required="required" /><br/>
                            Prénom : <input type="text" name="prenom" required="required" /><br/>
                            Date de naissance : <input type="date" name="date_naissance" required="required"/><br/>
                            Date décès(ne pas remplir si vivant) : <input type="date" name="date_mort"/><br/>
                            Role :<textarea name="role" rows="2" cols="30" required="required"></textarea><br/>
                            Photo : <input type="file" name="url_photo" required="required"><br>
                            </select><br/><br/>


                            <input type="submit" value="Ajouter l'artiste"/>
                        </form>
                    </div>
                    <!-- ---------------- Ajout Groupe ---------------- -->
                    <div>
                        <h3>Ajout d'un Groupe</h3>
                        <form action="ajouterGroupe.php" method="POST" enctype="multipart/form-data">
                            Nom : <input type="text" name="nom" required="required" /><br/>
                            Année de création : <input type="text" name="date_creation" pattern="\d{4}" title="Veuillez entrer une année (format : AAAA)" required="required" /><br/>
                            Logo/Image du groupe : <input type="file" name="url_image" required="required"><br>
                            </select><br/><br/>


                            <input type="submit" value="Ajouter le groupe "/>
                        </form>

                        <!-- ---------------- Ajout Membre ---------------- -->
                        <h3>Ajout d'un Membre</h3>
                        <form action="admin.php" method="POST">
                            Choissisez le groupe : <br>
                            <select name="id_groupe_ajoutMembre" size=5 required="required">
                            <?php
                                foreach($tabGroupe as $groupe):
                                    echo afficheoption($groupe["id_groupe"], $groupe["nom"]);
                                endforeach;
                            ?>
                            </select><br/><br/>
                            <input type="submit" value="Valider le groupe"/>
                        </form>
                        <?php
                            if (isset($_POST["id_groupe_ajoutMembre"])) : 
                                $tabArtiste_SansMembre = RequeteSousRequete($bdd,"*","artiste","id_artiste NOT IN","id_artiste","membre",'id_groupe ='.$_POST["id_groupe_ajoutMembre"]);
                        ?>
                                <form action="ajouterMembre.php" method="POST">
                                    <input type="hidden" name="id_groupe_ajoutMembre" value=<?php echo $_POST["id_groupe_ajoutMembre"]; ?>>
                                    <select name="id_artiste_ajoutMembre" size=10 required="required">
                                    <?php
                                        foreach($tabArtiste_SansMembre as $artiste):
                                            echo afficheoption($artiste["id_artiste"], ($artiste["prenom"]."  ". $artiste["nom"]));
                                        endforeach;
                                    ?> 
                                    </select><br/><br/>
                                    Année de rejoint : <input type="text" name="date_rejoint" pattern="\d{4}" title="Veuillez entrer une année (format : AAAA)" required="required" /><br/>
                                
                                    <input type="submit" value="Ajouter le membre"/>
                                </form>
                            <?php endif; ?>
                    </div>
                    <!-- ---------------- Ajout Musique ---------------- -->
                    <div>
                        <h3>Ajout d'une Musique </h3>
                        <form action="admin.php" method="POST">
                                Votre musique fait-elle partie d'un album :
                                <input type="radio" name="album" value="OUI"> Oui
                                <input type="radio" name="album" value="NON"> Non <br/>
                                <input type="submit" value="Valider "/>
                        </form>
                        <?php if(isset($_POST["album"])) : ?>
                            <!-- Dans le cas ou la musqiue vient d'un album -->
                            <?php if($_POST["album"]=="OUI") : ?>
                                <form action="admin.php" method="POST">
                                    Votre musique est-elle sortie avant l'album :
                                    <input type="radio" name="Sortie" value="OUI"> Oui
                                    <input type="radio" name="Sortie" value="NON"> Non <br/>
                                    <input type="hidden" name="album" value=<?php echo $_POST["album"]; ?>>
                                    <input type="submit" value="Valider "/>
                                </form>

                                <!-- Quand le formulaire pour savoir quand est sortie la musique est remplie demande les donner qu'on a besoin  -->
                                <?php if(isset($_POST["Sortie"])) : ?>
                                        <form action="ajouterMusique.php" method="POST">
                                        <?php if($_POST["Sortie"]=="OUI") : ?>
                                                Date de sortie : <input type="date" name="date_sortie_mus" required="required"/><br/>                        
                                        <?php endif; ?>
                                        
                                                Veuillez choisir l'album : <select name="id_album" size=10>
                                                <?php
                                                    foreach($tabAlbum as $album):
                                                        echo afficheoption($album["id_album"], $album["titre"]);
                                                    endforeach;
                                                ?>                    
                                                </select><br/><br/>
                                    
                                            Titre : <input type="text" name="titre" required="required" /><br/>
                                            Duree : <input type="time" name="duree_mus" step="1" require="required" ><br/>
                                            Parole :<textarea name="parole" rows="2" cols="30" required="required"></textarea><br/>
                                            <input type="submit" value="Ajouter le groupe "/>
                                        </form>
                                <?php endif; ?>
                            <?php endif; ?>


                            <!-- Dans le cas ou la musqiue ne vient pas d'un album -->
                            <?php if($_POST["album"]=="NON") : ?>
                                <form action="admin.php" method="POST">
                                    Choissisez le type d'auteur  :
                                    <input type="radio" name="auteur" value="groupe"> Groupe
                                    <input type="radio" name="auteur" value="artiste"> Artiste <br/>
                                    <input type="hidden" name="album" value=<?php echo $_POST["album"]; ?>>
                                    <input type="submit" value="Valider "/>
                                </form>
                                <?php if(isset($_POST["auteur"])) :?>
                                        <form action="ajouterMusique.php" method="POST" enctype="multipart/form-data">
                                        <?php if($_POST["auteur"]=="groupe") : ?>
                                                Veuillez choisir le groupe : <select name="id_groupe" size=10 required="required">
                                                <?php
                                                    foreach($tabGroupe as $groupe):
                                                        echo afficheoption($groupe["id_groupe"], $groupe["nom"]);
                                                    endforeach;
                                                ?>                    
                                                </select><br/><br/>                       
                                        <?php endif;
                                        if($_POST["auteur"]=="artiste") : ?>
                                                Veuillez choisir l'artiste : <select name="id_artiste" size=10>
                                                <?php
                                                    foreach($tabArtiste as $artiste):
                                                        echo afficheoption($artiste["id_artiste"], ($artiste["prenom"]."  ". $artiste["nom"]));
                                                    endforeach;
                                                ?>                    
                                                </select><br/><br/>                       
                                        <?php endif; ?>           
                                    
                                    Titre : <input type="text" name="titre" required="required" /><br/>
                                    Date de sortie : <input type="date" name="date_sortie_mus" required="required"/><br/>
                                    Duree : <input type="time" name="duree_mus" require="required" step="1"><br/>
                                    Parole :<textarea name="parole" rows="2" cols="30" required="required"></textarea><br/>
                                    Cover : <input type="file" name="url_cover_mus" required="required"><br>
                                    <input type="submit" value="Ajouter la musique  "/>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                    </div>
                    <!-- ---------------- Ajout Album ---------------- -->
                    <div>
                        <h3>Ajout d'un Album </h3>           
                        
                        <!-- On demande si l'album est fait par un artiste ou par un groupe -->
                        <form action="admin.php" method="POST">
                            Choissisez le type d'auteur  :
                            <input type="radio" name="auteur_alb" value="groupe"> Groupe
                            <input type="radio" name="auteur_alb" value="artiste"> Artiste <br/>
                            <input type="submit" value="Valider "/>
                        </form>
                        <?php if(isset($_POST["auteur_alb"])) :?>
                            
                                <form action="ajouterAlbum.php" method="POST" enctype="multipart/form-data">
                                <?php if($_POST["auteur_alb"]=="groupe") : ?>
                                        Veuillez choisir le groupe : <select name="id_groupe" size=10 required="required">
                                        <?php
                                            foreach($tabGroupe as $groupe):
                                                echo afficheoption($groupe["id_groupe"], $groupe["nom"]);
                                            endforeach;
                                        ?>                    
                                        </select><br/><br/>                       
                                <?php endif;
                                if($_POST["auteur_alb"]=="artiste") : ?>
                                        Veuillez choisir l'artiste : <select name="id_artiste" size=10 required="required">
                                        <?php
                                            foreach($tabArtiste as $artiste):
                                                echo afficheoption($artiste["id_artiste"], ($artiste["prenom"]."  ". $artiste["nom"]));
                                            endforeach;
                                        ?>                    
                                        </select><br/><br/>                       
                                <?php endif; ?>           
                            
                            Titre : <input type="text" name="titre" required="required" /><br/>
                            Date de sortie : <input type="date" name="date_sortie_alb" required="required"/><br/>
                            Duree : <input type="time" name="duree_alb" require="required" step="1"><br/>
                            Cover : <input type="file" name="url_cover_alb" required="required"><br>
                            <input type="submit" value="Ajouter l'album "/>
                            </form>
                        <?php endif; ?>           
                        
                    </div> 
                    <!-- ---------------- Ajouter un Feat ---------------- -->
                    <div>
                        <h3>Ajouter un feat </h3>           
                        <!-- On demande si l'album est fait par un artiste ou par un groupe -->
                        <?php if(!isset($_POST["modif_type_feat"])) :?>
                            <form action="admin.php" method="POST">
                                Vous voulez ajouter un feat sur une musique ou un album :
                                <input type="radio" name="modif_type_feat" value="album" required="required"> Album
                                <input type="radio" name="modif_type_feat" value="musique"> Musique <br/>
                                <input type="submit" value="Valider "/>
                            </form>
                        <?php endif; ?>

                        <?php if(isset($_POST["modif_type_feat"]) && (!isset($_POST["modif_id_musique_feat"]) && !isset($_POST["modif_id_album_feat"]))) :?>
                            <form action="admin.php" method="POST" >
                            <?php if($_POST["modif_type_feat"]=="album") :?>
                                    Veuillez choisir l'album : <select name="modif_id_album_feat" size=10 required="required">
                                    <?php
                                        foreach($tabAlbum as $album):
                                            echo afficheoption($album["id_album"], $album["titre"]);
                                        endforeach;
                                    ?>                    
                                    </select><br/><br/>                       
                            <?php endif;
                            if($_POST["modif_type_feat"]=="musique") :?>
                                    Veuillez choisir la musique : <select name="modif_id_musique_feat" size=10 required="required">
                                    <?php
                                        foreach($tabMusique as $musique):
                                            echo afficheoption($musique["id_musique"], $musique["titre"]);
                                        endforeach;
                                    ?>                    
                                    </select><br/><br/>                       
                            <?php endif; ?>
                            <input type="hidden" name="modif_type_feat" value=<?php echo $_POST["modif_type_feat"]; ?>>
                            <input type="submit" value="Valider"/>
                            </form>
                        <?php endif; ?>

                        <?php
                            if (isset($_POST["modif_id_musique_feat"]) || isset($_POST["modif_id_album_feat"]) ) : 
                        ?>
                            <form action="admin.php" method="POST">
                                Vous voulez ajouter un feat d'un artiste ou un groupe :
                                <input type="radio" name="modif_personne_feat" value="artiste" required="required"> Artiste
                                <input type="radio" name="modif_personne_feat" value="groupe"> Groupe <br/>
                                <?php
                                    if (isset($_POST["modif_id_musique_feat"])) : 
                                ?>
                                        <input type="hidden" name="modif_id_musique_feat" value=<?php echo $_POST["modif_id_musique_feat"]; ?>>
                                <?php 
                                    endif; 
                                ?>
                                <?php
                                    if (isset($_POST["modif_id_album_feat"])) : 
                                ?>
                                        <input type="hidden" name="modif_id_album_feat" value=<?php echo $_POST["modif_id_album_feat"]; ?>>
                                <?php 
                                    endif; 
                                ?>
                                <input type="hidden" name="modif_type_feat" value=<?php echo $_POST["modif_type_feat"]; ?>>
                                <input type="submit" value="Valider "/>
                            </form>
                        <?php endif; ?>

                        <?php
                            if (isset($_POST["modif_personne_feat"])) : 
                                $tabPersonne_feat = RequeteSousRequete($bdd,'*',$_POST["modif_personne_feat"],'id_'.$_POST["modif_personne_feat"].' NOT IN','id_'.$_POST["modif_personne_feat"],'feat','id_'.$_POST["modif_type_feat"].' ='.$_POST["modif_id_".$_POST["modif_type_feat"]."_feat"]);             
                        ?>  
                            <form action="ajouterFeat.php" method="POST">
                                <select name="modif_id_personne_feat" size=10 required="required">
                                <?php
                                    foreach($tabPersonne_feat as $personne):
                                        if($_POST["modif_personne_feat"]=="artiste"){
                                            $texte = $personne["prenom"]."  ". $personne["nom"];
                                        }
                                        else{
                                            $texte = $personne["nom"];
                                        }  
                                        print_r($personne);
                                        echo afficheoption($personne["id_".$_POST["modif_personne_feat"]], $texte);
                                    endforeach;
                                ?> 
                                </select><br/><br/>

                                <input type="hidden" name="<?php echo "modif_id_".$_POST["modif_type_feat"]."_feat"; ?>" value=<?php echo $_POST["modif_id_".$_POST["modif_type_feat"]."_feat"]; ?>>
                                <input type="hidden" name="modif_type_feat" value=<?php echo $_POST["modif_type_feat"]; ?>>
                                <input type="hidden" name="modif_personne_feat" value=<?php echo $_POST["modif_personne_feat"]; ?>>
                                <input type="submit" value="Ajouter le feat"/>
                            </form>
                        <?php 
                            endif; 
                        ?>
                    
                    </div> 
                </section>
            </div>
            <!-- ---------------- Modification ---------------- -->
            <div class="border_top">
                <h2>Modification :  </h2>
                <section>
                    <?php
                        // Supprimmer un Artiste
                        afficheFormSelect("Artiste","id_artiste",$tabArtiste,"prenom","adminModificationArtiste.php", "Modifier");
                        // Supprimmer un Groupe
                        afficheFormSelect("Groupe","id_groupe",$tabGroupe,"nom","adminModificationGroupe.php", "Modifier");
                        // Supprimmer une Musique
                        afficheFormSelect("Musique","id_musique",$tabMusique,"titre","adminModificationMusique.php", "Modifier");
                        // Supprimmer un Album
                        afficheFormSelect("Album","id_album",$tabAlbum,"titre","adminModificationAlbum.php", "Modifier");
                    ?>
                </section>
            </div>
        </div>
    </main>
    <?php
        afficherFooterAdmin();
    ?>    
</body>
</html>