let routes = [
    {
        path: '/email/',
        name: 'encuestas_generadas',
        component: require('./listado.vue'),
        props: true,
        meta: { auth: true }
    },
    {
        path: '/informes/',
        name: 'informes_encuestas',
        component: require('./reportesEncuestas.vue'),
        props: true,
        meta: { auth: true }
    },
   
    // {
    //     path: '/cargadas/nuevo',
    //     name: 'cargadas_nuevo',
    //     component: require('./nuevo.vue'),
    //     meta: { auth: true }
    // },
    {
        path: '/cargadas/editar/:id',
        name: 'cargadas_editar',
        component: require('./editar.vue'),
        props: true,
        meta: { auth: true }
    },
    // {
    //     path: '/cargadas/vista/:id',
    //     name: 'cargadas_vista',
    //     component: require('./vista.vue'),
    //     props: true,
    //     meta: { auth: true }
    // }
]

export default routes