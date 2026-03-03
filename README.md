# OctoberCMS Headless + Vue.js Demo

> **Proof of concept**: OctoberCMS без CMS-модуля как чистый API backend, Vue.js как полноценный фронт со своим роутингом.
>
> Коллеги говорят что на OctoberCMS нельзя сделать фронт на чём угодно? Смотрите сюда 👇

## Суть

OctoberCMS — это не только CMS с Twig-шаблонами. Это **Laravel-фреймворк** с удобной экосистемой плагинов. CMS-модуль (страницы, шаблоны, медиа) — **опциональный компонент**, который можно отключить одной строкой.

После отключения:
- OctoberCMS = чистый Laravel API backend
- Фронт — **любой**: Vue.js, React, Next.js, Nuxt.js, мобильное приложение
- Данные — через REST API
- Admin-панель OctoberCMS работает как обычно для управления данными

## Что есть в этом репо

```
october-headless-demo/
├── backend/                         # OctoberCMS (Laravel)
│   ├── composer.json                # ← зависимости, с этого начинаем
│   ├── .env.example                 # ← конфиг (скопировать в .env)
│   ├── config/
│   │   └── cms.php                  # ← CMS_DISABLE_MODULE=true
│   └── plugins/demo/api/
│       ├── Plugin.php               # CORS + меню в Admin
│       ├── routes.php               # API роуты (/api/v1/*)
│       ├── models/
│       │   ├── Post.php
│       │   └── Todo.php
│       ├── http/controllers/
│       │   ├── PostController.php   # GET /api/v1/posts
│       │   └── TodoController.php   # CRUD /api/v1/todos
│       ├── controllers/
│       │   ├── Todos.php            # OctoberCMS Admin контроллер
│       │   └── todos/
│       │       ├── config_list.yaml # Список в Admin
│       │       └── config_form.yaml # Форма создания/редактирования
│       └── updates/
│           ├── version.yaml
│           └── create_todos_table.php
└── frontend/                        # Vue.js SPA
    ├── package.json                 # ← зависимости npm
    ├── vite.config.js               # Vite + proxy на backend
    ├── index.html
    └── src/
        ├── main.js
        ├── App.vue
        ├── router/index.js          # Vue Router — клиентский роутинг
        ├── api/client.js            # Axios → OctoberCMS API
        └── views/
            ├── HomeView.vue         # / — список постов
            ├── PostView.vue         # /posts/:slug
            ├── TodoView.vue         # /todos — Todo лист (API-backed)
            └── AboutView.vue        # /about
```

## Архитектура

```
┌─────────────────────────┐     GET /api/v1/todos     ┌──────────────────────────┐
│     Vue.js Frontend     │ ◄───────────────────────► │   OctoberCMS Backend     │
│   localhost:5173        │                            │   localhost:8000          │
│                         │                            │                          │
│  Vue Router (SPA)       │                            │  CMS Module: DISABLED ✗  │
│  /         → HomeView   │                            │  API Routes: ENABLED  ✓  │
│  /todos    → TodoView   │                            │  Admin Panel: /backend   │
│  /about    → AboutView  │                            │  Database: SQLite/MySQL  │
└─────────────────────────┘                            └──────────────────────────┘
```

## Установка и запуск

### 1. Backend (OctoberCMS)

```bash
cd backend

# Установить зависимости
composer install

# Скопировать конфиг
cp .env.example .env

# Сгенерировать ключ приложения
php artisan key:generate

# Создать SQLite базу (или настроить MySQL в .env)
touch database/database.sqlite

# Запустить миграции и установку
php artisan october:up

# Запустить сервер
php artisan serve
# → http://localhost:8000
```

Войти в Admin: `http://localhost:8000/backend`
Логин: `admin` / Пароль: задаётся при `october:up`

### 2. Frontend (Vue.js)

```bash
cd frontend

# Установить зависимости
npm install

# Запустить dev-сервер
npm run dev
# → http://localhost:5173
```

### 3. Проверить что работает

```bash
# API backend
curl http://localhost:8000/api/v1/health
# → {"status":"ok","cms_module":"disabled","message":"OctoberCMS headless API is running!"}

# Todos API
curl http://localhost:8000/api/v1/todos
# → {"data":[...]}
```

## Ключевой момент — одна строка отключает CMS

**`backend/config/cms.php`**:
```php
'disableCmsModule' => env('CMS_DISABLE_MODULE', true),
```

**`backend/.env`**:
```
CMS_DISABLE_MODULE=true
```

Всё. После этого OctoberCMS не обрабатывает ни один URL через свои шаблоны. Все маршруты — через стандартный Laravel Router в `routes.php` плагина.

## Демо: Admin → Vue.js синхронизация

1. Открываем Admin: `http://localhost:8000/backend`
2. Переходим в **Todos** (в меню слева)
3. Создаём задачу
4. Открываем Vue фронт: `http://localhost:5173/todos`
5. Видим только что созданную задачу — **без перезагрузки страницы**

И наоборот — добавляем задачу в Vue, она появляется в Admin.

## API Endpoints

| Method | URL | Описание |
|--------|-----|----------|
| GET | `/api/v1/health` | Проверка работы API |
| GET | `/api/v1/posts` | Список постов |
| GET | `/api/v1/posts/:slug` | Один пост |
| GET | `/api/v1/todos` | Список задач |
| POST | `/api/v1/todos` | Создать задачу |
| PUT | `/api/v1/todos/:id` | Обновить задачу |
| DELETE | `/api/v1/todos/:id` | Удалить задачу |

## Можно использовать любой фронт

OctoberCMS как backend — это просто Laravel API. Клиент может быть любым:

| Frontend | Поддержка |
|----------|-----------|
| Vue.js | ✅ (этот пример) |
| React | ✅ |
| Next.js | ✅ |
| Nuxt.js | ✅ |
| Мобильное приложение (iOS/Android) | ✅ |
| Postman / curl | ✅ |

---

*Demo by [Clawdia](https://t.me/ghostinthemachine_ai) for [Fruskate](https://t.me/fruskate)*
