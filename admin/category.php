<?php
include_once('../lib/db.php');
$conn = connect();

$message = '';
$editresult = [];
$updating=true;
$categoryid = isset($_GET['categoryid']) ? (int) $_GET['categoryid'] : null;

if ($categoryid) {
    if (isset($_GET['delete'])) {
        $result = deletedata('categories', ['categoryid' => $categoryid]);
        $message = $result ? 'Category Deleted Successfully!' : 'Failed to Delete Category.';
        $updating = false;
    } elseif (isset($_GET['edit'])) {
        $updating = true;
        $editresult = getdata('categories', ['*'], ['categoryid' => $categoryid]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['categories'])) {
    $categories = $_POST['categories'];
    $catagoryname = $categories['categoryname'];
    $checkResult = getdata('categories', ['*'], ['categoryname' => $catagoryname]);

    if ($checkResult && (!isset($_GET['edit']) || $checkResult[0]['categoryid'] != $categoryid)) {
        $message = "Category already exists!";
    } else {
        if (isset($_GET['edit']) && $categoryid) {
            $result = editdata('categories', $categories, ['categoryid' => $categoryid]);
            $message = $result ? 'Category Updated Successfully!' : 'Failed to Update Category.';
            $updating = false;

        } else {
            $result = insertdata('categories', $categories);
            $message = $result ? 'Category Inserted Successfully!' : 'Failed to Insert Category.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Form and List</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: space-evenly;
            align-items: flex-start;
            height: 100vh;
        }

        .form-container, .category-list-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 40%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #000;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"] {
            /* width: 100%; */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;

            /* width: 100%; */
        }

        input[type="submit"]:hover {
            background-color: #333;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .category-list-container {
            height: 80vh;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        /* tr:nth-child(even) {
            background-color: #f2f2f2;
        } */

        tr:hover {
            background-color: #eaeaea;
        }

        td {
            color: #333;
        }

        .category-list-container h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #000;
        }
        .msg{
            padding: 20;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        a{
            text-decoration: none;
            color: #000;
            border: 1px solid gray;
            padding: 4px;
        }

    </style>
</head>
<body>

    <div class="form-container">
        <h2>Enter Category</h2>

        <form id="categoryForm" action="" method="POST">
            <label for="categoryname">Category Name:</label>
            <!-- <input type="hidden" id="categoryid" name = "categories[categoryid]"> -->
             
            <input type="text" id="categoryname" name="categories[categoryname]" value="<?php echo ($editresult && $updating)? $editresult[0]['categoryname']:"";?>" required>
            <input type="submit"id="submitbtn" value=" <?php echo $updating && isset($_GET['categoryid'])  ? 'Update Category' : 'Add Category'; ?>">

            <div class="error" id="error"></div>
        </form>

        <div class="message">
            <?php if (isset($message)):?>
                <h3 class="msg"><?php echo $message?></h3>
            <?php endif ?>
        </div>
    </div>

    <div class="category-list-container">
        <h3>Existing Categories</h3>
        <table>
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $result = getdata('categories',["*"])?>
                <?php if ($result):?>
                    <?php foreach ($result as $row): ?>
                        <tr>
                        <td><?php echo $row["categoryid"] ?></td>
                        <td><?php echo $row["categoryname"]?></td>
                        <td>
                            <a href="?edit=true&categoryid=<?php echo $row["categoryid"] ?>">Edit</a>
                            <a href="?delete=true&categoryid=<?php echo $row["categoryid"] ?>" onclick="return confirm('Deleting product: <?php echo $row['categoryname']?>')">Delete</a>
                        </td>
                        </tr>
                    <?php endforeach?>
                <?php else: ?>
                    <tr><td colspan='2'>No categories found.</td></tr>
                <?php endif ?>

            </tbody>
        </table>
    </div>
    <script>
        const categoryInput = document.getElementById('categoryname');
        const submitBtn = document.getElementById('submitbtn');
        const errorDiv = document.getElementById('error');

        // Function to validate input
        function validateInput() {
            const value = categoryInput.value.trim(); 
            // words with a space between them, each word containing only letters.
            if (value === '') {
                errorDiv.textContent = 'Category name cannot be empty or just spaces.';
                submitBtn.disabled = true; 
            } else if (!/^[a-zA-Z]+( [a-zA-Z]+)?$/.test(value)) {
                errorDiv.textContent = 'Category name can only contain letters, and at most one space between two words.';
                submitBtn.disabled = true; 
            } else {
                errorDiv.textContent = ''; 
                submitBtn.disabled = false; 
            }
        }
        

        categoryInput.addEventListener('input', validateInput);

        const form = document.getElementById('categoryForm');


    </script>
</body>
</html>
