# Buku Tamu (Guest Book)

A simple and elegant guest book application built with PHP and MySQL. This application allows visitors to leave messages and administrators to manage guest entries.

## Features

- 📝 **Guest Registration**: Visitors can leave their name, message, and select gender
- 🔍 **Search Functionality**: Search through guest entries by name or message
- 📊 **Pagination**: Navigate through entries with pagination
- 🔐 **Admin Panel**: Secure admin interface for managing entries
- ✏️ **CRUD Operations**: Create, Read, Update, and Delete guest entries
- 📤 **Export Feature**: Export guest data
- 🎨 **Clean Interface**: User-friendly design

## Screenshots

*Add screenshots of your application here*

## Technology Stack

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Server**: Apache/Nginx

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- phpMyAdmin (optional, for database management)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/arifbdarsono/buku-tamu.git
   cd buku-tamu
   ```

2. **Database Setup**
   - Create a new MySQL database
   - Import the `bukutamu.sql` file into your database
   ```sql
   mysql -u username -p database_name < bukutamu.sql
   ```

3. **Configure Database Connection**
   - Edit `config/database.php`
   - Update database credentials:
   ```php
   $host = 'localhost';
   $dbname = 'your_database_name';
   $username = 'your_username';
   $password = 'your_password';
   ```

4. **Set Permissions**
   ```bash
   chmod 755 logs/
   chmod 644 config/database.php
   ```

5. **Access the Application**
   - Place files in your web server directory
   - Access via browser: `http://localhost/buku-tamu`

## Usage

### For Visitors

1. **Leave a Message**
   - Fill in your name
   - Select your gender
   - Write your message
   - Click "Submit"

2. **Search Messages**
   - Use the search box to find specific entries
   - Filter by gender if needed

### For Administrators

1. **Login**
   - Access admin panel: `/admin/dashboard.php`
   - Use admin credentials

2. **Manage Entries**
   - View all guest entries
   - Edit or delete entries
   - Export data

## File Structure

```
buku-tamu/
├── admin/
│   └── dashboard.php      # Admin panel
├── config/
│   └── database.php       # Database configuration
├── includes/
│   ├── header.php         # Common header
│   └── footer.php         # Common footer
├── logs/                  # Log files directory
├── index.php              # Main guest book page
├── login.php              # Admin login
├── tambah.php             # Add new entry
├── edit.php               # Edit entry
├── hapus.php              # Delete entry
├── simpan.php             # Save entry
├── export.php             # Export functionality
├── logout.php             # Admin logout
└── bukutamu.sql           # Database schema
```

## Database Schema

The application uses a simple database structure:

```sql
CREATE TABLE bukutamu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    genre ENUM('male', 'female') NOT NULL,
    pesan TEXT NOT NULL,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security Considerations

- Always validate and sanitize user inputs
- Use prepared statements for database queries
- Implement proper session management
- Regular security updates
- Use HTTPS in production

## License

This project is open source and available under the [MIT License](LICENSE).

## Support

If you encounter any issues or have questions:

- Create an issue on GitHub
- Check existing issues for solutions
- Contribute to the documentation

## Changelog

### Version 1.0.0
- Initial release
- Basic guest book functionality
- Admin panel
- Search and pagination features

---

**Made with ❤️ by [arifbdarsono](https://github.com/arifbdarsono)**