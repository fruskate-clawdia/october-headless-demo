<template>
  <div class="todo-app">
    <h1>Todo List</h1>
    <p class="subtitle">
      Data lives in OctoberCMS database.
      Manage via <strong>Admin panel</strong> → you see changes here in real time 🔄
    </p>

    <!-- Add new todo -->
    <form @submit.prevent="handleAdd" class="add-form">
      <input v-model="newTodo" placeholder="Add a task..." autofocus />
      <button type="submit" :disabled="adding">{{ adding ? '...' : 'Add' }}</button>
    </form>

    <!-- Loading state -->
    <div v-if="loading" class="loading">Loading from OctoberCMS API...</div>
    <div v-else-if="error" class="error">{{ error }}</div>

    <!-- Stats -->
    <div class="stats" v-if="todos.length">
      <span>{{ pending.length }} pending</span>
      <span>{{ completed.length }} done</span>
      <button v-if="completed.length" @click="clearCompleted" class="clear-btn">
        Clear completed
      </button>
    </div>

    <!-- Todo list -->
    <ul class="todo-list">
      <li v-for="todo in todos" :key="todo.id" :class="{ done: todo.done }">
        <input
          type="checkbox"
          :checked="todo.done"
          @change="toggleTodo(todo)"
        />
        <span class="todo-text">{{ todo.title }}</span>
        <button @click="removeTodo(todo.id)" class="remove-btn">✕</button>
      </li>
    </ul>

    <p v-if="!loading && !todos.length" class="empty">
      No tasks yet. Add one above, or create in OctoberCMS admin!
    </p>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { getTodos, createTodo, updateTodo, deleteTodo } from '../api/client'

const todos = ref([])
const newTodo = ref('')
const loading = ref(true)
const adding = ref(false)
const error = ref(null)

const completed = computed(() => todos.value.filter(t => t.done))
const pending = computed(() => todos.value.filter(t => !t.done))

async function fetchTodos() {
  try {
    const { data } = await getTodos()
    todos.value = data.data
  } catch (e) {
    error.value = 'Failed to load todos from OctoberCMS API'
  } finally {
    loading.value = false
  }
}

async function handleAdd() {
  if (!newTodo.value.trim()) return
  adding.value = true
  try {
    const { data } = await createTodo(newTodo.value)
    todos.value.push(data.data)
    newTodo.value = ''
  } finally {
    adding.value = false
  }
}

async function toggleTodo(todo) {
  const { data } = await updateTodo(todo.id, { done: !todo.done })
  const idx = todos.value.findIndex(t => t.id === todo.id)
  if (idx !== -1) todos.value[idx] = data.data
}

async function removeTodo(id) {
  await deleteTodo(id)
  todos.value = todos.value.filter(t => t.id !== id)
}

async function clearCompleted() {
  await Promise.all(completed.value.map(t => deleteTodo(t.id)))
  todos.value = todos.value.filter(t => !t.done)
}

onMounted(fetchTodos)
</script>

<style scoped>
.todo-app { max-width: 500px; margin: 2rem auto; padding: 0 1rem; }
.subtitle { color: #888; font-size: 0.9rem; }
.add-form { display: flex; gap: 0.5rem; margin: 1.5rem 0; }
.add-form input { flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; }
.add-form button { padding: 0.5rem 1rem; background: #42b883; color: white; border: none; border-radius: 6px; cursor: pointer; }
.add-form button:disabled { background: #aaa; cursor: default; }
.stats { display: flex; gap: 1rem; align-items: center; font-size: 0.85rem; color: #666; margin-bottom: 1rem; }
.clear-btn { margin-left: auto; padding: 0.25rem 0.5rem; font-size: 0.8rem; color: #e55; background: none; border: 1px solid #e55; border-radius: 4px; cursor: pointer; }
.todo-list { list-style: none; padding: 0; margin: 0; }
.todo-list li { display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem 0; border-bottom: 1px solid #f0f0f0; }
.todo-text { flex: 1; }
.done .todo-text { text-decoration: line-through; color: #aaa; }
.remove-btn { background: none; border: none; color: #ccc; cursor: pointer; font-size: 0.9rem; }
.remove-btn:hover { color: #e55; }
.empty { color: #aaa; text-align: center; margin-top: 2rem; }
.loading { color: #888; margin: 2rem 0; }
.error { color: #e55; margin: 1rem 0; }
</style>
