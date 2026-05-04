<?php

function parseAndValidateQueryParams(array &$errors): array {
    $filters = [];
    foreach ($_GET as $key => $value) {
        switch ($key) {
            case 'category':
                if (trim($value) === '') break;
                $filters['category'] = strtolower(trim($value));
                break;
            case 'min_price':
            case 'max_price':
                if ($value === '') break;
                if (is_numeric($value)) {
                    $filters[$key] = (float)$value;
                } else {
                    $ans = [
                        "error_type" => "Invalid parameter type",
                        "error_description" => $key . " must be a number, value is '" . $value . "'"
                    ];
                    $errors[] = $ans;
                }
                break;
            default:
                $ans = [
                    "error_type" => "Invalid parameter",
                    "error_description" => $key . " is not a valid parameter. Valid parameters are category, min_price, max_price"
                ];
                $errors[] = $ans;
        }
    }
    return $filters;
}

function readCoursesFile(array &$errors): array {
    if (file_exists("courses.json")) {
        $file = file_get_contents("courses.json");
    } else {
        $file = false;
    }
    if ($file === false) {
        $errors[] = [
            "error_type" => "Internal server error",
            "error_description" => "Failed to read courses.json"
        ];
        return [];
    }
    $coursesJson = json_decode($file, true);
    if (gettype($coursesJson) !== 'array') {
        $errors[] = [
            "error_type" => "Internal server error",
            "error_description" => "Failed to parse courses.json"
        ];
        return [];
    }
    return $coursesJson;
}

function getFilteredCourses(array $courses, array $filters): array {
    $filteredCourses = [];
    foreach ($courses as $course) {
        if (isset($filters['category']) && $course['category'] != $filters['category']) {
            continue;
        }
        if (isset($filters['min_price']) && $course['price'] < $filters['min_price']) {
            continue;
        }
        if (isset($filters['max_price']) && $course['price'] > $filters['max_price']) {
            continue;
        }
        $filteredCourses[] = $course;
    }
    return $filteredCourses;
}

$errors = [];
$filters = parseAndValidateQueryParams($errors);
if (count($errors) > 0) {
    http_response_code(400);
    echo json_encode($errors);
    exit;
}

$errors = [];
$courses = readCoursesFile($errors);
if (count($errors) > 0) {
    http_response_code(500);
    echo json_encode($errors);
    exit;
}
$filteredCourses = getFilteredCourses($courses, $filters);

echo json_encode($filteredCourses);

