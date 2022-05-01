<?php
session_start();
include_once '../lib/functions.php';
?>
<html>
    <body>
        <div id="target"></div>
        <div class="banner">
            <div class="navbar">
                <img src="photos/attachment_62504124-removebg-preview.png" class="logo">
                <ul>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">For Business</a></li>
                    <?php if(is_logged_in()) : ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php endif;?>
                </ul>
            </div>
            <div class="content">
                <h1>Welcome to Royalty Car Rental!</h1>
                <p>Take a look at our luxury car fleet! <br>We have a wide variety of vehicles in our fleet!</br></p>
                <div>
                    <button type="button" onclick="window.location.href='login.php'"><span></span>Login/Sign up</button>
                    <button type="button"  onclick="window.location.href='fleet.php'"><span></span>Fleet</button>
                </div>
            </div>
        </div>
    </body>
</html>
<style>
    *{
       margin:0;
       padding:0;
       font-family:sans-serif;
    }
    .banner
    {
        width:100%;
        height: 100vh;
        background-image: linear-gradient(rgba(0,0,0,0.50),rgba(0,0,0,0.50)),url(photos/background.jpg);
        background-size:cover;
        background-position: center;
    }
    .navbar
    {
        width: 35%;
        margin-left:auto;
        justify-content: space-between;
        align-items: center;
        padding: 35px 0;

    }
    .logo
    {
        position: absolute;
        width:20%;
        top:-60px;
        left:-80px;
        cursor:pointer;

    }
    .navbar ul li
    {
        list-style:none;
        display:inline-block;
        margin: 0 20px;
        position: relative;
    }
    .navbar ul li a
    {
        text-decoration: none;
        color: #fff;
        text-transform: uppercase;
    }
    .navbar ul li::after
    {
        content: '';
        height: 3px;
        width:0;
        background: yellow;
        position: absolute;
        left: 0;
        bottom: -10px;
        transition: 0.25s;
    }
    .navbar ul li:hover::after
    {
        width: 100%;

    }
    .content
    {
        width:100%;
        position:absolute;
        top: 50%;
        transform: translateY(-50%);
        text-align:center;
        color:#fff;
    }
    .content h1
    {
        font-size: 70px;
        margin-top:80px;
    }
    .content p
    {
        margin: 20px auto;
        font-weight: 100;
        line-height:25px;
    }
    button
    {
        width:200px;
        padding: 15px 0;
        text-align:center;
        margin:20px 10px;
        border-radius:25px;
        font-weight:bold;
        border:2px solid yellow;
        background:transparent;
        color: #fff;
        cursor: pointer;
        position:relative;
        overflow:hidden;
    }
    span
    {
        background: yellow;
        filter:brightness(75%);
        height: 100%;
        width: 0;
        border-radius:25px;
        position: absolute;
        left:0;
        bottom:0;
        z-index: -1;
        transition:0.25s;

    }

    button:hover span
    {
        width:100%;
    }
    button:hover
    {
        border:none;
    }

</style>
<?php
include_once "../lib/flash.php";
?>