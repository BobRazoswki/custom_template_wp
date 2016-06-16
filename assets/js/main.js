function openBurger() {
  var menu = document.getElementsByClassName("nav");
  menu[0].classList.add("translate0");
}

function closeBurger() {
  var menu = document.getElementsByClassName("nav");
  menu[0].classList.remove("translate0");
}

document.addEventListener("DOMContentLoaded", function(event) {

  var menu    = document.getElementsByClassName("nav");
  var menuElement = menu[0];
  var menuElementFirstOfChild = menuElement.firstChild;
  // Ou alors rajouter une li dans le menu avec burger__cross
  var li = document.createElement("li");
  menuElement.insertBefore( li, menuElementFirstOfChild );
  // A rajouter dans le lien créer dans le BO
  menuElementFirstOfChild.innerHTML = "<i class='fa fa-times' aria-hidden='true'></i>";
  menuElementFirstOfChild.classList.add("burger__cross");
  // A garder de toute les facon
  var att = document.createAttribute("onclick");
  att.value = "closeBurger()";
  menuElementFirstOfChild.setAttributeNode(att);
});
