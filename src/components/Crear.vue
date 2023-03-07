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
            <router-link class="nav-link" to="/VerPolizas">Ver cuotas</router-link>
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
  <div class="container">
      <div class="card">
          <div class="card-header">
              Nuevo cliente
          </div>
          <div class="card-body">
              
            <form v-on:submit.prevent="agregarRegistro">

                <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" required name="nombre" v-model="cliente.nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre">
                    <small id="helpId" class="form-text text-muted">Escribe el nombre</small>
                </div>

                <div class="mb-3">
                  <label for="apellido" class="form-label">Apellido:</label>
                  <input type="text" class="form-control" required name="apellido" v-model="cliente.apellido" id="apellido" aria-describedby="helpId" placeholder="Apellido">
                  <small id="helpId" class="form-text text-muted">Escribe el apellido</small>
                </div>

                <div class="mb-3">
                  <label for="Telefono" class="form-label">Telefono:</label>
                  <input type="text" class="form-control" required name="Telefono" v-model="cliente.telefono" id="Telefono" aria-describedby="helpId" placeholder="Telefono">
                  <small id="helpId" class="form-text text-muted">Escribe el Telefono</small>
                </div>

                  <div class="mb-3">
                    <label for="provincia">Provincia:</label>
                    <select v-model="provinciaSeleccionada" required name="provincia" id="provincia" class="form-select" aria-label="Default select example">
                      <option value="">Selecciona una provincia</option>
                      <option v-for="provincia in provincias" :key="provincia.id" :value="provincia.id">
                        {{ provincia.provincia }}
                      </option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label for="codigo_postal" class="form-label">Codigo Postal:</label>
                    <input type="text" class="form-control" required name="codigo_postal" v-model="cliente.codigo_postal" id="codigo_postal" aria-describedby="helpId" placeholder="Codigo Postal">
                    <small id="helpId" class="form-text text-muted">Escribe el codgio Postal</small>
                  </div>

                  <div class="mb-3">
                    <label for="municipio" class="form-label">Municipio:</label>
                    <select v-model="municipioSeleccionado" required name="municipio" id="municipio" class="form-select" aria-label="Default select example">
                      <option value="">Selecciona un municipio</option>
                      <option v-for="municipio in municipios" :key="municipio.id" :value="municipio.id">
                        {{ municipio.municipio }}
                      </option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de cliente:</label>
                      <select v-model="cliente.tipo" required name="tipo" id="tipo" class="form-select" aria-label="Default select example">
                        <option disabled selected>Elija un tipo</option>
                        <option value="Particular">Particular</option>
                        <option value="Empresa">Empresa</option>
                      </select>
                  </div>

                  <div class="btn-group" role="group" aria-label="Button group name">
                    <button type="submit" class="btn btn-success">Aceptar</button>
                    <router-link :to="{name:'login'}" class="btn btn-warning">Cancelar</router-link>
                  </div>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      provincias: [],
      municipios: [],
      provinciaSeleccionada: '',
      municipioSeleccionado: '',
      cliente:{

      }
    }
  },
  created() {
    this.cargarProvincias()
  },
  methods: {
    cargarProvincias() {
      fetch('https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/provincias/')
        .then(respuesta => respuesta.json())
        .then(provincias => {
          this.provincias = provincias
        })
        .catch(error => {
          console.log(error)
        })
    },
    cargarMunicipios() {
      if (this.provinciaSeleccionada) {
        fetch(`https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/municipios/?consultarMunicipio=${this.provinciaSeleccionada}`)
          .then(respuesta => respuesta.json())
          .then(municipios => {
            this.municipios = municipios
          })
          .catch(error => {
            console.log(error)
          })
      } else {
        this.municipios = []
      }
    },
    agregarRegistro(){
            var datosEnviar={nombre: this.cliente.nombre, apellido: this.cliente.apellido, telefono: this.cliente.telefono, provincia: this.provinciaSeleccionada,
                codigo_postal: this.cliente.codigo_postal, municipio: this.municipioSeleccionado, tipo: this.cliente.tipo}
            fetch('https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/user/?insertar=1', {
                method:"POST",
                body:JSON.stringify(datosEnviar)
            })
            .then(respuesta => respuesta.json())
            .then((datosRespuesta => {
                if (JSON.stringify(datosRespuesta) == 'true') {
                  this.$router.push({name: "listar"});
                }  
            }))
        }
  },
  watch: {
    provinciaSeleccionada() {
      this.cargarMunicipios()
    }
  }
}
</script>