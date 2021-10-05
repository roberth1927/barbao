<template>
    <b-container fluid>
        <crud-cabecera titulo="Empresas" titulo_singular="Empresa" ruta="empresas_nuevo" ver_boton_nuevo=true></crud-cabecera>
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

        <b-table responsive striped hover :items="empresas" :fields="campos" :filter="filter" :current-page="currentPage" :per-page="perPage" @filtered="onFiltered">
            <template slot="actions" slot-scope="row">
                <TablaAcciones :ver="{show: true, ruta: 'empresas_vista', id: row.item.id}"
                               :editar="{show: true, ruta: 'empresas_editar', id: row.item.id}">
                </TablaAcciones>
            </template>
            <template slot="activa" slot-scope="row">{{row.value?'Si':'No'}}</template>
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
                campos: [
                    { key: 'actions', label: 'Acciones', thStyle: "width:5%" },
                    { key: 'nombre', label: 'Nombre', sortable: true, sortDirection: 'desc'},
                    { key: 'email', label: 'Email'},
                    { key: 'activa', label: 'Activa'}
                ],
                mensaje : null,
                empresas: [],
                filter: null,
                totalRows: 0,
                perPage : 10,
                currentPage: 1,
                loading: false,
            }
        },
        created() {
            this.getDatos();
        },
        
        methods: {
            getDatos: function() {
                this.loading = true
                axios.get('/auth/empresas')
                    .then((response) => {
                        this.empresas =  response.data
                        this.totalRows = Object.keys(this.empresas).length
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