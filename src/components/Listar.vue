<template>
    <div>
        <div class="card">
            <div class="card-header">
                Empleados
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="empleado in empleados" :key="empleado.id">
                            <td>{{ empleado.id }}</td>
                            <td>{{ empleado.nombre }}</td>
                            <td>{{ empleado.correo }}</td>
                            <td>
                                <a class="btn btn-primary" href="#" role="button">Editar</a>
                                <a class="btn btn-primary" href="#" role="button">Borrar</a>
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
            empleados: []
        }
    },
    created: function () {
        this.consultarEmpelados();
    },
    methods: {
        consultarEmpelados() {
            fetch('http://localhost/empleados/')
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {


                    console.log(datosRespuesta)
                    this.empleados = []
                    if (typeof datosRespuesta[0].success === 'undefined') {

                        this.empleados = datosRespuesta;
                    }


                })
                .catch(console.log)
        }
    }
}
</script>