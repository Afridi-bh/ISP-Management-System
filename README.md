# 🌐 BetterNet — ISP Billing & Management System

> **BetterNet 4.1** — A complete, full-stack billing and management solution for modern Internet Service Providers.

![BetterNet](https://img.shields.io/badge/Version-4.1-cyan?style=for-the-badge)
![Laravel](https://img.shields.io/badge/Laravel-PHP-red?style=for-the-badge&logo=laravel)
![Mikrotik](https://img.shields.io/badge/Mikrotik-API-blue?style=for-the-badge)
![bKash](https://img.shields.io/badge/bKash-Payment-pink?style=for-the-badge)
![Stripe](https://img.shields.io/badge/Stripe-Payment-6772e5?style=for-the-badge&logo=stripe)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

---

## 📋 Table of Contents

- [About](#about)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Database Schema](#database-schema)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Screenshots](#screenshots)
- [API Integration](#api-integration)
- [Contributing](#contributing)
- [Author](#author)
- [License](#license)

---

## 📖 About

BetterNet is a full-stack ISP billing and management system developed for **IT WAY BD**. It streamlines the day-to-day operations of small to medium-sized Internet Service Providers by automating billing, managing subscribers, integrating with Mikrotik routers, and processing payments through multiple gateways.

The system was developed as a practicum project for the **Bachelor of Computer Science and Engineering (BCSE)** at **IUBAT — International University of Business Agriculture and Technology**, Fall 2025.

---

## ✨ Features

### 🆕 What's New in v4.1
- Multiple Router Support
- bKash Payment Gateway integration
- Improved UI/UX
- One-click billing
- Mikrotik Router API
- 3 payment options (Cash, Stripe, bKash)
- Admin and user console
- One-click disable for all users with due payments
- Support ticket system
- Mikrotik log viewer
- Reports & Analytics

### 🔧 Core Features

| Feature | Description |
|---|---|
| **Mikrotik Integration** | Seamlessly manage multiple routers with full Mikrotik API support, real-time monitoring, and complete network control from a single dashboard |
| **Multiple Payment Gateways** | Accept payments via Cash, Stripe, and bKash with instant confirmation, automated receipts, and comprehensive payment tracking |
| **Automated Billing** | Generate invoices instantly with one-click billing, automated cycles, email reminders, and PDF generation for all customers |
| **Dual Portal System** | Separate Admin and Customer portals with role-based access, comprehensive dashboards, and self-service capabilities |
| **Support Tickets** | Efficient ticket management system with status tracking, email notifications, priority levels, and complete issue resolution |
| **Reports & Analytics** | Track revenue, user analytics, payment reports, and export data to PDF/Excel for comprehensive business insights |

---

## 🛠️ Tech Stack

- **Frontend:** HTML, Tailwind CSS, JavaScript
- **Backend:** PHP (Laravel Framework)
- **Database:** MySQL
- **Router API:** Mikrotik RouterOS API
- **Payment Gateways:** Stripe, bKash, Cash
- **Other:** PDF generation, Email notifications

---

## 🗄️ Database Schema

The system uses a relational MySQL database with the following core tables:

```
ROUTERS          — Stores router credentials (IP, port, username, password)
USERS            — Admin/staff accounts with role-based access
CUSTOMERS        — ISP subscriber accounts and Stripe customer info
PACKAGES         — Internet packages with speed, price, and validity
SUBSCRIPTIONS    — Customer-package assignments with start/end dates
BILLING          — Billing records linked to customers and invoices
PAYMENTS         — Payment transactions with method and status
INVOICES         — Generated invoices for customers
TICKETS          — Customer support tickets with priority and status
COMMENTS         — Ticket thread comments from users/admins
PACKAGE_REQUESTS — Customer package change requests pending approval
DETAILS          — Extended customer profile information
```

**Key Relationships:**
- Routers → provide → Packages
- Customers → have → Subscriptions → linked to → Packages
- Billing → processed by → Payments
- Tickets → have → Comments

---

## ⚙️ Installation

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js & NPM
- A Mikrotik Router (for API integration)
- Stripe account
- bKash merchant account

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/your-username/betternet-isp.git
cd betternet-isp

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install && npm run build

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Run database migrations
php artisan migrate

# 7. Seed initial data (optional)
php artisan db:seed

# 8. Start the development server
php artisan serve
```

---

## 🔧 Configuration

Update your `.env` file with the following credentials:

```env
# Application
APP_NAME=BetterNet
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=betternet
DB_USERNAME=root
DB_PASSWORD=

# Stripe
STRIPE_KEY=pk_live_xxxxxxxxxxxx
STRIPE_SECRET=sk_live_xxxxxxxxxxxx

# bKash
BKASH_APP_KEY=your_bkash_app_key
BKASH_APP_SECRET=your_bkash_app_secret
BKASH_USERNAME=your_bkash_username
BKASH_PASSWORD=your_bkash_password

# Mail (for invoice & notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
```

---

## 🚀 Usage

### Admin Portal
- Access at `/admin/login`
- Manage customers, packages, routers, billing, and reports
- View Mikrotik logs and control user bandwidth
- Handle support tickets and generate invoices

### Customer Portal
- Access at `/customer/login`
- View subscription details and billing history
- Make payments via Stripe, bKash, or Cash
- Submit and track support tickets

---

## 📸 Screenshots

### 🏠 Landing Page
The public-facing landing page showcases all features with access to both Admin and Customer portals.

### 📊 Admin Dashboard
Real-time overview of Total Bills, Total Payments, Bills This Month, and Monthly Billing & Payments chart.

### 📦 Package Management
Create and manage internet packages per router with pricing in BDT and package-wise user details.

---

## 🔌 API Integration

### Mikrotik Router API
The system connects to Mikrotik routers over the RouterOS API to:
- Enable/disable user accounts
- Assign and update bandwidth profiles
- Retrieve connection logs
- Manage PPPoE/Hotspot users

### Stripe Payment API
- Secure card payment processing
- Webhook handling for payment confirmation
- Customer and subscription management

### bKash Payment API
- Mobile financial service (MFS) integration
- Instant payment confirmation
- Automated receipts

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 👨‍💻 Author

**Afridi Bin Hafiz**  
ID: 22103005  
Department of Computer Science and Engineering  
IUBAT — International University of Business Agriculture and Technology  
Dhaka, Bangladesh

> Developed for **IT WAY BD** as part of CSC 490 – Practicum, Fall 2025.  
> Supervised by **Arifa Tur Rahman**, Associate Professor, CSE Department, IUBAT.

---

## 📄 License

This project is licensed under the MIT License — see the [LICENSE](LICENSE) file for details.

---

<p align="center">
  Made with ❤️ for IT WAY BD &nbsp;|&nbsp; BetterNet ISP Billing System &copy; 2024
</p>
