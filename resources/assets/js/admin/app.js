require('../bootstrap');

require('froala-editor/js/froala_editor.pkgd.min')
// require('froala-editor/css/froala_editor.pkgd.min.css')
// require('font-awesome/css/font-awesome.css')
// require('froala-editor/css/froala_style.min.css')
import VueFroala from 'vue-froala-wysiwyg'
Vue.use(VueFroala)

import Notification from './core/ui/Notification'
Vue.use(Notification)

import routes from './routes';

import store from './store'

Vue.component('passport-clients', require('../components/passport/Clients.vue'));
Vue.component('passport-authorized-clients', require('../components/passport/AuthorizedClients.vue'));
Vue.component('passport-personal-access-tokens', require('../components/passport/PersonalAccessTokens.vue'));

const router = new VueRouter({ routes });

const admin_app = new Vue({
    el: '#admin-app',
    router,
    store,
    render: h => h(require('./components/App.vue'))
});

Vue.material.inkRipple = false;

Vue.material.registerTheme('app', {
    primary: 'cyan',
    accent: 'black'
});

Vue.material.setCurrentTheme('app');



import { 
	domain, count, prettyDate, pluralize, 
	isActive, sex, percentage, currency, precision } from './core/filter'

Vue.filter('isActive', isActive)
Vue.filter('sex', sex)
Vue.filter('percentage', percentage)
Vue.filter('pluralize', pluralize)
Vue.filter('currency', currency)
Vue.filter('precision', precision)