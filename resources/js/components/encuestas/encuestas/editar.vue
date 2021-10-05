<template>
    <b-container fluid>
        <crud-cabecera titulo="Encuestas"></crud-cabecera>
        <b-form @submit="guardarDatos">

        <b-form-group id="grupoEmpresa" label="Empresa" label-for="empresa">
            <b-form-select id="empresa" :options="empresas" v-model="empresas_id" @input="$v.empresas_id.$touch()" disabled></b-form-select>
            <!-- <span v-if="errors.empresas_id" class="error-message">{{errors.empresas_id[0]}}</span>
            <div v-if="$v.empresas_id.$dirty"><p class="error-message" v-if="!$v.empresas_id.required"></p></div> -->
        </b-form-group>

        <b-form-group id="grupoTipo" label="Tipo de Encuesta" label-for="tipo">
            <b-form-select id="tipo" :options="encuesta_tipos" v-model="encuesta_tipos_id" @input="$v.encuesta_tipos_id.$touch()"></b-form-select>
            <span v-if="errors.encuesta_tipos_id" class="error-message">{{errors.encuesta_tipos_id[0]}}</span>
            <div v-if="$v.encuesta_tipos_id.$dirty"><p class="error-message" v-if="!$v.encuesta_tipos_id.required"></p></div>
        </b-form-group>


        <b-form-group id="grupoNombre" label="Nombre de la encuesta:" label-for="nombre">
            <b-form-input id="nombre" type="text" v-model="nombre" @input="$v.nombre.$touch()"></b-form-input>
            <span v-if="errors.nombre" class="error-message">{{errors.nombre[0]}}</span>
            <div v-if="$v.nombre.$dirty"><p class="error-message" v-if="!$v.nombre.required">El nombre de la encuesta es obligatorio</p></div>
        </b-form-group>       
            
            <b-button type="submit" variant="primary" :disabled="$v.$invalid">Guardar</b-button>
            <b-button variant="secondary" to="/encuestas">Volver</b-button>
        </b-form>
        <br>
        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>
        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
    import { required } from 'vuelidate/lib/validators';
    export default {
        props: ['id', 'empresas_id'],
        data () {
            return {
                empresas            : [],
                encuesta_tipos      : [],         
                nombre              : '', 
                encuesta_tipos_id   : 0,  
                errors              : [],
                respuesta           : [],
                loading             : false 
            }
        },
        validations: {
            nombre :  { required },   
            encuesta_tipos_id :  { required },   
        },
        mounted() {
            this.getEmpresas();
            this.getTipos();
            this.getDatos();
        },
        methods: {
            getTipos: function() {
                this.loading = true
                axios.get('/auth/tipos_de_encuestas')
                    .then((response) => {
                        this.encuesta_tipos =  response.data
                        this.loading = false
                    })
                    .catch((err) => {
                        console.log(err)
                        this.loading = false
                    })
            },
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
            getDatos: function() {
                this.loading = true
                axios.get('/auth/encuestas/' + this.id + '/' + this.empresas_id )
                    .then((response) => {
                        this.datos              = response.data
                        this.nombre             = this.datos[0].nombre
                        this.encuesta_tipos_id  = this.datos[0].tipo_encuesta
                        this.loading            = false
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
                axios.put('/auth/encuestas/' + this.id+ '/' + this.empresas_id, {
                    encuesta_tipos_id: this.encuesta_tipos_id,
                    nombre: this.nombre
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