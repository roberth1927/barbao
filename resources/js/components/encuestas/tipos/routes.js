let routes = [
    {
        path: '/encuestas_tipos',
        name: 'encuestas_tipos',
        component: require('./listado.vue'),
        meta: { auth: true }
    },
    {
        path: '/encuestas_tipos/nuevo',
        name: 'encuestas_tipos_nuevo',
        component: require('./nuevo.vue'),
        meta: { auth: true }
    },
    {
        path: '/encuestas_tipos/editar/:id',
        name: 'encuestas_tipos_editar',
        component: require('./editar.vue'),
        props: true,
        meta: { auth: true }
    },
    {
        path: '/encuestas_tipos/vista/:id',
        name: 'encuestas_tipos_vista',
        component: require('./vista.vue'),
        props: true,
        meta: { auth: true }
    }
]

export default routes