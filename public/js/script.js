// Fonctions

    // Fonction pour ouvrir le modal
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

const caroussel = document.getElementById('caroussel');
const cards = caroussel.querySelector('.cards');

const chevronGauche = document.getElementById('chevron-gauche');
const chevronDroit = document.getElementById('chevron-droit');

p = 0;

chevronGauche.onclick=function(){
    p++
    caroussel.style.transform="translate(" + p * 367 + "px)";
}
  
chevronDroit.onclick=function(){
    p--
    caroussel.style.transform="translate(" + p * 367 + "px)";
}