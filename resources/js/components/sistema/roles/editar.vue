<template>
    <b-container fluid>
        <crud-cabecera titulo="Roles de Usuarios"></crud-cabecera>
        <b-form @submit="guardarDatos">
            
            <b-form-group id="grupoNombre" label="Nombre Rol:" label-for="nombre">
                <b-form-input id="nombre" type="text" v-model="nombre" @input="$v.nombre.$touch()"></b-form-input>
                <span v-if="errors.nombre" class="error-message">{{errors.nombre[0]}}</span>
                <div v-if="$v.nombre.$dirty"><p class="error-message" v-if="!$v.nombre.required">El nombre del rol es obligatorio</p></div>
            </b-form-group>
            
            <b-button type="submit" variant="primary" :disabled="$v.$invalid">Guardar</b-button>
            <b-button variant="secondary" :to="{name: 'usuarios_roles'}">Volver</b-button>
        </b-form>
        <br>
        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>
        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
    import { required } from 'vuelidate/lib/validators';
    export default {
        props: ['id'],
        data () {
            
            return {
                nombre : '',
                
                errors : [],
                respuesta : [],
                datos: [],
                loading : false
            }
        },
        validations: {
            nombre : { required }
        },
        mounted() {
            this.getDatos();
        },
        methods: {
            getDatos: function() {
                this.loading = true
                axios.get('/auth/usuarios_roles/' + this.id)
                    .then((response) => {
                        this.datos =  response.data
                        this.nombre = this.datos[0].name
                        
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
                axios.put('/auth/usuarios/roles/' + this.id, {
                    name: this.nombre,
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