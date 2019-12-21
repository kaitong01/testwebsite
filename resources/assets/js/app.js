
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.$ = window.jQuery = require('jquery')
require('./bootstrap');
require('selectize');
require('flatpickr');
// require('./jquery-clock-timepicker'); //jquery-clock-timepicker.min.js

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#doc'
});

$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#page-navigation-trigger').click( (evt) => {
        evt.preventDefault();
        $('body').toggleClass('is-pushed-left');

        $.get( '/switch/menu', {status: $('body').hasClass('is-pushed-left')? 1: 0}, function (res) {

            // console.log( res );
        }, 'json');
    });
});
