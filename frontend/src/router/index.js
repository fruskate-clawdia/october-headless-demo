import { createRouter, createWebHistory } from 'vue-router'
import AboutView from '../views/AboutView.vue'
import TodoView from '../views/TodoView.vue'

/**
 * Vue Router — client-side routing
 *
 * OctoberCMS knows nothing about these URLs.
 * All routing is handled on the Vue.js client side.
 * The backend only sees /api/* requests.
 */
const routes = [
  {
    path: '/',
    name: 'home',
    component: TodoView,
    meta: { title: 'Todos' }
  },
  {
    path: '/todos',
    redirect: '/'
  },
  {
    path: '/about',
    name: 'about',
    component: AboutView,
    meta: { title: 'About' }
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: () => import('../views/NotFoundView.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Update page title
router.afterEach((to) => {
  document.title = `${to.meta.title || 'App'} — OctoberCMS Headless Demo`
})

export default router
