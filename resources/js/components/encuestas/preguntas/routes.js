let routes = [
    {
        path: '/encuestas_preguntas',
        name: 'encuestas_preguntas',
        component: require('./listado.vue'),
        meta: { auth: true }
    },
    {
        path: '/encuestas_preguntas/nuevo',
        name: 'encuestas_preguntas_nuevo',
        component: require('./nuevo.vue'),
        meta: { auth: true }
    },
    {
        path: '/encuestas_preguntas/editar/:id/:encuestas_id/:empresas_id',
        name: 'encuestas_preguntas_editar',
        component: require('./editar.vue'),
        props: true,
        meta: { auth: true }
    },
    {
        path: '/encuestas_preguntas/vista/:id/:encuestas_id/:empresas_id',
        name: 'encuestas_preguntas_vista',
        component: require('./vista.vue'),
        props: true,
        meta: { auth: true }
    },
    {
        path: '/encuestas_preguntas/opciones/:encuesta_preguntas_id/:encuestas_id/:empresas_id',
        name: 'encuestas_preguntas_opciones',
        component: require('./opciones.vue'),
        props: true,
        meta: { auth: true }
    },
]

export default routes