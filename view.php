<?php
// view_enrollments.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website1"; // change if your DB has a different name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT * FROM enrollment ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Enrollments</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: #f4f6fa;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #002B5B;
        }

        table {
            margin: 20px auto;
            width: 90%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #002B5B;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h1>Student Enrollments</h1>

    <table>
        <tr>
            <th>Enrollment No</th>
            <th>Email</th>
            <th>Password</th>
            <th>Created At</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['enrollment_no']}</td>
                        <td>{$row['email']}</td>
                        <td>••••••</td>
                        <td>{$row['created_at']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align:center;'>No enrollments found</td></tr>";
        }
        ?>

    </table>

</body>
</html>

<?php $conn->close(); ?>
