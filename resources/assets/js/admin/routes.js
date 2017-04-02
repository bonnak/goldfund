const routes = [
  { path: '/user', component: require('./components/user/Index.vue') },
  { path: '/customer', component: require('./components/customer/Index.vue') },

  { path: '/deposit/pending', component: require('./components/deposit/pending/Index.vue') },

  { path: '/withdrawal/pending', component: require('./components/withdrawal/pending/Index.vue') },
  { path: '/withdrawal/approved', component: require('./components/withdrawal/approved/Index.vue') },
  { path: '/withdrawal/canceled', component: require('./components/withdrawal/canceled/Index.vue') },

  // { path: '/plan', component: require('./components/plan/Index.vue') },
  
  { path: '/geneology', component: require('./components/Geneology.vue') },
  { path: '/company/profile', component: require('./components/company/Index.vue') },
]

export default routes ;