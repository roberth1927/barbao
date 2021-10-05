<template>
    <b-container fluid>
        <crud-cabecera titulo="Encuestas" titulo_singular="Encuesta" ruta="encuestas_nuevo" ver_boton_nuevo=true></crud-cabecera>
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
        </b-row>

        <b-table responsive striped hover :items="datos" :fields="fields" :filter="filter" :current-page="currentPage" :per-page="perPage" @filtered="onFiltered">
            <template slot="actions" slot-scope="row">
                <b-link :to="{name: 'encuestas_vista',  params: {id : row.item.id, empresas_id : row.item.empresas_id }}"><i class="fa fa-eye"></i></b-link>
                <b-link :to="{name: 'encuestas_editar', params: {id : row.item.id, empresas_id : row.item.empresas_id }}"><i class="fa fa-edit"></i></b-link>
            </template>
            <template slot="activo" slot-scope="row">{{row.value?'Si':'No'}}</template>
        </b-table>

        <b-row>
            <b-col md="6" class="my-1">
                <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
            </b-col>
        </b-row>

        <b-modal ref="myModalRef" hide-footer centered title="Mensajes del Sistema"><MensajesModal :mensaje="mensaje" /></b-modal>
        <Loading v-if="loading"/>
    </b-container>
</template>
<script>
    export default {
        data(){
            return {
                fields: [
                    { key: 'actions', label: 'Acciones', thStyle: "width:5%" },
                    { key: 'Tipo Encuesta', label: 'Tipo de Encuesta', sortable: true, sortDirection: 'asc'},
                    { key: 'Empresa', label: 'Empresa', sortable: true, sortDirection: 'asc'},
                    { key: 'nombre', label: 'Nombre'},
                   
                  
                ],
                datos: [],
                filter: null,
                totalRows: 0,
                perPage : 5,
                currentPage: 1,
                loading: false,
                mensaje : ''

            }
        },
        created() {
            this.getDatos();
        },
        methods: {
            getDatos: function() {
                this.loading = true
                axios.get('/auth/encuestas')
                    .then((response) => {
                        this.datos =  response.data
                        this.totalRows = Object.keys(this.datos).length
                        this.loading = false
                    })
                    .catch((err) => {
                         this.loading = false
                        if (err.response.status == 403){
                            this.mensaje = err.response.data.message
                            this.$refs.myModalRef.show()
                        } else {
                            console.log(err.response)
                        }
                    })
            },
            onFiltered (filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        },
        
    }
</script>