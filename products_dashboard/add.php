<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $name = $_POST['name'];
  $quantity = $_POST['quantity'];
  $price = $_POST['price'];
  $desc = $_POST['desc'];

  $sql = "INSERT INTO products(name,quantity,price,description) VALUES ('$name', '$quantity' ,'$price', '$desc')";
  $result = mysqli_query($conn, $sql);

  echo '<div class="success-message">Product added successfully! <a href="index.php" class="back-link">Go back to products</a></div>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .product-form {
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            color: #2c3e50;
            margin-bottom: 25px;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: -15px;
        }
        
        input {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
            transition: border 0.3s;
        }
        
        input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }
        
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: 600;
            margin-top: 10px;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        .success-message {
            max-width: 600px;
            margin: 20px auto;
            padding: 15px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            text-align: center;
        }
        
        .back-link {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        textarea {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
            min-height: 100px;
            font-family: inherit;
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="product-form">
        <h2>Add Product</h2>
        <form method="post">
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required />
            </div>
            
            <div>
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" required />
            </div>
            
            <div>
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" step="0.01" required />
            </div>
            
            <div>
                <label for="desc">Description:</label>
                <textarea name="desc" id="desc" required></textarea>
            </div>
            
            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html> 