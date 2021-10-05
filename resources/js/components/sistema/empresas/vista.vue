<template>
    <b-container fluid>
        <crud-cabecera titulo="Empresas"></crud-cabecera>
        <b-form>
            <b-form-group id="grupoNombre" label="Nombre:" label-for="nombre">
                <b-form-input id="nombre" type="text" v-model="nombre" placeholder="Digite el nombre de la empresa" disabled></b-form-input>
                <span v-if="errors.nombre" class="text-danger">{{errors.nombre[0]}}</span>
            </b-form-group>
            <b-form-group id="grupoEmail" label="Email:" label-for="email">
                <b-form-input id="email" type="email" v-model="email" placeholder="Digite un email valido usuario@dominio.com"></b-form-input>
                <span v-if="errors.email" class="text-danger">{{errors.email[0]}}</span>
            </b-form-group>
            <b-form-group id="grupoActiva">
                <b-form-checkbox class="mb-2 mr-sm-2 mb-sm-0" id="activa" v-model="activa" value="1" unchecked-value="0" disabled>
                    Activa
                    <span v-if="errors.activa" class="text-danger">{{errors.activa[0]}}</span>
                </b-form-checkbox>
            </b-form-group>
            <b-button variant="secondary" :to="{name: 'empresas'}">Volver</b-button>
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
                activa: 0,
                email: '',
                errors : [],
                respuesta : [],
                empresas: [],
                loading : false,
            }
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
            }
        }
    }
</script>