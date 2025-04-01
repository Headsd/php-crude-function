<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'nitish'; // Replace!

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);//$_GET['id']: Retrieves the value of the id parameter from the URL //intval(): Converts the retrieved value to an integer
    $sql = "DELETE FROM orders WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: view.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>