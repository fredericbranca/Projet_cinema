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