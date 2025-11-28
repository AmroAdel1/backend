<?php
    include "db.php";

    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        try {
            // Validate and sanitize inputs
            $name = mysqli_real_escape_string($conn, trim($_POST['name']));
            $quantity = intval($_POST['quantity']);
            $price = floatval($_POST['price']);
            $desc = mysqli_real_escape_string($conn, trim($_POST['desc']));
            
            // Validate required fields
            if (empty($name) || empty($desc)) {
                throw new Exception("All fields are required");
            }
            
            if ($quantity < 0) {
                throw new Exception("Quantity cannot be negative");
            }
            
            if ($price < 0) {
                throw new Exception("Price cannot be negative");
            }
            
            // Use prepared statement
            $stmt = $conn->prepare("INSERT INTO products (name, quantity, price, description) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sids", $name, $quantity, $price, $desc);
            
            if ($stmt->execute()) {
                $success = "Product added successfully!";
                // Clear form on success if you want
                $_POST = array();
            } else {
                throw new Exception("Error adding product: " . $conn->error);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
        }
        
        h2 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 25px;
            text-align: center;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #34495e;
        }
        
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        
        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        button[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s;
        }
        
        button[type="submit"]:hover {
            background-color: #2980b9;
        }
        
        .required-field::after {
            content: " *";
            color: #e74c3c;
        }
        
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #3498db;
            text-decoration: none;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Product</h2>
        
        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="message success">
                <?php echo $success; ?>
                <a href="index.php" class="back-link">View all products</a>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="name" class="required-field">Name</label>
                <input type="text" id="name" name="name" required 
                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                       placeholder="Enter product name">
            </div>
            
            <div class="form-group">
                <label for="quantity" class="required-field">Quantity</label>
                <input type="number" id="quantity" name="quantity" min="0" required 
                       value="<?php echo isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : ''; ?>" 
                       placeholder="Enter quantity">
            </div>
            
            <div class="form-group">
                <label for="price" class="required-field">Price</label>
                <input type="number" id="price" name="price" min="0" step="0.01" required 
                       value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" 
                       placeholder="Enter price">
            </div>
            
            <div class="form-group">
                <label for="desc" class="required-field">Description</label>
                <textarea id="desc" name="desc" required 
                          placeholder="Enter product description"><?php echo isset($_POST['desc']) ? htmlspecialchars($_POST['desc']) : ''; ?></textarea>
            </div>
            
            <button type="submit">Add Product</button>
        </form>
        
        <a href="index.php" class="back-link">← Back to all products</a>
    </div>
</body>
</html>