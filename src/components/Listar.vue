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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cliente in clientes" :key="cliente.id">
                            <td>{{ cliente.id }}</td>
                            <td>{{ cliente.nombre }}</td>
                            <td>{{ cliente.apellido }}</td>
                            <td>{{ cliente.telefono }}</td>
                            <td>{{ cliente.tipo }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="">
                                   
                                    <button type="button" v-on:click="borrarcliente(cliente.id)"
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
        borrarcliente(id) {
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