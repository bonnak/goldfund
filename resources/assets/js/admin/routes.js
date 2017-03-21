const routes = [
  { path: '/user', component: require('./components/user/Index.vue') },
  { path: '/customer', component: require('./components/customer/Index.vue') },
  { path: '/deposit/history', component: require('./components/deposit/HistoryTable.vue') },
  { path: '/plan', component: require('./components/plan/Index.vue') },
  { path: '/geneology', component: require('./components/Geneology.vue') },
]

export default routes ;