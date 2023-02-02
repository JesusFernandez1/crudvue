<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Editar nuevo empleado
            </div>
            <div class="card-body">
                
                <form v-on:submit.prevent="actualizarRegistro">

                    <div class="mb-3">
                      <label for="nombre" class="form-label">Nombre:</label>
                      <input type="text"
                        class="form-control" required name="nombre" v-model="empleado.nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre">
                      <small id="helpId" class="form-text text-muted">Escribe el nombre</small>
                    </div>

                    <div class="mb-3">
                      <label for="correo" class="form-label">Correo</label>
                      <input type="email"
                        class="form-control" required name="correo" v-model="empleado.correo" id="correo" aria-describedby="helpId" placeholder="Correo">
                      <small id="helpId" class="form-text text-muted">Escribe el correo</small>
                    </div>

                    <div class="btn-group" role="group" aria-label="Button group name">
                        <button type="submit" class="btn btn-danger">Aceptar</button>
                        <router-link :to="{name:'Listar'}" class="btn btn-success">Cancelar</router-link>
                    </div>

                </form>

            </div>
            
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            empleado:{

            }
        }
    },
    created:function(){
        this.obtenerInformacionID();
    },
    methods:{

        obtenerInformacionID(){

           
            fetch('http://localhost/empleados/?consultar='+this.$route.params.id)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    this.empleado = datosRespuesta[0];

                })
                .catch(console.log)
        },
        actualizarRegistro(){
            var datosEnviar={id:this.$route.params.id, nombre:this.empleado.nombre, correo:this.empleado.correo}

            fetch('http://localhost/empleados/?actualizar='+this.$route.params.id, {
                method:"POST",
                body:JSON.stringify(datosEnviar)
            })
            .then(respuesta => respuesta.json())
            .then((datosRespuesta=>{

                console.log(datosRespuesta);
                window.location.href='../listar';
            }))
        }
    }
}
</script>