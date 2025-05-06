<?php
require_once 'config/db.php';

// Fetch the 5 most recently added students
$sql = "SELECT * FROM students ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Royal Global University - Computer Science Department</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        // Apply the saved theme on page load
        document.addEventListener('DOMContentLoaded', () => {
            const theme = getCookie('theme');
            if (theme === 'dark') {
                document.body.classList.add('dark-theme');
            }
        });

        // Toggle theme and save preference in a cookie
        function toggleTheme() {
            document.body.classList.toggle('dark-theme');
            const theme = document.body.classList.contains('dark-theme') ? 'dark' : 'light';
            setCookie('theme', theme, 365);
        }

        // Helper functions to manage cookies
        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/`;
        }

        function getCookie(name) {
            const cookies = document.cookie.split(';');
            for (let i = 0; i < cookies.length; i++) {
                const cookie = cookies[i].trim();
                if (cookie.startsWith(name + '=')) {
                    return cookie.substring(name.length + 1);
                }
            }
            return '';
        }
    </script>
    <style>
        .hero {
            background: url('assets/images/royal_global_university.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 50px 20px;
        }
        .hero h1 {
            font-size: 3em;
            margin-bottom: 10px;
        }
        .hero p {
            font-size: 1.2em;
        }
        .action-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .action-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .action-card i {
            font-size: 2.5em;
            margin-bottom: 15px;
            color: #4CAF50;
        }
        .action-card h3 {
            margin: 10px 0;
            color: #333;
        }
        body.dark-theme .action-card {
            background: rgba(30, 30, 30, 0.5);
        }
        body.dark-theme .action-card h3 {
            color: #fff;
        }
        .recent-students {
            margin-top: 30px;
        }
        .recent-students table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            overflow: hidden;
        }
        .recent-students th, 
        .recent-students td {
            padding: 15px;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: left;
        }
        .recent-students th {
            background-color: #4CAF50;
            color: white;
        }
        .recent-students tr:hover {
            background-color: #f5f5f5; /* Light gray hover effect */
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .theme-toggle i {
            font-size: 1.2em;
            color: #333;
        }

        body.dark-theme .theme-toggle i {
            color: #fff;
        }

        .footer {
            margin-top: 50px;
            padding: 40px 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            padding: 0 20px;
        }

        .footer-section {
            padding: 20px;
        }

        .footer-section h4 {
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #333;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            color: #333;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            transform: translateY(-3px);
            background: #4CAF50;
            color: white;
        }

        body.dark-theme .footer-section h4,
        body.dark-theme .social-links a {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-moon"></i>
    </div>
    
    <div class="hero">
        <h1><i class="fas fa-university"></i> Royal Global University</h1>
        <p><i class="fas fa-laptop-code"></i> Welcome to the Computer Science Department</p>
    </div>

    <div class="container">
        <h2><i class="fas fa-users-gear"></i> Manage Students</h2>
        <div class="action-cards">
            <div class="action-card" onclick="window.location.href='add_student.php'">
                <i class="fas fa-user-plus"></i>
                <h3>Add Student</h3>
                <p>Register a new student in the system</p>
            </div>
            <div class="action-card" onclick="window.location.href='view_students.php'">
                <i class="fas fa-users"></i>
                <h3>View Students</h3>
                <p>View and manage all students</p>
            </div>
        </div>
        <div class="recent-students">
            <h3><i class="fas fa-clock-rotate-left"></i> Recently Added Students</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Course</th>
                    <th>Added On</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4><i class="fas fa-info-circle"></i> About Us</h4>
                <p>The Computer Science Department at Royal Global University is dedicated to excellence in education and innovation in technology.</p>
            </div>
            
            <div class="footer-section">
                <h4><i class="fas fa-address-card"></i> Contact</h4>
                <p><i class="fas fa-envelope"></i> Email: cs@rgu.ac.in</p>
                <p><i class="fas fa-phone"></i> Phone: +91 1234567890</p>
                <p><i class="fas fa-location-dot"></i> Location: Guwahati, Assam</p>
            </div>

            <div class="footer-section">
                <h4><i class="fas fa-link"></i> Quick Links</h4>
                <ul>
                    <li><a href="#"><i class="fas fa-graduation-cap"></i> Academic Programs</a></li>
                    <li><a href="#"><i class="fas fa-chalkboard-teacher"></i> Faculty</a></li>
                    <li><a href="#"><i class="fas fa-flask"></i> Research</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4><i class="fas fa-share-nodes"></i> Connect With Us</h4>
                <div class="social-links">
                    <a href="https://facebook.com/RoyalGlobalUniversity" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/RoyalGlobalUniv" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/school/royal-global-university" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://instagram.com/royalglobaluniversity" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://youtube.com/@RoyalGlobalUniversity" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
