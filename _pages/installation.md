---
layout: page
title: Installation Guide
permalink: /installation/
---

# Installation Guide

This guide will walk you through setting up Buku Tamu on your server.

## System Requirements

### Minimum Requirements
- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher (or MariaDB 10.2+)
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Disk Space**: 50MB minimum
- **Memory**: 128MB RAM minimum

### Recommended Requirements
- **PHP**: 8.0 or higher
- **MySQL**: 8.0 or higher
- **Web Server**: Apache 2.4+ with mod_rewrite
- **Disk Space**: 200MB
- **Memory**: 512MB RAM

## Installation Methods

### Method 1: Manual Installation

#### Step 1: Download the Application

```bash
# Clone from GitHub
git clone https://github.com/arifbdarsono/buku-tamu.git

# Or download ZIP and extract
wget https://github.com/arifbdarsono/buku-tamu/archive/main.zip
unzip main.zip
```

#### Step 2: Database Setup

1. **Create Database**
   ```sql
   CREATE DATABASE bukutamu_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Create Database User** (optional but recommended)
   ```sql
   CREATE USER 'bukutamu_user'@'localhost' IDENTIFIED BY 'secure_password';
   GRANT ALL PRIVILEGES ON bukutamu_db.* TO 'bukutamu_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

3. **Import Database Schema**
   ```bash
   mysql -u bukutamu_user -p bukutamu_db < bukutamu.sql
   ```

#### Step 3: Configure Application

1. **Copy to Web Directory**
   ```bash
   # For Apache
   sudo cp -r buku-tamu /var/www/html/
   
   # For Nginx
   sudo cp -r buku-tamu /var/www/
   ```

2. **Set Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/html/buku-tamu
   sudo chmod -R 755 /var/www/html/buku-tamu
   sudo chmod -R 777 /var/www/html/buku-tamu/logs
   ```

3. **Configure Database Connection**
   
   Edit `config/database.php`:
   ```php
   <?php
   $host = 'localhost';
   $dbname = 'bukutamu_db';
   $username = 'bukutamu_user';
   $password = 'secure_password';
   
   try {
       $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } catch(PDOException $e) {
       die("Connection failed: " . $e->getMessage());
   }
   ?>
   ```

### Method 2: Docker Installation

#### Step 1: Create Docker Compose File

Create `docker-compose.yml`:
```yaml
version: '3.8'

services:
  web:
    image: php:8.0-apache
    ports:
      - "8080:80"
    volumes:
      - ./:/var/www/html
    depends_on:
      - db
    environment:
      - DB_HOST=db
      - DB_NAME=bukutamu
      - DB_USER=root
      - DB_PASS=rootpassword

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: bukutamu
    volumes:
      - mysql_data:/var/lib/mysql
      - ./bukutamu.sql:/docker-entrypoint-initdb.d/bukutamu.sql

volumes:
  mysql_data:
```

#### Step 2: Run Docker Containers

```bash
docker-compose up -d
```

## Web Server Configuration

### Apache Configuration

Create `.htaccess` file:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Security headers
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"

# Hide PHP version
Header unset X-Powered-By
```

### Nginx Configuration

Add to your Nginx site configuration:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/buku-tamu;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Security
    location ~ /\. {
        deny all;
    }
    
    location ~* \.(sql|log)$ {
        deny all;
    }
}
```

## Post-Installation Setup

### 1. Create Admin Account

Access the admin setup (if available) or manually insert admin credentials:
```sql
INSERT INTO admin (username, password) VALUES ('admin', MD5('your_secure_password'));
```

### 2. Test Installation

1. Visit your website: `http://your-domain.com/buku-tamu`
2. Try adding a guest entry
3. Access admin panel: `http://your-domain.com/buku-tamu/admin`

### 3. Security Hardening

1. **Change Default Passwords**
2. **Remove Installation Files** (if any)
3. **Set Proper File Permissions**
4. **Enable HTTPS**
5. **Configure Firewall**

## Troubleshooting

### Common Issues

#### Database Connection Error
- Check database credentials in `config/database.php`
- Verify MySQL service is running
- Check firewall settings

#### Permission Denied
```bash
sudo chown -R www-data:www-data /var/www/html/buku-tamu
sudo chmod -R 755 /var/www/html/buku-tamu
```

#### PHP Errors
- Check PHP error logs
- Verify PHP version compatibility
- Install required PHP extensions

### Log Files

Check these log files for errors:
- `/var/log/apache2/error.log` (Apache)
- `/var/log/nginx/error.log` (Nginx)
- `/var/log/mysql/error.log` (MySQL)
- `logs/` directory in application

## Getting Help

If you encounter issues:
1. Check the [troubleshooting section](#troubleshooting)
2. Search existing [GitHub issues](https://github.com/arifbdarsono/buku-tamu/issues)
3. Create a new issue with detailed error information
4. Join our community discussions

---

*Need help? Don't hesitate to ask in our [GitHub Issues](https://github.com/arifbdarsono/buku-tamu/issues)!*