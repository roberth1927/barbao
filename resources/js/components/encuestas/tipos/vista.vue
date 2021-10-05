<template>
    <b-container fluid>
        <crud-cabecera titulo="Tipos de Encuestas"></crud-cabecera>
        <b-form>
            <b-form-group id="grupoNombre" label="Nombre:" label-for="nombre">
                <b-form-input id="nombre" type="text" v-model="nombre"  disabled></b-form-input>
                <span v-if="errors.nombre" class="text-danger">{{errors.nombre[0]}}</span>
            </b-form-group>
           
           
            <b-button variant="secondary" :to="{name: 'encuestas_tipos'}">Volver</b-button>
        </b-form>
        <br>
        <b-alert show variant="success" v-if="respuesta.status">{{respuesta.message}}</b-alert>
        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
    export default {
        props: ['id'],
        data () {
            return {
                nombre : '',
                errors : [],
                respuesta : [],
                loading : false
            }
        },
        mounted() {
            this.getDatos();
        },
        methods: {
            getDatos: function() {
                this.loading = true
                axios.get('/auth/encuestas/tipos/' + this.id)
                    .then((response) => {
                       this.datos =  response.data
                        this.nombre = this.datos[0].nombre
                        this.loading = false
                    })
                    .catch((err) => {
                        console.log(err)
                        this.loading = false
                    })
            }
        }
    }
</script>