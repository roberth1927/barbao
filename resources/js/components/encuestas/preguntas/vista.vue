<template>
    <b-container fluid>
        <crud-cabecera titulo="Preguntas"></crud-cabecera>
        <b-form>

            <b-form-group id="grupoEmpresa" label="Empresa" label-for="empresa">
                <b-form-select id="empresa" :options="empresas" v-model="empresas_id" disabled></b-form-select>
            </b-form-group>

            <b-form-group id="grupoEncuesta" label="Encuesta" label-for="encuesta">
                <b-form-select id="encuesta" :options="encuestas" v-model="encuestas_id" disabled></b-form-select>
            </b-form-group>
            
            <b-form-group id="grupoPregunta" label="Pregunta:" label-for="pregunta">
                <b-form-input id="pregunta" type="text" v-model="pregunta" disabled></b-form-input>
            </b-form-group>

            <b-form-group id="grupoTipo" label="Tipo:" label-for="tipo">
                <b-form-select id="tipo" type="text" v-model="tipo" :options="opciones_tipo" disabled></b-form-select>
            </b-form-group>
            
            <b-form-group id="grupoPeso" label="Peso:" label-for="peso">
                <b-form-input id="peso" type="number" v-model="peso" disabled></b-form-input>
            </b-form-group>

            <b-button variant="secondary" to="/encuestas/preguntas">Volver</b-button>
        </b-form>
        <br>
        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>
        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
    import { required} from 'vuelidate/lib/validators';
    export default {
        props: ['id', 'encuestas_id', 'empresas_id'],
        data () {
            return {
                encuestas : [],
                empresas : [],
                tipo : 0,
                 opciones_tipo: [
                        { text: 'Seleccione' },
                        { text: 'Selección multiple única respuesta', value: 'SEL_MUL_UNI_RESP' },
                        { text: 'Si o No',value: 'SI_NO' },
                        { text: 'Texto',value: 'TEXTO' },
                        ],
                pregunta : '',
                peso : '', 
                activo: 0,
                errors : [],
                respuesta : [],
                loading : false
              
            }
        },
        validations: {
            pregunta : { required},
            tipo : { required},
            peso : { required }
        },
        mounted() {
            this.getEmpresa()
            this.getDatos()
            this.getEncuesta()
        },
        methods: {
             getEncuesta: function() {
                this.loading = true
                axios.get('/auth/encuestas/listado/' + this.empresas_id)
                    .then((response) => {
                        this.encuestas =  response.data
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
            getDatos: function() {
                this.loading = true
                axios.get('/auth/encuestas/preguntas/' + this.id + '/' + this.encuestas_id + '/' + this.empresas_id  )
                    .then((response) => {
                        this.datos =  response.data
                        this.pregunta = this.datos[0].pregunta
                        this.tipo = this.datos[0].tipo
                        this.peso = this.datos[0].peso
                        this.loading = false
                    })
                    .catch((err) => {
                        console.log(err)
                        this.loading = false
                    })
            },
        }
    }
</script>