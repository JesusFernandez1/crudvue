<template>
    <nav>
    <router-link to="/listar">Home</router-link> |
    <router-link to="/VerPolizas">Ver cuotas</router-link> |
    <router-link to="/filtrar">Filtrar</router-link>
    </nav>
    <div>
        <div class="card">
            <div class="card-header">
                Clientes
            </div>
            <div class="card-body">
                <table id="listado" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Telefono</th>
                            <th>Localidad</th>
                            <th>Codigo postal</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cliente in clientes" :key="cliente.idcliente">
                            <td>{{ cliente.idcliente }}</td>
                            <td>{{ cliente.nombre }}</td>
                            <td>{{ cliente.apellido }}</td>
                            <td>{{ cliente.telefono }}</td>
                            <td>{{ cliente.provincia }}</td>
                            <td>{{ cliente.codigo_postal }}</td>
                            <td>{{ cliente.tipo }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="">

                                   <router-link :to="{name:'polizas',params:{id:cliente.idcliente}}"  class="btn btn-info">Ver detalles</router-link>

                                   <router-link :to="{name:'crearPoliza',params:{id:cliente.idcliente}}"  class="btn btn-success">Crear poliza</router-link>

                                    <router-link :to="{name:'modificar',params:{id:cliente.idcliente}}"  class="btn btn-warning">Modificar</router-link>
                                        
                                    <router-link :to="{name:'confirmarEliminar',params:{id:cliente.idcliente}}"  class="btn btn-danger">Borrar</router-link>
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
            clientes: []
        }
    },
    created: function () {
        this.consultarCliente();
    },
    methods: {
        consultarCliente() {
            fetch('http://localhost/user/')
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {


                    console.log(datosRespuesta)
                    this.clientes = []
                    if (typeof datosRespuesta[0].success === 'undefined') {

                        this.clientes = datosRespuesta;
                    }
                    this.$nextTick(function () {
                        $("#listado").DataTable()
                    });
                })
                .catch(console.log)
        },
        crearPoliza(){
            window.location.href = '/crearPoliza';
        }
    }
}
</script>
<style>

#listado th {
    text-align: center;
}

</style>