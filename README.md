# ICS Integrated Computer Society (2026 - 2027)
## Apparel Catalog & Smart Merch Reservation System

> **CP3 Midterm Group Project — Associate in Information Systems (AIS 2B)**  
> **Group 4**:
> - **DERRAMAS, J.** (Team Lead / Core Admin & Database Architecture)
> - **BUENAVENTURA** (Backend Server-Side Logic & Routes)
> - **REGADIO** (Frontend Blade Views & UI/UX Styling)
> - **DOTILLOS** (Database Admin, Migrations & Schema Mapping)
> - **ALBOR** (System Support & Documentation)

---

## 📌 Project Overview
The **ICS Apparel & Merch Reservation System** is a unified college web application tailored for the **Integrated Computer Society (ICS)**. It streamlines official student uniform orders, departmental attire reservations, athletic PE dry-fit apparel, collegiate letterman varsity jackets, and campus merchandise.

The project incorporates an **ICS Crimson Red & Golden Honeycomb UI Design System** reflecting the official ICS heraldic shield emblem (binary code matrix, mechanical gears, honeycomb lattice, and circuit board traces).

---

## 🚀 Key Modules (System Specification Compliance)

### 1. Dashboard (Read)
- **Real-Time KPI Metrics**:
  - Total Catalog Items count
  - Available On-Hand Stock units
  - Total Units Claimed (Sales) + Gross Revenue in PHP (₱)
  - Active Pending & Ready Reservations
- **Sales vs Stock Inventory Analytics**:
  - Comparative stacked visual representation of Initial Inventory vs Units Sold vs Units Reserved vs Current Available Stock.
  - Automatic Stock Health warnings (`In Stock`, `Low Stock < 20`, `Out of Stock`).
- **Recent Activity Audit Feed**:
  - Live display of latest system transactions and logs.

### 2. Information Management (Create, Read, Update, Delete)
- Full CRUD operations for apparel and merchandise items.
- **Photo Upload & Edit Features**:
  - Drag-and-drop or file upload directly from device with instant preview.
  - One-click selection from official campus photography presets (`male_polo.jpg`, `female_blouse.jpg`, `pe_shirt.jpg`, `pe_pants.jpg`, `varsity_jacket.jpg`, `dept_tech.jpg`, `dept_ba.jpg`, `lanyard.jpg`, etc.).
  - Edit existing merchandise pictures and sizing breakdown (XS to 3XL).
  - Material, category, and target department settings.

### 3. Reports (Read)
- **Sales vs Stock Master Report**:
  - Tabular breakdown of SKU / Item Code, Name, Category, Price, Initial Stock, Units Claimed (Sold), Units Reserved, Available Stock, Total Sales Revenue, and Stock Health.
- **CSV Masterlist Export**:
  - Direct download endpoint (`/reports/export-csv`) streaming audit-ready data.
- **Printable Report Summary**:
  - Clean printable layout with inventory turnaround statistics.

### 4. User Management (Create, Read, Update, Delete)
- User accounts table for faculty advisers, student council officers, and student members.
- Account role management: `Admin`, `Logistics Officer`, `Inventory Officer`, `Student Member`.
- Pre-seeded with class members and faculty adviser (`E. Moreno` - `e.moreno@gmail.com`).

### 5. Activity Logs (Audit Trail Specification)
- Schema strictly following the whiteboard wireframe:
  - **USER CODE** | **ACTION** (`CREATE`, `READ`, `UPDATE`, `DELETE`, `LOGIN`, `LOGOUT`) | **ACTIVITY** | **DATE / TIMESTAMP**
- Action filtering and real-time search.

### 6. Student Reservation & Catalog Portal
- Visual showcase with responsive filter toolbar (`All Merch`, `Collegiate Uniforms`, `PE Wear`, `Department & Varsity`, `Accessories`).
- Interactive **Size Selection Modal** with live stock validation per size.
- **Interactive Anatomical Size Guide** with **Dual-Unit Toggle** (Inches vs Centimeters; Tops vs Bottoms).
- **Reservation Cart Drawer** with reactive badge counters, quantity adjusters, and price calculation.
- **Student Checkout**:
  - Input Student ID, Name, Department (AIS / BSIS), Year Level, Contact Number, Pickup Date & Slot.
- **Printable Confirmation Claim Slip**:
  - Complete with unique reference code (e.g. `ICS-2026-X941K`), student info, reserved items table, and simulated barcode for campus claim verification.

---

## 🛠️ Tech Stack & Requirements

- **Backend**: Laravel 11 / 13 (PHP 8.3)
- **Database**: SQLite (Zero configuration, ready for MySQL / MariaDB via `.env`)
- **Frontend**: Blade Views, Modern Tailwind CSS, Vanilla JS reactive state architecture
- **Icons & Assets**: Custom ICS SVG Crest, High-definition campus apparel photography
- **Effects**: Canvas Confetti for checkout completion

---

## 💻 Local Setup & Execution (XAMPP)

1. **Place project in XAMPP web root**:
   ```
   D:\xampp\htdocs\My_laravel
   ```

2. **Start Apache in XAMPP Control Panel**.

3. **Database Migration & Seeding**:
   ```bash
   d:\xampp\php\php.exe artisan migrate
   d:\xampp\php\php.exe artisan db:seed --class=IcsDatabaseSeeder
   ```

4. **Access in Web Browser**:
   ```
   http://localhost/My_laravel/public/
   ```

---

## 👥 Midterm Group Responsibilities

| Role | Member | Responsibilities |
| :--- | :--- | :--- |
| **Backend Lead** | **DERRAMAS, J.** / **BUENAVENTURA** | Routes, MerchController, API endpoints, Validation |
| **Frontend UI/UX** | **REGADIO** | Blade views, ICS Red design system, Modal dialogs, Cart drawer |
| **Database Admin** | **DOTILLOS** | Migrations (`products`, `reservations`, `activity_logs`, `system_users`), Seeder |
| **System Support & Docs** | **ALBOR** | XAMPP configuration, asset organization, documentation |
