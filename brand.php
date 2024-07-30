<?php
// Connection parameters
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'test';

// Attempt to connect to MySQL
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get distinct departments
$sql = "SELECT DISTINCT department FROM branches";
$result = $conn->query($sql);

if ($result === false) {
    die("Error fetching departments: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Department Table</title>
    <style>
        body {
            background-color : #000;
        }
        h1 {
            text-align : center;
            color : white;
            margin-top : 60px;
        }
        table {
            width: 70%;
            border-collapse: collapse;
            margin: 0 auto;
            background-color : white;
            padding: auto;
            margin-top : 60px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            text-align : center;
            background-color: #f2f2f2;
        }
        td {
            text-align : center;
        }
        td button {
            border radius : 10px;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        tr:hover a {
            color: #0ef; /* Change link color on hover */
        }
        a {
            text-decoration: none;
            color: blue;
            transition: color 0.3s;
        }
    </style>
</head>
<body>

<h1>Department Table</h1>

<table>
  <thead>
    <tr>
      <th>S.No</th>
      <th>Department</th>
      <th>More</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sno = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $sno++ . "</td>";
        echo "<td>" . htmlspecialchars($row['department']) . "</td>";
        echo "<td><button><a href='details.php?department=" . urlencode($row['department']) . "'>View More</a></button></td>";
        echo "</tr>";
    }
    ?>
  </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>
