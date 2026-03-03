<template>
  <div id="app">
    <nav>
      <router-link to="/">Posts</router-link>
      <router-link to="/about">About</router-link>
    </nav>
    <!-- Vue Router renders the active view here -->
    <!-- OctoberCMS knows nothing about these routes -->
    <router-view />
  </div>
</template>

<script setup>
// App root — pure Vue.js
// No connection to OctoberCMS templates whatsoever
</script>
