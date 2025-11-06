# 📋 Laravel Task Manager<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



a full-featured task management system built with Laravel 12, PostgreSQL, and modern front-end technologies. this project demonstrates proficiency in Laravel ecosystem, database design, and clean code practices.<p align="center">

<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>

## ✨ Features<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>

<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>

- 🔐 **authentication system** - complete user registration, login, and password recovery<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>

- 📁 **project management** - organize tasks into customizable projects</p>

- ✅ **task management** - create, edit, delete, and track tasks with priorities and deadlines

- 🏷️ **categories** - tag tasks with multiple categories for better organization## About Laravel

- 💬 **comments** - collaborate on tasks with team members through comments

- 📎 **file attachments** - attach files to tasks for documentationLaravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- 🎨 **customizable** - projects and categories with custom colors

- 📊 **status tracking** - monitor task progress (todo, in progress, completed)- [Simple, fast routing engine](https://laravel.com/docs/routing).

- [Powerful dependency injection container](https://laravel.com/docs/container).

## 🛠️ Tech Stack- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.

- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).

### Backend- Database agnostic [schema migrations](https://laravel.com/docs/migrations).

- **Laravel 12** - PHP framework- [Robust background job processing](https://laravel.com/docs/queues).

- **PostgreSQL** - relational database- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

- **Eloquent ORM** - database relationships and queries

Laravel is accessible, powerful, and provides tools required for large, robust applications.

### Frontend

- **Blade Templates** - server-side templating## Learning Laravel

- **Tailwind CSS** - utility-first styling

- **Alpine.js** - lightweight JavaScript frameworkLaravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

- **Vite** - modern build tool

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

### Development Tools

- **Docker & Docker Compose** - containerization and orchestration
- **Laravel Breeze** - authentication scaffolding## Laravel Sponsors

- **Faker** - test data generation

- **PHPUnit** - testing frameworkWe would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).



## 📊 Database Schema### Premium Partners



```- **[Vehikl](https://vehikl.com)**

users- **[Tighten Co.](https://tighten.co)**

├── id- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**

├── name- **[64 Robots](https://64robots.com)**

├── email- **[Curotec](https://www.curotec.com/services/technologies/laravel)**

└── password- **[DevSquad](https://devsquad.com/hire-laravel-developers)**

- **[Redberry](https://redberry.international/laravel-development)**

projects- **[Active Logic](https://activelogic.com)**

├── id

├── user_id (FK → users)## Contributing

├── name

├── descriptionThank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

├── color

└── status## Code of Conduct



tasksIn order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

├── id

├── project_id (FK → projects)## Security Vulnerabilities

├── user_id (FK → users)

├── titleIf you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

├── description

├── priority (low, medium, high)## License

├── status (todo, in_progress, completed)

├── due_dateThe Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

└── completed_at

categories
├── id
├── name
└── color

category_task (pivot)
├── category_id (FK → categories)
└── task_id (FK → tasks)

comments
├── id
├── task_id (FK → tasks)
├── user_id (FK → users)
└── content

attachments
├── id
├── task_id (FK → tasks)
├── user_id (FK → users)
├── filename
├── path
├── mime_type
└── size
```

## 🚀 Getting Started

### Prerequisites

- **Docker** and **Docker Compose** installed on your machine
- Git

> **Note:** This project uses Docker for containerization, so you don't need to install PHP, Composer, PostgreSQL, or Node.js locally!

### Installation with Docker

1. **clone the repository**
```bash
git clone https://github.com/refleeexzz/laravel-task-manager.git
cd laravel-task-manager
```

2. **set up environment file**
```bash
cp .env.example .env
```

3. **configure database in .env for Docker**
```env
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=laravel_tasks
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

4. **build and start Docker containers**
```bash
docker-compose up -d
```

5. **install PHP dependencies inside the container**
```bash
docker-compose exec app composer install
```

6. **generate application key**
```bash
docker-compose exec app php artisan key:generate
```

7. **run migrations and seeders**
```bash
docker-compose exec app php artisan migrate --seed
```

8. **install Node.js dependencies and build assets**
```bash
docker-compose exec app npm install
docker-compose exec app npm run build
```

visit `http://localhost:8000` in your browser.

### Docker Commands

**Start containers:**
```bash
docker-compose up -d
```

**Stop containers:**
```bash
docker-compose down
```

**View logs:**
```bash
docker-compose logs -f
```

**Access container shell:**
```bash
docker-compose exec app bash
```

**Run artisan commands:**
```bash
docker-compose exec app php artisan [command]
```

### Alternative: Local Installation (without Docker)

If you prefer to run without Docker:

**Prerequisites:**
- PHP 8.3 or higher
- Composer
- PostgreSQL 16 or higher
- Node.js 18+ and npm

Follow the traditional installation steps and configure `.env` with your local database credentials.

### Default Test User

- **Email:** john@example.com
- **Password:** password

## 📁 Project Structure

```
app/
├── Models/              # eloquent models with relationships
│   ├── User.php
│   ├── Project.php
│   ├── Task.php
│   ├── Category.php
│   ├── Comment.php
│   └── Attachment.php
├── Http/
│   └── Controllers/     # request handlers
└── ...

database/
├── migrations/          # database schema definitions
├── seeders/            # sample data generators
└── factories/          # model factories for testing

resources/
├── views/              # blade templates
└── js/                 # frontend JavaScript
```

## 🧪 Testing

run the test suite with Docker:

```bash
docker-compose exec app php artisan test
```

or without Docker:

```bash
php artisan test
```

## 🌱 Seeded Data

the database seeder creates:
- **6 users** (including test user)
- **10 projects** with different statuses
- **50 tasks** with various priorities and deadlines
- **8 predefined categories** (Work, Personal, Urgent, etc.)
- **100 comments** across tasks

## 🔑 Key Features Demonstrated

### eloquent relationships
- **one-to-many**: User → Projects, User → Tasks
- **many-to-many**: Tasks ↔ Categories (with pivot table)
- **polymorphic relationships** potential for future expansion

### database design
- proper foreign key constraints
- cascade deletes for data integrity
- indexed columns for performance
- normalized structure

### best practices
- PSR-12 coding standards
- repository pattern ready
- service layer architecture potential
- comprehensive PHPDoc comments
- mass assignment protection
- type hinting throughout

## 🎨 Customization

### adding new categories
```php
Category::create([
    'name' => 'Marketing',
    'color' => '#FF6B6B'
]);
```

### creating tasks programmatically
```php
Task::create([
    'user_id' => auth()->id(),
    'project_id' => 1,
    'title' => 'New Feature',
    'description' => 'Implement user dashboard',
    'priority' => 'high',
    'status' => 'todo',
    'due_date' => now()->addDays(7)
]);
```

## 📝 Environment Variables

key `.env` configurations:

```env
APP_NAME="Laravel Task Manager"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=pgsql
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
# configure mail settings for password reset
```

## 🚢 Deployment

### with Docker

the project is already configured to run with Docker, making deployment easier on any platform that supports Docker containers.

### recommended platforms
- **Railway** - easy Laravel + PostgreSQL deployment with Docker support
- **Render** - free tier available, supports Docker
- **Fly.io** - good performance on free tier, Docker-native
- **DigitalOcean App Platform** - managed Docker deployments

### deployment checklist
- [ ] set `APP_ENV=production` in `.env`
- [ ] set `APP_DEBUG=false` in `.env`
- [ ] configure production database credentials
- [ ] set up mail service for notifications
- [ ] run `docker-compose exec app php artisan optimize`
- [ ] configure queue worker if using jobs
- [ ] ensure Docker volumes are properly configured for persistence

## 🤝 Contributing

contributions are welcome! please feel free to submit a pull request.

1. fork the project
2. create your feature branch (`git checkout -b feature/AmazingFeature`)
3. commit your changes (`git commit -m 'add some amazing feature'`)
4. push to the branch (`git push origin feature/AmazingFeature`)
5. open a pull request

## 📄 License

this project is open-sourced software licensed under the MIT license.

## 👤 Author

**refleeexzz**
- GitHub: [@refleeexzz](https://github.com/refleeexzz)

## 🙏 Acknowledgments

- Laravel community for excellent documentation
- Tailwind CSS for the utility-first CSS framework
- Alpine.js for reactive components

---

built with ❤️ using Laravel
