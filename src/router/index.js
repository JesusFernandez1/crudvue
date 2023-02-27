import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/Login.vue'
import Crear from '../components/Crear.vue'
import Listar from '../components/Listar.vue'
import Modificar from '../components/Modificar.vue'
import Polizas from '../components/Polizas.vue'
import ModificarPoliza from '../components/ModificarPoliza.vue'
import CrearPoliza from '../components/CrearPoliza.vue'
import VerPolizas from '../components/VerPolizas.vue'
import MostrarCliente from '../components/MostrarCliente.vue'
import confirmarEliminar from '../components/confirmarEliminar.vue'
import confirmarEliminarPoliza from '../components/confirmarEliminarPoliza.vue'
import filtrar from '../components/filtrar.vue'

const routes = [
  {
    path: '/',
    name: 'login',
    component: Login
  },
  {
    path: '/crear',
    name: 'crear',
    component: Crear
  },
  {
    path: '/listar',
    name: 'listar',
    component: Listar
  },
  {
    path: '/modificar/:id',
    name: 'modificar',
    component: Modificar
  },
  {
    path: '/VerPolizas',
    name: 'VerPolizas',
    component: VerPolizas
  },
  {
    path: '/MostrarCliente/:id',
    name: 'MostrarCliente',
    component: MostrarCliente
  },
  {
    path: '/polizas/:id',
    name: 'polizas',
    component: Polizas
  },
  {
    path: '/modificarpoliza/:id',
    name: 'modificarpoliza',
    component: ModificarPoliza
  },
  {
    path: '/confirmarEliminar/:id',
    name: 'confirmarEliminar',
    component: confirmarEliminar
  },
  {
    path: '/confirmarEliminarPoliza/:id',
    name: 'confirmarEliminarPoliza',
    component: confirmarEliminarPoliza
  },
  {
    path: '/crearPoliza/:id',
    name: 'crearPoliza',
    component: CrearPoliza
  },
  {
    path: '/filtrar',
    name: 'filtrar',
    component: filtrar
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
