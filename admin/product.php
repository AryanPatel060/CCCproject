<?php

// include_once('../lib/config.php');
include_once('../lib/db.php');

$producteditactive = false;
$message = "";
$error = "";




if (isset($_GET['edit_productid'])) {
    $producteditactive = true;
    $productid = $_GET['edit_productid'];
    $product = getdata('products', ['*'], ['productid' => $productid])[0];
    // echo "<pre>";
    // print_r($categories);
}
if (isset($_GET['delete_productid'])) {
    $productdeleteactive = true;
    $productid = $_GET['delete_productid'];
    // echo $productid;
    $deleteresult = deletedata('products', ['productid' => $productid]);
    if ($deleteresult) {
        $message = "Product Deleted Successfully!";
        $baseUrl = strtok($_SERVER["REQUEST_URI"], '?');
        header("Location: $baseUrl");
        exit();
    } else {
        $error = "Error While Deleting Product!";
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $productDetails = $_POST['product'];
    $productid = $productDetails['productid'];
    $productname = $productDetails['productname'];

    if ($productid) {
        $editresult = editdata('products', $productDetails, ['productid' => $productid]);
        $producteditactive = false;
    } else if ($productDetails) {
        $product = getdata('products', ['*'], ['productname' => $productname]);
        if ($product) {
            $error = "Product Already Exists.";
        } else {
            $result = insertdata('products', $productDetails);
            if ($result) {
                $message = "New Product Added Successfully!";
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$result = getdata('products', ['*']);
$categories = getdata('categories', ['*']);
?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Product Submission form</title>
    <style>
        /* Reset and global styles */
        body {
            font-family: 'Arial', sans-serif;
            /* Simple and clean font */
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            /* height: 100vh; */
        }

        /* Form container */
        .form-container {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px 50px;
            width: 100%;
            margin: 30px;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Input fields */
        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .form-container input[ type='text'],
        .form-container input[ type='number'],
        .form-container select,
        .form-container textarea {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 14px;
            color: #333;
        }

        .form-container textarea {
            resize: none;
            height: 100px;
        }

        /* Submit button */
        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #333;
        }

        /* Form alignment */
        .form-container .form-group {
            margin-bottom: 15px;
        }

        /* Footer text */
        .form-container .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            color: #777;
        }

        .disabled {
            background-color: gray;
        }

        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f9f9f9;
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

        .message {
            color: green;
            font-size: 14px;
            /* margin-bottom: 10px; */
            /* border: 1px solid gray; */
            padding: 8px;
            /* max-width: 300px; */
            display: flex;
            align-items: stretch;
            justify-content: center;
        }

        .msgerror {
            color: red;
            font-size: 14px;
            /* margin-bottom: 10px; */
            /* border: 1px solid gray; */
            padding: 8px;
            /* max-width: 300px; */
            display: flex;
            align-items: stretch;
            justify-content: center;

        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .messages {
            max-width: 300px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: baseline;
        }
    </style>
</head>

<body>
    <div class='form-container'>
        <h1>Product Submission</h1>

        <div class="error" id="error"></div>
        <form id="productForm" action="" method="POST">
            <input type="hidden" name="product[productid]" value="<?php echo ($producteditactive) ? $product['productid'] : ""; ?>">
            <div class='form-group'>
                <label for='productName'>Product Name</label>
                <input type='text' id='productName' name='product[productname]' value="<?php echo ($producteditactive) ? $product['productname'] : ""; ?>" placeholder='Enter product name' required>
                <div class="error" id="nameError"></div>
            </div>
            <div class='form-group'>
                <label for='productDescription'>Product Description</label>
                <textarea id='productDescription' name='product[productdescription]' placeholder='Enter product description'
                    required><?php echo ($producteditactive) ? $product['productdescription'] : ""; ?></textarea>
                <div class="error" id="descriptionError"></div>
            </div>
            <div class='form-group'>
                <label for='price'>Price ( $ )</label>
                <input type='number' id='price' value="<?php echo ($producteditactive) ? $product['price'] : ""; ?>" name='product[price]' placeholder='Enter product price' step='0.01'
                    required>
                <div class="error" id="priceError"></div>
            </div>
            <div class='form-group'>
                <label for='quantity'>Quantity</label>
                <input type='number' id='quantity' value="<?php echo ($producteditactive) ? $product['quantity'] : ""; ?>" name='product[quantity]' placeholder='Enter product quantity' required>
                <div class="error" id="quantityError"></div>
            </div>
            <div class='form-group'>
                <label for='category'>Category</label>
                <select id='category' name='product[categoryname]' required>
                    <option value='<?php echo ($producteditactive) ? $product['categoryname'] : ""; ?>'><?php echo ($producteditactive) ? $product['categoryname'] : "select category"; ?> </option>
                    <?php foreach ($categories as $category): ?>
                        <?php if ($category['categoryname'] != $product['categoryname']): ?>
                            <option value='<?php echo $category['categoryname']; ?>'><?php echo $category['categoryname']; ?>
                            </option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
                <div class="error" id="categoryError"></div>
            </div>
            <button type='submit' id="submitBtn" disabled><?php echo ($producteditactive) ? "Update" : "Submit"; ?></button>
        </form>
        <div class='footer-text'>
            <p>&copy; 2025 Product Management</p>
        </div>
    </div>


    <!-- <h3><?php echo $query; ?></h3> -->
    <div class="table-container">
        <div calss="messages">
            <?php if (isset($message)): ?>
                <h3 class="message"><?php echo $message ?></h3>
            <?php endif ?>
            <?php if (isset($error)): ?>
                <h3 class="msgerror"><?php echo $error ?></h3>
            <?php endif ?>
        </div>
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
                    <th>Category Name</th>

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
                        <td><?php echo htmlspecialchars($row["categoryname"]); ?></td>
                        <td><a href="?edit_productid=<?php echo $row["productid"] ?>">Edit</a>
                            <a href="?delete_productid=<?php echo $row["productid"] ?>" onclick="return confirm('Deleting product: <?php echo $row['productname']  ?>')">Delete</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <script>
        const form = document.getElementById('productForm');
        const productName = document.getElementById('productName');
        const productDescription = document.getElementById('productDescription');
        const price = document.getElementById('price');
        const quantity = document.getElementById('quantity');
        const category = document.getElementById('category');
        const submitBtn = document.getElementById('submitBtn');

        const nameError = document.getElementById('nameError');
        const descriptionError = document.getElementById('descriptionError');
        const priceError = document.getElementById('priceError');
        const quantityError = document.getElementById('quantityError');

        function validateForm() {
            let isValid = true;

            if (productName.value.trim() === '') {
                nameError.textContent = 'Product name cannot be empty or spaces only.';
                isValid = false;
            } else {
                nameError.textContent = '';
            }

            if (productDescription.value.trim() === '') {
                descriptionError.textContent = 'Product description cannot be empty.';
                isValid = false;
            } else {
                descriptionError.textContent = '';
            }

            if (price.value <= 0 || price.value === '') {
                priceError.textContent = 'Price must be a positive number.';
                isValid = false;
            } else {
                priceError.textContent = '';
            }

            if (quantity.value <= 0 || quantity.value === '') {
                quantityError.textContent = 'Quantity must be a positive number.';
                isValid = false;
            } else {
                quantityError.textContent = '';
            }

            submitBtn.disabled = !isValid;

        }

        document.getElementById('productForm').addEventListener('submit', function(event) {
            const value = categoryInput.value.trim();
            if (value === '' || !/^[a-zA-Z0-9-_]+$/.test(value)) {
                event.preventDefault();
                validateInput();
            }
        });


        productName.addEventListener('input', validateForm);
        productDescription.addEventListener('input', validateForm);
        price.addEventListener('input', validateForm);
        quantity.addEventListener('input', validateForm);

        // validateForm();
        if (!isValid) {
            submitBtn.className('disabled');
        } else {
            submitBtn.className('');
        }
    </script>
</body>

</html>