<template>
    <b-container fluid>
        <crud-cabecera titulo="Encuestas"></crud-cabecera>
        <b-form>

        <b-form-group id="grupoEmpresa" label="Empresa" label-for="empresa">
            <b-form-select id="empresa" :options="empresas" v-model="empresas_id" disabled></b-form-select>
        </b-form-group>

        <b-form-group id="grupoTipo" label="Tipo de Encuesta" label-for="tipo">
            <b-form-select id="tipo" :options="encuesta_tipos" v-model="encuesta_tipos_id" disabled></b-form-select>
        </b-form-group>

        <b-form-group id="grupoNombre" label="Nombre de la encuesta:" label-for="nombre">
            <b-form-input id="nombre" type="text" v-model="nombre" disabled></b-form-input>
        </b-form-group>       
            
            <b-button variant="secondary" to="/encuestas">Volver</b-button>
        </b-form>
        <br>
        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>
        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
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
        mounted() {
            this.getTipos();
            this.getEmpresas();
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
        }
    }
</script>