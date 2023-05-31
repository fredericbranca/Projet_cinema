////////////////////////////////////////////// Fonctions //////////////////////////////////////////////

// Fonction pour effectuer le défilement en ajoutant un décalage en px
function scrollToElement(elementId, px) {
    const element = document.getElementById(elementId);
    if (element) {
      const offset = element.offsetTop + px;
      window.scrollTo({
        top: offset,
        behavior: 'smooth' // Ajoute une animation de défilement fluide
      });
    }
  }

  // Fonction pour la durée du message d'alerte avant de le faire disparaître
  function tempAlert(duration, className){
    var msg = document.getElementById(className);
    console.log(msg);
    msg.style.transition = "1s";
    msg.style.opacity = "1";
    setTimeout(function(){
        msg.style.opacity = "0";
    },duration);
}

////////////////////////////////////// Fonction vue accueil //////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Fonction pour masquer ou afficher les chevrons en fonction de la position actuelle
    function afficherChevrons(p) {
        const chevronGauche = document.getElementById('chevron-gauche');
        const chevronDroit = document.getElementById('chevron-droit');
        const cards = caroussel.querySelector('.cards');
        // Initialise l'état des chevrons
        if (p === 0) {
            chevronGauche.style.display = 'none'; // Masquer le chevron de gauche quand p est égal à 0
        } else if (p === cards.children.length - 5 ) {
            chevronDroit.style.display = 'none'; // Masquer le chevron de droite quand p atteint la fin de la liste
        } else {
            chevronGauche.style.display = ''; // Afficher le chevron de gauche dans les autres cas
            chevronDroit.style.display = ''; // Afficher le chevron de droite dans les autres cas
        }
        }

    // Fonction pour mettre à jour le background
    function updateFilmBackground(p) {
        const filmCards = Array.from(document.getElementsByClassName('card-film'));
        const filmBackground = document.getElementById('listFilms');
        
        // Vérifie si la position p est valide
        if (p >= 0 && p < filmCards.length - 4) {
            const filmCard = filmCards[p+2];
            const filmImage = filmCard.querySelector('img');
            const imageUrl = filmImage.getAttribute('src');
            filmBackground.style.backgroundImage = `url(${imageUrl})`;
        }
        }

    // Fonction pour scale une image
    function scaleImg(p) {
        const filmCards = Array.from(document.getElementsByClassName('card-film'));
                // Vérifie si la position p est valide
        if (p >= 0 && p < filmCards.length - 4) {
            const filmCard = filmCards[p+2];
            const filmImage = filmCard.querySelector('img');

            // Supprime la classe "scaled" des images précédentes
            filmCards.forEach(card => {
                const image = card.querySelector('img');
                image.classList.remove('scaled');
            });
            // Ajoute la classe "scaled" à l'image sélectionnée
            filmImage.classList.add('scaled');
        }
    }

////////////////////////////////////// Fonction pour les modals //////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Ces fonctions modifient le style css du modal pour le rendre visible ou invisible
    function openModal(modalId) {
        if (modalId === '#modalDelFilm') {
            document.querySelector('.overlay2').style.zIndex = '2';
            document.querySelector('.overlay2').style.opacity = '1';
            document.querySelector(modalId).classList.add('modal-open');
        } else {
            document.querySelector('.overlay').style.zIndex = '2';
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
        } else if (modalId == '#ModalConfirmSubmit') {
            document.querySelector('.OverlayModalConfirmation').style.display = 'none';
            document.querySelector(modalId).classList.remove('modal-open');
        }
        else {
            document.querySelector('.overlay').style.opacity = '0';
            document.querySelector('.overlay').style.zIndex = '-1';
            document.querySelector(modalId).classList.remove('modal-open');
        }
    }

    // Fonction pour supprimer un modal
    function removeModal(event, modalId) {
        event.preventDefault();
        document.getElementById(modalId).remove();
        document.querySelector('.OverlayModalConfirmation').style.display = 'none';
    }

    // Ouvrir le modal si l'URL contient l'id du modal (#)
    window.addEventListener('DOMContentLoaded', function() {

        if (window.location.href.includes('#modalAddFilm')) {
            openModal('#modalAddFilm');
        }
        if (window.location.href.includes('#modalAddCasting')) {
            openModal('#modalAddCasting');
        }
    });

////////////////////////////////////// Fonction vue admin //////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Fonction pour ajouter un input d'acteur
    function ajouterChampActeur(event) {
        event.preventDefault(); // Empêche le rafraîchissement de la page

        // Créer et ajouter les éléments au conteneur
        const acteurInput = document.createElement('div');
        acteurInput.classList.add('acteur-input');
        acteurInput.innerHTML =   `<input type="text" name="nom[]" placeholder="Nom de l'acteur">
                                <input type="text" name="prenom[]" placeholder="Prénom de l'acteur">
                                <select name="sexe[]">
                                <option value="H">Homme</option>
                                <option value="F">Femme</option>
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

    // Fonction pour afficher ou non un élément html
    function afficherMenuDeroulant(menuId) {
        const menu = document.querySelector(menuId);
        if (menu.style.display === 'none') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    }

    // Fonction pour le modal de confirmation pour supprimer un film
    function openModalConfirmationSupprimerFilm(event, buttonId, titre) {
        event.preventDefault();

        const button = document.getElementById(buttonId);
        let modal = document.getElementById('ModalConfirmSubmit');
        console.log(titre);
        if (!modal) {
            modal = document.createElement('div');
            modal.setAttribute('id', 'ModalConfirmSubmit');
            modal.classList.add('modal3');
            modal.innerHTML = `<div>Voulez vraiment supprimer le film ${titre} ?</div>
                                <button id="confirm-submit" type="submit">Oui</button>
                                <button onclick="removeModal(event, 'ModalConfirmSubmit')" class="modal-button">Non</button>`;
            document.body.appendChild(modal);
        }
        modal.classList.add('modal-open');
        document.querySelector('.OverlayModalConfirmation').style.display = 'block';

        const buttonConfirm = document.querySelector('#confirm-submit');
        if (buttonConfirm) {
            buttonConfirm.addEventListener('click', function() {
                button.click();
            });
        }
    }

////////////////////////////////////// Fonction vue modifierFilm //////////////////////////////////////////////////////////////////////////////////////////////////////////

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

    // Fonction qui check si l'input est rempli
    function checkAndOpenModalConfirmation(event, buttonId, formId) {
        event.preventDefault();

        const form = document.getElementById(formId);
        if (form.checkValidity() == false) {
            return document.getElementById(buttonId).click();
        }
        openModalConfirmation(event, buttonId);
    }

    // Fonction qui créer le modal de confirmation 
    function openModalConfirmation(event, buttonId) {
        event.preventDefault();

        const button = document.getElementById(buttonId);
        let modal = document.getElementById('ModalConfirmSubmit');

        if (!modal) {
            modal = document.createElement('div');
            modal.setAttribute('id', 'ModalConfirmSubmit');
            modal.classList.add('modal3');
            modal.innerHTML = `<div>Les données entrées précédemment ne seront pas enregistré. Voulez-vous continuer ?</div>
                                <button id="confirm-submit" type="submit">Oui</button>
                                <button onclick="closeModal('#ModalConfirmSubmit')" class="modal-button">Non</button>`;
            document.body.appendChild(modal);
        }
        modal.classList.add('modal-open');
        document.querySelector('.OverlayModalConfirmation').style.display = 'block';

        const buttonConfirm = document.querySelector('#confirm-submit');
        if (buttonConfirm) {
            buttonConfirm.addEventListener('click', function() {
                button.click();
            });
        }
    }

/////////////////////////////////////////////////////////////////////// Fonction vue ListFilms ////////////////////////////////////////////////////////////////////////////

// Fonction pour ouvrir/fermer les listes déroulantes au clic
function toggleDropdown(event) {
    var dropdownMenu = event.currentTarget.nextElementSibling; // get next element
    dropdownMenu.classList.toggle('active');
  }

////////////////////////////////////////////////////////////////////////////////////// FIN FONCTION //////////////////////////////////////////////////////////////////////////////////////




/////////////////////////////////////////////////////////////////////// ListFilms view ////////////////////////////////////////////////////////////////////////////
    // Ecouteurs d'événements listes déroulantes
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    if (dropdownToggles) {
      document.addEventListener('DOMContentLoaded', function() {
        dropdownToggles.forEach(function(dropdownToggle) {
          dropdownToggle.addEventListener('click', toggleDropdown);
        });
      });
    }
/////////////////////////////////////////////////////////////////////// ModifierFilm view ////////////////////////////////////////////////////////////////////////////

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

/////////////////////////////////////////////////////////////////////// Admin view ////////////////////////////////////////////////////////////////////////////

    // Ajouter un input acteur
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

    // Défilement au clic sur les lettres
    const letter = document.querySelectorAll('.lettres');
    if (letter) {
        letter.forEach(letter => {
        letter.addEventListener('click', (event) => {
            event.preventDefault();
            const targetId = event.target.getAttribute('href').slice(1);
            scrollToElement(targetId, 50);
        });
        });
    }   

/////////////////////////////////////////////////////////////////////// Vue accueil ///////////////////////////////////////////////////////////////////////

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

            // Initialise l'état des chevrons en appelant la fonction
            afficherChevrons(p);
            updateFilmBackground(p);
            scaleImg(p);

            // Incrémente la valeur p et déplace le carrousel vers la droite
            chevronGauche.onclick=function(){
                p--
                caroussel.style.transform="translate(" + p * -367 + "px)";
                afficherChevrons(p);
                updateFilmBackground(p);
                scaleImg(p);
            }
            
            // Décrémente la valeur p et déplace le carrousel vers la gauche
            chevronDroit.onclick=function(){
                p++
                caroussel.style.transform="translate(" + p * -367 + "px)";
                afficherChevrons(p);
                updateFilmBackground(p);
                scaleImg(p);
            }
        }
    }

    // Défilement au clic sur "Voir les films récent"
    const button = document.querySelectorAll('.headerFilm');
    if (button) {
        button.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const targetId = event.target.getAttribute('href').slice(1);
            scrollToElement(targetId, 90);
        });
        });
    }   