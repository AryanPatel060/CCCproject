<?php
include_once('../lib/config.php');
// include_once('../lib/db.php');
$limit = 5;
$offset = 0;
$next = 0;
$totalpages = 0;
$totalnorow = getdata('products', ['count(productid) as rowcount'])[0]->rowcount;
// print_r($totalnorow[0]->rowcount);
if ($limit) {
    $totalpages = $totalnorow / $limit;
}
if ($limit && isset($_GET['offset'])) {
    $offset = $_GET['offset'];
    $next = $offset / $limit;
}
$result = getdata('products', ['*'], [], $limit, $offset, ['categoryname ', 'price DESC']);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f9f9f9;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100vw;
        }

        .table-container {
            background-color: #fff;
            margin: 50px;
        }

        table {
            border-collapse: collapse;
            margin: 0 auto;
        }

        th,
        td {
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
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($offset > 0): ?>
                    <li class="page-item"><a class="page-link" href="?offset=<?php echo ($offset - $limit) ?>">Previous</a></li>
                <?php endif ?>
                <?php for ($i = 1 + $next; $i <= 3 + $next; $i++): ?>
                    <?php if ($i <= $totalpages): ?>
                        <li class="page-item"><a class="page-link" href="?offset=<?php echo ($limit * ($i - 1)) ?>"><?php echo $i ?></a></li>
                    <?php endif ?>
                <?php endfor ?>
                <?php if ($offset < $totalpages): ?>
                    <li class="page-item"><a class="page-link" href="?offset=<?php echo ($offset + $limit) ?>">Next</a></li>
                <?php endif ?>
            </ul>
        </nav>
        <table>
            <caption>All Products</caption>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row->productid); ?></td>
                        <td><?php echo htmlspecialchars($row->productname); ?></td>
                        <td><?php echo htmlspecialchars($row->productdescription); ?></td>
                        <td><?php echo htmlspecialchars($row->price); ?></td>
                        <td><?php echo htmlspecialchars($row->quantity); ?></td>
                        <td><?php echo htmlspecialchars($row->categoryname); ?></td>
                        <td><a href="admin/product.php?edit_productid=<?php echo $row->productid ?>">Edit</a>
                            <a href="admin/product.php?delete_productid=<?php echo $row->productid ?>" onclick="return confirm('Deleting product: <?php echo $row->productname  ?>')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>