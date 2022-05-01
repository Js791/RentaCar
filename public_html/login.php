<?php
include_once '../lib/functions.php';
$email = se($_POST, "e", "", false);
session_start();
?>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet"/>
</head>

<body>
    <section class="vh-100">
        <div id="E"></div>
        <div class="container-fluid h-custom">
            <section class="container">
                <div class="fullBackground"></div>
                    <div id="target"></div>
            </section>
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div id="target"></div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <img src="photos/attachment_62504124-removebg-preview.png" class="img" width="400" height="400">
                    <form class="loginBox" onsubmit=True method="POST">
                        <h1>Login</h1>
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                        </div>
                        <div class="divider d-flex align-items-center my-4">
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example3"></label>
                            <input type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Enter a valid email address" name="e" required value=<?php se($email) ?>></input>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label" for="form3Example4"></label>
                            <input type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" name="p" required minlength="8"></input>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="text-center text-lg-start mt-4 pt-2">
                                <input type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" value="Login"></input>
                                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="register.php" class="link-danger" style="font-size:25px; padding-left: 2.5rem; padding-right: 2.5rem;">Register</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="JsHelpers/fullclip.js"></script>
        <script src="JsHelpers/fullclip.min.js"></script>
        <script>
            $('.fullBackground').fullClip({
                images: ['photos/911.jpg','photos/db11.jpg','photos/r8.jpg','photos/amg.jpg'],
                transitionTime:3000,
                wait: 5000
            });
        </script>
    </section>
</body>
<style>
    .loginBox
    {
        height: 50% !important;
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%,-50%) !important;
        font: white !important;
        outline: none !important;
        color: white !important;
        border: 6px solid rgba(255,255,255,0.438) !important;
        box-sizing: content-box !important;
        width: 300px !important;
        height: 300px !important;
        padding: 75px !important;
        
    }

    .loginBox h1
    {
        text-align: center !important;
        height: 5% !important;
        top: 50% !important;
        bottom: 50% !important;
        font-size: 40px !important;
        color: white !important;

    }
    .img
    {
        position: relative !important;
        top: -270px !important;
        left:-675px !important;
        
    }
    #E
    {
        color:white !important;
    }

</style>
<?php
if (isset($_POST["e"]) && isset($_POST["p"])) {
    $email = se($_POST, "e", "", false);
    $password = se($_POST, "p", "", false);
    $hasErrors = false;
    if (empty($email)) {
        flash("Email must be typed in", "warning");
        $hasErrors = true;
    }
    if (str_contains($email, "@")) {
        $email = sanitize_email($email);

        if (!is_valid_email($email)) {
            flash("Invalid email address", "warning");
            $hasErrors = true;
        }
    }

    if (empty($password)) {
        flash("Password must be typed in", "warning");
        $hasErrors = true;
    }

    if (strlen($password) < 8) {
        flash("Password must be at least 8 characters", "warning");
        $hasErrors = true;
    }

    if ($hasErrors) {
        //Nothing to output here,if errors then previous if stmts will handle it.
    } else {
        $db = getDB();
        $stmt = $db->prepare("SELECT id,email,name,pass from Users where email = :email");
        try {
            $r = $stmt->execute([":email" => $email]);
            if ($r) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $hash = $user["pass"];
                    unset($user["pass"]);
                    if (password_verify($password, $hash)) {
                        flash("Welcome!");
                        $_SESSION["user"] = $user;
                        redirect('home.php');
                    } else {
                        flash("Invalid password", "danger");
                    }
                } else {
                    flash("Email not found", "danger");
                }
            }
        } catch (Exception $e) {
            flash(var_export($e, true));
        }
    }
}
?>
<?php
include_once "../lib/flash.php";
?>