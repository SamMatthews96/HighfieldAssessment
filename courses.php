<?php

$string = file_get_contents("courses.json");
$coursesJson = json_decode($string, true);

$filters = [];
foreach ($_GET as $key => $value) {
    switch ($key) {
        case 'category':
            if (trim($value) == '') break;
            $filters['category'] = $value;
            break;
        case 'min_price':
        case 'max_price':
            if ($value == '') break;
            if (is_numeric($value)){
                $filters[$key] = (float)$value;
            } else {
                http_response_code(400);
                $ans = [
                    "error" => "Invalid parameter type",
                    "description" => $key . " must be a number, value is '" . $value ."'"
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

$response = [];
foreach ($coursesJson as $course) {
    if (isset($filters['category']) && $course['category'] != $filters['category']) {
        continue;
    }
    if (isset($filters['min_price']) && $course['price'] < $filters['min_price']) {
        continue;
    }
    if (isset($filters['max_price']) && $course['price'] > $filters['max_price']) {
        continue;
    }
    $response[] = $course;
}
echo json_encode($response);

