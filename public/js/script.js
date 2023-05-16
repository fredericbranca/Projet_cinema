// Fonctions

    // Fonction pour ouvrir le modal
    // Ces fonctions modifient le style css du modal pour le rendre visible ou invisible
    function openModal(modalId) {
        document.querySelector('.overlay').style.zIndex = '1';
        document.querySelector('.overlay').style.opacity = '1';
        document.querySelector(modalId).classList.add('modal-open');
    }
    // Fonction pour fermer le modal
    function closeModal(modalId) {
        document.querySelector('.overlay').style.opacity = '0';
        document.querySelector('.overlay').style.zIndex = '-1';
        document.querySelector(modalId).classList.remove('modal-open');
    }

// Ouvrir le modal si le lien contient l'id #modal
window.addEventListener('DOMContentLoaded', function() {

    if (window.location.href.includes('#modalAddFilm')) {
        openModal('#modalAddFilm');
    }
    if (window.location.href.includes('#modalAddCasting')) {
        openModal('#modalAddCasting');
    }
});

// Fonction pour ajouter un input d'acteur
function ajouterChampActeur(event) {
    event.preventDefault(); // Empêche le rafraîchissement de la page
    const acteurInput = document.createElement('div');
    acteurInput.classList.add('acteur-input');
    acteurInput.innerHTML =   `<input type="text" name="acteur[]" placeholder="Nom de l&apos;acteur">
                              <input type="text" name="prenom[]" placeholder="Prénom de l'acteur">
                              <select name="sexe[]">
                              <option value="homme">Homme</option>
                              <option value="femme">Femme</option>
                              </select>
                              <input type="date" name="dateNaissance[]">
                              <input type="text" name="role[]" placeholder="Rôle de l'acteur">
                              <button class="supprimer-acteur">-</button>`;
    acteursContainer.appendChild(acteurInput);
  }

/////////////////////////////////////////////////////////////////

const acteursContainer = document.getElementById('acteurs-container');
const ajouterActeurButton = document.getElementById('ajouter-acteur');

// Clic sur le bouton d'ajout
ajouterActeurButton.addEventListener('click', ajouterChampActeur);

// Clic sur le bouton de suppression d'acteur
acteursContainer.addEventListener('click', function(event) {
  if (event.target.classList.contains('supprimer-acteur')) {
    event.target.parentElement.remove();
  }
});



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