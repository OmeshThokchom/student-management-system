# Student Management System - Royal Global University

A modern, responsive web application for managing student records in the Computer Science Department of Royal Global University.

## 🚀 Features

- **Modern UI/UX**
  - Responsive design for all devices
  - Dark/Light theme support
  - Glassmorphism design elements
  - iOS-style notifications

- **Student Management**
  - Add new students
  - View all students with pagination
  - Edit student information
  - Delete student records
  - Real-time search functionality

- **Dashboard**
  - Quick action cards
  - Recently added students overview
  - Department information

## 🛠️ Technical Stack

- **Frontend**
  - HTML5
  - CSS3 (with modern features)
  - Font Awesome Icons

- **Backend**
  - PHP 7.4+
  - MySQL Database

## 📋 Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- mod_rewrite enabled (for Apache)

## 💻 Installation

1. **Database Setup**
   ```sql
   mysql -u root -p < setup.sql
   ```

2. **Directory Permissions**
   ```bash
   chmod -R 755 /home/omesh_thokchom/Pictures/sachin
   chmod -R 777 /home/omesh_thokchom/Pictures/sachin/assets/images
   ```

3. **Access Application**
   Navigate to: `http://localhost/sachin/`

## 🔧 Configuration

### Database Credentials
```php
$servername = "localhost";
$username = "student_admin";
$password = "omesh2001";
$dbname = "student_management";
```

### Theme Settings
- Default theme can be configured in `assets/css/style.css`
- Theme preferences are stored in browser cookies

### Pagination
- Default items per page: 10 (adjustable in view_students.php)
- Configure in `view_students.php`:
  ```php
  $limit = 10; // Change this value
  ```

## 🔐 Security Features

- SQL Injection Prevention
  - Prepared Statements
  - Parameter Binding

- XSS Prevention
  - HTML Escaping
  - Input Validation

## 👥 Contributors

- Developer: Omesh Thokchom
- Email: thokchomdayananda54@gmail.com
- Department: Computer Science, Royal Global University

## 📱 Responsive Breakpoints

- Mobile: 320px - 480px
- Tablet: 481px - 768px
- Desktop: 769px - 1024px
- Large Desktop: 1025px+

## 🎨 Theme Colors

```css
:root {
    --primary-color: #2196F3;
    --primary-dark: #1976D2;
    --text-light: #2c3e50;
    --text-dark: #ffffff;
}
```

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support & Contact

For support:
- Email: thokchomdayananda54@gmail.com
- Phone: Contact CS Department
- Location: Royal Global University, Guwahati, Assam

## 🙏 Acknowledgments

- Royal Global University CS Department
- Font Awesome for icons
- Contributors and testers

---
Made with ❤️ by Omesh Thokchom for Royal Global University
