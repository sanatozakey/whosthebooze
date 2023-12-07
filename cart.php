<?php
include "connection.php";
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
                            <h4><b>Buy Booze</b></h4>
                        </div>
                        <div class="col align-self-center text-right text-muted"><span class="totalItems">0</span> item(s) | <a href="cartEdit.php">Edit Item List</a></div>
                    </div>
                </div>

                <div style="overflow-y: scroll; max-height: 250px;">
                    <?php
                    $rs = mysqli_query($conn, "SELECT * FROM items;");

                    while ($row = mysqli_fetch_array($rs)) {
                        echo '<div class="row border-top border-bottom item" data-price="' . $row['price'] . '">';
                        echo '<div class="row main align-items-center">';
                        echo '<div class="col-2"><img class="img-fluid" src="data:image;base64,' . base64_encode($row['img_src']) . '"></div>';
                        echo '<div class="col">';
                        echo '<div class="row text-muted">' . $row['name'] . '</div>';
                        echo '<div class="row">' . $row['description'] . '</div>';
                        echo '</div>';
                        echo '<div class="col">';
                        echo '<div class="quantity">';
                        echo '<button class="minus">-</button>';
                        echo '<input type="number" class="itemCounter" value="0" min="0">';
                        echo '<button class="plus">+</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="col"> ₱' . $row['price'] . ' <span class="close">&#10005;</span></div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <a href="index.php" class="back-to-shop btn btn-secondary">&leftarrow; Back to Booze</a>
            </div>

            <div class="col-md-4 summary">
                <div>
                    <h5><b>Summary</b></h5>
                </div>
                <hr>
                <div class="row">
                    <div class="col" style="padding-left:0;">ITEM(S) <span class="totalItems">0</span></div>
                </div>
                <form>
                    <p>SHIPPING</p>
                    <select>
                        <option class="text-muted">Standard-Delivery- ₱200.00</option>
                    </select>
                    <p>Payment</p>
                    <select>
                        <option class="text-muted">COD (Cash On Delivery)</option>
                        <option class="text-muted">Gcash (Payment First)</option>
                    </select>
                    <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                        <div class="col">TOTAL PRICE</div>
                        <div class="col text-right">₱<span class="totalPriceValue">00.00</span></div>
                    </div>
                    <button type="button" id="checkoutButton" class="btn btn-primary">CHECKOUT</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="receiptModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">The Booze Boutique - Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="receiptContent">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $(".plus").click(function () {
                var input = $(this).parent().find(".itemCounter");
                var currentVal = parseInt(input.val(), 10);
                input.val(currentVal + 1);
                updateTotal();
            });

            $(".minus").click(function () {
                var input = $(this).parent().find(".itemCounter");
                var currentVal = parseInt(input.val(), 10);
                if (!isNaN(currentVal) && currentVal > 0) {
                    input.val(currentVal - 1);
                    updateTotal();
                }
            });

            $(".itemCounter").change(function () {
                var currentVal = parseInt($(this).val(), 10);
                if (isNaN(currentVal) || currentVal < 0) {
                    $(this).val(0);
                }
                updateTotal();
            });

            $("#checkoutButton").click(function () {
                showReceipt();
            });

            function updateTotal() {
                var totalItems = 0;
                var totalPrice = 0;

                $(".item").each(function () {
                    var quantity = parseInt($(this).find(".itemCounter").val(), 10);
                    var price = parseFloat($(this).data("price"));
                    totalItems += quantity;
                    totalPrice += quantity * price;
                });

                $(".totalItems").text(totalItems);
                $(".totalPriceValue").text(totalPrice.toFixed(2));
            }

            function showReceipt() {
                var receiptContent = "<p>Date: " + getCurrentDate() + "</p>";
                receiptContent += "<p>Time: " + getCurrentTime() + "</p>";
                receiptContent += "<h6>Products Ordered:</h6>";

                $(".item").each(function () {
                    var itemName = $(this).find(".row.text-muted").text();
                    var quantity = parseInt($(this).find(".itemCounter").val(), 10);
                    var price = parseFloat($(this).data("price"));

                    receiptContent += "<p>" + itemName + " - Quantity: " + quantity + " - Price: ₱" + (quantity * price).toFixed(2) + "</p>";
                });

                receiptContent += "<h6>Total Price: ₱" + $(".totalPriceValue").text() + "</h6>";

                $("#receiptContent").html(receiptContent);
                $("#receiptModal").modal("show");
            }

            function getCurrentDate() {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0');
                var yyyy = today.getFullYear();
                return mm + '/' + dd + '/' + yyyy;
            }

            function getCurrentTime() {
                var now = new Date();
                var hours = now.getHours();
                var minutes = now.getMinutes();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                var strTime = hours + ':' + minutes + ' ' + ampm;
                return strTime;
            }
        });
    </script>

</body>

</html>
