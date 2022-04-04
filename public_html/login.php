<?php
include_once '../lib/functions.php';
$email = se($_POST,"e","",false);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<section class="vh-100">
    <div id="E"></div>
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
      <div id ="target"></div>
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="carrental.jpg" class="img-fluid" alt="Rental Logo" style="position:relative;bottom:40px">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form onsubmit="return validate(this)" method="POST">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
          </div>

          <div class="divider d-flex align-items-center my-4">
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <label class="form-label" for="form3Example3">Email address</label>
            <input type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Enter a valid email address" name="e" value = <?php se($email)?>></input>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <label class="form-label" for="form3Example4">Password</label>
            <input type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" name="p"></input>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
          <div class="text-center text-lg-start mt-4 pt-2">
            <input type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" value ="Login"></input>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="register.php" class="link-danger">Register</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>
<script>
     function validate(form) //client side validation
    {
        
         const error = document.getElementById("E");
         let email = document.getElementsByName("e")[0].value;
         let password = document.getElementsByName("p")[0].value;
         let errors = [];

            if(password.length < 8 )
            {
                if(!password)
                {
                    errors.push("Passsword must be filled out");
                }
                else
                {
                    errors.push("Password too short");
                }
               
            }

            if(!email)
            {
                errors.push("Email must not be empty");
            }

            if(!(email.includes("@")))
            {
                errors.push("Not a valid email");
            }

            if(!(/^([a-zA-Z\d\.-]+)@([a-z\d]+)\.([a-z]{2,8}(\.[a-z]{2,8})?)$/.test(email)))
            {   
                    errors.push("Email is not in the correct form");
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
if (isset($_POST["e"]) && isset($_POST["p"])) 
{
    $email = se($_POST, "e", "", false);
    $password = se($_POST, "p", "", false);
    $hasErrors = false;
    if (empty($email)) 
    {
        flash("Email must be typed in", "warning");
        $hasErrors = true;
    }
    if (str_contains($email, "@")) 
    {
        $email = sanitize_email($email);
  
        if (!is_valid_email($email)) 
        {
            flash("Invalid email address", "warning");
            $hasErrors = true;
        }
    } 

    if (empty($password)) 
    {
        flash("Password must be typed in","warning");
        $hasErrors = true;
    }

    if (strlen($password) < 8) {
        flash("Password must be at least 8 characters", "warning");
        $hasErrors = true;
    }

    if ($hasErrors) 
    {
        //Nothing to output here,if errors then previous if stmts will handle it.
    } 
    else 
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT id,email,name,pass from Users where email = :email");
        try 
        {
            $r = $stmt->execute([":email" => $email]);
            if ($r) 
            {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) 
                {
                    $hash = $user["pass"];
                    unset($user["pass"]);
                    if (password_verify($password, $hash)) 
                    {
                        flash("Welcome!");
                        $_SESSION["user"] = $user;
                    } 
                    else 
                    {
                        flash("Invalid password", "danger");
                    }
                } 
                else 
                {
                    flash("Email not found", "danger");
                }
            }
        } 
        catch (Exception $e) 
        {
            flash(var_export($e, true));
        }
    }
}
?>
<?php
include_once "../lib/flash.php";
?>