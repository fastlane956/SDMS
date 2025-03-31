<?php
session_start();
include 'includes/db.php';

// Ensure the user is logged in as a teacher
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'teacher') {
    header("Location: index.php");
    exit();
}

// Get the teacher ID from the query parameter
if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];

    // Fetch the teacher's details
    $sql = "SELECT * FROM teachers WHERE id = $teacher_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
    } else {
        echo "Teacher not found.";
        exit();
    }

    // Handle the form submission to update teacher data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $department = $_POST['department'];

        $update_sql = "UPDATE teachers SET name='$name', department='$department' WHERE id=$teacher_id";
        if ($conn->query($update_sql) === TRUE) {
            echo "Teacher details updated successfully.";
            header("Location: teacher_dashboard.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    echo "Invalid teacher ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Edit Teacher Information</h1>
        <a href="logout.php">Logout</a>
    </header>

    <div class="container">
        <h3>Edit Teacher Details</h3>
        <form method="POST">
            <label for="name">Teacher Name:</label>
            <input type="text" name="name" value="<?php echo $teacher['name']; ?>" required><br>

            <label for="department">Department:</label>
            <input type="text" name="department" value="<?php echo $teacher['department']; ?>" required><br>

            <button type="submit">Update Teacher</button>
        </form>
    </div>
</body>
</html>
