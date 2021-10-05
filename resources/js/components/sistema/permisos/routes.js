let routes = [
    {
        path: '/usuarios_permisos',
        name: 'usuarios_permisos',
        component: require('./permisos.vue'),
        meta: { auth: true }
    }
]

export default routes