<template>
  <div class="post">
    <router-link to="/">← Back</router-link>

    <div v-if="loading">Loading...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <article v-else>
      <h1>{{ post.title }}</h1>
      <time>{{ post.created_at }}</time>
      <!-- Content from OctoberCMS, rendered by Vue -->
      <div class="content" v-html="post.content" />
    </article>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { getPost } from '../api/client'

const route = useRoute()
const post = ref(null)
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    // URL slug from Vue Router — /posts/:slug
    const { data } = await getPost(route.params.slug)
    post.value = data.data
  } catch (e) {
    error.value = 'Post not found'
  } finally {
    loading.value = false
  }
})
</script>
