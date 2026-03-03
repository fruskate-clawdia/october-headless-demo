<template>
  <div class="not-found container">
    <div class="not-found__inner animate-in">
      <h1 class="not-found__code">404</h1>
      <p class="not-found__text">This 404 is handled by Vue Router, not OctoberCMS.</p>
      <router-link to="/" class="not-found__btn">Back Home</router-link>
    </div>
  </div>
</template>

<style scoped>
.not-found {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: calc(60vh - var(--navbar-height));
}

.not-found__inner {
  text-align: center;
}

.not-found__code {
  font-size: var(--text-3xl);
  font-family: var(--font-display);
  font-weight: 700;
  background: linear-gradient(135deg, var(--color-teal), var(--color-violet), var(--color-rose));
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  line-height: 1.1;
  margin-bottom: var(--space-md);
}

.not-found__text {
  color: var(--color-muted);
  margin-bottom: var(--space-2xl);
  font-size: var(--text-base);
}

.not-found__btn {
  display: inline-flex;
  align-items: center;
  padding: var(--space-sm) var(--space-xl);
  background: var(--color-teal);
  color: var(--color-base);
  font-weight: 600;
  font-size: var(--text-sm);
  border-radius: var(--radius-pill);
  text-decoration: none;
  transition: opacity var(--transition-fast), transform var(--transition-fast);
}

.not-found__btn:hover {
  opacity: 0.9;
  transform: translateY(-1px);
  color: var(--color-base);
}
</style>
