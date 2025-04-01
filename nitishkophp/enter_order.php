<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'nitish'; 

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vegetable_name = mysqli_real_escape_string($conn, $_POST["vegetable_name"]);
    $vegetable_quantity = floatval($_POST["vegetable_quantity"]);
    $vegetable_price = floatval($_POST["vegetable_price"]);
    $user_name = mysqli_real_escape_string($conn, $_POST["user_name"]);

    $vegetable_total = $vegetable_quantity * $vegetable_price;

    $sql = "INSERT INTO orders (vegetable_name, vegetable_quantity, vegetable_price, vegetable_total, user_name) 
            VALUES ('$vegetable_name', $vegetable_quantity, $vegetable_price, $vegetable_total, '$user_name')";

    if (mysqli_query($conn, $sql)) {
        $success_message = "Order saved successfully!";
        // Clear form fields after successful submission
        $_POST = array();
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produce Order Form</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Additional styles specific to this form */
        .order-form-container {
            width: 600px;
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
            background-color: #2ecc71;
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
            background-color: #27ae60;
        }
        
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            text-align: center;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .home-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #3498db;
            font-weight: 600;
        }
        
        .home-link:hover {
            text-decoration: underline;
        }
        
        .section-title {
            color: #2c3e50;
            margin: 20px 0 15px;
            font-size: 18px;
        }
        
    </style>
</head>
<body>
    <div class="order-form-container">
        <h2 class="form-title">Place Your Produce Order</h2>
        
        <?php if (!empty($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="user_name">Your Name:</label>
                <input type="text" id="user_name" name="user_name" value="<?php echo isset($_POST['user_name']) ? htmlspecialchars($_POST['user_name']) : ''; ?>" required>
            </div>
            
            <h3 class="section-title">Vegetable Details</h3>
            
            <div class="form-group">
                <label for="vegetable_name">Vegetable Name:</label>
                <input type="text" id="vegetable_name" name="vegetable_name" value="<?php echo isset($_POST['vegetable_name']) ? htmlspecialchars($_POST['vegetable_name']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="vegetable_quantity">Quantity (kg):</label>
                <input type="number" id="vegetable_quantity" name="vegetable_quantity" min="0" step="0.01" value="<?php echo isset($_POST['vegetable_quantity']) ? htmlspecialchars($_POST['vegetable_quantity']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="vegetable_price">Price per kg (NPR):</label>
                <input type="number" id="vegetable_price" name="vegetable_price" min="0" step="0.01" value="<?php echo isset($_POST['vegetable_price']) ? htmlspecialchars($_POST['vegetable_price']) : ''; ?>" required>
            </div>
            
            <button type="submit" class="btn-submit">Place Order</button>
        </form>
        
        <a href="index.php" class="home-link">Back to Home</a>
    </div>
</body>
</html>