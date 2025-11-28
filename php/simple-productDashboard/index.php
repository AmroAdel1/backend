<?php
    include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        h2 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 20px;
        }
        
        .add-btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }
        
        .add-btn:hover {
            background-color: #218838;
        }
        
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .product-table th {
            background-color: #343a40;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        .product-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        .product-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .product-table tr:hover {
            background-color: #e9ecef;
        }
        
        .action-link {
            color: #007bff;
            text-decoration: none;
            margin: 0 5px;
            transition: color 0.3s;
        }
        
        .action-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        
        .delete-link {
            color: #dc3545;
        }
        
        .delete-link:hover {
            color: #bd2130;
        }
        
        .price {
            font-weight: bold;
            color: #28a745;
        }
        
        .quantity {
            font-weight: bold;
        }
        
        .low-stock {
            color: #ffc107;
        }
        
        .out-of-stock {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>All Products</h2>
        <a href="add.php" class="add-btn">Add New Product</a>
        
        <table class="product-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM products ORDER BY name ASC";
                $result = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $quantityClass = '';
                        if($row['quantity'] == 0) {
                            $quantityClass = 'out-of-stock';
                        } elseif($row['quantity'] < 5) {
                            $quantityClass = 'low-stock';
                        }
                        
                        echo "
                            <tr>
                                <td>{$row['name']}</td>
                                <td class='quantity {$quantityClass}'>{$row['quantity']}</td>
                                <td class='price'>$".number_format($row['price'], 2)."</td>
                                <td>".substr($row['description'], 0, 50).(strlen($row['description']) > 50 ? '...' : '')."</td>
                                <td>
                                    <a href='edit.php?id={$row['id']}' class='action-link'>Edit</a>
                                    <a href='delete.php?id={$row['id']}' class='action-link delete-link' 
                                       onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>
                                </td>
                            </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center;'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>