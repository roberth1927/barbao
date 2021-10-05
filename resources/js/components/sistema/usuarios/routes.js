let routes = [
    {
        path: '/usuarios',
        name: 'usuarios',
        component: require('./listado.vue'),
        meta: { auth: true }
    },
    {
        path: '/usuarios/nuevo',
        name: 'usuarios_nuevo',
        component: require('./nuevo.vue'),
        meta: { auth: true }
    },
    {
        path: '/usuarios/editar/:id',
        name: 'usuarios_editar',
        component: require('./editar.vue'),
        props: true,
        meta: { auth: true }
    },
    {
        path: '/usuarios/vista/:id',
        name: 'usuarios_vista',
        component: require('./vista.vue'),
        props: true,
        meta: { auth: true }
    }
]

export default routes