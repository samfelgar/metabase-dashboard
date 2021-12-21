Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'metabase-dashboard',
      path: '/metabase-dashboard',
      component: require('./components/Tool'),
    },
  ])
})
