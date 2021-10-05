let routes = [
    {
        path: '/empresas',
        name: 'empresas',
        component: require('./listado.vue'),
        meta: { auth: true }
    },
    {
        path: '/empresas/nuevo',
        name: 'empresas_nuevo',
        component: require('./nuevo.vue'),
        meta: { auth: true }
    },
    {
        path: '/empresas/editar/:id',
        name: 'empresas_editar',
        component: require('./editar.vue'),
        props: true,
        meta: { auth: true }
    },
    {
        path: '/empresas/vista/:id',
        name: 'empresas_vista',
        component: require('./vista.vue'),
        props: true,
        meta: { auth: true }
    }
]

export default routes