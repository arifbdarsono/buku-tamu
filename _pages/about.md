---
layout: page
title: About
permalink: /about/
---

# About Buku Tamu

Buku Tamu is a simple yet powerful guest book application designed to help websites collect visitor feedback and messages in an organized manner.

## Project Goals

- **Simplicity**: Easy to install and use
- **Security**: Built with security best practices
- **Flexibility**: Customizable to fit different needs
- **Performance**: Lightweight and fast

## Why Buku Tamu?

In Indonesian, "Buku Tamu" literally means "Guest Book." This application was created to provide a digital equivalent of traditional guest books found in hotels, events, and offices.

### Key Benefits

1. **Digital Record Keeping**: All guest entries are stored digitally and can be easily searched and managed
2. **Admin Control**: Full administrative control over guest entries
3. **Data Export**: Export guest data for analysis or backup
4. **Responsive Design**: Works on desktop and mobile devices

## Technical Details

### Architecture

The application follows a simple MVC-like pattern:
- **Models**: Database interactions through `config/database.php`
- **Views**: HTML templates with PHP includes
- **Controllers**: Individual PHP files handling specific actions

### Security Features

- SQL injection prevention using prepared statements
- XSS protection through input sanitization
- Session-based authentication for admin panel
- CSRF protection (recommended for production)

## Development Philosophy

This project emphasizes:
- **Clean Code**: Readable and maintainable code structure
- **Documentation**: Comprehensive documentation for users and developers
- **Community**: Open to contributions and feedback
- **Learning**: Great for beginners learning PHP and MySQL

## Future Enhancements

Planned features for future versions:
- Email notifications for new entries
- Captcha integration
- Multiple language support
- API endpoints
- Enhanced admin dashboard
- User registration system

## Contact

For questions, suggestions, or contributions, please reach out through:
- GitHub Issues
- Pull Requests
- Email (if provided in profile)

---

*This project is maintained by [arifbdarsono](https://github.com/arifbdarsono) and the open source community.*