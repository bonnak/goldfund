//require('./bootstrap');

import Vue from 'vue'

Vue.component('passport-clients', require('./components/passport/Clients.vue'));
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'));
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue'));

Vue.component('example', { template : '<h1>Example</h1>' });


const app = new Vue({
    el: '#app'
});
