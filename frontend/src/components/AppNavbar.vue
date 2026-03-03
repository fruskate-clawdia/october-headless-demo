<template>
  <nav class="navbar">
    <div class="navbar__inner container--wide">
      <router-link to="/" class="navbar__brand">
        <span class="navbar__logo">&#9680;</span>
        <span class="navbar__name">OctoberCMS</span>
      </router-link>

      <div class="navbar__links">
        <router-link to="/" class="navbar__link" exact-active-class="navbar__link--active">
          Todos
        </router-link>
        <router-link to="/about" class="navbar__link" active-class="navbar__link--active">
          About
        </router-link>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.navbar {
  position: sticky;
  top: 0;
  z-index: 100;
  height: var(--navbar-height);
  background: rgba(15, 23, 42, 0.75);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid var(--glass-border);
}

.navbar__inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 100%;
  max-width: var(--container-wide);
  margin: 0 auto;
  padding: 0 var(--space-lg);
}

.navbar__brand {
  display: flex;
  align-items: center;
  gap: var(--space-sm);
  color: var(--color-text);
  text-decoration: none;
  transition: opacity var(--transition-fast);
}

.navbar__brand:hover {
  opacity: 0.85;
  color: var(--color-text);
}

.navbar__logo {
  font-size: 1.6rem;
  color: var(--color-teal);
  line-height: 1;
}

.navbar__name {
  font-family: var(--font-display);
  font-weight: 600;
  font-size: var(--text-base);
  letter-spacing: -0.01em;
}

.navbar__links {
  display: flex;
  gap: var(--space-xl);
}

.navbar__link {
  position: relative;
  color: var(--color-muted);
  text-decoration: none;
  font-size: var(--text-sm);
  font-weight: 500;
  padding: var(--space-xs) 0;
  transition: color var(--transition-fast);
}

.navbar__link:hover {
  color: var(--color-text);
}

.navbar__link::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 100%;
  height: 2px;
  background: var(--color-teal);
  border-radius: 1px;
  transform: scaleX(0);
  transition: transform var(--transition-base);
}

.navbar__link--active {
  color: var(--color-text);
}

.navbar__link--active::after {
  transform: scaleX(1);
}
</style>
