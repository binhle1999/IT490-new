<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">   
    <title>Register</title> 

    <!--Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../css/main.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/seedling-solid.svg"/>
</head>
 
<body>
<!--Sign Up Page-->

<!-- Navigation-->
<nav class="navbar navbar-expand-md navbar-light sticky-top sticky-top shadow p-3 mb-5 bg-white rounde">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="login.html">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--end of nav-->

<!--Register user account-->
<div class="container col-md-6">
    <h1>Register</h1>
    <hr/>
    <form action="register.php" method="POST">
        <div class="row g-3">
            <div class="col-md-6 input-fld">
                <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" aria-label="First name">
            </div>
            <div class="col-md-6 input-fld">
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" aria-label="Last name">
            </div>
            <div class="col-12 input-fld">
              <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
            <div class="col-12 input-fld">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="col-12 input-fld">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label style="color: grey;">*Must include special characters</label>
            </div>
            <div class="col-12 input-fld">
            <label for="securityq1" style="color: grey;">Choose a security question</label>
                <select class="form-control" id="securityq1" name="securityq1">
                <option value="Name of first pet">Name of your first pet?</option>
                <option value="Favorite Color">Your favorite color?</option>
                </select>   
            </div>
            <div class="col-12 input-fld">
              <input type="text" class="form-control" id="answer1" name="answer1" placeholder="Question 1 Answer">
            </div>
            <div class="col-12 input-fld">
            <label for="securityq1" style="color: grey;">Choose a security question</label>
                <select class="form-control" id="securityq2" name="securityq2">
                <option value="Father's Middle name">Father's middle name?</option>
                <option value="Model of first car">Model of first car?</option>
                </select>
            </div>
            <div class="col-12 input-fld">
              <input type="text" class="form-control" id="answer2" name="answer2" placeholder="Question 2 Answer">
            </div>
             		
            <div class="col-12">
                <button type="submit" id="submit" class="btn btn-primary">Register</button>
            </div>
        </div>
    </form>
</div>
</body>

<!--Footer-->
<footer class="text-center text-white sticky-bottom container-fluid footer" style="background-color: #7d9988;">
    <!-- Grid container -->
    <div class="container p-4">
    <!--common links and other infromation accessible from all pages-->
    <p> © Copyright 2022: Best IT490 Group</p>
  </div>
</footer>

</html>
