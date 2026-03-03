<template>
  <div class="container">
    <header class="page-header animate-in">
      <h1>Todos</h1>
      <p class="page-subtitle">
        Data lives in OctoberCMS database. Manage via Admin panel — changes sync in real time.
      </p>
    </header>

    <!-- Add form -->
    <form @submit.prevent="handleAdd" class="add-form glass-card animate-in">
      <input
        v-model="newTodo"
        placeholder="Add a task..."
        class="add-form__input"
        autofocus
      />
      <button type="submit" class="add-form__btn" :disabled="adding">
        {{ adding ? '...' : 'Add' }}
      </button>
    </form>

    <!-- Loading -->
    <div v-if="loading" class="stagger-children" style="margin-top: var(--space-lg)">
      <div v-for="n in 3" :key="n" class="glass-card skeleton-todo">
        <div class="skeleton" style="height: 1rem; width: 60%"></div>
      </div>
    </div>

    <div v-else-if="error" class="error-message animate-in">{{ error }}</div>

    <template v-else>
      <!-- Stats -->
      <div class="stats animate-in" v-if="todos.length">
        <span class="badge badge--teal">{{ pending.length }} pending</span>
        <span class="badge badge--amber">{{ completed.length }} done</span>
        <button v-if="completed.length" @click="clearCompleted" class="clear-btn">
          Clear completed
        </button>
      </div>

      <!-- Todo list -->
      <div class="todo-list stagger-children">
        <div
          v-for="todo in todos"
          :key="todo.id"
          class="todo-item glass-card"
          :class="{ 'todo-item--done': todo.done }"
        >
          <label class="todo-item__check">
            <input
              type="checkbox"
              :checked="todo.done"
              @change="toggleTodo(todo)"
              class="todo-item__input"
            />
            <span class="todo-item__indicator"></span>
          </label>
          <span class="todo-item__text">{{ todo.title }}</span>
          <button @click="removeTodo(todo.id)" class="todo-item__remove" aria-label="Remove">
            &times;
          </button>
        </div>
      </div>

      <p v-if="!todos.length" class="empty-state animate-in">
        No tasks yet. Add one above, or create in OctoberCMS admin!
      </p>
    </template>
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
.page-header {
  margin-bottom: var(--space-xl);
}

.page-subtitle {
  color: var(--color-muted);
  font-size: var(--text-sm);
  margin-top: var(--space-xs);
}

/* Add form */
.add-form {
  display: flex;
  gap: var(--space-sm);
  padding: var(--space-md);
}

.add-form__input {
  flex: 1;
  padding: var(--space-sm) var(--space-md);
  background: rgba(15, 23, 42, 0.5);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-sm);
  color: var(--color-text);
  font-size: var(--text-base);
  outline: none;
  transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.add-form__input::placeholder {
  color: var(--color-muted);
}

.add-form__input:focus {
  border-color: var(--color-teal);
  box-shadow: 0 0 0 3px rgba(6, 214, 160, 0.15);
}

.add-form__btn {
  padding: var(--space-sm) var(--space-lg);
  background: var(--color-teal);
  color: var(--color-base);
  border: none;
  border-radius: var(--radius-sm);
  font-weight: 600;
  font-size: var(--text-sm);
  transition: opacity var(--transition-fast), transform var(--transition-fast);
}

.add-form__btn:hover:not(:disabled) {
  opacity: 0.9;
  transform: translateY(-1px);
}

.add-form__btn:disabled {
  opacity: 0.5;
  cursor: default;
}

/* Stats */
.stats {
  display: flex;
  align-items: center;
  gap: var(--space-sm);
  margin: var(--space-lg) 0;
}

.clear-btn {
  margin-left: auto;
  padding: var(--space-xs) var(--space-md);
  background: none;
  border: 1px solid rgba(255, 0, 110, 0.3);
  border-radius: var(--radius-pill);
  color: var(--color-rose);
  font-size: var(--text-xs);
  font-weight: 500;
  transition: background var(--transition-fast), border-color var(--transition-fast);
}

.clear-btn:hover {
  background: rgba(255, 0, 110, 0.1);
  border-color: var(--color-rose);
}

/* Todo list */
.todo-list {
  display: flex;
  flex-direction: column;
  gap: var(--space-sm);
}

.todo-item {
  display: flex;
  align-items: center;
  gap: var(--space-md);
  padding: var(--space-md) var(--space-lg);
}

/* Custom checkbox */
.todo-item__check {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.todo-item__input {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

.todo-item__indicator {
  width: 22px;
  height: 22px;
  border-radius: 50%;
  border: 2px solid var(--color-muted);
  cursor: pointer;
  transition: border-color var(--transition-fast), background var(--transition-fast), transform var(--transition-bounce);
}

.todo-item__input:checked + .todo-item__indicator {
  border-color: var(--color-teal);
  background: var(--color-teal);
  transform: scale(1.1);
}

.todo-item__input:checked + .todo-item__indicator::after {
  content: '';
  display: block;
  width: 6px;
  height: 10px;
  margin: 2px auto 0;
  border: solid var(--color-base);
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

.todo-item__text {
  flex: 1;
  transition: color var(--transition-fast), opacity var(--transition-fast);
}

.todo-item--done .todo-item__text {
  text-decoration: line-through;
  color: var(--color-muted);
  opacity: 0.6;
}

.todo-item__remove {
  background: none;
  border: none;
  color: var(--color-muted);
  font-size: 1.3rem;
  line-height: 1;
  padding: var(--space-xs);
  border-radius: var(--radius-sm);
  opacity: 0;
  transition: color var(--transition-fast), opacity var(--transition-fast), background var(--transition-fast);
}

.todo-item:hover .todo-item__remove {
  opacity: 1;
}

.todo-item__remove:hover {
  color: var(--color-rose);
  background: rgba(255, 0, 110, 0.1);
}

.skeleton-todo {
  height: 56px;
  margin-bottom: var(--space-sm);
  display: flex;
  align-items: center;
  padding: var(--space-md) var(--space-lg);
}

.error-message {
  color: var(--color-rose);
  padding: var(--space-lg);
}

.empty-state {
  color: var(--color-muted);
  text-align: center;
  padding: var(--space-3xl) 0;
}
</style>
