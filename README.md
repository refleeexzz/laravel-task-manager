# 📋 Laravel Task Manager

[![Tests](https://github.com/refleeexzz/laravel-task-manager/actions/workflows/tests.yml/badge.svg)](https://github.com/refleeexzz/laravel-task-manager/actions/workflows/tests.yml)

A full-featured task management system built with Laravel 12, PostgreSQL, and modern frontend technologies.

## ✨ Features

- 🔐 **Authentication System** - User registration, login, and password recovery
- 📁 **Project Management** - Organize tasks into customizable projects
- ✅ **Task Management** - Create, edit, delete, and track tasks with priorities
- 👥 **Role-Based Access Control** - Admin, QA, Editor, and Reader roles
- 🔍 **QA Workflow** - Quality assurance review process for tasks
- 🏷️ **Categories** - Tag tasks with multiple categories
- 💬 **Comments** - Team collaboration on tasks
- 📎 **File Attachments** - Attach files to tasks
- 🌓 **Dark Mode** - System-based theme with manual toggle
- 🎯 **Modern UI** - Built with Tailwind CSS v4

## 🛠️ Tech Stack

- **Backend:** Laravel 12, PHP 8.3
- **Database:** PostgreSQL 16
- **Frontend:** Tailwind CSS v4, Vite, Alpine.js
- **Dev Tools:** Docker, Docker Compose, Laravel Pint

## 🚀 Quick Start

### With Docker (Recommended)

```bash
# clone the repository
git clone https://github.com/refleeexzz/laravel-task-manager.git
cd laravel-task-manager

# copy environment file
cp .env.example .env

# start docker containers
docker compose up -d

# install dependencies
docker compose exec app composer install
docker compose exec app npm install

# generate application key
docker compose exec app php artisan key:generate

# run migrations and seeders
docker compose exec app php artisan migrate --seed

# build frontend assets (vite runs automatically in docker)
# access the app at http://localhost:8000
```

### Without Docker

```bash
# install dependencies
composer install
npm install

# setup environment
cp .env.example .env
php artisan key:generate

# configure database in .env
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=laravel
# DB_USERNAME=your_user
# DB_PASSWORD=your_password

# run migrations
php artisan migrate --seed

# start dev servers
php artisan serve
npm run dev
```

## 🧪 Testing

```bash
# run all tests
php artisan test

# run specific test suite
php artisan test --testsuite=Feature

# run with coverage
php artisan test --coverage
```

## 👤 Default Users

After seeding, you can login with:

| Role   | Email              | Password |
|--------|-------------------|----------|
| Admin  | admin@example.com | password |
| QA     | qa@example.com    | password |
| Editor | editor@example.com| password |
| Reader | reader@example.com| password |

## 📝 User Roles & Permissions

- **Admin:** Full access to all features including user management
- **QA:** Can review tasks, approve/reject QA requests
- **Editor:** Can create/edit projects and tasks
- **Reader:** Read-only access to projects and tasks

## 🔒 Security Features

- CSRF protection on all forms
- SQL injection prevention via Eloquent ORM
- XSS protection with Blade escaping
- Mass assignment protection
- Input sanitization middleware
- Role-based authorization policies

## 📦 Project Structure

```
app/
├── Http/Controllers/     # application controllers
├── Models/              # eloquent models
├── Policies/            # authorization policies
└── Providers/           # service providers

resources/
├── views/              # blade templates
├── css/                # stylesheets
└── js/                 # javascript

database/
├── migrations/         # database migrations
├── factories/          # model factories
└── seeders/           # database seeders

tests/
├── Feature/           # feature tests
└── Unit/              # unit tests
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is open-sourced software licensed under the MIT license.
