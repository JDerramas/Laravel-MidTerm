# 🎽 ICS Apparel & Merchandise Reservation System

> **Official Midterm Project for Computer Programming 3 (CP3)**  
> **Integrated Computer Society (ICS)** • **Academic Year 2026**

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-InnoDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

---

## 📌 1. Project Overview & Objectives

The **ICS Apparel & Merchandise Reservation System** is a unified, full-stack web application developed for the **Integrated Computer Society (ICS)** student body and administrative council.

### Core Problems Addressed:

1. **Manual Logistics Chaos**: Eliminates physical sign-up sheets and manual stock counting for department uniforms, P.E. shirts, and organization merch.
2. **Double-Booking & Stock Discrepancies**: Prevents overbooking with dynamic, atomic stock allocation per size (`XS`, `S`, `M`, `L`, `XL`, `2XL`).
3. **Logistics Deadlocks**: Provides an automated **Conflict Lock Engine** (`⚠️ ON HOLD`) preventing premature item claims while a student has an unresolved helpdesk ticket.
4. **Order Support Transparency**: Built-in real-time Helpdesk Chat with turn-taking anti-spam and strict resolved-only ticket deletion governance.

---

## 🛠️ 2. Technology Stack & Architecture

| Layer                  | Technologies & Tools                                                                                        |
| :--------------------- | :---------------------------------------------------------------------------------------------------------- |
| **Frontend UI/UX**     | Laravel Blade Engine, Tailwind CSS, Space Grotesk / Plus Jakarta Sans fonts, FontAwesome 6, Canvas Confetti |
| **Client-Side Logic**  | Vanilla JavaScript (ES6+), Fetch API, 3-Second Background Polling Engine, LocalStorage caching              |
| **Backend Framework**  | Laravel 11.x MVC Architecture, PHP 8.2 / 8.3                                                                |
| **Identity & SSO**     | OnePass OIDC SSO (RFC 6749, RFC 7636 PKCE S256), Supabase Auth (`oyzvcqaytavbfwdrgili.supabase.co`)       |
| **Database & ORM**     | MySQL 8.0 (InnoDB Engine), Laravel Eloquent ORM, JSON Column Casting                                        |
| **Development Server** | XAMPP (Apache 2.4 + MySQL MariaDB/InnoDB), Composer 2.x, Node.js 20+                                        |

---

## 🚀 3. Installation & Local Development Setup

### Prerequisites

- **XAMPP** (PHP >= 8.2 with `pdo_mysql`, `mbstring`, `fileinfo`, `openssl` enabled)
- **Composer** (PHP Package Manager)
- **Git** (Version Control System)

### Step-by-Step Setup:

```bash
# 1. Clone repository into your web server directory
cd d:/xampp/htdocs/
git clone https://github.com/JDerramas/Laravel-MidTerm.git My_laravel
cd My_laravel

# 2. Install PHP Dependencies via Composer
composer install

# 3. Environment Configuration
cp .env.example .env
# (Edit .env and ensure DB_DATABASE=my_laravel, DB_USERNAME=root, DB_PASSWORD=)

# 4. Generate Application Encryption Key
php artisan key:generate

# 5. Database Setup (Migrations & Seeders)
# Ensure Apache and MySQL are running in XAMPP Control Panel
php artisan migrate:fresh --seed

# 6. Create Storage Symlink (for merchandise images & GCash receipts)
php artisan storage:link

# 7. Access in Browser
# http://localhost/My_laravel/public/
```

---

## 🗄️ 4. Database Schema & Architecture

The application is powered by **7 normalized tables** under the MySQL InnoDB storage engine with full ACID compliance (Atomicity, Consistency, Isolation, Durability):

### 📖 Key Terms & Legend:
- **Primary Key (PK)**: The unique record identifier for each row (auto-incrementing unique integer ID).
- **Unique Key (UK)**: A constraint guaranteeing no duplicate values exist across the entire table (e.g., Reference Code or Student ID).
- **Foreign Key (FK)**: A relational reference linking a child record to its parent row in an associated table.
- **1 : N (One-to-Many Relationship)**: A data relationship where a single parent record can have multiple related child records.
- **Cascade Delete**: An automated database rule that purges dependent child records whenever their parent row is deleted, eliminating orphan/ghost data.

### 🗺️ Visual Entity-Relationship Diagram (ERD):

```
+------------------------------------+                         +------------------------------------+
|            reservations            |      1 : N Relationship |          support_tickets           |
|         (Student Orders)           | <---------------------- |      (Customer Complaints)         |
+------------------------------------+   (via reservation_ref) +------------------------------------+
| Primary Key : id                   |                         | Primary Key : id                   |
| Unique Code : ref_code (ICS-XXXX)  |                         | Unique Code : ticket_code (TCK-XX) |
| Student ID  : student_id (Indexed) |                         | Link to Order: reservation_ref     |
| Cart Items  : items (JSON Snapshot)|                         | Ticket Status: status (Indexed)    |
| Order Total : total_amount         |                         +------------------------------------+
| Order Status: status               |                                          | 1
+------------------------------------+                                          | 1 : N (Cascade Delete)
                  ^                                                             v
                  |                                            +------------------------------------+
                  | Snapshot Link                              |          support_messages          |
+------------------------------------+                         |         (Chat Conversations)       |
|              products              |                         +------------------------------------+
|       (Merchandise Catalog)        |                         | Primary Key : id                   |
+------------------------------------+                         | Foreign Key : ticket_id            |
| Primary Key : id                   |                         | Sender Role : sender_type          |
| Unique Code : item_code (POLO-001) |                         | Chat Text   : message (TEXT)       |
| Unit Price  : price (DECIMAL)      |                         +------------------------------------+
| Size Stock  : sizes (JSON Breakdown)
| Total Units : current_stock        |                         +------------------------------------+
+------------------------------------+                         |           activity_logs            |
                                                               |         (Audit Trail Ledger)       |
+------------------------------------+                         +------------------------------------+
|            system_users            |                         | Primary Key : id                   |
|       (Council Admins/Staff)       |                         | Action Type : action (CRUD/LOGIN)  |
+------------------------------------+                         | Activity Log: activity (TEXT)      |
| Primary Key : id                   |                         | Module Name : module               |
| Unique Code : user_code (USR-010)  |                         +------------------------------------+
| Staff Email : email (ics@npc.edu.ph)
| System Role : role (Administrator) |                         +------------------------------------+
+------------------------------------+                         |              students              |
                                                               |     (OnePass Verified Profiles)    |
                                                               +------------------------------------+
                                                               | Primary Key : id                   |
                                                               | Student No. : student_id (Unique)  |
                                                               | Campus Email: email (Unique)       |
                                                               | Student Info: name, section, dept  |
                                                               +------------------------------------+
```

### 📋 Overview of the 7 Core Database Tables:

| Table Name | Description & Architectural Purpose |
| :--- | :--- |
| **`products`** | Stores the merchandise catalog items, unit pricing (`DECIMAL 10,2`), category filters, and real-time inventory counts per size (`XS`, `S`, `M`, `L`, `XL`, `2XL`). |
| **`reservations`** | Stores student checkout orders, unique reference codes (`ref_code`), payment methods (Cash/GCash), uploaded receipt images, and order lifecycle states (`Pending`, `Ready for Pickup`, `Claimed`, `Cancelled`). |
| **`support_tickets`** | Logs student inquiries and complaints. When a ticket is active (`Open`), it automatically engages the **Conflict Lock** (`⚠️ ON HOLD`) on the corresponding reservation, preventing premature pickup. |
| **`support_messages`** | Stores live chat transcripts between students and council officers. Protected by a **Turn-Taking Anti-Spam** rule and configured with `ON DELETE CASCADE` to clean up messages upon ticket deletion. |
| **`system_users`** | Roster of authorized faculty advisers and student council administrators (e.g., `ics@npc.edu.ph`). Enforced by the RBAC middleware guard prior to granting access to `/admin`. |
| **`students`** | Local verified student directory cached automatically whenever a student authenticates via OnePass OIDC SSO (Student ID, Name, Section, Department, Avatar). |
| **`activity_logs`** | Immutable security audit trail recording every significant system event (User Code, Action, Activity Description, Module, and Timestamps). |

### 💡 Key Architectural Patterns:

1. **JSON Snapshot Pattern (`reservations.items`)**:
   - Instead of fragmenting shopping carts across multiple normalized line-item tables, the exact merchandise items, sizes, quantities, and prices at checkout are preserved as a native JSON snapshot.
   - **Why this matters**: If an administrator modifies product prices or fabric details in the catalog in the future, past student reservation receipts remain 100% historically accurate.
2. **Cascading Foreign Key Deletion (`support_messages.ticket_id`)**:
   - Whenever an administrator deletes a resolved support ticket, MySQL automatically purges all related chat messages in a single atomic operation, preventing orphan records from polluting the database.
3. **Atomic Inventory Allocation (InnoDB ACID)**:
   - Stock deduction and reservation creation execute within a database transaction. If any step fails, changes roll back immediately to prevent overbooking or inconsistent inventory states.

---

## 📡 5. REST API Endpoints

| Method   | Endpoint                             | Description                                               | Access        |
| :------- | :----------------------------------- | :-------------------------------------------------------- | :------------ |
| `GET`    | `/`                                  | Student Storefront & Catalog                              | Public        |
| `GET`    | `/admin`                             | Dedicated Administrative Operations Portal                | Admin/Staff   |
| `GET`    | `/api/realtime/sync`                 | Aggregated sync payload (catalog, orders, tickets, stats) | Public/Admin  |
| `POST`   | `/api/reservations`                  | Submit new checkout reservation                           | Student       |
| `PATCH`  | `/api/reservations/{id}/status`      | Update order status (with Conflict Lock check)            | Admin         |
| `DELETE` | `/api/reservations/{id}`             | Delete finished reservation (restores stock if cancelled) | Admin         |
| `POST`   | `/api/products`                      | Create merchandise item with image upload                 | Admin         |
| `POST`   | `/api/products/{id}`                 | Update product details and inventory sizes                | Admin         |
| `DELETE` | `/api/products/{id}`                 | Remove merchandise item                                   | Admin         |
| `POST`   | `/api/users`                         | Create administrative user account                        | Admin         |
| `PUT`    | `/api/users/{id}`                    | Update administrative user details & status               | Admin         |
| `DELETE` | `/api/users/{id}`                    | Remove administrative user account                        | Admin         |
| `POST`   | `/api/support/tickets`               | Open student support ticket (Engages ON HOLD)             | Student       |
| `POST`   | `/api/support/tickets/{id}/messages` | Send live chat message (Turn-taking anti-spam)            | Student/Admin |
| `PATCH`  | `/api/support/tickets/{id}/status`   | Mark ticket as In Review / Resolved                       | Admin         |
| `DELETE` | `/api/support/tickets/{id}`          | Delete resolved ticket (Cascade deletes messages)         | Student/Admin |
| `GET`    | `/reports/export-csv`                | Download complete audit & reservation report              | Admin         |
| `GET`    | `/oauth/login`                       | OnePass OIDC SSO authorization redirect with PKCE S256    | Public/Student|
| `GET`    | `/oauth/callback`                    | Token exchange via `/api/oauth/token` & claims sync       | OnePass Server|
| `GET`    | `/oauth/logout`                      | End verified student session & record audit log           | Student       |

---

## 🌐 6. Cloud Deployment Guide

The application is cloud-ready and can be deployed to production through multiple methods:

### Option A: Render.com (Recommended - Same Ecosystem as OnePass)
1. Push repository to GitHub.
2. Create a new **Web Service** on [Render.com](https://render.com) linked to your GitHub repo.
3. Connect to a free cloud MySQL instance (e.g. Aiven.io, Clever Cloud, or TiDB).
4. Configure Environment Variables:
   - `APP_KEY`, `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://your-service.onrender.com`
   - `DB_CONNECTION=mysql`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
   - `ONEPASS_REDIRECT_URI=https://your-service.onrender.com/oauth/callback`

### Option B: Railway.app (1-Click Laravel + MySQL)
1. On [Railway.app](https://railway.app), click **New Project > Provision MySQL**.
2. Click **New > GitHub Repo** and select this repository. Railway automatically detects Laravel and manages build steps.

### Option C: Instant Live Demo via Cloudflare Tunnel (Zero Cloud Cost)
Expose your local development server instantly for presentations and evaluations without setting up external servers:
```bash
# Expose port 8000 with a secure, public HTTPS URL
cloudflared tunnel --url http://127.0.0.1:8000
```

> **Important**: When changing host domains, remember to update `ONEPASS_REDIRECT_URI` in `.env` and whitelist the new callback URL in the OnePass client settings.

---

## 🛡️ 7. System Security & Quality Assurance

- **RFC 7636 PKCE S256**: Protects authorization code grants using high-entropy 64-character verifiers and SHA-256 challenge hashing.
- **CSRF Protection**: All mutating HTTP requests utilize `X-CSRF-TOKEN` meta header validation.
- **SQL Injection Prevention**: 100% parameter-bound queries via Eloquent ORM. No raw concatenated SQL.
- **Role-Based Access Control (RBAC)**: Only accounts authenticated via OnePass that exist as active administrators in `system_users` (e.g., `ics@npc.edu.ph`) can access `/admin`.
- **Anti-Spam Turn-Taking**: Strict chat policy locking student message input until an administrative officer replies.
- **Inventory Consistency**: Deleting cancelled reservations automatically restores merchandise stock counts back to inventory.
- **Financial Precision**: All monetary calculations utilize `DECIMAL(10,2)` to prevent floating-point rounding errors.

---

## 👥 8. Team Credits & Role Distribution (CP3 Midterm Groupings)

|  No.  | Task Description   | Domain                      | Member Coverage                                                                               |
| :---: | :----------------- | :-------------------------- | :-------------------------------------------------------------------------------------------- |
| **1** | **BACKEND**        | Server-side logic           | Routes, Controllers, 21 CRUD methods, Turn-Taking validation, Conflict Lock API, PKCE Auth    |
| **2** | **FRONTEND**       | User interface & experience | Blade views (`merch.blade.php`, `admin.blade.php`), Tailwind CSS, Fetch API, Realtime Polling |
| **3** | **DATABASE ADMIN** | Data layer & schema         | MySQL InnoDB, Migrations, JSON Snapshot Pattern, B-Tree Indexes, `.env` config                |
| **4** | **SYSTEM SUPPORT** | Environment & deployment    | XAMPP Dev setup, Git workflow, Security compliance, Cloud deployment, Cross-device testing    |
| **5** | **DOCUMENTATION**  | Project documentation       | `README.md`, PHPDoc code comments, Technical explanation files, Presentation script           |

---

_Developed with ❤️ for the Integrated Computer Society (ICS) Midterm Defense._
