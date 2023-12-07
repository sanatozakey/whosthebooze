<?php
include "connection.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $rs = mysqli_query($conn, $query);

    if (mysqli_num_rows($rs) === 1) {
        $row = mysqli_fetch_assoc($rs);

        if($row['username'] === 'admin' && $row['password'] === 'admin'){
            header("Location: accountsRecord.php");
            exit();
        } else {
            echo "<script>";
            echo "window.alert('Successfully logged in');";
            echo "window.location.href = 'index.php';";
            echo "</script>";
        }
    } else {
        echo "<script>";
        echo "window.alert('Invalid account');";
        echo "window.location.href = 'index.php';";
        echo "</script>";
    }
}

if (isset($_POST['register'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $rUsername = validate($_POST['reg_Username']);
    $rPassword = validate($_POST['reg_Password']);
    $cPassword = validate($_POST['confirm_Password']);
    $rEmail = validate($_POST['reg_Email']);

    if ($rPassword == $cPassword) {
        $insertQuery = "INSERT INTO users (user_id, username, password, email) VALUES (NULL, '$rUsername', '$rPassword', '$rEmail')";

        $rs = mysqli_query($conn, $insertQuery);

        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>";
            echo "alert('successfully registered account')";
            echo "</script>";
        } else {
            header("Location: index.php");
            exit();
        }
    } else {
        echo "<script>";
        echo "alert('passwords do not match')";
        echo "</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title img src="">Who's the Booze</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="assets\header-logo.ico">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>


    <!-- ======= Top Bar ======= -->
    <div id="topbar" class="d-flex align-items-center fixed-top">
        <div class="container d-flex justify-content-center justify-content-md-between">

            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-phone d-flex align-items-center"><span>+63 9158890847</span></i>
                <i class="bi bi-clock d-flex align-items-center ms-4"><span> Mon-Sat: 8:00 AM - 8:00 PM</span></i>
            </div>

        </div>
    </div>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-cente">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">

            <h2 class="logo me-auto me-lg-0"><img src="assets\header-logo.png">Who's The Booze
            </h2>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <!-- .navbar -->
            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#about">About</a></li>
                    <li><a class="nav-link scrollto" href="#menu">Menu</a></li>
                    <li><a class="nav-link scrollto" href="#specials">Specials</a></li>
                    <li><a class="nav-link scrollto" href="#gallery">Gallery</a></li>
                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>

            <div class="d-flex align-items-end">
                <a href="#exampleModal" class="book-a-table-btn scrollto d-none d-lg-flex" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" data-dismiss="modal">Login</a>
                <a href="cart.php" class="book-a-table-btn scrollto d-none d-lg-flex">Buy Booze</a>
            </div>

        </div>
    </header><!-- End Header -->

    <!-- sign in modal -->
    <div class="specific">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="username" class="col-form-label">Username:</label>
                                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password:</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password"><br>
                                <div>
                                    <input type="checkbox" onclick="myFunction()"><label for="email">&nbsp;<b>Show Password</b></label><br><br>
                                    <div style="margin-top: 10px; margin-bottom: 10px">Don't have an account? <a href="#eresgister_modal" data-toggle="modal" data-target="#resgister_modal" data-whatever="@mdo" data-dismiss="modal">Register here</a></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="sign_in">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- register modal -->
    <div class="specific">
        <div class="modal fade" id="resgister_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Register an account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="reg_Username" class="col-form-label">Username:</label>
                                <input type="text" class="form-control" id="reg_Username" placeholder="Enter username" name="reg_Username" required>
                            </div>
                            <div class="form-group">
                                <label for="reg_Password" class="col-form-label">Password:</label>
                                <input type="password" class="form-control" id="reg_Password" placeholder="Enter password" name="reg_Password">
                            </div>
                            <div class="form-group">
                                <label for="confirm_Password" class="col-form-label">Confirm password:</label>
                                <input type="password" class="form-control" id="confirm_Password" placeholder="Confirm password" name="confirm_Password" required>
                            </div>
                            <div class="form-group">
                                <label for="reg_Email" class="col-form-label">Email:</label>
                                <input type="text" class="form-control" id="reg_Email" placeholder="Enter email" name="reg_Email" required>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="register">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container position-relative text-center text-lg-start" data-aos="zoom-in" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-8">
                    <h1>Welcome to <span>Who's the Booze</span></h1>
                    <h3>Buy your booze to be the boss</h3>

                    <div class="btns">
                        <a href="#menu" class="btn-menu animated fadeInUp scrollto">Our Alcoholic Beverages</a>
                        <a href="cart.php" class="btn-book animated fadeInUp scrollto">Order Booze</a>
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-center justify-content-center position-relative" data-aos="zoom-in" data-aos-delay="200">
                    <a href="assets\video\teaser.mp4" class="glightbox play-btn"></a>
                </div>

            </div>
        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="row">
                    <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="100">
                        <div class="about-img">
                            <img src="assets/img/about.jpg" alt="">
                        </div>

                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
                        <div class="section-title">
                            <p>About Us</p>
                        </div>
                        <h3>"Welcome to our magnificient RestoBar Who's the Booze dedicated to the world of alcohol! Explore the
                            rich heritage, diverse flavors, and cultural significance of beverages that have been cherished for
                            centuries. From fine wines to craft beers, artisanal spirits to unique cocktails, embark on a journey that
                            celebrates the craftsmanship and artistry behind these delightful libations. Join us as we raise a glass
                            to the traditions and innovations that make the world of alcohol so fascinating and enjoyable."</h3>
                        <br>

                        <p class="fst-italic">
                            "Wine is sunlight, held together by water."
                            <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            - Galileo Galilei
                        </p>
                        <ul>
                            <li><i class="bi bi-check-circle"></i> Red Elegance: Embark on a journey of sophistication with our
                                collection of rich, velvety red wines</li>
                            <li><i class="bi bi-check-circle"></i> Signature Pride Potion: Indulge in our prideful concoctions, where
                                creativity meets craftsmanship. </li>
                            <li><i class="bi bi-check-circle"></i> Brewed Boldness: Raise your glass to the pride of boldness found in
                                every sip of our craft beers. </li>
                        </ul>
                        <p>
                            "In every glass, we capture the essence of celebration. Join us in raising a toast to the blend of flavors
                            that make life truly remarkable."
                        </p>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <!-- ======= Why Us Section ======= -->
        <section id="why-us" class="why-us">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Why Us</h2>
                    <p>Why Choose Our RestoBar</p>
                </div>

                <div class="row">

                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="box" data-aos="zoom-in" data-aos-delay="100">
                            <span>01</span>
                            <h4>Unique Selection</h4>
                            <p>RestoBar that offer a diverse and unique selection of alcoholic beverages, such as craft beers,
                                artisanal cocktails, or rare wines, can attract customers looking for something beyond the usual
                                options. Having a well-curated drink menu can be a strong draw for those seeking new and interesting
                                flavors or experiences.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="box" data-aos="zoom-in" data-aos-delay="200">
                            <span>02</span>
                            <h4>Exclusive or Rare Beverage Offerings</h4>
                            <p>Certain RestoBar acquire a reputation for offering exclusive or rare alcoholic beverages that are not
                                commonly found elsewhere. This could include limited-edition spirits, aged wines, or unique craft beers.
                                People may visit these establishments specifically to indulge in these rare finds or to expand their
                                palate with something distinct and exceptional.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="box" data-aos="zoom-in" data-aos-delay="300">
                            <span>03</span>
                            <h4> Atmosphere and Social Experience</h4>
                            <p> Some RestoBar are known for their vibrant bar scenes or cozy, relaxed environments that encourage
                                patrons to unwind and socialize over drinks. The ambiance created by the type of alcohol served, be it
                                signature cocktails, fine spirits, or local brews, can heavily influence the overall atmosphere and
                                attract customers looking for a particular vibe or social experience.</p>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Why Us Section -->

        <!-- ======= Menu Section ======= -->
        <section id="menu" class="menu section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Menu</h2>
                    <p>Check Our Alcoholic Beverages </p>
                </div>

                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="menu-flters">
                            <li data-filter="*" class="filter-active">All</li>
                            <li data-filter=".filter-bottled">Bottled</li>
                            <li data-filter=".filter-thincan">Thincan</li>
                        </ul>
                    </div>
                </div>

                <div class="row menu-container" data-aos="fade-up" data-aos-delay="200">

                    <div class="col-lg-6 menu-item filter-thincan">
                        <a href="assets/img/menu/tcan1.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/tcan1.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Kiss of Whine Crisp</a><span>$5.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Kiss of Wine Crisp Sauvignon Blanc, 187ml can 12
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-bottled">
                        <a href="assets/img/menu/bt2.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/bt2.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Josh Cellars Cabernet Sauvignon</a><span>$6.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Josh Cellars Cabernet Sauvignon, California Red Wine, 750 mL Bottle.
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-thincan">
                        <a href="assets/img/menu/tcan3.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/tcan3.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Kiss of Whine Intense</a><span>$7.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Kiss of Wine Intense Sauvignon Blanc, 187ml can 12
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-bottled">
                        <a href="assets/img/menu/bt4.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/bt4.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Heineken Original</a><span>$8.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Heineken Original, 330 mL Bottle
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-thincan">
                        <a href="assets/img/menu/tcan5.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/tcan5.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Kiss of Whine Feisty</a><span>$9.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Kiss of Wine Feisty Sauvignon Blanc 187ml can 12
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-bottled">
                        <a href="assets/img/menu/bt6.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/bt6.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Beirao Licor</a><span>$4.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Beirao Licor, 750 mL Bottle
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-thincan">
                        <a href="assets/img/menu/tcan7.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/tcan7.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Kiss of Whine Wild</a><span>$9.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Kiss of Wine Wild Sauvignon Blanc 187ml can 12
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-bottled">
                        <a href="assets/img/menu/bt8.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/bt8.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Bombay Sapphire Gin</a><span>$9.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Bombay Sapphire Gin, 750 ml bottle
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-thincan">
                        <a href="assets/img/menu/tcan9.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/tcan9.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Kiss of Whine Picante</a><span>$12.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Kiss of Wine Picante Sauvignon Blanc 187ml 12oz can
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-bottled">
                        <a href="assets/img/menu/bt10.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/bt10.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Very Old Captain Rum</a><span>$9.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Very Old Captain Rum, 740 mL bottle
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-thincan">
                        <a href="assets/img/menu/tcan11.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/tcan11.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Premium Potato Vodka</a><span>$12.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Premium Potato Vodka 355ml 12oz can
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-bottled">
                        <a href="assets/img/menu/bt12.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/bt12.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Jack Daniel's Tennessee Whiskey</a><span>$9.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Jack Daniel's Old No.7 Tennessee Whiskey, 700 ml bottle
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-thincan">
                        <a href="assets/img/menu/tcan13.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/tcan13.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Heineken Slim Can</a><span>$12.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Heineken Slim Can 320ml 12oz can
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-bottled">
                        <a href="assets/img/menu/bt14.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/bt14.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Absolut Vodka</a><span>$9.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Absolut Vodka, 700mL Bottle
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-thincan">
                        <a href="assets/img/menu/tcan15.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/tcan15.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Cutwater Lime Tequila Soda</a><span>$12.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Cutwater Lime Tequila Soda 355ml 12oz can
                        </div>
                    </div>

                    <div class="col-lg-6 menu-item filter-bottled">
                        <a href="assets/img/menu/bt16.png" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/menu/bt16.png" class="menu-img" alt=""></a>
                        <div class="menu-content">
                            <a href="#">Jose Cuervo Special</a><span>$9.95</span>
                        </div>
                        <div class="menu-ingredients">
                            Jose Cuervo Especial Reposado, 375ml Bottle
                        </div>
                    </div>

                </div>
            </div>
        </section><!-- End Menu Section -->

        <!-- ======= Specials Section ======= -->
        <section id="specials" class="specials">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Specials</h2>
                    <p>Best Selling Alcoholic Beverages</p>
                </div>

                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-3">
                        <ul class="nav nav-tabs flex-column">
                            <li class="nav-item">
                                <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">Jack Daniel's</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-2">Jose Cuervo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-3">Heineken</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-4">Absolut Vodka</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-5">Josh Cellars Wine</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-9 mt-4 mt-lg-0">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab-1">
                                <div class="row">
                                    <div class="col-lg-8 details order-2 order-lg-1">
                                        <h3>Jack Daniel's Jennesse Whiskey</h3>
                                        <p class="fst-italic">Jack Daniel's Jennesse Whiskey. Nose Light with plenty of sweetness. There are
                                            hints of dry spice and oily nuts, a touch of smoke. Palate Quite smooth and soft with notes of
                                            banana milkshake, a mixed nut note, a touch of caramel with crème anglaise. Finish Sweet with a
                                            little cereal sweetness and toasty oak.</p>
                                        <p>Mellowed drop by drop through 10-feet of sugar maple charcoal, then matured in handcrafted
                                            barrels of our own making. And our Tennessee Whiskey doesn’t follow a calendar. It’s only ready
                                            when our tasters say it is. We judge it by the way it looks. By its aroma. And of course, by the
                                            way it tastes. It’s how Jack Daniel himself did it over a century ago. And how we still do it
                                            today.</p>
                                    </div>
                                    <div class="col-lg-4 text-center order-1 order-lg-2">
                                        <img src="assets\img\gallery\alco6.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <div class="row">
                                    <div class="col-lg-8 details order-2 order-lg-1">
                                        <h3>Jose Cuervo Especial Reposado</h3>
                                        <p class="fst-italic">Cuervo® Gold is golden-style joven tequila made from a blend of reposado
                                            (aged) and younger tequilas. Ever the story-maker, Cuervo® Gold’s own story includes the leading
                                            role in the invention of The Margarita, and it is still the perfect tequila for that beloved
                                            cocktail.</p>
                                        <p>This drink comes from Jose Cuervo Especial, which is the world’s No.1 tequila brand. This brand
                                            lays a typical “Gold Standard” based on which other brands are judged. The drink boasts of an
                                            ultra-smooth and well-balanced, short finish and taste on the tongue.</p>
                                    </div>
                                    <div class="col-lg-4 text-center order-1 order-lg-2">
                                        <img src="assets\img\gallery\alco8.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-3">
                                <div class="row">
                                    <div class="col-lg-8 details order-2 order-lg-1">
                                        <h3>Heineken Original</h3>
                                        <p class="fst-italic">Heineken® Pure Malt Lager Beer (5% ABV) is a refreshing, bright golden-yellow
                                            pure malt lager beer brewed with 100% natural ingredients.World's Most International Premium
                                            Beer.World Famous - The only beer enjoyed in 192 countries.100% Natural - Pure Natural Quality
                                            made with 3 ingredients only (Water, Malted Barley, and Hops).Same great taste around the world.
                                            Star-brewed for that first sip!</p>
                                        <p>The world's most valuable international premium Lager brand, Heineken has an impressive global
                                            reach. Their Original Lager is brewed using 100% malted grains alongside a selection of choice
                                            hops & special yeast strains, which are supplied from the Heineken headquarters in Zoeterwoude in
                                            the Netherlands.</p>
                                    </div>
                                    <div class="col-lg-4 text-center order-1 order-lg-2">
                                        <img src="assets\img\gallery\alco2.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-4">
                                <div class="row">
                                    <div class="col-lg-8 details order-2 order-lg-1">
                                        <h3>Absolut Blue Vodka</h3>
                                        <p class="fst-italic">Absolut Blue Vodka is one of the most famous vodkas in the world. It's made
                                            from winter wheat grown in the fields of Åhus, Sweden. Absolut is rich, full bodied and blends
                                            beautifully with other aromas, enhancing the taste of your drinks and cocktails. It has been
                                            produced at the famous old distilleries near Ahus in accordance with more than 400 years of
                                            Swedish tradition</p>
                                        <p>Clean and complex on the nose, with subtle cereal notes. Smooth and mellow to taste with a
                                            distinct character of peppery grain, followed by a hint of dried fruit and sourdough bread. All
                                            Absolut Vodka is made from winter wheat, which is distilled on four story high column stills to a
                                            supremely high quality.</p>
                                    </div>
                                    <div class="col-lg-4 text-center order-1 order-lg-2">
                                        <img src="assets\img\gallery\alco7.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-5">
                                <div class="row">
                                    <div class="col-lg-8 details order-2 order-lg-1">
                                        <h3>Josh Cellars Cabernet Sauvignon</h3>
                                        <p class="fst-italic"> Cabernet Sauvignon was the first wine we made. This is the wine that started
                                            it all, setting the exacting standards that we hold ourselves to for all of our varietals. The
                                            nose bursts with aromas of intense dark fruits, cinnamon, clove, and subtle oak aromas. The palate
                                            is dominated by flavors of black cherries and blackberries, accented by vanilla and toasty oak and
                                            finishing long with round, soft tannins.</p>
                                        <p>Round and juicy, Josh Cabernet Sauvignon has flavours of blackberry, toasted hazelnut and
                                            cinnamon, complemented by hints of vanilla and toasted oak. Pair this wine with well-seasoned
                                            meats like beef, pork, or lamb, and indulgent chocolate desserts.</p>
                                    </div>
                                    <div class="col-lg-4 text-center order-1 order-lg-2">
                                        <img src="assets\img\gallery\alco1.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End Specials Section -->

        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="testimonials section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Who we are</h2>
                    <p>Developers</p>
                </div>

                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    In every glass, a story swirls, a tale of flavors waiting to be tasted, a symphony of spirits dancing
                                    on the tongue.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                                <img src="assets/img/testimonials/testimonials-1.png" class="testimonial-img" alt="">
                                <h3>Miguel Bunyi</h3>
                                <h4>Developer</h4>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Behind every label lies a universe of taste, explore, indulge, and let your senses journey through the
                                    alchemy of flavors.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                                <img src="assets/img/testimonials/testimonials-2.png" class="testimonial-img" alt="">
                                <h3>Christian Bolima</h3>
                                <h4>Developer</h4>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Life, like a fine wine, is best savored slowly, sip by sip, embracing every nuanced moment.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                                <img src="assets/img/testimonials/testimonials-3.png" class="testimonial-img" alt="">
                                <h3>Nani Lipata</h3>
                                <h4>Developer</h4>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Cocktails aren't just drinks; they're crafted elixirs of inspiration, blending flavors to stir the
                                    soul and ignite conversations.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                                <img src="assets/img/testimonials/testimonials-4.png" class="testimonial-img" alt="">
                                <h3>Eugene Bigornia</h3>
                                <h4>Developer</h4>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Raise your glass to the magic in every pour, a liquid spell that transforms moments into memories.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                                <img src="assets/img/testimonials/testimonials-5.png" class="testimonial-img" alt="">
                                <h3>Aljen Carmona</h3>
                                <h4>Developer</h4>
                            </div>
                        </div><!-- End testimonial item -->



                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section><!-- End Testimonials Section -->

        <!-- ======= Gallery Section ======= -->
        <section id="gallery" class="gallery">

            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Alcohols</h2>
                    <p>Gallery</p>
                </div>
            </div>

            <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-0">

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="assets\img\gallery\vibe 1.png" class="gallery-lightbox" data-gall="gallery-item">
                                <img src="assets\img\gallery\vibe 1.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="C:\Users\Chan\OneDrive\Documents\Web Project\BOOZE\Restaurantly\assets\img\gallery\vibe 2.png" class="gallery-lightbox" data-gall="gallery-item">
                                <img src="assets\img\gallery\vibe 2.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="C:\Users\Chan\OneDrive\Documents\Web Project\BOOZE\Restaurantly\assets\img\gallery\vibe 3.png" class="gallery-lightbox" data-gall="gallery-item">
                                <img src="assets\img\gallery\vibe 3.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="C:\Users\Chan\OneDrive\Documents\Web Project\BOOZE\Restaurantly\assets\img\gallery\vibe 4.png" class="gallery-lightbox" data-gall="gallery-item">
                                <img src="assets\img\gallery\vibe 4.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="C:\Users\Chan\OneDrive\Documents\Web Project\BOOZE\Restaurantly\assets\img\gallery\vibe 5.png" class="gallery-lightbox" data-gall="gallery-item">
                                <img src="assets\img\gallery\vibe 5.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="C:\Users\Chan\OneDrive\Documents\Web Project\BOOZE\Restaurantly\assets\img\gallery\vibe 6.png" class="gallery-lightbox" data-gall="gallery-item">
                                <img src="assets\img\gallery\vibe 6.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="C:\Users\Chan\OneDrive\Documents\Web Project\BOOZE\Restaurantly\assets\img\gallery\vibe 7.png" class="gallery-lightbox" data-gall="gallery-item">
                                <img src="assets\img\gallery\vibe 7.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="C:\Users\Chan\OneDrive\Documents\Web Project\BOOZE\Restaurantly\assets\img\gallery\vibe 8.png" class="gallery-lightbox" data-gall="gallery-item">
                                <img src="assets\img\gallery\vibe 8.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Gallery Section -->



        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Contact</h2>
                    <p>Contact Us</p>
                </div>
            </div>

            <div data-aos="fade-up">
                <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15441.662450755435!2d121.04497624646807!3d14.632333547444935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b796aecb8763%3A0xaa026ea7350f82e7!2sTechnological%20Institute%20of%20the%20Philippines%20-%20Quezon%20City!5e0!3m2!1sen!2sph!4v1697630748700!5m2!1sen!2sph" frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="container" data-aos="fade-up">

                <div class="row mt-5">

                    <div class="col-lg-4">
                        <div class="info">
                            <div class="address">
                                <i class="bi bi-geo-alt"></i>
                                <h4>Location:</h4>
                                <p>938 Aurora Blvd, Cubao, Quezon City, 1109 Metro Manila</p>
                            </div>

                            <div class="open-hours">
                                <i class="bi bi-clock"></i>
                                <h4>Open Hours:</h4>
                                <p>
                                    Monday-Saturday:<br>
                                    8:00 AM - 8:00 PM
                                </p>
                            </div>

                            <div class="email">
                                <i class="bi bi-envelope"></i>
                                <h4>Email:</h4>
                                <p>thebooze@gmail.com</p>
                            </div>

                            <div class="phone">
                                <i class="bi bi-phone"></i>
                                <h4>Call:</h4>
                                <p>+63 9158890847</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-8 mt-5 mt-lg-0">

                        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="message" rows="8" placeholder="Message" required></textarea>
                            </div>
                            <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center"><button type="submit">Send Message</button></div>
                        </form>

                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-info">
                            <h3>The Booze</h3>
                            <p>
                                <br>938 Aurora Blvd, Cubao, Quezon City, 1109 Metro Manila<br>
                                <strong>Phone:</strong> +63 9158890847<br>
                                <strong>Email:</strong> thebooze@gmail.com<br>
                            </p>
                            <div class="social-links mt-3">
                                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>The Booze</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by Team ShawarmaShack</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- Bootstrap Loading via CDN -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <script>
      function myFunction() {
          // Define the functionality you want to perform here
          // For example, toggle the visibility of the password field
          var passwordField = document.getElementById("password");
          if (passwordField.type === "password") {
              passwordField.type = "text";
          } else {
              passwordField.type = "password";
          }
      }
  </script>
</body>

</html>