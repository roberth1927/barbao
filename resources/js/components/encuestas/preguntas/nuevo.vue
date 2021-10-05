<template>
    <b-container fluid>
        <crud-cabecera titulo="Preguntas" titulo_singular="Pregunta" ruta="preguntas_nuevo"></crud-cabecera>
        <b-form @submit="guardarDatos">

            <b-form-group id="grupoEmpresa" label="Empresa" label-for="empresa">
                <b-form-select id="empresa" :options="empresas" v-model="empresas_id" @input="$v.empresas_id.$touch()" @change="getEncuestas"></b-form-select>
                <span v-if="errors.empresas_id" class="error-message">{{errors.empresas_id[0]}}</span>
                <div v-if="$v.empresas_id.$dirty"><p class="error-message" v-if="!$v.empresas_id.required"></p></div>
            </b-form-group>

            <b-form-group id="grupoEncuesta" label="Encuesta" label-for="encuesta">
                <b-form-select id="encuesta" :options="encuestas" v-model="encuestas_id" @input="$v.encuestas_id.$touch()"></b-form-select>
                <span v-if="errors.encuestas_id" class="error-message">{{errors.encuestas_id[0]}}</span>
                <div v-if="$v.encuestas_id.$dirty"><p class="error-message" v-if="!$v.encuestas_id.required">La encuesta a la cual pertece la pregunta es obligatoria</p></div>
            </b-form-group>
            
            <b-form-group id="grupoPregunta" label="Pregunta:" label-for="pregunta">
                <b-form-input id="pregunta" type="text" v-model="pregunta" @input="$v.pregunta.$touch()"></b-form-input>
                <span v-if="errors.pregunta" class="error-message">{{errors.pregunta[0]}}</span>
                <div v-if="$v.pregunta.$dirty"><p class="error-message" v-if="!$v.pregunta.required">La pregunta es obligatoria</p></div>
            </b-form-group>

            <b-form-group id="grupoTipo" label="Tipo:" label-for="tipo">
                <b-form-select id="tipo" type="text" v-model="tipo" :options="opciones_tipo" @input="$v.tipo.$touch()"></b-form-select>
                <span v-if="errors.tipo" class="error-message">{{errors.tipo[0]}}</span>
                <div v-if="$v.tipo.$dirty"><p class="error-message" v-if="!$v.tipo.required">El tipo de pregunta obligatorio</p></div>
            </b-form-group>
            
            <b-form-group id="grupoPeso" label="Peso:" label-for="peso">
                <b-form-input id="peso" type="number" v-model="peso" @input="$v.peso.$touch()"></b-form-input>
                <span v-if="errors.peso" class="error-message">{{errors.peso[0]}}</span>
                <div v-if="$v.peso.$dirty">
                </div>
            </b-form-group>

            <b-button type="submit" variant="primary" :disabled="$v.$invalid">Guardar</b-button>
            <b-button variant="secondary" :to="{name: 'encuestas_preguntas'}">Volver</b-button>
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
                empresas : [],
                empresas_id : '',
                encuestas : [],
                encuestas_id : 0,
                pregunta: '',
                peso: '',
                tipo : 0,
                opciones_tipo: [
                        { text: 'Seleccione' },
                        { text: 'Selección multiple única respuesta', value: 'SEL_MUL_UNI_RESP' },
                        { text: 'Si o No',value: 'SI_NO' },
                        { text: 'Texto',value: 'TEXTO' },
                        ],
                errors : [],
                respuesta : [],
                loading : false,
                encuestas : []
               
            }
        },
        validations: {
            encuestas_id : { required },
            empresas_id : { required },
            pregunta : { required },
            tipo : { required },
            peso : { required }
           
        },
        mounted() {
            this.getEmpresas()
        },
        methods: {
            getEncuestas: function($ev) {
                this.loading = true
                axios.get('/auth/encuestas/listado/' + $ev)
                    .then((response) => {
                        this.encuestas =  response.data
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
            guardarDatos(evt){
                this.loading = true
                evt.preventDefault();
                this.errors = []
                axios.post('/auth/encuestas/preguntas', {
                    encuestas_id : this.encuestas_id,
                    empresas_id : this.empresas_id,
                    pregunta: this.pregunta,
                    tipo: this.tipo,
                    peso: this.peso
                }).then(response => {
                    this.encuesta_id = null
                    this.empresas_id = null
                    this.pregunta = null
                    this.tipo = null
                    this.peso = null
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