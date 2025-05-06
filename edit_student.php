<?php
session_start();
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];

    $sql = "UPDATE students SET name = ?, email = ?, phone = ?, course = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $course, $id);
    
    if($stmt->execute()) {
        $_SESSION['message'] = '<i class="fas fa-check-circle"></i> Student updated successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = '<i class="fas fa-times-circle"></i> Error updating student.';
        $_SESSION['message_type'] = 'error';
    }
    header("Location: view_students.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student - Royal Global University</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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

        .student-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5; /* Light gray hover effect */
        }
    </style>
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
            <i class="fas fa-user-edit"></i>
            <span>Editing Student: <?php echo htmlspecialchars($student['name']); ?></span>
        </div>

        <div class="student-info">
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
                
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Student Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Phone</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-graduation-cap"></i> Course</label>
                    <input type="text" name="course" value="<?php echo htmlspecialchars($student['course']); ?>">
                </div>
                
                <button type="submit">
                    <i class="fas fa-save"></i> Update Student
                </button>
            </form>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
