<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <router-link class="navbar-brand" to="/listar">Mi sitio web</router-link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/listar">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/filtrar">Filtrar</router-link>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <router-link class="nav-link btn btn-danger" to="/">Logout</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    <div class="container mt-4">
    <div class="card">
      <div class="card-header bg-primary text-white">
        Polizas
      </div>
      <div class="card-body">
                <table id="listaPolizas" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Importe</th>
                            <th>Fecha de creacion</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                            <th>ID del cliente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="poliza in polizas" :key="poliza.idpoliza" v-bind:class="{ 'bg-success': poliza.estado == 'Cobrada', 'bg-danger': poliza.estado == 'Anulada', 'bg-warning': poliza.estado == 'A cuenta', 'bg-info': poliza.estado == 'Liquidada', 'bg-secondary': poliza.estado == 'Pre-Anulada' }">
                            <td>{{ poliza.idpoliza }}</td>
                            <td>{{ poliza.importe }}</td>
                            <td>{{ poliza.fecha }}</td>
                            <td>{{ poliza.estado }}</td>
                            <td>{{ poliza.observaciones }}</td>
                            <td>{{ poliza.cliente_idcliente }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="">

                                    <router-link :to="{name:'polizas',params:{id:poliza.cliente_idcliente}}" style="border-color: white;" class="btn btn-info">Ver cliente</router-link>

                                    <router-link :to="{name:'modificarpoliza',params:{id:poliza.idpoliza}}" style="border-color: white;" class="btn btn-warning">Modificar</router-link>
                                   
                                    <router-link :to="{name:'confirmarEliminarPoliza',params:{id:poliza.idpoliza}}" style="border-color: white;" class="btn btn-danger">Borrar</router-link>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import 'jquery/dist/jquery.min.js';
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import $ from 'jquery';
export default {
    data() {

        return {
            polizas: []
        }
    },
    created: function () {
        this.consultarPoliza();
    },
    methods: {
        consultarPoliza() {
            fetch('https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/poliza/')
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    this.polizas = []
                    if (typeof datosRespuesta[0].success === 'undefined') {

                        this.polizas = datosRespuesta;
                    }
                    this.$nextTick(() => {
                        $("#listaPolizas").DataTable({
                            order: [[2, "desc"]],
                            columnDefs: [
                                {
                                    targets: 2,
                                    render: function (data) {
                                        var date = new Date(data);
                                        var day = date.getDate().toString().padStart(2, '0');
                                        var month = (date.getMonth() + 1).toString().padStart(2, '0');
                                        var year = date.getFullYear();
                                        return `${day}/${month}/${year}`;
                                    }
                                }
                            ]
                        });
                    });
                })
                .catch(console.log)
        }
    }
}
</script>
<style>

#listaPolizas th {
    text-align: center;
}

</style>