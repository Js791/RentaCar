<?php
session_start();
require("../lib/functions.php");
reset_session();

flash("Successfully logged out", "success");
redirect("home.php");
?>