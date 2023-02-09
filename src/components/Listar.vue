<template>
    <div>
        <div class="card">
            <div class="card-header">
                Clientes
            </div>
            <div class="card-body">
                <table class="table">
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
                            <td>{{ cliente.localidad }}</td>
                            <td>{{ cliente.codigo_postal }}</td>
                            <td>{{ cliente.tipo }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="">

                                   <!--<router-link :to="{name:'polizas',params:{id:cliente.idcliente}}"  class="btn btn-info">Ver polizas</router-link>--> 

                                    <router-link :to="{name:'modificar',params:{id:cliente.idcliente}}"  class="btn btn-warning">Modificar</router-link>
                                        
                                    <button type="button" v-on:click="borrarCliente(cliente.idcliente)"
                                        class="btn btn-danger">Borrar</button>
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
        }
    }
}
</script>