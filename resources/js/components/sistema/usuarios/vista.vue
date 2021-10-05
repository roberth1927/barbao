<template>
    <b-container fluid>
        <crud-cabecera titulo="Usuarios"></crud-cabecera>
        <b-form>
            
            <b-form-group id="grupoNombre" label="Nombres y Apellidos:" label-for="name">
                <b-form-input id="name" type="text" v-model="name" disabled></b-form-input>
                <span v-if="errors.name" class="text-danger">{{errors.name[0]}}</span>
            </b-form-group>
            
            <b-form-group id="grupoEmail" label="Email:" label-for="email">
                <b-form-input id="email" type="email" v-model="email" disabled></b-form-input>
                <span v-if="errors.email" class="text-danger">{{errors.email[0]}}</span>
            </b-form-group>

            <b-form-group id="grupoEmpresa" label="Empresa:" label-for="empresa">
                <b-form-select id="empresa" :options="empresas" v-model="id_empresa" disabled></b-form-select>
                <span v-if="errors.id_empresa" class="error-message">{{errors.id_empresa[0]}}</span>
            </b-form-group>

            <b-form-group id="grupoRol" label="Rol:" label-for="rol_id">
                <b-form-select id="rol_id" :options="roles" v-model="rol_id" disabled></b-form-select>
                <span v-if="errors.rol_id" class="error-message">{{errors.rol_id[0]}}</span>
            </b-form-group>

            <b-form-group id="grupoActivo">
                <b-form-checkbox class="mb-2 mr-sm-2 mb-sm-0" id="activo" v-model="activo" value="1" unchecked-value="0" disabled>
                    Activo
                    <span v-if="errors.activo" class="text-danger">{{errors.activo[0]}}</span>
                </b-form-checkbox>
            </b-form-group>
            
            <b-button variant="secondary" to="/usuarios">Volver</b-button>
        </b-form>
        <br>
        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>
        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
    export default {
        props: ['id'],
        data () {
            return {
                name : '',
                activo: 0,
                email: '',
                id_empresa : null,
                rol_id : null,

                errors : [],
                respuesta : [],
                empresas: [],
                roles: [],

                loading : false
            }
        },
        mounted() {
            this.getEmpresas();
            this.getRoles();
            this.getDatos();
        },
        methods: {
            getEmpresas: function() {
                this.loading = true
                axios.get('/auth/empresas_activas')
                    .then((response) => {
                        this.empresas =  response.data
                        this.loading = false
                    })
                    .catch((err) => {
                        console.log(err)
                        this.loading = false
                    })
            },
            getRoles: function() {
                this.loading = true
                axios.get('/auth/usuarios/roles/listado')
                    .then((response) => {
                        this.roles =  response.data
                        this.loading = false
                    })
                    .catch((err) => {
                        console.log(err)
                        this.loading = false
                    })
            },
            getDatos: function() {
                this.loading = true
                axios.get('/auth/usuarios/' + this.id)
                    .then((response) => {
                        this.datos =  response.data
                        this.name = this.datos[0].name
                        this.email = this.datos[0].email
                        this.activo = this.datos[0].activo
                        this.id_empresa = this.datos[0].id_empresa
                        this.rol_id = this.datos[0].rol_id

                        this.loading = false
                    })
                    .catch((err) => {
                        console.log(err)
                        this.loading = false
                    })
            }
        }
    }
</script>