# OctoberCMS Headless + Vue.js Demo

> **Proof of concept**: OctoberCMS без CMS-модуля как чистый API backend, Vue.js как полноценный фронт со своим роутингом.

## Тезис

OctoberCMS — это не только CMS с шаблонами Twig. Это Laravel-фреймворк с удобной экосистемой плагинов. CMS-модуль (страницы, шаблоны, медиа) — **опциональный компонент**, который можно отключить.

После отключения:
- OctoberCMS = чистый Laravel API backend
- Фронт — любой: Vue.js, React, Next.js, Nuxt.js, мобильное приложение — что угодно
- Данные — через REST или GraphQL API

## Архитектура

```
┌─────────────────────────┐     HTTP/JSON      ┌──────────────────────────┐
│     Vue.js Frontend     │ ◄────────────────► │   OctoberCMS Backend     │
│                         │                    │                          │
│  Vue Router (SPA)       │                    │  CMS Module: DISABLED    │
│  Pinia (state)          │                    │  API Routes: ENABLED     │
│  Axios (HTTP client)    │                    │  Models + Plugins        │
└─────────────────────────┘                    └──────────────────────────┘
     localhost:5173                                 localhost:8000
```

## Структура проекта

```
october-headless-demo/
├── backend/                    # OctoberCMS (Laravel-based)
│   ├── config/
│   │   └── cms.php             # CMS module disabled here
│   └── plugins/
│       └── demo/
│           └── api/            # API Plugin
│               ├── Plugin.php
│               ├── routes.php  # API endpoints
│               └── models/
│                   └── Post.php
└── frontend/                   # Vue.js SPA
    ├── src/
    │   ├── main.js
    │   ├── router/index.js     # Vue Router (клиентский роутинг)
    │   ├── api/client.js       # Axios wrapper
    │   └── views/
    │       ├── HomeView.vue
    │       └── PostView.vue
    ├── package.json
    └── vite.config.js
```

## Ключевой момент — отключение CMS модуля

**`backend/config/cms.php`**:
```php
<?php return [
    'disableCmsModule' => true,  // ← Вот и всё!
];
```

Или через `.env`:
```
CMS_DISABLE_MODULE=true
```

После этого OctoberCMS перестаёт обрабатывать URL через свои шаблоны — все маршруты теперь через стандартный Laravel Router.

## Backend: API Plugin

**`backend/plugins/demo/api/routes.php`** — стандартный Laravel routing:
```php
<?php
Route::prefix('api/v1')->group(function () {
    Route::get('/posts', 'Demo\Api\Http\Controllers\PostController@index');
    Route::get('/posts/{slug}', 'Demo\Api\Http\Controllers\PostController@show');
});
```

Это чистый Laravel. Никакого Twig. Никаких CMS-шаблонов.

## Frontend: Vue.js со своим роутингом

Vue Router управляет URL полностью на клиенте:

```
/            → HomeView (список постов)
/posts/:slug → PostView (один пост)
/about       → AboutView
```

Vue не знает об OctoberCMS. Он просто делает fetch на API и рендерит данные.

## Запуск

### Backend (OctoberCMS)
```bash
cd backend
composer install
php artisan october:up
php artisan serve  # → localhost:8000
```

### Frontend (Vue.js)
```bash
cd frontend
npm install
npm run dev  # → localhost:5173
```

## Итог

| Возможность | OctoberCMS Headless |
|-------------|---------------------|
| Vue.js frontend | ✅ |
| React frontend | ✅ |
| Next.js / Nuxt | ✅ |
| Mobile app | ✅ |
| Любой HTTP клиент | ✅ |
| CMS module | Отключён (не нужен) |

**OctoberCMS — это Laravel. А на Laravel можно сделать API для любого фронта.**

---

*Demo created by [Clawdia](https://t.me/ghostinthemachine_ai) for [Fruskate](https://t.me/fruskate)*
