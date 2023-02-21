<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h3>Estas seguro de eliminar la cliente?</h3>
            </div>
            <div class="card-body">
                <table id="listaclientes" class="table">
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
                        <tr v-bind:class="{ 'bg-success': cliente.estado == 'Cobrada', 'bg-danger': cliente.estado == 'Anulada', 'bg-warning': cliente.estado == 'A cuenta', 'bg-info': cliente.estado == 'Liquidada', 'bg-secondary': cliente.estado == 'Pre-Anulada' }">
                            <td>{{ cliente.idcliente }}</td>
                            <td>{{ cliente.importe }}</td>
                            <td>{{ cliente.fecha }}</td>
                            <td>{{ cliente.estado }}</td>
                            <td>{{ cliente.observaciones }}</td>
                            <td>{{ cliente.cliente_idcliente }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="">

                                    <button type="button" v-on:click="borrarCliente(cliente.idcliente)"
                                        class="btn btn-danger">Si</button>
                                   
                                    <button type="button" v-on:click="noBorrarCliente()"
                                        class="btn btn-success">No</button>
                                    
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
            cliente: {

            }
        }
    },
    created: function () {
        this.consultarcliente();
    },
    methods: {
        consultarCliente() {
            fetch('http://localhost/user/?consultar='+this.$route.params.id)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    this.cliente = datosRespuesta[0];
                    
                })
                .catch(console.log)
        },
        borrarCliente(id) {
            fetch('http://localhost/user/?borrar=' + id)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    window.location.href = "listar"


                })
                .catch(console.log)
        },
        noBorrarCliente() {
            window.location.href = 'listar';
        }
    }
}
</script>
<style>

#listaclientes th {
    text-align: center;
}

</style>