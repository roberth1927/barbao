let routes = [
    {
        path: '/usuarios_roles',
        name: 'usuarios_roles',
        component: require('./listado.vue'),
        meta: { auth: true }
    },
    {
        path: '/usuarios_roles/nuevo',
        name: 'usuarios_roles_nuevo',
        component: require('./nuevo.vue'),
        meta: { auth: true }
    },
    {
        path: '/usuarios_roles/editar/:id',
        name: 'usuarios_roles_editar',
        component: require('./editar.vue'),
        props: true,
        meta: { auth: true }
    },
    {
        path: '/usuarios_roles/vista/:id',
        name: 'usuarios_roles_vista',
        component: require('./vista.vue'),
        props: true,
        meta: { auth: true }
    }
]

export default routes