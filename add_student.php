<?php
session_start();
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];

    $sql = "INSERT INTO students (name, email, phone, course) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $phone, $course);
    
    if($stmt->execute()) {
        $_SESSION['message'] = '<i class="fas fa-check-circle"></i> Student added successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = '<i class="fas fa-times-circle"></i> Error adding student.';
        $_SESSION['message_type'] = 'error';
    }
    header("Location: view_students.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Student - Royal Global University</title>
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
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-group i {
            margin-right: 10px;
            color: #4CAF50;
        }

        .navigation-controls {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .page-label {
            background: rgba(76, 175, 80, 0.1);
            padding: 10px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .page-label i {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-moon"></i>
    </div>

    <div class="hero">
        <h1><i class="fas fa-university"></i> Student Management System</h1>
    </div>

    <div class="container">
        <div class="navigation-controls">
            <button onclick="window.location.href='index.php'" class="home-btn">
                <i class="fas fa-home"></i> Home
            </button>
            <button onclick="window.location.href='view_students.php'">
                <i class="fas fa-arrow-left"></i> Back to List
            </button>
        </div>

        <div class="page-label">
            <i class="fas fa-user-plus"></i>
            <span>Add New Student</span>
        </div>

        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Student Name</label>
                    <input type="text" name="name" placeholder="Enter student name" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" placeholder="Enter email address" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Phone Number</label>
                    <input type="text" name="phone" placeholder="Enter phone number">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-graduation-cap"></i> Course</label>
                    <input type="text" name="course" placeholder="Enter course name">
                </div>
                <button type="submit"><i class="fas fa-plus-circle"></i> Add Student</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <!-- ... same footer as index.php ... -->
    </footer>
</body>
</html>
