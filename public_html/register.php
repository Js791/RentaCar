<?php
include_once "../lib/functions.php";
$email = se($_POST,"email","",false);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
   <div id ="target"></div>
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                <form class="mx-1 mx-md-4" onsubmit="return validate(this)" method="POST">
                  <div id="E"></div>
                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example1c">Your Name</label>
                      <input type="text" id="name" class="form-control"  name="N"/>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example3c">Your Email</label>
                      <input type="email" class="form-control" name="email" id="email"  value=<?php se($email)?>>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example4c">Password</label>
                      <input type="password" class="form-control" name="password" id = "pass"/>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example4cd">Repeat your password</label>
                      <input type="password" class="form-control" name="repeat" id ="repe"/>
                    </div>
                  </div>
                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <input type="submit" value ="Register" class="btn btn-primary btn-lg"></input>
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
         let name = document.getElementsByName("N")[0].value;
         let email = document.getElementsByName("email")[0].value;
         let password = document.getElementsByName("password")[0].value;
         let repeat = document.getElementsByName("repeat")[0].value;
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

            if((password !== repeat) || (password.length !== repeat.length))
            {
                errors.push("Passwords dont match");
            }
            
            if(!name)
            {
                errors.push("Name must be filled out");
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
if(isset($_POST["N"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["repeat"]))
{
    
    $name = se($_POST,"N","",false);
    $email = se($_POST, "email","",false);
    $password = se($_POST,"password","",false);
    $repeat = se($_POST,"repeat","",false);
    
    $has_errors = false;
    if(empty($email))
    {
        flash("Email must not be empty");
        $has_errors = true;
    }

    $email = sanitize_email($email);

    if(!is_valid_email($email))
    {
        flash("Not a valid email");
        $has_errors = true;
    }

    if(empty($password))
    {
        flash("password cannot be empty");
        $has_errors = true;
    }

    if(empty($repeat))
    {
        flash("Repeat password cannot be empty");
        $has_errors = true;
    }

    if(strlen($password) < 5)
    {
        flash("Password too short must be more than 5 characters");
        $has_errors = true;
    }

    if($password !== $repeat)
    {
        flash("Repeat password and Password fields do not match");
        $has_errors = true;
    }

    if($has_errors)
    {
        //do nothing fix the errors
    }

    else
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (email, pass, name) VALUES(:email, :pass, :name)");
        $hash = password_hash($password, PASSWORD_BCRYPT);
        try 
        {
                $stmt->execute([":email" => $email, ":pass" => $hash, ":name" => $name]);
                flash("You've registered, Welcome");
        } 
        catch (Exception $e) 
            {
                $code = se($e->errorInfo,1,'0000',false);
                if($code == '1062')
                {
                    flash("An account already exists with this email, please choose another email",'warning');    
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