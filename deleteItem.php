<?php  
    include "connection.php";
    $id = $_GET["id"];
    mysqli_query($conn, "DELETE FROM items WHERE item_id =  $id");
?>

<script type="text/javascript">
    window.location = "cartEdit.php";
</script>