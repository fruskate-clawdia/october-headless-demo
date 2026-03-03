import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import PostView from '../views/PostView.vue'
import AboutView from '../views/AboutView.vue'
import TodoView from '../views/TodoView.vue'

/**
 * Vue Router — клиентский роутинг
 *
 * OctoberCMS ничего не знает об этих URL.
 * Весь routing обрабатывается на клиенте Vue.js.
 * Backend видит только /api/* запросы.
 */
const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: { title: 'Posts' }
  },
  {
    path: '/posts/:slug',
    name: 'post',
    component: PostView,
    meta: { title: 'Post' }
  },
  {
    path: '/todos',
    name: 'todos',
    component: TodoView,
    meta: { title: 'Todo List' }
  },
  {
    path: '/about',
    name: 'about',
    component: AboutView,
    meta: { title: 'About' }
  },
  // Any other route — Vue handles it, not OctoberCMS
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
