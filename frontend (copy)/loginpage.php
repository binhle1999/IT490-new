<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title> 

    <!--Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"/>
    <link href="../css/main.css" type="text/css" rel="stylesheet"/>
    <link rel="shortcut icon" href="../img/seedling-solid.svg"/>
    <!--Send user input to login.php to validate the user login and sessionID-->
</head> 
 
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-md navbar-light sticky-top shadow p-3 mb-5 bg-white rounde">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"><?php if(isset($_SESSION["username"])) {echo $_SESSION["username"];} ?></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.html">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--end of nav-->

    <div class="container p-1"></div>
    <div class="container col-md-6">
    <h1>Sign In</h1>
    <hr>
    <form action="login.php" method="POST" >
        <div class="mb-3">
            <input type="username" class="form-control" id="username" name="username" placeholder="Enter Username">
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
        </div>
        
        <button type="submit" class="btn btn-primary">Sign In</button>
        <a class="nav-link" href="">Forgot Password?</a>
    </form>
    </div>
    <div class="container p-1"></div>

</body>

<!--Footer-->
<footer class="text-center text-white sticky-bottom container-fluid footer" style="background-color: #7d9988;">
    <!-- Grid container -->
    <div class="container p-3">
    <!--common links and other infromation accessible from all pages-->
    <p> © Copyright 2022: IT490 Project</p>
  </div>
</footer>

</html>