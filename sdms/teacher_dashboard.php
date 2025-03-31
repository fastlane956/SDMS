<?php
session_start();
include 'includes/db.php';

// Check if the user is logged in as a teacher
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'teacher') {
    header("Location: index.php");
    exit();
}

// Fetch list of teachers (teachers should be able to see all teachers)
$teachers_sql = "SELECT * FROM teachers";
$teachers_result = $conn->query($teachers_sql);

// Fetch list of students (teachers should be able to see all students)
$students_sql = "SELECT * FROM students";
$students_result = $conn->query($students_sql);

// Handle updating student grade
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_grade'])) {
    $student_id = $_POST['student_id'];
    $grade = $_POST['grade'];

    $update_sql = "UPDATE students SET grade='$grade' WHERE id='$student_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Grade updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Teacher Dashboard</h1>
    </header>
    
    <div class="container">
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

        <h3>List of Students</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Roll No</th>
                <th>Department</th>
                <th>Grade</th>
                <th>Action</th>
            </tr>
            <?php while ($student = $students_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['roll_no']; ?></td>
                    <td><?php echo $student['department']; ?></td>
                    <td><?php echo $student['grade']; ?></td>
                    <td>
                        <button onclick="showEditForm(<?php echo $student['id']; ?>, '<?php echo $student['grade']; ?>')">Edit Grade</button>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h3>Edit Student Grade</h3>
        <div id="editForm" style="display:none;">
            <form method="POST">
                <input type="hidden" name="student_id" id="student_id">
                <input type="text" name="grade" id="grade" placeholder="New Grade" required>
                <button type="submit" name="update_grade">Update Grade</button>
            </form>
        </div>

        <a href="logout.php">Logout</a>
    </div>

    <script>
        function showEditForm(studentId, currentGrade) {
            // Show the edit form and populate it with current student grade data
            var form = document.getElementById('editForm');
            form.style.display = 'block';

            document.getElementById('student_id').value = studentId;
            document.getElementById('grade').value = currentGrade;
        }
    </script>
</body>
</html>
