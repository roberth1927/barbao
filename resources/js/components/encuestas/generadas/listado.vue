<template>
    <b-container fluid>
        <crud-cabecera titulo="Encuestas generadas"></crud-cabecera>
        <b-row>
            <b-col md="6" class="my-1">
                <b-form-group horizontal label="Buscar" class="mb-0">
                    <b-input-group>
                        <b-form-input v-model="filter" placeholder="Digite el dato a buscar" />
                        <b-input-group-append>
                            <b-btn :disabled="!filter" @click="filter = ''" variant="primary">Limpiar</b-btn>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col offset-md="2" md="auto" class="my-1">
                <b-button variant="primary" v-b-modal.modalWS @click="getDatosWS">Cargar desde WebService DMS</b-button>
                <b-button variant="primary" @click="getEnviar" >Enviar Encuestas</b-button>

            </b-col>

           
        </b-row>

        <b-table responsive striped hover :items="datos"  :fields="fields" :filter="filter" :current-page="currentPage" :per-page="perPage" @filtered="onFiltered">
            <!-- <template slot="actions" slot-scope="row">
                <b-link :to="{name: 'cargadas_vista', params: {id : row.item.id }}"><i class="fa fa-eye"></i></b-link>
                <b-link :to="{name: 'cargadas_editar', params: {id : row.item.id }}"><i class="fa fa-edit"></i></b-link>
            </template> -->

            <!-- <template slot="actions" slot-scope="rojo">
                <b-button  variant="primary" @click="getEnviar"> {{rojo.enviar}}Enviar1</b-button>
            </template>
            -->

           

            <template slot="activo" slot-scope="row">{{row.value?'Si':'No'}}</template> 


        </b-table>
        <b-row>
            <b-col md="6" class="my-1">
                <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
            </b-col>
        </b-row>
        
        <Loading v-if="loading"/>

        <b-modal id="modalWS" size="lg" title="Datos Web Services" v-model="show" centered>
            {{el_mensaje}}
            <b-form-group id="grupoEmpresa" label="Empresa" label-for="empresa">
                <b-form-select id="empresa" :options="empresas" v-model="empresas_id" @change="getEncuestas"></b-form-select>
            </b-form-group>

            <b-form-group id="grupoEncuesta" label="Encuesta" label-for="encuesta">
                <b-form-select id="encuesta" :options="encuestas" v-model="encuestas_id"></b-form-select>
            </b-form-group>

            <b-table responsive striped hover :items="datos_ws" :fields="fields_ws" :current-page="currentPage_ws" :per-page="perPage_ws">
            </b-table>
            
            <b-col md="6" class="my-1">
                <b-pagination :total-rows="totalRows_ws" :per-page="perPage_ws" v-model="currentPage_ws" class="my-0" />
            </b-col>
            
            <div slot="modal-footer" class="w-100">
                <b-btn variant="primary" @click="cargarDatosWs">Cargar Todos</b-btn>
                <b-btn class="float-right" variant="primary" @click="show=false">Cerrar</b-btn>
            </div>

        </b-modal>
    </b-container>
</template>
<script>
    export default {
         // props: ['id'],
        data(){
            return {
                fields: [
                   // { key: 'id', label: 'Id', sortable: true, sortDirection: 'asc'},
                    { key: 'encuesta', label: 'Encuesta'},
                    { key: 'cliente', label: 'Cliente'},
                    { key: 'orden', label: 'Orden'},
                    { key: 'empresas', label: 'Empresa'},
                    { key: 'tipo estado', label: 'Estado Encuesta'},
                    //{ key: 'actions', label: 'Acciones', thStyle: "width:5%" }

                ],

                fields_ws: [
                    // { key: 'actions', label: 'Acciones', thStyle: "width:5%" },
                    { key: 'id', label: 'Id', sortable: true, sortDirection: 'asc'},
                    { key: 'placa', label: 'Placa'},
                    { key: 'vehiculo', label: 'Vehículo'},
                    { key: 'fecha', label: 'Fecha Servicio'},
                
                ],

                datos           : [],
                datos_ws        : [],
                filter          : null,
                totalRows       : 0,
                totalRows_ws    : 0,
                perPage         : 10,
                perPage_ws      : 5,
                currentPage     : 1,
                currentPage_ws  : 1,
                loading         : false,
                el_mensaje      : 'Cargando datos ...',
                show            : false,
                empresas_id     : '',
                //id              : [],
                encuestas_id    : 0,
                empresas        : [],
                encuestas       : [],

            }
        },
        created() {
          this.getDatos();
        },
        methods: {
            getDatos: function() {
                this.loading = true
                axios.get('/auth/encuestas/cargadas')
                    .then((response) => {
                        this.datos =  response.data
                        this.totalRows = Object.keys(this.datos).length
                        this.loading = false
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            },
            onFiltered (filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            getDatosWS: function() {
                this.show = true
                this.getEmpresas()
                axios.get('http://barbao_ws/api/v1/taller/orden_servicio')
                    .then((response) => {
                        this.datos_ws =  response.data
                        this.totalRows_ws = Object.keys(this.datos_ws).length
                        this.el_mensaje = ''
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            },
             getEnviar: function() {
                this.loading = false
                axios.get('/auth/sendemail')
                    .then((response) => {
                       // this.datos  =  response.data
                       // this.totalRows = Object.keys(this.datos).length
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            },
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
            cargarDatosWs: function(){
                this.loading = true
                this.errors = []
                axios.post('/auth/encuestas/cargar_datos_ws', {
                    encuestas_id    : this.encuestas_id,
                    empresas_id     : this.empresas_id,
                    datos_ws        : this.datos_ws
                }).then(response => {
                    this.getDatos()
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
        },
        
    }
</script>