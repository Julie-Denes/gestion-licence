/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import './styles/components/menu.css';
import './styles/components/boutons.css';
import './styles/components/tableau.css';
import './styles/components/formulaire.css';
import './styles/components/module.css';
import './controller/module-parent.js';
import './controller/intervention-filter.js';

import TomSelect from "tom-select";

document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('.tomselect').forEach((el) => {
    // Crée TomSelect
    new TomSelect(el, {
      plugins: ['remove_button'],
      create: false,
      sortField: {
        field: "text",
        direction: "asc"
      }
    });

    // Masque le select original **après** initialisation
    el.style.display = 'none';
  });
});



console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
