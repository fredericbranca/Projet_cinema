// Fonctions

    // Fonction pour ouvrir le modal
    // Ces fonctions modifient le style css du modal pour le rendre visible ou invisible
    function openModal() {
        document.querySelector('.overlay').style.zIndex = '1';
        document.querySelector('.overlay').style.opacity = '1';
        document.querySelector('.modal').classList.add('modal-open');
    }
    // Fonction pour fermer le modal
    function closeModal() {
        document.querySelector('.overlay').style.opacity = '0';
        document.querySelector('.overlay').style.zIndex = '-1';
        document.querySelector('.modal').classList.remove('modal-open');
    }

// Caroussel, liste des films de la page d'accueil

    // On récupère les éléments HTML
    const caroussel = document.getElementById('caroussel');

if (caroussel) {
    const cards = caroussel.querySelector('.cards');

    if (cards) {
        const chevronGauche = document.getElementById('chevron-gauche');
        const chevronDroit = document.getElementById('chevron-droit');
        
        // Variable pour le déplacement du carrousel, elle détermine la position actuelle du carrousel
        let p = 0;

        // Incrémente la valeur p et déplace le carrousel vers la droite
        chevronGauche.onclick=function(){
            p++
            caroussel.style.transform="translate(" + p * 367 + "px)";
        }
        
        //// Décrémente la valeur p et déplace le carrousel vers la gauche
        chevronDroit.onclick=function(){
            p--
            caroussel.style.transform="translate(" + p * 367 + "px)";
        }
    }
}

// Ouvrir le modal si le lien contient l'id #modal
window.addEventListener('DOMContentLoaded', function() {

    if (window.location.href.includes('#modal')) {
        openModal();
    }
});