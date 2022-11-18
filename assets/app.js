/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

require('bootstrap');
require('./js/mdb.min.js');

var quantity = document.getElementById("ordered_quantity");
var unitPrice = document.getElementById("unit_price");
var amount = document.getElementById("amount");

quantity.addEventListener('change', function() {
    amount.innerText = parseFloat(unitPrice.innerText) * parseFloat(quantity.value);
})

// start the Stimulus application
import './bootstrap';
