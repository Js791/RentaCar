<?php
include_once "../lib/functions.php";
session_start();
if (!is_logged_in()) {
    flash("You must be logged on to view this page", "warning");
    redirect("login.php");
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div id="target"></div>
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                <div id="E"></div>
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Rental Reservation</p>

                                <form class="mx-1 mx-md-4" onsubmit="return validate(this)" method="POST">
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example1c">Your Full Name</label>
                                            <input type="text" id="name" class="form-control" name="FullName" required/>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example3c">Your Full Address</label>
                                            <input type="text" class="form-control" name="address" id="addy" required>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example4c">Desired Rental Duration (in days)</label>
                                            <input type="text" class="form-control" name="days" id="day" required />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example4c"> Select A Credit Card</label>
                                            <select id="cards" name="card" required>
                                                <option value="AMEX">AMEX</option>
                                                <option value="Discover">DISCOVER</option>
                                                <option value="VISA">VISA</option>
                                                <option value="MASTERCARD">MASTERCARD</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example4cd">Your Driver's License Number</label>
                                            <input type="text" class="form-control" name="DL" id="driversL" required />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example4cd">Upload front and back of your Driver's License</label>
                                            <br></br>
                                            <input type="file" name="filefield" id="file" multiple="multiple" required />
                                        </div>
                                    </div>
                                    <br></br>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <input type="submit" value="Rent" class="btn btn-primary btn-lg"></input>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" alt="Sample image">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
     function validate(form) //client side validation
    {
        
         const error = document.getElementById("E");
         let name = document.getElementsByName("FullName")[0].value;
         let addy = document.getElementsByName("address")[0].value;
         let Dl = document.getElementsByName("DL")[0].value;
         let days = document.getElementsByName("days")[0].value;
         let errors = [];

            if(!name)
            {
                errors.push("you must enter your full name");
            }
            if(!days)
            {
                errors.push("you must enter the number of desired rental days");
            }

            if(!addy)
            {
                errors.push("address must be filled out");
            }

            if(!Dl)
            {
                errors.push("Drivers License must be entered");
            }
            if(!/^[0-9]$/.test(days))
            {
                errors.push("enter a number for the desired rental days");
            }
            if(errors.length != 0)
            {
                error.innerText = errors.join(', ');
                return false;
            }

            return true;
    }
</script>
<?php
if(isset($_POST["FullName"]) && isset($_POST["address"]) && isset($_POST["days"]) && isset($_POST["DL"]) && isset($_POST["filefield"]) && isset($_POST["card"]))
{
    
    $name = se($_POST,"FullName","",false);
    $addy = se($_POST, "address","",false);
    $days = se($_POST,"days","",false);
    $dl = se($_POST,"DL","",false);
    $file = se($_POST,"filefield","",false);
    $card = se($_POST,"card","",false);
    
    $has_errors = false;
    if(empty($name))
    {
        flash("name must not be empty");
        $has_errors = true;
    }

    if(empty($addy))
    {
        flash("address cannot be empty");
        $has_errors = true;
    }

    if(empty($dl))
    {
        flash("driver's license must not be empty");
        $has_errors = true;
    }
    if(empty($days))
    {
        flash("duration day(s) must be entered");
        $has_errors = true;
    }
    if(!is_numeric($days))
    {
        flash("please enter a number for days field");
        $has_errors = true;
    }
    if(!$file)
    {
        flash("must upload driver's license files");
        $has_errors = true;
    }

    if($has_errors)
    {
        //do nothing fix the errors
    }

    else
    {
        $db = getDB();
        $car_id = $_GET['carID'];
        $stmt = $db->prepare("INSERT INTO rental_agreement(address,name,days,car_id,card,Driver_L,DL_photo) VALUES(:address, :name, :days,:car_id,:card,:Driver_L,:DL_photo)");
        try 
        {
                $stmt->execute([":address" => $addy, ":name" => $name, ":days" => $days, ":car_id" => $car_id, ":card" => $card , ":Driver_L"=> $dl ,":DL_photo" => $file]);
                $stmt_2 = $db->prepare("UPDATE Cars set stock = stock-1,visibility = 0 where carID=:car_id");
                $stmt_2->execute([":car_id" => $car_id]);
                redirect("thankyou.php?carID=$car_id");
        } 
        catch (Exception $e) 
            {
                $code = se($e->errorInfo,1,'0000',false);
                if($code == '1062')
                {
                    flash("A reservation already exists",'warning');    
                } 
                else 
                {
                    
                    flash("Error please resolve: " . var_export($e->errorInfo, true));
                }
               
            }
    }
}
?>
<?php
include_once "../lib/flash.php";
?>