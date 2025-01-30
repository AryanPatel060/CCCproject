<?php
include_once("lib/db.php");
$result = getdata('products',['*']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
      *{
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        background-color: #f9f9f9;
      }
      body{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100vw;
      }
      .table-container{
        background-color: #fff;
        margin: 50px;
      }
      table {
            border-collapse: collapse;
            margin: 0 auto;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #000;
            color: #fff;
            font-weight: bold;
 
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #eaeaea;
        }

        td {
            color: #333;
        }

    </style>
</head>
<body>
    <!-- <h3><?php echo $query; ?></h3> -->
    <div class="table-container">
        <h1>Products Table</h1>
        <table>
            <caption>All Products</caption>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["productid"]); ?></td>
                    <td><?php echo htmlspecialchars($row["productname"]); ?></td>
                    <td><?php echo htmlspecialchars($row["productdescription"]); ?></td>
                    <td><?php echo htmlspecialchars($row["price"]); ?></td>
                    <td><?php echo htmlspecialchars($row["quantity"]); ?></td>
                    <!-- <td><?php echo htmlspecialchars($row["categoryname"]); ?></td> -->
                    <td><a href="admin/product.php/?edit_productid=<?php echo $row["productid"] ?>">Edit</a>
                    <a href="/?productid=<?php echo $row["productid"] ?>">Delete</a></td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
