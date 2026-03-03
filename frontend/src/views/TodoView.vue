<template>
  <div class="todo-app">
    <h1>Todo List</h1>
    <p class="subtitle">Pure Vue.js + Pinia. OctoberCMS doesn't know this page exists 😄</p>

    <!-- Add new todo -->
    <form @submit.prevent="handleAdd" class="add-form">
      <input
        v-model="newTodo"
        placeholder="Add a task..."
        autofocus
      />
      <button type="submit">Add</button>
    </form>

    <!-- Stats -->
    <div class="stats" v-if="store.todos.length">
      <span>{{ store.pending.length }} pending</span>
      <span>{{ store.completed.length }} done</span>
      <button
        v-if="store.completed.length"
        @click="store.clearCompleted()"
        class="clear-btn"
      >
        Clear completed
      </button>
    </div>

    <!-- Todo list -->
    <ul class="todo-list">
      <li
        v-for="todo in store.todos"
        :key="todo.id"
        :class="{ done: todo.done }"
      >
        <input
          type="checkbox"
          :checked="todo.done"
          @change="store.toggle(todo.id)"
        />
        <span class="todo-text">{{ todo.text }}</span>
        <button @click="store.remove(todo.id)" class="remove-btn">✕</button>
      </li>
    </ul>

    <p v-if="!store.todos.length" class="empty">No tasks yet. Add one above!</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useTodosStore } from '../stores/todos'

const store = useTodosStore()
const newTodo = ref('')

function handleAdd() {
  store.add(newTodo.value)
  newTodo.value = ''
}
</script>

<style scoped>
.todo-app { max-width: 500px; margin: 2rem auto; padding: 0 1rem; }
.subtitle { color: #888; font-size: 0.9rem; }
.add-form { display: flex; gap: 0.5rem; margin: 1.5rem 0; }
.add-form input { flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; }
.add-form button { padding: 0.5rem 1rem; background: #42b883; color: white; border: none; border-radius: 6px; cursor: pointer; }
.stats { display: flex; gap: 1rem; align-items: center; font-size: 0.85rem; color: #666; margin-bottom: 1rem; }
.clear-btn { margin-left: auto; padding: 0.25rem 0.5rem; font-size: 0.8rem; color: #e55; background: none; border: 1px solid #e55; border-radius: 4px; cursor: pointer; }
.todo-list { list-style: none; padding: 0; margin: 0; }
.todo-list li { display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem 0; border-bottom: 1px solid #f0f0f0; }
.todo-text { flex: 1; }
.done .todo-text { text-decoration: line-through; color: #aaa; }
.remove-btn { background: none; border: none; color: #ccc; cursor: pointer; font-size: 0.9rem; }
.remove-btn:hover { color: #e55; }
.empty { color: #aaa; text-align: center; margin-top: 2rem; }
</style>
