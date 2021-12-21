Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'metabase-dashboard',
      path: '/metabase-dashboard/:identifier',
      component: require('./components/Tool'),
      props: true,
    },
  ])
})
