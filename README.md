# Kisii University - Campus Lost & Found Portal (`cumpus_lost_items`)

An official, responsive web application for managing, reporting, and securely recovering lost property across **Kisii University** campus blocks.

---

## 🌟 Key Features

* **University Branding & Aesthetics**: Customized with official Kisii University identity, coat of arms emblem, and landmark gallery (Academic Block, Chancellor's Pavilion, Science Complex).
* **Dual Reporting System**:
  * **Public Reporting**: Students and visitors can report lost or found items without mandatory registration.
  * **Student Accounts**: Enrolled students can register and filter items directly related to their declared search category.
* **Smart Live Validation**:
  * Real-time format verification for Kisii University registration numbers (e.g., `IN13/00000/23`).
  * Instant green confirmation ticks and dynamic status indicators.
  * 10-digit phone number check and real-time password match checks.
* **Multi-Step Flow with Animated Spinners**:
  * Step-by-step registration with live loading indicators and state preservation.
  * Global top progress bar and transition spinner when navigating between campus sections.
* **Administrative & Security Operations**:
  * Role-based access control (Student, Finder, Seeker, Admin, Super Admin).
  * Direct coordination with the Main Administration Security Desk (+254 58 2030161).
* **Fully Responsive**: Designed with a mobile-first philosophy, adapting across smartphones, tablets, and desktop workstations.

---

## 🛠️ Technology Stack

* **Framework**: Laravel 12 (PHP 8.2+)
* **Frontend**: Blade Templates, Tailwind CSS, Alpine.js, FontAwesome 6
* **Database**: PostgreSQL (production) / SQLite (local development)
* **Build Tooling**: Vite 7
* **Deployment**: Docker (Render.com)

---

## 🚀 Getting Started

### 1. Clone Repository
```bash
git clone https://github.com/OsanoDavid/cumpus_lost_items.git
cd cumpus_lost_items
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup & Migrations
```bash
php artisan migrate --seed
```

### 5. Compile Frontend Assets
```bash
npm run build
```

### 6. Run Local Development Server
```bash
php artisan serve
```
Open `http://127.0.0.1:8000` in your web browser.

---

## ☁️ Render Deployment

This project is configured for **Docker deployment** on [Render](https://render.com).

### Render Dashboard Settings

| Field | Value |
|---|---|
| **Environment** | Docker |
| **Dockerfile Path** | `./Dockerfile` |
| **Docker Context Directory** | `.` |

### Required Environment Variables on Render

| Variable | Value |
|---|---|
| `APP_NAME` | `Kisii University Lost & Found` |
| `APP_ENV` | `production` |
| `APP_KEY` | `base64:...` (generate with `php artisan key:generate --show`) |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://your-app.onrender.com` |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | *(from Render PostgreSQL dashboard)* |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | *(from Render PostgreSQL dashboard)* |
| `DB_USERNAME` | *(from Render PostgreSQL dashboard)* |
| `DB_PASSWORD` | *(from Render PostgreSQL dashboard)* |
| `SESSION_DRIVER` | `cookie` |
| `CACHE_STORE` | `file` |
| `LOG_CHANNEL` | `stderr` |

> **Note**: If using Render's free PostgreSQL, use the **Internal Database URL** connection details.

---

## 🔒 Security Best Practices

* Environment credentials (`.env`) are strictly untracked.
* SQLite databases (`*.sqlite`) are ignored from version control.
* CSRF protection is enforced on all form submissions.
* Passwords are encrypted with bcrypt hashing.
* Proxy headers are properly trusted for HTTPS enforcement behind Render's load balancer.

---

## 📜 License
Developed for Kisii University Campus Community. Distributed under the [MIT License](LICENSE).
