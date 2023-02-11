<template>
    <div>
        <div class="card">
            <div class="card-header">
                Polizas
            </div>
            <div class="card-body">
                <table class="table">
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
                        <tr v-for="poliza in polizas" :key="poliza.idpoliza">
                            <td>{{ poliza.idpoliza }}</td>
                            <td>{{ poliza.importe }}</td>
                            <td>{{ poliza.fecha }}</td>
                            <td>{{ poliza.estado }}</td>
                            <td>{{ poliza.observaciones }}</td>
                            <td>{{ poliza.cliente_idcliente }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="">

                                    <router-link :to="{name:'modificarpoliza',params:{id:poliza.idpoliza}}"  class="btn btn-warning">Modificar</router-link>
                                   
                                    <button type="button" v-on:click="borrarPoliza(poliza.idpoliza)"
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
            polizas: []
        }
    },
    created: function () {
        this.consultarPoliza();
    },
    methods: {
        consultarPoliza() {
            fetch('http://localhost/poliza/?consultar=' + this.$route.params.id)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    this.polizas = []
                    if (typeof datosRespuesta[0].success === 'undefined') {

                        this.polizas = datosRespuesta;
                    }
                })
                .catch(console.log)
        },
        borrarPoliza(id) {
            fetch('http://localhost/poliza/?borrar=' + id)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    window.location.href = "listar"


                })
                .catch(console.log)
        },
    }
}
</script>