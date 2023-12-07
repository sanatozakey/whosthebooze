<?php
include "connection.php";

$id = $_GET['id'];

$item_id = $id;

$rs = mysqli_query($conn, "SELECT * FROM items WHERE item_id = $id;");

if ($row = mysqli_fetch_array($rs)) {
    $product = $row["name"];
    $description = $row["description"];
    $price = $row["price"];
    $image = base64_encode($row["image_src"]);

    header("Location: cartEdit.php?item_id=$item_id&product=$product&description=$description&price=$price&image=$image");
    exit();
}
