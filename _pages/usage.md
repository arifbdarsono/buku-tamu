---
layout: page
title: Usage Guide
permalink: /usage/
---

# Usage Guide

Learn how to use Buku Tamu effectively for both visitors and administrators.

## For Visitors

### Adding a Guest Entry

1. **Navigate to the Guest Book**
   - Visit the main page of the application
   - You'll see the guest book form and existing entries

2. **Fill Out the Form**
   - **Name**: Enter your full name
   - **Gender**: Select Male or Female
   - **Message**: Write your message or feedback

3. **Submit Your Entry**
   - Click the "Submit" or "Kirim" button
   - Your entry will be added to the guest book
   - You'll see a confirmation message

### Viewing Guest Entries

- **Browse Entries**: Scroll through the list of guest entries
- **Pagination**: Use page numbers to navigate through multiple pages
- **Recent First**: Entries are displayed with the most recent first

### Searching Entries

1. **Use the Search Box**
   - Enter keywords to search in names or messages
   - Results will filter automatically

2. **Filter by Gender**
   - Use the gender filter dropdown
   - Select "Male", "Female", or "All"

## For Administrators

### Accessing the Admin Panel

1. **Login**
   - Navigate to `/admin/dashboard.php`
   - Enter your admin credentials
   - Click "Login"

2. **Dashboard Overview**
   - View total number of entries
   - See recent activity
   - Access management tools

### Managing Guest Entries

#### Viewing All Entries

- **Admin Dashboard**: See all entries in a table format
- **Detailed View**: Click on entries for full details
- **Sorting**: Sort by date, name, or other criteria

#### Editing Entries

1. **Select Entry**: Click "Edit" next to any entry
2. **Modify Information**:
   - Update name, gender, or message
   - Add admin notes (if feature available)
3. **Save Changes**: Click "Update" to save modifications

#### Deleting Entries

1. **Select Entry**: Click "Delete" next to unwanted entries
2. **Confirm Deletion**: Confirm the action when prompted
3. **Permanent Removal**: Entry will be permanently deleted

⚠️ **Warning**: Deleted entries cannot be recovered!

### Data Management

#### Exporting Data

1. **Access Export Feature**
   - Go to the export section in admin panel
   - Or use the direct export link

2. **Choose Format**
   - CSV format (recommended for spreadsheets)
   - Other formats if available

3. **Download File**
   - Click "Export" to generate file
   - Download will start automatically

#### Backup Considerations

- **Regular Backups**: Export data regularly
- **Database Backup**: Also backup the MySQL database
- **File Backup**: Backup application files

### User Management (If Available)

#### Adding Admin Users

```sql
-- Manual method via database
INSERT INTO admin (username, password, email) 
VALUES ('newadmin', MD5('secure_password'), 'admin@example.com');
```

#### Changing Passwords

1. **Through Admin Panel** (if feature exists)
2. **Direct Database Update**:
   ```sql
   UPDATE admin SET password = MD5('new_password') WHERE username = 'admin';
   ```

## Advanced Features

### Customization

#### Modifying Appearance

1. **CSS Customization**
   - Edit styles in `includes/header.php`
   - Add custom CSS for branding

2. **Template Modification**
   - Modify `includes/header.php` and `includes/footer.php`
   - Update main templates as needed

#### Adding Fields

To add new fields to the guest book:

1. **Database Schema**
   ```sql
   ALTER TABLE bukutamu ADD COLUMN new_field VARCHAR(255);
   ```

2. **Update Forms**
   - Modify the main form in `index.php`
   - Update `simpan.php` to handle new field
   - Modify `edit.php` for editing

3. **Update Display**
   - Modify display templates to show new field

### Integration

#### Email Notifications

Add email notifications for new entries:

```php
// In simpan.php after successful insert
$to = 'admin@example.com';
$subject = 'New Guest Book Entry';
$message = "New entry from: " . $nama;
mail($to, $subject, $message);
```

#### API Integration

Create simple API endpoints:

```php
// api.php
header('Content-Type: application/json');

if ($_GET['action'] == 'entries') {
    $stmt = $pdo->query("SELECT * FROM bukutamu ORDER BY tanggal DESC");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
```

## Best Practices

### For Administrators

1. **Regular Monitoring**
   - Check entries daily for inappropriate content
   - Monitor for spam or abuse

2. **Data Management**
   - Export data monthly for backup
   - Clean up old or irrelevant entries

3. **Security**
   - Change admin passwords regularly
   - Monitor access logs
   - Keep application updated

### For Website Owners

1. **Content Moderation**
   - Set clear guidelines for guest entries
   - Moderate content regularly
   - Remove inappropriate entries promptly

2. **User Experience**
   - Keep the interface simple and intuitive
   - Provide clear instructions
   - Thank users for their participation

## Troubleshooting Common Issues

### Entry Not Saving

1. **Check Form Fields**: Ensure all required fields are filled
2. **Database Connection**: Verify database is accessible
3. **Permissions**: Check file and directory permissions

### Admin Login Issues

1. **Verify Credentials**: Double-check username and password
2. **Session Issues**: Clear browser cache and cookies
3. **Database Check**: Verify admin table exists and has data

### Display Problems

1. **PHP Errors**: Check error logs for PHP issues
2. **Database Queries**: Verify database queries are working
3. **Template Issues**: Check include files are accessible

## Getting Support

### Self-Help Resources

1. **Documentation**: Read through all documentation pages
2. **Code Comments**: Check inline code comments
3. **Error Logs**: Review application and server logs

### Community Support

1. **GitHub Issues**: Search existing issues or create new ones
2. **Discussions**: Participate in project discussions
3. **Contributions**: Help improve the project

### Professional Support

For commercial use or custom development:
- Contact the project maintainer
- Consider hiring a PHP developer
- Look for community developers

---

*Happy guest booking! 📝*