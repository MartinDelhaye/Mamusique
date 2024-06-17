function fermerPopup_MD() {
    window.close();
}

function jeuReponse_MD() {
    let reponse_MD = document.getElementById("reponse").value;
    // Envoyer le message à la fenêtre principale
    window.opener.afficherResultat_MD(reponse_MD);
    fermerPopup_MD();
}

function setupListeners_MD() {
    let boutonPopup_MD = document.getElementById("fermerPopup");
    let boutonAbandonPopup_MD = document.getElementById("arreterJeu");

    boutonPopup_MD.addEventListener('click', jeuReponse_MD);
    boutonAbandonPopup_MD.addEventListener('click', fermerPopup_MD);
}

window.addEventListener('load', setupListeners_MD);
