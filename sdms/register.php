<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Student Database Management System</h1>
    </header>
    <div class="container">
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="roll_no" placeholder="Roll No (for Students)" required>
            <input type="text" name="department" placeholder="Department" required>
            <select name="role" required>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
