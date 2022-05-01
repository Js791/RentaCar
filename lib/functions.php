<?php
function se($v, $k = null, $default = "", $isEcho = true)
{
    if (is_array($v) && isset($k) && isset($v[$k])) {
        $returnValue = $v[$k];
    } else if (is_object($v) && isset($k) && isset($v->$k)) {
        $returnValue = $v->$k;
    } else {
        $returnValue = $v;
        if (is_array($returnValue) || is_object($returnValue)) {
            $returnValue = $default;
        }
    }
    if (!isset($returnValue)) {
        $returnValue = $default;
    }
    if ($isEcho) {
        echo htmlspecialchars($returnValue, ENT_QUOTES);
    } else {
        return htmlspecialchars($returnValue, ENT_QUOTES);
    }
}
function get_url($dest)
{
    global $BASE_PATH;
    if (str_starts_with($dest, "/")) {
        //handle absolute path
        return $dest;
    }
    //handle relative path
    return $BASE_PATH . $dest;
}
function sanitize_email($email = "")
{
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}
function is_valid_email($email = "")
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
}
function redirect($path)
{ 
    if (!headers_sent()) {
        //php redirect
        die(header("Location: " . get_url($path)));
    }
    //javascript redirect
    echo "<script>window.location.href='" . get_url($path) . "';</script>";
    //metadata redirect (runs if javascript is disabled)
    echo "<noscript><meta http-equiv=\"refresh\" content=\"0;url=" . get_url($path) . "\"/></noscript>";
    die();
}
function is_logged_in($redirect = false, $destination = "home.php") 
{
    $isLoggedIn = isset($_SESSION["user"]);
    if ($redirect && !$isLoggedIn) {
        flash("You must be logged in to view this page", "warning");
       redirect("$destination");
    }
    return $isLoggedIn; //se($_SESSION, "user", false, false);
}

function flash($msg = "", $color = "info")
{
    $message = ["text" => $msg, "color" => $color];
    if (isset($_SESSION['flash'])) {
        array_push($_SESSION['flash'], $message);
    } else {
        $_SESSION['flash'] = array();
        array_push($_SESSION['flash'], $message);
    }
}

function getMessages()
{
    if (isset($_SESSION['flash'])) {
        $flashes = $_SESSION['flash'];
        $_SESSION['flash'] = array();
        return $flashes;
    }
    return array();
}

function getDB(){
    global $db;
    //this function returns an existing connection or creates a new one if needed
    //and assigns it to the $db variable
    if(!isset($db)) 
    {
        $hostname = 'wb39lt71kvkgdmw0.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
        $username = 'mqgzajyvl4pw3yns';
        $password = 'wfqniqurm2e1b8s6';
        $database = 'fk4ckx8dd3f27ovm';

        try 
        {
            $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

   	    catch(Exception $e)
        {
            echo "Connection failed: " . $e->getMessage();
            var_export($e);
            $db = null;
        }
    }
    return $db;
}
function reset_session()
{
    session_unset();
    session_destroy();
    session_start();
}

?>