<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>informes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
<table class="table table-sm table-bordered">
                        <thead class="thead-dark text-uppercase text-center">
                            <tr scope="row">
                                <th scope="col" width="30px">#</th>
                                <th scope="col">preguntas</th>
                                <th scope="col">respuestas</th>
                                <th scope="col">resultados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Row 1 -->
                            <tr scope="row">
                                <td rowspan="2" class="align-middle">1</th>
                                <td rowspan="2" class="align-middle">Mark</td>
                                <td>aaaa</th>
                                <td>aaaa</th>
                            </tr>
                            <tr scope="row">
                                <td>aaaa</th>
                                <td>aaaa</th>
                            </tr>
                            <!-- Row 2 -->
                            <tr scope="row">
                                <td rowspan="3" class="align-middle">2</th>
                                <td rowspan="3" class="align-middle">Bob</td>
                                <td>bbbb</th>
                                <td>bbbb</th>
                            </tr>
                            <tr scope="row">
                                <td>bbbb</th>
                                <td>bbbb</th>
                            </tr>
                            <tr scope="row">
                                <td>bbbb</th>
                                <td>bbbb</th>
                            </tr>
                        </tbody>
                    </table>
   
<script src="{{('js/app.js')}}"></script>
</body>
</html>

<script>
    export default {
        data(){
            return {
              
               
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
            }
        },
        methods: {
            getDatos(){
                this.loading = true
                axios.get(`/auth/respuesta_jason/${this.encuesta}/${this.empresa}`)
                    .then((response) =>
                     {
                        console.log(response)
                        this.datosjson =  response.data
                        this.totalRows = Object.keys(this.datosjson).length
                      
                        let contador 
                        let total = []
                        for(let i = 0; i < this.totalRows; i++)
                        {
                            contador = this.datosjson[i].RESPUESTAS_CLIENTES.opciones[1].valor_rta

                            if(contador == 10)
                            {
                                 total.push(contador)
                            }
                        }
                       
                    })
                    .catch((err) => {
                        console.log(err)
                    }) 
                    
            },
            contPre(){},
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