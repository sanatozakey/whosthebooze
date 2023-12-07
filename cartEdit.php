<?php
include "connection.php";

$rs = mysqli_query($conn, "SELECT * FROM items;");

$rowCount = mysqli_num_rows($rs);

$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : '';
$product = isset($_GET['product']) ? $_GET['product'] : '';
$description = isset($_GET['description']) ? $_GET['description'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$image = isset($_GET['image']) ? $_GET['image'] : '';

?>

<html>

<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="assets/css/cart.css" rel="stylesheet">

    <style>
        .quantity {
            display: flex;
            align-items: center;
        }

        .plus,
        .minus {
            font-size: 1.2em;
            cursor: pointer;
        }

        .back-to-shop {
            background-color: #B0926A;
            color: #fff;
            border-color: #B0926A;
        }

        .back-to-shop:hover {
            background-color: #654321;
            border-color: #654321;
        }

        #checkoutButton {
            background-color: #B0926A;
            border-color: #B0926A;
        }

        #checkoutButton:hover {
            background-color: #654321;
            border-color: #654321;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="row">
            <div class="col-md-8 cart" style="backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                <div class="title">
                    <div class="row">
                        <div class="col">
                            <h4><b>Edit Booze</b></h4>
                        </div>
                        <div class="col align-self-center text-right text-muted"><?php echo $rowCount ?> item(s)</div>
                    </div>
                </div>

                <div style="overflow-y: scroll; max-height: 350px;">
                    <?php

                    while ($row = mysqli_fetch_array($rs)) {
                        echo '<div class="row border-top border-bottom">';
                        echo '<div class="row main align-items-center">';
                        echo '<div class="col-2"><img class = "img-fluid" src = "data:image;base64,' . base64_encode($row['img_src']) . '"></div>';
                        echo '<div class="col">';
                        echo '<div class="row text-muted">' . $row['name'] . '</div>';
                        echo '<div class="row">' . $row['description'] . '</div>';
                        echo '</div>';
                        echo '<div class="col"><center>';
                        echo '₱' . $row['price'] . '';
                        echo '</center></div>';
                    ?>
                        <a href="selectItem.php?id=<?php echo $row["item_id"]; ?>"><button type="button" class="btn btn-success" id="edit">Edit</button></a>
                        <a href="deleteItem.php?id=<?php echo $row["item_id"]; ?>"> <button type="button" class="btn btn-danger">Delete</button></a>
                    <?php
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <a href="cart.php" class="back-to-shop btn btn-secondary">&leftarrow; Back to Booze</a>
            </div>

            <div class="col-md-4 summary">
                <div>
                    <h5><b>Item Details</b></h5>
                </div>
                <br>
                <form class="border-top" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="product_name">Product name</label>
                        <input type="text" class="form-control form-control-sm form-control-md-1" id="product_name" name="product_name" placeholder="" value="<?php echo $product; ?>" style="margin-bottom: 1vh;">
                    </div>
                    <div class="form-group">
                        <label for="item_description">Description</label>
                        <input type="text" class="form-control form-control-sm" id="item_description" name="item_description" placeholder="" value="<?php echo $description; ?>" style="margin-bottom: 1vh;">
                    </div>
                    <div class="form-group">
                        <label for="item_price">Price</label>
                        <input type="text" class="form-control form-control-sm" id="item_price" name="item_price" value="<?php echo $price; ?>" style="margin-bottom: 1vh;">
                    </div>
                    <div class="form-group">
                        <label for="imageSrc">Product image</label>
                        <input type="file" class="form-control-file" id="imageSrc" name="imageSrc" value="<?php echo $image; ?>" required>
                    </div>
                    <hr>
                    <div>
                        <a href="cartEdit.php" style="padding: 0;"><button type="button" class="btn btn-secondary" id="reset">Reset</button></a>
                        <button type="submit" class="btn" id="update" name="update" style="background-color: #cda45e; color: #fff">Update</button>
                        <button type="submit" class="btn" id="add" name="add" style="background-color: #cda45e; color: #fff">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>

<?php
if (isset($_POST['update'])) {
    $tempFilePath = $_FILES["imageSrc"]["tmp_name"];

    $fileContent = file_get_contents($tempFilePath);

    unlink($tempFilePath);

    $escapedContent = mysqli_real_escape_string($conn, $fileContent);

    $rs = mysqli_query($conn, "UPDATE items SET name = '$_POST[product_name]', description = '$_POST[item_description]', price = '$_POST[item_price]', img_src = '$escapedContent'  WHERE item_id = $item_id");
}

if (isset($_POST['add'])) {
    $tempFilePath = $_FILES["imageSrc"]["tmp_name"];

    $fileContent = file_get_contents($tempFilePath);

    unlink($tempFilePath);

    $escapedContent = mysqli_real_escape_string($conn, $fileContent);

    $rs = mysqli_query($conn, "INSERT INTO items (`item_id`, `name`, `description`, `price`, `img_src`) VALUES (NULL, '$_POST[product_name]', '$_POST[item_description]', '$_POST[item_price]', '$escapedContent')");

    header("Location: cartEdit.php");
}
?>

</html>