# FutureX App Page

A Laravel package to create beautiful app landing pages with a powerful Filament admin dashboard.

It includes:
- App landing page
- Features management
- Screenshots gallery
- Contact section
- Click tracking
- Visit duration analytics
- Filament 3 admin panel

---

## 🚀 Requirements

- PHP 8.1+
- Laravel 10/11+
- Filament 3

---

## 📦 Installation

Install via Composer:

```bash
composer require futurex/app-page
```

Run migrations:

```bash
php artisan migrate
```

Publish Filament assets:

```bash
php artisan filament:assets
```

Clear caches:

```bash
php artisan optimize:clear
```

---

## 🔐 Admin Access

The dashboard is protected and only allows specific emails to log in.

By default, the allowed email is:

```
admin@gmail.com
```

> ⚠️ You should change this to your own email before using the package in production.

### How to change the allowed emails

**Step 1** — Publish the config file:

```bash
php artisan vendor:publish --tag=app-page-config
```

This will create `config/app-page.php` in your project.

**Step 2** — Open `config/app-page.php` and update the `allowed_emails` array:

```php
'allowed_emails' => [
    'your-email@example.com',
    // you can add multiple emails
],
```

**Step 3** — Make sure a user with that email exists in your `users` table. You can create one via Tinker:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name'     => 'Admin',
    'email'    => 'your-email@example.com',
    'password' => bcrypt('your-password'),
]);
```

Then visit `/app-panel/login` and log in with those credentials.

---

## ⚙️ Configuration

After publishing the config, you can customize the following options in `config/app-page.php`:

```php
return [

    // URL prefix for the landing page (default: /app-page)
    'route_prefix' => 'app-page',

    // Enable/disable visit tracking
    'track_visits' => true,

    // Enable/disable visit duration tracking
    'track_duration' => true,

    // Emails allowed to access the admin dashboard
    'allowed_emails' => [
        'admin@gmail.com', // ← change this to your email
    ],

];
```

---

## 🎨 Publish Views (Optional)

If you want to customize the landing page design:

```bash
php artisan vendor:publish --tag=app-page-views
```

This copies the Blade views to `resources/views/vendor/app-page/` where you can freely edit them.

---

## 🌐 URLs

| URL | Description |
|-----|-------------|
| `/app-page` | Public landing page |
| `/app-panel` | Admin dashboard (Filament) |
| `/app-panel/login` | Admin login page |
