let routes = [
    {
        path: '/encuestas',
        name: 'encuestas',
        component: require('./listado.vue'),
        meta: { auth: true }
    },

    {
        path: '/encuestas/vista/:id/:empresas_id',
        name: 'encuestas_vista',
        component: require('./vista.vue'),
        props: true,
        meta: { auth: true }
    },

    {
        path: '/encuestas/editar/:id/:empresas_id',
        name: 'encuestas_editar',
        component: require('./editar.vue'),
        props: true,
        meta: { auth: true }
    },
    
    {
        path: '/encuestas/nuevo',
        name: 'encuestas_nuevo',
        component: require('./nuevo.vue'),
        meta: { auth: true }
    }
   
   
]

export default routes