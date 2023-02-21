<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h3>Estas seguro de eliminar la cliente?</h3>
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
                        <tr>
                            <td>{{ cliente.idcliente }}</td>
                            <td>{{ cliente.nombre }}</td>
                            <td>{{ cliente.apellido }}</td>
                            <td>{{ cliente.telefono }}</td>
                            <td>{{ cliente.provincia }}</td>
                            <td>{{ cliente.codigo_postal }}</td>
                            <td>{{ cliente.tipo }}</td>
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
        consultarcliente() {
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
                    window.location.href = "/listar"

                })
                .catch(console.log)
        },
        noBorrarCliente() {
            window.location.href = '/listar';
        }
    }
}
</script>
<style>

#listaclientes th {
    text-align: center;
}

</style>