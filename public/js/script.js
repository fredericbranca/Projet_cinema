// Fonctions

    // Fonction pour ouvrir le modal
    // Ces fonctions modifient le style css du modal pour le rendre visible ou invisible
    function openModal(modalId) {
        if (modalId === '#modalDelFilm') {
            document.querySelector('.overlay2').style.zIndex = '1';
            document.querySelector('.overlay2').style.opacity = '1';
            document.querySelector(modalId).classList.add('modal-open');
        } else {
            document.querySelector('.overlay').style.zIndex = '1';
            document.querySelector('.overlay').style.opacity = '1';
            document.querySelector(modalId).classList.add('modal-open');
        }
    }
    // Fonction pour fermer le modal
    function closeModal(modalId) {
        if (modalId === '#modalDelFilm') {
            document.querySelector('.overlay2').style.opacity = '0';
            document.querySelector('.overlay2').style.zIndex = '-1';
            document.querySelector(modalId).classList.remove('modal-open');
        } else {
            document.querySelector('.overlay').style.opacity = '0';
            document.querySelector('.overlay').style.zIndex = '-1';
            document.querySelector(modalId).classList.remove('modal-open');
        }
    }

// Ouvrir le modal si le lien contient l'id #modal
window.addEventListener('DOMContentLoaded', function() {

    if (window.location.href.includes('#modalAddFilm')) {
        openModal('#modalAddFilm');
    }
    if (window.location.href.includes('#modalAddCasting')) {
        openModal('#modalAddCasting');
    }
    if (window.location.href.includes('#modalAddGenre')) {
        openModal('#modalAddGenre');
    }
    if (window.location.href.includes('#modalAddRealisateur')) {
        openModal('#modalAddRealisateur');
    }
    if (window.location.href.includes('#modalAddActeur')) {
        openModal('#modalAddActeur');
    }
    if (window.location.href.includes('#modalAddRole')) {
        openModal('#modalAddRole');
    }
});

// Fonction pour ajouter un input d'acteur
function ajouterChampActeur(event) {
    event.preventDefault(); // Empêche le rafraîchissement de la page

    // Créer et ajouter les éléments au conteneur
    const acteurInput = document.createElement('div');
    acteurInput.classList.add('acteur-input');
    acteurInput.innerHTML =   `<input type="text" name="nom[]" placeholder="Nom de l'acteur">
                              <input type="text" name="prenom[]" placeholder="Prénom de l'acteur">
                              <select name="sexe[]">
                              <option value="homme">Homme</option>
                              <option value="femme">Femme</option>
                              </select>
                              <input type="date" name="dateNaissance[]">
                              <input type="text" name="role2[]" placeholder="Rôle de l'acteur">
                              <button class="supprimer-acteur">-</button>`;
    acteursInputContainer.appendChild(acteurInput);
  }

// Fonction pour ajouter un select d'acteur
function ajouterSelectActeur(event) {
    event.preventDefault(); // Empêche le rafraîchissement de la page

    // Construction des options depuis $acteurs
    // valeur par défaut de options
    let options = '<option value="">Sélectionner un acteur</option>';
    // forEach pour parcourir chaque élément du tableau acteursDate (qui correspond à $requeteActeur->fetchAll();)
    acteursData.forEach(function(acteur) {
        options += '<option value="' + acteur.id_acteur + '">' + acteur.name + '</option>';
    });

    // Créer et ajouter les éléments au conteneur
    const acteurSelect = document.createElement('div');
    acteurSelect.classList.add('acteurs-select');
    acteurSelect.innerHTML =   `<select id="idActeur" name="idActeur[]">
                                    ${options}
                                </select>
                                <input type="text" name="role[]" placeholder="Rôle de l'acteur">
                                <button class="supprimer-acteur">-</button>`;
    acteurSelectContainer.appendChild(acteurSelect);
  }

// Fonction pour ajouter un input genre
function ajouterChampGenre(event) {
    event.preventDefault();
    const genreInput = document.createElement('div');
    genreInput.classList.add('genre-input');
    genreInput.innerHTML =  `<input type="text" name="genre[]" placeholder="Nom du genre">
                            <button class="supprimer-genre">-</button>`;
    genresContainer.appendChild(genreInput);
}

// Fonction pour ouvrir le menu déroulant 
function afficherMenuDeroulant(menuId) {
    const menu = document.querySelector(menuId);
    if (menu.style.display === 'none') {
        menu.style.display = 'block';
    } else {
        menu.style.display = 'none';
    }
}

// Fonction vue modifierFilm
    // Fonction pour ajouter un casting
    function ajouterCasting(event) {
        event.preventDefault();

        let optionsActeur = `<option value="">Sélection d'un acteur</option>`;
        acteursData.forEach(function(acteur) {
            optionsActeur += '<option value="' + acteur.id_acteur + '">' + acteur.acteur + '</option>';
        });
        let optionsRole = `<option value="">Sélection d'un rôle</option>`;
        rolesData.forEach(function(role) {
            optionsRole += '<option value="' + role.id_role + '">' + role.role + '</option>';
        });
        const casting = document.createElement('div');
        casting.setAttribute('id', 'casting');
        casting.innerHTML = `<div id="acteurRole">
                                <div class="acteur-select">
                                    <select id="acteur" name="acteur[]">
                                        ${optionsActeur}
                                    </select>
                                </div>
                                <div class="role-select">
                                    <select id="role" name="role[]">
                                        ${optionsRole}
                                    </select>
                                </div>
                            </div>
                            <button id="supprimer-casting">-</button>`;
        modifierFilmCasting.appendChild(casting);
    }

    // Fonction pour le modal de confirmation
    function openModalConfirmation(buttonId) {
        buttonId.preventDefault();

        const button = document.querySelectorAll("[name=",buttonId,"]");
        console.log(button);
        const modal = createElement('div');
        modal.setAttribute('id', 'ModalConfirmSubmit');
        modal.classList.add('modal3 modal-open');
        modal.innerHTML = `<div>Les données entrées précédemment ne seront pas enregistré. Voulez-vous continuer ?</div>
                            <button id="confirm-submit" type="submit>Oui</button>
                            <button onclick="closeModal('#confirm-submit')" class="modal-button">Non</button>`
        const buttonConfirm = document.querySelector('#confirm-submit');
        buttonConfirm.addEventListener('click', function() {
            button.click();
        });
    }
/////////////////////////////////////////////////////////////////

// ModifierFilm view
    // Ajouter un champ casting
    const modifierFilmCasting = document.getElementById('modifierFilmCasting');
    if (modifierFilmCasting) {
        const ajouterDivCasting = document.getElementById('ajouter-casting');

        // Clic sur le bouton d'ajout
        ajouterDivCasting.addEventListener('click', ajouterCasting);

        // Clic sur le bouton de suppression d'acteur
        modifierFilmCasting.addEventListener('click', function(event) {
        event.preventDefault();
        if (event.target.id === 'supprimer-casting') {
            event.target.parentElement.remove();
        }
        });
    }

//Ajouter un input acteur
const acteursInputContainer = document.getElementById('acteurs-input-container');
if (acteursInputContainer) {
    const ajouterActeurButton = document.getElementById('ajouter-acteur');

    // Clic sur le bouton d'ajout
    ajouterActeurButton.addEventListener('click', ajouterChampActeur);

    // Clic sur le bouton de suppression d'acteur
    acteursInputContainer.addEventListener('click', function(event) {
    if (event.target.classList.contains('supprimer-acteur')) {
        event.target.parentElement.remove();
    }
    });
}

//Ajouter un select acteur
const acteurSelectContainer = document.getElementById('acteurs-select-container');
if (acteurSelectContainer) {
    const ajouterActeurButton = document.getElementById('ajouter-select-acteur');

    // Clic sur le bouton d'ajout
    ajouterActeurButton.addEventListener('click', ajouterSelectActeur);

    // Clic sur le bouton de suppression d'acteur
    acteurSelectContainer.addEventListener('click', function(event) {
    if (event.target.classList.contains('supprimer-acteur')) {
        event.target.parentElement.remove();
    }
    });
}

//Ajouter un input genre
const genresContainer = document.getElementById('genres-container');
if (genresContainer) {
    const ajouterGenreButton = document.getElementById('ajouter-genre');

    // Clic sur le bouton d'ajout
    ajouterGenreButton.addEventListener('click', ajouterChampGenre);

    // Clic sur le bouton de suppression d'acteur
    genresContainer.addEventListener('click', function(event) {
    if (event.target.classList.contains('supprimer-genre')) {
        event.target.parentElement.remove();
    }
    });
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
        
        // Décrémente la valeur p et déplace le carrousel vers la gauche
        chevronDroit.onclick=function(){
            p--
            caroussel.style.transform="translate(" + p * 367 + "px)";
        }
    }
}