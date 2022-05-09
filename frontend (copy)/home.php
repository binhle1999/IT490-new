<?php

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$preferences = array();
$preferences["DietType"] = $_POST["diet"];
$preferences["Intolerances"] = $_POST["intolerances"];
$ingredientsAtHome["IngredientsAtHome"] = $_POST["ingredients"];

/*function saveRecipe()
{
	$str = "lap was here";
	return $str;
}*/

function complex_search($preferences, $ingredientsAtHome)
{
    $url = "https://api.spoonacular.com/recipes/complexSearch?diet=";
    $url .= $preferences["DietType"];
    $url .= "&instructionsRequired=true&addRecipeInformation=true";
    $url .= "&intolerances=";
    $intolerances = explode(", ", $preferences["Intolerances"]);
    for ($i = 0; $i < count($intolerances) - 1; $i++) {
        $url .= $intolerances[$i] . "%2C%20";
    }
    $url .= $intolerances[count($intolerances) - 1];

    $ingredientsAtHome = explode(", ", $ingredientsAtHome["IngredientsAtHome"]);
    $url .= "&includeIngredients=";
    for ($i = 0; $i < count($ingredientsAtHome) - 1; $i++) {
        $url .= $ingredientsAtHome[$i] . "%2C%20";
    }
    $url .= $ingredientsAtHome[count($ingredientsAtHome) - 1];
    $url .= "&fillIngredients=true&sort=max-used-ingredients";
    $url .= "&number=5&apiKey=" . "cb8cebfd5d1d4e1b88f4f7e9e4f95f8a";
    return $url;
}

$ip=["192.168.194.3", "192.168.194.117", "192.168.194.181"];
$num=0;
for ($i=0; $i<count($ip); $i++)
{
	$host = $ip[$i];
	exec("ping -c 2 " . $host, $output, $result);

	if ($result==0)
	{
        	echo PHP_EOL. "[*] ".$host." is Online".PHP_EOL;
		break;
	}
	else
	{
        	echo PHP_EOL. "[*] ".$host." is Offline".PHP_EOL;
        	$host = "off";
	}
}
if ($host == "192.168.194.3")
{
	$node="testRabbitMQ.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.117")
{
	$node="testRabbitMQ2.ini"; 
	echo $node .PHP_EOL;
}
if($host == "192.168.194.181")
{
	$node="testRabbitMQ3.ini"; 
	echo $node .PHP_EOL;
}
if($host == "off")
{
	$node="No Machine is Online WTF"; 
	echo $node .PHP_EOL;
}

$client = new rabbitMQClient($node,"testServer");

$request['type'] = "search";
$request['url'] = complex_search($preferences, $ingredientsAtHome);
$response = $client->send_request($request);

//echo '<pre>';
//print_r($response);
//echo '<pre>';

/*if($response == 1){
	
	
} else{
        
}*/

}
?>

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
    <h3>Search for Recipes</h3></br>
      <input type="text" name="ingredients" id="recipe" class="form-control" placeholder="Search for Recipes">
      </br>
      <input type="text" name="intolerances" id="allergy" class="form-control" placeholder="Enter Any Intolerances ex: peanuts, diary, gluten, etc.">
      </br>
      <p>Select a Diet Type:</p>
	<div>
  		<input type="radio" id="omnivore" name="diet" value="omnivore" checked>
  		<label for="omnivore">Everything</label>
  		
  		<input type="radio" id="vegan" name="diet" value="vegan">
  		<label for="vegan">Vegan</label>
  		
  		<input type="radio" id="vegetarian" name="diet" value="vegetarian">
  		<label for="vegetarian">Vegetarian</label>
  		
  		<input type="radio" id="keto" name="diet" value="keto">
  		<label for="keto">Keto</label>
	</div>
	</br>
      <button type="submit" name="search" class="btn btn-primary">Search</button>
      <br></br>
    </form>
    <div>
  <?php for($i = 0; $i<count($response["results"]); $i++)
{
	echo '<div id="div'.$i.'">';
	$str = strval($response["results"][$i]["title"]);
	echo "<h3>$str</h3>"."\n";
	echo "<img src='".$response["results"][$i]["image"]."'>"."</br>\n"."</br>\n";
	//echo "Recipe ID: " . $response["results"][$i]["id"]."</br>\n";
	echo "<h6>Dish Summary: </h6>" . "\n" . $response["results"][$i]["summary"]."</br></br>\n";
	echo "<h6>Cook & Prep Time: </h6>" . "\n" . $response["results"][$i]["readyInMinutes"]."</br></br>\n";
	echo "<h6>Servings: </h6>" . "\n" . $response["results"][$i]["servings"]."</br></br>\n";
	echo "<h6>Link: </h6>" . "\n" . $response["results"][$i]["sourceUrl"]."</br></br>";
	echo ("<button onclick=\"saveRecipe()\"> Favorite Recipe </button>")."</br></br>\n";
	echo '</div>';
	
	
} ?>
  </div>
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
