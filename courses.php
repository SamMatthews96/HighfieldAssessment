<?php

$string = file_get_contents("courses.json");
$json = json_decode($string, true);

$ans = json_encode($json);

// validate _GET
// check _GET for category, min_price, max_price
//var_dump($_GET);
$filters = [];
foreach ($_GET as $key => $value) {
    switch ($key) {
        case 'category':
            $filters['category'] = $value;
            break;
        case 'min_price':
        case 'max_price':
            if (is_numeric($value)){
                $filters[$key] = (float)$value;
            } else {
                http_response_code(400);
                $ans = [
                    "error" => "Invalid parameter type",
                    "description" => $key . " must be a number"
                ];
                echo json_encode($ans);
                return;
            }
            break;
        default:
            http_response_code(400);
            $ans = [
                "error" => "Invalid parameter",
                "description" => $key . " is not a valid parameter. Valid parameters are category, min_price, max_price"
            ];
            echo json_encode($ans);
            return;
    }
}

echo $ans;