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

export const getPosts = () => apiClient.get('/posts')
export const getPost = (slug) => apiClient.get(`/posts/${slug}`)
export const healthCheck = () => apiClient.get('/health')

export default apiClient
