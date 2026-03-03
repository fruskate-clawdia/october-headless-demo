<template>
  <div class="home">
    <h1>Posts from OctoberCMS API</h1>

    <div v-if="loading">Loading...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else>
      <article v-for="post in posts" :key="post.id">
        <h2>
          <!-- Vue Router link — client-side navigation, no page reload -->
          <router-link :to="`/posts/${post.slug}`">
            {{ post.title }}
          </router-link>
        </h2>
        <time>{{ post.created_at }}</time>
      </article>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { getPosts } from '../api/client'

const posts = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    // Single API call to OctoberCMS backend
    // OctoberCMS returns JSON — Vue renders it
    const { data } = await getPosts()
    posts.value = data.data
  } catch (e) {
    error.value = 'Failed to load posts from OctoberCMS API'
  } finally {
    loading.value = false
  }
})
</script>
