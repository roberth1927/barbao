<template>
    <b-container fluid>
        <crud-cabecera titulo="Encuestas" titulo_singular="Encuesta" ruta="encuestas_nuevo"></crud-cabecera>
        <b-form @submit="guardarDatos">

            
        <b-form-group id="grupoEmpresa" label="Empresa" label-for="empresa">
            <b-form-select id="empresa" :options="empresas" v-model="empresas_id" @input="$v.empresas_id.$touch()"></b-form-select>
            <span v-if="errors.empresas_id" class="error-message">{{errors.empresas_id[0]}}</span>
            <div v-if="$v.empresas_id.$dirty"><p class="error-message" v-if="!$v.empresas_id.required"></p></div>
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
        <b-modal ref="myModalRef" hide-footer centered title="Mensajes del Sistema"><MensajesModal :mensaje="mensaje" /></b-modal>

        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>

        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
    import { required} from 'vuelidate/lib/validators';
    export default {
        data () {
            return {
                encuesta_tipos_id: null,
                encuesta_tipos_id: [],
                empresas_id: null,
                nombre: '',
                encuesta_tipos : [],
                empresas : [],
                nombre : [],                
                errors : [],
                respuesta : [],
                mensaje : '',
                loading : false            
               
            }
        },
        validations: {
            encuesta_tipos_id : { required },
            empresas_id : { required },
            nombre : { required }          
           
        },
        mounted() {
            this.getTipos();
            this.getTipos1();
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
            getTipos1: function() {
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
            guardarDatos(evt){
                this.loading = true
                evt.preventDefault();
                this.errors = []
                axios.post('/auth/encuestas', {
                    encuesta_tipos_id: this.encuesta_tipos_id,
                    empresas_id: this.empresas_id,
                    nombre : this.nombre,
                }).then(response => {
                    this.encuesta_tipos_id = null
                    this.empresas_id = null
                    this.nombre = null
                    this.respuesta = response.data
                    this.loading = false
                    return response.data
                }).catch(error => {
                    this.loading = false
                        if (err.response.status == 403){
                            this.mensaje = err.response.data.message
                            this.$refs.myModalRef.show()
                        } else {
                            console.log(err.response)
                        }
                })
            }
        }
    }
</script>