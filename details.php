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

$branch = '';
if (isset($_GET['department'])) {
    $branch = $_GET['department'];

    // Prepare the SQL query to get distinct years and semisters for the selected branch
    $stmt = $conn->prepare("
        SELECT DISTINCT year, semister
        FROM branch 
        WHERE branch = ?
    ");

    // Check if the statement preparation was successful
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind the branch parameter
    $stmt->bind_param("s", $branch);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows === 0) {
        echo "No data found for branch: " . htmlspecialchars($branch);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Branch Details</title>
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
    tr:hover {
        background-color: #f5f5f5;
    }
    tr:hover a {
        color: #0ef; 
    }
    a {
        text-decoration: none;
        color: blue;
        transition: color 0.3s;
    }
    </style>
</head>
<body>

<h1>Details for Branch: <?php echo htmlspecialchars($branch); ?></h1>

<table>
  <thead>
    <tr>
      <th>S.No</th>
      <th>Year</th>
      <th>Sem</th>
      <th>More</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($result)) {
        $sno = 1;
        while ($row = $result->fetch_assoc()) {
    ?>
    <tr>
      <td><?php echo $sno++; ?></td>
      <td><?php echo htmlspecialchars($row['year']); ?></td>
      <td><?php echo htmlspecialchars($row['semister']); ?></td>
      <td><button><a href="details1.php?branch=<?php echo urlencode($branch); ?>&year=<?php echo urlencode($row['year']); ?>&sem=<?php echo urlencode($row['semister']); ?>">View More</a></button></td>
    </tr>
    <?php
        }
    }
    ?>
  </tbody>
</table>

</body>
</html>

<?php
// Close statement and connection
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
