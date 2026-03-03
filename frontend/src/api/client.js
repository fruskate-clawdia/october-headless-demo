import axios from 'axios'

// API client — points to OctoberCMS backend
// In dev: Vite proxy handles /api → localhost:8000
// In prod: set VITE_API_BASE_URL env variable
const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || '/api/v1',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

export const healthCheck = () => apiClient.get('/health')

// Todos API
export const getTodos = () => apiClient.get('/todos')
export const createTodo = (title) => apiClient.post('/todos', { title })
export const updateTodo = (id, data) => apiClient.put(`/todos/${id}`, data)
export const deleteTodo = (id) => apiClient.delete(`/todos/${id}`)

export default apiClient
