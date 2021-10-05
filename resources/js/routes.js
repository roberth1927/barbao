import VueRouter from 'vue-router';

import RutasEmpresas from './components/sistema/empresas/routes'
import RutasUsuariosRoles from './components/sistema/roles/routes'
import RutasUsuarios from './components/sistema/usuarios/routes'
import RutasPermisosUsuarios from './components/sistema/permisos/routes'

import RutasEncuestaTipos       from './components/encuestas/tipos/routes'
import RutasEncuestas           from './components/encuestas/encuestas/routes'
import RutasEncuestaPreguntas   from './components/encuestas/preguntas/routes'
import RutasEncuestaGeneradas   from './components/encuestas/generadas/routes'

let rutas = [
    {
        path: '/login',
        name: 'login',
        component: require('./components/login.vue'),
        meta: {auth: false}
    },
    {
        path: '/',
        redirect: 'inicio',
        meta: { auth: true }
    },
    {
        path: '/inicio',
        name: 'inicio',
        component: require('./components/inicio.vue'),
        meta: { auth: true }
    },
    {

        path: '/respuesta_encuestas/:token',
        name: 'respuesta_encuestas',
        props: true,
        component: require('./components/encuestas/responder/formulario.vue'),
        meta: {auth: true}
    },
    

];

var todasRutas = []
todasRutas = todasRutas.concat(rutas, RutasEmpresas, RutasUsuariosRoles, RutasUsuarios, RutasPermisosUsuarios, 
                               RutasEncuestaTipos, RutasEncuestas, RutasEncuestaPreguntas, RutasEncuestaGeneradas)

const routes = todasRutas

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes
  })

  export default router