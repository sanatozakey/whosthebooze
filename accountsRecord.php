<?php
include "connection.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["insert"])) {
        $username = isset($_POST['new_username']) ? $_POST['new_username'] : '';
        $password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
        $email = isset($_POST['new_email']) ? $_POST['new_email'] : '';

        mysqli_query($conn, "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')");
        echo "<script>window.location.href=window.location.href;</script>";
    }
    if (isset($_POST["delete"])) {
        $usernameToDelete = isset($_POST['username']) ? $_POST['username'] : '';
        mysqli_query($conn, "DELETE FROM users WHERE username='$usernameToDelete'") or die(mysqli_error($conn));
        echo "<script>window.location.href=window.location.href;</script>";
    }

    if (isset($_POST["update"])) {
        $newUsername = isset($_POST['new_username']) ? $_POST['new_username'] : '';
        $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
        $newEmail = isset($_POST['new_email']) ? $_POST['new_email'] : '';
        $usernameToUpdate = isset($_POST['username']) ? $_POST['username'] : '';

        $updateQuery = "UPDATE users SET ";
        if (!empty($newUsername)) {
            $updateQuery .= "username='$newUsername', ";
        }
        if (!empty($newPassword)) {
            $updateQuery .= "password='$newPassword', ";
        }
        if (!empty($newEmail)) {
            $updateQuery .= "email='$newEmail', ";
        }
        $updateQuery = rtrim($updateQuery, ", "); // Remove trailing comma

        $updateQuery .= " WHERE username='$usernameToUpdate'";

        mysqli_query($conn, $updateQuery) or die(mysqli_error($conn));
        echo "<script>window.location.href=window.location.href;</script>";
    }
}
?>

<html lang="en">

<head>
    <title>Account Records</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="assets/css/cart.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">
        <h2>Account Records</h2>

        <div class="row justify-content-end mb-3">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $rs = mysqli_query($conn, "SELECT * FROM users;");

                    while ($row = mysqli_fetch_array($rs)) {
                        echo "<tr>";
                        echo "<td>{$row['user_id']}</td>";
                        echo "<td>{$row['username']}</td>";
                        echo "<td>{$row['password']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>
                            <!-- Delete Form -->
                            <form method='post'>
                                <input type='hidden' name='username' value='{$row['username']}'>
                                <button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                            <!-- Update Form -->
                            <form method='post'>
                                <input type='hidden' name='username' value='{$row['username']}'>
                                <input type='text' name='new_username' placeholder='New Username'>
                                <input type='text' name='new_password' placeholder='New Password'>
                                <input type='text' name='new_email' placeholder='New Email'>
                                <button type='submit' name='update' class='btn btn-primary btn-sm'>Update</button>
                            </form>
                          </td>";
                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>

            <div class="back-to-shop"><a href="index.php">&leftarrow;</a><span class="text-muted">Exit</span></div>
        </div>

        <!-- Insert Modal -->
        <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel">Insert User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <input type="text" name="new_username" placeholder="New Username">
                            <input type="text" name="new_password" placeholder="New Password">
                            <input type="text" name="new_email" placeholder="New Email">
                            <button type="submit" name="insert" class="btn btn-success">Add User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>