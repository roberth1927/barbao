<template>
    <b-container fluid>
        <crud-cabecera titulo="Preguntas"></crud-cabecera>
        <b-form @submit="guardarDatos">
     
            <b-form-group  id="grupoPregunta" label="Pregunta:" label-for="pregunta">
                <b-form-input id="pregunta" type="text" v-model="pregunta" disabled></b-form-input>
            </b-form-group>


             <b-form-group id="grupoOpcion" label="Nueva Opcion:" label-for="opcion">
                <b-form-input id="opcion" type="text" v-model="opcion" @input="$v.opcion.$touch()"></b-form-input>
                <span v-if="errors.opcion" class="error-message">{{errors.opcion[0]}}</span>
                <div v-if="$v.opcion.$dirty"><p class="error-message" v-if="!$v.opcion.required">La opcion es obligatoria</p></div>
            </b-form-group>

             <b-form-group id="grupoPeso" label="Peso:" label-for="peso">
                <b-form-input id="peso" type="text" v-model="peso" @input="$v.peso.$touch()"></b-form-input>
                <span v-if="errors.peso" class="error-message">{{errors.peso[0]}}</span>
                <div v-if="$v.peso.$dirty"><p class="error-message" v-if="!$v.peso.required">El peso es obligatorio</p></div>
            </b-form-group>
            <b-button type="submit" variant="primary" :disabled="$v.$invalid">Guardar</b-button>
            <b-button  variant="secondary" :to="{name: 'encuestas_preguntas'}">Volver</b-button>
            <b-btn v-b-modal.modal-center variant="primary">Opciones existentes</b-btn>
        </b-form>
        <br>
        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>
        <Loading v-if="loading"/>

        <div>
            <b-modal id="modal-center" hide-footer centered title="Opciones">
                <b-form-group  id="grupoOpciones" label-for="opcioes">
                    <b-list-group v-for="(op, id) in opciones_data" :key="id" >     
                        <b-list-group-item>{{ op.value }} </b-list-group-item>
                    </b-list-group>
                </b-form-group>
            </b-modal>
        </div>
        
    </b-container>
</template>
<script>
    import { required } from 'vuelidate/lib/validators';
    export default {
        props: ['encuesta_preguntas_id', 'encuestas_id', 'empresas_id'],
        data () {
            return {
                encuestas : [],
                empresas : [],
                opciones_preguntas: [],
                tipo : 0,
                opciones_tipo: [
                        { text: 'Seleccione' },
                        { text: 'Selección multiple única respuesta', value: 'SEL_MUL_UNI_RESP' },
                        { text: 'Si o No',value: 'SI_NO' },
                        { text: 'Texto',value: 'TEXTO' },
                        ],
                pregunta : '',
                preguntas_respuestas: '',
                peso: '',
                opcion: '',
                errors : [],
                respuesta : [],
                opciones_data: [],
                loading : false
            }
        },
         validations: {
            opcion : { required }, 
            peso : { required }
           
        },
        mounted() {
            this.getEmpresa()
            this.getPregunta()
            this.getOpciones()
        },
        
         methods: {
             getPregunta: function() {
                this.loading = true
                axios.get('/auth/encuestas/preguntas/' + this.encuesta_preguntas_id + '/' + this.encuestas_id + '/' + this.empresas_id )
                    .then((response) => {
                        this.encuestas_data =  response.data
                        this.pregunta = this.encuestas_data[0].pregunta
                        this.loading = false
                    })
                    .catch((err) => {
                        console.log(err)
                        this.loading = false
                    })
            },
            
            getOpciones: function() {
                this.loading = true
                axios.get('/auth/encuestas/preguntas_respuestas/' + this.encuesta_preguntas_id + '/' + this.encuestas_id + '/' + this.empresas_id )
                    .then((response) => {
                        this.opciones_data =  response.data
                        this.totalRows=Object.keys(this.opciones_data).length
                        this.opciones_preguntas = response.data
                        this.loading = false
                    })
                    .catch((err) => {
                        console.log(err)
                        this.loading = false
                    })
            },
            getEmpresa: function() {
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
                axios.post('/auth/encuestas/preguntas_respuestas', {
                    encuesta_preguntas_id : this.encuesta_preguntas_id,
                    empresas_id : this.empresas_id,
                    encuestas_id : this.encuestas_id,
                    opcion: this.opcion,
                    peso: this.peso
                }).then(response => {
                    // this.id = null
                    // this.empresas_id = null
                    // this.encuestas_id = null
                    this.opcion = null
                    this.peso = null
                    this.getOpciones()
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