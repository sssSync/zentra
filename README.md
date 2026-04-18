# Zentra - CRM 🚀

![PHP 8.4](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Supabase](https://img.shields.io/badge/Supabase-3ECF8E?style=for-the-badge&logo=supabase&logoColor=white)
![Render](https://img.shields.io/badge/Render-46E3B7?style=for-the-badge&logo=render&logoColor=white)

## 🌟 Overview
Zentra is a modern, high-performance Customer Relationship Management (CRM) SaaS application. Built to help teams streamline their sales pipelines, manage client relationships, and track revenue seamlessly. 

## 🔐 Live Demo
Experience the application live:
- **URL:** [https://zentra-5fvt.onrender.com](https://zentra-5fvt.onrender.com/)
- **Email:** `test@crm.com` 
- **Password:** `testcrm1`

## ✨ Key Features
- **Smart Contact Management:** Detailed contact profiles with custom avatar uploads and dynamic UI-Avatar fallbacks.
- **Deal Tracking:** Visual pipeline and state management for tracking opportunities from "Discovery" to "Closed Won".
- **Deep Analytics Hub:** Real-time visual charts and reporting to track performance trends and sales revenue.
- **Seamless Interaction Logging:** Keep a historical timeline of all meetings, emails, and calls per contact.
- **Task Management:** Stay on top of due dates and follow-ups.

## 🛠️ Tech Stack
- **Backend:** PHP 8.4, Laravel 13
- **Frontend:** Livewire 3, Alpine.js, Tailwind CSS, Flux UI
- **Database:** Supabase (PostgreSQL with IPv4 Connection Pooling)
- **Deployment:** Render (Custom Docker Environment)
- **Assets:** Vite, Bun, Bunny Fonts

## 🚀 Local Development Setup

Follow these steps to run the CRM locally on your machine.

**1. Clone the repository**
```bash
git clone https://github.com/sssSync/zentra.git
cd zentra
```
2. Install dependencies
```Bash

composer install
bun install
```
3. Environment Setup
Copy the .env.example file and generate an application key:
```Bash

cp .env.example .env
php artisan key:generate
```
 >Note: For local development, SQLite is configured by default.

4. Run Migrations & Seeders
Generate the database tables and populate the app with demo data (Contacts, Deals, etc.):
```Bash

php artisan migrate:fresh --seed
```
5. Link Local Storage
Create the secure symlink for local avatar uploads to work properly:
```Bash

php artisan storage:link
```
6. Start the Servers
Boot up the frontend asset compiler and the PHP server:
```Bash
composer run dev
```
Visit `http://localhost:8000` in your browser.
☁️ Deployment Notes (Render)

This application is configured to deploy seamlessly to Render using a custom Dockerfile.

  - Environment: Docker

  - Build Step: Compiles frontend assets natively using Bun (no Node.js required) and installs production PHP extensions.

  - Database: Fully integrated with Supabase PostgreSQL.
