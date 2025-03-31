<?php
session_start();
include 'includes/db.php';

// Check if the user is already logged in
if (isset($_SESSION['id'])) {
    // Redirect to appropriate dashboard if already logged in
    if ($_SESSION['role'] == 'student') {
        header("Location: student_dashboard.php");
        exit();
    } elseif ($_SESSION['role'] == 'teacher') {
        header("Location: teacher_dashboard.php");
        exit();
    }
}

// Handle login and registration logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check for student login
        $sql = "SELECT * FROM students WHERE roll_no='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['role'] = 'student';
                header("Location: student_dashboard.php");
                exit();
            }
        }

        // Check for teacher login
        $sql = "SELECT * FROM teachers WHERE name='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['role'] = 'teacher';
                header("Location: teacher_dashboard.php");
                exit();
            }
        }

        echo "Invalid credentials!";
    }

    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $department = $_POST['department'];
        $role = $_POST['role'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if ($role == 'student') {
            $roll_no = $_POST['roll_no'];
            $sql = "INSERT INTO students (name, roll_no, department, password) VALUES ('$name', '$roll_no', '$department', '$password')";
        } else {
            $sql = "INSERT INTO teachers (name, department, password) VALUES ('$name', '$department', '$password')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful! Please login.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Database Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Student Database Management System</h1>
    </header>
    <div class="container">
        <h2>Welcome to the SDMS</h2>

        <!-- Login or Register Form -->
        <div class="form-container">
            <!-- Login Form -->
            <div id="loginForm">
                <h3>Login</h3>
                <form method="POST">
                    <input type="text" name="username" placeholder="Username (Roll No or Name)" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login">Login</button>
                </form>
                <p>Don't have an account? <a href="javascript:void(0);" onclick="showRegisterForm()">Register here</a></p>
            </div>

            <!-- Registration Form -->
            <div id="registerForm" style="display:none;">
                <h3>Register</h3>
                <form method="POST">
                    <input type="text" name="name" placeholder="Full Name" required>
                    <input type="text" name="department" placeholder="Department" required>
                    <select name="role" id="role" onchange="toggleRollNoField()" required>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                    <div id="rollNoDiv">
                        <input type="text" name="roll_no" id="roll_no" placeholder="Roll No" required>
                    </div>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="register">Register</button>
                </form>
                <p>Already have an account? <a href="javascript:void(0);" onclick="showLoginForm()">Login here</a></p>
            </div>
        </div>
    </div>

    <script>
        function showRegisterForm() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
        }

        function showLoginForm() {
            document.getElementById('registerForm').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
        }

        function toggleRollNoField() {
            const role = document.getElementById('role').value;
            const rollNoDiv = document.getElementById('rollNoDiv');
            const rollNoField = document.getElementById('roll_no');

            if (role === 'student') {
                rollNoDiv.style.display = 'block';
                rollNoField.required = true;
            } else {
                rollNoDiv.style.display = 'none';
                rollNoField.required = false;
            }
        }

        toggleRollNoField();
    </script>
</body>
</html>
