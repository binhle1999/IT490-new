<?php
function api_call($url): array|bool|string
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            'Content-type: application/json'
        ],
    ]);

    $response = curl_exec($curl);
    $errorText = curl_error($curl);

    curl_close($curl);

    return $errorText ? ["errorText" => "cURL Error #:" . $errorText] : $response;
}

function generate_complex_search_url($preferences, $ingredientsAtHome, $type): string
{
    $url = "https://api.spoonacular.com/recipes/complexSearch?diet=";
    $url .= $preferences["DietType"];
    $url .= "&intolerances=";
    $intolerances = explode(", ", $preferences["Intolerances"]);
    for ($i = 0; $i < count($intolerances) - 1; $i++) {
        $url .= $intolerances[$i] . " %2C%20 ";
    }
    $url .= $intolerances[count($intolerances) - 1];

    $ingredientsAtHome = explode(", ", $ingredientsAtHome["IngredientsAtHome"]);
    $url .= "&includeIngredients=";
    for ($i = 0; $i < count($ingredientsAtHome) - 1; $i++) {
        $url .= $ingredientsAtHome[$i] . " %2C%20 ";
    }
    $url .= $ingredientsAtHome[count($ingredientsAtHome) - 1];
    $url .= "&type=" . $type;
    $url .= "&fillIngredients=true&sort=max-used-ingredients";
    $url .= "&maxCalories=" . intdiv($preferences["Calories"], 3) . "&number=10&apiKey=" . API_KEY;
    return $url;
}
?>
