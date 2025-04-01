<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'nitish'; 

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$error_message = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $vegetable_name = mysqli_real_escape_string($conn, $_POST["vegetable_name"]);
        $vegetable_quantity = floatval($_POST["vegetable_quantity"]);
        $vegetable_price = floatval($_POST["vegetable_price"]);
        $user_name = mysqli_real_escape_string($conn, $_POST["user_name"]);

        $vegetable_total = $vegetable_quantity * $vegetable_price;

        $sql = "UPDATE orders SET 
                vegetable_name='$vegetable_name', 
                vegetable_quantity=$vegetable_quantity, 
                vegetable_price=$vegetable_price, 
                vegetable_total=$vegetable_total, 
                user_name='$user_name' 
                WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            header("Location: view.php");
            exit();
        } else {
            $error_message = "Error updating record: " . mysqli_error($conn);
        }
    }

    $sql = "SELECT * FROM orders WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);  //mysqli_fetch_assoc($result) converts the row into an associative array (key-value pairs).
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Order</title>
            <link rel="stylesheet" href="style.css">
            <style>
                .edit-form-container {
                    max-width: 600px;
                    margin: 30px auto;
                    padding: 30px;
                    background-color: #ffffff;
                    border-radius: 12px;
                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
                }
                
                .form-group {
                    margin-bottom: 20px;
                }
                
                .form-group label {
                    display: block;
                    margin-bottom: 8px;
                    font-weight: 600;
                    color: #2c3e50;
                }
                
                .form-group input {
                    width: 100%;
                    padding: 12px;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    font-size: 16px;
                    transition: border-color 0.3s;
                }
                
                .form-group input:focus {
                    border-color: #3498db;
                    outline: none;
                }
                
                .form-title {
                    color: #2c3e50;
                    text-align: center;
                    margin-bottom: 25px;
                    font-size: 24px;
                }
                
                .btn-submit {
                    background-color: #f39c12;
                    color: white;
                    border: none;
                    padding: 12px 20px;
                    font-size: 16px;
                    border-radius: 6px;
                    cursor: pointer;
                    width: 100%;
                    font-weight: 600;
                    transition: background-color 0.3s;
                }
                
                .btn-submit:hover {
                    background-color: #e67e22;
                }
                
                .error-message {
                    padding: 15px;
                    margin-bottom: 20px;
                    border-radius: 6px;
                    text-align: center;
                    background-color: #f8d7da;
                    color: #721c24;
                }
                
                .action-links {
                    text-align: center;
                    margin-top: 20px;
                }
                
                .action-links a {
                    display: inline-block;
                    margin: 0 10px;
                    color: #3498db;
                    font-weight: 600;
                    text-decoration: none;
                }
                
                .action-links a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class="edit-form-container">
                <h2 class="form-title">Edit Order</h2>
                
                <?php if (!empty($error_message)): ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="form-group">
                        <label for="user_name">User Name:</label>
                        <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($row['user_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="vegetable_name">Vegetable Name:</label>
                        <input type="text" id="vegetable_name" name="vegetable_name" value="<?php echo htmlspecialchars($row['vegetable_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="vegetable_quantity">Quantity (kg):</label>
                        <input type="number" id="vegetable_quantity" name="vegetable_quantity" min="0" step="0.01" value="<?php echo htmlspecialchars($row['vegetable_quantity']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="vegetable_price">Price per kg (NPR):</label>
                        <input type="number" id="vegetable_price" name="vegetable_price" min="0" step="0.01" value="<?php echo htmlspecialchars($row['vegetable_price']); ?>" required>
                    </div>
                    
                    <button type="submit" class="btn-submit">Update Order</button>
                </form>
                
                <div class="action-links">
                    <a href="view_orders.php">View Orders</a>
                    <a href="index.php">Home</a>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<div class='error-message'>Order not found.</div>";
    }
} else {
    echo "<div class='error-message'>No order ID specified.</div>";
}

mysqli_close($conn);
?>