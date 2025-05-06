<?php
session_start();
require_once 'config/db.php';

$limit = 10; // Number of students per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch students with pagination
$sql = "SELECT * FROM students ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Get total number of students for pagination
$total_students = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()['total'];
$total_pages = ceil($total_students / $limit);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Students - Royal Global University</title>
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

        function searchStudents(query) {
            const rows = document.querySelectorAll('table tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const isMatch = text.includes(query.toLowerCase());
                row.style.display = isMatch ? '' : 'none';
            });
        }
    </script>
    <style>
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

        .student-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 5px 15px;
            width: 300px;
        }

        .search-box input {
            background: transparent;
            border: none;
            padding: 10px;
            width: 100%;
        }

        .search-box i {
            color: #4CAF50;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 5px;
            color: inherit;
            text-decoration: none;
        }

        .pagination a.active {
            background: #4CAF50;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5; /* Light gray hover effect */
        }

        .home-btn {
            background: #4CAF50;
            color: white;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .action-buttons a {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
        }
        
        .edit-btn {
            background: #2196F3;
        }
        
        .delete-btn {
            background: #f44336;
        }
        
        .message-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: modalSlideUp 0.3s ease;
        }

        @keyframes modalSlideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-content h3 {
            color: #f44336;
            margin-bottom: 20px;
            font-size: 1.5em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .modal-content p {
            margin-bottom: 25px;
            color: #666;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .modal-buttons a {
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: transform 0.2s ease;
        }

        .modal-buttons a:hover {
            transform: scale(1.05);
        }

        .delete-confirm-btn {
            background: #f44336;
            color: white;
        }

        .cancel-btn {
            background: rgba(0, 0, 0, 0.1);
            color: #666;
        }

        body.dark-theme .modal-content {
            background: rgba(30, 30, 30, 0.95);
        }

        body.dark-theme .modal-content p {
            color: #ccc;
        }

        body.dark-theme .cancel-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-moon"></i>
    </div>

    <?php if(isset($_SESSION['message'])): ?>
    <div class="dynamic-notification <?php echo isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'success'; ?>">
        <?php 
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        ?>
    </div>
    <?php endif; ?>

    <div class="hero">
        <h1><i class="fas fa-university"></i> Royal Global University</h1>
        <p><i class="fas fa-users"></i> Student Directory</p>
    </div>

    <div class="container">
        <div class="student-controls">
            <button onclick="window.location.href='index.php'" class="home-btn">
                <i class="fas fa-home"></i> Home
            </button>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search students..." onkeyup="searchStudents(this.value)">
            </div>
            <button onclick="window.location.href='add_student.php'">
                <i class="fas fa-user-plus"></i> Add New Student
            </button>
        </div>

        <div class="recent-students">
            <table>
                <tr>
                    <th><i class="fas fa-id-card"></i> ID</th>
                    <th><i class="fas fa-user"></i> Name</th>
                    <th><i class="fas fa-envelope"></i> Email</th>
                    <th><i class="fas fa-phone"></i> Phone</th>
                    <th><i class="fas fa-graduation-cap"></i> Course</th>
                    <th><i class="fas fa-calendar"></i> Added On</th>
                    <th><i class="fas fa-cog"></i> Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="edit-btn">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="view_students.php?action=delete&id=<?php echo $row['id']; ?>" class="delete-btn">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>

            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>>
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <?php if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])): ?>
    <div class="message-modal">
        <div class="modal-content">
            <h3>
                <i class="fas fa-exclamation-circle"></i>
                Delete Student
            </h3>
            <p>Are you sure you want to delete this student? This action cannot be undone.</p>
            <div class="modal-buttons">
                <a href="delete_student.php?id=<?php echo $_GET['id']; ?>" class="delete-confirm-btn">
                    <i class="fas fa-trash"></i> Delete
                </a>
                <a href="view_students.php" class="cancel-btn">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <footer class="footer">
        <!-- Footer content same as index.php -->
    </footer>
</body>
</html>
