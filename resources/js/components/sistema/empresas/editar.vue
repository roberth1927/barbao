<template>
    <b-container fluid>
        <crud-cabecera titulo="Empresas"></crud-cabecera>
        <b-form @submit="guardarEmpresa">

            <b-form-group id="grupoNombre" label="Nombre:" label-for="nombre">
                <b-form-input id="nombre" type="text" v-model="nombre" @input="$v.nombre.$touch()"></b-form-input>
                <span v-if="errors.nombre" class="error-message">{{errors.nombre[0]}}</span>
                <div v-if="$v.nombre.$dirty"><p class="error-message" v-if="!$v.nombre.required">El nombre de la empresa es obligatorio</p></div>
            </b-form-group>

            <b-form-group id="grupoEmail" label="Email:" label-for="email">
                <b-form-input id="email" type="email" v-model="email" @input="$v.email.$touch()"></b-form-input>
                <span v-if="errors.email" class="error-message">{{errors.email[0]}}</span>
                <div v-if="$v.email.$dirty">
                    <p class="error-message" v-if="!$v.email.required">El email de la empresa es obligatorio</p>
                    <p class="error-message" v-if="!$v.email.email">Debe digitar un email valido</p>
                </div>
            </b-form-group>

            <b-form-group id="grupoActiva">
                <b-form-checkbox class="mb-2 mr-sm-2 mb-sm-0" id="activa" v-model="activa" value="1" unchecked-value="0">
                    Activa
                    <span v-if="errors.activa" class="text-danger">{{errors.activa[0]}}</span>
                </b-form-checkbox>
            </b-form-group>

            <b-button type="submit" variant="primary" :disabled="$v.$invalid">Guardar</b-button>
            <b-button variant="secondary" :to="{name: 'empresas'}">Volver</b-button>
        </b-form>
        <br>
        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>
        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
    import { required, email } from 'vuelidate/lib/validators'
    export default {
        props: ['id'],
        data () {
            return {
                nombre : '',
                activa: 0,
                email : '', 
                errors : [],
                respuesta : [],
                empresas: [],
                loading : false,
                tiene : false
            }
        },
        validations: {
            nombre : { required },
            email : { required, email },
        },
        mounted() {
            this.getDatos();
        },
        methods: {
            getDatos: function() {
                this.loading = true
                axios.get('/auth/empresas/' + this.id)
                    .then((response) => {
                        this.empresas =  response.data
                        this.nombre = this.empresas[0].nombre
                        this.activa = this.empresas[0].activa
                        this.email = this.empresas[0].email
                        this.loading = false
                    })
                    .catch((err) => {
                        console.log(err)
                        this.loading = false
                    })
            },
            guardarEmpresa(evt){
                this.loading = true
                evt.preventDefault();
                this.errors = []
                axios.put('/auth/empresas/' + this.id, {
                    nombre: this.nombre,
                    activa: this.activa,
                    email: this.email
                }).then(response => {
                    this.respuesta = response.data
                    this.loading = false
                    return response.data
                }).catch(error => {
                    if (error.response.status == 422){
                        this.errors = error.response.data.errors
                        this.loading = false
                    }
                })
            }
        }
    }
</script>