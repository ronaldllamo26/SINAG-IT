# 🌟 SINAG IT Marketplace
### Professional Software Solutions & Project Catalog

<div align="center">
  <video src="https://github.com/user-attachments/assets/9df08f36-ebcb-4571-8724-a1c6eb4321f3" width="100%" autoplay muted loop></video>
  <br>
  <p align="center">
    <b>A High-Performance Software Marketplace for Modern Development Teams</b>
  </p>
</div>

---

**SINAG IT** is an enterprise-grade software marketplace designed for development agencies and freelance teams. It provides a high-fidelity showroom for project source codes, a robust role-based lead management system, and an automated administrative engine for rapid project deployment.

---

## ✨ Key Features

### 🏢 Agency Marketplace
- **Premium UI/UX:** High-end glassmorphism design with responsive navigation and cinematic hero sections.
- **Intelligent Catalog:** Real-time search and category-aware filtering for diverse project niches (Inventory, School Management, E-Commerce, etc.).
- **Interactive Modals:** Detailed project previews featuring embedded video demos and YouTube integration.

### 🛠️ Developer Productivity (AI-Powered)
- **Quick Select Tags:** Interactive UI badges for rapid population of technical metadata.
- **Flexi-Category System:** Support for both pre-defined and custom project categories.
- **Automated Metadata:** Intelligent keyword analysis to streamline the project documentation workflow.

### 💼 Sales & Lead Management (CRM)
- **Role-Based Routing:** Leads are automatically partitioned between Developers and Superadmins for focused follow-ups.
- **Status-Driven Pipeline:** Color-coded tracking for `New`, `Replied`, and `Closed/Sold` inquiries.
- **Notification Badges:** Real-time visual indicators for new incoming leads.

### 👤 Developer Ecosystem
- **Public Portfolios:** Dynamic individual pages showcasing every developer's portfolio and technical build stats.
- **Personal Dashboards:** Private analytics hubs for developers to track their project performance and sales trends.

---

## 🛠️ Technology Stack
- **Core:** Native PHP (v8.x+) & MySQL
- **Frontend:** Bootstrap 5, FontAwesome 6, SweetAlert2
- **Data Viz:** Chart.js
- **Environment:** Optimized for XAMPP (Local) and Shared Hosting (e.g., InfinityFree)

---

## 📂 Project Structure
```text
SINAG/
├── admin/          # Secure Management Suite
│   ├── actions/    # Backend Logic (Upload, Edit, Delete)
│   └── includes/   # Admin UI Components
├── auth/           # Authentication Layer (Login/Logout)
├── assets/         # CSS, Images, and Video Assets
├── includes/       # Database Configuration & Helper Functions
├── setup/          # Maintenance & Migration Scripts
├── dev.php         # Public Developer Portfolio Page
└── index.php       # Marketplace Entry Point
```

---

## 🚀 Quick Setup Guide

1. **Clone the repository:**
   ```bash
   git clone https://github.com/ronaldllamo26/SINAG-IT.git
   ```
2. **Database Configuration:**
   - Import the database schema into your MySQL server.
   - Configure your credentials in `includes/config.php`.
3. **Initialization:**
   - Run the scripts in the `/setup` folder to synchronize the latest database columns and roles.
4. **Default Admin:**
   - Access the administrative panel via the "Secret Lock" in the footer or directly via `/auth/login.php`.

---

## 🔒 Security Policy
The system is built with role-based partitioning and data sanitization. *Note: For production deployments, ensure all maintenance scripts in the `/setup` folder are restricted or deleted.*

---
**Developed with ❤️ by the SINAG IT Team.**
