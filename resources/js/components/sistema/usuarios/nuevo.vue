<template>
    <b-container fluid>
        <crud-cabecera titulo="Usuarios" titulo_singular="Usuario" ruta="usuarios_nuevo"></crud-cabecera>
        <b-form @submit="guardarDatos">
            
            <b-form-group id="grupoNombre" label="Nombres y Apellidos:" label-for="name">
                <b-form-input id="name" type="text" v-model="name" @input="$v.name.$touch()"></b-form-input>
                <span v-if="errors.name" class="error-message">{{errors.name[0]}}</span>
                <div v-if="$v.name.$dirty"><p class="error-message" v-if="!$v.name.required">Los nombres y apellidos del usuario son obligatorios</p></div>
            </b-form-group>
            
            <b-form-group id="grupoEmail" label="Email:" label-for="email">
                <b-form-input id="email" type="email" v-model="email" @input="$v.email.$touch()"></b-form-input>
                <span v-if="errors.email" class="error-message">{{errors.email[0]}}</span>
                <div v-if="$v.email.$dirty">
                    <p class="error-message" v-if="!$v.email.required">El email del usuario es obligatorio</p>
                    <p class="error-message" v-if="!$v.email.email">Debe digitar un email valido</p>
                </div>
            </b-form-group>

            <b-form-group id="grupoPassword" label="Contraseña:" label-for="password">
                <b-form-input id="password" type="password" v-model="password" @input="$v.password.$touch()"></b-form-input>
                <span v-if="errors.password" class="error-message">{{errors.password[0]}}</span>
                <div v-if="$v.password.$dirty"><p class="error-message" v-if="!$v.password.required">La contraseña de usuario es obligatoria</p></div>
            </b-form-group>

            <b-form-group id="grupoEmpresa" label="Empresa:" label-for="empresa">
                <b-form-select id="empresa" :options="empresas" v-model="id_empresa" @input="$v.id_empresa.$touch()"></b-form-select>
                <span v-if="errors.id_empresa" class="error-message">{{errors.id_empresa[0]}}</span>
                <div v-if="$v.id_empresa.$dirty"><p class="error-message" v-if="!$v.id_empresa.required">La empresa a la cual pertece el usuario es obligatoria</p></div>
            </b-form-group>

            <b-form-group id="grupoRol" label="Rol:" label-for="rol_id">
                <b-form-select id="rol_id" :options="roles" v-model="rol_id" @input="$v.rol_id.$touch()"></b-form-select>
                <span v-if="errors.rol_id" class="error-message">{{errors.rol_id[0]}}</span>
                <div v-if="$v.rol_id.$dirty"><p class="error-message" v-if="!$v.rol_id.required">El rol del usuario es obligario</p></div>
            </b-form-group>

            <b-form-group id="grupoActivo">
                <b-form-checkbox class="mb-2 mr-sm-2 mb-sm-0" id="activo" v-model="activo" value="1" unchecked-value="0">
                    Activo
                    <span v-if="errors.activo" class="error-message">{{errors.activo[0]}}</span>
                </b-form-checkbox>
            </b-form-group>
            
            <b-button type="submit" variant="primary" :disabled="$v.$invalid">Guardar</b-button>
            <b-button variant="secondary" to="/usuarios">Volver</b-button>
        </b-form>
        <br>
        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>
        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
    import { required, email } from 'vuelidate/lib/validators';
    export default {
        data () {
            return {
                name: '',
                email: '',
                password: '',
                activo : 0,
                id_empresa : null,
                rol_id : null,

                errors : [],
                respuesta : [],
                loading : false,
                empresas : [],
                roles : [],
            }
        },
        validations: {
            name : { required },
            email : { required, email },
            password : { required },
            id_empresa : { required },
            rol_id : { required }
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
                evt.preventDefault();
                this.errors = []
                axios.post('/auth/usuarios', {
                    name: this.name,
                    email: this.email,
                    password : this.password,
                    id_empresa : this.id_empresa,
                    activo : this.activo,
                    rol_id : this.rol_id
                }).then(response => {
                    this.name = null
                    this.email = null
                    this.password = null
                    this.activo = 0
                    this.id_empresa = null
                    this.rol_id = null

                    this.respuesta = response.data
                    this.loading = false
                    return response.data
                }).catch(error => {
                    if (error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                    this.loading = false
                })
            }
        }
    }
</script>