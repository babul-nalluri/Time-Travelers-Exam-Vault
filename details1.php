<?php
// Connection parameters
$host = 'localhost';  // Adjust the host and port if necessary
$user = 'root';            // MySQL username
$password = '';            // MySQL password
$database = 'test';        // Database name

// Attempt to connect to MySQL
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for branch, year, and semester
$branch = isset($_GET['branch']) ? $_GET['branch'] : 'CSE';
$year = isset($_GET['year']) ? $_GET['year'] : 'E2';
$sem = isset($_GET['sem']) ? $_GET['sem'] : 'Sem2';

// Prepare the SQL query to fetch data for the selected branch, year, and semester
$stmt = $conn->prepare("
    SELECT academic, subject, mt1, mt2, mt3, sem
    FROM branch 
    WHERE branch = ? AND year = ? AND semister = ?
");

// Check if the statement preparation was successful
if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}

// Bind the parameters
$stmt->bind_param("sss", $branch, $year, $sem);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Close statement
$stmt->close();

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subjects</title>
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
    /* tr:hover { */
        /* background-color: #f5f5f5; */
    /* } */
    /* tr:hover a { */
        /* color: #0ef;  Change link color on hove */
    /* } */
    a {
        text-decoration: none;
        color: blue;
        transition: color 0.3s;
    }
</style>
</head>
<body>

<h1>Details for Branch: <?php echo htmlspecialchars($branch); ?>, Year: <?php echo htmlspecialchars($year); ?>, Sem: <?php echo htmlspecialchars($sem); ?></h1>

<table>
  <thead>
    <tr>
      <th>Academic Year</th>
      <th>Subject</th>
      <th>MT1</th>
      <th>MT2</th>
      <th>MT3</th>
      <th>Sem</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($result->num_rows > 0) { 
        while ($row = $result->fetch_assoc()) { 
    ?>
    <tr>
      <td><?php echo htmlspecialchars($row['academic']); ?></td>
      <td><?php echo htmlspecialchars($row['subject']); ?></td>
      <td><button><?php echo (!empty($row['mt1'])) ? '<a href="download.php?file=' . urlencode($row['mt1']) . '" class="btn-download" download>Download PDF</a>' : 'N/A'; ?></button></td>
      <td><button><?php echo (!empty($row['mt2'])) ? '<a href="download.php?file=' . urlencode($row['mt2']) . '" class="btn-download" download>Download PDF</a>' : 'N/A'; ?></button></td>
      <td><button><?php echo (!empty($row['mt3'])) ? '<a href="download.php?file=' . urlencode($row['mt3']) . '" class="btn-download" download>Download PDF</a>' : 'N/A'; ?></button></td>
      <td><button><?php echo (!empty($row['sem'])) ? '<a href="download.php?file=' . urlencode($row['sem']) . '" class="btn-download" download>Download PDF</a>' : 'N/A'; ?></button></td>
     
    </tr>
    <?php 
        }
    } else {
        echo '<tr><td colspan="6">No data found</td></tr>';
    }
    ?>
  </tbody>
</table>

</body>
</html>
