<template>
    <div>
        <div class="card">
            <div class="card-header">
                Usuarios
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
                        <tr v-for="usuario in usuarios" :key="usuario.id">
                            <td>{{ usuario.id }}</td>
                            <td>{{ usuario.nombre }}</td>
                            <td>{{ usuario.apellido }}</td>
                            <td>{{ usuario.telefono }}</td>
                            <td>{{ usuario.tipo }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="">
                                    <router-link :to="{ name: 'Editar', params: { id: usuario.id } }"
                                        class="btn btn-info">Editar</router-link>
                                    <button type="button" v-on:click="borrarusuario(usuario.id)"
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
            usuarios: []
        }
    },
    created: function () {
        this.consultarEmpelados();
    },
    methods: {
        consultarEmpelados() {
            fetch('http://localhost/user/')
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {


                    console.log(datosRespuesta)
                    this.usuarios = []
                    if (typeof datosRespuesta[0].success === 'undefined') {

                        this.usuarios = datosRespuesta;
                    }


                })
                .catch(console.log)
        },
        borrarusuario(id) {
            fetch('http://localhost/usuarios/?borrar=' + id)
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