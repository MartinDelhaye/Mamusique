// --------------- Variable Globale ---------------
// Carrousel
let index_MD = 0;
let divV5_MD;
let tabTitre_MD = ["Presentation", "Les artistes", "Les groupes", "Les Albums", "Les Musiques"];
let tabTexte_MD = [
    "Sur ce site, vous retrouverez mes artistes, groupes, albums et musiques préférés.   Pour commencer je vous propose de découvrir 3 exemples de chaque catégorie",
    "Vous pourrez voir la carrière solo des artistes s'ils en ont une. Vous aurez aussi accès à leur(s) groupe(s)",
    "Vous pourrez voir la composition des groupes et certains de leurs albums et certaines de leurs musiques",
    "Vous pourrez voir qui est l'auteur de chaque album, voir si il a été fait en feat, combien de temps dure l'album, quand il est sorti et vous aurez bien sûr accès au titre de ce dernier.",
    "Vous pourrez voir qui est l'auteur de chaque Musique, voir si elle a été fait en feat, combien de temps dure la musique et quand elle est sortie. Vous aurez accès à son album si elle est provient d'un album"
];
let tabFond_MD = ["fond_presentation.jpg", "fond_artiste.jpg", "fond_groupe.jpg", "fond_album.jpg", "fond_musique.jpg"];
let etatActifDefilement_MD = "auto";
let buttonPre_MD;
let buttonPau_MD;
let buttonSui_MD;
let defilAuto_MD;
let divDiapo;
// Changement thème
let themUse_MD = "claire";
let root_MD;
let iconTheme_MD;
// Popup
let themeChoisi_MD;
let popup;
let zoneResultat_MD;
let selectTheme;
// Modifie la nav celon la page où on se trouve 
let recupPage;
// Filtre liste déroulante
// Tableaux pour le filtre
let tabFiltreArtiste_MD = [
    { valueOption: "date_mort IS NULL", texteOption: "Toujour en vie", categorieFiltre: "Etat vie" },
    { valueOption: "date_mort IS NOT NULL", texteOption: "Mort", categorieFiltre: "Etat vie" },
    { valueOption: "IN", texteOption: "A une carrière solo", categorieFiltre: "Carrière solo" },
    { valueOption: "NOT", texteOption: "N'a pas une carrière solo", categorieFiltre: "Carrière solo" }
];
let tabFiltreAlbum_MD = [
    { valueOption: "id_artiste IS NULL", texteOption: "Fait par un groupe", categorieFiltre: "Auteur" },
    { valueOption: "id_groupe IS NULL", texteOption: "Fait par un artiste", categorieFiltre: "Auteur" }
];
let tabFiltreMusique_MD = [
    { valueOption: "id_album IS NULL", texteOption: "Single", categorieFiltre: "Provenance" },
    { valueOption: "id_album IS NOT NULL", texteOption: "Dans un album", categorieFiltre: "Provenance" },
    { valueOption: "id_artiste IS NULL", texteOption: "Faite par un groupe", categorieFiltre: "Auteur" },
    { valueOption: "id_groupe IS NULL", texteOption: "Faite par un artiste", categorieFiltre: "Auteur" }
];
// Tableaux pour l'ordre
let tabOrdreArtiste_MD = [
    { valueOption: "prenom,nom", texteOption: "Prénom (a->z)", categorieFiltre: "Prénom" },
    { valueOption: "prenom DESC,nom DESC", texteOption: "Prénom (z->a)", categorieFiltre: "Prénom" },
    { valueOption: "nom,prenom", texteOption: "Nom (a->z)", categorieFiltre: "Nom" },
    { valueOption: "nom DESC,prenom DESC", texteOption: "Nom (z->a)", categorieFiltre: "Nom" },
    { valueOption: "date_naissance ASC", texteOption: "Date de naissance (Plus vieux ->Plus jeune)", categorieFiltre: "Date" },
    { valueOption: "date_naissance DESC", texteOption: "Date de naissance (Plus jeune ->Plus vieux)", categorieFiltre: "Date" }
];
let tabOrdreGroupe_MD = [
    { valueOption: "nom ASC", texteOption: "Nom (a->z)", categorieFiltre: "Nom" },
    { valueOption: "nom DESC", texteOption: "Nom (z->a)", categorieFiltre: "Nom" },
    { valueOption: "date_creation ASC", texteOption: "Date de création (Plus vieux ->Plus jeune)", categorieFiltre: "Date" },
    { valueOption: "date_creation DESC", texteOption: "Date de création (Plus jeune ->Plus vieux)", categorieFiltre: "Date" }
];
let tabOrdreAlbum_MD = [
    { valueOption: "titre ASC", texteOption: "Titre (a->z)", categorieFiltre: "Nom Titre" },
    { valueOption: "titre DESC", texteOption: "Titre (z->a)", categorieFiltre: "Nom Titre" },
    { valueOption: "date_sortie_alb ASC", texteOption: "Date de sortie (Plus vieux ->Plus récent)", categorieFiltre: "Date" },
    { valueOption: "date_sortie_alb DESC", texteOption: "Date de sortie (Plus récent ->Plus vieux)", categorieFiltre: "Date" }
];
let tabOrdreMusique_MD = [
    { valueOption: "titre ASC", texteOption: "Titre (a->z)", categorieFiltre: "Nom Titre" },
    { valueOption: "titre DESC", texteOption: "Titre (z->a)", categorieFiltre: "Nom Titre" },
    { valueOption: "date_sortie_mus ASC", texteOption: "Date de sortie (Plus vielle ->Plus récente)", categorieFiltre: "Date" },
    { valueOption: "date_sortie_mus DESC", texteOption: "Date de sortie (Plus récente ->Plus vielle)", categorieFiltre: "Date" },
    { valueOption: "duree_mus ASC", texteOption: "Durée (Plus court ->Plus long)", categorieFiltre: "Duree" },
    { valueOption: "duree_mus DESC", texteOption: "Durée (Plus long ->Plus court)", categorieFiltre: "Duree" }
];


// --------------- Fonction ---------------

// Carrousel 
// Fonction pour faire défiler les diapos qui prend en paramêtre un nombre qui définit de combien  on se déplace 
function defilementDiapo_MD(bouge_MD) {
    // On incrémente l'index en lui ajoutant "bouge_MD", de plus si il atteint 5 ou -1 ou repart respectivement à 0 et 4s
    index_MD += bouge_MD;
    if (index_MD == 5) {
        index_MD = 0;
    }
    else if (index_MD == -1) {
        index_MD = 4;
    }
    titreDiapo_MD.textContent = tabTitre_MD[index_MD];
    texteDiapo_MD.textContent = tabTexte_MD[index_MD];
    divDiapo.style.backgroundImage = "url('Image/Diapo/" + tabFond_MD[index_MD] + "')";
}
// fonction qui change l'état entre défilement automatique et manuel
function changeEtatDiapo_MD() {
    switch (etatActifDefilement_MD) {
        case "auto":
            buttonPau_MD.value = "Défilement automatique";
            etatActifDefilement_MD = "pause";
            buttonPre_MD.style.display = "block";
            buttonSui_MD.style.display = "block";
            clearInterval(defilAuto_MD);
            break;
        case "pause":
            buttonPau_MD.value = "Pause";
            etatActifDefilement_MD = "auto";
            buttonPre_MD.style.display = "none";
            buttonSui_MD.style.display = "none";
            defilAuto_MD = setInterval(() => defilementDiapo_MD(1), 3000);
            break;
        default:
            console.log("Il y a une erreur sur l'état de défilement");
            break;
    }
}

// Popup
// Fonction qui affiche la Popup
function afficherPopup_MD() {
    themeChoisi_MD = selectTheme.value;

    let largeurPopup_MD = 500;
    let longueurPopup_MD = 500;
    let left_MD = (window.screen.width - largeurPopup_MD) / 2;
    let top_MD = (window.screen.height - longueurPopup_MD) / 2;
    popup = window.open("Jeu.html", "popup", "width=" + longueurPopup_MD + ",height=" + largeurPopup_MD + ",left=" + left_MD + ",top=" + top_MD);

    popup.addEventListener("load", () => informerPopupCree_MD(themeChoisi_MD));
}
//Fonction qui envoie le thème dans 
function informerPopupCree_MD(themeChoisi_MD) {
    let addResultat_MD = popup.document.getElementById("Theme");
    addResultat_MD.textContent = themeChoisi_MD;
}
// Fonction qui prend en parametre le résultat de la popup 
function afficherResultat_MD(resultat) {
    switch (themeChoisi_MD) {
        case "mon artiste":
            if (resultat == "Steven Wilson") {
                zoneResultat_MD.textContent = "Bien joué, mon artiste préféré est bien Steven Wilson";
            }
            else {
                zoneResultat_MD.textContent = "Dommage " + resultat + " n'est pas mon artiste préféré";
            }
            break;
        case "mon groupe":
            if (resultat == "Red Hot Chili Peppers") {
                zoneResultat_MD.textContent = "Bien joué, mon groupe préféré est bien Red Hot Chilie Peppers";
            }
            else {
                zoneResultat_MD.textContent = "Dommage " + resultat + " n'est pas mon groupe préféré";
            }
            break;
        case "mon album":
            if (resultat == "21st Century Breakdown") {
                zoneResultat_MD.textContent = "Bien joué, mon album préféré est bien 21st Century Breakdown";
            }
            else {
                zoneResultat_MD.textContent = "Dommage " + resultat + " n'est pas mon album préféré";
            }
            break;
        case "ma musique":
            if (resultat == "21 Guns") {
                zoneResultat_MD.textContent = "Bien joué, ma musique préférée est bien 21 Guns";
            }
            else {
                zoneResultat_MD.textContent = "Dommage " + resultat + " n'est pas ma musique préféré";
            }
            break;
        default:
            console.log("Il y a une erreur sur le jeu");
            break;
    }
}
// function pour effacer la zone de rendu
function effaceReponse_MD() {
    zoneResultat_MD.textContent = "";
}
// Changement thème
function changeTheme_MD() {
    switch (themUse_MD) {
        case "claire":
            themUse_MD = "sombre";
            iconTheme_MD.textContent = "v";
            root_MD.style.setProperty('--color-fond', 'black');
            root_MD.style.setProperty('--color-main', '#282828');
            root_MD.style.setProperty('--color-second', '#003049');
            root_MD.style.setProperty('--color-font-hover', 'black');
            root_MD.style.setProperty('--color-hover', '#C6D8D3');
            break;
        case "sombre":
            themUse_MD = "claire";
            iconTheme_MD.textContent = "N";
            root_MD.style.setProperty('--color-fond', '#C6D8D3');
            root_MD.style.setProperty('--color-main', '#003049');
            root_MD.style.setProperty('--color-second', '#CC5803');
            root_MD.style.setProperty('--color-font-hover', 'white');
            root_MD.style.setProperty('--color-hover', '#F7934C');
            break;
        default:
            console.log("Il y a une erreur sur l'état du thème");
            break;
    }
    // Enregistrement du thème actuel dans le stockage local
    localStorage.setItem('theme', themUse_MD);
}
// Définir le thème en fonction de la valeur stockée dans le stockage local lors du chargement de la page
function setThemeFromLocalStorage_MD() {
    let storedTheme = localStorage.getItem('theme');
    if (storedTheme === 'sombre') {
        changeTheme_MD();
    }
}

// fonction  qui change la couleur la nav celon la page. recoit l'id du texte dans le header à modifier 
function indicationPage_MD(page) {
    let headerfocus = document.getElementById(page);
    headerfocus.style.color = "var(--color-second)";
}

// Filtre liste déroulante
function filtreAjour_MD(nameCheckbox_MD, nameListe_MD) {

    let checked_MD = document.querySelectorAll('[name="' + nameCheckbox_MD + '"]:checked');
    let listeDeroulante_MD = document.querySelector('select[name="' + nameListe_MD + '"]');

    // Efface les anciens filtres sauf le premier
    for (let i = listeDeroulante_MD.options.length - 1; i > 0; i--) {
        listeDeroulante_MD.remove(i);
    }
    // Permets de savoir quel tableau d'option on doit prendre en utilisant la variable qui nous permet de savoir sur quel page on se trouve
    let tabFocus_MD;
    switch (recupPage.value) {
        case "nav_artiste":
            if (nameListe_MD == "filtre") {
                tabFocus_MD = tabFiltreArtiste_MD;
            }
            else { tabFocus_MD = tabOrdreArtiste_MD; }
            break;
        case "nav_groupe":
            tabFocus_MD = tabOrdreGroupe_MD;
            break;
        case "nav_album":
            if (nameListe_MD == "filtre") {
                tabFocus_MD = tabFiltreAlbum_MD;
            }
            else { tabFocus_MD = tabOrdreAlbum_MD; }
            break;
        case "nav_musique":
            if (nameListe_MD == "filtre") {
                tabFocus_MD = tabFiltreMusique_MD;
            }
            else { tabFocus_MD = tabOrdreMusique_MD; }
            break;
    }
    // Pour chaque case coché on regarde si 
    for (let i = 0; i < checked_MD.length; i++) {
        for (let j = 0; j < tabFocus_MD.length; j++) {
            if (tabFocus_MD[j].categorieFiltre == checked_MD[i].value) {
                let option = document.createElement("option");
                option.value = tabFocus_MD[j].valueOption;
                option.textContent = tabFocus_MD[j].texteOption;
                listeDeroulante_MD.appendChild(option);
            }
        }
    }
}


// --------------- Fonction se réalisant après le chargement de la page ---------------
function setupListeners_MD() {
    // Carrousel
    divDiapo = document.getElementById("diapo");
    // On fait les actions liés à la diapo que si la div existe. Pour éviter des erreurs sur les autres pages
    if (divDiapo !== null) {
        buttonPau_MD = document.getElementById("Pause");
        buttonPre_MD = document.getElementById("Precedent");
        buttonSui_MD = document.getElementById("Suivant");
        titreDiapo_MD = document.getElementById("titre-diapo_MD");
        texteDiapo_MD = document.getElementById("texte-diapo_MD");
        titreDiapo_MD.textContent = tabTitre_MD[0];
        texteDiapo_MD.textContent = tabTexte_MD[0];
        divDiapo.style.backgroundImage = "url('Image/Diapo/" + tabFond_MD[0] + "')";

        defilAuto_MD = setInterval(() => defilementDiapo_MD(1), 3000);
        buttonPau_MD.addEventListener('click', changeEtatDiapo_MD);
        buttonPre_MD.addEventListener("click", () => defilementDiapo_MD(-1));
        buttonSui_MD.addEventListener("click", () => defilementDiapo_MD(1));
    }
    // Popup
    let boutonPopup_MD = document.getElementById("ouvrirPopoup");
    // Je vérifie que le bouton existe car dans mon admin cela pourra créer des erreurs
    if (boutonPopup_MD !== null) {
        zoneResultat_MD = document.getElementById("Resultat");
        selectTheme = document.getElementById("choixTheme");
        selectTheme.addEventListener('change', effaceReponse_MD);
        boutonPopup_MD.addEventListener('click', afficherPopup_MD);
    }

    // Changement thème
    iconTheme_MD = document.getElementById("iconTheme");
    buttonTheme_MD = document.getElementById("theme");
    root_MD = document.querySelector(':root');
    buttonTheme_MD.addEventListener('click', changeTheme_MD);
    // Récupère le thème actuel
    setThemeFromLocalStorage_MD();

    // Modifie la nav celon la page où on se trouve 
    recupPage = document.getElementById("where");
    if (recupPage !== null) {
        indicationPage_MD(recupPage.value);
    }

    // Filtre liste déroulante
    let filtreCheckbox_MD = document.querySelectorAll('[name="filtreType"]');
    // On véréfie que la liste n'est pas vide car dans le cas contraire cela voudrait dire qu'on est pas sur une page avec des filtres
    if (filtreCheckbox_MD.length > 0) {
        filtreAjour_MD('filtreType', 'filtre');
        for (let i = 0; i < filtreCheckbox_MD.length; i++) {
            filtreCheckbox_MD[i].addEventListener('change', () => filtreAjour_MD('filtreType', 'filtre'));
        }
    }
    let ordreCheckbox_MD = document.querySelectorAll('[name="orderType"]');
    if (ordreCheckbox_MD.length > 0) {
        filtreAjour_MD('orderType', 'ordre');
        for (let i = 0; i < ordreCheckbox_MD.length; i++) {
            ordreCheckbox_MD[i].addEventListener('change', () => filtreAjour_MD('orderType', 'ordre'));
        }
    }



}

// On attend le chargement de la page avant d'appeler la fonction  
window.addEventListener("load", setupListeners_MD);
