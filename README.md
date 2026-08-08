# Vehicle Gate Operations System

A responsive enterprise web application built with **Laravel 11**, **Filament v3**, and **MySQL** designed to manage vehicle gate entry and exit workflows, track active on-site vehicles, record operator metadata, and display real-time analytics.

---

## Technical Features & Requirements Implementation

### 1. Secure Authentication & User Session Tracking

* **Authentication:** Secure login managed via Filament Admin Panel with password hashing and session encryption.
* **Audit Logging:** Custom `user_logins` table and authentication listeners capture login timestamps (`logged_in_at`), IP addresses, user agents, and user session tokens.

### 2. Vehicle Gate In Workflow

* **Vehicle Selection:** Searchable dropdown listing all registered fleet vehicles.
* **Driver Selection & Auto-Population:** Dynamic dropdown for registered drivers; auto-populates Driver ID and Phone Number upon selection.
* **Automated Data Capture:** Automatically logs `date_time_in` timestamp, sets status to `GATED_IN`, and associates `gated_in_by_user_id` with the authenticated operator.

### 3. Vehicle Gate Out Workflow

* **Filtered Vehicle Query:** Dropdown dynamically filters and displays **only** vehicles currently in `GATED_IN` status.
* **Driver & Gate Details Auto-Population:** Automatically retrieves and populates Driver Name, Driver ID, and Phone Number from the active gate record upon vehicle selection.
* **Automated Data Capture:** Automatically updates record status to `GATED_OUT`, logs `date_time_out` timestamp, and assigns `gated_out_by_user_id`.

### 4. Interactive Dashboard & Gate History Logs

* **Insights Widgets:** Key metrics displaying Total Vehicles, Total Drivers/Employees, Vehicles Currently Gated In, and Vehicles Gated Out.
* **Operations Chart:** Interactive line chart tracking daily Gate In vs. Gate Out traffic over time.
* **History Log Table:** Searchable, filterable audit log displaying full gate records with operator attribution.

---

## Tech Stack

* **Framework:** Laravel 11 / PHP 8.3+
* **Admin Panel & UI:** Filament v3 (Livewire / Alpine.js / Tailwind CSS)
* **Database:** MySQL 8.0+
* **Session & Cache Management:** MySQL / Database Driver

---

## Database Architecture

```
vehicles
  ├── id (PK)
  ├── registration_number (Unique)
  └── vehicle_type

drivers
  ├── id (PK)
  ├── name
  ├── driver_id (Unique)
  └── phone_number

gate_records
  ├── id (PK)
  ├── vehicle_id (FK -> vehicles.id)
  ├── driver_id (FK -> drivers.id)
  ├── status (ENUM: 'GATED_IN', 'GATED_OUT')
  ├── date_time_in (Timestamp)
  ├── date_time_out (Timestamp, Nullable)
  ├── gated_in_by_user_id (FK -> users.id)
  ├── gated_out_by_user_id (FK -> users.id, Nullable)
  └── timestamps

user_logins
  ├── id (PK)
  ├── user_id (FK -> users.id)
  ├── ip_address
  ├── user_agent
  └── logged_in_at (Timestamp)

```

---

## Deployment Manual

### Prerequisites

Ensure the deployment server meet the following requirements:

* PHP 8.2 or 8.3 with extensions: `pdo_mysql`, `mbstring`, `openssl`, `curl`, `xml`, `zip`, `bcmath`
* Composer 2.x
* MySQL 8.0+ or MariaDB 10.5+
* Web Server: Apache 2.4+ or NGINX
* Git

---

### Step-by-Step Installation & Deployment

#### 1. Clone the Repository

```bash
git clone https://github.com/your-username/Task_2_Web_Application-_Development_Vehicle_Gate-_Operations.git
cd Task_2_Web_Application-_Development_Vehicle_Gate-_Operations

```

#### 2. Install PHP Dependencies

```bash
composer install --optimize-autoloader --no-dev

```

#### 3. Environment Configuration

Copy the `.env.example` file to create your `.env` configuration file:

```bash
cp .env.example .env

```

Update your `.env` file with database credentials and production settings:

```ini
APP_NAME="Vehicle Gate Operations"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain-or-ip

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=assessment_task_2
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

SESSION_DRIVER=database
SESSION_LIFETIME=120

```

#### 4. Generate Application Key

```bash
php artisan key:generate

```

#### 5. Database Setup & Migration

Run fresh database migrations and seed default administrative user and sample test data:

```bash
php artisan migrate:fresh --seed

```

*(Optional) Create a specific administrative user for Filament access:*

```bash
php artisan make:filament-user

```

#### 6. Storage Link Creation

Create the symbolic link from `public/storage` to `storage/app/public`:

```bash
php artisan storage:link

```

#### 7. Cache Optimization for Production

Optimize configuration, route, view, and event loading:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize

```

#### 8. Directory Permissions

Grant necessary read and write permissions to the storage and bootstrap cache directories:

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

```

---

## Web Server Configuration

### Apache VirtualHost Configuration (`/etc/apache2/sites-available/vehicle-gate.conf`)

```apache
<VirtualHost *:80>
    ServerName your-domain-or-ip
    DocumentRoot /var/www/Task_2_Web_Application-_Development_Vehicle_Gate-_Operations/public

    <Directory /var/www/Task_2_Web_Application-_Development_Vehicle_Gate-_Operations/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/vehicle_gate_error.log
    CustomLog ${APACHE_LOG_DIR}/vehicle_gate_access.log combined
</VirtualHost>

```

Enable the site and rewrite module:

```bash
a2ensite vehicle-gate.conf
a2enmod rewrite
systemctl restart apache2

```

---

## Verification & Testing

1. Access the web interface at `http://your-domain-or-ip/admin`.
2. Login with generated credentials.
3. Verify Dashboard widgets and operations traffic charts load.
4. Navigate to **Vehicle Gate In** (`/admin/gate-records/create`), select a vehicle and driver, and submit to log entry.
5. Navigate to **Vehicle Gate Out** (`/admin/gate-out-vehicle`), select the vehicle from the filtered dropdown, verify driver auto-population, and log exit.
6. Check **Gate History Logs** (`/admin/gate-records`) to confirm timestamps, statuses, and operator IDs recorded correctly.