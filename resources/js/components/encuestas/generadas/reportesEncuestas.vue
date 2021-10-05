<template>
    <div>
        <b-container fluid>
            <crud-cabecera titulo="Reporte Encuestas"></crud-cabecera>
            <b-row>
                    <div class="col-5">
                    <div id="sidebar-sponsors-special">
                        <b-form-group id="grupoEmpresa" label="Empresa" label-for="empresa">
                            <b-form-select id="empresa" :options="empresas" v-model="empresas_id" @change="getEncuestas"></b-form-select>
                        </b-form-group>    

                        <b-form-group id="grupoEncuesta" label="Encuesta" label-for="encuesta">
                            <b-form-select id="encuesta" :options="encuestas" v-model="encuestas_id"></b-form-select>
                        </b-form-group>      
                    </div>  
                </div> 
            </b-row>

            <b-row>
                <div class="col-12">
                <b-table  responsive striped hover :items="datosjson"  :fields="fields" :current-page="currentPage" :per-page="perPage" >
                    <template slot="actions" slot-scope="rojo">
                        <b-button @click="getResEncuesta(datosjson.id)" v-b-modal.modalWS variant="primary"><i class="fa fa-eye"></i>{{rojo.e}}</b-button>
                    </template>                  
                </b-table>

                </div>      
                       
            </b-row>   
 
            <!-- Inicio Modal -->
            <b-modal id="modalWS" size="lg" title="Datos De La Encuesta" centered>    
                     <b-table responsive striped hover :fields="fieldsModal">   
                    </b-table>
            </b-modal>
            <!-- Fin Modal -->

        </b-container>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                fields: [
                    { key: 'actions', label: 'Accion', thStyle: "width:3%"},
                    { key: 'encuesta', label: 'Encuesta'},
                    { key: 'empresas', label: 'Empresa'},
                    { key: 'orden', label: 'Orden'},
                    { key: 'cliente', label: 'Cliente'},
              
                ],

                 fieldsModal: [
                    { key: 'actions', label: 'Pregunta', thStyle: "width:20%"},
                    { key: 'encuesta', label: 'Encuesta'},
                    { key: 'empresas', label: 'Empresa'},
                    { key: 'orden', label: 'Orden'},
                    { key: 'cliente', label: 'Cliente'},
              
                ],
                pregunta: '',
                contador: [],
                datosjson: [],
                empresas : [],
                encuestas : [],
                empresas_id: '',
                encuestas_id: '',
                datos: [],
                filter: null,
                totalRows: 0,
                pregunta_id: 0,
                perPage : 5,
                currentPage: 1,
                loading: false,
                encuesta:'',
                empresa:'',              
              
            }         
        },
       
        mounted() {
            this.getEmpresas();
            if( (this.encuesta != '') || (this.empresa != '') )
            {
                this.getDatos();
                //this.datosjson();    
            }
            
        },
        methods: {
            getDatos(){
                this.loading = true
                axios.get(`/auth/encuestas/cargadas`)
                .then((response) =>
                    {
                    console.log(response)
                    this.datosjson =  response.data
                    this.totalRows = Object.keys(this.datosjson).length                      
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

            onFiltered (filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
                
            },

            validParams(){
                if( (this.empresa != '') && (this.encuesta != '') )
                {
                    this.getDatos()
                }
            }
        },

        watch:{
            empresas_id(){
                this.empresa = this.empresas_id
                this.validParams()
            },
            encuestas_id(){
                this.encuesta = this.encuestas_id
                this.validParams()

            }
        }
 
        
    }
</script>