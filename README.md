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
migrate database:

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
### optionally Publish 
Publish views

```bash
php artisan vendor:publish --tag=app-page-views
```
Publish config
```bash
php artisan vendor:publish --tag=app-page-config
```
