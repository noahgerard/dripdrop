# DripDrop ☕️

A modern coffee tracking and social app built as an intern side project at FOCUS!

---

## Overview
DripDrop is a Laravel-based web application for logging, sharing, and visualizing coffee consumption within a team or organization. Users can log their coffee, comment, view leaderboards, and see department stats. The app is designed for a fun, social, and data-driven coffee culture.

---

## Features
- User authentication (SSO and email)
- Log coffee entries with time, type, and optional image
- Comment on coffee entries
- Department and user leaderboards
- Department stats and charts
- Notifications for comments and activity
- Responsive, modern UI with Tailwind CSS and Alpine.js
- Image upload and compression
- Pagination and charts for data visualization

---

## Tech Stack
- **Backend:** Laravel (PHP)
- **Frontend:** Blade, Alpine.js, Tailwind CSS
- **Build Tools:** Vite
- **Database:** SQLite (dev), Eloquent ORM
- **Testing:** PestPHP
- **Other:** Chart.js, browser-image-compression

---

## Setup

1. **Clone the repo:**
   ```sh
   git clone https://github.com/noahgerard/dripdrop.git
   cd dripdrop
   ```
2. **Install PHP dependencies:**
   ```sh
   composer install
   ```
3. **Install JS dependencies:**
   ```sh
   npm install
   ```
4. **Copy and edit your environment file:**
   ```sh
   cp .env.example .env
   # Edit .env as needed
   ```
5. **Generate app key:**
   ```sh
   php artisan key:generate
   ```
6. **Run migrations and seeders:**
   ```sh
   php artisan migrate --seed
   ```
7. **Start the dev server:**
   ```sh
   npm run dev
   # In another terminal:
   php artisan serve
   ```

---

## Usage
- Register or log in
- Log your coffee with time, type, and optional image
- View your department and user stats
- Comment on others' coffee entries
- Check the leaderboard and department charts

---

## Screenshots

| Dashboard | Feed | Log |
|---|---|---|
| ![Dashboard](/media/dash.png) | ![Feed](/media/feed.png) | ![Log](/media/log.png) |

---

## Folder Structure
- `app/` - Laravel app code (Controllers, Models, etc.)
- `resources/views/` - Blade templates and UI components
- `resources/js/` - Frontend JS (Alpine.js, app logic)
- `public/` - Public assets and entry point
- `media/` - App screenshots and images
- `routes/` - Route definitions
- `database/` - Migrations, seeders, SQLite DB

---

## Credits
- Built by Noah Gerard as an intern project at FOCUS!
- Thanks to the Laravel, Alpine.js, and Tailwind CSS communities

---

## License

[MIT license](https://opensource.org/licenses/MIT).
