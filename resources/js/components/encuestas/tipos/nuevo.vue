<template>
    <b-container fluid>
        <crud-cabecera titulo="Tipos de Encuestas" titulo_singular="Tipo de encuesta" ruta="encuestas_tipos_nuevo"></crud-cabecera>
        <b-form @submit="guardarDatos">
            
           <b-form-group id="grupoNombre" label="Nombre:" label-for="nombre">
                <b-form-input id="nombre" type="text" v-model="nombre" @input="$v.nombre.$touch()"></b-form-input>
                <span v-if="errors.nombre" class="error-message">{{errors.nombre[0]}}</span>
                <div v-if="$v.nombre.$dirty"><p class="error-message" v-if="!$v.nombre.required">El nombre de la empresa es obligatorio</p></div>
            </b-form-group>
            
            
            <b-button type="submit" variant="primary" :disabled="$v.$invalid">Guardar</b-button>
            <b-button variant="secondary" to="/encuestas_tipos">Volver</b-button>
        </b-form>
        <br>
        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>
        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
    import { required } from 'vuelidate/lib/validators';
    export default {
        data () {
            return {
                nombre: '',
                errors : [],
                respuesta : [],
                loading : false,
            }
        },
        validations: {
            nombre : { required }
        },
         methods: {
             guardarDatos(evt){
            this.loading = true
            evt.preventDefault();
            this.errors = []
            axios.post('/auth/encuestas/tipos', {
                nombre: this.nombre
            }).then(response => {
                this.nombre = null
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