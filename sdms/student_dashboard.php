<?php
session_start();
include 'includes/db.php';

// Check if the user is logged in as a student
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'student') {
    header("Location: index.php");
    exit();
}

// Fetch student data
$student_id = $_SESSION['id'];
$sql = "SELECT * FROM students WHERE id='$student_id'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

// Fetch list of teachers
$teachers_sql = "SELECT * FROM teachers";
$teachers_result = $conn->query($teachers_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Student Dashboard</h1>
    </header>
    
    <div class="container">
        <h3>Your Profile</h3>
        <table>
            <tr>
                <th>Name</th>
                <td><?php echo $student['name']; ?></td>
            </tr>
            <tr>
                <th>Roll No</th>
                <td><?php echo $student['roll_no']; ?></td>
            </tr>
            <tr>
                <th>Department</th>
                <td><?php echo $student['department']; ?></td>
            </tr>
            <tr>
                <th>Grade</th>
                <td><?php echo $student['grade']; ?></td>
            </tr>
        </table>

        <h3>List of Teachers</h3>
        <table>
            <tr>
                <th>Teacher Name</th>
                <th>Department</th>
            </tr>
            <?php while ($teacher = $teachers_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $teacher['name']; ?></td>
                    <td><?php echo $teacher['department']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
