const routes = [
  // { path: '/user', component: require('./components/user/Index.vue') },
  { path: '/customer', component: require('./components/customer/Index.vue') },

  { path: '/deposit/pending', component: require('./components/deposit/pending/Index.vue') },
  { path: '/deposit/approve', component: require('./components/deposit/approve/Index.vue') },
  { path: '/deposit/expire', component: require('./components/deposit/expire/Index.vue') },

  { path: '/withdrawal/pending', component: require('./components/withdrawal/pending/Index.vue') },
  { path: '/withdrawal/approve', component: require('./components/withdrawal/approve/Index.vue') },
  { path: '/withdrawal/cancel', component: require('./components/withdrawal/cancel/Index.vue') },

  // { path: '/plan', component: require('./components/plan/Index.vue') },
  
  { path: '/geneology', component: require('./components/Geneology.vue') },
  { path: '/company/profile', component: require('./components/company/Index.vue') },
  { path: '/page/faq', component: require('./components/pages/faq/Index.vue') },
  { path: '/page/about-us', component: require('./components/pages/about-us/Edit.vue') },
]

export default routes ;