const routes = [
  { path: '/user', component: require('./components/user/Index.vue') },
  { path: '/customer', component: require('./components/customer/Index.vue') },
  { path: '/deposit', component: require('./components/deposit/Index.vue') },
  { path: '/withdrawal/pending', component: require('./components/withdrawal/Index.vue') },
  // { path: '/plan', component: require('./components/plan/Index.vue') },
  { path: '/geneology', component: require('./components/Geneology.vue') },
  { path: '/company/profile', component: require('./components/company/Index.vue') },
]

export default routes ;