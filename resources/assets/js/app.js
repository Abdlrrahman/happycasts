
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();

window.notify = function (notification) {
    window.events.$emit('notification', notification)
};

window.handleErrors = function (error) {
    if (error.response.status == 422) {
        window.notify({
            message: 'There was a validation error, Please try again.',
            type: 'danger'
        })
    }

    window.notify({
        message: 'Something went wrong, Please refresh the page.',
        type: 'danger'
    })
};

Vue.component('vue-login', require('./components/Login.vue'));

Vue.component('vue-lessons', require('./components/Lessons.vue'));

Vue.component('vue-notify', require('./components/Notify.vue'));

Vue.component('vue-player', require('./components/Player.vue'));

Vue.component('vue-stripe', require('./components/Stripe.vue'));

Vue.component('vue-update-card', require('./components/UpdateCard.vue'));

const app = new Vue({
    el: '#app'
});
