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
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        
        .add-btn {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }
        
        .add-btn:hover {
            background-color: #2980b9;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .action-link {
            color: #3498db;
            text-decoration: none;
            margin: 0 5px;
            padding: 5px 10px;
            border-radius: 3px;
            transition: all 0.3s;
        }
        
        .action-link.edit {
            color: #27ae60;
        }
        
        .action-link.delete {
            color: #e74c3c;
        }
        
        .action-link:hover {
            text-decoration: none;
            background-color: #ecf0f1;
        }
        
        .divider {
            color: #bdc3c7;
        }
    </style>
</head>
<body>
    <h2>All Products</h2>
    <a href="add.php" class="add-btn">Add New Product</a>
    <table>        <!-- border="1" cellpadding="10" -->
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>

        <?php
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                echo "
                    <tr>
                        <td>{$row['name']}</td>
                        <td>{$row['quantity']}</td>
                        <td>\${$row['price']}</td>
                        <td>{$row['description']}</td>
                        <td>
                            <a href='edit.php?id={$row['id']}' class='action-link edit'>Edit</a>
                            <span class='divider'>|</span>
                            <a href='delete.php?id={$row['id']}' class='action-link delete'>Delete</a>
                        </td>
                    </tr>
                ";
            }
        ?>
    </table>
</body>
</html>

<!-- image, created_at timestamp, -->
<!-- <a href="edit.php?id={$row['id']}">EDIT</a> -->