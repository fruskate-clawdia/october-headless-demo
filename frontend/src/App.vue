<template>
  <AppNavbar />
  <main class="main-content">
    <router-view v-slot="{ Component }">
      <transition name="page" mode="out-in">
        <component :is="Component" />
      </transition>
    </router-view>
  </main>
</template>

<script setup>
import AppNavbar from './components/AppNavbar.vue'
</script>

<style scoped>
.main-content {
  padding: var(--space-2xl) 0 var(--space-3xl);
}
</style>
