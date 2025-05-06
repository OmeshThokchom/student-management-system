<?php
session_start();
require_once 'config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        $_SESSION['message'] = '<i class="fas fa-check-circle"></i> Student deleted successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = '<i class="fas fa-times-circle"></i> Error deleting student.';
        $_SESSION['message_type'] = 'error';
    }
    header("Location: view_students.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <link rel="stylesheet" href="assets/css/style.css">
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
</head>
<body>
    <div class="container">
        <button onclick="window.location.href='index.php'">Home</button>
        <button onclick="toggleTheme()">Toggle Theme</button>
        <h2>Delete Student</h2>
        <p>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            ?>
        </p>
        <a href="view_students.php">Back to Student List</a>
    </div>
</body>
</html>
