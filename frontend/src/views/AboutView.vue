<template>
  <div class="container">
    <header class="page-header animate-in">
      <h1>About this demo</h1>
      <p class="page-subtitle">
        This page is rendered entirely by Vue.js.
        OctoberCMS has no idea this route exists.
      </p>
    </header>

    <p class="about-intro animate-in">
      The backend (OctoberCMS) only handles <code>/api/v1/*</code> requests.
      Everything else — routing, rendering, state — is Vue.js.
    </p>

    <div class="feature-grid stagger-children">
      <div v-for="feature in features" :key="feature.title" class="feature-card glass-card">
        <span class="feature-card__icon" :style="{ color: feature.color }">{{ feature.icon }}</span>
        <h3 class="feature-card__title">{{ feature.title }}</h3>
        <p class="feature-card__desc">{{ feature.desc }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
const features = [
  {
    icon: '\u21C4',
    color: 'var(--color-teal)',
    title: 'Vue Router',
    desc: 'Handles all client-side routes. OctoberCMS never sees navigation between pages.'
  },
  {
    icon: '\u2716',
    color: 'var(--color-rose)',
    title: 'CMS Module Disabled',
    desc: 'OctoberCMS CMS module is disabled — it runs as a pure headless API server.'
  },
  {
    icon: '\u21E9',
    color: 'var(--color-sky)',
    title: 'REST API',
    desc: 'Data comes from OctoberCMS REST API endpoints at /api/v1/* prefix.'
  },
  {
    icon: '\u2194',
    color: 'var(--color-violet)',
    title: 'Swappable Frontend',
    desc: 'You can replace Vue with React, Nuxt, Next.js — anything that speaks HTTP.'
  }
]
</script>

<style scoped>
.page-header {
  margin-bottom: var(--space-lg);
}

.page-subtitle {
  color: var(--color-muted);
  font-size: var(--text-sm);
  margin-top: var(--space-xs);
}

.about-intro {
  color: var(--color-muted);
  margin-bottom: var(--space-2xl);
  line-height: 1.7;
}

.about-intro code {
  background: rgba(148, 163, 184, 0.1);
  padding: 0.15em 0.4em;
  border-radius: var(--radius-sm);
  font-size: 0.9em;
  color: var(--color-teal);
}

.feature-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: var(--space-md);
}

@media (max-width: 600px) {
  .feature-grid {
    grid-template-columns: 1fr;
  }
}

.feature-card {
  display: flex;
  flex-direction: column;
  gap: var(--space-sm);
}

.feature-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
}

.feature-card__icon {
  font-size: 1.8rem;
  line-height: 1;
}

.feature-card__title {
  font-size: var(--text-base);
}

.feature-card__desc {
  color: var(--color-muted);
  font-size: var(--text-sm);
  line-height: 1.6;
}
</style>
