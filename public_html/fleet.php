
<?php
session_start();
include_once '../lib/functions.php';
$results = [];
$db = getDB();
$stmt = $db->prepare("SELECT Cars.image,Cars.description,model.model,brand.brand,Cars.carID FROM Cars Join model on Cars.modelID = model.modelID Join brand on Cars.brandID = brand.brandID Join prices on Cars.priceID = prices.priceID Where visibility > 0 AND stock > 0;");
try {
    $stmt->execute();
    $return = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($return) {
        $results = $return;
    }
} catch (PDOException $e) {
    flash("There is an error, the error is:" . var_export($e, true));
}
?>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div id="target"></div>
    <div class="banner">
        <div class="navbar">
            <img src="photos/attachment_62504124-removebg-preview.png" class="logo">
            <div class="content">
                <h1>Our Fleet</h1>
            </div>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">For Business</a></li>
                <?php if(is_logged_in()) : ?>
                        <li><a href="logout.php">Logout</a></li>
                <?php endif;?>
            </ul>
        </div>
        <div class="container">
            <div class="row row-cols-1 row-cols-md-5 g-4" id="row">
                <?php foreach ($results as $member) : ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card">
                            <?php if (se($member, "image", "", false) && se($member, "description", "", false) && se($member, "brand", "", false) && se($member, "model", "", false)) : ?>
                                <img src="<?php se($member, "image"); ?>" alt=".." class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Make: <?php se($member, "brand"); ?></h5>
                                    <h6 class="card-title">Model: <?php se($member, "model"); ?></h6>
                                    <h7 class="card-title">Description:</h7>
                                    <p class="card-text"><?php se($member, "description"); ?></p>
                                    <button type="button" onclick="window.location.href='rent.php?carID=<?php se($member,'carID');?>'">Rent</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
<style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;

    }

    .banner {
        width: 100%;
        height: 100vh;
        background-image: linear-gradient(rgba(0, 0, 0, 0.50), rgba(0, 0, 0, 0.50)), url(photos/background.jpg);
        background-size: cover;
        background-position: center;
    }

    .navbar {
        width: 43%;
        margin-left: auto;
        justify-content: space-between;
        align-items: center;
        padding: 35px 0;

    }

    .logo {
        position: absolute;
        width: 45%;
        top: -55px;
        left: -950px;

    }

    .navbar ul li {
        list-style: none;
        display: inline-block;
        margin: 0 20px;
        position: relative;
    }

    .navbar ul li a {
        text-decoration: none;
        color: #fff;
        text-transform: uppercase;
    }

    .navbar ul li::after {
        content: '';
        height: 3px;
        width: 0;
        background: yellow;
        position: absolute;
        left: 0;
        bottom: -10px;
        transition: 0.25s;
    }

    .navbar ul li:hover::after {
        width: 100%;

    }

    .content {
        width: 100%;
        position: absolute;
        top: 20%;
        right: 455px;
        top: 60px;
        transform: translateY(-50%);
        text-align: center;
        color: #fff;
    }

    .content h1 {
        font-size: 70px;
        margin-top: 80px;
    }

    .content p {
        margin: 20px auto;
        font-weight: 100;
        line-height: 25px;
    }

    .container {
        margin: 50px;
        padding: 40px;
        border-radius: 20px;
        width: 65%;
        justify-content: space-between;
    }

    button {
        background-color: #0095ff;
        border: 1px solid transparent;
        border-radius: 3px;
        box-shadow: rgba(255, 255, 255, .4) 0 1px 0 0 inset;
        box-sizing: border-box;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        font-family: system-ui, "Segoe UI", "Liberation Sans", sans-serif;
        font-size: 20px;
        font-weight: 400;
        line-height: 1.15385;
        margin: 0;
        outline: none;
        padding: 8px .8em;
        position: relative;
        text-align: center;
        text-decoration: none;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        vertical-align: baseline;
        white-space: nowrap;

    }
</style>
<?php

include_once "../lib/flash.php";
?>