<?php

    //Liste de complete d'un table avec un choix pour le trie
    function obtenirListeComplete($bdd,$table,$trier) {
        $requete = 'SELECT * FROM '.$table.' ORDER BY '.$trier;
        $resultats = $bdd->query($requete);
        return $resultats->fetchAll(PDO::FETCH_ASSOC);
    }
    //Liste de complete d'un table avec un filtre 
    function listeFiltreOrder($bdd,$table,$filtre,$trier) {
        $requete = 'SELECT * FROM '.$table.' WHERE '.$filtre.' ORDER BY '.$trier;
        $resultats = $bdd->query($requete);
        return $resultats->fetchAll(PDO::FETCH_ASSOC);
    }
    // Fonction pour obtenir une liste aléatoire d'une table 
    function obtenirListeAleatoire($bdd,$table) {
        $requete = 'SELECT * FROM '.$table.' ORDER BY RAND() LIMIT 3';
        $resultats = $bdd->query($requete);
        return $resultats->fetchAll(PDO::FETCH_ASSOC);
    }
    // Requete cibler
    function obtenirInfoPrecis($bdd,$table,$what,$who,$type_fetch) {
        $requete = 'SELECT * FROM '.$table.' WHERE '.$what.'= '.$who;
        $resultats = $bdd->query($requete);
        return $resultats->$type_fetch(PDO::FETCH_ASSOC);
    }
    // Requete contenant un JOIN
    function RequeteJOIN($bdd,$table,$tableJOIN,$lien_table,$what,$who,$type_fetch,$select) {
        $requete = 'SELECT '.$select.' FROM '.$table.' JOIN '.$tableJOIN.' ON '.$table.'.'.$lien_table.' = '.$tableJOIN.'.'.$lien_table.' WHERE '.$what.'= '.$who;
        $resultats = $bdd->query($requete);
        return $resultats->$type_fetch(PDO::FETCH_ASSOC);
    }
    //Requete avec sous requete 
    function RequeteSousRequete($bdd,$select,$table,$filtre,$sous_select,$sous_table,$sous_filtre) {
        $requete = 'SELECT '.$select.' FROM '.$table.' WHERE '.$filtre.'(SELECT '.$sous_select.' FROM '.$sous_table.' WHERE '.$sous_filtre.')';
        $resultats = $bdd->query($requete);
        return $resultats->fetchAll(PDO::FETCH_ASSOC);
    }
    //Requete avec sous requete et order
    function RequeteSousRequeteORDER($bdd,$select,$table,$filtre,$sous_select,$sous_table,$sous_filtre,$trier){
        $requete = 'SELECT '.$select.' FROM '.$table.' WHERE '.$filtre.'(SELECT '.$sous_select.' FROM '.$sous_table.' WHERE '.$sous_filtre.') ORDER BY '.$trier;
        $resultats = $bdd->query($requete);
        return $resultats->fetchAll(PDO::FETCH_ASSOC);
    }
?>
    


