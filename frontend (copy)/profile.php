<!DOCTYPE html>
<html lang="en">
<head>  
  <meta charset="UTF-8">
  <title>Home</title> 

  <!--Links-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="../css/main.css" type="text/css" rel="stylesheet">
  <link rel="shortcut icon" href="../img/seedling-solid.svg"/>

<body>
  <!-- Navigation-->
  <nav class="navbar navbar-expand-md navbar-light sticky-top shadow p-3 mb-5 bg-white rounde">
    <div class="container-fluid">
      <div class="logo" style="color:#7d9988">
        <h1>
          <i class="fas fa-seedling"></i>
          レシピ
        </h1>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item active">
            <a class="nav-link" href="home.php">Home</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="profile.php">Calorie Calculator</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="logout.php"">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!--end of nav-->

  <!--search bar-->
  
  <div class="container">
    <form class="form-inline" method="POST">
    <h3>Calorie Calculator</h3></br>
    Gender:
    <select name="gender"><br>
    <option>Male</option>
    <option>Female</option>
    </select><br><br>
    Age:
    <input name="age" type="text"placeholder="Enter Age" pattern="[0-9]+"> yrs.<br><br>
    Weight:
    <input name="weight" type="text" placeholder="Enter Weight in lbs" pattern="[0-9]+"> lbs.<br><br>
    Height:
    <input name="height" type="text" placeholder="Enter height in cm" pattern="[0-9]+"> cm.<br><br>
    <br><input type="Submit" value="Calculate"><br><br>

    <?php
	$age=$_POST['age'];
	$weight=$_POST['weight']/2.2046;
	$height = $_POST['height'];
	$calories="0.0215183";
	$gender=$_POST['gender'];
		
	switch ($gender){
	case 'Female':
		$gender= 655 + (9.6 * $weight ) + (1.8 * $height) - (4.7 * $age);
		$calorie= number_format($gender, 2);
		echo "<br><h6>Your estimated daily metabolic rate is $calorie </h6>";
		echo "<h6>This means that you need rouhgly $calorie calories a day to maintain your current weight.</h6>";
		break;
	case 'Male':
		$gender=66 + (13.7 *$weight) + (5 * $height) - (6.8 * $age);
		$calorie= number_format($gender, 2);
		echo "<br><h6>Your estimated daily metabolic rate is $calorie </h6>";
		echo "<h6>This means that you need rouhgly $calorie calories a day to maintain your current weight.</h6>";			
	}
?>
      </br>
	</br>
      <button type="submit" name="search" class="btn btn-primary">Search</button>
      <br></br>
    </form>
  </div>

  
  <!--Home Page Info-->
<!--
  <div class="row container-fluid card-deck">
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"></h5>
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">View Recipe</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Special title treatment</h5>
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">View Recipe</a>
        </div>
      </div>
    </div>
  </div>
  <br></br>
-->
</body>


<!--Footer-->
<footer class="text-center text-white sticky-bottom container-fluid footer" style="background-color: #7d9988;">
    <!-- Grid container -->
    <div class="container p-3">
    <!--common links and other infromation accessible from all pages-->
    <p> © Copyright 2021: Best IT490 Group</p>
  </div>
</footer>
</html>
