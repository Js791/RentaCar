<?php
include_once '../lib/functions.php';
session_start();
$results = [];
$car_id = $_GET['carID'];
$db = getDB();
$stmt = $db->prepare("SELECT model.model,brand.brand,Cars.carID,rental_agreement.days FROM Cars Join model on Cars.modelID = model.modelID Join brand on Cars.brandID = brand.brandID join rental_agreement on Cars.carID = rental_agreement.car_id Where Cars.carID = :car_id;");
try {
    $stmt->execute([":car_id" => $car_id]);
    $return = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($return) 
    {
        $results = $return;
    }
} catch (PDOException $e) {
    flash("There is an error, the error is:" . var_export($e, true));
}
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet"/>
</head>
<div id="target"></div>
<div class="thankyou-page">
    <div class="_header">
        <div class="logo">
        </div>
        <h1>Thank You!</h1>
    </div>
    <div class="_body">
        <div class="_box">
            <h2>
                <strong>You have successfully rented: <?php echo $results['0']['brand'] . " " . $results['0']['model'];?></strong>
            </h2>
            <p>
                Please remember you have rented your vehicle for <?php echo $results[0]['days'];?> days, return the vehicle on time and we hope you enjoy your rental!
            </p>
        </div>
    </div>
    <div class="_footer">
        <p>Having trouble? <a href="">Contact us</a> </p>
        <a class="btn" href="home.php">Back to homepage</a>
    </div>
</div>
<style>
    @import url('https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&display=swap');
html,body {
    font-family: 'Raleway', sans-serif;  
}
.thankyou-page ._header {
    background: gray;
    padding: 100px 30px;
    text-align: center;
    background: gray url(https://codexcourier.com/images/main_page.jpg) center/cover no-repeat;
}
.thankyou-page ._header .logo {
    max-width: 200px;
    margin: 0 auto 50px;
}
.thankyou-page ._header .logo img {
    width: 100%;
}
.thankyou-page ._header h1 {
    font-size: 65px;
    font-weight: 800;
    color: black;
    margin: 0;
}
.thankyou-page ._body {
    margin: -70px 0 30px;
}
.thankyou-page ._body ._box {
    margin: auto;
    max-width: 80%;
    padding: 50px;
    background: white;
    border-radius: 3px;
    box-shadow: 0 0 35px rgba(10, 10, 10,0.12);
    -moz-box-shadow: 0 0 35px rgba(10, 10, 10,0.12);
    -webkit-box-shadow: 0 0 35px rgba(10, 10, 10,0.12);
}
.thankyou-page ._body ._box h2 {
    font-size: 32px;
    font-weight: 600;
    color: black;
}
.thankyou-page ._footer {
    text-align: center;
    padding: 50px 30px;
}

.thankyou-page ._footer .btn {
    background: blue;
    color: white;
    border: 0;
    font-size: 14px;
    font-weight: 600;
    border-radius: 0;
    letter-spacing: 0.8px;
    padding: 20px 33px;
    text-transform: uppercase;
}
</style>
<?php
include_once "../lib/flash.php";
?>