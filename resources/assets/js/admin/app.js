require('../bootstrap');
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



import { domain, count, prettyDate, pluralize, isActive, sex } from './core/filter'

Vue.filter('isActive', isActive)
Vue.filter('sex', sex)