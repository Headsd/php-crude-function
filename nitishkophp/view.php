<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'nitish'; // Replace!

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$sql = "SELECT * FROM orders";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Additional styles specific to this page */
        .order-container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            padding: 25px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        
        .action-links a {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 5px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .action-links a:first-child {
            background-color: #f39c12;
            color: white;
        }
        
        .action-links a:last-child {
            background-color: #e74c3c;
            color: white;
        }
        
        .action-links a:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            text-decoration: none;
        }
        
        .navigation-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .navigation-links a {
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #2ecc71;
            color: white;
            border-radius: 6px;
            font-weight: 600;
        }
        
        .navigation-links a:hover {
            background-color: #27ae60;
            text-decoration: none;
        }
        
        table {
            margin-top: 20px;
        }
        
        th {
            background-color: #3498db;
            color: white;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="order-container">
        <h2>Order List</h2>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Vegetable Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Vegetable Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row["user_name"]); ?></td>
                                <td><?php echo htmlspecialchars($row["vegetable_name"]); ?></td>
                                <td><?php echo htmlspecialchars($row["vegetable_quantity"]); ?></td>
                                <td><?php echo number_format($row["vegetable_price"], 2); ?></td>
                                <td><?php echo number_format($row["vegetable_total"], 2); ?></td>
                                <td class="action-links">
                                    <a href="edit_order.php?id=<?php echo $row["id"]; ?>">Edit</a>
                                    <a href="delete_order.php?id=<?php echo $row["id"]; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-orders">No orders found.</p>
        <?php endif; ?>
        
        <div class="navigation-links">
            <a href="enter_order.php">Enter New Order</a>
            <a href="index.php">Home</a>
        </div>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>