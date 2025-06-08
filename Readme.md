# Library_app

---

## Установка проекта

Для запуска проекта локально выполните:

## Backend

Выполните эти действия для запуска backend:
```bash
    cd .\backend\
    cp .env.example .env
    composer i
```
Далее у вас должен быть запущен docker и оболочке wsl выполните:

```bash
    vendor/bin/sail build
    vendor/bin/sail up -d
    vendor/bin/sail artisan key:generate
    vendor/bin/sail artisan migrate:fresh --seed
    vendor/bin/sail artisan queue:work
```

## Frontend

Выполните эти действия для запуска frontend:
```bash
    cd .\frontend\
    cp .env.example .env
    npm install
    npm run dev
```
---
## Сайт

Если на прошлых этапов не было ошибок сайт должен быть доступен по данному url:

```bash
    http://localhost:3000
```

---

## Готовые данные для входа

### Admin
```bash
    email: administrator@example.com
    password: administrator
```
### Librarian
```bash
    email: librarian@example.com
    password: librarian
```
### User
```bash
    email: user@example.com
    password: user12345
```
---
## Стек

### Backend (Laravel)
- PHP 8.3+
- Laravel 12+
- PostgreSQL
- JWT 
- Laravel Mail 
- Laravel Sail 

### Frontend (Next.js)
- Next.js 
- React 
- TypeScript
- Tailwind CSS

---


