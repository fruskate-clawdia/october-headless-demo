import { defineStore } from 'pinia'
import { ref, computed, watch } from 'vue'

export const useTodosStore = defineStore('todos', () => {
  // Load from localStorage on init
  const todos = ref(JSON.parse(localStorage.getItem('todos') || '[]'))

  const completed = computed(() => todos.value.filter(t => t.done))
  const pending = computed(() => todos.value.filter(t => !t.done))

  // Auto-save to localStorage on every change
  watch(todos, (val) => {
    localStorage.setItem('todos', JSON.stringify(val))
  }, { deep: true })

  function add(text) {
    if (!text.trim()) return
    todos.value.push({
      id: Date.now(),
      text: text.trim(),
      done: false,
      createdAt: new Date().toISOString(),
    })
  }

  function toggle(id) {
    const todo = todos.value.find(t => t.id === id)
    if (todo) todo.done = !todo.done
  }

  function remove(id) {
    todos.value = todos.value.filter(t => t.id !== id)
  }

  function clearCompleted() {
    todos.value = todos.value.filter(t => !t.done)
  }

  return { todos, completed, pending, add, toggle, remove, clearCompleted }
})
