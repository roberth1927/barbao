<template>
    <b-container fluid>
        <crud-cabecera titulo="Permisos de Usuario"></crud-cabecera>
        <b-form @submit="guardarDatos">

            <b-form-group id="grupoEmpresa" label="Empresa:" label-for="empresa">
                <b-form-select id="empresa" :options="empresas" v-model="id_empresa" @input="$v.id_empresa.$touch()" @change="limpiar_datos"></b-form-select>
                <span v-if="errors.id_empresa" class="error-message">{{errors.id_empresa[0]}}</span>
                <div v-if="$v.id_empresa.$dirty"><p class="error-message" v-if="!$v.id_empresa.required">La empresa a la cual pertece el usuario es obligatoria</p></div>
            </b-form-group>

            <b-form-group id="grupoRol" label="Rol:" label-for="rol_id">
                <b-form-select id="rol_id" :options="roles" v-model="rol_id" @input="$v.rol_id.$touch()"></b-form-select>
                <span v-if="errors.rol_id" class="error-message">{{errors.rol_id[0]}}</span>
                <div v-if="$v.rol_id.$dirty"><p class="error-message" v-if="!$v.rol_id.required">El rol del usuario es obligario</p></div>
            </b-form-group>
            
            <b-form-group v-if="id_empresa && rol_id" id="grupoNombre" label="Módulo:" label-for="nombre">
                <b-form-select id="modulo" :options="modulos" v-model="modulo"></b-form-select>
                <span v-if="errors.modulo" class="error-message">{{errors.modulo[0]}}</span>
                <div v-if="$v.modulo.$dirty"><p class="error-message" v-if="!$v.modulo.required">El nombre del rol es obligatorio</p></div>
            </b-form-group>

            <b-form-group v-if="modulo" label="Sub módulo:" label-for="sub_modulo">
                <b-form-select v-if="modulo" id="sub_modulo" :options="subModulos[modulo]" v-model="sub_modulo" @change="cargar_permisos"></b-form-select>
                <span v-if="errors.sub_modulo" class="error-message">{{errors.sub_modulo[0]}}</span>
                <div v-if="$v.sub_modulo.$dirty"><p class="error-message" v-if="!$v.sub_modulo.required">El nombre del rol es obligatorio</p></div>
            </b-form-group>

            <b-form-group v-if="sub_modulo" id="grupoPermisos" label="Permisos disponibles:">
                <b-form-checkbox-group stacked v-model="permiso" name="permiso" :options="permisos[sub_modulo]">
                </b-form-checkbox-group>
            </b-form-group>
            
            <b-button type="submit" variant="primary" :disabled="$v.$invalid">Guardar</b-button>
        </b-form>
        <br>
        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>
        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
    import { required } from 'vuelidate/lib/validators';

    import json_modulos from './modulos.json';
    import json_sub_modulos from './sub_modulos.json';
    import json_permisos from './permisos.json';

    export default {
        data () {
            return {
                //Campos del formulario usados para envio de datos
                id_empresa: null,
                rol_id: null,
                modulo : null,
                sub_modulo : null,
                permiso : [],

                errors : [],
                empresas: [],
                roles: [],
                modulos : json_modulos,
                subModulos : json_sub_modulos,
                permisos: json_permisos,
                permiso_id : 0,

                respuesta : [],
                loading : false,
                datos : [],
            }
        },
        validations: {
            id_empresa : { required },
            rol_id : { required },
            modulo : { required },
            sub_modulo : { required },
        },
        mounted() {
            this.getEmpresas();
            this.getRoles();
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
            guardarDatos(evt){
                this.loading = true
                evt.preventDefault()
                this.errors = []
                axios.post('/auth/usuarios/permisos', {
                    id_empresa: this.id_empresa,
                    rol_id: this.rol_id,
                    modulo: this.modulo,
                    sub_modulo: this.sub_modulo,
                    permisos: this.permiso,
                }).then(response => {
                    this.respuesta = response.data
                    this.loading = false
                    return response.data
                }).catch(error => {
                    if (error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                    this.loading = false
                })
            },
            limpiar_datos(){
                this.rol_id = null
                this.modulo = null
                this.sub_modulo = null
                this.permiso = null
            },
            cargar_permisos($ev){
                this.permiso_id = 0
                this.permiso = []
                this.loading = true
                axios.get('/auth/usuarios/permisos/' + this.id_empresa + '/' + this.rol_id  + '/' + $ev)
                    .then((response) => {
                        if ( response.data.length > 0 ) {
                            this.permiso = response.data
                        }
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