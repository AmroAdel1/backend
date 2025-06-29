<?php 
include "db.php";

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .edit-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 25px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        
        .edit-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #2c3e50;
        }
        
        input, textarea {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        input:focus, textarea:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .submit-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: 600;
            margin-top: 10px;
        }
        
        .submit-btn:hover {
            background-color: #2980b9;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Product</h2>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $desc = $_POST['desc'];

            $sql = "UPDATE products SET name='$name', price='$price', quantity='$quantity', description='$desc' WHERE id=$id";
            
            mysqli_query($conn, $sql);
            echo '<div class="success-message">Product updated! <a href="index.php" class="back-link">Go back</a></div>';
            
            // Refresh product data
            $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
            $product = mysqli_fetch_assoc($result);
        }
        ?>
        
        <form class="edit-form" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?= $product['name'] ?>">
            </div>
            
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" value="<?= $product['quantity'] ?>">
            </div>
            
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" value="<?= $product['price'] ?>">
            </div>
            
            <div class="form-group">
                <label for="desc">Description:</label>
                <textarea name="desc"><?= $product['description'] ?></textarea>
            </div>
            
            <button type="submit" class="submit-btn">Update Product</button>
        </form>
    </div>
</body>
</html>